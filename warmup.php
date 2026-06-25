<?php
/**
 * Cache Warmup Script - cPanel Terminal'den calistir:
 *
 *   cd ~/unikeyterra.net && php warmup.php
 *
 * Bu script:
 * 1. Eski cache'leri temizler
 * 2. Config/Route/View cache olusturur (Laravel hizlanir)
 * 3. Composer autoloader optimize eder
 * 4. Uygulama cache'lerini on-isitir (DB sorgulari yapilir, sonuc cache'e yazilir)
 *
 * HTTP'den CALISTIRILMAZ - sadece Terminal!
 */

// HTTP'den erisimi engelle
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Bu script sadece Terminal\'den calistirilabilir!');
}

echo "\n=== UNIKEYTERRA CACHE WARMUP ===\n\n";

$base = __DIR__;

// Artisan komutlarini calistir
function runArtisan(string $command, string $base): bool
{
    $fullCommand = "php {$base}/artisan {$command} 2>&1";
    echo "  > php artisan {$command} ... ";
    $output = [];
    $code = 0;
    exec($fullCommand, $output, $code);
    if ($code === 0) {
        echo "OK\n";
        return true;
    } else {
        echo "HATA\n";
        foreach ($output as $line) {
            echo "    {$line}\n";
        }
        return false;
    }
}

// ADIM 1: Eski cache'leri temizle
echo "[1/5] Eski cache'ler temizleniyor...\n";
runArtisan('config:clear', $base);
runArtisan('route:clear', $base);
runArtisan('view:clear', $base);
runArtisan('cache:clear', $base);

// Page cache temizle
$pageCacheDir = $base . '/storage/framework/page-cache';
if (is_dir($pageCacheDir)) {
    $files = glob($pageCacheDir . '/*.html');
    if ($files) {
        foreach ($files as $f) {
            @unlink($f);
        }
    }
    echo "  > Page cache temizlendi\n";
}
echo "\n";

// ADIM 2: Config/Route/View cache olustur
echo "[2/5] Laravel cache'leri olusturuluyor...\n";
runArtisan('config:cache', $base);
runArtisan('route:cache', $base);
runArtisan('view:cache', $base);
echo "\n";

// ADIM 3: Composer autoloader optimize
echo "[3/5] Composer autoloader optimize ediliyor...\n";
$composerOutput = [];
$composerCode = 0;
if (file_exists($base . '/composer.phar')) {
    exec("php {$base}/composer.phar dump-autoload --optimize --no-dev 2>&1", $composerOutput, $composerCode);
} else {
    exec("composer dump-autoload --optimize --no-dev -d {$base} 2>&1", $composerOutput, $composerCode);
}
if ($composerCode === 0) {
    echo "  > Composer autoload OPTIMIZE edildi\n";
} else {
    echo "  > Composer optimize basarisiz (sorun degil, devam ediyor)\n";
}
echo "\n";

// ADIM 4: Uygulama cache'lerini on-isit (Laravel'i yukle)
echo "[4/5] Uygulama cache'leri on-isitiliyor...\n";
echo "  > Laravel yukleniyor...\n";

// Laravel'i bootstrap et
require $base . '/vendor/autoload.php';
$app = require_once $base . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Minimal bir request olustur ve isle
// Bu, tum service provider'lari yukler ve Cache::remember() cagrilarini tetikler
try {
    $request = \Illuminate\Http\Request::create('/', 'GET');
    $request->headers->set('Accept-Language', 'tr');

    echo "  > Ana sayfa render ediliyor (cache olusturuluyor)...\n";
    $response = $kernel->handle($request);
    $statusCode = $response->getStatusCode();
    echo "  > Ana sayfa: HTTP {$statusCode}";

    if ($statusCode === 200) {
        echo " - OK\n";

        // Page cache dosyasi olusturuldu mu kontrol et
        if (is_dir($pageCacheDir)) {
            $cacheFiles = glob($pageCacheDir . '/*.html');
            echo "  > Page cache dosyasi: " . ($cacheFiles ? count($cacheFiles) : 0) . " adet\n";
        }
    } else {
        echo " - UYARI (sayfa yuklenemedi ama cache'ler olusturuldu)\n";
    }

    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    echo "  > Hata: " . $e->getMessage() . "\n";
    echo "  > (Cache'ler yine de olusturuldu, site calismaya devam eder)\n";
}
echo "\n";

// ADIM 5: Statik sayfalari on-isit
echo "[5/6] Statik sayfalar on-isitiliyor...\n";
$pagesToWarm = [
    '/urunler' => 'Urunler',
    '/hakkimizda' => 'Hakkimizda',
    '/katalog' => 'Katalog',
    '/bitki-besleme' => 'Bitki Besleme',
    '/bayiler' => 'Bayiler',
];

foreach ($pagesToWarm as $path => $name) {
    try {
        $request = \Illuminate\Http\Request::create($path, 'GET');
        $request->headers->set('Accept-Language', 'tr');
        $response = $kernel->handle($request);
        $code = $response->getStatusCode();
        echo "  > {$name} ({$path}): HTTP {$code}" . ($code === 200 ? ' OK' : '') . "\n";
        $kernel->terminate($request, $response);
    } catch (\Exception $e) {
        echo "  > {$name}: ATLANILDI - " . $e->getMessage() . "\n";
    }
}
echo "\n";

// ADIM 6: Tum urun sayfalarini on-isit
echo "[6/6] Urun sayfalari on-isitiliyor...\n";
try {
    $products = \App\Models\Product::where('status', 'active')
        ->select('slug', 'name')
        ->get();

    echo "  > {$products->count()} aktif urun bulundu\n";

    $ok = 0;
    $fail = 0;
    foreach ($products as $product) {
        try {
            $path = '/urun/' . $product->slug;
            $request = \Illuminate\Http\Request::create($path, 'GET');
            $request->headers->set('Accept-Language', 'tr');
            $response = $kernel->handle($request);
            $code = $response->getStatusCode();
            $kernel->terminate($request, $response);

            if ($code === 200) {
                $ok++;
            } else {
                $fail++;
                echo "  > UYARI: {$product->name} ({$path}): HTTP {$code}\n";
            }

            // Her 10 urun sonrasi ilerleme goster
            if (($ok + $fail) % 10 === 0) {
                echo "  > ... {$ok}/{$products->count()} urun cache'lendi\n";
            }
        } catch (\Exception $e) {
            $fail++;
        }
    }
    echo "  > Urun cache tamamlandi: {$ok} basarili, {$fail} hatali\n";

    // Kategori sayfalari da on-isit
    $categories = \App\Models\Category::where('status', 'active')
        ->select('slug')
        ->get();

    echo "  > {$categories->count()} kategori sayfalari cache'leniyor...\n";
    foreach ($categories as $cat) {
        try {
            $path = '/urunler?category=' . $cat->slug;
            $request = \Illuminate\Http\Request::create($path, 'GET');
            $request->headers->set('Accept-Language', 'tr');
            $response = $kernel->handle($request);
            $kernel->terminate($request, $response);
        } catch (\Exception $e) {
            // sessiz gec
        }
    }
    echo "  > Kategori sayfalari cache'lendi\n";
} catch (\Exception $e) {
    echo "  > Urun cache hatasi: " . $e->getMessage() . "\n";
}

// Cache istatistikleri
$pageCacheFiles = glob($pageCacheDir . '/*.html');
$totalCached = $pageCacheFiles ? count($pageCacheFiles) : 0;
$totalSize = 0;
if ($pageCacheFiles) {
    foreach ($pageCacheFiles as $f) {
        $totalSize += filesize($f);
    }
}
echo "\n=== TAMAMLANDI! ===\n";
echo "Toplam cache'lenen sayfa: {$totalCached}\n";
echo "Toplam cache boyutu: " . round($totalSize / 1024 / 1024, 2) . " MB\n";
echo "Simdi siteyi tarayicidan ac: https://unikeyterra.net\n";
echo "TUM sayfalar hizli acilacak (cache'den servis edilecek).\n\n";

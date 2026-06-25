<?php
/**
 * Ürün görseli teşhis scripti
 * Kullanım: https://domain.com/debug-images.php
 * İşin bitince SİL!
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->handle(
    \Illuminate\Http\Request::capture()
);

echo "<pre style='background:#1a1a2e;color:#16c60c;padding:20px;font-family:monospace;font-size:13px;'>";
echo "=== ÜRÜN GÖRSELİ TEŞHİS ===\n\n";

// 1. İlk 3 aktif ürünü çek
$products = \App\Models\Product::where('status', 'active')
    ->whereNotNull('images')
    ->limit(3)
    ->get(['id', 'name', 'slug', 'images']);

if ($products->isEmpty()) {
    $products = \App\Models\Product::whereNotNull('images')->limit(3)->get(['id', 'name', 'slug', 'images']);
}

if ($products->isEmpty()) {
    echo "❌ Hiç images alanı dolu ürün yok!\n";
    echo "\nTüm ürünlerin images alanı:\n";
    \App\Models\Product::limit(5)->get(['id','name','images'])->each(function($p) {
        echo "  #{$p->id} {$p->name} => " . var_export($p->getRawOriginal('images'), true) . "\n";
    });
    echo "</pre>";
    exit;
}

foreach ($products as $product) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📦 #{$product->id} — {$product->name}\n\n";

    // 2. DB'deki ham veri
    $raw = $product->getRawOriginal('images');
    echo "1) DB RAW (json string):\n   " . ($raw ?: '(NULL)') . "\n\n";

    // 3. Cast sonrası PHP tipi
    $parsed = $product->images;
    echo "2) PHP cast sonrası (gettype=" . gettype($parsed) . "):\n   ";
    print_r($parsed);
    echo "\n";

    // 4. Array anahtarları
    if (is_array($parsed) && !empty($parsed)) {
        echo "3) Array anahtarları: " . implode(', ', array_keys($parsed)) . "\n";
        echo "   \$images[0] = " . var_export($parsed[0] ?? '<<KEY 0 YOK>>', true) . "\n";
        echo "   array_values()[0] = " . var_export(array_values($parsed)[0] ?? null, true) . "\n\n";

        // 5. Her görsel için dosya kontrolü
        foreach (array_values($parsed) as $i => $path) {
            echo "4.$i) Görsel yolu: $path\n";

            $isRemote = str_starts_with($path, 'http');
            echo "     Uzak URL mi: " . ($isRemote ? 'EVET' : 'HAYIR') . "\n";

            if (!$isRemote) {
                // Disk üzerinde var mı?
                $diskExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                echo "     Storage::disk('public')->exists(): " . ($diskExists ? '✅ EVET' : '❌ HAYIR') . "\n";

                // Fiziksel dosya yolu
                $physicalPath = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
                echo "     Fiziksel yol: $physicalPath\n";
                echo "     file_exists(): " . (file_exists($physicalPath) ? '✅ EVET' : '❌ HAYIR') . "\n";

                // URL
                $url = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
                echo "     Storage URL: $url\n";
                echo "     asset() URL: " . asset('storage/' . $path) . "\n";
            }
            echo "\n";
        }
    } else {
        echo "3) images BOŞ veya array değil!\n\n";
    }
}

// 6. Storage disk bilgileri
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📁 STORAGE BİLGİLERİ\n\n";
$publicDiskRoot = config('filesystems.disks.public.root');
echo "Public disk root config: $publicDiskRoot\n";
$resolvedRoot = \Illuminate\Support\Facades\Storage::disk('public')->path('');
echo "Resolved root path: $resolvedRoot\n";
echo "Root dizin var mı: " . (is_dir($resolvedRoot) ? '✅ EVET' : '❌ HAYIR') . "\n";

$symlinkPath = public_path('storage');
echo "\npublic/storage yolu: $symlinkPath\n";
echo "Symlink mi: " . (is_link($symlinkPath) ? '✅ EVET → ' . readlink($symlinkPath) : '❌ HAYIR') . "\n";
echo "Dizin mi: " . (is_dir($symlinkPath) ? '✅ EVET' : '❌ HAYIR') . "\n";

// 7. products klasörü var mı
$productsDir = $resolvedRoot . '/products';
echo "\nproducts klasörü: $productsDir\n";
echo "Var mı: " . (is_dir($productsDir) ? '✅ EVET' : '❌ HAYIR') . "\n";

if (is_dir($productsDir)) {
    $files = glob($productsDir . '/{,*/,*/*/}*', GLOB_BRACE);
    echo "İçindeki dosya sayısı: " . count($files) . "\n";
    foreach (array_slice($files, 0, 10) as $f) {
        echo "  " . str_replace($resolvedRoot, '', $f) . " (" . round(filesize($f)/1024) . " KB)\n";
    }
}

echo "\n</pre>";

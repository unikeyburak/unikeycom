<?php
/**
 * Config/Route/View cache olusturur.
 * Kullandiktan sonra bu dosyayi SIL!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

// Output buffering kapat — her satir aninda gonderilsin (timeout onleme)
if (ob_get_level()) ob_end_clean();
header('Content-Type: text/html; charset=utf-8');
header('X-Accel-Buffering: no'); // Nginx buffering kapat
header('Cache-Control: no-cache'); // LiteSpeed buffering kapat

echo '<div style="font-family:monospace;max-width:700px;margin:40px auto;padding:20px">';
echo '<h1>CACHE OLUSTURULUYOR...</h1>';
echo '<ul style="line-height:2.5">';
echo str_pad('', 4096) . "\n"; // Buffer flush icin bos veri
flush();

$base = dirname(__DIR__);

// 0. Oncelikle eski cache dosyalarini sil (temiz baslangic)
echo '<li>Eski cache siliniyor... ';
flush();
@unlink($base . '/bootstrap/cache/config.php');
foreach (glob($base . '/bootstrap/cache/routes*.php') as $f) @unlink($f);
echo '<span style="color:green">OK</span></li>';
echo str_pad('', 256) . "\n";
flush();

// 1. Laravel bootstrap
echo '<li>Laravel yukleniyor... ';
echo str_pad('', 256) . "\n";
flush();

try {
    require $base . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo '<span style="color:green">OK</span></li>';
    echo str_pad('', 256) . "\n";
    flush();
} catch (\Throwable $e) {
    echo '<span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span></li>';
    echo '</ul></div>';
    exit;
}

$results = [];

// 2. Config cache
echo '<li>config:cache ... ';
echo str_pad('', 256) . "\n";
flush();
try {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    echo '<span style="color:green">OK</span></li>';
    $results[] = 'config:cache OK';
} catch (\Throwable $e) {
    echo '<span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span></li>';
    $results[] = 'config:cache HATA: ' . $e->getMessage();
}
echo str_pad('', 256) . "\n";
flush();

// 3. Route cache
echo '<li>route:cache ... ';
echo str_pad('', 256) . "\n";
flush();
try {
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    echo '<span style="color:green">OK</span></li>';
    $results[] = 'route:cache OK';
} catch (\Throwable $e) {
    echo '<span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span></li>';
    $results[] = 'route:cache HATA: ' . $e->getMessage();
}
echo str_pad('', 256) . "\n";
flush();

// 4. View cache
echo '<li>view:cache ... ';
echo str_pad('', 256) . "\n";
flush();
try {
    \Illuminate\Support\Facades\Artisan::call('view:cache');
    echo '<span style="color:green">OK</span></li>';
    $results[] = 'view:cache OK';
} catch (\Throwable $e) {
    echo '<span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span></li>';
    $results[] = 'view:cache HATA: ' . $e->getMessage();
}
echo str_pad('', 256) . "\n";
flush();

// 5. OPcache reset (yeni dosyalar icin)
if (function_exists('opcache_reset')) {
    @opcache_reset();
    echo '<li>OPcache resetlendi <span style="color:green">OK</span></li>';
} else {
    echo '<li>OPcache: mevcut degil</li>';
}
flush();

// Dogrulama
echo '<li>Dogrulama: ';
$configExists = file_exists($base . '/bootstrap/cache/config.php');
$routeExists = count(glob($base . '/bootstrap/cache/routes*.php')) > 0;
$viewCount = count(glob($base . '/storage/framework/views/*.php'));

if ($configExists && $routeExists) {
    echo '<span style="color:green">BASARILI</span></li>';
} else {
    echo '<span style="color:red">EKSIK</span></li>';
}

echo '</ul>';

echo '<h2 style="color:green">SONUC:</h2>';
echo '<ul>';
echo '<li>Config cache: ' . ($configExists ? '&#10003; VAR' : '&#10007; YOK') . '</li>';
echo '<li>Route cache: ' . ($routeExists ? '&#10003; VAR' : '&#10007; YOK') . '</li>';
echo '<li>View cache: ' . $viewCount . ' dosya</li>';
echo '</ul>';

if (in_array(true, array_map(fn($r) => str_contains($r, 'HATA'), $results))) {
    echo '<h2 style="color:red">HATALAR:</h2><ul>';
    foreach ($results as $r) {
        if (str_contains($r, 'HATA')) {
            echo '<li style="color:red">' . htmlspecialchars($r) . '</li>';
        }
    }
    echo '</ul>';
}

echo '<br><p style="color:red;font-weight:bold;font-size:18px">Bu dosyayi sunucudan SIL! (public/build-cache.php)</p>';
echo '<br><a href="/admin" style="font-size:20px;color:green">Admin paneli test et &rarr;</a>';
echo '<br><br><a href="/" style="font-size:16px;color:green">Ana sayfayi test et &rarr;</a>';
echo '</div>';

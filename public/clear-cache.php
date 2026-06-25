<?php
/**
 * Uygulama cache temizle + config/route/view cache otomatik yeniden olustur.
 * Kullandiktan sonra bu dosyayi SIL!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

if (ob_get_level()) ob_end_clean();
header('Content-Type: text/html; charset=utf-8');
header('X-Accel-Buffering: no');
header('Cache-Control: no-cache');

$results = [];
$base = dirname(__DIR__);

if (!is_dir($base . '/bootstrap') || !is_dir($base . '/storage')) {
    echo '<h1 style="color:red">HATA: Laravel klasor yapisi bulunamadi!</h1>';
    exit;
}

echo '<div style="font-family:monospace;max-width:700px;margin:40px auto;padding:20px">';
echo '<h1>CACHE TEMIZLENIYOR...</h1>';
echo '<ul style="line-height:2.2">';
echo str_pad('', 4096) . "\n";
flush();

// 1. File cache sil (Cache::remember verileri)
$cachePath = $base . '/storage/framework/cache/data';
if (is_dir($cachePath)) {
    $count = 0;
    try {
        $dirs = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($cachePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($dirs as $item) {
            if ($item->isFile()) {
                @unlink($item->getRealPath());
                $count++;
            } elseif ($item->isDir()) {
                @rmdir($item->getRealPath());
            }
        }
    } catch (Exception $e) {
        // sessiz hata
    }
    echo "<li>File cache: <b>$count dosya</b> silindi <span style='color:green'>OK</span></li>";
} else {
    echo '<li>File cache: klasor yok (temiz)</li>';
}
echo str_pad('', 256) . "\n";
flush();

// 2. PAGE CACHE sil (full-page HTML cache)
$pageCachePath = $base . '/storage/framework/page-cache';
if (is_dir($pageCachePath)) {
    $count = 0;
    $htmlFiles = glob($pageCachePath . '/*.html');
    if ($htmlFiles) {
        foreach ($htmlFiles as $f) {
            @unlink($f);
            $count++;
        }
    }
    echo "<li>Page cache: <b>$count HTML</b> silindi <span style='color:green'>OK</span></li>";
} else {
    echo '<li>Page cache: klasor yok (temiz)</li>';
}
echo str_pad('', 256) . "\n";
flush();

// 3. Config/Route/View cache YENIDEN OLUSTUR (Laravel ile)
echo '<li>Config/Route/View cache yeniden olusturuluyor... ';
echo str_pad('', 256) . "\n";
flush();

$rebuildOk = true;
try {
    require $base . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Config cache
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    echo '<br>&nbsp;&nbsp;config:cache <span style="color:green">OK</span>';
    echo str_pad('', 256) . "\n";
    flush();

    // Route cache
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    echo '<br>&nbsp;&nbsp;route:cache <span style="color:green">OK</span>';
    echo str_pad('', 256) . "\n";
    flush();

    // View cache
    \Illuminate\Support\Facades\Artisan::call('view:cache');
    echo '<br>&nbsp;&nbsp;view:cache <span style="color:green">OK</span>';

    echo '</li>';
} catch (\Throwable $e) {
    echo '<br><span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span></li>';
    $rebuildOk = false;
}
echo str_pad('', 256) . "\n";
flush();

// 4. OPcache reset
if (function_exists('opcache_reset')) {
    @opcache_reset();
    echo '<li>OPcache resetlendi <span style="color:green">OK</span></li>';
}

echo '</ul>';

// Dogrulama
$configExists = file_exists($base . '/bootstrap/cache/config.php');
$routeExists = count(glob($base . '/bootstrap/cache/routes*.php')) > 0;
$viewCount = count(glob($base . '/storage/framework/views/*.php'));

echo '<h2 style="color:' . ($configExists && $routeExists ? 'green' : 'red') . '">SONUC:</h2>';
echo '<ul>';
echo '<li>Config cache: ' . ($configExists ? '&#10003; VAR' : '&#10007; YOK') . '</li>';
echo '<li>Route cache: ' . ($routeExists ? '&#10003; VAR' : '&#10007; YOK') . '</li>';
echo '<li>View cache: ' . $viewCount . ' dosya</li>';
echo '</ul>';

if ($configExists && $routeExists) {
    echo '<p style="color:green;font-size:18px"><b>&#10003; TUM CACHE TEMIZLENDI VE YENIDEN OLUSTURULDU!</b></p>';
}

echo '<br><p style="color:red;font-weight:bold;font-size:18px">Bu dosyayi sunucudan SIL!</p>';
echo '<br><a href="/admin" style="font-size:20px;color:green">Admin paneli test et &rarr;</a>';
echo '<br><br><a href="/" style="font-size:16px;color:green">Ana sayfayi test et &rarr;</a>';
echo '</div>';

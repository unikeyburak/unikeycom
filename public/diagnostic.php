<?php
/**
 * Laravel YUKLEMEDEN sunucu durumunu kontrol eder.
 * Kullandiktan sonra SIL!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

$start = microtime(true);
$base = dirname(__DIR__);

echo '<div style="font-family:monospace;max-width:800px;margin:40px auto;padding:20px">';
echo '<h1>SUNUCU TESHIS</h1>';
echo '<ul style="line-height:2.2">';

// 1. PHP surumu
echo '<li>PHP: <b>' . PHP_VERSION . '</b></li>';

// 2. Timeout limitleri
echo '<li>max_execution_time: <b>' . ini_get('max_execution_time') . ' saniye</b></li>';
echo '<li>memory_limit: <b>' . ini_get('memory_limit') . '</b></li>';

// 3. OPcache durumu
$opcache = function_exists('opcache_get_status') ? @opcache_get_status(false) : false;
if ($opcache && !empty($opcache['opcache_enabled'])) {
    echo '<li style="color:green">OPcache: <b>ACIK</b> (cached: ' . ($opcache['opcache_statistics']['num_cached_scripts'] ?? '?') . ' dosya)</li>';
} else {
    echo '<li style="color:red;font-weight:bold">OPcache: KAPALI! — Bu Filament icin OLUMCUL yavaslik sebebi!</li>';
}

// 4. Cache dosyalari
$configCache = file_exists($base . '/bootstrap/cache/config.php');
$routeCache = count(glob($base . '/bootstrap/cache/routes*.php')) > 0;
$viewCount = count(glob($base . '/storage/framework/views/*.php'));
echo '<li>Config cache: ' . ($configCache ? '<span style="color:green">VAR</span>' : '<span style="color:red">YOK</span>') . '</li>';
echo '<li>Route cache: ' . ($routeCache ? '<span style="color:green">VAR</span>' : '<span style="color:red">YOK</span>') . '</li>';
echo '<li>View cache: ' . $viewCount . ' dosya</li>';

// 5. Vendor var mi
$vendorExists = file_exists($base . '/vendor/autoload.php');
echo '<li>vendor/autoload.php: ' . ($vendorExists ? '<span style="color:green">VAR</span>' : '<span style="color:red">YOK</span>') . '</li>';

// 6. Vendor dosya sayisi (yavaslik gostergesi)
echo '<li>vendor/ PHP dosya sayisi: ';
flush();
$vendorFileCount = 0;
if (is_dir($base . '/vendor')) {
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base . '/vendor', RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($it as $file) {
            if ($file->getExtension() === 'php') $vendorFileCount++;
            if ($vendorFileCount > 8000) { $vendorFileCount = '8000+'; break; }
        }
    } catch (Exception $e) {
        $vendorFileCount = 'sayilamadi';
    }
    echo '<b>~' . $vendorFileCount . '</b>';
    if (is_int($vendorFileCount) && $vendorFileCount > 3000) {
        echo ' <span style="color:red">(Cok fazla — OPcache sart!)</span>';
    }
}
echo '</li>';

// 7. DB baglantisi hiz testi
echo '<li>DB baglanti testi: ';
flush();
$envFile = $base . '/.env';
$dbHost = $dbName = $dbUser = $dbPass = $dbPort = null;
if (file_exists($envFile)) {
    $envLines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, 'DB_HOST=') === 0) $dbHost = trim(substr($line, 8));
        if (strpos($line, 'DB_DATABASE=') === 0) $dbName = trim(substr($line, 12));
        if (strpos($line, 'DB_USERNAME=') === 0) $dbUser = trim(substr($line, 12));
        if (strpos($line, 'DB_PASSWORD=') === 0) $dbPass = trim(substr($line, 12));
        if (strpos($line, 'DB_PORT=') === 0) $dbPort = trim(substr($line, 8));
    }
}

if ($dbHost && $dbName) {
    $dbStart = microtime(true);
    try {
        $dsn = "mysql:host={$dbHost};port=" . ($dbPort ?: 3306) . ";dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_TIMEOUT => 5]);
        $dbMs = round((microtime(true) - $dbStart) * 1000);

        // Basit sorgu
        $qStart = microtime(true);
        $pdo->query('SELECT 1');
        $qMs = round((microtime(true) - $qStart) * 1000);

        $color = $dbMs < 100 ? 'green' : ($dbMs < 500 ? 'orange' : 'red');
        echo "<span style='color:{$color}'>Baglanti: {$dbMs}ms, Sorgu: {$qMs}ms</span>";

        if ($dbMs > 500) {
            echo ' <b style="color:red">— DB BAGLANTISI COK YAVAS!</b>';
        }
    } catch (Exception $e) {
        echo '<span style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</span>';
    }
} else {
    echo '<span style="color:orange">ENV okunamadi</span>';
}
echo '</li>';

// 8. Autoload hiz testi
echo '<li>Autoload testi: ';
flush();
if ($vendorExists) {
    $alStart = microtime(true);
    require $base . '/vendor/autoload.php';
    $alMs = round((microtime(true) - $alStart) * 1000);
    $color = $alMs < 200 ? 'green' : ($alMs < 1000 ? 'orange' : 'red');
    echo "<span style='color:{$color}'>{$alMs}ms</span>";
    if ($alMs > 1000) {
        echo ' <b style="color:red">— COK YAVAS! OPcache SART</b>';
    }
} else {
    echo '<span style="color:red">vendor yok</span>';
}
echo '</li>';

// 9. .env kontrol (production mu?)
$appDebug = $appEnv = null;
if (file_exists($envFile)) {
    $envLines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, 'APP_DEBUG=') === 0) $appDebug = trim(substr($line, 10));
        if (strpos($line, 'APP_ENV=') === 0) $appEnv = trim(substr($line, 8));
    }
}
echo '<li>APP_ENV: <b>' . htmlspecialchars($appEnv ?: 'bilinmiyor') . '</b>';
if ($appEnv === 'local') echo ' <span style="color:red">— PRODUCTION OLMALI!</span>';
echo '</li>';
echo '<li>APP_DEBUG: <b>' . htmlspecialchars($appDebug ?: 'bilinmiyor') . '</b>';
if ($appDebug === 'true') echo ' <span style="color:red">— false OLMALI! Debug mod cok yavaslatir</span>';
echo '</li>';

// Toplam sure
$totalMs = round((microtime(true) - $start) * 1000);
echo '</ul>';
echo '<hr>';
echo '<p>Toplam sure: <b>' . $totalMs . 'ms</b></p>';

// Onerileri goster
echo '<h2>ONERILER:</h2><ul style="line-height:2">';

if (!$opcache || empty($opcache['opcache_enabled'])) {
    echo '<li style="color:red;font-weight:bold">1. OPcache\'i AC! — cPanel > PHP Secici > Uzantilar > opcache tikla. Bu tek basina 5-10x hizlandirir.</li>';
}

if ($appDebug === 'true') {
    echo '<li style="color:red">2. .env dosyasinda APP_DEBUG=false yap</li>';
}

if ($appEnv === 'local') {
    echo '<li style="color:red">3. .env dosyasinda APP_ENV=production yap</li>';
}

if (!$configCache) {
    echo '<li style="color:orange">4. Config cache yok — build-cache.php calistir</li>';
}

echo '</ul>';
echo '<br><p style="color:red;font-weight:bold">Bu dosyayi sunucudan SIL!</p>';
echo '</div>';

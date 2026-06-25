<?php
// Güvenlik anahtarı
define('SECRET_KEY', 'ukt-migrate-2024');
$key = $_GET['key'] ?? '';
if (!hash_equals(SECRET_KEY, $key)) {
    http_response_code(403); exit('403 Forbidden');
}

header('Content-Type: text/html; charset=utf-8');
$logFile = dirname(__DIR__) . '/storage/logs/laravel.log';

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Laravel Log</title>
<style>
body{font-family:monospace;background:#0d1117;color:#c9d1d9;padding:20px;margin:0}
h1{color:#58a6ff}
pre{background:#161b22;border:1px solid #30363d;padding:15px;border-radius:6px;
    white-space:pre-wrap;word-break:break-all;font-size:12px;max-height:80vh;overflow-y:auto}
.err{color:#f85149}.warn{color:#d29922}.info{color:#3fb950}
.btn{display:inline-block;padding:6px 14px;margin:4px;border-radius:4px;
     text-decoration:none;background:#1f6feb;color:#fff;font-size:13px}
</style></head><body>';

echo '<h1>Laravel Error Log</h1>';
echo '<a class="btn" href="?key='.$key.'&lines=50">Son 50 satır</a>';
echo '<a class="btn" href="?key='.$key.'&lines=100">Son 100 satır</a>';
echo '<a class="btn" href="?key='.$key.'&clear=1" onclick="return confirm(\'Logu temizle?\')">Logu Temizle</a>';

// Log temizle
if (isset($_GET['clear'])) {
    file_put_contents($logFile, '');
    echo '<p style="color:#3fb950">Log temizlendi.</p>';
}

$lines = (int)($_GET['lines'] ?? 50);

if (!file_exists($logFile)) {
    echo '<p style="color:#f85149">Log dosyası bulunamadı: ' . htmlspecialchars($logFile) . '</p>';
} else {
    $size = filesize($logFile);
    echo '<p style="color:#8b949e">Dosya boyutu: ' . number_format($size/1024, 1) . ' KB | Son ' . $lines . ' satır</p>';

    // Son N satırı oku
    $content = '';
    $fp = fopen($logFile, 'r');
    $allLines = [];
    while (!feof($fp)) {
        $allLines[] = fgets($fp);
    }
    fclose($fp);

    $lastLines = array_slice($allLines, -$lines);
    $content = implode('', $lastLines);

    // Renklendir
    $content = htmlspecialchars($content);
    $content = preg_replace('/\[ERROR\]|error|SQLSTATE|Exception|Error/i', '<span class="err">$0</span>', $content);
    $content = preg_replace('/\[WARNING\]|warning/i', '<span class="warn">$0</span>', $content);

    echo '<pre>' . $content . '</pre>';
}

echo '</body></html>';

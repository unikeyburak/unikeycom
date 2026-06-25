<?php
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(600);

// 1) docroot public klasörlerinin izinlerini düzelt (dirs 755, files 644) — filament:assets yazabilsin
function fixp($d) {
    if (!is_dir($d)) return;
    @chmod($d, 0755);
    try {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($it as $p) { @chmod($p, $p->isDir() ? 0755 : 0644); }
    } catch (\Throwable $e) {}
}
@chmod(__DIR__, 0755);
foreach (['css', 'js', 'build', 'storage'] as $dd) fixp(__DIR__ . '/' . $dd);
echo "docroot izinleri düzeltildi\n";

// 2) ürün görseli gerçekte var mı, nerede?
function findf($dir, $name) {
    if (!is_dir($dir)) return null;
    foreach (scandir($dir) as $e) {
        if ($e === '.' || $e === '..') continue;
        $p = $dir . '/' . $e;
        if (is_dir($p)) { $r = findf($p, $name); if ($r) return $r; }
        elseif ($e === $name) return $p;
    }
    return null;
}
$nm = '20-10-20-bf879007.webp';
echo "webp (laravel): " . (findf(__DIR__ . '/laravel/storage/app/public', $nm) ?: 'BULUNAMADI') . "\n";
echo "webp (docroot/storage): " . (findf(__DIR__ . '/storage', $nm) ?: 'BULUNAMADI') . "\n";

// 3) filament:assets tekrar
try {
    require __DIR__ . '/laravel/vendor/autoload.php';
    $app = require __DIR__ . '/laravel/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $k = $app->make(Illuminate\Contracts\Console\Kernel::class);
    try { $k->call('filament:assets'); echo "[filament:assets]\n" . trim($k->output()) . "\n"; }
    catch (\Throwable $e) { echo "filament HATA: " . $e->getMessage() . " @ " . $e->getFile() . ":" . $e->getLine() . "\n"; }
} catch (\Throwable $e) { echo "boot HATA: " . $e->getMessage() . "\n"; }

// 4) docroot/css/filament gerçekte ne içeriyor?
echo "=== docroot/css/filament ağacı ===\n";
function tree($d, $pre = '') {
    if (!is_dir($d)) { echo $pre . "(yok)\n"; return; }
    foreach (array_diff(scandir($d), ['.', '..']) as $e) {
        $p = $d . '/' . $e;
        echo $pre . $e . (is_dir($p) ? '/' : '') . "\n";
        if (is_dir($p)) tree($p, $pre . '  ');
    }
}
tree(__DIR__ . '/css/filament');

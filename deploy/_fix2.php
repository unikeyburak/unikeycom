<?php
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(600);

// ── ADIM 1: storage'ı gerçek klasöre kopyala (symlink kapalı; görseller görünsün) ──
function rcopy($src, $dst, &$n) {
    if (!is_dir($src)) return;
    if (!is_dir($dst)) @mkdir($dst, 0755, true);
    foreach (scandir($src) as $e) {
        if ($e === '.' || $e === '..') continue;
        $s = $src . '/' . $e; $d = $dst . '/' . $e;
        if (is_dir($s)) rcopy($s, $d, $n);
        elseif (!file_exists($d)) { @copy($s, $d) && $n++; }
    }
}
$n = 0;
rcopy(__DIR__ . '/laravel/storage/app/public', __DIR__ . '/storage', $n);
echo "storage kopyalanan dosya = $n\n\n";

// ── ADIM 2: artisan komutları (gerçek hatayı yakala) ──
try {
    require __DIR__ . '/laravel/vendor/autoload.php';
    $app = require __DIR__ . '/laravel/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    foreach (['optimize:clear', 'filament:assets'] as $cmd) {
        try {
            $code = $kernel->call($cmd);
            echo "[$cmd] exit=$code\n" . trim($kernel->output()) . "\n\n";
        } catch (\Throwable $e) {
            echo "[$cmd] HATA: " . get_class($e) . ": " . $e->getMessage() . "\n  @ " . $e->getFile() . ":" . $e->getLine() . "\n\n";
        }
    }
} catch (\Throwable $e) {
    echo "BOOT HATA: " . $e->getMessage() . "\n  @ " . $e->getFile() . ":" . $e->getLine() . "\n";
}

foreach (['css/filament', 'js/filament', 'storage/products', 'storage/settings'] as $p) {
    echo "var? $p : " . (is_dir(__DIR__ . '/' . $p) ? 'EVET' : 'yok') . "\n";
}

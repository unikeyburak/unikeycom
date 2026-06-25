<?php
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(300);
$base = __DIR__ . '/laravel';
@chmod($base, 0755);
$d = 0; $f = 0; $err = 0;
try {
    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($rii as $path => $info) {
        if ($info->isDir()) { (@chmod($path, 0755)) ? $d++ : $err++; }
        else                { (@chmod($path, 0644)) ? $f++ : $err++; }
    }
} catch (\Throwable $e) {
    echo "ITER-ERR: " . $e->getMessage() . "\n";
}
// storage + bootstrap/cache yazılabilir olmalı (775/664)
foreach (['storage', 'bootstrap/cache'] as $w) {
    $wp = $base . '/' . $w;
    if (is_dir($wp)) {
        @chmod($wp, 0775);
        try {
            $r2 = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($wp, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($r2 as $p2 => $i2) { @chmod($p2, $i2->isDir() ? 0775 : 0664); }
        } catch (\Throwable $e) {}
    }
}
echo "OK dirs=$d files=$f err=$err\n";

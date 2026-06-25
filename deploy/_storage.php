<?php
header('Content-Type: text/plain; charset=utf-8');
$docStorage = __DIR__ . '/storage';                 // docroot/storage (gerçek dizin)
$pub        = __DIR__ . '/laravel/storage/app/public'; // asıl medya home

function mergeMove($src, $dst, &$moved, &$dups) {
    if (!is_dir($dst)) @mkdir($dst, 0755, true);
    foreach (scandir($src) as $e) {
        if ($e === '.' || $e === '..') continue;
        $s = $src . '/' . $e; $d = $dst . '/' . $e;
        if (is_dir($s)) { mergeMove($s, $d, $moved, $dups); @rmdir($s); }
        else { if (!file_exists($d)) { @rename($s, $d) && $moved++; } else { @unlink($s); $dups++; } }
    }
}

$moved = 0; $dups = 0;
if (is_dir($docStorage) && !is_link($docStorage)) {
    mergeMove($docStorage, $pub, $moved, $dups);
    @rmdir($docStorage);
    echo "merge: taşınan=$moved, yinelenen-silinen=$dups\n";
} elseif (is_link($docStorage)) {
    echo "zaten symlink\n";
}

if (!file_exists($docStorage)) {
    echo symlink($pub, $docStorage) ? "symlink OLUŞTU -> $pub\n" : "symlink BAŞARISIZ\n";
} else {
    echo "docroot/storage hâlâ duruyor (boşaltılamadı), is_link=" . (is_link($docStorage) ? '1' : '0') . "\n";
}
echo "kontrol: products=" . (file_exists($docStorage . '/products') ? 'var' : 'YOK')
   . " settings=" . (file_exists($docStorage . '/settings') ? 'var' : 'YOK') . "\n";

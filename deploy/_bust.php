<?php
header('Content-Type: text/plain; charset=utf-8');
$views = glob(__DIR__ . '/laravel/storage/framework/views/*.php') ?: [];
$c = 0; foreach ($views as $f) { @unlink($f) && $c++; }
$pc = glob(__DIR__ . '/laravel/storage/framework/page-cache/*.html') ?: [];
$p = 0; foreach ($pc as $f) { @unlink($f) && $p++; }
$cfg = __DIR__ . '/laravel/bootstrap/cache/config.php';
if (is_file($cfg)) { @unlink($cfg); echo "config.php silindi\n"; }
echo "compiled-views silindi=$c, page-cache silindi=$p\n";
if (function_exists('opcache_reset')) { echo "opcache_reset=" . (opcache_reset() ? 'OK' : 'FAIL') . "\n"; }
else { echo "opcache fonksiyonu yok\n"; }

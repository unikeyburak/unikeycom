<?php
/*
| GÜVENLİ cache temizleme — bu kuruluma özel.
| config:cache / route:cache ÇALIŞTIRMAZ (onlar bu yapıda storage/asset yollarını bozar).
| Tarayıcıdan aç: https://unikeyterra.net/cache-temizle.php
| Güvenlik: dosya adını tahmin edilmesi zor bir şeye çevir veya işin bitince sil.
*/
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(120);
$base = __DIR__ . '/laravel';

$n = 0;
foreach (glob($base . '/storage/framework/views/*.php') ?: [] as $f) { @unlink($f) && $n++; }
$p = 0;
foreach (glob($base . '/storage/framework/page-cache/*.html') ?: [] as $f) { @unlink($f) && $p++; }
// Bu kurulumda config/route cache YASAK — varsa temizle
foreach (['config.php', 'routes-v7.php', 'routes.php', 'events.php'] as $bc) {
    if (is_file($base . '/bootstrap/cache/' . $bc)) { @unlink($base . '/bootstrap/cache/' . $bc); echo "silindi: bootstrap/cache/$bc\n"; }
}
try {
    require $base . '/vendor/autoload.php';
    $app = require $base . '/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $k = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $k->call('cache:clear');
    echo "cache:clear -> " . trim($k->output()) . "\n";
} catch (\Throwable $e) { echo "uyari (cache:clear): " . $e->getMessage() . "\n"; }
if (function_exists('opcache_reset')) { opcache_reset(); echo "opcache reset\n"; }
echo "TAMAM: $n compiled-view + $p page-cache temizlendi.\n";

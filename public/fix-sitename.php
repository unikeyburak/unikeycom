<?php
/**
 * settings tablosundaki site_name ve footer_copyright değerlerini günceller.
 * Kullandıktan sonra sunucudan SİL!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(60);

$base = dirname(__DIR__);

echo '<div style="font-family:monospace;max-width:600px;margin:40px auto;padding:20px">';
echo '<h2>Site Adı Düzeltiliyor...</h2><ul>';

try {
    require $base . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $db = app('db');

    // site_name güncelle
    $affected = $db->table('settings')
        ->where('key', 'site_name')
        ->where('value', 'Unikeyterra')
        ->update(['value' => 'Keysol Agro']);
    echo '<li>site_name: ' . ($affected ? '<b style="color:green">Güncellendi → Keysol Agro</b>' : '<span style="color:orange">Zaten doğru veya farklı bir değer var</span>') . '</li>';

    // Mevcut site_name göster
    $current = $db->table('settings')->where('key', 'site_name')->value('value');
    echo '<li>Mevcut site_name: <b>' . htmlspecialchars((string)$current) . '</b></li>';

    // footer_copyright güncelle
    $copy = $db->table('settings')
        ->where('key', 'footer_copyright')
        ->where('value', 'like', '%Unikeyterra%')
        ->update(['value' => '© ' . date('Y') . ' Keysol Agro. Tüm hakları saklıdır.']);
    echo '<li>footer_copyright: ' . ($copy ? '<b style="color:green">Güncellendi</b>' : 'Değişiklik gerekmedi') . '</li>';

    // Cache temizle
    \Illuminate\Support\Facades\Cache::forget('all_settings_parsed');
    \Illuminate\Support\Facades\Cache::forget('sitemap_xml');
    echo '<li style="color:green">Cache temizlendi (settings + sitemap)</li>';

} catch (\Throwable $e) {
    echo '<li style="color:red">HATA: ' . htmlspecialchars($e->getMessage()) . '</li>';
}

echo '</ul>';
echo '<p style="color:red;font-weight:bold">Bu dosyayı sunucudan SİL: public/fix-sitename.php</p>';
echo '<a href="/" style="font-size:18px">Ana sayfayı test et →</a>';
echo '</div>';

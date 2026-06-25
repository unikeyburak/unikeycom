<?php
/**
 * WordPress REST API Test Script
 * Sitenizin REST API endpoint'lerini kontrol eder
 */

// WordPress site URL'nizi buraya girin
$site_url = "https://siteadi.com"; // <-- BU KISMI DEĞİŞTİRİN

echo "WordPress REST API Kontrol\n";
echo "===========================\n\n";

// 1. Temel REST API kontrolü
echo "1. REST API Ana Endpoint:\n";
echo "   {$site_url}/wp-json/\n\n";

// 2. Varsayılan WordPress endpoints
echo "2. Standart WordPress Endpoints:\n";
echo "   - Yazılar: {$site_url}/wp-json/wp/v2/posts\n";
echo "   - Sayfalar: {$site_url}/wp-json/wp/v2/pages\n";
echo "   - Kategoriler: {$site_url}/wp-json/wp/v2/categories\n";
echo "   - Kullanıcılar: {$site_url}/wp-json/wp/v2/users\n";
echo "   - Medya: {$site_url}/wp-json/wp/v2/media\n\n";

// 3. WooCommerce endpoints (eğer varsa)
echo "3. WooCommerce Endpoints (eğer yüklüyse):\n";
echo "   - Ürünler: {$site_url}/wp-json/wc/v3/products\n";
echo "   - Kategoriler: {$site_url}/wp-json/wc/v3/products/categories\n";
echo "   - Siparişler: {$site_url}/wp-json/wc/v3/orders\n";
echo "   - Müşteriler: {$site_url}/wp-json/wc/v3/customers\n\n";

// 4. Custom Post Types (tahmin)
echo "4. Olası Custom Post Type Endpoints:\n";
echo "   - {$site_url}/wp-json/wp/v2/product\n";
echo "   - {$site_url}/wp-json/wp/v2/urun\n";
echo "   - {$site_url}/wp-json/wp/v2/urunler\n\n";

// 5. API Erişilebilirlik Testi
echo "5. API Erişilebilirlik Testi:\n";
echo "==========================\n\n";

function checkEndpoint($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode;
}

// Test edilecek endpoint'ler
$endpoints = [
    'REST API Ana' => '/wp-json/',
    'WP Posts' => '/wp-json/wp/v2/posts',
    'WP Categories' => '/wp-json/wp/v2/categories',
    'WooCommerce Products' => '/wp-json/wc/v3/products',
    'Custom Product' => '/wp-json/wp/v2/product'
];

foreach ($endpoints as $name => $endpoint) {
    $url = $site_url . $endpoint;
    $status = checkEndpoint($url);
    
    echo "✓ {$name}: ";
    if ($status == 200) {
        echo "BAŞARILI (200 OK)\n";
    } elseif ($status == 401) {
        echo "BAŞARILI - Kimlik doğrulama gerekli (401)\n";
    } elseif ($status == 404) {
        echo "BULUNAMADI (404) - Endpoint mevcut değil\n";
    } else {
        echo "HTTP {$status}\n";
    }
}

echo "\n6. Browser'dan Kontrol:\n";
echo "========================\n";
echo "Tarayıcınızda şu adresi açın:\n";
echo "{$site_url}/wp-json/\n\n";
echo "Eğer JSON formatında veri görüyorsanız REST API aktif.\n";

echo "\n7. Kimlik Doğrulama:\n";
echo "====================\n";
echo "WordPress REST API'ye erişim için:\n";
echo "- Application Passwords kullanın (WordPress 5.6+)\n";
echo "- Kullanıcılar > Profil > Application Passwords\n";
echo "- Veya JWT Authentication eklentisi kullanın\n";

echo "\n8. Eklenti Önerileri:\n";
echo "====================\n";
echo "- WP REST API Controller - Endpoint'leri yönetir\n";
echo "- Custom Post Type UI - CPT'ler için REST desteği\n";
echo "- ACF to REST API - ACF alanlarını REST'e ekler\n";
?>
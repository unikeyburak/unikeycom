<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

echo "<pre style='background:#1a1a2e; color:#16c60c; padding:20px; font-family:monospace;'>";
echo "=== DİL TESPİT TESTİ ===\n\n";

// Session temizle
if (isset($_GET['clear'])) {
    Session::forget('locale');
    Session::forget('direction');
    echo "[OK] Session temizlendi!\n\n";
}

// IP bilgisi
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'bilinmiyor';
echo "IP Adresi: {$ip}\n";

// IP'den ülke tespiti
try {
    $response = Http::timeout(5)->get('http://ip-api.com/json/' . $ip);
    if ($response->successful()) {
        $data = $response->json();
        echo "Ülke: " . ($data['country'] ?? 'bilinmiyor') . " (" . ($data['countryCode'] ?? '?') . ")\n";
        echo "Şehir: " . ($data['city'] ?? 'bilinmiyor') . "\n";
    }
} catch (Exception $e) {
    echo "IP tespiti başarısız\n";
}

echo "\n";

// Tarayıcı dili
$acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'yok';
echo "Accept-Language Header:\n{$acceptLang}\n\n";

// Session durumu
echo "Session Locale: " . (Session::get('locale') ?? 'yok') . "\n";
echo "Session Direction: " . (Session::get('direction') ?? 'yok') . "\n";

// Aktif diller
echo "\n--- Aktif Diller (Veritabanı) ---\n";
$languages = \App\Models\Language::where('is_active', true)->get();
foreach ($languages as $lang) {
    $default = $lang->is_default ? ' [VARSAYILAN]' : '';
    echo "{$lang->flag} {$lang->code} - {$lang->name}{$default}\n";
}

if ($languages->isEmpty()) {
    echo "[UYARI] Hiç aktif dil yok!\n";
}

echo "\n=== TEST LINKLERI ===\n";
echo "Session temizle: ?clear=1\n";
echo "Ana sayfa: https://unikeyterra.net/\n";

echo "</pre>";

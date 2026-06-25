<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Language;

echo "<pre style='background:#1a1a2e; color:#16c60c; padding:20px; font-family:monospace;'>";
echo "=== DİL EKLEME ===\n\n";

$languages = [
    [
        'code' => 'tr',
        'name' => 'Turkish',
        'native_name' => 'Türkçe',
        'flag' => '🇹🇷',
        'direction' => 'ltr',
        'is_active' => true,
        'is_default' => true,
        'sort_order' => 1,
    ],
    [
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
        'flag' => '🇬🇧',
        'direction' => 'ltr',
        'is_active' => true,
        'is_default' => false,
        'sort_order' => 2,
    ],
    [
        'code' => 'ar',
        'name' => 'Arabic',
        'native_name' => 'العربية',
        'flag' => '🇸🇦',
        'direction' => 'rtl',
        'is_active' => true,
        'is_default' => false,
        'sort_order' => 3,
    ],
    [
        'code' => 'es',
        'name' => 'Spanish',
        'native_name' => 'Español',
        'flag' => '🇪🇸',
        'direction' => 'ltr',
        'is_active' => true,
        'is_default' => false,
        'sort_order' => 4,
    ],
    [
        'code' => 'fr',
        'name' => 'French',
        'native_name' => 'Français',
        'flag' => '🇫🇷',
        'direction' => 'ltr',
        'is_active' => true,
        'is_default' => false,
        'sort_order' => 5,
    ],
];

$added = 0;
$skipped = 0;

foreach ($languages as $lang) {
    $existing = Language::where('code', $lang['code'])->first();

    if ($existing) {
        echo "[MEVCUT] {$lang['flag']} {$lang['code']} - {$lang['native_name']}\n";
        $skipped++;
    } else {
        Language::create($lang);
        echo "[EKLENDİ] {$lang['flag']} {$lang['code']} - {$lang['native_name']}\n";
        $added++;
    }
}

echo "\n=== SONUÇ ===\n";
echo "Eklenen: {$added}\n";
echo "Atlanan: {$skipped}\n";
echo "Toplam: " . Language::count() . " dil\n";

echo "\nAdmin paneli kontrol et: /admin/languages\n";
echo "Bu dosyayı silebilirsin.\n";
echo "</pre>";

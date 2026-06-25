<?php
/**
 * Storage symlink düzeltme scripti.
 * 1. Bu dosyayı public/ klasörüne FTP ile yükle
 * 2. Tarayıcıdan aç: https://keysolagro.com/fix-storage.php
 * 3. Çalıştıktan sonra FTP ile SİL
 */

// Güvenlik: sadece bu IP'den çalışsın (kendi IP'ni yaz, boş bırakırsan herkese açık)
$allowedIp = ''; // Örnek: '85.123.45.67'

if ($allowedIp && $_SERVER['REMOTE_ADDR'] !== $allowedIp) {
    die('Yetkisiz erişim.');
}

$publicStorage = __DIR__ . '/storage';
$target        = __DIR__ . '/../storage/app/public';

echo '<pre>';
echo "Target path : $target\n";
echo "Symlink path: $publicStorage\n";
echo "Target exists: " . (is_dir($target) ? 'EVET' : 'HAYIR') . "\n\n";

// Mevcut durumu kontrol et
if (is_link($publicStorage)) {
    $currentTarget = readlink($publicStorage);
    echo "Mevcut symlink var → $currentTarget\n";
    echo "Symlink çalışıyor mu: " . (is_dir($publicStorage) ? 'EVET' : 'HAYIR (kırık)') . "\n\n";

    if (is_dir($publicStorage)) {
        echo "✅ Symlink zaten çalışıyor, işlem gerekmiyor.\n";
        echo '</pre>';
        exit;
    }

    // Kırık symlink'i sil
    unlink($publicStorage);
    echo "Kırık symlink silindi.\n";

} elseif (is_dir($publicStorage)) {
    echo "UYARI: public/storage bir klasör (symlink değil).\n";
    echo "İçindeki dosyalar:\n";
    $files = glob($publicStorage . '/*');
    foreach ($files as $f) {
        echo "  - " . basename($f) . "\n";
    }
    echo "\nKlasörü symlink ile değiştiriyorum...\n";
    // Klasörü yeniden adlandır (içinde dosya varsa kaybet)
    rename($publicStorage, $publicStorage . '_backup_' . date('Ymd_His'));
    echo "Eski klasör yeniden adlandırıldı: storage_backup_" . date('Ymd_His') . "\n";
}

// Symlink oluştur
if (symlink($target, $publicStorage)) {
    echo "\n✅ Symlink başarıyla oluşturuldu!\n";
    echo "Test: " . (is_dir($publicStorage) ? 'Klasör erişilebilir ✅' : 'HATA - klasör hâlâ erişilemiyor ❌') . "\n";

    // İçeriği listele
    $items = glob($publicStorage . '/*');
    echo "\nStorage içeriği:\n";
    foreach ($items as $item) {
        $count = is_dir($item) ? count(glob($item . '/*')) . ' dosya' : '';
        echo "  " . basename($item) . "/ $count\n";
    }
} else {
    echo "\n❌ Symlink oluşturulamadı!\n";
    echo "Hata: " . error_get_last()['message'] . "\n\n";
    echo "Alternatif çözüm için cPanel → File Manager → public/ klasörüne git\n";
    echo "→ Sağ tık → 'Create Symlink'\n";
    echo "→ Symlink name: storage\n";
    echo "→ Target path: ../storage/app/public\n";
}

echo '</pre>';

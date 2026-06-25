<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<pre style='background:#1a1a2e; color:#16c60c; padding:20px; font-family:monospace;'>";
echo "=== STORAGE DOSYA KOPYALAYICI ===\n\n";

$source = '/home/u1731690/unikeyterra.net/storage/app/public';
$dest = __DIR__ . '/storage';

echo "Kaynak: $source\n";
echo "Hedef: $dest\n\n";

// Hedef klasör oluştur
if (!is_dir($dest)) {
    if (mkdir($dest, 0755, true)) {
        echo "[OK] storage klasoru olusturuldu\n";
    } else {
        echo "[HATA] storage klasoru olusturulamadi\n";
        exit;
    }
} else {
    echo "[OK] storage klasoru mevcut\n";
}

// Recursive copy function
function copyDir($src, $dst) {
    $count = 0;
    $dir = opendir($src);

    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    while (($file = readdir($dir)) !== false) {
        if ($file == '.' || $file == '..') continue;

        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;

        if (is_dir($srcPath)) {
            $count += copyDir($srcPath, $dstPath);
        } else {
            if (copy($srcPath, $dstPath)) {
                echo "  [+] $file\n";
                $count++;
            } else {
                echo "  [HATA] $file kopyalanamadi\n";
            }
        }
    }

    closedir($dir);
    return $count;
}

// Alt klasörleri kopyala
$folders = ['products', 'categories'];

foreach ($folders as $folder) {
    $srcFolder = $source . '/' . $folder;
    $dstFolder = $dest . '/' . $folder;

    echo "\n--- $folder klasoru ---\n";

    if (is_dir($srcFolder)) {
        $copied = copyDir($srcFolder, $dstFolder);
        echo "[OK] $copied dosya kopyalandi\n";
    } else {
        echo "[BILGI] Kaynak klasor yok: $srcFolder\n";
        // Klasörü oluştur
        if (!is_dir($dstFolder)) {
            mkdir($dstFolder, 0755, true);
            echo "[OK] Bos klasor olusturuldu\n";
        }
    }
}

// Sonuç
echo "\n=== SONUC ===\n";

$productCount = is_dir($dest . '/products') ? count(glob($dest . '/products/*')) : 0;
$categoryCount = is_dir($dest . '/categories') ? count(glob($dest . '/categories/*')) : 0;

echo "Products: $productCount dosya\n";
echo "Categories: $categoryCount dosya\n";

echo "\n[OK] Islem tamamlandi!\n";
echo "Artik resimleri gorebilmelisiniz.\n";
echo "\nBu dosyayi simdi silebilirsiniz.\n";
echo "</pre>";

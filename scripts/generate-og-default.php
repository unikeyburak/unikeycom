<?php
/**
 * Varsayılan Open Graph sosyal paylaşım kartı üretir → public/images/og-default.jpg
 *
 * 1200×630 (Facebook / WhatsApp / LinkedIn / X önerilen boyut).
 * Marka rengi gradyan + sol aksan çubuğu + marka adı + slogan + domain.
 *
 * Çalıştırma:  php scripts/generate-og-default.php
 *
 * Not: Metin, üretim anında Windows TTF fontlarıyla raster'lanır; çıktı statik
 *      JPG olduğu için sunucuda font gerekmez. Marka/slogan değişirse buradan
 *      güncelleyip yeniden çalıştırın (veya admin'den site_og_image yükleyin).
 */

$W = 1200;
$H = 630;

// ── İçerik ────────────────────────────────────────────────────────────────
$brand    = 'Unikeyterra';
$tagline1 = 'Yenilikçi tarımsal ürünler ve';
$tagline2 = 'bitki besleme programları';
$domain   = 'unikeyterra.net';

// ── Fontlar (Windows) ──────────────────────────────────────────────────────
$fontBold = 'C:/Windows/Fonts/segoeuib.ttf'; // Segoe UI Bold
$fontSemi = 'C:/Windows/Fonts/seguisb.ttf';  // Segoe UI Semibold
foreach ([$fontBold, $fontSemi] as $f) {
    if (!is_file($f)) {
        fwrite(STDERR, "Font bulunamadı: {$f}\n");
        exit(1);
    }
}

// ── Renkler (marka token'ları) ─────────────────────────────────────────────
$top    = [14, 116, 144]; // #0e7490 brand-600
$bottom = [8, 38, 50];    // koyu teal
$leaf   = [132, 204, 22]; // #84cc16 yaprak yeşili
$cyan   = [165, 243, 252];// #a5f3fc açık cyan

$im = imagecreatetruecolor($W, $H);
imagealphablending($im, true);

// Dikey gradyan
for ($y = 0; $y < $H; $y++) {
    $t = $y / $H;
    $r = (int) round($top[0] + ($bottom[0] - $top[0]) * $t);
    $g = (int) round($top[1] + ($bottom[1] - $top[1]) * $t);
    $b = (int) round($top[2] + ($bottom[2] - $top[2]) * $t);
    $col = imagecolorallocate($im, $r, $g, $b);
    imageline($im, 0, $y, $W, $y, $col);
}

// Dekoratif halka (sağ-üstte, hafif) — derinlik hissi
$ring = imagecolorallocatealpha($im, 255, 255, 255, 110);
for ($i = 0; $i < 6; $i++) {
    imageellipse($im, 1080 + $i, 90, 360, 360, $ring);
}

// Sol aksan çubuğu (yaprak yeşili)
$leafCol = imagecolorallocate($im, $leaf[0], $leaf[1], $leaf[2]);
imagefilledrectangle($im, 0, 0, 16, $H, $leafCol);

// ── Metinler ───────────────────────────────────────────────────────────────
$white   = imagecolorallocate($im, 255, 255, 255);
$cyanCol = imagecolorallocate($im, $cyan[0], $cyan[1], $cyan[2]);

// Marka adı
imagettftext($im, 90, 0, 92, 300, $white, $fontBold, $brand);

// Aksan alt çizgisi
imagefilledrectangle($im, 96, 332, 96 + 250, 342, $leafCol);

// Slogan (2 satır)
imagettftext($im, 36, 0, 94, 416, $cyanCol, $fontSemi, $tagline1);
imagettftext($im, 36, 0, 94, 470, $cyanCol, $fontSemi, $tagline2);

// Domain (alt)
imagettftext($im, 28, 0, 94, 578, $white, $fontSemi, $domain);

// ── Kaydet ─────────────────────────────────────────────────────────────────
$outDir = __DIR__ . '/../public/images';
if (!is_dir($outDir)) {
    mkdir($outDir, 0775, true);
}
$out = $outDir . '/og-default.jpg';
imagejpeg($im, $out, 90);
imagedestroy($im);

echo "OK → {$out} (" . $W . 'x' . $H . ", " . number_format(filesize($out) / 1024, 1) . " KB)\n";

<?php
/**
 * WordPress/WooCommerce Import Script v3
 * Resimleri indirir ve sunucuya kaydeder
 */

define('IMPORT_SECRET_KEY', 'UniKeyTerra2026Import');

set_time_limit(0);
ini_set('memory_limit', '512M');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;
use App\Services\WordPressContentParser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

$key = $_GET['key'] ?? '';
if ($key !== IMPORT_SECRET_KEY) {
    die('Yetkisiz erişim!');
}

$action = $_GET['action'] ?? 'info';
$wpUrl = rtrim($_GET['url'] ?? 'https://unikeyterra.com.tr', '/');
$consumerKey = $_GET['consumer_key'] ?? '';
$consumerSecret = $_GET['consumer_secret'] ?? '';
$test = isset($_GET['test']);
$force = isset($_GET['force']);

header('Content-Type: text/html; charset=utf-8');
echo "<pre style='font-family: monospace; background: #1a1a2e; color: #16c60c; padding: 20px;'>";
echo "=================================================\n";
echo "   IMPORT TOOL v3 - RESİM İNDİRME DESTEKLİ\n";
echo "=================================================\n\n";

if ($action === 'info') {
    echo "KULLANIM:\n";
    echo "?key=XXX&action=all&url=...&consumer_key=...&consumer_secret=...\n\n";
    echo "Kategori: " . Category::count() . "\n";
    echo "Ürün: " . Product::count() . "\n";
    echo "</pre>";
    exit;
}

$apiParams = [];
if ($consumerKey && $consumerSecret) {
    $apiParams['consumer_key'] = $consumerKey;
    $apiParams['consumer_secret'] = $consumerSecret;
    echo "[OK] API bilgileri alındı\n";
}

echo "[*] Site: {$wpUrl}\n";
echo "[*] Test: " . ($test ? 'EVET' : 'HAYIR') . "\n\n";

$categoryMapping = [];
$stats = ['added' => 0, 'updated' => 0, 'skipped' => 0, 'images' => 0, 'errors' => 0];

/**
 * WP REST API ürün formatını WooCommerce API formatına normalize eder.
 * WP REST: title.rendered, content.rendered, excerpt.rendered, categories=[int]
 * WooCommerce: name, description, short_description, categories=[{id,name,slug}]
 */
function normalizeWpRestProduct(array $wp): array {
    // Başlık
    $name = '';
    if (isset($wp['title']['rendered'])) {
        $name = html_entity_decode(strip_tags($wp['title']['rendered']), ENT_QUOTES, 'UTF-8');
    } elseif (isset($wp['title']) && is_string($wp['title'])) {
        $name = $wp['title'];
    }

    // İçerik (description)
    $description = '';
    if (isset($wp['content']['rendered'])) {
        $description = $wp['content']['rendered'];
    }

    // Kısa açıklama
    $shortDesc = '';
    if (isset($wp['excerpt']['rendered'])) {
        $shortDesc = $wp['excerpt']['rendered'];
    }

    // SKU
    $meta = $wp['meta'] ?? [];
    $sku  = '';
    if (is_array($meta)) {
        $sku = $meta['_sku'] ?? ($meta['sku'] ?? '');
    }
    if (empty($sku)) {
        $sku = 'WP-' . ($wp['id'] ?? uniqid());
    }

    // Kategoriler: WooCommerce ürünleri 'product_cat' taxonomy kullanır
    // WP REST API'da 'categories' değil, 'product_cat' alanına bakılmalı
    $wpCats = $wp['product_cat'] ?? $wp['categories'] ?? [];
    $categories = [];
    foreach ($wpCats as $catId) {
        $categories[] = ['id' => (int) $catId, 'name' => '', 'slug' => ''];
    }

    // Görseller: _embedded > wp:featuredmedia
    $images   = [];
    $embedded = $wp['_embedded'] ?? [];
    if (!empty($embedded['wp:featuredmedia'])) {
        foreach ($embedded['wp:featuredmedia'] as $media) {
            $src = $media['source_url'] ?? '';
            if ($src) $images[] = ['src' => $src];
        }
    }

    return [
        'id'                => $wp['id'] ?? null,
        'name'              => $name,
        'slug'              => $wp['slug'] ?? Str::slug($name),
        'sku'               => $sku,
        'status'            => $wp['status'] ?? 'publish',
        'featured'          => false,
        'description'       => $description,
        'short_description' => $shortDesc,
        'categories'        => $categories,
        'images'            => $images,
        'meta_data'         => [],
        'yoast_head_json'   => $wp['yoast_head_json'] ?? [],
    ];
}

// Resim indirme fonksiyonu
function downloadImage($url, $folder = 'products') {
    global $stats;

    if (empty($url)) return null;

    try {
        // Dosya adını al
        $parsedUrl = parse_url($url);
        $filename = basename($parsedUrl['path']);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Geçerli uzantı kontrolü
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($extension), $validExtensions)) {
            $extension = 'jpg';
        }

        // Benzersiz dosya adı
        $newFilename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '-' . time() . '-' . rand(100, 999) . '.' . $extension;

        // Klasör yolu (direkt public/storage'a kaydet - symlink gerekmiyor)
        $storagePath = public_path("storage/{$folder}");
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $fullPath = $storagePath . '/' . $newFilename;

        // Resmi indir - withoutVerifying SSL sorunları için
        $response = Http::withoutVerifying()->timeout(60)->get($url);

        if ($response->successful()) {
            $body = $response->body();
            if (strlen($body) > 1000) { // En az 1KB olmalı
                File::put($fullPath, $body);
                $stats['images']++;
                return "{$folder}/{$newFilename}";
            } else {
                echo "[UYARI: Resim çok küçük] ";
            }
        } else {
            echo "[HTTP " . $response->status() . "] ";
        }

    } catch (\Exception $e) {
        echo "[HATA: " . $e->getMessage() . "] ";
    }

    return null;
}

// Kategorileri import et
function importCategories($wpUrl, $apiParams, &$categoryMapping, $test, $force) {
    global $stats;

    echo "--- KATEGORİLER ---\n\n";

    $page = 1;

    do {
        $params = array_merge($apiParams, ['per_page' => 100, 'page' => $page]);

        // 1) WooCommerce product categories
        $response = Http::timeout(60)->withoutVerifying()->get("{$wpUrl}/wp-json/wc/v3/products/categories", $params);

        if (!$response->successful() || isset($response->json()['code'])) {
            // 2) WP REST API — product_cat taxonomy (WooCommerce'in kayıtladığı)
            $response = Http::timeout(60)->withoutVerifying()->get("{$wpUrl}/wp-json/wp/v2/product_cat", [
                'per_page' => 100,
                'page'     => $page,
                'orderby'  => 'id',
                'order'    => 'asc',
            ]);
            if ($response->successful() && is_array($response->json()) && !isset($response->json()['code'])) {
                if ($page === 1) echo "[*] WP REST API product_cat kullanılıyor\n";
            } else {
                // 3) Standart WP kategorileri (son çare)
                $response = Http::timeout(60)->withoutVerifying()->get("{$wpUrl}/wp-json/wp/v2/categories", [
                    'per_page' => 100,
                    'page'     => $page,
                    'orderby'  => 'id',
                    'order'    => 'asc',
                ]);
                if ($page === 1) echo "[*] WP REST API standart kategoriler kullanılıyor\n";
            }
        }

        $categories = $response->json();
        if (!is_array($categories) || isset($categories['code']) || empty($categories)) break;

        echo "[*] Sayfa {$page}: " . count($categories) . " kategori\n";

        foreach ($categories as $cat) {
            if (!isset($cat['slug'])) continue;

            try {
                $slug = Str::slug($cat['slug']);
                $existing = Category::where('slug', $slug)->first();

                // Kategori resmini indir
                $imagePath = null;
                if (!empty($cat['image']['src']) && !$test) {
                    $imagePath = downloadImage($cat['image']['src'], 'categories');
                }

                if ($existing) {
                    $categoryMapping[$cat['id']] = $existing->id;
                    if ($force && !$test) {
                        $updateData = ['name' => $cat['name'], 'description' => strip_tags($cat['description'] ?? '')];
                        if ($imagePath) $updateData['image'] = $imagePath;
                        $existing->update($updateData);
                        echo "   [GÜNCELLENDİ] {$cat['name']}\n";
                        $stats['updated']++;
                    } else {
                        $stats['skipped']++;
                    }
                } else {
                    if (!$test) {
                        $newCat = Category::create([
                            'name' => $cat['name'],
                            'slug' => $slug,
                            'description' => strip_tags($cat['description'] ?? ''),
                            'parent_id' => isset($categoryMapping[$cat['parent']]) ? $categoryMapping[$cat['parent']] : null,
                            'status' => 'active',
                            'image' => $imagePath
                        ]);
                        $categoryMapping[$cat['id']] = $newCat->id;
                        echo "   [EKLENDİ] {$cat['name']}\n";
                        $stats['added']++;
                    }
                }
            } catch (\Exception $e) {
                echo "   [HATA] {$cat['name']}: {$e->getMessage()}\n";
                $stats['errors']++;
            }
        }

        $page++;
        flush();

    } while (count($categories) == 100);

    echo "\n";
}

// Ürünleri import et
function importProducts($wpUrl, $apiParams, &$categoryMapping, $test, $force) {
    global $stats;

    echo "--- ÜRÜNLER ---\n\n";

    // Kategori mapping
    if (empty($categoryMapping)) {
        $catResponse = Http::timeout(30)->get("{$wpUrl}/wp-json/wc/v3/products/categories", array_merge($apiParams, ['per_page' => 100]));
        if ($catResponse->successful()) {
            $cats = $catResponse->json();
            foreach ($cats as $cat) {
                $localCat = Category::where('slug', Str::slug($cat['slug']))->first();
                if ($localCat) $categoryMapping[$cat['id']] = $localCat->id;
            }
        }
        echo "[*] " . count($categoryMapping) . " kategori eşleşti\n\n";
    }

    $page        = 1;
    $isWpRestApi = false;

    do {
        $params = array_merge($apiParams, ['per_page' => 10, 'page' => $page, 'status' => 'publish']);

        echo "[*] Sayfa {$page} çekiliyor...\n";

        // 1) WooCommerce v3
        $response = Http::timeout(90)->withoutVerifying()->get("{$wpUrl}/wp-json/wc/v3/products", $params);
        if ($response->successful() && is_array($response->json()) && !isset($response->json()['code'])) {
            $isWpRestApi = false;
        } else {
            // 2) WooCommerce v2
            $response = Http::timeout(90)->withoutVerifying()->get("{$wpUrl}/wp-json/wc/v2/products", $params);
            if ($response->successful() && is_array($response->json()) && !isset($response->json()['code'])) {
                $isWpRestApi = false;
                if ($page === 1) echo "[*] WC v2 API kullanılıyor\n";
            } else {
                // 3) WP REST API custom post type 'product'
                $wpParams = array_merge(['per_page' => 10, 'page' => $page, 'status' => 'publish', '_embed' => true]);
                $response = Http::timeout(90)->withoutVerifying()->get("{$wpUrl}/wp-json/wp/v2/product", $wpParams);
                if ($response->successful()) {
                    $isWpRestApi = true;
                    if ($page === 1) echo "[*] WP REST API (wp/v2/product) kullanılıyor\n";
                } else {
                    echo "[HATA] Hiçbir API endpoint çalışmadı. HTTP " . $response->status() . "\n";
                    echo "[BİLGİ] WooCommerce consumer_key ve consumer_secret gerekebilir.\n";
                    break 2;
                }
            }
        }

        $products = $response->json();
        if (!is_array($products) || isset($products['code']) || empty($products)) break;

        echo "[*] " . count($products) . " ürün bulundu\n";

        foreach ($products as $p) {
            // WP REST API formatını normalize et
            if ($isWpRestApi) {
                $p = normalizeWpRestProduct($p);
            }

            if (!isset($p['name']) || empty($p['name'])) continue;

            try {
                $name = trim($p['name']);
                $sku = !empty($p['sku']) ? $p['sku'] : 'WP-' . $p['id'];
                $slug = Str::slug($p['slug'] ?? $name);

                // Benzersiz slug
                $origSlug = $slug;
                $i = 1;
                while (Product::where('slug', $slug)->where('sku', '!=', $sku)->exists()) {
                    $slug = $origSlug . '-' . $i++;
                }

                // Kategori
                $categoryId = null;
                if (!empty($p['categories'])) {
                    foreach ($p['categories'] as $cat) {
                        $catId = is_array($cat) ? $cat['id'] : $cat;
                        if (isset($categoryMapping[$catId])) {
                            $categoryId = $categoryMapping[$catId];
                            break;
                        }
                    }
                }
                if (!$categoryId) {
                    $categoryId = Category::first()?->id;
                }

                // RESİMLERİ İNDİR
                $images = [];
                if (!empty($p['images']) && !$test) {
                    echo "      Resimler indiriliyor... ";
                    foreach ($p['images'] as $img) {
                        if (!empty($img['src'])) {
                            $downloaded = downloadImage($img['src'], 'products');
                            if ($downloaded) {
                                $images[] = $downloaded;
                                echo ".";
                            }
                        }
                    }
                    echo " " . count($images) . " resim\n";
                }

                $existing = Product::where('sku', $sku)->first();

                // ── WordPress HTML içeriğini parse et ──────────────────────
                // description → DESCRIPTION + CONTENT + DOSAGES bölümlerine ayrılır
                $parser  = new WordPressContentParser();
                $parsed  = $parser->parse(
                    $p['description'] ?? '',
                    $p['short_description'] ?? ''
                );

                // WooCommerce meta_data'dan etken madde / formülasyon çek
                $metaData        = $p['meta_data'] ?? [];
                $activeIngredient = WordPressContentParser::findMetaValue(
                    $metaData,
                    'active_ingredient', '_active_ingredient', 'etken_madde'
                );
                $formulation = WordPressContentParser::findMetaValue(
                    $metaData,
                    'formulation', '_formulation', 'formulasyon'
                );

                // SEO meta
                $yoast       = $p['yoast_head_json'] ?? [];
                $metaTitle   = $yoast['title'] ?? $name;
                $metaDesc    = $yoast['og_description'] ?? $yoast['description']
                               ?? Str::limit(strip_tags($parsed['short_description']), 160);
                $metaKeyword = WordPressContentParser::findMetaValue(
                    $metaData,
                    '_yoast_wpseo_focuskw', 'rank_math_focus_keyword'
                );

                // DEBUG çıktısı (verbose modda)
                if (isset($_GET['verbose'])) {
                    echo "      [PARSE] short_desc: " . Str::limit(strip_tags($parsed['short_description']), 60) . "\n";
                    echo "      [PARSE] long_desc: " . Str::limit(strip_tags($parsed['long_description']), 60) . "\n";
                    echo "      [PARSE] technical_info: " . (empty($parsed['technical_info']) ? 'BOŞ' : count($parsed['technical_info']['content'] ?? []) . ' satır') . "\n";
                    echo "      [PARSE] dosage_items: " . (empty($parsed['dosage_items']) ? 'BOŞ' : count($parsed['dosage_items']) . ' satır') . "\n";
                }

                $data = [
                    'name'                => $name,
                    'slug'                => $slug,
                    'sku'                 => $sku,
                    'category_id'         => $categoryId,

                    // ─── İçerik alanları (artık doğru alanlara gidiyor) ───
                    'short_description'   => $parsed['short_description'],  // DESCRIPTION
                    'long_description'    => $parsed['long_description'],    // DESCRIPTION (uzun)
                    'technical_info'      => $parsed['technical_info'],      // CONTENT (bileşim tablosu)
                    'dosage_items'        => $parsed['dosage_items'],        // DOSAGES (JSON yapısal)
                    'dosage_info'         => $parsed['dosage_info'],         // DOSAGES (HTML yedek)
                    'application_info'    => $parsed['application_info'],    // Uygulama bilgileri
                    // ─────────────────────────────────────────────────────

                    'active_ingredient'   => $activeIngredient,
                    'formulation'         => $formulation,
                    'images'              => $images,
                    'status'              => ($p['status'] ?? 'publish') === 'publish' ? 'active' : 'inactive',
                    'is_featured'         => $p['featured'] ?? false,
                    'meta_title'          => $metaTitle,
                    'meta_description'    => $metaDesc,
                    'meta_keywords'       => $metaKeyword,
                ];

                if ($existing) {
                    if ($force && !$test) {
                        if (!empty($images)) {
                            $data['images'] = $images;
                        } else {
                            unset($data['images']); // Boşsa eskiyi koru
                        }
                        $existing->update($data);
                        echo "   [GÜNCELLENDİ] {$name}";
                        echo " | İçerik:" . (empty($parsed['technical_info']) ? '✗' : '✓');
                        echo " Dozaj:" . (empty($parsed['dosage_items']) ? '✗' : '✓') . "\n";
                        $stats['updated']++;
                    } else {
                        echo "   [MEVCUT] {$name}\n";
                        $stats['skipped']++;
                    }
                } else {
                    if (!$test) {
                        $product = Product::create($data);
                        echo "   [EKLENDİ] {$name} (ID: {$product->id})";
                        echo " | İçerik:" . (empty($parsed['technical_info']) ? '✗' : '✓');
                        echo " Dozaj:" . (empty($parsed['dosage_items']) ? '✗' : '✓') . "\n";
                        $stats['added']++;
                    } else {
                        // TEST modunda ne parse edildiğini göster
                        echo "   [TEST] {$name}\n";
                        echo "          short_desc: " . Str::limit(strip_tags($parsed['short_description']), 80) . "\n";
                        echo "          technical_info: " . (empty($parsed['technical_info']) ? 'YOK' : count($parsed['technical_info']['content'] ?? []) . ' bileşen') . "\n";
                        echo "          dosage_items: " . (empty($parsed['dosage_items']) ? 'YOK' : count($parsed['dosage_items']) . ' satır') . "\n";
                    }
                }

            } catch (\Exception $e) {
                echo "   [HATA] " . ($p['name'] ?? '?') . ": " . $e->getMessage() . "\n";
                $stats['errors']++;
            }

            flush();
        }

        $page++;

    } while (count($products) == 10);

    echo "\n";
}

// Çalıştır
if ($action === 'categories' || $action === 'all') {
    importCategories($wpUrl, $apiParams, $categoryMapping, $test, $force);
}

if ($action === 'products' || $action === 'all') {
    importProducts($wpUrl, $apiParams, $categoryMapping, $test, $force);
}

echo "=================================================\n";
echo "   SONUÇ\n";
echo "=================================================\n";
echo "Eklenen: {$stats['added']}\n";
echo "Güncellenen: {$stats['updated']}\n";
echo "Atlanan: {$stats['skipped']}\n";
echo "İndirilen Resim: {$stats['images']}\n";
echo "Hata: {$stats['errors']}\n";
echo "</pre>";

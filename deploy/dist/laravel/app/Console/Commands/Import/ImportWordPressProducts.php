<?php

namespace App\Console\Commands\Import;

use App\Models\Category;
use App\Models\Product;
use App\Services\WordPressContentParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportWordPressProducts extends Command
{
    protected $signature = 'import:wordpress {method=api : api|csv|sql} {--url=} {--file=} {--test} {--consumer_key=} {--consumer_secret=} {--db_host=} {--db_name=} {--db_user=} {--db_password=} {--db_prefix=}';
    protected $description = 'WordPress sitesinden ürün ve kategori aktarımı';

    private $categoryMapping = [];
    private $importedCount = 0;
    private $skippedCount = 0;
    private $errorCount = 0;
    private $consumerKey = null;
    private $consumerSecret = null;

    /**
     * Web'den (Artisan::call) mi yoksa terminal'den mi calistigini kontrol et.
     * STDIN sabiti sadece CLI modunda tanimlidir; Artisan::call() ile web'den
     * cagrildiginda tanimli degildir.
     */
    private function isInteractive(): bool
    {
        return defined('STDIN');
    }

    public function handle()
    {
        $method = $this->argument('method');
        
        $this->info("WordPress veri aktarımı başlıyor ({$method} yöntemi)...");
        
        try {
            DB::beginTransaction();
            
            switch ($method) {
                case 'api':
                    $this->importViaApi();
                    break;
                case 'csv':
                    $this->importViaCsv();
                    break;
                case 'sql':
                    $this->importViaSql();
                    break;
                default:
                    $this->error('Geçersiz yöntem!');
                    return;
            }
            
            if ($this->option('test')) {
                DB::rollBack();
                $this->info('TEST MODU - Değişiklikler geri alındı.');
            } else {
                DB::commit();
                $this->info('Aktarım tamamlandı!');
            }
            
            $this->info("Toplam aktarılan: {$this->importedCount}");
            $this->info("Atlanan: {$this->skippedCount}");
            if ($this->errorCount > 0) {
                $this->warn("Hatalı: {$this->errorCount}");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Hata: ' . $e->getMessage());
        }
    }

    private function importViaApi()
    {
        $baseUrl = $this->option('url');
        if (!$baseUrl) {
            if (!$this->isInteractive()) {
                $this->error('URL parametresi gerekli! --url= ile belirtin.');
                return;
            }
            $baseUrl = $this->ask('WordPress site URL\'ini girin (örn: https://siteadi.com)');
        }

        // WooCommerce API credentials (option > env > interactive)
        $this->consumerKey = $this->option('consumer_key')
            ?: (getenv('WP_API_USER') ?: null);
        $this->consumerSecret = $this->option('consumer_secret')
            ?: (getenv('WP_API_PASS') ?: null);

        if (!$this->consumerKey && $this->isInteractive()) {
            $this->consumerKey = $this->ask('WooCommerce Consumer Key (boş bırakılabilir)');
        }
        if (!$this->consumerSecret && $this->isInteractive()) {
            $this->consumerSecret = $this->ask('WooCommerce Consumer Secret (boş bırakılabilir)');
        }

        // Önce kategorileri aktar
        $this->info('Kategoriler aktarılıyor...');
        $this->importCategoriesFromApi($baseUrl);

        // Sonra ürünleri aktar
        $this->info('Ürünler aktarılıyor...');
        $this->importProductsFromApi($baseUrl);
    }

    private function importCategoriesFromApi($baseUrl)
    {
        $page    = 1;
        $perPage = 100;
        $usedEndpoint = '';

        do {
            $params = ['per_page' => $perPage, 'page' => $page];

            if ($this->consumerKey && $this->consumerSecret) {
                $params['consumer_key']    = $this->consumerKey;
                $params['consumer_secret'] = $this->consumerSecret;
            }

            // 1) WooCommerce product categories endpoint
            $response = Http::timeout(60)->withoutVerifying()->get("{$baseUrl}/wp-json/wc/v3/products/categories", $params);

            if ($response->successful()) {
                $usedEndpoint = 'wc/v3';
            } else {
                // 2) WooCommerce product_cat taxonomy (WC >= 3.x bazen bu endpoint'i açık bırakır)
                $response = Http::timeout(60)->withoutVerifying()->get("{$baseUrl}/wp-json/wc/v2/products/categories", $params);

                if ($response->successful()) {
                    $usedEndpoint = 'wc/v2';
                } else {
                    // 3) WP REST API — WooCommerce product_cat taxonomy
                    // WooCommerce ürünleri 'product_cat' taxonomy kullanır (wp/v2/categories DEĞİL)
                    $response = Http::timeout(60)->withoutVerifying()->get("{$baseUrl}/wp-json/wp/v2/product_cat", [
                        'per_page' => $perPage,
                        'page'     => $page,
                        'orderby'  => 'id',
                        'order'    => 'asc',
                    ]);
                    if ($response->successful() && is_array($response->json()) && !isset($response->json()['code'])) {
                        $usedEndpoint = 'wp/v2/product_cat';
                    } else {
                        // 4) Standart WP post kategorileri (son çare)
                        $response = Http::timeout(60)->withoutVerifying()->get("{$baseUrl}/wp-json/wp/v2/categories", [
                            'per_page' => $perPage,
                            'page'     => $page,
                            'orderby'  => 'id',
                            'order'    => 'asc',
                        ]);
                        $usedEndpoint = 'wp/v2/categories';
                    }
                }
            }

            if ($page === 1) {
                $this->info("Kategori endpoint: {$usedEndpoint}");
            }

            $categories = $response->json();

            if (!is_array($categories)) {
                $this->error('Kategori API yanıtı geçersiz.');
                break;
            }

            // Hata kodu geldi (örn. 401, 403)
            if (isset($categories['code']) || isset($categories['message'])) {
                $this->warn('Kategori API uyarısı: ' . ($categories['message'] ?? 'Bilinmeyen'));
                // Devam et - ürünler yine de kategori oluşturabilir
                break;
            }

            if (empty($categories)) {
                break;
            }

            foreach ($categories as $wpCategory) {
                if (is_array($wpCategory) && (isset($wpCategory['slug']) || isset($wpCategory['name']))) {
                    $this->createCategory($wpCategory);
                }
            }

            $page++;
        } while (count($categories) == $perPage);
    }

    private function createCategory($wpCategory, $parentId = null)
    {
        $existingCategory = Category::where('slug', Str::slug($wpCategory['slug']))->first();

        if ($existingCategory) {
            $this->categoryMapping[$wpCategory['id']] = $existingCategory->id;
            return $existingCategory;
        }

        // SEO verilerini cek (Yoast SEO / RankMath / WooCommerce)
        $seo = $this->extractCategorySeo($wpCategory);

        $category = Category::create([
            'name' => $wpCategory['name'],
            'slug' => Str::slug($wpCategory['slug']),
            'description' => strip_tags($wpCategory['description'] ?? ''),
            'parent_id' => $parentId,
            'status' => 'active',
            'meta_title' => $seo['title'],
            'meta_description' => $seo['description'],
        ]);

        $this->categoryMapping[$wpCategory['id']] = $category->id;
        $this->line("Kategori eklendi: {$category->name}" . ($seo['title'] ? ' [SEO]' : ''));

        return $category;
    }

    /**
     * WooCommerce/WordPress kategori API yanitindan SEO verilerini cek
     */
    private function extractCategorySeo(array $wpCategory): array
    {
        $title = null;
        $description = null;

        // Yoast SEO (WooCommerce eklentisi)
        if (!empty($wpCategory['yoast_head_json'])) {
            $yoast = $wpCategory['yoast_head_json'];
            $title = $yoast['title'] ?? null;
            $description = $yoast['og_description'] ?? ($yoast['description'] ?? null);
        }

        // Yoast SEO (alternatif alan adlari)
        if (!$title && !empty($wpCategory['yoast_meta'])) {
            $title = $wpCategory['yoast_meta']['title'] ?? null;
            $description = $wpCategory['yoast_meta']['description'] ?? null;
        }

        // RankMath SEO
        if (!$title && !empty($wpCategory['rank_math'])) {
            $title = $wpCategory['rank_math']['title'] ?? null;
            $description = $wpCategory['rank_math']['description'] ?? null;
        }

        // Fallback: kategori adi ve aciklamasi
        if (!$title) {
            $title = $wpCategory['name'] ?? null;
        }
        if (!$description) {
            $desc = strip_tags($wpCategory['description'] ?? '');
            $description = !empty($desc) ? Str::limit($desc, 160) : null;
        }

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    private function importProductsFromApi($baseUrl)
    {
        $page         = 1;
        $perPage      = 20; // Daha az al - timeout riskini azalt
        $usedEndpoint = '';
        $isWpRestApi  = false; // WP REST API mi WooCommerce API mi?

        do {
            $params = ['per_page' => $perPage, 'page' => $page, 'status' => 'publish'];

            if ($this->consumerKey && $this->consumerSecret) {
                $params['consumer_key']    = $this->consumerKey;
                $params['consumer_secret'] = $this->consumerSecret;
            }

            // 1) WooCommerce v3 endpoint
            $response = Http::timeout(90)->withoutVerifying()->get("{$baseUrl}/wp-json/wc/v3/products", $params);

            if ($response->successful()) {
                $body = $response->json();
                if (is_array($body) && !isset($body['code'])) {
                    $usedEndpoint = 'wc/v3';
                    $isWpRestApi  = false;
                } else {
                    $response = null;
                }
            }

            // 2) WooCommerce v2 endpoint
            if (!$response || !$response->successful()) {
                $response = Http::timeout(90)->withoutVerifying()->get("{$baseUrl}/wp-json/wc/v2/products", $params);
                if ($response->successful()) {
                    $body = $response->json();
                    if (is_array($body) && !isset($body['code'])) {
                        $usedEndpoint = 'wc/v2';
                        $isWpRestApi  = false;
                    } else {
                        $response = null;
                    }
                }
            }

            // 3) WP REST API — 'product' custom post type
            //    WooCommerce register eder ama bazı sitelerde kapalı olabilir
            if (!$response || !$response->successful()) {
                $wpParams = [
                    'per_page' => $perPage,
                    'page'     => $page,
                    'status'   => 'publish',
                    '_embed'   => true, // Görseller için
                ];
                $response = Http::timeout(90)->withoutVerifying()->get("{$baseUrl}/wp-json/wp/v2/product", $wpParams);

                if ($response->successful()) {
                    $usedEndpoint = 'wp/v2/product';
                    $isWpRestApi  = true;
                } else {
                    // 4) WP REST API — 'products' (plural)
                    $response = Http::timeout(90)->withoutVerifying()->get("{$baseUrl}/wp-json/wp/v2/products", $wpParams);
                    if ($response->successful()) {
                        $usedEndpoint = 'wp/v2/products';
                        $isWpRestApi  = true;
                    }
                }
            }

            if ($page === 1) {
                $this->info("Ürün endpoint: {$usedEndpoint}");
            }

            if (!$response || !$response->successful()) {
                $this->error("Ürün API erişilemedi (HTTP {$response?->status()}). Consumer key/secret gerekebilir.");
                break;
            }

            $products = $response->json();

            if (!is_array($products)) {
                $this->error('API yanıtı geçersiz: ' . substr(json_encode($products), 0, 200));
                break;
            }

            // API hata kodu döndürdü
            if (isset($products['code']) || isset($products['message'])) {
                $this->error('API Hatası: ' . ($products['message'] ?? 'Bilinmeyen'));
                break;
            }

            if (empty($products)) {
                break;
            }

            $this->info("Sayfa {$page}: " . count($products) . " ürün bulundu...");

            foreach ($products as $wpProduct) {
                if (!is_array($wpProduct)) continue;

                // WP REST API formatını WooCommerce formatına normalize et
                if ($isWpRestApi) {
                    $wpProduct = $this->normalizeWpRestProduct($wpProduct, $baseUrl);
                }

                // 'name' alanı yoksa atla (geçersiz kayıt)
                if (empty($wpProduct['name'])) {
                    $this->warn("  [ATLANDI] Ürün adı yok, ID: " . ($wpProduct['id'] ?? '?'));
                    continue;
                }

                try {
                    $this->createProduct($wpProduct);
                } catch (\Exception $e) {
                    $this->errorCount++;
                    $this->error("  [HATA] {$wpProduct['name']}: " . $e->getMessage());
                }
            }

            $this->info("Sayfa {$page} işlendi.");
            $page++;

        } while (count($products) == $perPage);
    }

    /**
     * WP REST API ürün formatını WooCommerce API formatına dönüştürür.
     *
     * WP REST API: title.rendered, content.rendered, excerpt.rendered, categories (int[])
     * WooCommerce: name, description, short_description, categories ([{id,name,slug}])
     */
    private function normalizeWpRestProduct(array $wp, string $baseUrl): array
    {
        // Başlık
        $name = '';
        if (isset($wp['title']['rendered'])) {
            $name = $wp['title']['rendered'];
        } elseif (isset($wp['title'])) {
            $name = is_string($wp['title']) ? $wp['title'] : '';
        }

        // İçerik
        $description = '';
        if (isset($wp['content']['rendered'])) {
            $description = $wp['content']['rendered'];
        } elseif (isset($wp['content'])) {
            $description = is_string($wp['content']) ? $wp['content'] : '';
        }

        // Kısa açıklama
        $shortDesc = '';
        if (isset($wp['excerpt']['rendered'])) {
            $shortDesc = $wp['excerpt']['rendered'];
        } elseif (isset($wp['excerpt'])) {
            $shortDesc = is_string($wp['excerpt']) ? $wp['excerpt'] : '';
        }

        // SKU (meta'dan)
        $meta     = $wp['meta'] ?? [];
        $sku      = '';
        if (is_array($meta)) {
            $sku = $meta['_sku'] ?? ($meta['sku'] ?? '');
        }
        if (empty($sku)) {
            $sku = 'WP-' . ($wp['id'] ?? uniqid());
        }

        // Kategoriler: WP REST API int[] → WooCommerce [{id, name, slug}] formatına çevir
        // WooCommerce ürünleri 'product_cat' taxonomy kullanır (standart 'categories' DEĞİL)
        $wpCats = $wp['product_cat'] ?? $wp['categories'] ?? [];
        $categories = [];
        foreach ($wpCats as $catId) {
            $categories[] = ['id' => (int) $catId, 'name' => '', 'slug' => ''];
        }

        // Görseller: _embedded.wp:featuredmedia
        $images = [];
        $embedded = $wp['_embedded'] ?? [];
        if (!empty($embedded['wp:featuredmedia'])) {
            foreach ($embedded['wp:featuredmedia'] as $media) {
                $src = $media['source_url'] ?? ($media['media_details']['sizes']['full']['source_url'] ?? '');
                if ($src) $images[] = ['src' => $src, 'id' => $media['id'] ?? 0];
            }
        }
        if (empty($images) && !empty($wp['featured_media'])) {
            // Media ID'yi resolve etmek için ek istek gerekir (yavaş)
            // Şimdilik atlıyoruz, later yapılabilir
        }

        // Yoast SEO
        $yoast = $wp['yoast_head_json'] ?? [];

        return [
            'id'                => $wp['id'] ?? null,
            'name'              => html_entity_decode(strip_tags($name), ENT_QUOTES, 'UTF-8'),
            'slug'              => $wp['slug'] ?? Str::slug($name),
            'sku'               => $sku,
            'status'            => $wp['status'] ?? 'publish',
            'featured'          => $wp['sticky'] ?? false,
            'description'       => $description,
            'short_description' => $shortDesc,
            'categories'        => $categories,
            'images'            => $images,
            'meta_data'         => [],
            'yoast_head_json'   => $yoast,
            'acf'               => $wp['acf'] ?? [],
        ];
    }

    private function createProduct($wpProduct)
    {
        // SKU kontrolu - bos string'i de yakala (API "sku":"" donebilir)
        $sku = !empty($wpProduct['sku']) ? $wpProduct['sku'] : 'WP-' . $wpProduct['id'];

        if (Product::where('sku', $sku)->exists()) {
            $this->skippedCount++;
            $this->line("Atlandi (mevcut): {$wpProduct['name']}");
            return;
        }

        // TUM kategorileri topla
        $categoryIds = $this->resolveAllCategories($wpProduct['categories'] ?? []);
        $primaryCategoryId = $categoryIds[0] ?? null;

        // category_id NOT NULL - kategori yoksa "Kategorisiz" olustur
        if (!$primaryCategoryId) {
            $uncategorized = Category::firstOrCreate(
                ['slug' => 'kategorisiz'],
                ['name' => 'Kategorisiz', 'status' => 'active']
            );
            $primaryCategoryId = $uncategorized->id;
            $categoryIds = [$uncategorized->id];
        }

        // Slug benzersizligi - ayni slug varsa sonuna sayi ekle
        $baseSlug = Str::slug($wpProduct['slug'] ?: $wpProduct['name']);
        $slug = $baseSlug;
        $slugCounter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }

        // Gorselleri cek (WP URL'leri olarak)
        $images = $this->extractImages($wpProduct);

        // ── WordPress HTML içeriğini parse et ────────────────────────────
        // description alanı → DESCRIPTION + CONTENT + DOSAGES bölümlerine ayrılır
        $parser = new WordPressContentParser();
        $parsed = $parser->parse(
            $wpProduct['description'] ?? '',
            $wpProduct['short_description'] ?? ''
        );

        // Meta/ACF alanlarından etken madde ve formülasyon çek
        $activeIngredient = $this->extractMetaField($wpProduct, 'active_ingredient')
            ?? $this->extractMetaField($wpProduct, 'etken_madde');
        $formulation = $this->extractMetaField($wpProduct, 'formulation')
            ?? $this->extractMetaField($wpProduct, 'formulasyon');

        // technical_info: önce parse edileni kullan, yoksa orijinal extractor'a bak
        $technicalInfo = $parsed['technical_info']
            ?? $this->extractTechnicalInfo($wpProduct);

        // dosage_items: önce parse edileni kullan
        $dosageItems = !empty($parsed['dosage_items'])
            ? $parsed['dosage_items']
            : null;

        // dosage_info: parse'dan gelen HTML yedek ya da meta field
        $dosageInfo = $parsed['dosage_info']
            ?? $this->extractMetaField($wpProduct, 'dosage_info');

        $this->line(
            "  Parse → short:" . (empty($parsed['short_description']) ? '✗' : '✓')
            . " tech:" . (empty($technicalInfo) ? '✗' : '✓')
            . " dosage:" . (empty($dosageItems) ? '✗' : count($dosageItems) . ' satır')
        );

        // Urun olustur (alan adlari Product model $fillable ile uyumlu)
        $product = Product::create([
            'name'                => $wpProduct['name'],
            'slug'                => $slug,
            'sku'                 => $sku,
            'category_id'         => $primaryCategoryId,

            // ─── İçerik alanları (artık doğru yerlere) ──────────────────
            'short_description'   => $parsed['short_description'],   // DESCRIPTION
            'long_description'    => $parsed['long_description'],     // DESCRIPTION (uzun)
            'technical_info'      => $technicalInfo,                  // CONTENT (bileşim)
            'dosage_items'        => $dosageItems,                    // DOSAGES (yapısal JSON)
            'dosage_info'         => $dosageInfo,                     // DOSAGES (HTML yedek)
            'application_info'    => $parsed['application_info'],     // Uygulama bilgileri
            // ─────────────────────────────────────────────────────────────

            'active_ingredient'   => $activeIngredient,
            'formulation'         => $formulation,
            'usage_areas'         => $this->extractMetaField($wpProduct, 'usage_areas'),
            'mixing_info'         => $this->extractMixingInfo($wpProduct),
            'warning_info'        => $this->extractWarningInfo($wpProduct),
            'images'              => $images,
            'status'              => ($wpProduct['status'] === 'publish') ? 'active' : 'inactive',
            'is_featured'         => $wpProduct['featured'] ?? false,
            'meta_title'          => $this->extractProductSeoField($wpProduct, 'title'),
            'meta_description'    => $this->extractProductSeoField($wpProduct, 'description'),
            'meta_keywords'       => $this->extractProductSeoField($wpProduct, 'keywords'),
        ]);

        // Coklu kategorileri pivot tabloya kaydet (tablo yoksa atla)
        if (!empty($categoryIds)) {
            try {
                $product->syncCategories($categoryIds);
                $catCount = count($categoryIds);
                $this->line("Urun eklendi: {$product->name} ({$catCount} kategori)" . (!empty($images) ? ' [gorsel]' : ''));
            } catch (\Exception $e) {
                // Pivot tablo yoksa veya baska hata - urun yine de kaydedilir
                $this->line("Urun eklendi: {$product->name} (kategori sync hatasi: " . $e->getMessage() . ')');
            }
        } else {
            $this->line("Urun eklendi: {$product->name} (kategorisiz)");
        }

        $this->importedCount++;
    }

    /**
     * WordPress kategori dizisinden tum lokal kategori ID'lerini coz
     */
    private function resolveAllCategories(array $wpCategories): array
    {
        $categoryIds = [];

        foreach ($wpCategories as $wpCat) {
            // WooCommerce API: [{id:5, name:'...', slug:'...'}]
            // WP REST API:     [5, 12, 8]  (integer ID listesi)
            $wpCatId = is_array($wpCat) ? ($wpCat['id'] ?? null) : (int) $wpCat;

            if ($wpCatId && isset($this->categoryMapping[$wpCatId])) {
                $categoryIds[] = $this->categoryMapping[$wpCatId];
            }
        }

        return array_unique($categoryIds);
    }

    private function importViaCsv()
    {
        $filePath = $this->option('file');
        if (!$filePath) {
            $filePath = $this->ask('CSV dosya yolunu girin');
        }
        
        if (!file_exists($filePath)) {
            $this->error('Dosya bulunamadı!');
            return;
        }
        
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data = array_combine($header, $row);
            $this->createProductFromCsv($data);
        }
        
        fclose($handle);
    }

    private function createProductFromCsv($data)
    {
        // CSV sutun eslemeleri
        $mappings = [
            'name' => ['Ürün Adı', 'Product Name', 'name', 'title'],
            'sku' => ['SKU', 'Stok Kodu', 'sku', 'code'],
            'category' => ['Kategori', 'Category', 'category', 'Kategoriler', 'Categories'],
            'description' => ['Açıklama', 'Description', 'description'],
            'active_ingredient' => ['Etken Madde', 'Active Ingredient', 'active'],
            'formulation' => ['Formülasyon', 'Formulation', 'form'],
            'dosage' => ['Dozaj', 'Dosage', 'dose'],
            'price' => ['Fiyat', 'Price', 'price'],
            'meta_title' => ['SEO Başlık', 'SEO Title', 'Meta Title', 'meta_title', 'seo_title'],
            'meta_description' => ['SEO Açıklama', 'SEO Description', 'Meta Description', 'meta_description', 'seo_description'],
            'meta_keywords' => ['SEO Anahtar Kelimeler', 'SEO Keywords', 'Meta Keywords', 'meta_keywords', 'seo_keywords', 'focus_keyword'],
        ];

        $productData = [];
        foreach ($mappings as $field => $columns) {
            foreach ($columns as $col) {
                if (isset($data[$col]) && $data[$col] !== '') {
                    $productData[$field] = $data[$col];
                    break;
                }
            }
        }

        // Coklu kategori destegi: "Bitki Koruma, Fungisitler, Sivi" veya "Bitki Koruma > Fungisitler"
        $categoryIds = [];
        if (!empty($productData['category'])) {
            // Virgul veya pipe ile ayrilmis coklu kategori
            $categoryNames = preg_split('/[,|]/', $productData['category']);

            foreach ($categoryNames as $catName) {
                $catName = trim($catName);
                if (empty($catName)) continue;

                $category = Category::firstOrCreate([
                    'slug' => Str::slug($catName)
                ], [
                    'name' => $catName,
                    'status' => 'active'
                ]);
                $categoryIds[] = $category->id;
            }
        }

        $primaryCategoryId = $categoryIds[0] ?? null;

        // SKU kontrolu - bos string'i de yakala
        $sku = !empty($productData['sku']) ? $productData['sku'] : 'CSV-' . uniqid();

        if (Product::where('sku', $sku)->exists()) {
            $this->skippedCount++;
            return;
        }

        // SEO fallback: baslik yoksa urun adini, aciklama yoksa description'i kullan
        $metaTitle = $productData['meta_title'] ?? $productData['name'] ?? null;
        $metaDesc = $productData['meta_description']
            ?? (!empty($productData['description']) ? Str::limit(strip_tags($productData['description']), 160) : null);
        $metaKeywords = $productData['meta_keywords'] ?? null;

        // Urun olustur
        $product = Product::create([
            'name' => $productData['name'],
            'slug' => Str::slug($productData['name']),
            'sku' => $sku,
            'category_id' => $primaryCategoryId,
            'long_description' => $productData['description'] ?? '',
            'active_ingredient' => $productData['active_ingredient'] ?? '',
            'formulation' => $productData['formulation'] ?? '',
            'dosage_info' => $productData['dosage'] ?? '',
            'status' => 'active',
            'meta_title' => $metaTitle,
            'meta_description' => $metaDesc,
            'meta_keywords' => $metaKeywords,
        ]);

        // Coklu kategorileri pivot tabloya kaydet
        if (!empty($categoryIds)) {
            $product->syncCategories($categoryIds);
        }

        $this->importedCount++;
    }

    private function extractMetaField($wpProduct, $field)
    {
        // 1) Dogrudan alan (eklenti REST field olarak eklemisse)
        if (!empty($wpProduct[$field])) {
            return $wpProduct[$field];
        }

        // 2) ACF alanlari
        if (!empty($wpProduct['acf'][$field])) {
            return $wpProduct['acf'][$field];
        }

        // 3) WooCommerce meta_data dizisi ({id, key, value} nesneleri)
        if (!empty($wpProduct['meta_data']) && is_array($wpProduct['meta_data'])) {
            // Hem _ onekli hem oneksiz ara
            $searchKeys = [$field, '_' . $field];
            foreach ($wpProduct['meta_data'] as $meta) {
                if (isset($meta['key']) && in_array($meta['key'], $searchKeys) && !empty($meta['value'])) {
                    return $meta['value'];
                }
            }
        }

        return null;
    }

    /**
     * mixing_info alanini cek (JSON array formatinda)
     */
    private function extractMixingInfo($wpProduct): ?array
    {
        $mixing = $this->extractMetaField($wpProduct, 'mixing_info');
        if ($mixing && is_array($mixing)) return $mixing;
        if ($mixing && is_string($mixing)) {
            return ['instructions' => [strip_tags($mixing)]];
        }
        return null;
    }

    /**
     * warning_info alanini cek (JSON array formatinda)
     */
    private function extractWarningInfo($wpProduct): ?array
    {
        $warning = $this->extractMetaField($wpProduct, 'warning_text')
            ?? $this->extractMetaField($wpProduct, 'warning_info');
        if ($warning && is_array($warning)) return $warning;
        if ($warning && is_string($warning)) {
            return ['text' => strip_tags($warning)];
        }
        return null;
    }

    private function extractTechnicalInfo($wpProduct)
    {
        $info = [];
        $fields = ['ph', 'density', 'appearance', 'storage_conditions'];
        
        foreach ($fields as $field) {
            $value = $this->extractMetaField($wpProduct, $field);
            if ($value) {
                $info[$field] = $value;
            }
        }
        
        return empty($info) ? null : $info;
    }

    private function extractImages($wpProduct)
    {
        $images = [];

        // WooCommerce gorsel dizisi
        if (!empty($wpProduct['images'])) {
            foreach ($wpProduct['images'] as $image) {
                if (!empty($image['src'])) {
                    $images[] = $image['src'];
                }
            }
        } elseif (!empty($wpProduct['featured_media_url'])) {
            $images[] = $wpProduct['featured_media_url'];
        }

        // Ayni gorsel birden fazla geliyorsa tekrarlari kaldir
        return array_values(array_unique($images));
    }

    /**
     * WooCommerce/WordPress urun API yanitindan SEO alanini cek
     * $field: 'title', 'description', 'keywords'
     */
    private function extractProductSeoField(array $wpProduct, string $field): ?string
    {
        // Alan adi eslemeleri (kaynak => alt alan)
        $fieldMap = [
            'title' => [
                'yoast_head_json' => 'title',
                'yoast_meta' => 'title',
                'rank_math' => 'title',
                'meta_data' => '_yoast_wpseo_title',
                'rank_meta_data' => 'rank_math_title',
            ],
            'description' => [
                'yoast_head_json' => 'og_description',
                'yoast_head_json_alt' => 'description',
                'yoast_meta' => 'description',
                'rank_math' => 'description',
                'meta_data' => '_yoast_wpseo_metadesc',
                'rank_meta_data' => 'rank_math_description',
            ],
            'keywords' => [
                'yoast_meta' => 'focuskw',
                'rank_math' => 'focus_keyword',
                'meta_data' => '_yoast_wpseo_focuskw',
                'rank_meta_data' => 'rank_math_focus_keyword',
            ],
        ];

        $map = $fieldMap[$field] ?? [];

        // 1) Yoast head JSON (en zengin kaynak)
        if (!empty($map['yoast_head_json']) && !empty($wpProduct['yoast_head_json'])) {
            $val = $wpProduct['yoast_head_json'][$map['yoast_head_json']] ?? null;
            if ($val) return $val;
        }
        // yoast_head_json alternatif alan (description icin og_description bos olabilir)
        if (!empty($map['yoast_head_json_alt']) && !empty($wpProduct['yoast_head_json'])) {
            $val = $wpProduct['yoast_head_json'][$map['yoast_head_json_alt']] ?? null;
            if ($val) return $val;
        }

        // 2) Yoast meta (eklenti REST alanı)
        if (!empty($map['yoast_meta']) && !empty($wpProduct['yoast_meta'])) {
            $val = $wpProduct['yoast_meta'][$map['yoast_meta']] ?? null;
            if ($val) return $val;
        }

        // 3) RankMath (eklenti REST alanı)
        if (!empty($map['rank_math']) && !empty($wpProduct['rank_math'])) {
            $val = $wpProduct['rank_math'][$map['rank_math']] ?? null;
            if ($val) return $val;
        }

        // 4) WooCommerce meta_data dizisi (key-value array)
        if (!empty($wpProduct['meta_data']) && is_array($wpProduct['meta_data'])) {
            $metaKey = $map['meta_data'] ?? null;
            $rankMetaKey = $map['rank_meta_data'] ?? null;

            foreach ($wpProduct['meta_data'] as $meta) {
                $key = $meta['key'] ?? null;
                $value = $meta['value'] ?? null;
                if (!$key || !$value) continue;

                if ($metaKey && $key === $metaKey) return $value;
                if ($rankMetaKey && $key === $rankMetaKey) return $value;
            }
        }

        // 5) Fallback
        if ($field === 'title') {
            return $wpProduct['name'] ?? null;
        }
        if ($field === 'description') {
            $excerpt = strip_tags($wpProduct['short_description'] ?? '');
            return !empty($excerpt) ? Str::limit($excerpt, 160) : null;
        }

        return null;
    }

    private function parseDosageFromText($text)
    {
        if (empty($text)) return null;

        $lines = explode("\n", $text);
        $data = ['rows' => []];

        foreach ($lines as $line) {
            $cells = preg_split('/\t|\|/', $line);
            if (count($cells) > 1) {
                $data['rows'][] = array_map('trim', $cells);
            }
        }

        return empty($data['rows']) ? null : $data;
    }

    private function importViaSql()
    {
        $this->info('SQL import başlatılıyor...');

        // Parametre onceligi: --option > putenv > interactive ask
        $host = $this->option('db_host') ?: (getenv('WP_IMPORT_HOST') ?: null);
        $database = $this->option('db_name') ?: (getenv('WP_IMPORT_DB') ?: null);
        $username = $this->option('db_user') ?: (getenv('WP_IMPORT_USER') ?: null);
        $password = $this->option('db_password') ?: (getenv('WP_IMPORT_PASS') ?: null);
        $prefix = $this->option('db_prefix') ?: (getenv('WP_IMPORT_PREFIX') ?: null);

        if ($this->isInteractive()) {
            // Terminal'de calisiyor - eksik alanlari sor
            $host = $host ?: $this->ask('WordPress DB Host', 'localhost');
            $database = $database ?: $this->ask('WordPress DB Adı');
            $username = $username ?: $this->ask('WordPress DB Kullanıcı');
            $password = $password ?: $this->secret('WordPress DB Şifre');
            $prefix = $prefix ?: $this->ask('WordPress Tablo Öneki', 'wp_');
        } else {
            // Web'den calisiyor - eksik parametre varsa hata ver
            $host = $host ?: 'localhost';
            $prefix = $prefix ?: 'wp_';

            if (!$database || !$username) {
                $this->error('SQL import için db_name ve db_user parametreleri gerekli!');
                return;
            }
            $password = $password ?: '';
        }

        $config = [
            'host' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'prefix' => $prefix,
        ];

        // Geçici bağlantı oluştur
        config(['database.connections.wordpress' => array_merge(
            config('database.connections.mysql'),
            $config
        )]);

        $wpDB = DB::connection('wordpress');

        // Kategorileri aktar
        $this->importCategoriesFromSql($wpDB, $config['prefix']);

        // Ürünleri aktar
        $this->importProductsFromSql($wpDB, $config['prefix']);
    }

    private function importCategoriesFromSql($wpDB, $prefix)
    {
        $taxonomies = $wpDB->table($prefix . 'term_taxonomy')
            ->where(function ($query) {
                $query->where('taxonomy', 'product_cat')
                      ->orWhere('taxonomy', 'category');
            })
            ->get();

        foreach ($taxonomies as $taxonomy) {
            $term = $wpDB->table($prefix . 'terms')
                ->where('term_id', $taxonomy->term_id)
                ->first();

            if ($term) {
                $parentId = null;
                if ($taxonomy->parent > 0 && isset($this->categoryMapping[$taxonomy->parent])) {
                    $parentId = $this->categoryMapping[$taxonomy->parent];
                }

                // Yoast SEO / RankMath meta verilerini wp_termmeta'dan oku
                $termMeta = $wpDB->table($prefix . 'termmeta')
                    ->where('term_id', $taxonomy->term_id)
                    ->pluck('meta_value', 'meta_key')
                    ->toArray();

                $metaTitle = $termMeta['_yoast_wpseo_title']
                    ?? $termMeta['rank_math_title']
                    ?? $term->name;
                $metaDesc = $termMeta['_yoast_wpseo_metadesc']
                    ?? $termMeta['rank_math_description']
                    ?? (!empty($taxonomy->description) ? Str::limit(strip_tags($taxonomy->description), 160) : null);

                $category = Category::firstOrCreate([
                    'slug' => $term->slug
                ], [
                    'name' => $term->name,
                    'description' => strip_tags($taxonomy->description ?? ''),
                    'parent_id' => $parentId,
                    'status' => 'active',
                    'is_active' => true,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDesc,
                ]);

                $this->categoryMapping[$taxonomy->term_id] = $category->id;
                $this->line("Kategori eklendi: {$category->name}" . ($metaTitle !== $term->name ? ' [SEO]' : ''));
            }
        }
    }

    private function importProductsFromSql($wpDB, $prefix)
    {
        $products = $wpDB->table($prefix . 'posts')
            ->where(function ($query) {
                $query->where('post_type', 'product')
                      ->orWhere('post_type', 'urun');
            })
            ->where('post_status', 'publish')
            ->get();

        foreach ($products as $wpProduct) {
            // Meta verileri al
            $metaData = $wpDB->table($prefix . 'postmeta')
                ->where('post_id', $wpProduct->ID)
                ->pluck('meta_value', 'meta_key')
                ->toArray();

            // TUM kategorileri al
            $wpCategoryTermIds = $wpDB->table($prefix . 'term_relationships as tr')
                ->join($prefix . 'term_taxonomy as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
                ->where('tr.object_id', $wpProduct->ID)
                ->whereIn('tt.taxonomy', ['product_cat', 'category'])
                ->pluck('tt.term_id')
                ->toArray();

            // WP term ID'lerini lokal kategori ID'lerine cevir
            $categoryIds = [];
            foreach ($wpCategoryTermIds as $termId) {
                if (isset($this->categoryMapping[$termId])) {
                    $categoryIds[] = $this->categoryMapping[$termId];
                }
            }
            $categoryIds = array_unique($categoryIds);
            $primaryCategoryId = $categoryIds[0] ?? null;

            // SKU kontrolu - bos string'i de yakala
            $sku = !empty($metaData['_sku']) ? $metaData['_sku'] : 'WP-' . $wpProduct->ID;

            if (Product::where('sku', $sku)->exists()) {
                $this->skippedCount++;
                continue;
            }

            // Yoast SEO / RankMath meta verilerini oku
            $metaTitle = $metaData['_yoast_wpseo_title']
                ?? $metaData['rank_math_title']
                ?? $wpProduct->post_title;
            $metaDesc = $metaData['_yoast_wpseo_metadesc']
                ?? $metaData['rank_math_description']
                ?? (!empty($wpProduct->post_excerpt) ? Str::limit(strip_tags($wpProduct->post_excerpt), 160) : null);
            $metaKeywords = $metaData['_yoast_wpseo_focuskw']
                ?? $metaData['rank_math_focus_keyword']
                ?? null;

            // ── SQL import: HTML içeriği parse et ────────────────────────
            $parser    = new WordPressContentParser();
            $parsed    = $parser->parse(
                $wpProduct->post_content ?? '',
                $wpProduct->post_excerpt ?? ''
            );

            $technicalInfo = $parsed['technical_info'];
            $dosageItems   = !empty($parsed['dosage_items']) ? $parsed['dosage_items'] : null;
            $dosageInfo    = $parsed['dosage_info'];

            $product = Product::create([
                'name'              => $wpProduct->post_title,
                'slug'              => $wpProduct->post_name,
                'sku'               => $sku,
                'category_id'       => $primaryCategoryId,

                // ─── İçerik alanları (doğru yerlere) ────────────────────
                'short_description' => $parsed['short_description'],  // DESCRIPTION
                'long_description'  => $parsed['long_description'],   // DESCRIPTION (uzun)
                'technical_info'    => $technicalInfo,                // CONTENT (bileşim)
                'dosage_items'      => $dosageItems,                  // DOSAGES (JSON)
                'dosage_info'       => $dosageInfo,                   // DOSAGES (HTML yedek)
                'application_info'  => $parsed['application_info'],   // Uygulama bilgileri
                // ─────────────────────────────────────────────────────────

                'active_ingredient' => $metaData['_active_ingredient'] ?? ($metaData['active_ingredient'] ?? ''),
                'formulation'       => $metaData['_formulation'] ?? ($metaData['formulation'] ?? ''),
                'status'            => 'active',
                'is_featured'       => ($metaData['_featured'] ?? 'no') === 'yes',
                'meta_title'        => $metaTitle,
                'meta_description'  => $metaDesc,
                'meta_keywords'     => $metaKeywords,
            ]);

            // Coklu kategorileri pivot tabloya kaydet
            if (!empty($categoryIds)) {
                $product->syncCategories($categoryIds);
                $catCount = count($categoryIds);
                $this->line("Urun eklendi: {$product->name} ({$catCount} kategori)");
            } else {
                $this->line("Urun eklendi: {$product->name} (kategorisiz)");
            }

            $this->importedCount++;
        }
    }
}
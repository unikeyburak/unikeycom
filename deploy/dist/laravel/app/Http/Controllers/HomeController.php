<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\ProductService;
use App\Services\SeoService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private CategoryService $categoryService,
        private ProductService $productService,
        private PostService $postService,
        private SeoService $seoService
    ) {}

    /**
     * Ana sayfa
     */
    public function index()
    {
        // Kategorileri cache'le (1 saat) - translations eager loaded (N+1 sorgu önlenir)
        $categories = Cache::remember('homepage_categories', 3600, function () {
            $cats = \App\Models\Category::active()
                ->showOnHomepage()
                ->withCount('products')
                ->with('translations')
                ->get();

            if ($cats->isEmpty()) {
                $cats = $this->categoryService->getCategoriesWithProductCount();
            }

            return $cats;
        });

        // Öne çıkan ürünleri getir (zaten ProductService'de cache var)
        $featuredProducts = $this->productService->getFeaturedProducts(8);

        // Bitki listesini cache'le ve limitle
        $plants = Cache::remember('homepage_plants', 3600, function () {
            return \App\Models\Plant::active()
                ->orderBy('name')
                ->limit(20)
                ->get(['id', 'name', 'slug', 'image', 'scientific_name']);
        });

        // Son blog yazilari (4 adet, 1 saat cache)
        $latestPosts = Cache::remember('homepage_latest_posts', 3600, function () {
            return \App\Models\Post::published()
                ->with(['category', 'creator'])
                ->latest('published_at')
                ->limit(4)
                ->get(['id', 'post_category_id', 'created_by', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time', 'status']);
        });

        // Rich Snippets - Google için yapılandırılmış veri
        $settings = app('view')->getShared()['settings'] ?? [];
        $schemas = $this->buildHomeSchemas($featuredProducts, $categories, $settings);

        // Ana sayfa OG/meta — admin panelindeki Site Bilgileri'nden al
        $meta = [
            'title'       => $settings['site_name'] ?? config('app.name'),
            'description' => $settings['site_description'] ?? '',
            'keywords'    => $settings['site_keywords'] ?? '',
            'image'       => !empty($settings['site_og_image'])
                                ? asset('storage/' . $settings['site_og_image'])
                                : asset('images/og-default.jpg'),
            'image_width'  => 1200,
            'image_height' => 630,
            'type'        => 'website',
            'url'         => request()->url(),
            'canonical'   => request()->url(),
        ];

        return view('home', compact('categories', 'featuredProducts', 'plants', 'latestPosts', 'schemas', 'meta'));
    }

    /**
     * Ana sayfa için Schema.org yapılandırılmış verileri
     */
    private function buildHomeSchemas($featuredProducts, $categories, array $settings): array
    {
        $schemas = [];
        $appUrl = config('app.url', 'https://unikeyterra.com');
        $appName = $settings['site_name'] ?? config('app.name');

        // Logo URL
        $logoUrl = !empty($settings['site_logo'])
            ? asset('storage/' . $settings['site_logo'])
            : asset('images/logo.png');

        // 1. Organization - Şirket bilgileri
        $organization = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $appName,
            'url' => $appUrl,
            'logo' => $logoUrl,
        ];
        if (!empty($settings['contact_phone'])) {
            $organization['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $settings['contact_phone'],
                'contactType' => 'customer service',
                'availableLanguage' => ['Turkish', 'English'],
            ];
        }
        if (!empty($settings['contact_address'])) {
            $organization['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $settings['contact_address'],
                'addressLocality' => $settings['contact_city'] ?? '',
                'postalCode' => $settings['contact_postcode'] ?? '',
                'addressCountry' => 'TR',
            ];
        }
        $socialLinks = [];
        $socialMedia = $settings['social_media'] ?? [];
        if (is_array($socialMedia)) {
            foreach ($socialMedia as $platform) {
                $url = is_array($platform) ? ($platform['url'] ?? null) : $platform;
                if (!empty($url)) {
                    $socialLinks[] = $url;
                }
            }
        }
        if (!empty($socialLinks)) {
            $organization['sameAs'] = $socialLinks;
        }
        $schemas[] = $organization;

        // 2. WebSite - Site arama özelliği
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $appName,
            'url' => $appUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $appUrl . '/urunler/ara?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];

        // 3. ItemList - Öne çıkan ürünler listesi
        $productItems = [];
        foreach ($featuredProducts as $index => $product) {
            $item = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Product',
                    'name' => $product->name,
                    'url' => route('products.show', $product->slug),
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => $appName,
                    ],
                ],
            ];
            $pImgs = is_array($product->images) ? array_values(array_filter($product->images, 'is_string')) : [];
            if (!empty($pImgs)) {
                $item['item']['image'] = str_starts_with($pImgs[0], 'http') ? $pImgs[0] : app(\App\Services\MediaService::class)->getCdnUrl($pImgs[0]);
            }
            if ($product->short_description) {
                $item['item']['description'] = $product->short_description;
            }
            $productItems[] = $item;
        }
        if (!empty($productItems)) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => 'Öne Çıkan Ürünler',
                'numberOfItems' => count($productItems),
                'itemListElement' => $productItems,
            ];
        }

        // 4. CollectionPage - Kategori listesi
        $categoryItems = [];
        foreach ($categories as $index => $category) {
            $categoryItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Thing',
                    'name' => $category->translate('name'),
                    'url' => route('products.category', $category->slug),
                ],
            ];
        }
        if (!empty($categoryItems)) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => 'Ürün Kategorileri',
                'numberOfItems' => count($categoryItems),
                'itemListElement' => $categoryItems,
            ];
        }

        return $schemas;
    }
}
<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}
    /**
     * Ürün listesi (tüm ürünler veya arama)
     */
    public function index(Request $request)
    {
        // Eski ?category=slug URL'lerini yeni /{slug} URL'lerine 301 yönlendir
        if ($request->filled('category')) {
            return redirect('/' . $request->get('category'), 301);
        }

        $currentCategory = null;

        if ($request->filled('q')) {
            $products = $this->productService->searchProducts($request->get('q'), 12);
        } else {
            $products = $this->productService->getAllProducts(12);
        }

        $categories = $this->categoryService->getCategoriesWithProductCount();

        // Ürünler listesi için settings'den meta al
        $settings = app('view')->getShared()['settings'] ?? [];
        $meta = [
            'title'       => ($settings['site_name'] ?? config('app.name')),
            'description' => $settings['site_description'] ?? '',
            'keywords'    => $settings['site_keywords'] ?? '',
            'image'       => !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('images/og-default.jpg'),
            'type'        => 'website',
            'url'         => request()->url(),
            'canonical'   => request()->url(),
        ];

        $categoryGroups = $this->categoryGroups();

        return view('products.index', compact('products', 'categories', 'categoryGroups', 'currentCategory', 'meta'));
    }

    /**
     * Kategori sayfası (root-level slug: /klasik-gubreler)
     */
    public function category(string $slug, Request $request)
    {
        $currentCategory = $this->categoryService->getCategoryBySlug($slug);

        if (!$currentCategory) {
            abort(404);
        }

        $sort = $request->get('sort', 'category');
        $products = $this->productService->getProductsByCategory($currentCategory->id, 12, $sort);
        $categories = $this->categoryService->getCategoriesWithProductCount();

        // Kategori SEO meta — HasSeo trait üzerinden
        $meta = $currentCategory->getSeoMeta();

        // Breadcrumb: Ana Sayfa › Kategori
        $schemas = [
            breadcrumb_schema([
                ['name' => __('Ana Sayfa'), 'url' => lroute('home')],
                ['name' => $currentCategory->translate('name')],
            ]),
        ];

        $categoryGroups = $this->categoryGroups();

        return view('products.index', compact('products', 'categories', 'categoryGroups', 'currentCategory', 'meta', 'schemas'));
    }
    
    /**
     * Ürün detay
     */
    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        
        if (!$product || $product->status !== 'active') {
            abort(404);
        }
        
        // İlgili ürünleri getir
        $relatedProducts = $this->productService->getRelatedProducts($product->id, $product->category_id, 4);
        
        // SEO meta verilerini hazırla
        $meta = $product->getSeoMeta();
        
        // Rich Snippets için tüm schema'ları al
        $schemas = $product->getAllSchemas();

        // Breadcrumb: Ana Sayfa › [Kategori] › Ürün
        $crumbs = [['name' => __('Ana Sayfa'), 'url' => lroute('home')]];
        if ($product->category) {
            $crumbs[] = [
                'name' => $product->category->translate('name'),
                'url'  => lroute('products.category', $product->category->slug),
            ];
        }
        $crumbs[] = ['name' => $product->translate('name')];
        $schemas[] = breadcrumb_schema($crumbs);

        return view('products.show', compact('product', 'relatedProducts', 'meta', 'schemas'));
    }
    
    /**
     * Ürün arama
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Gruplu filtre için: üst grup kategorileri (parent'sız) + serileri (children).
     * "uncategorized" (WP kalıntısı) gizlenir. Gruplama yapılmamışsa düz kategoriler
     * doğrudan link pill'i olarak render edilir (view bunu destekler).
     */
    private function categoryGroups(): \Illuminate\Support\Collection
    {
        return \App\Models\Category::query()
            ->whereNull('parent_id')
            ->where('slug', '!=', 'uncategorized')
            ->with(['children' => fn ($q) => $q->orderBy('name')])
            ->orderBy('name')
            ->get();
    }
}

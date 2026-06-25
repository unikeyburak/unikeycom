<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\CachePublicPages;


class ProductService
{
    private const LIST_COLUMNS = [
        'id',
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'active_ingredient',
        'formulation',
        'status',
        'is_featured',
        'images',
        'created_at',
        'updated_at',
    ];

    private const RELATED_COLUMNS = [
        'id',
        'category_id',
        'name',
        'slug',
        'short_description',
        'images',
        'is_featured',
    ];
    /**
     * Constructor
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Get all products
     */
    public function getAllProducts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->getActiveProductsPaginated($perPage, self::LIST_COLUMNS, ['category']);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Cache::remember('featured_products', 3600, function () use ($limit) {
            return $this->productRepository->getFeaturedProducts($limit, self::LIST_COLUMNS, ['category']);
        });
    }

    /**
     * Get product by ID
     */
    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->find($id, ['*'], ['category']);
    }

    /**
     * Get product by slug
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Cache::remember("product_slug_{$slug}", 3600, function () use ($slug) {
            return $this->productRepository->findBySlug($slug, ['*'], ['category', 'categories.translations']);
        });
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(int $categoryId, int $perPage = 15, string $sort = 'category'): LengthAwarePaginator
    {
        return $this->productRepository->getByCategory($categoryId, $perPage, self::LIST_COLUMNS, ['category'], $sort);
    }

    /**
     * Search products
     */
    public function searchProducts(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->searchProducts($query, $perPage, self::LIST_COLUMNS, ['category']);
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(int $productId, int $categoryId, int $limit = 4): Collection
    {
        return Cache::remember("related_products_{$productId}", 3600, function () use ($productId, $categoryId, $limit) {
            return $this->productRepository->getRelatedProducts($productId, $categoryId, $limit, self::RELATED_COLUMNS);
        });
    }

    /**
     * Create product
     */
    public function createProduct(ProductDTO $dto): Product
    {
        $product = $this->productRepository->create($dto->toArray());

        $this->clearProductCache();

        return $product;
    }

    /**
     * Update product
     */
    public function updateProduct(int $id, ProductDTO $dto): bool
    {
        $result = $this->productRepository->update($id, $dto->toArray());

        if ($result) {
            $this->clearProductCache();
        }

        return $result;
    }

    /**
     * Delete product
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->find($id);

        $result = $this->productRepository->delete($id);

        if ($result) {
            $this->clearProductCache();
            // Silinen ürünün cache'ini temizle
            if ($product) {
                CachePublicPages::clearUrl('/urun/' . $product->slug);
            }
        }

        return $result;
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(int $id): bool
    {
        $product = $this->productRepository->find($id);
        
        if (!$product) {
            return false;
        }
        
        $result = $this->productRepository->update($id, [
            'is_featured' => !$product->is_featured
        ]);
        
        if ($result) {
            Cache::forget('featured_products');
        }
        
        return $result;
    }

    /**
     * Update product status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $result = $this->productRepository->update($id, [
            'status' => $status
        ]);
        
        if ($result) {
            $this->clearProductCache();
        }
        
        return $result;
    }

    /**
     * Clear product cache (seçici - sadece ilgili key'leri temizle)
     */
    private function clearProductCache(): void
    {
        Cache::forget('featured_products');
        Cache::forget('nav_categories');
        Cache::forget('mega_menu_categories');
        Cache::forget('homepage_categories');
        Cache::forget('homepage_plants');
        Cache::forget('homepage_stats');
        Cache::forget('homepage_plant_programs_grid');
        Cache::forget('category_hierarchy');
        Cache::forget('admin_dashboard_stats');

        // Sayfa cache'lerini temizle (yeni cache ilk ziyarette oluşur — senkron warm yok)
        CachePublicPages::clearUrl('/');
        CachePublicPages::clearUrl('/urunler');
    }
}

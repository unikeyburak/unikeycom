<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use App\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * Constructor
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active products
     */
    public function getActiveProducts(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model
            ->with($relations)
            ->where('status', 'active')
            ->get($columns);
    }

    /**
     * Get active products with pagination
     */
    public function getActiveProductsPaginated(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        $relationsWithTranslations = array_merge($relations, ['category.translations']);

        return $this->model
            ->with($relationsWithTranslations)
            ->where('status', 'active')
            ->paginate($perPage, $columns);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8, array $columns = ['*'], array $relations = []): Collection
    {
        // category.translations eager load ekle (N+1 translate() problemi önlenir)
        $relationsWithTranslations = array_merge($relations, ['category.translations']);

        $featured = $this->model
            ->with($relationsWithTranslations)
            ->where('status', 'active')
            ->where('is_featured', true)
            ->limit($limit)
            ->latest()
            ->get($columns);

        // Eğer öne çıkan ürün yoksa, aktif ürünlerden getir
        if ($featured->isEmpty()) {
            $featured = $this->model
                ->with($relationsWithTranslations)
                ->where('status', 'active')
                ->limit($limit)
                ->latest()
                ->get($columns);
        }

        return $featured;
    }

    /**
     * Get products by category (pivot tablo ile coka-cok filtreleme)
     */
    public function getByCategory(int $categoryId, int $perPage = 15, array $columns = ['*'], array $relations = [], string $sort = 'category'): LengthAwarePaginator
    {
        $categoryIds = $this->getCategoryIdsWithDescendants($categoryId);
        $relationsWithTranslations = array_merge($relations, ['category.translations']);

        $query = $this->model
            ->with($relationsWithTranslations)
            ->where('status', 'active');

        // Pivot tablo varsa hem category_id hem pivot'tan ara
        if (\Illuminate\Support\Facades\Schema::hasTable('category_product')) {
            $query->where(function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                  ->orWhereHas('categories', function ($sub) use ($categoryIds) {
                      $sub->whereIn('categories.id', $categoryIds);
                  });
            });
        } else {
            $query->whereIn('category_id', $categoryIds);
        }

        // Sıralama: varsayılan olarak kategoriye göre grupla (category_id aynı olanlar yan yana)
        match ($sort) {
            'name_desc' => $query->orderBy('name', 'desc'),
            'newest'    => $query->orderBy('created_at', 'desc'),
            'name_asc'  => $query->orderBy('name', 'asc'),
            default     => $query->orderBy('category_id')->orderBy('name'),
        };

        return $query->paginate($perPage, $columns);
    }

    /**
     * Search products
     */
    public function searchProducts(string $query, int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        $relationsWithTranslations = array_merge($relations, ['category.translations']);

        return $this->model
            ->with($relationsWithTranslations)
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('long_description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%")
                  ->orWhere('active_ingredient', 'like', "%{$query}%");
            })
            ->paginate($perPage, $columns);
    }

    /**
     * Get related products (ortak kategorilere gore)
     */
    public function getRelatedProducts(
        int $productId,
        int $categoryId,
        int $limit = 4,
        array $columns = ['*'],
        array $relations = []
    ): Collection
    {
        // Urunun tum kategori ID'lerini al
        $product = $this->model->find($productId);
        $productCategoryIds = $product
            ? $product->categories()->pluck('categories.id')->toArray()
            : [$categoryId];

        if (empty($productCategoryIds)) {
            $productCategoryIds = [$categoryId];
        }

        return $this->model
            ->with($relations)
            ->where('id', '!=', $productId)
            ->where('status', 'active')
            ->where(function ($query) use ($productCategoryIds) {
                $query->whereIn('category_id', $productCategoryIds)
                      ->orWhereHas('categories', function ($q) use ($productCategoryIds) {
                          $q->whereIn('categories.id', $productCategoryIds);
                      });
            })
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Find product by slug
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $relations = []): ?object
    {
        $relationsWithTranslations = array_merge($relations, ['category.translations']);

        return $this->model
            ->with($relationsWithTranslations)
            ->where('slug', $slug)
            ->first($columns);
    }

    /**
     * Update product stock
     */
    public function updateStock(int $productId, int $quantity): bool
    {
        // Bu projede stok takibi yok, gelecekte eklenebilir
        return true;
    }

    /**
     * Get products with low stock
     */
    public function getLowStockProducts(int $threshold = 10): Collection
    {
        // Bu projede stok takibi yok, gelecekte eklenebilir
        return new Collection();
    }

    /**
     * Get category ID list including descendants.
     *
     * @return array<int>
     */
    private function getCategoryIdsWithDescendants(int $categoryId): array
    {
        $categories = \Illuminate\Support\Facades\Cache::remember('category_hierarchy', 3600, function () {
            return Category::query()
                ->select(['id', 'parent_id'])
                ->get();
        });

        $childrenByParent = [];
        foreach ($categories as $category) {
            if ($category->parent_id !== null) {
                $childrenByParent[$category->parent_id][] = $category->id;
            }
        }

        $ids = [$categoryId];
        $stack = [$categoryId];

        while (!empty($stack)) {
            $currentId = array_pop($stack);
            foreach ($childrenByParent[$currentId] ?? [] as $childId) {
                $ids[] = $childId;
                $stack[] = $childId;
            }
        }

        return array_values(array_unique($ids));
    }
}

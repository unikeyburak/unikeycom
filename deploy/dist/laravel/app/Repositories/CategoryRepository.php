<?php

namespace App\Repositories;

use App\Models\Category;
use App\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * Constructor
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Get root categories
     */
    public function getRootCategories(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model
            ->with($relations)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get($columns);
    }

    /**
     * Get categories with product count
     */
    public function getCategoriesWithProductCount(): Collection
    {
        $hasPivot = \Illuminate\Support\Facades\Schema::hasTable('category_product');

        $query = $this->model
            ->select(['id', 'name', 'slug', 'parent_id', 'status'])
            ->where('status', 'active')
            ->with('translations');

        if ($hasPivot) {
            // Pivot tablo varsa oradan say (syncCategories tum kategorileri pivot'a yazar)
            $query->withCount(['allProducts as products_count' => function ($query) {
                $query->where('products.status', 'active');
            }]);
        } else {
            // Pivot yoksa FK'den say
            $query->withCount(['products as products_count' => function ($query) {
                $query->where('status', 'active');
            }]);
        }

        $categories = $query->get();

        $categoriesById = $categories->keyBy('id');

        foreach ($categories as $category) {
            $count = (int) $category->products_count;
            $parentId = $category->parent_id;

            while ($parentId && $categoriesById->has($parentId)) {
                $parent = $categoriesById->get($parentId);
                $parent->products_count += $count;
                $parentId = $parent->parent_id;
            }
        }

        return $categories
            ->whereNull('parent_id')
            ->sortBy('name')
            ->values();
    }

    /**
     * Get subcategories
     */
    public function getSubcategories(int $parentId): Collection
    {
        return $this->model
            ->where('parent_id', $parentId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get category tree
     */
    public function getCategoryTree(): Collection
    {
        return $this->model
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    /**
     * Find category by slug
     */
    public function findBySlug(string $slug): ?object
    {
        return $this->model
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get active categories
     */
    public function getActiveCategories(): Collection
    {
        return $this->model
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }
}

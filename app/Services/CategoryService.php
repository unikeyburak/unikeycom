<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * Constructor
     */
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    /**
     * Get all categories
     */
    public function getAllCategories(): Collection
    {
        return Cache::remember('all_categories', 3600, function () {
            return $this->categoryRepository->all(['*'], ['children']);
        });
    }

    /**
     * Get root categories
     */
    public function getRootCategories(): Collection
    {
        return Cache::remember('root_categories', 3600, function () {
            return $this->categoryRepository->getRootCategories();
        });
    }

    /**
     * Get categories with product count
     */
    public function getCategoriesWithProductCount(): Collection
    {
        return Cache::remember('categories_with_count_' . app()->getLocale(), 3600, function () {
            return $this->categoryRepository->getCategoriesWithProductCount();
        });
    }

    /**
     * Get category by ID
     */
    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->find($id, ['*'], ['children', 'products']);
    }

    /**
     * Get category by slug
     */
    public function getCategoryBySlug(string $slug): ?Category
    {
        return Cache::remember("category_slug_{$slug}", 3600, function () use ($slug) {
            return $this->categoryRepository->findBySlug($slug);
        });
    }

    /**
     * Get subcategories
     */
    public function getSubcategories(int $parentId): Collection
    {
        return Cache::remember("subcategories_{$parentId}", 3600, function () use ($parentId) {
            return $this->categoryRepository->getSubcategories($parentId);
        });
    }

    /**
     * Get category tree
     */
    public function getCategoryTree(): Collection
    {
        return Cache::remember('category_tree', 3600, function () {
            return $this->categoryRepository->getCategoryTree();
        });
    }

    /**
     * Create category
     */
    public function createCategory(CategoryDTO $dto): Category
    {
        $category = $this->categoryRepository->create($dto->toArray());
        
        // Clear cache
        $this->clearCategoryCache();
        
        return $category;
    }

    /**
     * Update category
     */
    public function updateCategory(int $id, CategoryDTO $dto): bool
    {
        $result = $this->categoryRepository->update($id, $dto->toArray());
        
        if ($result) {
            // Clear cache
            $this->clearCategoryCache();
        }
        
        return $result;
    }

    /**
     * Delete category
     */
    public function deleteCategory(int $id): bool
    {
        // Check if category has products
        $category = $this->categoryRepository->find($id, ['*'], ['products']);
        
        if ($category && $category->products->count() > 0) {
            throw new \Exception('Bu kategori altında ürünler bulunmaktadır. Önce ürünleri başka bir kategoriye taşıyın.');
        }
        
        $result = $this->categoryRepository->delete($id);
        
        if ($result) {
            // Clear cache
            $this->clearCategoryCache();
        }
        
        return $result;
    }

    /**
     * Update category status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $result = $this->categoryRepository->update($id, [
            'status' => $status
        ]);
        
        if ($result) {
            $this->clearCategoryCache();
        }
        
        return $result;
    }

    /**
     * Move category
     */
    public function moveCategory(int $id, ?int $parentId): bool
    {
        $result = $this->categoryRepository->update($id, [
            'parent_id' => $parentId
        ]);
        
        if ($result) {
            $this->clearCategoryCache();
        }
        
        return $result;
    }

    /**
     * Clear category cache
     */
    private function clearCategoryCache(): void
    {
        Cache::forget('all_categories');
        Cache::forget('root_categories');
        Cache::forget('categories_with_count_tr');
        Cache::forget('categories_with_count_en');
        Cache::forget('categories_with_count_fr');
        Cache::forget('categories_with_count_ar');
        Cache::forget('category_tree');
        Cache::forget('nav_categories');
        Cache::forget('mega_menu_categories');
        Cache::forget('homepage_categories');
        Cache::forget('category_hierarchy');

        // Clear specific category caches
        $categories = $this->categoryRepository->all(['id', 'slug']);
        foreach ($categories as $category) {
            Cache::forget("category_slug_{$category->slug}");
            Cache::forget("subcategories_{$category->id}");
        }
    }
}
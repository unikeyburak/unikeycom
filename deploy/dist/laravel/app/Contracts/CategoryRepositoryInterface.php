<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get root categories
     */
    public function getRootCategories(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get categories with product count
     */
    public function getCategoriesWithProductCount(): Collection;

    /**
     * Get subcategories
     */
    public function getSubcategories(int $parentId): Collection;

    /**
     * Get category tree
     */
    public function getCategoryTree(): Collection;

    /**
     * Find category by slug
     */
    public function findBySlug(string $slug): ?object;

    /**
     * Get active categories
     */
    public function getActiveCategories(): Collection;
}
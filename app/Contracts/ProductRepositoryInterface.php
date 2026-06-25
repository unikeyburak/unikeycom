<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active products
     */
    public function getActiveProducts(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get active products with pagination
     */
    public function getActiveProductsPaginated(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8, array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get products by category
     */
    public function getByCategory(int $categoryId, int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Search products
     */
    public function searchProducts(string $query, int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Get related products
     */
    public function getRelatedProducts(
        int $productId,
        int $categoryId,
        int $limit = 4,
        array $columns = ['*'],
        array $relations = []
    ): Collection;

    /**
     * Find product by slug
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $relations = []): ?object;

    /**
     * Update product stock
     */
    public function updateStock(int $productId, int $quantity): bool;

    /**
     * Get products with low stock
     */
    public function getLowStockProducts(int $threshold = 10): Collection;
}

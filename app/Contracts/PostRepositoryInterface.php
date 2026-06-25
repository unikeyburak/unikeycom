<?php

namespace App\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get published posts with pagination
     */
    public function getPublishedPosts(
        int $perPage = 12,
        ?int $categoryId = null,
        ?int $tagId = null,
        ?string $search = null,
        array $columns = ['*'],
        array $relations = []
    ): LengthAwarePaginator;

    /**
     * Find post by slug
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $relations = []): ?Post;

    /**
     * Get featured posts
     */
    public function getFeaturedPosts(int $limit = 5, array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get popular posts by views
     */
    public function getPopularPosts(int $limit = 5, array $columns = ['*']): Collection;

    /**
     * Get related posts
     */
    public function getRelatedPosts(Post $post, int $limit = 4, array $columns = ['*']): Collection;

    /**
     * Get categories with post count
     */
    public function getCategoriesWithCount(): Collection;

    /**
     * Get tag cloud with post count
     */
    public function getTagCloud(): Collection;

    /**
     * Increment view count
     */
    public function incrementViews(Post $post): void;

    /**
     * Get posts for RSS feed
     */
    public function getRssPosts(int $limit = 20): Collection;
}

<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

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
    ): LengthAwarePaginator {
        $query = $this->model
            ->with(array_merge($relations, ['category', 'tags']))
            ->published();

        if ($categoryId) {
            $query->where('post_category_id', $categoryId);
        }

        if ($tagId) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('post_tags.id', $tagId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate($perPage, $columns);
    }

    /**
     * Find post by slug
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $relations = []): ?Post
    {
        return $this->model
            ->with(array_merge($relations, ['category', 'tags', 'creator']))
            ->where('slug', $slug)
            ->first($columns);
    }

    /**
     * Get featured posts
     */
    public function getFeaturedPosts(int $limit = 5, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model
            ->with(array_merge($relations, ['category']))
            ->published()
            ->featured()
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get popular posts by views
     */
    public function getPopularPosts(int $limit = 5, array $columns = ['*']): Collection
    {
        return $this->model
            ->with(['category'])
            ->published()
            ->orderByDesc('views')
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get related posts
     */
    public function getRelatedPosts(Post $post, int $limit = 4, array $columns = ['*']): Collection
    {
        $tagIds = $post->tags->pluck('id')->toArray();

        return $this->model
            ->with(['category', 'tags'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post, $tagIds) {
                $query->where('post_category_id', $post->post_category_id);
                if (!empty($tagIds)) {
                    $query->orWhereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('post_tags.id', $tagIds);
                    });
                }
            })
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get categories with post count
     */
    public function getCategoriesWithCount(): Collection
    {
        return PostCategory::active()
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get tag cloud with post count
     */
    public function getTagCloud(): Collection
    {
        return PostTag::withCount(['posts' => function ($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->limit(30)
            ->get();
    }

    /**
     * Increment view count
     */
    public function incrementViews(Post $post): void
    {
        $post->increment('views');
    }

    /**
     * Get posts for RSS feed
     */
    public function getRssPosts(int $limit = 20): Collection
    {
        return $this->model
            ->with(['category'])
            ->published()
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();
    }
}

<?php

namespace App\DTO;

use App\Models\Post;
use Illuminate\Http\Request;

class PostDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $postCategoryId,
        public readonly string $title,
        public readonly string $slug,
        public readonly ?string $excerpt,
        public readonly ?string $content,
        public readonly ?string $featuredImage,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly string $status = 'draft',
        public readonly bool $isFeatured = false,
        public readonly int $sortOrder = 0,
        public readonly ?string $publishedAt = null,
    ) {}

    /**
     * Create DTO from Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            postCategoryId: $request->input('post_category_id'),
            title: $request->input('title'),
            slug: $request->input('slug') ?? \Illuminate\Support\Str::slug($request->input('title')),
            excerpt: $request->input('excerpt'),
            content: $request->input('content'),
            featuredImage: $request->input('featured_image'),
            metaTitle: $request->input('meta_title'),
            metaDescription: $request->input('meta_description'),
            metaKeywords: $request->input('meta_keywords'),
            status: $request->input('status', 'draft'),
            isFeatured: $request->boolean('is_featured'),
            sortOrder: $request->integer('sort_order', 0),
            publishedAt: $request->input('published_at'),
        );
    }

    /**
     * Create DTO from Model
     */
    public static function fromModel(Post $post): self
    {
        return new self(
            id: $post->id,
            postCategoryId: $post->post_category_id,
            title: $post->title,
            slug: $post->slug,
            excerpt: $post->excerpt,
            content: $post->content,
            featuredImage: $post->featured_image,
            metaTitle: $post->meta_title,
            metaDescription: $post->meta_description,
            metaKeywords: $post->meta_keywords,
            status: $post->status,
            isFeatured: $post->is_featured,
            sortOrder: $post->sort_order,
            publishedAt: $post->published_at?->toDateTimeString(),
        );
    }

    /**
     * Convert to array for database
     */
    public function toArray(): array
    {
        $data = [
            'post_category_id' => $this->postCategoryId,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featuredImage,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'status' => $this->status,
            'is_featured' => $this->isFeatured,
            'sort_order' => $this->sortOrder,
            'published_at' => $this->publishedAt,
        ];

        if ($this->id) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}

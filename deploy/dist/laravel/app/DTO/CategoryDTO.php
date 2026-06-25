<?php

namespace App\DTO;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $parentId,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly ?string $image,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly string $status = 'active'
    ) {}

    /**
     * Create DTO from Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            parentId: $request->input('parent_id'),
            name: $request->input('name'),
            slug: $request->input('slug') ?? \Illuminate\Support\Str::slug($request->input('name')),
            description: $request->input('description'),
            image: $request->input('image'),
            metaTitle: $request->input('meta_title'),
            metaDescription: $request->input('meta_description'),
            metaKeywords: $request->input('meta_keywords'),
            status: $request->input('status', 'active')
        );
    }

    /**
     * Create DTO from Model
     */
    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            parentId: $category->parent_id,
            name: $category->name,
            slug: $category->slug,
            description: $category->description,
            image: $category->image,
            metaTitle: $category->meta_title,
            metaDescription: $category->meta_description,
            metaKeywords: $category->meta_keywords,
            status: $category->status
        );
    }

    /**
     * Convert to array for database
     */
    public function toArray(): array
    {
        $data = [
            'parent_id' => $this->parentId,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'status' => $this->status,
        ];

        if ($this->id) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
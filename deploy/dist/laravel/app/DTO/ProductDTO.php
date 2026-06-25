<?php

namespace App\DTO;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $categoryId,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $sku,
        public readonly ?string $shortDescription,
        public readonly ?string $longDescription,
        public readonly ?string $activeIngredient,
        public readonly ?string $formulation,
        public readonly ?string $usageAreas,
        public readonly ?array $technicalInfo,
        public readonly ?array $images,
        public readonly ?string $brochurePdf,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly string $status = 'active',
        public readonly bool $isFeatured = false
    ) {}

    /**
     * Create DTO from Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            categoryId: $request->input('category_id'),
            name: $request->input('name'),
            slug: $request->input('slug') ?? \Illuminate\Support\Str::slug($request->input('name')),
            sku: $request->input('sku'),
            shortDescription: $request->input('short_description'),
            longDescription: $request->input('long_description'),
            activeIngredient: $request->input('active_ingredient'),
            formulation: $request->input('formulation'),
            usageAreas: $request->input('usage_areas'),
            technicalInfo: $request->input('technical_info', []),
            images: $request->input('images', []),
            brochurePdf: $request->input('brochure_pdf'),
            metaTitle: $request->input('meta_title'),
            metaDescription: $request->input('meta_description'),
            metaKeywords: $request->input('meta_keywords'),
            status: $request->input('status', 'active'),
            isFeatured: $request->boolean('is_featured')
        );
    }

    /**
     * Create DTO from Model
     */
    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            categoryId: $product->category_id,
            name: $product->name,
            slug: $product->slug,
            sku: $product->sku,
            shortDescription: $product->short_description,
            longDescription: $product->long_description,
            activeIngredient: $product->active_ingredient,
            formulation: $product->formulation,
            usageAreas: $product->usage_areas,
            technicalInfo: $product->technical_info,
            images: $product->images,
            brochurePdf: $product->brochure_pdf,
            metaTitle: $product->meta_title,
            metaDescription: $product->meta_description,
            metaKeywords: $product->meta_keywords,
            status: $product->status,
            isFeatured: $product->is_featured
        );
    }

    /**
     * Convert to array for database
     */
    public function toArray(): array
    {
        $data = [
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'short_description' => $this->shortDescription,
            'long_description' => $this->longDescription,
            'active_ingredient' => $this->activeIngredient,
            'formulation' => $this->formulation,
            'usage_areas' => $this->usageAreas,
            'technical_info' => $this->technicalInfo,
            'images' => $this->images,
            'brochure_pdf' => $this->brochurePdf,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'status' => $this->status,
            'is_featured' => $this->isFeatured,
        ];

        if ($this->id) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
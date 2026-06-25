<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseApiController
{
    /**
     * Constructor
     */
    public function __construct(
        private CategoryService $categoryService,
        private ProductService $productService
    ) {}

    /**
     * Get all categories
     */
    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryService->getCategoriesWithProductCount();
        
        return $this->success(
            CategoryResource::collection($categories),
            'Categories retrieved successfully'
        );
    }

    /**
     * Get category details
     */
    public function show($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        
        if (!$category) {
            return $this->notFound('Category not found');
        }
        
        return $this->success(
            new CategoryResource($category),
            'Category retrieved successfully'
        );
    }

    /**
     * Get products by category
     */
    public function products(Request $request, $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        
        if (!$category) {
            return $this->notFound('Category not found');
        }
        
        $perPage = $request->get('per_page', 15);
        $products = $this->productService->getProductsByCategory($id, $perPage);
        
        return $this->paginated(
            $products,
            'Products retrieved successfully'
        );
    }
}
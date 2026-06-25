<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseApiController
{
    /**
     * Constructor
     */
    public function __construct(
        private ProductService $productService
    ) {}

    /**
     * Get all products
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        
        // Category filter
        if ($request->has('category_id')) {
            $products = $this->productService->getProductsByCategory(
                $request->get('category_id'),
                $perPage
            );
        } else {
            $products = $this->productService->getAllProducts($perPage);
        }
        
        return $this->paginated(
            $products,
            'Products retrieved successfully'
        );
    }

    /**
     * Get product details
     */
    public function show($id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        
        if (!$product || $product->status !== 'active') {
            return $this->notFound('Product not found');
        }
        
        return $this->success(
            new ProductDetailResource($product),
            'Product retrieved successfully'
        );
    }

    /**
     * Search products
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);
        
        $perPage = $request->get('per_page', 15);
        $products = $this->productService->searchProducts(
            $request->get('q'),
            $perPage
        );
        
        return $this->paginated(
            $products,
            'Search results retrieved successfully'
        );
    }
}
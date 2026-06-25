<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use App\Services\OrderService;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseApiController
{
    /**
     * Constructor
     */
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Get dealer orders
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status');
        
        $orders = $this->orderService->getDealerOrders(
            $user->dealer_id,
            $perPage,
            $status
        );
        
        return $this->paginated(
            $orders,
            'Orders retrieved successfully'
        );
    }

    /**
     * Create order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $user = $request->user();
        
        try {
            $order = $this->orderService->createOrder(
                $user->dealer_id,
                $request->validated()
            );
            
            return $this->created(
                new OrderDetailResource($order),
                'Order created successfully'
            );
            
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get order details
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $order = $this->orderService->getOrderById($id);
        
        if (!$order || $order->dealer_id !== $user->dealer_id) {
            return $this->notFound('Order not found');
        }
        
        return $this->success(
            new OrderDetailResource($order),
            'Order retrieved successfully'
        );
    }

    /**
     * Update order
     */
    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        $user = $request->user();
        $order = $this->orderService->getOrderById($id);
        
        if (!$order || $order->dealer_id !== $user->dealer_id) {
            return $this->notFound('Order not found');
        }
        
        if (!in_array($order->status, ['pending', 'processing'])) {
            return $this->error('Order cannot be updated in current status');
        }
        
        try {
            $updated = $this->orderService->updateOrder($id, $request->validated());
            
            if (!$updated) {
                return $this->error('Failed to update order');
            }
            
            $order = $this->orderService->getOrderById($id);
            
            return $this->success(
                new OrderDetailResource($order),
                'Order updated successfully'
            );
            
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $order = $this->orderService->getOrderById($id);
        
        if (!$order || $order->dealer_id !== $user->dealer_id) {
            return $this->notFound('Order not found');
        }
        
        if (!in_array($order->status, ['pending', 'processing'])) {
            return $this->error('Order cannot be cancelled in current status');
        }
        
        try {
            $cancelled = $this->orderService->cancelOrder($id, 'Cancelled by dealer');
            
            if (!$cancelled) {
                return $this->error('Failed to cancel order');
            }
            
            return $this->success(null, 'Order cancelled successfully');
            
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
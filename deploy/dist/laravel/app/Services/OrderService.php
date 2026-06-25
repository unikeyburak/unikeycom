<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Get dealer orders
     */
    public function getDealerOrders(int $dealerId, int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        $query = Order::with(['items.product'])
            ->where('dealer_id', $dealerId);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->latest()->paginate($perPage);
    }

    /**
     * Get order by ID
     */
    public function getOrderById(int $id): ?Order
    {
        return Order::with(['dealer', 'items.product'])->find($id);
    }

    /**
     * Create order
     */
    public function createOrder(int $dealerId, array $data): Order
    {
        return DB::transaction(function () use ($dealerId, $data) {
            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            
            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'dealer_id' => $dealerId,
                'status' => 'pending',
                'order_date' => now(),
                'notes' => $data['notes'] ?? null
            ]);
            
            // Create order items
            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => 0, // Price will be set by admin
                    'total_price' => 0,
                    'notes' => $item['notes'] ?? null
                ]);
                
                $totalAmount += $orderItem->total_price;
            }
            
            // Update total amount
            $order->update(['total_amount' => $totalAmount]);
            
            return $order->load(['items.product']);
        });
    }

    /**
     * Update order
     */
    public function updateOrder(int $id, array $data): bool
    {
        $order = Order::find($id);
        
        if (!$order) {
            return false;
        }
        
        return DB::transaction(function () use ($order, $data) {
            // Update notes if provided
            if (isset($data['notes'])) {
                $order->update(['notes' => $data['notes']]);
            }
            
            // Update items if provided
            if (isset($data['items'])) {
                // Delete existing items
                $order->items()->delete();
                
                // Create new items
                $totalAmount = 0;
                foreach ($data['items'] as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    
                    $orderItem = $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'quantity' => $item['quantity'],
                        'unit_price' => 0, // Price will be set by admin
                        'total_price' => 0,
                        'notes' => $item['notes'] ?? null
                    ]);
                    
                    $totalAmount += $orderItem->total_price;
                }
                
                // Update total amount
                $order->update(['total_amount' => $totalAmount]);
            }
            
            return true;
        });
    }

    /**
     * Cancel order
     */
    public function cancelOrder(int $id, string $reason): bool
    {
        $order = Order::find($id);
        
        if (!$order) {
            return false;
        }
        
        return $order->update([
            'status' => 'cancelled',
            'cancelled_date' => now(),
            'cancellation_reason' => $reason
        ]);
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(int $id, string $status, ?string $internalNotes = null): bool
    {
        $order = Order::find($id);
        
        if (!$order) {
            return false;
        }
        
        $updateData = ['status' => $status];
        
        // Set status dates
        switch ($status) {
            case 'approved':
                $updateData['approved_date'] = now();
                break;
            case 'shipped':
                $updateData['shipped_date'] = now();
                break;
            case 'delivered':
                $updateData['delivered_date'] = now();
                break;
            case 'cancelled':
                $updateData['cancelled_date'] = now();
                break;
        }
        
        if ($internalNotes) {
            $updateData['internal_notes'] = $internalNotes;
        }
        
        return $order->update($updateData);
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'dealer' => new DealerResource($this->whenLoaded('dealer')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'order_date' => $this->order_date?->toIso8601String(),
            'approved_date' => $this->approved_date?->toIso8601String(),
            'shipped_date' => $this->shipped_date?->toIso8601String(),
            'delivered_date' => $this->delivered_date?->toIso8601String(),
            'cancelled_date' => $this->cancelled_date?->toIso8601String(),
            'cancellation_reason' => $this->cancellation_reason,
            'notes' => $this->notes,
            'internal_notes' => $this->when($request->user()?->type === 'admin', $this->internal_notes),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\DealerService;
use App\Http\Resources\DealerResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DealerController extends BaseApiController
{
    /**
     * Constructor
     */
    public function __construct(
        private DealerService $dealerService
    ) {}

    /**
     * Get dealer profile
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();
        $dealer = $this->dealerService->getDealerById($user->dealer_id);
        
        if (!$dealer) {
            return $this->notFound('Dealer not found');
        }
        
        return $this->success(
            new DealerResource($dealer),
            'Dealer profile retrieved successfully'
        );
    }

    /**
     * Update dealer profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'sometimes|string|max:20',
            'website' => 'sometimes|nullable|string|max:255',
            'address' => 'sometimes|string',
            'about' => 'sometimes|nullable|string',
            'working_hours' => 'sometimes|nullable|array',
            'social_media' => 'sometimes|nullable|array'
        ]);
        
        $user = $request->user();
        $updated = $this->dealerService->updateDealer(
            $user->dealer_id,
            $request->only([
                'phone', 'website', 'address', 'about', 
                'working_hours', 'social_media'
            ])
        );
        
        if (!$updated) {
            return $this->error('Failed to update dealer profile');
        }
        
        $dealer = $this->dealerService->getDealerById($user->dealer_id);
        
        return $this->success(
            new DealerResource($dealer),
            'Dealer profile updated successfully'
        );
    }
}
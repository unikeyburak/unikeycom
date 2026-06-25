<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Dealer;
use App\Models\ApiToken;
use App\Services\DealerService;
use App\DTO\DealerDTO;
use App\Http\Resources\UserResource;
use App\Http\Resources\ApiTokenResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterDealerRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends BaseApiController
{
    /**
     * Constructor
     */
    public function __construct(
        private DealerService $dealerService
    ) {}

    /**
     * Login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->unauthorized('Invalid credentials');
        }

        if (!$user->dealer_id) {
            return $this->forbidden('Only dealers can access the API');
        }

        // Check dealer status
        $dealer = Dealer::find($user->dealer_id);
        if (!$dealer || $dealer->status !== 'active') {
            return $this->forbidden('Dealer account is not active');
        }

        // Create API token
        $token = Str::random(80);
        $apiToken = ApiToken::create([
            'dealer_id' => $dealer->id,
            'name' => 'API Access - ' . now()->format('Y-m-d H:i:s'),
            'token' => hash('sha256', $token),
            'abilities' => ['*'],
            'created_by' => $user->id,
            'last_used_at' => now(),
            'last_used_ip' => $request->ip()
        ]);

        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Login successful');
    }

    /**
     * Register dealer
     */
    public function register(RegisterDealerRequest $request): JsonResponse
    {
        try {
            // Create dealer application
            $dealerDTO = DealerDTO::fromRequest($request);
            $dealer = $this->dealerService->createDealerApplication($dealerDTO);

            return $this->created([
                'dealer' => $dealer
            ], 'Dealer application submitted successfully. We will review your application and contact you soon.');

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();
        if ($token) {
            ApiToken::where('token', hash('sha256', $token))->delete();
        }

        return $this->success(null, 'Logged out successfully');
    }

    /**
     * Get current user
     */
    public function me(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()),
            'User retrieved successfully'
        );
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20'
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'phone']));

        return $this->success(
            new UserResource($user),
            'Profile updated successfully'
        );
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->validationError([
                'current_password' => ['Current password is incorrect']
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->success(null, 'Password changed successfully');
    }

    /**
     * Get API tokens
     */
    public function tokens(Request $request): JsonResponse
    {
        $user = $request->user();
        $tokens = ApiToken::where('dealer_id', $user->dealer_id)
            ->where('status', 'active')
            ->latest()
            ->get();

        return $this->success(
            ApiTokenResource::collection($tokens),
            'Tokens retrieved successfully'
        );
    }

    /**
     * Create API token
     */
    public function createToken(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'abilities' => 'sometimes|array',
            'expires_at' => 'sometimes|date|after:now'
        ]);

        $user = $request->user();
        $token = Str::random(80);

        $apiToken = ApiToken::create([
            'dealer_id' => $user->dealer_id,
            'name' => $request->name,
            'token' => hash('sha256', $token),
            'abilities' => $request->abilities ?? ['*'],
            'expires_at' => $request->expires_at,
            'created_by' => $user->id
        ]);

        return $this->created([
            'token' => $token,
            'token_info' => new ApiTokenResource($apiToken)
        ], 'Token created successfully');
    }

    /**
     * Revoke API token
     */
    public function revokeToken(Request $request, $tokenId): JsonResponse
    {
        $user = $request->user();
        $token = ApiToken::where('dealer_id', $user->dealer_id)
            ->where('id', $tokenId)
            ->first();

        if (!$token) {
            return $this->notFound('Token not found');
        }

        $token->update([
            'status' => 'revoked',
            'revoked_by' => $user->id,
            'revoked_at' => now(),
            'revocation_reason' => 'Revoked by user'
        ]);

        return $this->success(null, 'Token revoked successfully');
    }
}
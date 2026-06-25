<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Models\DealerUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return $this->unauthorizedResponse('Token not provided');
        }
        
        // Find and validate token
        $apiToken = ApiToken::findByToken($token);
        
        if (!$apiToken) {
            return $this->unauthorizedResponse('Invalid token');
        }
        
        // Validate token access
        if (!$apiToken->validateAccess()) {
            return $this->unauthorizedResponse('Token access denied');
        }
        
        // Get the dealer's primary user
        $dealerUser = DealerUser::where('dealer_id', $apiToken->dealer_id)
            ->where('role', 'owner')
            ->where('is_active', true)
            ->first();
        
        if (!$dealerUser) {
            return $this->unauthorizedResponse('User not found');
        }
        
        // Check dealer status
        $dealer = $dealerUser->dealer;
        if (!$dealer || !$dealer->is_active || !$dealer->is_verified) {
            return $this->unauthorizedResponse('Dealer access denied');
        }
        
        // Log API usage
        $this->logApiUsage($apiToken, $request);
        
        // Set authenticated user and token
        $request->setUserResolver(function () use ($dealerUser) {
            return $dealerUser;
        });
        
        // Add token to request for later use
        $request->attributes->set('api_token', $apiToken);
        
        return $next($request);
    }
    
    /**
     * Return unauthorized response
     */
    private function unauthorizedResponse(string $message): Response
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => 'UNAUTHORIZED'
        ], 401);
    }
    
    /**
     * Log API usage
     */
    private function logApiUsage(ApiToken $apiToken, Request $request): void
    {
        Log::channel('api')->info('API Token Used', [
            'token_id' => $apiToken->id,
            'dealer_id' => $apiToken->dealer_id,
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
    }
}
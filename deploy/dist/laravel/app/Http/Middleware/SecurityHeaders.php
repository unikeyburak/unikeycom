<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Güvenlik başlıklarını response'a ekler
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin/Filament panelinde CSP gereksiz — Filament kendi asset'lerini yönetir
        $path = $request->path();
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'filament') || str_starts_with($path, 'livewire')) {
            return $next($request);
        }

        $response = $next($request);
        
        // Temel güvenlik başlıkları
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // HTTPS zorlaması (production'da)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        // Content Security Policy (CSP)
        $csp = $this->generateCSP();
        $response->headers->set('Content-Security-Policy', $csp);
        
        // Permissions Policy (eski Feature Policy)
        $permissions = $this->generatePermissionsPolicy();
        $response->headers->set('Permissions-Policy', $permissions);
        
        // Server bilgisini gizle
        $response->headers->remove('X-Powered-By');
        
        return $response;
    }
    
    /**
     * Content Security Policy oluştur
     */
    private function generateCSP(): string
    {
        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: https: blob:",
            "connect-src 'self'",
            "media-src 'self'",
            "object-src 'self'",
            "frame-src 'self' https://www.google.com https://maps.google.com https://www.google.com.tr https://www.youtube.com https://youtube.com https://www.youtube-nocookie.com",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests"
        ];
        
        return implode('; ', $directives);
    }
    
    /**
     * Permissions Policy oluştur
     */
    private function generatePermissionsPolicy(): string
    {
        $policies = [
            'geolocation=()',
            'microphone=()',
            'camera=()',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()'
        ];
        
        return implode(', ', $policies);
    }
}

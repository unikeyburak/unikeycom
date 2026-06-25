<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Tehlikeli karakterleri temizlemek için kullanılacak liste
     */
    protected $dangerousTags = [
        '<script', '</script>',
        '<iframe', '</iframe>',
        '<object', '</object>',
        '<embed', '</embed>',
        '<applet', '</applet>',
        '<meta', '</meta>',
        '<link',
        'javascript:',
        'vbscript:',
        'onload=',
        'onerror=',
        'onclick=',
        'onmouseover=',
        'onfocus=',
        'onblur=',
        'onchange=',
        'onsubmit=',
        'style=',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin/Filament panelinde sanitize etme — Filament kendi güvenliğini sağlar
        $path = $request->path();
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'filament') || str_starts_with($path, 'livewire')) {
            return $next($request);
        }

        // Sadece form gönderen isteklerde sanitize et (GET isteklerinde gereksiz)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $this->sanitizeInputs($request);
        }

        return $next($request);
    }
    
    /**
     * Request input'larını temizle
     */
    protected function sanitizeInputs(Request $request): void
    {
        $inputs = $request->all();
        
        array_walk_recursive($inputs, function (&$value) {
            if (is_string($value)) {
                // XSS koruması için tehlikeli tagları kaldır
                $value = $this->removeDangerousTags($value);
                
                // Null byte karakterini kaldır
                $value = str_replace(chr(0), '', $value);
                
                // Control karakterlerini kaldır (tab ve newline hariç)
                $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
            }
        });
        
        $request->merge($inputs);
    }
    
    /**
     * Tehlikeli tagları ve attributeleri kaldır
     */
    protected function removeDangerousTags(string $value): string
    {
        // Case-insensitive olarak tehlikeli tagları kaldır
        foreach ($this->dangerousTags as $tag) {
            $value = preg_replace('/' . preg_quote($tag, '/') . '/i', '', $value);
        }
        
        return $value;
    }
}
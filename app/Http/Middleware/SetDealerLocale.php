<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetDealerLocale
{
    /**
     * Bayi tercih ettiği dili ayarlar
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Varsayılan dil Türkçe
        App::setLocale('tr');
        
        // Session'da dil tercihi varsa kullan
        if ($locale = session('dealer_locale')) {
            App::setLocale($locale);
        }
        
        // Giriş yapmış kullanıcının dil tercihi varsa kullan
        elseif (Auth::guard('dealer')->check()) {
            $dealerUser = Auth::guard('dealer')->user();
            if ($dealerUser->preferred_language) {
                App::setLocale($dealerUser->preferred_language);
                session(['dealer_locale' => $dealerUser->preferred_language]);
            }
        }
        
        return $next($request);
    }
}

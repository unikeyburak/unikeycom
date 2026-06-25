<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDealerStatus
{
    /**
     * Bayi durumunu kontrol eder
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Bayi kullanıcısı giriş yapmış mı kontrol et
        if (!Auth::guard('dealer')->check()) {
            return redirect()->route('dealer.login')
                ->with('error', 'Bu sayfaya erişmek için giriş yapmalısınız.');
        }
        
        $dealerUser = Auth::guard('dealer')->user();
        $dealer = $dealerUser->dealer;
        
        // Bayi kullanıcısı aktif mi?
        if (!$dealerUser->is_active) {
            Auth::guard('dealer')->logout();
            return redirect()->route('dealer.login')
                ->with('error', 'Hesabınız devre dışı bırakılmış. Lütfen yönetici ile iletişime geçin.');
        }
        
        // Bayi aktif mi?
        if (!$dealer->is_active) {
            Auth::guard('dealer')->logout();
            return redirect()->route('dealer.login')
                ->with('error', 'Bayi hesabınız devre dışı. Lütfen yönetici ile iletişime geçin.');
        }
        
        // Bayi onaylanmış mı?
        if (!$dealer->is_verified) {
            Auth::guard('dealer')->logout();
            return redirect()->route('dealer.login')
                ->with('error', 'Bayi hesabınız henüz onaylanmamış. Onay sürecinin tamamlanmasını bekleyin.');
        }
        
        return $next($request);
    }
}

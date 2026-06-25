<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Cloudflare/proxy arkasında gerçek istemci IP'si, host ve şema (https)
        // X-Forwarded-* başlıklarından okunur. Bu olmadan request()->url()
        // http döner ve canonical ≠ hreflang olur (Google hreflang'i düşürür).
        // NOT: Güvenlik için origin yalnızca Cloudflare'e açıksa '*' uygundur;
        // değilse 'at:' parametresini Cloudflare IP aralıklarıyla sınırlayın.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'auth:api' => \App\Http\Middleware\ApiAuthentication::class,
            'dealer.check' => \App\Http\Middleware\CheckDealerStatus::class,
            'dealer.locale' => \App\Http\Middleware\SetDealerLocale::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'sanitize.input' => \App\Http\Middleware\SanitizeInput::class,
            'cache.public' => \App\Http\Middleware\CachePublicPages::class,
        ]);

        // Web middleware grubuna ekle
        // CachePublicPages EN BAŞTA - cache hit olursa diğerleri çalışmaz
        $middleware->web(prepend: [
            \App\Http\Middleware\CachePublicPages::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SanitizeInput::class,
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // API middleware grubuna input sanitization ekle
        $middleware->api(append: [
            \App\Http\Middleware\SanitizeInput::class,
        ]);
        
        // Bayi rotaları için middleware grubu
        $middleware->group('dealer', [
            'web',
            'auth:dealer',
            'dealer.check',
            'dealer.locale',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

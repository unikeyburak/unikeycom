<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Cookie;

class SetLocale
{
    private string $localeCookieName;
    private string $directionCookieName;
    private int $cookieMinutes;

    public function __construct()
    {
        $this->localeCookieName = (string) config('app.locale_cookie', 'site_locale');
        $this->directionCookieName = (string) config('app.direction_cookie', 'site_direction');
        $this->cookieMinutes = (int) config('app.locale_cookie_minutes', 43200);
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Admin/Filament/Livewire rotalarında dil algılama gereksiz — direkt varsayılan kullan
        $path = $request->path();
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'filament') || str_starts_with($path, 'livewire')) {
            $locale = config('app.locale', 'tr');
            App::setLocale($locale);
            $request->attributes->set('direction', 'ltr');
            $request->attributes->set('locale', $locale);
            return $next($request);
        }

        // Aktif dilleri cache'le (her istekte DB sorgusu yapma)
        $availableLocales = Cache::remember('available_locales', 3600, function () {
            return Language::where('is_active', true)->pluck('code')->toArray();
        });

        // URL'den dil kodunu al
        $urlSegment = $request->segment(1);

        // Eğer URL'de geçerli bir dil kodu varsa
        if (in_array($urlSegment, $availableLocales)) {
            $locale = $urlSegment;
        }
        // Cookie'de dil varsa
        elseif ($request->cookies->has($this->localeCookieName)
            && in_array($request->cookies->get($this->localeCookieName), $availableLocales)) {
            $locale = $request->cookies->get($this->localeCookieName);
        }
        // Accept-Language header'dan algıla (GeoIP yerine - anında, 0ms)
        else {
            $locale = $this->detectFromAcceptLanguage($request, $availableLocales);

            // Hiçbiri yoksa varsayılan dili kullan
            if (!$locale) {
                $locale = Cache::remember('default_locale', 3600, function () {
                    $defaultLang = Language::getDefault();
                    return $defaultLang ? $defaultLang->code : 'tr';
                });
            }
        }

        // Dili ayarla
        App::setLocale($locale);

        // RTL desteği - language bilgisini cache'le
        $languageDirections = Cache::remember('language_directions', 3600, function () {
            return Language::where('is_active', true)->pluck('direction', 'code')->toArray();
        });
        $direction = ($languageDirections[$locale] ?? 'ltr') === 'rtl' ? 'rtl' : 'ltr';

        // View için request attribute'ları
        $request->attributes->set('direction', $direction);
        $request->attributes->set('locale', $locale);

        $response = $next($request);

        $this->applyLocaleCookies($request, $response, $locale, $direction);

        return $response;
    }

    /**
     * Accept-Language header'dan dil algıla
     */
    private function detectFromAcceptLanguage(Request $request, array $availableLocales): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        if (!$acceptLanguage) {
            return null;
        }

        $languages = [];
        foreach (explode(',', $acceptLanguage) as $pair) {
            $parts = explode(';', $pair);
            $lang = strtolower(trim(substr(trim($parts[0]), 0, 2)));
            $quality = 1.0;
            if (isset($parts[1])) {
                preg_match('/q=([0-9.]+)/', $parts[1], $matches);
                $quality = isset($matches[1]) ? (float) $matches[1] : 1.0;
            }
            $languages[$lang] = $quality;
        }

        arsort($languages);

        foreach ($languages as $lang => $quality) {
            if (in_array($lang, $availableLocales)) {
                return $lang;
            }
        }

        return null;
    }

    /**
     * Locale ve direction cookie'lerini ayarla
     */
    private function applyLocaleCookies(Request $request, $response, string $locale, string $direction): void
    {
        $currentLocale = $request->cookies->get($this->localeCookieName);
        $currentDirection = $request->cookies->get($this->directionCookieName);

        if ($currentLocale !== $locale) {
            $response->headers->setCookie($this->makeCookie($this->localeCookieName, $locale));
        }

        if ($currentDirection !== $direction) {
            $response->headers->setCookie($this->makeCookie($this->directionCookieName, $direction));
        }
    }

    /**
     * Cookie üret
     */
    private function makeCookie(string $name, string $value): Cookie
    {
        $expires = now()->addMinutes($this->cookieMinutes);

        return Cookie::create(
            $name,
            $value,
            $expires,
            '/',
            config('session.domain'),
            (bool) config('session.secure'),
            false,
            false,
            config('session.same_site', 'lax')
        );
    }
}

<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('locale_default')) {
    /**
     * Varsayılan dil kodunu döndürür (URL prefix almayan dil).
     */
    function locale_default(): string
    {
        return config('localized-routes.default', 'en');
    }
}

if (!function_exists('lroute')) {
    /**
     * Mevcut dile göre lokalize URL üretir.
     *
     * Kullanım:
     *   lroute('about')                   → /about-us (EN) | /tr/hakkimizda (TR)
     *   lroute('products.show', $slug)    → /product/{slug} (EN) | /tr/urun/{slug} (TR)
     *   lroute('about', [], 'fr')         → /fr/a-propos
     *
     * @param  string       $name    Route adı (locale prefix olmadan)
     * @param  array|mixed  $params  Route parametreleri
     * @param  string|null  $locale  Dil kodu (null = mevcut dil)
     * @return string
     */
    function lroute(string $name, $params = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = locale_default();

        // Varsayılan dil için prefix olmadan route adı kullan
        $routeName = ($locale === $defaultLocale) ? $name : "{$locale}.{$name}";

        if (Route::has($routeName)) {
            return route($routeName, $params);
        }

        // Locale-spesifik route yoksa varsayılan dile dön
        if (Route::has($name)) {
            return route($name, $params);
        }

        return url('/');
    }
}

if (!function_exists('lroute_for_locale')) {
    /**
     * Mevcut sayfanın belirtilen dildeki URL'sini döndürür.
     * Dil değiştirici için kullanılır.
     *
     * Kullanım:
     *   lroute_for_locale('tr')  → /tr/hakkimizda (about sayfasındayken)
     *   lroute_for_locale('en')  → /about-us (aynı sayfadan)
     *
     * @param  string $targetLocale  Hedef dil kodu
     * @return string
     */
    function lroute_for_locale(string $targetLocale): string
    {
        try {
            $currentRoute = Route::current();
            if (!$currentRoute) {
                return lroute_home($targetLocale);
            }

            $currentName = $currentRoute->getName() ?? '';
            $currentParams = $currentRoute->parameters();
            $defaultLocale = locale_default();

            // Mevcut route adından locale prefix'ini temizle (örn: 'tr.about' → 'about')
            $baseName = preg_replace('/^[a-z]{2}\./', '', $currentName);

            if (!$baseName) {
                return lroute_home($targetLocale);
            }

            // Hedef locale için route adını oluştur
            $targetName = ($targetLocale === $defaultLocale)
                ? $baseName
                : "{$targetLocale}.{$baseName}";

            if (Route::has($targetName)) {
                return route($targetName, $currentParams);
            }

            // Fallback: hedef dilin ana sayfası
            return lroute_home($targetLocale);

        } catch (\Exception $e) {
            return lroute_home($targetLocale);
        }
    }
}

if (!function_exists('lroute_home')) {
    /**
     * Belirtilen dilin ana sayfa URL'sini döndürür.
     */
    function lroute_home(string $locale): string
    {
        $defaultLocale = locale_default();
        $homeName = ($locale === $defaultLocale) ? 'home' : "{$locale}.home";

        if (Route::has($homeName)) {
            return route($homeName);
        }

        return $locale === $defaultLocale ? url('/') : url("/{$locale}");
    }
}

if (!function_exists('breadcrumb_schema')) {
    /**
     * Google BreadcrumbList JSON-LD verisi üretir.
     *
     * Kullanım:
     *   breadcrumb_schema([
     *       ['name' => __('Ana Sayfa'), 'url' => lroute('home')],
     *       ['name' => $category->translate('name'), 'url' => lroute('products.category', $category->slug)],
     *       ['name' => $product->translate('name')], // son öğe: mevcut sayfa, url'siz
     *   ]);
     *
     * @param  array $crumbs  Her biri ['name' => string, 'url' => ?string]
     * @return array          schema.org BreadcrumbList dizisi
     */
    function breadcrumb_schema(array $crumbs): array
    {
        $items    = [];
        $position = 1;

        foreach ($crumbs as $crumb) {
            if (empty($crumb['name'])) {
                continue;
            }

            $item = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $crumb['name'],
            ];

            // Son (mevcut) öğenin url'i olmayabilir.
            if (!empty($crumb['url'])) {
                $item['item'] = $crumb['url'];
            }

            $items[] = $item;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}

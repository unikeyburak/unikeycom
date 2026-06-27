<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Lokalize rota helper fonksiyonlarını yükle
        // (composer dump-autoload gerekmeden çalışır)
        require_once app_path('Helpers/route-helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prod (Cloudflare/proxy arkası): url() ve route() her zaman https üretsin.
        // Böylece canonical (request()->url()) ile hreflang (route()) aynı şemada
        // olur; aksi halde scheme uyuşmazlığı Google'ın hreflang kümesini düşürür.
        if (config('app.force_https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Ürün kaydedildiğinde otomatik cache oluştur
        Product::observe(ProductObserver::class);

        // Rate limiting tanımlamaları
        $this->configureRateLimiting();

        // SMTP/mail ayarlarını admin panelden gelen değerlerle override et (koşulsuz — admin + frontend)
        $this->configureMailFromSettings();

        // Admin/Filament sayfalarında frontend verilerini yükleme (gereksiz, yavaşlatır)
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        if (str_starts_with($requestUri, '/admin') || str_starts_with($requestUri, '/filament') || str_starts_with($requestUri, '/livewire')) {
            View::share('settings', ['site_name' => '']);
            View::share('navCategories', collect());
            View::share('megaMenuCategories', collect());
            return;
        }

        // Frontend sayfaları için ayarları ve menü verilerini yükle
        $this->bootFrontend();
    }

    /**
     * Admin panelde girilen SMTP ayarlarını runtime mail config'ine uygula.
     * Host + kullanıcı doluysa .env yerine bunlar kullanılır; aksi halde .env'e düşer.
     */
    private function configureMailFromSettings(): void
    {
        try {
            $mail = Cache::remember('mail_settings', 3600, fn () =>
                Setting::whereIn('key', [
                    'mail_host', 'mail_port', 'mail_scheme', 'mail_username',
                    'mail_password', 'mail_from_address', 'mail_from_name', 'mail_to_address',
                ])->pluck('value', 'key')->toArray()
            );
        } catch (\Throwable $e) {
            return; // DB erişilemezse .env kullanılsın
        }

        if (empty($mail['mail_host']) || empty($mail['mail_username'])) {
            return; // SMTP girilmemiş → .env
        }

        $enc    = $mail['mail_scheme'] ?? 'ssl';
        $scheme = $enc === 'ssl' ? 'smtps' : null; // 465→smtps(SSL); 587→null(STARTTLS)
        $from   = ($mail['mail_from_address'] ?? '') ?: $mail['mail_username'];

        config([
            'mail.default'               => 'smtp',
            'mail.mailers.smtp.host'     => $mail['mail_host'],
            'mail.mailers.smtp.port'     => (int) ($mail['mail_port'] ?? 465),
            'mail.mailers.smtp.scheme'   => $scheme,
            'mail.mailers.smtp.username' => $mail['mail_username'],
            'mail.mailers.smtp.password' => $mail['mail_password'] ?? '',
            'mail.from.address'          => $from,
            'mail.from.name'             => ($mail['mail_from_name'] ?? '') ?: config('app.name', 'Unikeyterra'),
            'mail.to_address'            => ($mail['mail_to_address'] ?? '') ?: $from,
        ]);

        // Mailer .env config'iyle önceden çözülmüşse, yeni ayarlarla yeniden kurulsun
        \Illuminate\Support\Facades\Mail::purge('smtp');
    }

    /**
     * Frontend sayfaları için gerekli verileri yükle
     */
    private function bootFrontend(): void
    {
        // Cache'den ayarları bir kere al ve tüm view'lerle paylaş
        $settings = Cache::remember('all_settings_parsed', 3600, function () {
            try {
                $dbSettings = Setting::all()->pluck('value', 'key')->toArray();

                $jsonFields = ['header_menu', 'meta_menu', 'footer_columns', 'social_media', 'hero_slides', 'mega_menu', 'about_milestones', 'about_values', 'about_sustain_items'];
                foreach ($jsonFields as $field) {
                    if (isset($dbSettings[$field])) {
                        $dbSettings[$field] = json_decode($dbSettings[$field], true) ?? [];
                    }
                }

                $booleanFields = ['header_show_phone', 'header_show_email'];
                foreach ($booleanFields as $field) {
                    if (isset($dbSettings[$field])) {
                        $dbSettings[$field] = filter_var($dbSettings[$field], FILTER_VALIDATE_BOOLEAN);
                    }
                }

                $integerFields = ['hero_slider_autoplay'];
                foreach ($integerFields as $field) {
                    if (isset($dbSettings[$field])) {
                        $dbSettings[$field] = (int) $dbSettings[$field];
                    }
                }

                return $dbSettings;
            } catch (\Exception $e) {
                return [];
            }
        });

        $mergedSettings = array_merge([
            'site_name' => '',
            'site_description' => null,
            'site_keywords' => null,
            'site_logo' => null,
            'site_favicon' => null,
            'contact_phone' => null,
            'contact_email' => null,
            'contact_address' => null,
            'contact_address_label' => null,
            'contact_city' => null,
            'contact_postcode' => null,
            'contact_address_factory' => null,
            'contact_city_factory' => null,
            'contact_factory_label' => null,
            'map_office_title' => null,
            'map_office_embed' => null,
            'map_factory_title' => null,
            'map_factory_embed' => null,
            'header_menu' => [],
            'meta_menu' => [],
            'header_tagline' => null,
            'header_show_phone' => true,
            'header_show_email' => true,
            'header_cta_text' => null,
            'header_cta_url' => null,
            'header_meta_cta_text' => null,
            'header_meta_cta_url' => null,
            'footer_about' => null,
            'footer_columns' => [],
            'footer_copyright' => '',
            'footer_bottom_text' => null,
            'social_media' => [],
            'hero_slider_autoplay' => 6000,
            'hero_slides' => [],
            'mega_menu' => [],
        ], $settings);

        // config('app.name') her yerde DB'deki site_name'i dönsün
        if (!empty($mergedSettings['site_name'])) {
            config(['app.name' => $mergedSettings['site_name']]);
        }

        View::share('settings', $mergedSettings);

        try {
            $navCategories = Cache::remember('nav_categories', 3600, function () {
                return Category::query()
                    ->whereNull('parent_id')
                    ->where('status', 'active')
                    ->with(['children' => function ($query) {
                        $query
                            ->select(['id', 'name', 'slug', 'parent_id'])
                            ->where('status', 'active')
                            ->orderBy('name');
                    }, 'children.translations', 'translations'])
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug', 'description_plain']);
            });

            $megaMenuCategories = Cache::remember('mega_menu_categories', 3600, function () {
                $hasPivot = \Illuminate\Support\Facades\Schema::hasTable('category_product');

                $productRelation = $hasPivot ? 'allProducts' : 'products';

                return Category::query()
                    ->where('status', 'active')
                    ->with(['translations', $productRelation => function ($query) {
                        $query->where('products.status', 'active')
                              ->whereNotNull('products.images')
                              ->select('products.id', 'products.name', 'products.slug', 'products.images', 'products.category_id')
                              ->latest('products.created_at');
                    }])
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug', 'parent_id', 'description_plain']);
            });
        } catch (\Exception $e) {
            $navCategories = collect();
            $megaMenuCategories = collect();
        }

        View::share('navCategories', $navCategories);
        View::share('megaMenuCategories', $megaMenuCategories);

        // SEO: Mevcut sayfanın tüm dillerdeki alternate URL'lerini (hreflang)
        // render anında hesaplayıp yalnızca seo-meta partial'ına paylaş.
        // Composer kullanılır çünkü Route::current() boot anında henüz yoktur.
        View::composer('partials.seo-meta', function ($view) {
            $view->with('hreflangLinks', $this->buildHreflangLinks());
            $view->with('ogLocales', $this->buildOgLocales());
        });
    }

    /**
     * Open Graph og:locale (mevcut dil) ve og:locale:alternate (diğer aktif
     * diller) değerlerini language_TERRITORY formatında üretir.
     */
    private function buildOgLocales(): array
    {
        $map = [
            'tr' => 'tr_TR', 'en' => 'en_US', 'fr' => 'fr_FR',
            'ar' => 'ar_AR', 'es' => 'es_ES', 'de' => 'de_DE',
        ];

        $current  = app()->getLocale();
        $toOg     = fn (string $code) => $map[$code] ?? ($code . '_' . strtoupper($code));
        $primary  = $toOg($current);

        try {
            $active = Cache::remember('active_languages', 3600, function () {
                return \App\Models\Language::getActive();
            });
        } catch (\Throwable $e) {
            // DB erişilemezse yalnızca mevcut dilin og:locale'i kalsın
            return ['primary' => $primary, 'alternates' => []];
        }

        $alternates = [];
        foreach ($active as $lang) {
            if ($lang->code === $current) {
                continue;
            }
            $alternates[] = $toOg($lang->code);
        }

        return [
            'primary'    => $primary,
            'alternates' => array_values(array_unique($alternates)),
        ];
    }

    /**
     * Mevcut sayfanın aktif dillerdeki alternate URL'lerini üretir (hreflang).
     *
     * Kurallar:
     *  - `meta` değişkenini EZMEZ; ayrı `hreflangLinks` değişkeni döndürür.
     *  - Hedef route gerçekten yoksa (Route::has=false) o dili ATLAR;
     *    yanlış home-fallback alternate basmaz.
     *  - Sonuna x-default ekler (varsayılan dil URL'si).
     *  - En az 2 dil yoksa boş döner (tek dilli sayfada hreflang anlamsız).
     */
    private function buildHreflangLinks(): array
    {
        $route = \Illuminate\Support\Facades\Route::current();
        if (! $route || ! $route->getName()) {
            return [];
        }

        $defaultLocale = config('localized-routes.default', 'en');
        $baseName      = preg_replace('/^[a-z]{2}\./', '', $route->getName());
        $params        = $route->parameters();

        if (! $baseName) {
            return [];
        }

        try {
            $activeLanguages = Cache::remember('active_languages', 3600, function () {
                return \App\Models\Language::getActive();
            });
        } catch (\Throwable $e) {
            return []; // DB erişilemezse hreflang'i sessizce atla (sayfa yine açılsın)
        }

        $links    = [];
        $xDefault = null;

        foreach ($activeLanguages as $lang) {
            $code       = $lang->code;
            $targetName = ($code === $defaultLocale) ? $baseName : "{$code}.{$baseName}";

            // Hedef dilde bu route yoksa yanlış alternate basmamak için atla.
            if (! \Illuminate\Support\Facades\Route::has($targetName)) {
                continue;
            }

            try {
                $href = route($targetName, $params);
            } catch (\Throwable $e) {
                continue; // parametre uyuşmazlığı vb.
            }

            $links[] = ['hreflang' => $code, 'href' => $href];

            if ($code === $defaultLocale) {
                $xDefault = $href;
            }
        }

        // Tek dilli sonuç → hreflang kümesi gereksiz.
        if (count($links) < 2) {
            return [];
        }

        $links[] = ['hreflang' => 'x-default', 'href' => $xDefault ?? $links[0]['href']];

        return $links;
    }

    /**
     * Rate limiting konfigürasyonu
     */
    protected function configureRateLimiting(): void
    {
        // API rate limiter
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
        // Authenticated API rate limiter (daha yüksek limit)
        RateLimiter::for('api:auth', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(120)->by($request->user()->id)
                : Limit::perMinute(60)->by($request->ip());
        });
        
        // Login rate limiter
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
        
        // Contact form rate limiter
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by($request->ip());
        });
        
        // Dealer registration rate limiter
        RateLimiter::for('dealer-register', function (Request $request) {
            return Limit::perDay(3)->by($request->ip());
        });
        
        // Quote request rate limiter
        RateLimiter::for('quote-request', function (Request $request) {
            return Limit::perHour(10)->by($request->user()?->id ?: $request->ip());
        });
        
        // Password reset rate limiter
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });
        
        // File upload rate limiter
        RateLimiter::for('upload', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });
    }
}

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Models\Language;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/*
|--------------------------------------------------------------------------
| Sitemap (locale prefix yok, doğrudan /sitemap.xml)
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');

/*
|--------------------------------------------------------------------------
| Cache & Optimize Route (geçici, kullandıktan sonra sil)
|--------------------------------------------------------------------------
*/
Route::get('/optimize-clear-cache-2024x', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    \Illuminate\Support\Facades\Artisan::call('view:cache');

    return response()->json([
        'status'  => 'OK',
        'message' => 'Tüm cache temizlendi ve yeniden oluşturuldu!',
        'note'    => 'Bu route\'u şimdi web.php\'den silebilirsin!',
    ]);
});

/*
|--------------------------------------------------------------------------
| Debug Rotaları (sadece local ortamda)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/debug-translations/{categoryId}', function ($categoryId) {
        $category = \App\Models\Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found']);
        }

        $translations = \App\Models\Translation::where('translatable_type', \App\Models\Category::class)
            ->where('translatable_id', $categoryId)
            ->get();

        return response()->json([
            'category_id'              => $category->id,
            'category_name_db'         => $category->name,
            'current_locale'           => app()->getLocale(),
            'session_locale'           => session('locale'),
            'translated_name_current'  => $category->translate('name'),
            'translated_name_tr'       => $category->translate('name', 'tr'),
            'translated_name_fr'       => $category->translate('name', 'fr'),
            'translated_name_en'       => $category->translate('name', 'en'),
            'all_translations_in_db'   => $translations,
        ]);
    });

    Route::get('/debug-locale', function () {
        return response()->json([
            'app_locale'     => app()->getLocale(),
            'session_locale' => session('locale'),
            'session_all'    => session()->all(),
        ]);
    });

    Route::get('/debug-megamenu', function () {
        $filePath = resource_path('views/partials/mega-menu.blade.php');
        $content  = file_get_contents($filePath);
        $settings = \App\Models\Setting::where('key', 'mega_menu')->first();

        return response()->json([
            'file_path'         => $filePath,
            'file_exists'       => file_exists($filePath),
            'has_translate_calls' => str_contains($content, "->translate('name')"),
            'mega_menu_settings'  => $settings ? json_decode($settings->value, true) : null,
        ]);
    });

    Route::get('/debug-routes', function () {
        $allRoutes = Route::getRoutes();
        $list = [];
        foreach ($allRoutes as $route) {
            $name = $route->getName();
            if ($name && !str_starts_with($name, 'filament') && !str_starts_with($name, 'livewire')) {
                $list[] = ['name' => $name, 'uri' => $route->uri(), 'methods' => $route->methods()];
            }
        }
        return response()->json($list);
    });
}

/*
|--------------------------------------------------------------------------
| Dil Değiştirme Rotası
|--------------------------------------------------------------------------
| Locale cookie'yi ayarlar ve hedef dildeki mevcut sayfaya yönlendirir.
| `to` parametresi, language-switcher.blade.php tarafından lroute_for_locale()
| ile hesaplanarak geçirilir.
|--------------------------------------------------------------------------
*/
Route::get('language/{language}', function (string $language, Request $request) {
    $languageModel = Language::where('code', $language)->where('is_active', true)->first();
    if (!$languageModel) {
        return redirect()->back();
    }

    $cookieMinutes = (int) config('app.locale_cookie_minutes', 43200);

    $localeCookie = cookie(
        config('app.locale_cookie', 'site_locale'),
        $languageModel->code,
        $cookieMinutes,
        '/',
        config('session.domain'),
        (bool) config('session.secure'),
        false,
        false,
        config('session.same_site', 'lax')
    );

    $directionCookie = cookie(
        config('app.direction_cookie', 'site_direction'),
        $languageModel->isRtl() ? 'rtl' : 'ltr',
        $cookieMinutes,
        '/',
        config('session.domain'),
        (bool) config('session.secure'),
        false,
        false,
        config('session.same_site', 'lax')
    );

    // Dil değiştirici, lokalize sayfanın URL'sini `to` parametresi olarak gönderir
    $toUrl = $request->input('to', '');

    // Güvenlik: Sadece aynı domain URL'lerine izin ver
    if ($toUrl) {
        $appUrl   = rtrim(config('app.url', ''), '/');
        $isInternalAbsolute = str_starts_with($toUrl, $appUrl . '/') || $toUrl === $appUrl;
        $isRelative         = str_starts_with($toUrl, '/');

        if ($isInternalAbsolute || $isRelative) {
            return redirect($toUrl)->withCookie($localeCookie)->withCookie($directionCookie);
        }
    }

    return redirect('/')->withCookie($localeCookie)->withCookie($directionCookie);
})->name('change.language');

/*
|--------------------------------------------------------------------------
| Eski Türkçe URL Yönlendirmeleri (301 Kalıcı)
|--------------------------------------------------------------------------
| Önceki Türkçe root-level URL'leri /tr/ prefix'li adreslerine yönlendir.
| Bu rotalar, catch-all /{slug}'dan ÖNCE tanımlanmalıdır.
|
| ÖNEMLİ: Bu blok YALNIZCA APP_LOCALE=tr DEĞİLKEN çalışır. Çünkü APP_LOCALE=tr
| ise TR zaten varsayılan dil olur ve /iletisim, /hakkimizda gibi URL'ler
| prefix'siz olarak geçerli rotalardır. Bu durumda legacy redirect çalışırsa
| kendi geçerli rotalarını 404 olan /tr/* adreslerine yönlendirerek kırar.
|--------------------------------------------------------------------------
*/
if (env('APP_LOCALE', 'en') !== 'tr') {
    $legacyTrRedirects = [
        'hakkimizda'          => '/tr/hakkimizda',
        'iletisim'            => '/tr/iletisim',
        'gizlilik-politikasi' => '/tr/gizlilik-politikasi',
        'kullanim-sartlari'   => '/tr/kullanim-sartlari',
        'urunler'             => '/tr/urunler',
        'katalog'             => '/tr/katalog',
        'bitki-besleme'       => '/tr/bitki-besleme',
        'bayiler'             => '/tr/bayiler',
    ];
    foreach ($legacyTrRedirects as $from => $to) {
        Route::redirect("/{$from}", $to, 301);
    }
    Route::redirect('/urunler/ara', '/tr/urunler/ara', 301);
}

/*
|--------------------------------------------------------------------------
| Yardımcı veriler
|--------------------------------------------------------------------------
*/
$publicStatelessMiddleware = [
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    ValidateCsrfToken::class,
];

$defaultLocale = config('localized-routes.default', 'en');

// Route kaydı için config'den dil listesini al.
// DB query kullanmıyoruz: route:cache ortamında DB bağlantısı olmayabilir,
// ve varsayılan dil (EN) DB'de aktif olmasa bile route kayıtlanmak ZORUNDA.
// Tüm yapılandırılmış diller her zaman route olarak kayıtlanır;
// UI'da gösterilip gösterilmeyeceği Language modeli ile ayrıca kontrol edilir.
$activeLocales = array_keys(config('localized-routes.slugs.about', ['en' => 'about-us']));

// Varsayılan dil her zaman listede olmalı
if (!in_array($defaultLocale, $activeLocales)) {
    array_unshift($activeLocales, $defaultLocale);
}

// Slug al — bulunamazsa İngilizce'ye düşer
$s = function (string $key, string $locale) use ($defaultLocale): string {
    $slugs = config('localized-routes.slugs');
    return $slugs[$key][$locale]
        ?? $slugs[$key][$defaultLocale]
        ?? $key;
};

/*
|--------------------------------------------------------------------------
| Lokalize Rotalar
|--------------------------------------------------------------------------
| Varsayılan dil (en) → prefix yok    : /about-us, /products, /contact ...
| Diğer diller         → locale prefix : /tr/hakkimizda, /fr/a-propos ...
|--------------------------------------------------------------------------
*/
foreach ($activeLocales as $locale) {
    $isDefault  = ($locale === $defaultLocale);
    $urlPrefix  = $isDefault ? '' : $locale;          // URL ön eki
    $namePrefix = $isDefault ? '' : $locale . '.';    // Route adı ön eki

    // Tüm public rotaları aynı prefix/name grubu altında topla
    Route::prefix($urlPrefix)->name($namePrefix)->group(function () use ($s, $locale, $publicStatelessMiddleware) {

        // ── İletişim Formu (Session + CSRF gerekir — ayrı iç grup)
        $contactSlug = $s('contact', $locale);
        Route::get($contactSlug,  [PageController::class, 'contact'])->name('contact');
        Route::post($contactSlug, [PageController::class, 'contactSubmit'])
             ->name('contact.submit')
             ->middleware('throttle:contact');

        // ── Stateless Genel Sayfalar (session/CSRF kaldırıldı — daha hızlı)
        Route::withoutMiddleware($publicStatelessMiddleware)->group(function () use ($s, $locale) {

        // Ana sayfa
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // ── Statik Sayfalar
        Route::get($s('about', $locale),   [PageController::class, 'about'])->name('about');
        Route::get($s('privacy', $locale),  [PageController::class, 'privacy'])->name('privacy');
        Route::get($s('terms', $locale),    [PageController::class, 'terms'])->name('terms');
        Route::get($s('page.show', $locale) . '/{slug}', [PageController::class, 'show'])->name('page.show');

        // ── Ürünler
        $productBase = $s('products.index', $locale);
        $productSlug = $s('products.show', $locale);
        Route::get($productBase,               [ProductController::class, 'index'])->name('products.index');
        Route::get($s('products.search', $locale), [ProductController::class, 'search'])->name('products.search');
        Route::get($productSlug . '/{slug}',    [ProductController::class, 'show'])->name('products.show');

        // ── Ürün sayfasından bülten formu (stateless, CSRF yok)
        Route::post('newsletter-signup', [PageController::class, 'contactSubmit'])
             ->name('newsletter.submit')
             ->middleware('throttle:contact');

        // ── Kataloglar
        $catalogBase   = $s('catalogs.index', $locale);
        $viewSuffix    = $s('catalogs.view.suffix', $locale);
        $downloadSuffix = $s('catalogs.download.suffix', $locale);
        Route::get($catalogBase,                                        [App\Http\Controllers\CatalogController::class, 'index'])->name('catalogs.index');
        Route::get($catalogBase . '/{slug}',                            [App\Http\Controllers\CatalogController::class, 'show'])->name('catalogs.show');
        Route::get($catalogBase . '/{slug}/' . $viewSuffix,             [App\Http\Controllers\CatalogController::class, 'viewPdf'])->name('catalogs.view');
        Route::get($catalogBase . '/{slug}/' . $downloadSuffix,         [App\Http\Controllers\CatalogController::class, 'download'])->name('catalogs.download');

        // ── Bitki Besleme Programları
        $nutritionBase    = $s('nutrition-programs.index', $locale);
        $nutritionProdSfx = $s('nutrition-programs.products.suffix', $locale);
        Route::get($nutritionBase,                                        [App\Http\Controllers\NutritionProgramController::class, 'index'])->name('nutrition-programs.index');
        Route::get($nutritionBase . '/{plant:slug}',                      [App\Http\Controllers\NutritionProgramController::class, 'plant'])->name('nutrition-programs.plant');
        Route::get($nutritionBase . '/{plant:slug}/{program:slug}',       [App\Http\Controllers\NutritionProgramController::class, 'show'])->name('nutrition-programs.show');
        Route::get($nutritionBase . '/program/{program}/' . $nutritionProdSfx, [App\Http\Controllers\NutritionProgramController::class, 'products'])->name('nutrition-programs.products');

        // ── Bayiler
        Route::get($s('dealers.index', $locale), [DealerController::class, 'index'])->name('dealers.index');

        // ── Blog
        $blogBase    = $s('blog.index', $locale);
        $searchSfx   = $s('blog.search.suffix', $locale);
        $categorySfx = $s('blog.category.suffix', $locale);
        $tagSfx      = $s('blog.tag.suffix', $locale);

        Route::get($blogBase,                                     [PostController::class, 'index'])->name('blog.index');
        Route::get($blogBase . '/' . $searchSfx,                  [PostController::class, 'search'])->name('blog.search');
        Route::get($blogBase . '/' . $categorySfx . '/{slug}',    [PostController::class, 'category'])->name('blog.category');
        Route::get($blogBase . '/' . $tagSfx . '/{slug}',         [PostController::class, 'tag'])->name('blog.tag');
        Route::get($blogBase . '/rss',                             [PostController::class, 'rss'])->name('blog.rss');
        Route::get($blogBase . '/{slug}',                          [PostController::class, 'show'])->name('blog.show');

        }); // withoutMiddleware grubu kapanır

        // ── Root-level slug — EN SONDA olmalı!
        // Stateless grupTAN DIŞARIDA: Page rootSlug contact template'i render edebilir,
        // o view session + $errors (ShareErrorsFromSession) bekler.
        Route::get('{slug}', [PageController::class, 'rootSlug'])->name('products.category');
    }); // prefix/name grubu kapanır
}

/*
|--------------------------------------------------------------------------
| Bayi Auth (Giriş yapmamış) — lokalizasyon gerekmez
|--------------------------------------------------------------------------
*/
Route::middleware('guest:dealer')->group(function () {
    Route::get('/bayi-girisi',   [DealerController::class, 'login'])->name('dealer.login');
    Route::post('/bayi-girisi',  [DealerController::class, 'loginSubmit'])->name('dealer.login.submit')->middleware('throttle:login');
    Route::get('/bayi-basvurusu',  [DealerController::class, 'register'])->name('dealer.register');
    Route::post('/bayi-basvurusu', [DealerController::class, 'registerSubmit'])->name('dealer.register.submit')->middleware('throttle:dealer-register');

    Route::get('/bayi-sifremi-unuttum',    [DealerController::class, 'forgotPassword'])->name('dealer.password.forgot');
    Route::post('/bayi-sifremi-unuttum',   [DealerController::class, 'sendResetLink'])->name('dealer.password.email')->middleware('throttle:password-reset');
    Route::get('/bayi-sifre-sifirla/{token}', [DealerController::class, 'resetPasswordForm'])->name('dealer.password.reset');
    Route::post('/bayi-sifre-sifirla',    [DealerController::class, 'resetPassword'])->name('dealer.password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Import Rotaları
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/import/wordpress',      [App\Http\Controllers\Admin\ImportController::class, 'wordpress'])->name('admin.import.wordpress');
    Route::post('/import/wordpress/api', [App\Http\Controllers\Admin\ImportController::class, 'wordpressApi'])->name('admin.import.wordpress.api');
    Route::post('/import/wordpress/csv', [App\Http\Controllers\Admin\ImportController::class, 'wordpressCsv'])->name('admin.import.wordpress.csv');
    Route::post('/import/wordpress/sql', [App\Http\Controllers\Admin\ImportController::class, 'wordpressSql'])->name('admin.import.wordpress.sql');
});

/*
|--------------------------------------------------------------------------
| Bayi Paneli (Giriş yapmış) — lokalizasyon gerekmez
|--------------------------------------------------------------------------
*/
Route::prefix('bayi')->middleware(['dealer'])->group(function () {
    Route::get('/panel', [DealerController::class, 'dashboard'])->name('dealer.dashboard');
    Route::post('/cikis', [DealerController::class, 'logout'])->name('dealer.logout');

    Route::get('/profil', [DealerController::class, 'profile'])->name('dealer.profile');
    Route::put('/profil', [DealerController::class, 'profileUpdate'])->name('dealer.profile.update');

    Route::get('/firma', [DealerController::class, 'company'])->name('dealer.company');
    Route::put('/firma', [DealerController::class, 'companyUpdate'])->name('dealer.company.update');

    Route::get('/teklifler',              [DealerController::class, 'quotes'])->name('dealer.quotes');
    Route::get('/teklifler/{quote}',      [DealerController::class, 'quotesShow'])->name('dealer.quotes.show');
    Route::put('/teklifler/{quote}/iptal', [DealerController::class, 'quotesCancel'])->name('dealer.quotes.cancel');

    Route::get('/urunler',                           [DealerController::class, 'products'])->name('dealer.products');
    Route::get('/urunler/{product:slug}',             [DealerController::class, 'productsShow'])->name('dealer.products.show');
    Route::get('/urunler/{product:slug}/teklif',      [DealerController::class, 'productsQuote'])->name('dealer.products.quote');
    Route::post('/urunler/{product:slug}/teklif',     [DealerController::class, 'productsQuoteSubmit'])->name('dealer.products.quote.submit');
});

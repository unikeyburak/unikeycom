<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Catalog;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature   = 'sitemap:generate';
    protected $description = 'Çok dilli XML sitemap dosyasını oluşturur (hreflang dahil)';

    /**
     * Tüm aktif dil kodları ve URL prefix'leri
     * Varsayılan dil (en) prefix almaz, diğerleri /{locale}/ alır
     */
    private function getLocales(): array
    {
        $slugs          = config('localized-routes.slugs', []);
        $defaultLocale  = config('localized-routes.default', 'en');

        // Tüm dil kodlarını çıkart (ilk rota girişinin key'leri)
        $allLocales = array_keys(array_values($slugs)[0] ?? ['en' => '/']);

        $locales = [];
        foreach ($allLocales as $locale) {
            $locales[$locale] = ($locale === $defaultLocale) ? '' : "/{$locale}";
        }

        return $locales; // ['en' => '', 'tr' => '/tr', 'fr' => '/fr', ...]
    }

    /**
     * Belirli bir rota için tüm dil URL'lerini üret
     */
    private function buildLocalizedUrls(string $routeBase, string $slug = ''): array
    {
        $slugMap       = config('localized-routes.slugs', []);
        $defaultLocale = config('localized-routes.default', 'en');
        $baseUrl       = rtrim(config('app.url'), '/');
        $urls          = [];

        // Rota slug haritasında bu rota varsa dil bazlı slug kullan
        if (isset($slugMap[$routeBase])) {
            foreach ($slugMap[$routeBase] as $locale => $routeSlug) {
                $prefix = ($locale === $defaultLocale) ? '' : "/{$locale}";
                $path   = $routeSlug === '/' ? '/' : "/{$routeSlug}";
                if ($slug) {
                    $path .= "/{$slug}";
                }
                $urls[$locale] = $baseUrl . $prefix . $path;
            }
        } else {
            // Haritada yoksa tüm dillere aynı URL'yi ver
            foreach (array_keys($this->getLocales()) as $locale) {
                $prefix        = ($locale === $defaultLocale) ? '' : "/{$locale}";
                $urls[$locale] = $baseUrl . $prefix . ($slug ? "/{$slug}" : '');
            }
        }

        return $urls;
    }

    /**
     * Komutu çalıştır
     */
    public function handle(): int
    {
        $this->info('Sitemap oluşturuluyor...');

        $defaultLocale = config('localized-routes.default', 'en');

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . PHP_EOL;
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml"' . PHP_EOL;
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;

        // ── Statik sayfalar
        $staticPages = [
            ['route' => 'home',                  'freq' => 'daily',   'priority' => '1.0'],
            ['route' => 'products.index',         'freq' => 'daily',   'priority' => '0.9'],
            ['route' => 'catalogs.index',         'freq' => 'weekly',  'priority' => '0.8'],
            ['route' => 'about',                  'freq' => 'monthly', 'priority' => '0.8'],
            ['route' => 'nutrition-programs.index','freq' => 'weekly',  'priority' => '0.8'],
            ['route' => 'blog.index',             'freq' => 'daily',   'priority' => '0.7'],
            ['route' => 'dealers.index',          'freq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'contact',                'freq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'privacy',                'freq' => 'yearly',  'priority' => '0.3'],
            ['route' => 'terms',                  'freq' => 'yearly',  'priority' => '0.3'],
        ];

        foreach ($staticPages as $page) {
            $urls = $this->buildLocalizedUrls($page['route']);
            $xml .= $this->createUrl(
                $urls[$defaultLocale] ?? reset($urls),
                now()->format('Y-m-d'),
                $page['freq'],
                $page['priority'],
                [],
                $urls
            );
        }

        // ── Kategoriler
        $categories = Category::where('status', 'active')->get();
        foreach ($categories as $category) {
            // Kategori URL'si products.show benzeri yapıda → catch-all route /{slug}
            $urls = [];
            foreach (array_keys($this->getLocales()) as $locale) {
                $prefix       = ($locale === $defaultLocale) ? '' : "/{$locale}";
                $urls[$locale] = rtrim(config('app.url'), '/') . $prefix . '/' . $category->slug;
            }

            $xml .= $this->createUrl(
                $urls[$defaultLocale],
                $category->updated_at->format('Y-m-d'),
                'weekly',
                '0.8',
                [],
                $urls
            );
        }

        // ── Ürünler
        $products = Product::where('status', 'active')->get();
        foreach ($products as $product) {
            $urls = $this->buildLocalizedUrls('products.show', $product->slug);

            $images = [];
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    $images[] = asset('storage/' . $image);
                }
            }

            $xml .= $this->createUrl(
                $urls[$defaultLocale],
                $product->updated_at->format('Y-m-d'),
                'weekly',
                '0.7',
                $images,
                $urls
            );
        }

        // ── Kataloglar
        $catalogs = Catalog::where('status', 'active')->get();
        foreach ($catalogs as $catalog) {
            $urls = $this->buildLocalizedUrls('catalogs.show', $catalog->slug);

            $xml .= $this->createUrl(
                $urls[$defaultLocale],
                $catalog->updated_at->format('Y-m-d'),
                'monthly',
                '0.6',
                [],
                $urls
            );
        }

        // ── Blog yazıları
        $posts = Post::where('status', 'published')->get();
        foreach ($posts as $post) {
            $baseUrl    = rtrim(config('app.url'), '/');
            $slugsMap   = config('localized-routes.slugs.blog.index', []);
            $urls       = [];

            foreach (array_keys($this->getLocales()) as $locale) {
                $prefix       = ($locale === $defaultLocale) ? '' : "/{$locale}";
                $blogSlug     = $slugsMap[$locale] ?? 'blog';
                $urls[$locale] = "{$baseUrl}{$prefix}/{$blogSlug}/{$post->slug}";
            }

            $images = [];
            if ($post->featured_image) {
                $images[] = asset('storage/' . $post->featured_image);
            }

            $xml .= $this->createUrl(
                $urls[$defaultLocale],
                $post->updated_at->format('Y-m-d'),
                'monthly',
                '0.6',
                $images,
                $urls
            );
        }

        // ── Dinamik sayfalar (Page modeli)
        $pages = Page::where('status', 'active')->get();
        foreach ($pages as $page) {
            $urls = $this->buildLocalizedUrls('page.show', $page->slug);

            $xml .= $this->createUrl(
                $urls[$defaultLocale],
                $page->updated_at->format('Y-m-d'),
                'monthly',
                '0.5',
                [],
                $urls
            );
        }

        $xml .= '</urlset>';

        // storage/app/public/sitemap.xml olarak yedek kaydet (opsiyonel)
        Storage::disk('public')->put('sitemap.xml', $xml);

        $urlCount = substr_count($xml, '<url>');
        $this->info("Sitemap başarıyla oluşturuldu: {$urlCount} URL → " . config('app.url') . '/sitemap.xml');

        return Command::SUCCESS;
    }

    /**
     * <url> XML bloğu oluştur.
     * Birden fazla dil URL'si varsa xhtml:link hreflang etiketleri eklenir.
     *
     * @param  string   $loc        Canonical (varsayılan dil) URL
     * @param  string   $lastmod    Y-m-d formatında tarih
     * @param  string   $changefreq always|hourly|daily|weekly|monthly|yearly|never
     * @param  string   $priority   0.0 – 1.0
     * @param  array    $images     Görsel URL listesi
     * @param  array    $localeUrls ['en' => '...', 'tr' => '...', ...]
     */
    private function createUrl(
        string $loc,
        string $lastmod,
        string $changefreq = 'weekly',
        string $priority   = '0.5',
        array  $images     = [],
        array  $localeUrls = []
    ): string {
        $url  = '  <url>' . PHP_EOL;
        $url .= '    <loc>' . htmlspecialchars($loc) . '</loc>' . PHP_EOL;

        // hreflang alternate linkleri
        if (!empty($localeUrls)) {
            foreach ($localeUrls as $lang => $href) {
                $url .= '    <xhtml:link rel="alternate"'
                      . ' hreflang="' . htmlspecialchars($lang) . '"'
                      . ' href="' . htmlspecialchars($href) . '"/>' . PHP_EOL;
            }
            // x-default → varsayılan dil URL'si
            $url .= '    <xhtml:link rel="alternate"'
                  . ' hreflang="x-default"'
                  . ' href="' . htmlspecialchars($loc) . '"/>' . PHP_EOL;
        }

        $url .= '    <lastmod>'    . $lastmod    . '</lastmod>'    . PHP_EOL;
        $url .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
        $url .= '    <priority>'   . $priority   . '</priority>'   . PHP_EOL;

        // Resimler
        foreach ($images as $image) {
            $url .= '    <image:image>' . PHP_EOL;
            $url .= '      <image:loc>' . htmlspecialchars($image) . '</image:loc>' . PHP_EOL;
            $url .= '    </image:image>' . PHP_EOL;
        }

        $url .= '  </url>' . PHP_EOL;

        return $url;
    }
}

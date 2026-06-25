<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap_xml', 3600, fn () => $this->build());

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function build(): string
    {
        $baseUrl       = rtrim(config('app.url'), '/');
        $defaultLocale = config('localized-routes.default', 'en');
        $slugMap       = config('localized-routes.slugs', []);
        $locales       = array_keys(array_values($slugMap)[0] ?? ['en' => '/']);

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml"' . "\n";
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // ── 1. Sabit rotalar
        foreach ($this->staticRoutes() as $item) {
            $urls = $this->buildUrls($item['route'], '', $baseUrl, $defaultLocale, $locales, $slugMap);
            $xml .= $this->entry($urls[$defaultLocale], $urls, now()->format('Y-m-d'), $item['freq'], $item['priority']);
        }

        // ── 2. Dinamik sayfalar (Page modeli)
        try {
            \App\Models\Page::where('status', 'active')
                ->orderBy('updated_at', 'desc')
                ->select(['id', 'slug', 'updated_at'])
                ->each(function ($page) use (&$xml, $baseUrl, $defaultLocale, $locales, $slugMap) {
                    $urls = $this->buildUrls('page.show', $page->slug, $baseUrl, $defaultLocale, $locales, $slugMap);
                    $xml .= $this->entry($urls[$defaultLocale], $urls, $page->updated_at->format('Y-m-d'), 'monthly', '0.6');
                });
        } catch (\Throwable $e) {
            // pages tablosu yoksa sessizce geç
        }

        // ── 3. Kategoriler
        try {
            \App\Models\Category::where('status', 'active')
                ->orderBy('updated_at', 'desc')
                ->select(['id', 'slug', 'updated_at'])
                ->each(function ($category) use (&$xml, $baseUrl, $defaultLocale, $locales) {
                    $urls = [];
                    foreach ($locales as $locale) {
                        $prefix        = ($locale === $defaultLocale) ? '' : "/{$locale}";
                        $urls[$locale] = "{$baseUrl}{$prefix}/{$category->slug}";
                    }
                    $xml .= $this->entry($urls[$defaultLocale], $urls, $category->updated_at->format('Y-m-d'), 'weekly', '0.8');
                });
        } catch (\Throwable $e) {
            // categories tablosu yoksa sessizce geç
        }

        // ── 4. Ürünler (resimlerle)
        try {
            \App\Models\Product::where('status', 'active')
                ->orderBy('updated_at', 'desc')
                ->select(['id', 'slug', 'images', 'updated_at'])
                ->each(function ($product) use (&$xml, $baseUrl, $defaultLocale, $locales, $slugMap) {
                    $urls = $this->buildUrls('products.show', $product->slug, $baseUrl, $defaultLocale, $locales, $slugMap);

                    $images = [];
                    if ($product->images && is_array($product->images)) {
                        foreach (array_slice($product->images, 0, 5) as $img) {
                            if (is_string($img) && $img !== '') {
                                $images[] = str_starts_with($img, 'http') ? $img : asset('storage/' . $img);
                            }
                        }
                    }

                    $xml .= $this->entry($urls[$defaultLocale], $urls, $product->updated_at->format('Y-m-d'), 'weekly', '0.7', $images);
                });
        } catch (\Throwable $e) {
            // products tablosu yoksa sessizce geç
        }

        // ── 5. Blog yazıları
        try {
            $blogSlugPerLocale = $slugMap['blog.index'] ?? [];

            \App\Models\Post::where('status', 'published')
                ->orderBy('updated_at', 'desc')
                ->select(['id', 'slug', 'featured_image', 'updated_at'])
                ->each(function ($post) use (&$xml, $baseUrl, $defaultLocale, $locales, $blogSlugPerLocale) {
                    $urls = [];
                    foreach ($locales as $locale) {
                        $prefix        = ($locale === $defaultLocale) ? '' : "/{$locale}";
                        $blogSegment   = $blogSlugPerLocale[$locale] ?? 'blog';
                        $urls[$locale] = "{$baseUrl}{$prefix}/{$blogSegment}/{$post->slug}";
                    }

                    $images = [];
                    if (!empty($post->featured_image)) {
                        $images[] = str_starts_with($post->featured_image, 'http')
                            ? $post->featured_image
                            : asset('storage/' . $post->featured_image);
                    }

                    $xml .= $this->entry($urls[$defaultLocale], $urls, $post->updated_at->format('Y-m-d'), 'monthly', '0.6', $images);
                });
        } catch (\Throwable $e) {
            // posts tablosu yoksa sessizce geç
        }

        // ── 6. Kataloglar
        try {
            \App\Models\Catalog::where('status', 'active')
                ->orderBy('updated_at', 'desc')
                ->select(['id', 'slug', 'updated_at'])
                ->each(function ($catalog) use (&$xml, $baseUrl, $defaultLocale, $locales, $slugMap) {
                    $urls = $this->buildUrls('catalogs.show', $catalog->slug, $baseUrl, $defaultLocale, $locales, $slugMap);
                    $xml .= $this->entry($urls[$defaultLocale], $urls, $catalog->updated_at->format('Y-m-d'), 'monthly', '0.5');
                });
        } catch (\Throwable $e) {
            // catalogs tablosu yoksa sessizce geç
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function staticRoutes(): array
    {
        return [
            ['route' => 'home',                    'freq' => 'daily',   'priority' => '1.0'],
            ['route' => 'products.index',           'freq' => 'daily',   'priority' => '0.9'],
            ['route' => 'catalogs.index',           'freq' => 'weekly',  'priority' => '0.8'],
            ['route' => 'about',                    'freq' => 'monthly', 'priority' => '0.8'],
            ['route' => 'nutrition-programs.index', 'freq' => 'weekly',  'priority' => '0.8'],
            ['route' => 'blog.index',               'freq' => 'daily',   'priority' => '0.7'],
            ['route' => 'dealers.index',            'freq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'contact',                  'freq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'privacy',                  'freq' => 'yearly',  'priority' => '0.3'],
            ['route' => 'terms',                    'freq' => 'yearly',  'priority' => '0.3'],
        ];
    }

    private function buildUrls(string $routeName, string $slug, string $baseUrl, string $defaultLocale, array $locales, array $slugMap): array
    {
        $urls = [];

        foreach ($locales as $locale) {
            $prefix = ($locale === $defaultLocale) ? '' : "/{$locale}";

            if (isset($slugMap[$routeName][$locale])) {
                $routeSlug = $slugMap[$routeName][$locale];
                if ($routeSlug === '/') {
                    $urls[$locale] = $baseUrl . $prefix . '/';
                } else {
                    $path          = $slug ? "{$routeSlug}/{$slug}" : $routeSlug;
                    $urls[$locale] = "{$baseUrl}{$prefix}/{$path}";
                }
            } else {
                $path          = $slug ?: $routeName;
                $urls[$locale] = "{$baseUrl}{$prefix}/{$path}";
            }
        }

        return $urls;
    }

    private function entry(string $canonical, array $localeUrls, string $lastmod, string $changefreq = 'weekly', string $priority = '0.5', array $images = []): string
    {
        $e  = "  <url>\n";
        $e .= '    <loc>' . htmlspecialchars($canonical) . "</loc>\n";

        foreach ($localeUrls as $lang => $href) {
            $e .= '    <xhtml:link rel="alternate"'
                . ' hreflang="' . htmlspecialchars($lang) . '"'
                . ' href="' . htmlspecialchars($href) . '"/>' . "\n";
        }
        $e .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($canonical) . '"/>' . "\n";
        $e .= "    <lastmod>{$lastmod}</lastmod>\n";
        $e .= "    <changefreq>{$changefreq}</changefreq>\n";
        $e .= "    <priority>{$priority}</priority>\n";

        foreach ($images as $imgUrl) {
            $e .= "    <image:image>\n";
            $e .= '      <image:loc>' . htmlspecialchars($imgUrl) . "</image:loc>\n";
            $e .= "    </image:image>\n";
        }

        $e .= "  </url>\n";

        return $e;
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Str;

class SeoService
{
    /**
     * Site ayarını DB kaynaklı paylaşılan view verisinden okur.
     * (config('settings.*') KULLANILMAZ — öyle bir config dosyası yok;
     *  ayarlar AppServiceProvider'da View::share('settings') ile gelir.)
     */
    protected function setting(string $key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = app('view')->getShared()['settings'] ?? [];
        }

        return $settings[$key] ?? $default;
    }

    /**
     * Meta tag'leri oluştur
     */
    public function generateMetaTags(array $data = []): array
    {
        $defaults = [
            'title' => config('app.name'),
            'description' => $this->setting('site_description'),
            'keywords' => $this->setting('site_keywords'),
            'image' => asset('images/og-default.jpg'),
            'url' => request()->url(),
            'type' => 'website',
            'locale' => app()->getLocale() . '_' . strtoupper(app()->getLocale()),
            'site_name' => config('app.name'),
        ];
        
        $meta = array_merge($defaults, $data);

        // null değerleri boş string'e indir (strlen(null) PHP 8.2'de deprecated)
        $meta['title']       = (string) ($meta['title'] ?? '');
        $meta['description'] = (string) ($meta['description'] ?? '');

        // Başlığı optimize et (Google ~60 karakter gösterir)
        if (mb_strlen($meta['title']) > 60) {
            $meta['title'] = Str::limit($meta['title'], 57, '...');
        }

        // Açıklamayı optimize et (Google ~160 karakter gösterir)
        if (mb_strlen($meta['description']) > 160) {
            $meta['description'] = Str::limit($meta['description'], 157, '...');
        }

        return $meta;
    }
    
    /**
     * JSON-LD Schema oluştur
     */
    public function generateSchema(string $type, array $data = []): array
    {
        $schemas = [
            'organization' => $this->organizationSchema($data),
            'product' => $this->productSchema($data),
            'breadcrumb' => $this->breadcrumbSchema($data),
            'local_business' => $this->localBusinessSchema($data),
            'website' => $this->websiteSchema($data),
            'faq' => $this->faqSchema($data),
            'howto' => $this->howToSchema($data),
            'review' => $this->reviewSchema($data),
            'aggregate_rating' => $this->aggregateRatingSchema($data),
            'article' => $this->articleSchema($data),
            'video' => $this->videoSchema($data),
            'dataset' => $this->datasetSchema($data),
        ];
        
        return $schemas[$type] ?? [];
    }
    
    /**
     * Organization schema
     */
    protected function organizationSchema(array $data = []): array
    {
        $logo = $this->setting('site_logo');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => config('app.url'),
            'logo' => $logo ? asset('storage/' . $logo) : asset('images/logo.png'),
        ];

        if ($phone = $this->setting('contact_phone')) {
            $schema['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => 'customer service',
                'availableLanguage' => ['Turkish', 'English'],
            ];
        }

        // social_media: platform dizisi ([['url' => ...], ...] veya [url, ...])
        $sameAs = [];
        foreach ((array) $this->setting('social_media', []) as $platform) {
            $url = is_array($platform) ? ($platform['url'] ?? null) : $platform;
            if (!empty($url)) {
                $sameAs[] = $url;
            }
        }
        if (!empty($sameAs)) {
            $schema['sameAs'] = $sameAs;
        }

        return array_merge($schema, $data);
    }
    
    /**
     * Product schema
     */
    protected function productSchema(array $data = []): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name'),
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
            ],
            'category' => 'Agricultural Products',
        ];

        // Boş değerleri ekleme
        if (!empty($data['image'])) {
            $schema['image'] = $data['image'];
        }
        if (!empty($data['sku'])) {
            $schema['sku'] = $data['sku'];
        }
        if (!empty($data['url'])) {
            $schema['url'] = $data['url'];
        }

        // B2B: Bayi fiyatı - iletişime yönlendir
        $schema['offers'] = [
            '@type' => 'Offer',
            'priceCurrency' => 'TRY',
            'price' => '0',
            'availability' => 'https://schema.org/InStock',
            'priceValidUntil' => date('Y-12-31'),
            'seller' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
            ],
        ];

        // Ek özellikler (etken madde, formülasyon vb.)
        if (!empty($data['additionalProperty'])) {
            $schema['additionalProperty'] = $data['additionalProperty'];
        }

        return $schema;
    }
    
    /**
     * Breadcrumb schema
     */
    protected function breadcrumbSchema(array $data = []): array
    {
        $items = [];
        
        if (isset($data['items'])) {
            foreach ($data['items'] as $position => $item) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $position + 1,
                    'item' => [
                        '@id' => $item['url'],
                        'name' => $item['name']
                    ]
                ];
            }
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }
    
    /**
     * Local Business schema
     */
    protected function localBusinessSchema(array $data = []): array
    {
        $logo = $this->setting('site_logo');

        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => config('app.name'),
            'image' => $logo ? asset('storage/' . $logo) : asset('images/logo.png'),
            'url' => config('app.url'),
            'telephone' => $this->setting('contact_phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->setting('contact_address'),
                'addressLocality' => $this->setting('contact_city'),
                'postalCode' => $this->setting('contact_postcode'),
                'addressCountry' => 'TR'
            ],
            'priceRange' => '$$',
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '09:00',
                'closes' => '18:00'
            ]
        ], $data);
    }
    
    /**
     * Website schema
     */
    protected function websiteSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name'),
            'url' => config('app.url'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => config('app.url') . '/urunler/ara?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ], $data);
    }
    
    /**
     * Canonical URL oluştur
     */
    public function generateCanonicalUrl(?string $url = null): string
    {
        if ($url) {
            return $url;
        }
        
        // Query parametrelerini temizle (sayfalama hariç)
        $current = request()->url();
        $page = request()->get('page');
        
        if ($page && $page > 1) {
            $current .= '?page=' . $page;
        }
        
        return $current;
    }
    
    /**
     * Robots meta tag oluştur
     */
    public function generateRobotsTag(array $options = []): string
    {
        $defaults = [
            'index' => true,
            'follow' => true,
            'archive' => true,
            'snippet' => true,
            'imageindex' => true,
        ];
        
        $options = array_merge($defaults, $options);
        
        $directives = [];
        
        $directives[] = $options['index'] ? 'index' : 'noindex';
        $directives[] = $options['follow'] ? 'follow' : 'nofollow';
        
        if (!$options['archive']) {
            $directives[] = 'noarchive';
        }
        
        if (!$options['snippet']) {
            $directives[] = 'nosnippet';
        }
        
        if (!$options['imageindex']) {
            $directives[] = 'noimageindex';
        }
        
        return implode(', ', $directives);
    }
    
    /**
     * Hreflang tag'leri oluştur
     */
    public function generateHreflangTags(array $urls = []): array
    {
        $tags = [];
        
        foreach ($urls as $lang => $url) {
            $tags[] = [
                'rel' => 'alternate',
                'hreflang' => $lang,
                'href' => $url
            ];
        }
        
        // x-default ekle
        if (!empty($urls)) {
            $tags[] = [
                'rel' => 'alternate',
                'hreflang' => 'x-default',
                'href' => $urls['tr'] ?? reset($urls)
            ];
        }
        
        return $tags;
    }
    
    /**
     * FAQ schema - Sıkça sorulan sorular için
     */
    protected function faqSchema(array $data = []): array
    {
        $mainEntity = [];
        
        if (isset($data['questions'])) {
            foreach ($data['questions'] as $qa) {
                $mainEntity[] = [
                    '@type' => 'Question',
                    'name' => $qa['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $qa['answer']
                    ]
                ];
            }
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity
        ];
    }
    
    /**
     * HowTo schema - Uygulama talimatları için
     */
    protected function howToSchema(array $data = []): array
    {
        $steps = [];
        
        if (isset($data['steps'])) {
            foreach ($data['steps'] as $index => $step) {
                $steps[] = [
                    '@type' => 'HowToStep',
                    'position' => $index + 1,
                    'name' => $step['name'] ?? 'Adım ' . ($index + 1),
                    'text' => $step['text'],
                    'image' => $step['image'] ?? null
                ];
            }
        }
        
        $supply = [];
        if (isset($data['supply'])) {
            foreach ($data['supply'] as $item) {
                $supply[] = [
                    '@type' => 'HowToSupply',
                    'name' => $item
                ];
            }
        }
        
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => $data['name'] ?? 'Ürün Uygulama Talimatı',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? null,
            'totalTime' => $data['totalTime'] ?? null,
            'supply' => $supply,
            'step' => $steps
        ], $data);
    }
    
    /**
     * Review schema - Tek bir yorum için
     */
    protected function reviewSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => $data['author'] ?? 'Anonim'
            ],
            'datePublished' => $data['datePublished'] ?? now()->toIso8601String(),
            'reviewBody' => $data['reviewBody'] ?? '',
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => $data['ratingValue'] ?? 5,
                'bestRating' => 5,
                'worstRating' => 1
            ]
        ], $data);
    }
    
    /**
     * AggregateRating schema - Toplam puan için
     */
    protected function aggregateRatingSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'AggregateRating',
            'ratingValue' => $data['ratingValue'] ?? 0,
            'bestRating' => 5,
            'worstRating' => 1,
            'ratingCount' => $data['ratingCount'] ?? 0,
            'reviewCount' => $data['reviewCount'] ?? 0
        ], $data);
    }
    
    /**
     * Article schema - Blog/Haber içerikleri için
     */
    protected function articleSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['headline'] ?? '',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? [],
            'datePublished' => $data['datePublished'] ?? now()->toIso8601String(),
            'dateModified' => $data['dateModified'] ?? now()->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'url' => config('app.url')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $data['url'] ?? request()->url()
            ]
        ], $data);
    }
    
    /**
     * Video schema - Video içerikleri için
     */
    protected function videoSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'thumbnailUrl' => $data['thumbnailUrl'] ?? '',
            'uploadDate' => $data['uploadDate'] ?? now()->toIso8601String(),
            'duration' => $data['duration'] ?? null, // ISO 8601 formatında (PT1M33S)
            'contentUrl' => $data['contentUrl'] ?? '',
            'embedUrl' => $data['embedUrl'] ?? ''
        ], $data);
    }
    
    /**
     * Dataset schema - Teknik veriler için
     */
    protected function datasetSchema(array $data = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'Dataset',
            'name' => $data['name'] ?? 'Teknik Özellikler',
            'description' => $data['description'] ?? '',
            'keywords' => $data['keywords'] ?? [],
            'creator' => [
                '@type' => 'Organization',
                'name' => config('app.name')
            ],
            'distribution' => [
                '@type' => 'DataDownload',
                'encodingFormat' => 'application/pdf',
                'contentUrl' => $data['downloadUrl'] ?? ''
            ]
        ], $data);
    }
}
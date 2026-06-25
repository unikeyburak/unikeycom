<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEO Genel Ayarları
    |--------------------------------------------------------------------------
    */
    
    // Varsayılan değerler
    'defaults' => [
        'title_suffix' => '',
        'title_separator' => ' | ',
        'description' => '',
        'keywords' => 'tarım ilacı, zirai ilaç, pestisit, herbisit, fungusit, insektisit, gübre, tarımsal ürünler',
        'author' => '',
        'robots' => 'index, follow',
        'image' => '/images/og-default.jpg',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Meta Tag Uzunluk Limitleri
    |--------------------------------------------------------------------------
    */
    
    'limits' => [
        'title' => 60,
        'description' => 160,
        'keywords' => 255,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Open Graph Ayarları
    |--------------------------------------------------------------------------
    */
    
    'open_graph' => [
        'enabled' => true,
        'site_name' => '',
        'type' => 'website',
        'locale' => 'tr_TR',
        'locale_alternate' => [],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Twitter Card Ayarları
    |--------------------------------------------------------------------------
    */
    
    'twitter' => [
        'enabled' => true,
        'card' => 'summary_large_image',
        'site' => '@unikeyterra', // Twitter kullanıcı adınız
        'creator' => '@unikeyterra',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | JSON-LD Schema Ayarları
    |--------------------------------------------------------------------------
    */
    
    'schema' => [
        'enabled' => true,
        'organization' => [
            'name' => '',
            'logo' => '/images/logo.png',
            'url' => env('APP_URL', 'https://unikeyterra.com'),
            'sameAs' => [
                'https://www.facebook.com/unikeyterra',
                'https://www.twitter.com/unikeyterra',
                'https://www.linkedin.com/company/unikeyterra',
                'https://www.instagram.com/unikeyterra',
            ],
        ],
        'local_business' => [
            'type' => 'LocalBusiness',
            'priceRange' => '$$',
            'image' => '/images/office.jpg',
            'telephone' => '+90 555 123 4567',
            'address' => [
                'streetAddress' => 'Örnek Mahallesi, Test Sokak No:1',
                'addressLocality' => 'Antalya',
                'postalCode' => '07000',
                'addressCountry' => 'TR',
            ],
            'geo' => [
                'latitude' => '36.8969',
                'longitude' => '30.7133',
            ],
            'openingHours' => [
                'Mo-Fr 09:00-18:00',
                'Sa 09:00-13:00',
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Sitemap Ayarları
    |--------------------------------------------------------------------------
    */
    
    'sitemap' => [
        'enabled' => true,
        'cache_duration' => 1440, // dakika (24 saat)
        'include_images' => true,
        'priorities' => [
            'home' => 1.0,
            'categories' => 0.9,
            'products' => 0.8,
            'pages' => 0.7,
            'blog' => 0.6,
        ],
        'frequencies' => [
            'home' => 'daily',
            'categories' => 'weekly',
            'products' => 'weekly',
            'pages' => 'monthly',
            'blog' => 'weekly',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Robots.txt Ayarları
    |--------------------------------------------------------------------------
    */
    
    'robots' => [
        'allow' => [
            '/',
        ],
        'disallow' => [
            '/admin',
            '/admin/*',
            '/api/*',
            '/storage/*',
            '/vendor/*',
            '/*.pdf',
            '/login',
            '/register',
            '/password/*',
        ],
        'crawl_delay' => 1,
        'sitemap' => '/sitemap.xml',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Breadcrumb Ayarları
    |--------------------------------------------------------------------------
    */
    
    'breadcrumb' => [
        'enabled' => true,
        'home_title' => 'Ana Sayfa',
        'separator' => ' / ',
        'show_current' => true,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Canonical URL Ayarları
    |--------------------------------------------------------------------------
    */
    
    'canonical' => [
        'enabled' => true,
        'force_https' => true,
        'remove_trailing_slash' => true,
        'keep_query_params' => ['page', 'category', 'sort'],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Rich Snippets Ayarları
    |--------------------------------------------------------------------------
    */
    
    'rich_snippets' => [
        'product' => [
            'enabled' => true,
            'show_aggregate_rating' => true,
            'show_reviews' => true,
            'show_offers' => true,
            'default_availability' => 'https://schema.org/InStock',
            'default_currency' => 'TRY',
        ],
        'faq' => [
            'enabled' => true,
            'auto_generate' => true,
        ],
        'howto' => [
            'enabled' => true,
            'auto_generate_from_dosage' => true,
        ],
        'article' => [
            'enabled' => true,
            'default_author' => '',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | SEO İzleme ve Analitik
    |--------------------------------------------------------------------------
    */
    
    'tracking' => [
        'google_analytics' => env('GOOGLE_ANALYTICS_ID', ''),
        'google_tag_manager' => env('GOOGLE_TAG_MANAGER_ID', ''),
        'facebook_pixel' => env('FACEBOOK_PIXEL_ID', ''),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Multi-language SEO
    |--------------------------------------------------------------------------
    */
    
    'multi_language' => [
        'enabled' => false,
        'default_locale' => 'tr',
        'supported_locales' => [
            'tr' => 'Türkçe',
            // 'en' => 'English',
        ],
        'hreflang_enabled' => false,
    ],
];
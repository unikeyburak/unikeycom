<?php

/**
 * Lokalize URL slug haritası
 *
 * Her rota ismi için dile göre URL slug'larını tanımlar.
 * Varsayılan dil (default) prefix olmadan kaydedilir.
 * Diğer diller /{locale}/ prefix ile kaydedilir.
 *
 * Örnek:
 *   EN (default): /about-us, /products, /contact
 *   TR:           /tr/hakkimizda, /tr/urunler, /tr/iletisim
 *   FR:           /fr/a-propos, /fr/produits, /fr/contact
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Varsayılan dil (URL prefix almaz)
    |--------------------------------------------------------------------------
    */
    'default' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Rota slug haritası
    |--------------------------------------------------------------------------
    | Route adı => [ locale => slug ]
    */
    'slugs' => [

        // ── Ana sayfa
        'home' => [
            'en' => '/',
            'tr' => '/',
            'fr' => '/',
            'ar' => '/',
            'es' => '/',
        ],

        // ── Statik sayfalar
        'about' => [
            'en' => 'about-us',
            'tr' => 'hakkimizda',
            'fr' => 'a-propos',
            'ar' => 'about-us',
            'es' => 'sobre-nosotros',
        ],
        'contact' => [
            'en' => 'contact',
            'tr' => 'iletisim',
            'fr' => 'contact',
            'ar' => 'contact',
            'es' => 'contacto',
        ],
        'privacy' => [
            'en' => 'privacy-policy',
            'tr' => 'gizlilik-politikasi',
            'fr' => 'politique-confidentialite',
            'ar' => 'privacy-policy',
            'es' => 'politica-privacidad',
        ],
        'terms' => [
            'en' => 'terms-of-use',
            'tr' => 'kullanim-sartlari',
            'fr' => 'conditions-utilisation',
            'ar' => 'terms-of-use',
            'es' => 'terminos-uso',
        ],
        'page.show' => [
            'en' => 'page',
            'tr' => 'sayfa',
            'fr' => 'page',
            'ar' => 'page',
            'es' => 'pagina',
        ],

        // ── Ürünler
        'products.index' => [
            'en' => 'products',
            'tr' => 'urunler',
            'fr' => 'produits',
            'ar' => 'products',
            'es' => 'productos',
        ],
        'products.search' => [
            'en' => 'products/search',
            'tr' => 'urunler/ara',
            'fr' => 'produits/recherche',
            'ar' => 'products/search',
            'es' => 'productos/buscar',
        ],
        'products.show' => [
            'en' => 'product',
            'tr' => 'urun',
            'fr' => 'produit',
            'ar' => 'product',
            'es' => 'producto',
        ],

        // ── Kataloglar
        'catalogs.index' => [
            'en' => 'catalog',
            'tr' => 'katalog',
            'fr' => 'catalogue',
            'ar' => 'catalog',
            'es' => 'catalogo',
        ],
        'catalogs.show' => [
            'en' => 'catalog',
            'tr' => 'katalog',
            'fr' => 'catalogue',
            'ar' => 'catalog',
            'es' => 'catalogo',
        ],
        'catalogs.view.suffix' => [
            'en' => 'view',
            'tr' => 'goruntule',
            'fr' => 'voir',
            'ar' => 'view',
            'es' => 'ver',
        ],
        'catalogs.download.suffix' => [
            'en' => 'download',
            'tr' => 'indir',
            'fr' => 'telecharger',
            'ar' => 'download',
            'es' => 'descargar',
        ],

        // ── Bitki Besleme Programları
        'nutrition-programs.index' => [
            'en' => 'plant-nutrition',
            'tr' => 'bitki-besleme',
            'fr' => 'nutrition-vegetale',
            'ar' => 'plant-nutrition',
            'es' => 'nutricion-vegetal',
        ],
        'nutrition-programs.products.suffix' => [
            'en' => 'products',
            'tr' => 'urunler',
            'fr' => 'produits',
            'ar' => 'products',
            'es' => 'productos',
        ],

        // ── Bayiler
        'dealers.index' => [
            'en' => 'dealers',
            'tr' => 'bayiler',
            'fr' => 'revendeurs',
            'ar' => 'dealers',
            'es' => 'distribuidores',
        ],

        // ── Blog
        'blog.index' => [
            'en' => 'blog',
            'tr' => 'blog',
            'fr' => 'blog',
            'ar' => 'blog',
            'es' => 'blog',
        ],
        'blog.search.suffix' => [
            'en' => 'search',
            'tr' => 'ara',
            'fr' => 'recherche',
            'ar' => 'search',
            'es' => 'buscar',
        ],
        'blog.category.suffix' => [
            'en' => 'category',
            'tr' => 'kategori',
            'fr' => 'categorie',
            'ar' => 'category',
            'es' => 'categoria',
        ],
        'blog.tag.suffix' => [
            'en' => 'tag',
            'tr' => 'etiket',
            'fr' => 'etiquette',
            'ar' => 'tag',
            'es' => 'etiqueta',
        ],
    ],
];

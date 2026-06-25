<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/admin/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.auth.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.auth.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/catalogs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/catalogs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.catalogs.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/contact-forms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.contact-forms.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dealers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dealers/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.dealers.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/faqs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.faqs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/faqs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.faqs.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/imports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.imports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/languages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.languages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/languages/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.languages.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/pages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.pages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/pages/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.pages.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/plants' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.plants.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/plants/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.plants.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/post-categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.post-categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/post-categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.post-categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/posts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.posts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/posts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.posts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/products/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.products.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/quote-requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.quote-requests.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/quote-requests/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.quote-requests.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.js' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bFqgYvWEzdbjq4Qg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.min.js.map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZfrCsR3t8dNvqEd3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/upload-file' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.upload-file',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::O4MFEtn02MNFM68X',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8v3ZHS8pJdr19RVT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CgMW5uVpk1NJP9ww',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BML3oayxajVvBI6R',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IMZzsaqhwKIMGsIQ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/me' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iBK9YUVaHbKlIqtW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::H2cByXPDUxizCAlY',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/change-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yVHlVB8iM5NyJUli',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/dealer/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tqGyuQvW4YrxE54Q',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gWfqISMCO6BHiVav',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sXsvdKtlbrF1fa7T',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DfBLqb0J8a6zO3Hw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/tokens' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ImXbbCKkIaJ0sJrt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e3pCZvqOUfXxZxGw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OZPO5xELQsxR63EO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sitemap.xml' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sitemap',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/optimize-clear-cache-2024x' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::s9Jk6IWGguFjr0bS',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/debug-locale' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LeHvlrfsVUSxqdeB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/debug-megamenu' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sj0P1deJayyc9qrP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/debug-routes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tNQBwELVDPjhKjRo',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'en.contact.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/about-us' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/privacy-policy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/terms-of-use' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/products/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/newsletter-signup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.newsletter.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/catalog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/plant-nutrition' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.nutrition-programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/dealers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/blog/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/en/blog/rss' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.rss',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/iletisim' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'contact.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/hakkimizda' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/gizlilik-politikasi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kullanim-sartlari' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/urunler' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/urunler/ara' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newsletter-signup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'newsletter.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/katalog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bitki-besleme' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'nutrition-programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayiler' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/blog/ara' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/blog/rss' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.rss',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'fr.contact.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/a-propos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/politique-confidentialite' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/conditions-utilisation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/produits' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/produits/recherche' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/newsletter-signup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.newsletter.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/catalogue' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/nutrition-vegetale' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.nutrition-programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/revendeurs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/blog/recherche' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fr/blog/rss' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.rss',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ar.contact.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/about-us' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/privacy-policy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/terms-of-use' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/products/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/newsletter-signup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.newsletter.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/catalog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/plant-nutrition' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.nutrition-programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/dealers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/blog/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ar/blog/rss' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.rss',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/contacto' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'es.contact.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/sobre-nosotros' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/politica-privacidad' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/terminos-uso' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/productos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/productos/buscar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/newsletter-signup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.newsletter.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/catalogo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.catalogs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/nutricion-vegetal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.nutrition-programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/distribuidores' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.dealers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/blog/buscar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/es/blog/rss' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.rss',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/import/wordpress' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.import.wordpress',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/import/wordpress/api' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.import.wordpress.api',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/import/wordpress/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.import.wordpress.csv',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/import/wordpress/sql' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.import.wordpress.sql',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/panel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/cikis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/profil' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/firma' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.company',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.company.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/teklifler' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.quotes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bayi/urunler' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.products',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/filament/(?|exports/([^/]++)/download(*:45)|imports/([^/]++)/failed\\-rows/download(*:90))|/a(?|dmin/(?|c(?|at(?|alogs/([^/]++)/edit(*:139)|egories/([^/]++)/edit(*:168))|ontact\\-forms/([^/]++)(*:199))|dealers/([^/]++)/edit(*:229)|faqs/([^/]++)/edit(*:255)|languages/([^/]++)/edit(*:286)|p(?|ages/([^/]++)/edit(*:316)|lants/([^/]++)/edit(*:343)|ost(?|\\-categories/([^/]++)/edit(*:383)|s/([^/]++)/edit(*:406))|roducts/([^/]++)/edit(*:436))|quote\\-requests/([^/]++)(?|(*:472)|/edit(*:485)))|pi/v1/(?|categories/([^/]++)(?|(*:526)|/products(*:543))|products/(?|([^/]++)(*:572)|search(*:586))|orders/([^/]++)(?|(*:613))|tokens/([^/]++)(*:637)))|/l(?|ivewire/preview\\-file/([^/]++)(*:682)|anguage/([^/]++)(*:706))|/debug\\-translations/([^/]++)(*:744)|/en/(?|p(?|age/([^/]++)(*:775)|roduct/([^/]++)(*:798)|lant\\-nutrition/(?|([^/]++)(?|(*:836)|/([^/]++)(*:853))|program/([^/]++)/products(*:887)))|catalog/([^/]++)(?|(*:916)|/(?|view(*:932)|download(*:948)))|blog/(?|category/([^/]++)(*:983)|tag/([^/]++)(*:1003)|([^/]++)(*:1020))|([^/]++)(*:1038))|/sayfa/([^/]++)(*:1063)|/urun/([^/]++)(*:1086)|/katalog/([^/]++)(?|(*:1115)|/(?|goruntule(*:1137)|indir(*:1151)))|/b(?|itki\\-besleme/(?|([^/]++)(?|(*:1195)|/([^/]++)(*:1213))|program/([^/]++)/urunler(*:1247))|log/(?|kategori/([^/]++)(*:1281)|etiket/([^/]++)(*:1305)|([^/]++)(*:1322)))|/([^/]++)(*:1342)|/fr(?|(*:1357)|/(?|p(?|age/([^/]++)(*:1386)|roduit/([^/]++)(*:1410))|catalogue/([^/]++)(?|(*:1441)|/(?|voir(*:1458)|telecharger(*:1478)))|nutrition\\-vegetale/(?|([^/]++)(?|(*:1523)|/([^/]++)(*:1541))|program/([^/]++)/produits(*:1576))|blog/(?|categorie/([^/]++)(*:1612)|etiquette/([^/]++)(*:1639)|([^/]++)(*:1656))|([^/]++)(*:1674)))|/ar(?|(*:1691)|/(?|p(?|age/([^/]++)(*:1720)|roduct/([^/]++)(*:1744)|lant\\-nutrition/(?|([^/]++)(?|(*:1783)|/([^/]++)(*:1801))|program/([^/]++)/products(*:1836)))|catalog/([^/]++)(?|(*:1866)|/(?|view(*:1883)|download(*:1900)))|blog/(?|category/([^/]++)(*:1936)|tag/([^/]++)(*:1957)|([^/]++)(*:1974))|([^/]++)(*:1992)))|/es(?|(*:2009)|/(?|p(?|agina/([^/]++)(*:2040)|roducto/([^/]++)(*:2065))|catalogo/([^/]++)(?|(*:2095)|/(?|ver(*:2111)|descargar(*:2129)))|nutricion\\-vegetal/(?|([^/]++)(?|(*:2173)|/([^/]++)(*:2191))|program/([^/]++)/productos(*:2227))|blog/(?|categoria/([^/]++)(*:2263)|etiqueta/([^/]++)(*:2289)|([^/]++)(*:2306))|([^/]++)(*:2324)))|/bayi(?|\\-(?|girisi(?|(*:2357))|basvurusu(?|(*:2379))|sifre(?|mi\\-unuttum(?|(*:2411))|\\-sifirla(?|/([^/]++)(*:2442)|(*:2451))))|/(?|teklifler/([^/]++)(?|(*:2488)|/iptal(*:2503))|urunler/([^/]++)(?|(*:2532)|/teklif(?|(*:2551)))))|/storage/(.*)(*:2577))/?$}sDu',
    ),
    3 => 
    array (
      45 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.exports.download',
          ),
          1 => 
          array (
            0 => 'export',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      90 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.imports.failed-rows.download',
          ),
          1 => 
          array (
            0 => 'import',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      139 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.catalogs.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      168 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.categories.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      199 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.contact-forms.view',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      229 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.dealers.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      255 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.faqs.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      286 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.languages.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      316 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.pages.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      343 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.plants.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      383 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.post-categories.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      406 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.posts.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      436 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.products.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      472 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.quote-requests.view',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      485 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.quote-requests.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cBuNtLlruGApn5Vd',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      543 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e9BZ7P4axtLDZv4w',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      572 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dzCxm6NBi9B02WaT',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      586 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OXyrAzXs1NGCxXvs',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      613 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XLO58fuIbfIEQ09i',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Dx4er8WymtDijCxJ',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YJiYJLwFWUmJM3V4',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      637 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::19Jy4nEGG9aSfg3P',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      682 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.preview-file',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      706 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change.language',
          ),
          1 => 
          array (
            0 => 'language',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::95dSDmVSWbIAVp4o',
          ),
          1 => 
          array (
            0 => 'categoryId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      775 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.page.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      798 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      836 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.nutrition-programs.plant',
          ),
          1 => 
          array (
            0 => 'plant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      853 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.nutrition-programs.show',
          ),
          1 => 
          array (
            0 => 'plant',
            1 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      887 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.nutrition-programs.products',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      916 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.catalogs.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      932 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.catalogs.view',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      948 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.catalogs.download',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      983 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1003 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.tag',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1020 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1038 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'en.products.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1063 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1086 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1115 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'catalogs.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1137 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'catalogs.view',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1151 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'catalogs.download',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'nutrition-programs.plant',
          ),
          1 => 
          array (
            0 => 'plant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1213 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'nutrition-programs.show',
          ),
          1 => 
          array (
            0 => 'plant',
            1 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1247 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'nutrition-programs.products',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1281 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1305 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.tag',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1322 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1342 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1357 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.home',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1386 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.page.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1410 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1441 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.catalogs.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1458 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.catalogs.view',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1478 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.catalogs.download',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1523 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.nutrition-programs.plant',
          ),
          1 => 
          array (
            0 => 'plant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1541 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.nutrition-programs.show',
          ),
          1 => 
          array (
            0 => 'plant',
            1 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1576 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.nutrition-programs.products',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1612 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.tag',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1656 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1674 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fr.products.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1691 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.home',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1720 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.page.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1783 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.nutrition-programs.plant',
          ),
          1 => 
          array (
            0 => 'plant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1801 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.nutrition-programs.show',
          ),
          1 => 
          array (
            0 => 'plant',
            1 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1836 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.nutrition-programs.products',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1866 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.catalogs.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1883 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.catalogs.view',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1900 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.catalogs.download',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1936 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1957 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.tag',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1974 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1992 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ar.products.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2009 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.home',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2040 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.page.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2065 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2095 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.catalogs.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2111 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.catalogs.view',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2129 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.catalogs.download',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2173 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.nutrition-programs.plant',
          ),
          1 => 
          array (
            0 => 'plant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2191 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.nutrition-programs.show',
          ),
          1 => 
          array (
            0 => 'plant',
            1 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2227 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.nutrition-programs.products',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2263 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2289 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.tag',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2306 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2324 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'es.products.category',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2357 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.login',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.login.submit',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2379 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.register',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.register.submit',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2411 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.password.forgot',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.password.email',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2442 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2451 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.password.update',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2488 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.quotes.show',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2503 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.quotes.cancel',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2532 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.products.show',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2551 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.products.quote',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'dealer.products.quote.submit',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2577 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'filament.exports.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'filament/exports/{export}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'filament.actions',
        ),
        'uses' => 'Filament\\Actions\\Exports\\Http\\Controllers\\DownloadExport@__invoke',
        'controller' => 'Filament\\Actions\\Exports\\Http\\Controllers\\DownloadExport',
        'as' => 'filament.exports.download',
        'namespace' => NULL,
        'prefix' => 'filament',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.imports.failed-rows.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'filament/imports/{import}/failed-rows/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'filament.actions',
        ),
        'uses' => 'Filament\\Actions\\Imports\\Http\\Controllers\\DownloadImportFailureCsv@__invoke',
        'controller' => 'Filament\\Actions\\Imports\\Http\\Controllers\\DownloadImportFailureCsv',
        'as' => 'filament.imports.failed-rows.download',
        'namespace' => NULL,
        'prefix' => 'filament',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.auth.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/login',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
        ),
        'uses' => 'Filament\\Pages\\Auth\\Login@__invoke',
        'controller' => 'Filament\\Pages\\Auth\\Login',
        'as' => 'filament.admin.auth.login',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.auth.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/logout',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'Filament\\Http\\Controllers\\Auth\\LogoutController@__invoke',
        'controller' => 'Filament\\Http\\Controllers\\Auth\\LogoutController',
        'as' => 'filament.admin.auth.logout',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'Filament\\Pages\\Dashboard@__invoke',
        'controller' => 'Filament\\Pages\\Dashboard',
        'as' => 'filament.admin.pages.dashboard',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/settings',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\Settings@__invoke',
        'controller' => 'App\\Filament\\Pages\\Settings',
        'as' => 'filament.admin.pages.settings',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/catalogs',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\ListCatalogs@__invoke',
        'controller' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\ListCatalogs',
        'as' => 'filament.admin.resources.catalogs.index',
        'namespace' => NULL,
        'prefix' => 'admin/catalogs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.catalogs.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/catalogs/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\CreateCatalog@__invoke',
        'controller' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\CreateCatalog',
        'as' => 'filament.admin.resources.catalogs.create',
        'namespace' => NULL,
        'prefix' => 'admin/catalogs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.catalogs.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/catalogs/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\EditCatalog@__invoke',
        'controller' => 'App\\Filament\\Resources\\CatalogResource\\Pages\\EditCatalog',
        'as' => 'filament.admin.resources.catalogs.edit',
        'namespace' => NULL,
        'prefix' => 'admin/catalogs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\ListCategories@__invoke',
        'controller' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\ListCategories',
        'as' => 'filament.admin.resources.categories.index',
        'namespace' => NULL,
        'prefix' => 'admin/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\CreateCategory@__invoke',
        'controller' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\CreateCategory',
        'as' => 'filament.admin.resources.categories.create',
        'namespace' => NULL,
        'prefix' => 'admin/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\EditCategory@__invoke',
        'controller' => 'App\\Filament\\Resources\\CategoryResource\\Pages\\EditCategory',
        'as' => 'filament.admin.resources.categories.edit',
        'namespace' => NULL,
        'prefix' => 'admin/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.contact-forms.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/contact-forms',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ContactFormResource\\Pages\\ListContactForms@__invoke',
        'controller' => 'App\\Filament\\Resources\\ContactFormResource\\Pages\\ListContactForms',
        'as' => 'filament.admin.resources.contact-forms.index',
        'namespace' => NULL,
        'prefix' => 'admin/contact-forms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.contact-forms.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/contact-forms/{record}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ContactFormResource\\Pages\\ViewContactForm@__invoke',
        'controller' => 'App\\Filament\\Resources\\ContactFormResource\\Pages\\ViewContactForm',
        'as' => 'filament.admin.resources.contact-forms.view',
        'namespace' => NULL,
        'prefix' => 'admin/contact-forms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dealers',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealerResource\\Pages\\ListDealers@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealerResource\\Pages\\ListDealers',
        'as' => 'filament.admin.resources.dealers.index',
        'namespace' => NULL,
        'prefix' => 'admin/dealers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.dealers.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dealers/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealerResource\\Pages\\CreateDealer@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealerResource\\Pages\\CreateDealer',
        'as' => 'filament.admin.resources.dealers.create',
        'namespace' => NULL,
        'prefix' => 'admin/dealers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.dealers.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dealers/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealerResource\\Pages\\EditDealer@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealerResource\\Pages\\EditDealer',
        'as' => 'filament.admin.resources.dealers.edit',
        'namespace' => NULL,
        'prefix' => 'admin/dealers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.faqs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/faqs',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\FaqResource\\Pages\\ListFaqs@__invoke',
        'controller' => 'App\\Filament\\Resources\\FaqResource\\Pages\\ListFaqs',
        'as' => 'filament.admin.resources.faqs.index',
        'namespace' => NULL,
        'prefix' => 'admin/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.faqs.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/faqs/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\FaqResource\\Pages\\CreateFaq@__invoke',
        'controller' => 'App\\Filament\\Resources\\FaqResource\\Pages\\CreateFaq',
        'as' => 'filament.admin.resources.faqs.create',
        'namespace' => NULL,
        'prefix' => 'admin/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.faqs.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/faqs/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\FaqResource\\Pages\\EditFaq@__invoke',
        'controller' => 'App\\Filament\\Resources\\FaqResource\\Pages\\EditFaq',
        'as' => 'filament.admin.resources.faqs.edit',
        'namespace' => NULL,
        'prefix' => 'admin/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.imports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/imports',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ImportResource\\Pages\\WordPressImport@__invoke',
        'controller' => 'App\\Filament\\Resources\\ImportResource\\Pages\\WordPressImport',
        'as' => 'filament.admin.resources.imports.index',
        'namespace' => NULL,
        'prefix' => 'admin/imports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.languages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/languages',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\ListLanguages@__invoke',
        'controller' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\ListLanguages',
        'as' => 'filament.admin.resources.languages.index',
        'namespace' => NULL,
        'prefix' => 'admin/languages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.languages.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/languages/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\CreateLanguage@__invoke',
        'controller' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\CreateLanguage',
        'as' => 'filament.admin.resources.languages.create',
        'namespace' => NULL,
        'prefix' => 'admin/languages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.languages.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/languages/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\EditLanguage@__invoke',
        'controller' => 'App\\Filament\\Resources\\LanguageResource\\Pages\\EditLanguage',
        'as' => 'filament.admin.resources.languages.edit',
        'namespace' => NULL,
        'prefix' => 'admin/languages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.pages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PageResource\\Pages\\ListPages@__invoke',
        'controller' => 'App\\Filament\\Resources\\PageResource\\Pages\\ListPages',
        'as' => 'filament.admin.resources.pages.index',
        'namespace' => NULL,
        'prefix' => 'admin/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.pages.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PageResource\\Pages\\CreatePage@__invoke',
        'controller' => 'App\\Filament\\Resources\\PageResource\\Pages\\CreatePage',
        'as' => 'filament.admin.resources.pages.create',
        'namespace' => NULL,
        'prefix' => 'admin/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.pages.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PageResource\\Pages\\EditPage@__invoke',
        'controller' => 'App\\Filament\\Resources\\PageResource\\Pages\\EditPage',
        'as' => 'filament.admin.resources.pages.edit',
        'namespace' => NULL,
        'prefix' => 'admin/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.plants.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/plants',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PlantResource\\Pages\\ListPlants@__invoke',
        'controller' => 'App\\Filament\\Resources\\PlantResource\\Pages\\ListPlants',
        'as' => 'filament.admin.resources.plants.index',
        'namespace' => NULL,
        'prefix' => 'admin/plants',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.plants.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/plants/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PlantResource\\Pages\\CreatePlant@__invoke',
        'controller' => 'App\\Filament\\Resources\\PlantResource\\Pages\\CreatePlant',
        'as' => 'filament.admin.resources.plants.create',
        'namespace' => NULL,
        'prefix' => 'admin/plants',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.plants.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/plants/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PlantResource\\Pages\\EditPlant@__invoke',
        'controller' => 'App\\Filament\\Resources\\PlantResource\\Pages\\EditPlant',
        'as' => 'filament.admin.resources.plants.edit',
        'namespace' => NULL,
        'prefix' => 'admin/plants',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.post-categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/post-categories',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\ListPostCategories@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\ListPostCategories',
        'as' => 'filament.admin.resources.post-categories.index',
        'namespace' => NULL,
        'prefix' => 'admin/post-categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.post-categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/post-categories/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\CreatePostCategory@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\CreatePostCategory',
        'as' => 'filament.admin.resources.post-categories.create',
        'namespace' => NULL,
        'prefix' => 'admin/post-categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.post-categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/post-categories/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\EditPostCategory@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostCategoryResource\\Pages\\EditPostCategory',
        'as' => 'filament.admin.resources.post-categories.edit',
        'namespace' => NULL,
        'prefix' => 'admin/post-categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.posts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/posts',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostResource\\Pages\\ListPosts@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostResource\\Pages\\ListPosts',
        'as' => 'filament.admin.resources.posts.index',
        'namespace' => NULL,
        'prefix' => 'admin/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.posts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/posts/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostResource\\Pages\\CreatePost@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostResource\\Pages\\CreatePost',
        'as' => 'filament.admin.resources.posts.create',
        'namespace' => NULL,
        'prefix' => 'admin/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.posts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/posts/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\PostResource\\Pages\\EditPost@__invoke',
        'controller' => 'App\\Filament\\Resources\\PostResource\\Pages\\EditPost',
        'as' => 'filament.admin.resources.posts.edit',
        'namespace' => NULL,
        'prefix' => 'admin/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProductResource\\Pages\\ListProducts@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProductResource\\Pages\\ListProducts',
        'as' => 'filament.admin.resources.products.index',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.products.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProductResource\\Pages\\CreateProduct@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProductResource\\Pages\\CreateProduct',
        'as' => 'filament.admin.resources.products.create',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.products.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProductResource\\Pages\\EditProduct@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProductResource\\Pages\\EditProduct',
        'as' => 'filament.admin.resources.products.edit',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.quote-requests.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quote-requests',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\ListQuoteRequests@__invoke',
        'controller' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\ListQuoteRequests',
        'as' => 'filament.admin.resources.quote-requests.index',
        'namespace' => NULL,
        'prefix' => 'admin/quote-requests',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.quote-requests.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quote-requests/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\CreateQuoteRequest@__invoke',
        'controller' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\CreateQuoteRequest',
        'as' => 'filament.admin.resources.quote-requests.create',
        'namespace' => NULL,
        'prefix' => 'admin/quote-requests',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.quote-requests.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quote-requests/{record}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\ViewQuoteRequest@__invoke',
        'controller' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\ViewQuoteRequest',
        'as' => 'filament.admin.resources.quote-requests.view',
        'namespace' => NULL,
        'prefix' => 'admin/quote-requests',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.quote-requests.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quote-requests/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          5 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          6 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          7 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          8 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          9 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          10 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\EditQuoteRequest@__invoke',
        'controller' => 'App\\Filament\\Resources\\QuoteRequestResource\\Pages\\EditQuoteRequest',
        'as' => 'filament.admin.resources.quote-requests.edit',
        'namespace' => NULL,
        'prefix' => 'admin/quote-requests',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bFqgYvWEzdbjq4Qg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.js',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'as' => 'generated::bFqgYvWEzdbjq4Qg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZfrCsR3t8dNvqEd3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.min.js.map',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'as' => 'generated::ZfrCsR3t8dNvqEd3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.upload-file' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/upload-file',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'as' => 'livewire.upload-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.preview-file' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/preview-file/{filename}',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'as' => 'livewire.preview-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::O4MFEtn02MNFM68X' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::O4MFEtn02MNFM68X',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cBuNtLlruGApn5Vd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::cBuNtLlruGApn5Vd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e9BZ7P4axtLDZv4w' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/categories/{category}/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@products',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\CategoryController@products',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::e9BZ7P4axtLDZv4w',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8v3ZHS8pJdr19RVT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::8v3ZHS8pJdr19RVT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dzCxm6NBi9B02WaT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::dzCxm6NBi9B02WaT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OXyrAzXs1NGCxXvs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\ProductController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::OXyrAzXs1NGCxXvs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CgMW5uVpk1NJP9ww' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'throttle:login',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@login',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::CgMW5uVpk1NJP9ww',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BML3oayxajVvBI6R' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@register',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::BML3oayxajVvBI6R',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IMZzsaqhwKIMGsIQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::IMZzsaqhwKIMGsIQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iBK9YUVaHbKlIqtW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/auth/me',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@me',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@me',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::iBK9YUVaHbKlIqtW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::H2cByXPDUxizCAlY' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/auth/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@updateProfile',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::H2cByXPDUxizCAlY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yVHlVB8iM5NyJUli' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/change-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@changePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@changePassword',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::yVHlVB8iM5NyJUli',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tqGyuQvW4YrxE54Q' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/dealer/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\DealerController@profile',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\DealerController@profile',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::tqGyuQvW4YrxE54Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gWfqISMCO6BHiVav' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/dealer/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\DealerController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\DealerController@updateProfile',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::gWfqISMCO6BHiVav',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sXsvdKtlbrF1fa7T' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::sXsvdKtlbrF1fa7T',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DfBLqb0J8a6zO3Hw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::DfBLqb0J8a6zO3Hw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XLO58fuIbfIEQ09i' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/orders/{order}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::XLO58fuIbfIEQ09i',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Dx4er8WymtDijCxJ' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/orders/{order}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Dx4er8WymtDijCxJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YJiYJLwFWUmJM3V4' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/orders/{order}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@cancel',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\OrderController@cancel',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::YJiYJLwFWUmJM3V4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ImXbbCKkIaJ0sJrt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/tokens',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@tokens',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@tokens',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::ImXbbCKkIaJ0sJrt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e3pCZvqOUfXxZxGw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/tokens',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@createToken',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@createToken',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::e3pCZvqOUfXxZxGw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::19Jy4nEGG9aSfg3P' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/tokens/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:api',
          2 => 'auth:api',
          3 => 'throttle:api:auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@revokeToken',
        'controller' => 'App\\Http\\Controllers\\Api\\V1\\AuthController@revokeToken',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::19Jy4nEGG9aSfg3P',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OZPO5xELQsxR63EO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:807:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"0000000000000fdf0000000000000000";}}',
        'as' => 'generated::OZPO5xELQsxR63EO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sitemap' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sitemap.xml',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SitemapController@index',
        'controller' => 'App\\Http\\Controllers\\SitemapController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sitemap',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::s9Jk6IWGguFjr0bS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'optimize-clear-cache-2024x',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:657:"function () {
    \\Illuminate\\Support\\Facades\\Artisan::call(\'cache:clear\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'config:clear\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'route:clear\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'view:clear\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'config:cache\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'route:cache\');
    \\Illuminate\\Support\\Facades\\Artisan::call(\'view:cache\');

    return \\response()->json([
        \'status\'  => \'OK\',
        \'message\' => \'Tüm cache temizlendi ve yeniden oluşturuldu!\',
        \'note\'    => \'Bu route\\\'u şimdi web.php\\\'den silebilirsin!\',
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000fe30000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::s9Jk6IWGguFjr0bS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::95dSDmVSWbIAVp4o' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-translations/{categoryId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1031:"function ($categoryId) {
        $category = \\App\\Models\\Category::find($categoryId);
        if (!$category) {
            return \\response()->json([\'error\' => \'Category not found\']);
        }

        $translations = \\App\\Models\\Translation::where(\'translatable_type\', \\App\\Models\\Category::class)
            ->where(\'translatable_id\', $categoryId)
            ->get();

        return \\response()->json([
            \'category_id\'              => $category->id,
            \'category_name_db\'         => $category->name,
            \'current_locale\'           => \\app()->getLocale(),
            \'session_locale\'           => \\session(\'locale\'),
            \'translated_name_current\'  => $category->translate(\'name\'),
            \'translated_name_tr\'       => $category->translate(\'name\', \'tr\'),
            \'translated_name_fr\'       => $category->translate(\'name\', \'fr\'),
            \'translated_name_en\'       => $category->translate(\'name\', \'en\'),
            \'all_translations_in_db\'   => $translations,
        ]);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000ff40000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::95dSDmVSWbIAVp4o',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LeHvlrfsVUSxqdeB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-locale',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:222:"function () {
        return \\response()->json([
            \'app_locale\'     => \\app()->getLocale(),
            \'session_locale\' => \\session(\'locale\'),
            \'session_all\'    => \\session()->all(),
        ]);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000ff60000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::LeHvlrfsVUSxqdeB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sj0P1deJayyc9qrP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-megamenu',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:554:"function () {
        $filePath = \\resource_path(\'views/partials/mega-menu.blade.php\');
        $content  = \\file_get_contents($filePath);
        $settings = \\App\\Models\\Setting::where(\'key\', \'mega_menu\')->first();

        return \\response()->json([
            \'file_path\'         => $filePath,
            \'file_exists\'       => \\file_exists($filePath),
            \'has_translate_calls\' => \\str_contains($content, "->translate(\'name\')"),
            \'mega_menu_settings\'  => $settings ? \\json_decode($settings->value, true) : null,
        ]);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000ff80000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sj0P1deJayyc9qrP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tNQBwELVDPjhKjRo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-routes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:459:"function () {
        $allRoutes = \\Illuminate\\Support\\Facades\\Route::getRoutes();
        $list = [];
        foreach ($allRoutes as $route) {
            $name = $route->getName();
            if ($name && !\\str_starts_with($name, \'filament\') && !\\str_starts_with($name, \'livewire\')) {
                $list[] = [\'name\' => $name, \'uri\' => $route->uri(), \'methods\' => $route->methods()];
            }
        }
        return \\response()->json($list);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000ffa0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::tNQBwELVDPjhKjRo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change.language' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'language/{language}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1620:"function (string $language, \\Illuminate\\Http\\Request $request) {
    $languageModel = \\App\\Models\\Language::where(\'code\', $language)->where(\'is_active\', true)->first();
    if (!$languageModel) {
        return \\redirect()->back();
    }

    $cookieMinutes = (int) \\config(\'app.locale_cookie_minutes\', 43200);

    $localeCookie = \\cookie(
        \\config(\'app.locale_cookie\', \'site_locale\'),
        $languageModel->code,
        $cookieMinutes,
        \'/\',
        \\config(\'session.domain\'),
        (bool) \\config(\'session.secure\'),
        false,
        false,
        \\config(\'session.same_site\', \'lax\')
    );

    $directionCookie = \\cookie(
        \\config(\'app.direction_cookie\', \'site_direction\'),
        $languageModel->isRtl() ? \'rtl\' : \'ltr\',
        $cookieMinutes,
        \'/\',
        \\config(\'session.domain\'),
        (bool) \\config(\'session.secure\'),
        false,
        false,
        \\config(\'session.same_site\', \'lax\')
    );

    // Dil değiştirici, lokalize sayfanın URL\'sini `to` parametresi olarak gönderir
    $toUrl = $request->input(\'to\', \'\');

    // Güvenlik: Sadece aynı domain URL\'lerine izin ver
    if ($toUrl) {
        $appUrl   = \\rtrim(\\config(\'app.url\', \'\'), \'/\');
        $isInternalAbsolute = \\str_starts_with($toUrl, $appUrl . \'/\') || $toUrl === $appUrl;
        $isRelative         = \\str_starts_with($toUrl, \'/\');

        if ($isInternalAbsolute || $isRelative) {
            return \\redirect($toUrl)->withCookie($localeCookie)->withCookie($directionCookie);
        }
    }

    return \\redirect(\'/\')->withCookie($localeCookie)->withCookie($directionCookie);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000ffc0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'change.language',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contact',
        'controller' => 'App\\Http\\Controllers\\PageController@contact',
        'as' => 'en.contact',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.contact.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'en/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'en.contact.submit',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'as' => 'en.home',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/about-us',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@about',
        'controller' => 'App\\Http\\Controllers\\PageController@about',
        'as' => 'en.about',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/privacy-policy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@privacy',
        'controller' => 'App\\Http\\Controllers\\PageController@privacy',
        'as' => 'en.privacy',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/terms-of-use',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@terms',
        'controller' => 'App\\Http\\Controllers\\PageController@terms',
        'as' => 'en.terms',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.page.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/page/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'en.page.show',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'en.products.index',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/products/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'en.products.search',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/product/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'en.products.show',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.newsletter.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'en/newsletter-signup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'en.newsletter.submit',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/catalog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@index',
        'controller' => 'App\\Http\\Controllers\\CatalogController@index',
        'as' => 'en.catalogs.index',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.catalogs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/catalog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@show',
        'controller' => 'App\\Http\\Controllers\\CatalogController@show',
        'as' => 'en.catalogs.show',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.catalogs.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/catalog/{slug}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'as' => 'en.catalogs.view',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.catalogs.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/catalog/{slug}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@download',
        'controller' => 'App\\Http\\Controllers\\CatalogController@download',
        'as' => 'en.catalogs.download',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.nutrition-programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/plant-nutrition',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'as' => 'en.nutrition-programs.index',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.nutrition-programs.plant' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/plant-nutrition/{plant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'as' => 'en.nutrition-programs.plant',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.nutrition-programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/plant-nutrition/{plant}/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'as' => 'en.nutrition-programs.show',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
        'program' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.nutrition-programs.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/plant-nutrition/program/{program}/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'as' => 'en.nutrition-programs.products',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/dealers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@index',
        'controller' => 'App\\Http\\Controllers\\DealerController@index',
        'as' => 'en.dealers.index',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@index',
        'controller' => 'App\\Http\\Controllers\\PostController@index',
        'as' => 'en.blog.index',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@search',
        'controller' => 'App\\Http\\Controllers\\PostController@search',
        'as' => 'en.blog.search',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog/category/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@category',
        'controller' => 'App\\Http\\Controllers\\PostController@category',
        'as' => 'en.blog.category',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.tag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog/tag/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@tag',
        'controller' => 'App\\Http\\Controllers\\PostController@tag',
        'as' => 'en.blog.tag',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.rss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog/rss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@rss',
        'controller' => 'App\\Http\\Controllers\\PostController@rss',
        'as' => 'en.blog.rss',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@show',
        'controller' => 'App\\Http\\Controllers\\PostController@show',
        'as' => 'en.blog.show',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'en.products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'en/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'controller' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'as' => 'en.products.category',
        'namespace' => NULL,
        'prefix' => '/en',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'iletisim',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contact',
        'controller' => 'App\\Http\\Controllers\\PageController@contact',
        'as' => 'contact',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'contact.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'iletisim',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'contact.submit',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'as' => 'home',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'hakkimizda',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@about',
        'controller' => 'App\\Http\\Controllers\\PageController@about',
        'as' => 'about',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'gizlilik-politikasi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@privacy',
        'controller' => 'App\\Http\\Controllers\\PageController@privacy',
        'as' => 'privacy',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kullanim-sartlari',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@terms',
        'controller' => 'App\\Http\\Controllers\\PageController@terms',
        'as' => 'terms',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sayfa/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'page.show',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'urunler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'products.index',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'urunler/ara',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'products.search',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'urun/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'products.show',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'newsletter.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newsletter-signup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'newsletter.submit',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'katalog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@index',
        'controller' => 'App\\Http\\Controllers\\CatalogController@index',
        'as' => 'catalogs.index',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'catalogs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'katalog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@show',
        'controller' => 'App\\Http\\Controllers\\CatalogController@show',
        'as' => 'catalogs.show',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'catalogs.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'katalog/{slug}/goruntule',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'as' => 'catalogs.view',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'catalogs.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'katalog/{slug}/indir',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@download',
        'controller' => 'App\\Http\\Controllers\\CatalogController@download',
        'as' => 'catalogs.download',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'nutrition-programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bitki-besleme',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'as' => 'nutrition-programs.index',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'nutrition-programs.plant' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bitki-besleme/{plant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'as' => 'nutrition-programs.plant',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'nutrition-programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bitki-besleme/{plant}/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'as' => 'nutrition-programs.show',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
        'program' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'nutrition-programs.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bitki-besleme/program/{program}/urunler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'as' => 'nutrition-programs.products',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayiler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@index',
        'controller' => 'App\\Http\\Controllers\\DealerController@index',
        'as' => 'dealers.index',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@index',
        'controller' => 'App\\Http\\Controllers\\PostController@index',
        'as' => 'blog.index',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/ara',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@search',
        'controller' => 'App\\Http\\Controllers\\PostController@search',
        'as' => 'blog.search',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/kategori/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@category',
        'controller' => 'App\\Http\\Controllers\\PostController@category',
        'as' => 'blog.category',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.tag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/etiket/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@tag',
        'controller' => 'App\\Http\\Controllers\\PostController@tag',
        'as' => 'blog.tag',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.rss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/rss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@rss',
        'controller' => 'App\\Http\\Controllers\\PostController@rss',
        'as' => 'blog.rss',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@show',
        'controller' => 'App\\Http\\Controllers\\PostController@show',
        'as' => 'blog.show',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'controller' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'as' => 'products.category',
        'namespace' => NULL,
        'prefix' => '/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contact',
        'controller' => 'App\\Http\\Controllers\\PageController@contact',
        'as' => 'fr.contact',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.contact.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'fr/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'fr.contact.submit',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'as' => 'fr.home',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/a-propos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@about',
        'controller' => 'App\\Http\\Controllers\\PageController@about',
        'as' => 'fr.about',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/politique-confidentialite',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@privacy',
        'controller' => 'App\\Http\\Controllers\\PageController@privacy',
        'as' => 'fr.privacy',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/conditions-utilisation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@terms',
        'controller' => 'App\\Http\\Controllers\\PageController@terms',
        'as' => 'fr.terms',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.page.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/page/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'fr.page.show',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/produits',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'fr.products.index',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/produits/recherche',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'fr.products.search',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/produit/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'fr.products.show',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.newsletter.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'fr/newsletter-signup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'fr.newsletter.submit',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/catalogue',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@index',
        'controller' => 'App\\Http\\Controllers\\CatalogController@index',
        'as' => 'fr.catalogs.index',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.catalogs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/catalogue/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@show',
        'controller' => 'App\\Http\\Controllers\\CatalogController@show',
        'as' => 'fr.catalogs.show',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.catalogs.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/catalogue/{slug}/voir',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'as' => 'fr.catalogs.view',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.catalogs.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/catalogue/{slug}/telecharger',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@download',
        'controller' => 'App\\Http\\Controllers\\CatalogController@download',
        'as' => 'fr.catalogs.download',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.nutrition-programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/nutrition-vegetale',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'as' => 'fr.nutrition-programs.index',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.nutrition-programs.plant' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/nutrition-vegetale/{plant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'as' => 'fr.nutrition-programs.plant',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.nutrition-programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/nutrition-vegetale/{plant}/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'as' => 'fr.nutrition-programs.show',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
        'program' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.nutrition-programs.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/nutrition-vegetale/program/{program}/produits',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'as' => 'fr.nutrition-programs.products',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/revendeurs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@index',
        'controller' => 'App\\Http\\Controllers\\DealerController@index',
        'as' => 'fr.dealers.index',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@index',
        'controller' => 'App\\Http\\Controllers\\PostController@index',
        'as' => 'fr.blog.index',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog/recherche',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@search',
        'controller' => 'App\\Http\\Controllers\\PostController@search',
        'as' => 'fr.blog.search',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog/categorie/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@category',
        'controller' => 'App\\Http\\Controllers\\PostController@category',
        'as' => 'fr.blog.category',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.tag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog/etiquette/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@tag',
        'controller' => 'App\\Http\\Controllers\\PostController@tag',
        'as' => 'fr.blog.tag',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.rss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog/rss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@rss',
        'controller' => 'App\\Http\\Controllers\\PostController@rss',
        'as' => 'fr.blog.rss',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@show',
        'controller' => 'App\\Http\\Controllers\\PostController@show',
        'as' => 'fr.blog.show',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fr.products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fr/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'controller' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'as' => 'fr.products.category',
        'namespace' => NULL,
        'prefix' => '/fr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contact',
        'controller' => 'App\\Http\\Controllers\\PageController@contact',
        'as' => 'ar.contact',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.contact.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ar/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'ar.contact.submit',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'as' => 'ar.home',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/about-us',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@about',
        'controller' => 'App\\Http\\Controllers\\PageController@about',
        'as' => 'ar.about',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/privacy-policy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@privacy',
        'controller' => 'App\\Http\\Controllers\\PageController@privacy',
        'as' => 'ar.privacy',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/terms-of-use',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@terms',
        'controller' => 'App\\Http\\Controllers\\PageController@terms',
        'as' => 'ar.terms',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.page.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/page/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'ar.page.show',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'ar.products.index',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/products/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'ar.products.search',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/product/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'ar.products.show',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.newsletter.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ar/newsletter-signup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'ar.newsletter.submit',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/catalog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@index',
        'controller' => 'App\\Http\\Controllers\\CatalogController@index',
        'as' => 'ar.catalogs.index',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.catalogs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/catalog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@show',
        'controller' => 'App\\Http\\Controllers\\CatalogController@show',
        'as' => 'ar.catalogs.show',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.catalogs.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/catalog/{slug}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'as' => 'ar.catalogs.view',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.catalogs.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/catalog/{slug}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@download',
        'controller' => 'App\\Http\\Controllers\\CatalogController@download',
        'as' => 'ar.catalogs.download',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.nutrition-programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/plant-nutrition',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'as' => 'ar.nutrition-programs.index',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.nutrition-programs.plant' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/plant-nutrition/{plant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'as' => 'ar.nutrition-programs.plant',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.nutrition-programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/plant-nutrition/{plant}/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'as' => 'ar.nutrition-programs.show',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
        'program' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.nutrition-programs.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/plant-nutrition/program/{program}/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'as' => 'ar.nutrition-programs.products',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/dealers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@index',
        'controller' => 'App\\Http\\Controllers\\DealerController@index',
        'as' => 'ar.dealers.index',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@index',
        'controller' => 'App\\Http\\Controllers\\PostController@index',
        'as' => 'ar.blog.index',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@search',
        'controller' => 'App\\Http\\Controllers\\PostController@search',
        'as' => 'ar.blog.search',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog/category/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@category',
        'controller' => 'App\\Http\\Controllers\\PostController@category',
        'as' => 'ar.blog.category',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.tag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog/tag/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@tag',
        'controller' => 'App\\Http\\Controllers\\PostController@tag',
        'as' => 'ar.blog.tag',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.rss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog/rss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@rss',
        'controller' => 'App\\Http\\Controllers\\PostController@rss',
        'as' => 'ar.blog.rss',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@show',
        'controller' => 'App\\Http\\Controllers\\PostController@show',
        'as' => 'ar.blog.show',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ar.products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ar/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'controller' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'as' => 'ar.products.category',
        'namespace' => NULL,
        'prefix' => '/ar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/contacto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contact',
        'controller' => 'App\\Http\\Controllers\\PageController@contact',
        'as' => 'es.contact',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.contact.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'es/contacto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'es.contact.submit',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'as' => 'es.home',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/sobre-nosotros',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@about',
        'controller' => 'App\\Http\\Controllers\\PageController@about',
        'as' => 'es.about',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/politica-privacidad',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@privacy',
        'controller' => 'App\\Http\\Controllers\\PageController@privacy',
        'as' => 'es.privacy',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/terminos-uso',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@terms',
        'controller' => 'App\\Http\\Controllers\\PageController@terms',
        'as' => 'es.terms',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.page.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/pagina/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'es.page.show',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/productos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'es.products.index',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/productos/buscar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'es.products.search',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/producto/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'es.products.show',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.newsletter.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'es/newsletter-signup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:contact',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'controller' => 'App\\Http\\Controllers\\PageController@contactSubmit',
        'as' => 'es.newsletter.submit',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.catalogs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/catalogo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@index',
        'controller' => 'App\\Http\\Controllers\\CatalogController@index',
        'as' => 'es.catalogs.index',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.catalogs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/catalogo/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@show',
        'controller' => 'App\\Http\\Controllers\\CatalogController@show',
        'as' => 'es.catalogs.show',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.catalogs.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/catalogo/{slug}/ver',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\CatalogController@viewPdf',
        'as' => 'es.catalogs.view',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.catalogs.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/catalogo/{slug}/descargar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\CatalogController@download',
        'controller' => 'App\\Http\\Controllers\\CatalogController@download',
        'as' => 'es.catalogs.download',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.nutrition-programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/nutricion-vegetal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@index',
        'as' => 'es.nutrition-programs.index',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.nutrition-programs.plant' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/nutricion-vegetal/{plant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@plant',
        'as' => 'es.nutrition-programs.plant',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.nutrition-programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/nutricion-vegetal/{plant}/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@show',
        'as' => 'es.nutrition-programs.show',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'plant' => 'slug',
        'program' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.nutrition-programs.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/nutricion-vegetal/program/{program}/productos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'controller' => 'App\\Http\\Controllers\\NutritionProgramController@products',
        'as' => 'es.nutrition-programs.products',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.dealers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/distribuidores',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@index',
        'controller' => 'App\\Http\\Controllers\\DealerController@index',
        'as' => 'es.dealers.index',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@index',
        'controller' => 'App\\Http\\Controllers\\PostController@index',
        'as' => 'es.blog.index',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog/buscar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@search',
        'controller' => 'App\\Http\\Controllers\\PostController@search',
        'as' => 'es.blog.search',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog/categoria/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@category',
        'controller' => 'App\\Http\\Controllers\\PostController@category',
        'as' => 'es.blog.category',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.tag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog/etiqueta/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@tag',
        'controller' => 'App\\Http\\Controllers\\PostController@tag',
        'as' => 'es.blog.tag',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.rss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog/rss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@rss',
        'controller' => 'App\\Http\\Controllers\\PostController@rss',
        'as' => 'es.blog.rss',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          2 => 'Illuminate\\Session\\Middleware\\StartSession',
          3 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          4 => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
        ),
        'uses' => 'App\\Http\\Controllers\\PostController@show',
        'controller' => 'App\\Http\\Controllers\\PostController@show',
        'as' => 'es.blog.show',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'es.products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'es/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'controller' => 'App\\Http\\Controllers\\PageController@rootSlug',
        'as' => 'es.products.category',
        'namespace' => NULL,
        'prefix' => '/es',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi-girisi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@login',
        'controller' => 'App\\Http\\Controllers\\DealerController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.login.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi-girisi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
          2 => 'throttle:login',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@loginSubmit',
        'controller' => 'App\\Http\\Controllers\\DealerController@loginSubmit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.login.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi-basvurusu',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@register',
        'controller' => 'App\\Http\\Controllers\\DealerController@register',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.register.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi-basvurusu',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
          2 => 'throttle:dealer-register',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@registerSubmit',
        'controller' => 'App\\Http\\Controllers\\DealerController@registerSubmit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.register.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.password.forgot' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi-sifremi-unuttum',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@forgotPassword',
        'controller' => 'App\\Http\\Controllers\\DealerController@forgotPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.password.forgot',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi-sifremi-unuttum',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
          2 => 'throttle:password-reset',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@sendResetLink',
        'controller' => 'App\\Http\\Controllers\\DealerController@sendResetLink',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi-sifre-sifirla/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@resetPasswordForm',
        'controller' => 'App\\Http\\Controllers\\DealerController@resetPasswordForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi-sifre-sifirla',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\DealerController@resetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dealer.password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.import.wordpress' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/import/wordpress',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpress',
        'controller' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpress',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'admin.import.wordpress',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.import.wordpress.api' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/import/wordpress/api',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressApi',
        'controller' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressApi',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'admin.import.wordpress.api',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.import.wordpress.csv' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/import/wordpress/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressCsv',
        'controller' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressCsv',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'admin.import.wordpress.csv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.import.wordpress.sql' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/import/wordpress/sql',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressSql',
        'controller' => 'App\\Http\\Controllers\\Admin\\ImportController@wordpressSql',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'admin.import.wordpress.sql',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/panel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@dashboard',
        'controller' => 'App\\Http\\Controllers\\DealerController@dashboard',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi/cikis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@logout',
        'controller' => 'App\\Http\\Controllers\\DealerController@logout',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/profil',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@profile',
        'controller' => 'App\\Http\\Controllers\\DealerController@profile',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'bayi/profil',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@profileUpdate',
        'controller' => 'App\\Http\\Controllers\\DealerController@profileUpdate',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.profile.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.company' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/firma',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@company',
        'controller' => 'App\\Http\\Controllers\\DealerController@company',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.company',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.company.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'bayi/firma',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@companyUpdate',
        'controller' => 'App\\Http\\Controllers\\DealerController@companyUpdate',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.company.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.quotes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/teklifler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@quotes',
        'controller' => 'App\\Http\\Controllers\\DealerController@quotes',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.quotes',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.quotes.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/teklifler/{quote}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@quotesShow',
        'controller' => 'App\\Http\\Controllers\\DealerController@quotesShow',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.quotes.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.quotes.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'bayi/teklifler/{quote}/iptal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@quotesCancel',
        'controller' => 'App\\Http\\Controllers\\DealerController@quotesCancel',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.quotes.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/urunler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@products',
        'controller' => 'App\\Http\\Controllers\\DealerController@products',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.products',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/urunler/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@productsShow',
        'controller' => 'App\\Http\\Controllers\\DealerController@productsShow',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.products.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'product' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.products.quote' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bayi/urunler/{product}/teklif',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@productsQuote',
        'controller' => 'App\\Http\\Controllers\\DealerController@productsQuote',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.products.quote',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'product' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dealer.products.quote.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bayi/urunler/{product}/teklif',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'dealer',
        ),
        'uses' => 'App\\Http\\Controllers\\DealerController@productsQuoteSubmit',
        'controller' => 'App\\Http\\Controllers\\DealerController@productsQuoteSubmit',
        'namespace' => NULL,
        'prefix' => '/bayi',
        'where' => 
        array (
        ),
        'as' => 'dealer.products.quote.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'product' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:33:"/var/www/html/storage/app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000010000000000000000000";}}',
        'as' => 'storage.local',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/update',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'controller' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'livewire.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);

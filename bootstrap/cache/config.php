<?php return array (
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/var/www/html/resources/views',
    ),
    'compiled' => '/var/www/html/storage/framework/views',
  ),
  'app' => 
  array (
    'name' => 'Unikeyterra',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8080',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'tr',
    'fallback_locale' => 'tr',
    'faker_locale' => 'tr_TR',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:SEZ9E3X0EQ5REKpFHWLeByIW2N0BMV6z9g3x69h8RQI=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\Filament\\AdminPanelProvider',
      25 => 'App\\Providers\\RepositoryServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
    'force_https' => false,
    'locale_cookie' => 'site_locale',
    'direction_cookie' => 'site_direction',
    'locale_cookie_minutes' => '43200',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'dealer' => 
      array (
        'driver' => 'session',
        'provider' => 'dealers',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
      'dealers' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\DealerUser',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/var/www/html/storage/framework/cache/data',
        'lock_path' => '/var/www/html/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'unikeycom_',
    'public_cache' => 
    array (
      'enabled' => false,
      'max_age' => '300',
      's_maxage' => '3600',
      'stale_while_revalidate' => '86400',
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'laravel_db',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
        'transaction_mode' => 'DEFERRED',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'mysql',
        'port' => '3306',
        'database' => 'laravel_db',
        'username' => 'laravel_user',
        'password' => '1453',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => 'mysql',
        'port' => '3306',
        'database' => 'laravel_db',
        'username' => 'laravel_user',
        'password' => '1453',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'mysql',
        'port' => '3306',
        'database' => 'laravel_db',
        'username' => 'laravel_user',
        'password' => '1453',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'mysql',
        'port' => '3306',
        'database' => 'laravel_db',
        'username' => 'laravel_user',
        'password' => '1453',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'unikeyterra-database-',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => 'redis',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => 'redis',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/html/storage/app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/html/public/storage',
        'url' => 'http://localhost:8080/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      '/var/www/html/public/storage' => '/var/www/html/storage/app/public',
    ),
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Livewire',
    'view_path' => '/var/www/html/resources/views/livewire',
    'layout' => 'components.layouts.app',
    'lazy_placeholder' => NULL,
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => 
      array (
        0 => 'required',
        1 => 'file',
        2 => 'max:51200',
      ),
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' => 
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'smart_wire_keys' => false,
    'pagination_theme' => 'tailwind',
    'release_token' => 'a',
  ),
  'localized-routes' => 
  array (
    'default' => 'tr',
    'slugs' => 
    array (
      'home' => 
      array (
        'en' => '/',
        'tr' => '/',
        'fr' => '/',
        'ar' => '/',
        'es' => '/',
      ),
      'about' => 
      array (
        'en' => 'about-us',
        'tr' => 'hakkimizda',
        'fr' => 'a-propos',
        'ar' => 'about-us',
        'es' => 'sobre-nosotros',
      ),
      'contact' => 
      array (
        'en' => 'contact',
        'tr' => 'iletisim',
        'fr' => 'contact',
        'ar' => 'contact',
        'es' => 'contacto',
      ),
      'privacy' => 
      array (
        'en' => 'privacy-policy',
        'tr' => 'gizlilik-politikasi',
        'fr' => 'politique-confidentialite',
        'ar' => 'privacy-policy',
        'es' => 'politica-privacidad',
      ),
      'terms' => 
      array (
        'en' => 'terms-of-use',
        'tr' => 'kullanim-sartlari',
        'fr' => 'conditions-utilisation',
        'ar' => 'terms-of-use',
        'es' => 'terminos-uso',
      ),
      'page.show' => 
      array (
        'en' => 'page',
        'tr' => 'sayfa',
        'fr' => 'page',
        'ar' => 'page',
        'es' => 'pagina',
      ),
      'products.index' => 
      array (
        'en' => 'products',
        'tr' => 'urunler',
        'fr' => 'produits',
        'ar' => 'products',
        'es' => 'productos',
      ),
      'products.search' => 
      array (
        'en' => 'products/search',
        'tr' => 'urunler/ara',
        'fr' => 'produits/recherche',
        'ar' => 'products/search',
        'es' => 'productos/buscar',
      ),
      'products.show' => 
      array (
        'en' => 'product',
        'tr' => 'urun',
        'fr' => 'produit',
        'ar' => 'product',
        'es' => 'producto',
      ),
      'catalogs.index' => 
      array (
        'en' => 'catalog',
        'tr' => 'katalog',
        'fr' => 'catalogue',
        'ar' => 'catalog',
        'es' => 'catalogo',
      ),
      'catalogs.show' => 
      array (
        'en' => 'catalog',
        'tr' => 'katalog',
        'fr' => 'catalogue',
        'ar' => 'catalog',
        'es' => 'catalogo',
      ),
      'catalogs.view.suffix' => 
      array (
        'en' => 'view',
        'tr' => 'goruntule',
        'fr' => 'voir',
        'ar' => 'view',
        'es' => 'ver',
      ),
      'catalogs.download.suffix' => 
      array (
        'en' => 'download',
        'tr' => 'indir',
        'fr' => 'telecharger',
        'ar' => 'download',
        'es' => 'descargar',
      ),
      'nutrition-programs.index' => 
      array (
        'en' => 'plant-nutrition',
        'tr' => 'bitki-besleme',
        'fr' => 'nutrition-vegetale',
        'ar' => 'plant-nutrition',
        'es' => 'nutricion-vegetal',
      ),
      'nutrition-programs.products.suffix' => 
      array (
        'en' => 'products',
        'tr' => 'urunler',
        'fr' => 'produits',
        'ar' => 'products',
        'es' => 'productos',
      ),
      'dealers.index' => 
      array (
        'en' => 'dealers',
        'tr' => 'bayiler',
        'fr' => 'revendeurs',
        'ar' => 'dealers',
        'es' => 'distribuidores',
      ),
      'blog.index' => 
      array (
        'en' => 'blog',
        'tr' => 'blog',
        'fr' => 'blog',
        'ar' => 'blog',
        'es' => 'blog',
      ),
      'blog.search.suffix' => 
      array (
        'en' => 'search',
        'tr' => 'ara',
        'fr' => 'recherche',
        'ar' => 'search',
        'es' => 'buscar',
      ),
      'blog.category.suffix' => 
      array (
        'en' => 'category',
        'tr' => 'kategori',
        'fr' => 'categorie',
        'ar' => 'category',
        'es' => 'categoria',
      ),
      'blog.tag.suffix' => 
      array (
        'en' => 'tag',
        'tr' => 'etiket',
        'fr' => 'etiquette',
        'ar' => 'tag',
        'es' => 'etiqueta',
      ),
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/var/www/html/storage/logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/var/www/html/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'handler_with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'formatter' => NULL,
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/var/www/html/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => 'ssl',
        'url' => NULL,
        'host' => 'mail.unikeyterra.com',
        'port' => '465',
        'username' => 'info@unikeyterra.com',
        'password' => 'BURAYA_MAIL_SIFRESI',
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
        'retry_after' => 60,
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
        'retry_after' => 60,
      ),
    ),
    'from' => 
    array (
      'address' => 'info@unikeyterra.com',
      'name' => 'Unikeyterra',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/var/www/html/resources/views/vendor/mail',
      ),
    ),
    'to_address' => 'info@unikeyterra.com',
    'admin_emails' => 
    array (
      0 => 'admin@unikeyterra.com',
    ),
  ),
  'media' => 
  array (
    'cdn_url' => NULL,
    'disk' => 'public',
    'allowed_image_types' => 
    array (
      0 => 'jpg',
      1 => 'jpeg',
      2 => 'png',
      3 => 'gif',
      4 => 'webp',
      5 => 'bmp',
    ),
    'allowed_document_types' => 
    array (
      0 => 'pdf',
      1 => 'doc',
      2 => 'docx',
      3 => 'xls',
      4 => 'xlsx',
      5 => 'ppt',
      6 => 'pptx',
    ),
    'max_image_size' => 10,
    'max_document_size' => 20,
    'image_quality' => 85,
    'max_width' => 2000,
    'max_height' => 2000,
    'sizes' => 
    array (
      'thumbnail' => 
      array (
        'width' => 150,
        'height' => 150,
      ),
      'small' => 
      array (
        'width' => 300,
        'height' => 300,
      ),
      'medium' => 
      array (
        'width' => 600,
        'height' => 600,
      ),
      'large' => 
      array (
        'width' => 1200,
        'height' => 1200,
      ),
    ),
    'responsive' => 
    array (
      'enabled' => true,
      'directory' => 'responsive',
      'quality' => 82,
      'widths' => 
      array (
        0 => 480,
        1 => 768,
        2 => 1200,
        3 => 1600,
      ),
      'default_sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw',
    ),
    'watermark' => 
    array (
      'enabled' => false,
      'path' => 'watermark.png',
      'position' => 'bottom-right',
      'opacity' => 70,
      'size_percentage' => 10,
    ),
    'cleanup' => 
    array (
      'temp_files_after_days' => 7,
      'unused_files_after_days' => 30,
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
      'background' => 
      array (
        'driver' => 'background',
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'seo' => 
  array (
    'defaults' => 
    array (
      'title_suffix' => '',
      'title_separator' => ' | ',
      'description' => '',
      'keywords' => 'tarım ilacı, zirai ilaç, pestisit, herbisit, fungusit, insektisit, gübre, tarımsal ürünler',
      'author' => '',
      'robots' => 'index, follow',
      'image' => '/images/og-default.jpg',
    ),
    'limits' => 
    array (
      'title' => 60,
      'description' => 160,
      'keywords' => 255,
    ),
    'open_graph' => 
    array (
      'enabled' => true,
      'site_name' => '',
      'type' => 'website',
      'locale' => 'tr_TR',
      'locale_alternate' => 
      array (
      ),
    ),
    'twitter' => 
    array (
      'enabled' => true,
      'card' => 'summary_large_image',
      'site' => '@unikeyterra',
      'creator' => '@unikeyterra',
    ),
    'schema' => 
    array (
      'enabled' => true,
      'organization' => 
      array (
        'name' => '',
        'logo' => '/images/logo.png',
        'url' => 'http://localhost:8080',
        'sameAs' => 
        array (
          0 => 'https://www.facebook.com/unikeyterra',
          1 => 'https://www.twitter.com/unikeyterra',
          2 => 'https://www.linkedin.com/company/unikeyterra',
          3 => 'https://www.instagram.com/unikeyterra',
        ),
      ),
      'local_business' => 
      array (
        'type' => 'LocalBusiness',
        'priceRange' => '$$',
        'image' => '/images/office.jpg',
        'telephone' => '+90 555 123 4567',
        'address' => 
        array (
          'streetAddress' => 'Örnek Mahallesi, Test Sokak No:1',
          'addressLocality' => 'Antalya',
          'postalCode' => '07000',
          'addressCountry' => 'TR',
        ),
        'geo' => 
        array (
          'latitude' => '36.8969',
          'longitude' => '30.7133',
        ),
        'openingHours' => 
        array (
          0 => 'Mo-Fr 09:00-18:00',
          1 => 'Sa 09:00-13:00',
        ),
      ),
    ),
    'sitemap' => 
    array (
      'enabled' => true,
      'cache_duration' => 1440,
      'include_images' => true,
      'priorities' => 
      array (
        'home' => 1.0,
        'categories' => 0.9,
        'products' => 0.8,
        'pages' => 0.7,
        'blog' => 0.6,
      ),
      'frequencies' => 
      array (
        'home' => 'daily',
        'categories' => 'weekly',
        'products' => 'weekly',
        'pages' => 'monthly',
        'blog' => 'weekly',
      ),
    ),
    'robots' => 
    array (
      'allow' => 
      array (
        0 => '/',
      ),
      'disallow' => 
      array (
        0 => '/admin',
        1 => '/admin/*',
        2 => '/api/*',
        3 => '/storage/*',
        4 => '/vendor/*',
        5 => '/*.pdf',
        6 => '/login',
        7 => '/register',
        8 => '/password/*',
      ),
      'crawl_delay' => 1,
      'sitemap' => '/sitemap.xml',
    ),
    'breadcrumb' => 
    array (
      'enabled' => true,
      'home_title' => 'Ana Sayfa',
      'separator' => ' / ',
      'show_current' => true,
    ),
    'canonical' => 
    array (
      'enabled' => true,
      'force_https' => true,
      'remove_trailing_slash' => true,
      'keep_query_params' => 
      array (
        0 => 'page',
        1 => 'category',
        2 => 'sort',
      ),
    ),
    'rich_snippets' => 
    array (
      'product' => 
      array (
        'enabled' => true,
        'show_aggregate_rating' => true,
        'show_reviews' => true,
        'show_offers' => true,
        'default_availability' => 'https://schema.org/InStock',
        'default_currency' => 'TRY',
      ),
      'faq' => 
      array (
        'enabled' => true,
        'auto_generate' => true,
      ),
      'howto' => 
      array (
        'enabled' => true,
        'auto_generate_from_dosage' => true,
      ),
      'article' => 
      array (
        'enabled' => true,
        'default_author' => '',
      ),
    ),
    'tracking' => 
    array (
      'google_analytics' => '',
      'google_tag_manager' => '',
      'facebook_pixel' => '',
    ),
    'multi_language' => 
    array (
      'enabled' => false,
      'default_locale' => 'tr',
      'supported_locales' => 
      array (
        'tr' => 'Türkçe',
      ),
      'hreflang_enabled' => false,
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'key' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
    'geoip' => 
    array (
      'enabled' => true,
      'timeout' => '1.5',
      'cache_seconds' => '86400',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/var/www/html/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'unikeyterra-session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'blade-heroicons' => 
  array (
    'prefix' => 'heroicon',
    'fallback' => '',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'blade-icons' => 
  array (
    'sets' => 
    array (
    ),
    'class' => '',
    'attributes' => 
    array (
    ),
    'fallback' => '',
    'components' => 
    array (
      'disabled' => false,
      'default' => 'icon',
    ),
  ),
  'filament' => 
  array (
    'broadcasting' => 
    array (
    ),
    'default_filesystem_disk' => 'public',
    'assets_path' => NULL,
    'cache_path' => '/var/www/html/bootstrap/cache/filament',
    'livewire_loading_delay' => 'default',
    'system_route_prefix' => 'filament',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);

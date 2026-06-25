<?php

/*
|--------------------------------------------------------------------------
| cPanel / paylaşımlı hosting için DÜZENLENMİŞ index.php
|--------------------------------------------------------------------------
| Bu dosyayı public_html/index.php olarak yükle.
| Laravel uygulama dosyaları public_html DIŞINDA ../laravel/ klasöründe olmalı:
|   /home/KULLANICI/laravel/      ← app, vendor, bootstrap, .env ...
|   /home/KULLANICI/public_html/  ← bu index.php + .htaccess + build/ + images/ ...
|
| Eğer "laravel" yerine farklı bir klasör adı kullandıysan aşağıdaki
| ../laravel/ yollarını ona göre değiştir.
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Bakım modu...
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader...
require __DIR__.'/../laravel/vendor/autoload.php';

// Laravel'i başlat...
/** @var Application $app */
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$app->handleRequest(Request::capture());

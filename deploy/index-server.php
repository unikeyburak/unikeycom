<?php

/*
|--------------------------------------------------------------------------
| index.php — laravel/ docroot İÇİNDE alt klasör (./laravel)
| public dosyaları (build, css, js, images) docroot'ta → public path = docroot
|--------------------------------------------------------------------------
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/laravel/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/laravel/bootstrap/app.php';

// Public kök = bu dosyanın bulunduğu docroot (build/, css/, js/, images/, storage/ burada).
// @vite manifest'i ve asset() URL'leri bunu kullanır.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());

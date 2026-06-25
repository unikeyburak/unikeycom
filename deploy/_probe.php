<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/plain; charset=utf-8');

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "\nSHUTDOWN-FATAL: {$e['message']} @ {$e['file']}:{$e['line']}\n";
    }
});

echo "PHP=" . PHP_VERSION . "  memory_limit=" . ini_get('memory_limit') . "\n";

$req = ['gd','pdo_mysql','mbstring','openssl','tokenizer','xml','ctype','json','bcmath','fileinfo','curl','zip','intl','dom'];
$miss = [];
foreach ($req as $x) { if (!extension_loaded($x)) $miss[] = $x; }
echo "MISSING-EXT: " . (count($miss) ? implode(',', $miss) : 'yok') . "\n";

$paths = [
    'laravel/vendor/autoload.php',
    'laravel/bootstrap/app.php',
    'laravel/.env',
    'laravel/storage/framework/views',
    'laravel/bootstrap/cache',
];
foreach ($paths as $p) {
    $full = __DIR__ . '/' . $p;
    echo "PATH $p : " . (file_exists($full) ? 'var' : 'YOK')
       . (is_dir($full) ? (' dir w=' . (is_writable($full) ? 'evet' : 'HAYIR')) : '') . "\n";
}

try {
    require __DIR__ . '/laravel/vendor/autoload.php';
    echo "autoload OK\n";
    $app = require __DIR__ . '/laravel/bootstrap/app.php';
    echo "bootstrap OK\n";
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "kernel resolve OK\n";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo "framework bootstrap OK\n";
    echo "APP_ENV=" . config('app.env') . " DEBUG=" . var_export(config('app.debug'), true) . " URL=" . config('app.url') . "\n";
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "DB OK\n";
    } catch (\Throwable $db) {
        echo "DB-ERROR: " . $db->getMessage() . "\n";
    }
} catch (\Throwable $e) {
    echo "THROW: " . get_class($e) . ": " . $e->getMessage() . "\n@ " . $e->getFile() . ":" . $e->getLine() . "\n";
}

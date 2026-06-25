<?php
/**
 * View cache temizleyici — kullandıktan sonra SİL!
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->handle(
    \Illuminate\Http\Request::capture()
);

$viewPath = storage_path('framework/views');
$count = 0;
foreach (glob($viewPath . '/*.php') as $file) {
    unlink($file);
    $count++;
}

// Uygulama cache de temizle
\Illuminate\Support\Facades\Cache::flush();

echo "<pre style='background:#1a1a2e;color:#16c60c;padding:20px;font-family:monospace;'>";
echo "✅ $count derlenmiş view dosyası silindi.\n";
echo "✅ Uygulama cache temizlendi.\n";
echo "\nBu dosyayı şimdi silebilirsiniz.\n";
echo "</pre>";

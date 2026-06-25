<?php
/**
 * Laravel log hata mesajlarini ve admin testi.
 * Kullandiktan sonra SIL!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

$base = dirname(__DIR__);

echo '<div style="font-family:monospace;max-width:1000px;margin:40px auto;padding:20px">';

// Config cache sil ki APP_DEBUG=true etkili olsun
$configCachePath = $base . '/bootstrap/cache/config.php';
if (file_exists($configCachePath)) {
    @unlink($configCachePath);
    echo '<p style="color:orange">Config cache silindi (APP_DEBUG etkili olacak)</p>';
}

// Log dosyasindan sadece hata MESAJLARINI cek (stack trace degil)
echo '<h1>SON HATA MESAJLARI</h1>';
$logFile = $base . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $size = filesize($logFile);
    echo '<p>Log: ' . round($size / 1024) . ' KB</p>';

    // Son 30KB oku
    $fp = fopen($logFile, 'r');
    $readSize = min($size, 30000);
    fseek($fp, max(0, $size - $readSize));
    $content = fread($fp, $readSize);
    fclose($fp);

    // Hata mesajlarini bul (tarih ile baslayan satirlar)
    preg_match_all('/\[\d{4}-\d{2}-\d{2}[^\]]*\]\s+\S+\.\S+:\s+(.+?)(?=\n\[|\n#\d|\nStack trace)/s', $content, $matches);

    if (!empty($matches[0])) {
        $errors = array_slice($matches[0], -5);
        echo '<h2>Son ' . count($errors) . ' hata mesaji:</h2>';
        foreach (array_reverse($errors) as $error) {
            $short = substr(trim($error), 0, 500);
            echo '<div style="background:#1e1e1e;color:#ff6b6b;padding:12px;margin:8px 0;border-radius:6px;white-space:pre-wrap;font-size:13px;border-left:4px solid red;overflow-x:auto">';
            echo htmlspecialchars($short);
            echo '</div>';
        }
    } else {
        echo '<p>Log\'da regex ile hata bulunamadi. Son 500 karakter:</p>';
        echo '<pre style="background:#1e1e1e;color:#f0f0f0;padding:12px;font-size:12px;overflow-x:auto">';
        echo htmlspecialchars(substr($content, -500));
        echo '</pre>';
    }
} else {
    echo '<p style="color:red">Log dosyasi yok</p>';
}

// Simdi admin sayfasini ICERIDEN cagir ve hatayi yakala
echo '<hr><h1>ADMIN SAYFA TESTI</h1>';
flush();

try {
    require $base . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';

    // HTTP kernel ile admin sayfasini render et
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

    $request = \Illuminate\Http\Request::create('/admin', 'GET');
    $request->headers->set('Accept', 'text/html');

    echo '<p>Admin sayfasi render ediliyor...</p>';
    flush();

    $response = $kernel->handle($request);
    $status = $response->getStatusCode();

    echo '<p>HTTP Status: <b>' . $status . '</b></p>';

    if ($status >= 400) {
        $body = $response->getContent();
        // Whoops hata sayfasindan mesaji cek
        if (preg_match('/<h2 class="frame-class"[^>]*>(.*?)<\/h2>/s', $body, $m)) {
            echo '<p style="color:red;font-size:16px"><b>HATA: ' . htmlspecialchars(strip_tags($m[1])) . '</b></p>';
        }
        if (preg_match('/<span class="exception_message"[^>]*>(.*?)<\/span>/s', $body, $m)) {
            echo '<p style="color:red;font-size:14px">Mesaj: ' . htmlspecialchars(strip_tags($m[1])) . '</p>';
        }
        // Alternatif: title'dan hata mesaji
        if (preg_match('/<title>(.*?)<\/title>/s', $body, $m)) {
            echo '<p>Sayfa title: ' . htmlspecialchars(strip_tags($m[1])) . '</p>';
        }
        // Eger Whoops parse edemediyse, ilk 1000 karakter goster
        if (!preg_match('/exception_message/', $body)) {
            echo '<div style="background:#1e1e1e;color:#f0f0f0;padding:12px;border-radius:6px;font-size:12px;max-height:400px;overflow:auto">';
            echo htmlspecialchars(substr(strip_tags($body), 0, 1500));
            echo '</div>';
        }
    } else {
        echo '<p style="color:green;font-size:18px"><b>ADMIN SAYFA CALISIYOR!</b></p>';
    }

    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    echo '<div style="background:#1e1e1e;color:#ff6b6b;padding:15px;border-radius:8px;font-size:13px">';
    echo '<b>HATA SINIFI:</b> ' . get_class($e) . "\n";
    echo '<b>MESAJ:</b> ' . htmlspecialchars($e->getMessage()) . "\n";
    echo '<b>DOSYA:</b> ' . htmlspecialchars(str_replace($base, '', $e->getFile())) . ':' . $e->getLine() . "\n";

    // Onceki hata varsa
    $prev = $e->getPrevious();
    if ($prev) {
        echo "\n<b>ONCEKI HATA:</b> " . get_class($prev) . ': ' . htmlspecialchars($prev->getMessage()) . "\n";
        echo '<b>DOSYA:</b> ' . htmlspecialchars(str_replace($base, '', $prev->getFile())) . ':' . $prev->getLine() . "\n";
    }
    echo '</div>';
}

echo '<br><p style="color:red;font-weight:bold">Bu dosyayi sunucudan SIL!</p>';
echo '</div>';

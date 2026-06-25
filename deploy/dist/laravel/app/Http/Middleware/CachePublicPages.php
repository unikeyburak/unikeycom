<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CachePublicPages
{
    /**
     * Cache dışı bırakılacak URI kalıpları
     */
    private array $excludedPaths = [
        'admin*',
        'filament*',
        'bayi*',
        'api/*',
        'livewire*',
        'iletisim',
        'language/*',
        'bayi-girisi',
        'bayi-basvurusu',
        'bayi-sifremi-unuttum',
        'bayi-sifre-sifirla*',
        'debug-*',
        'clear-cache*',
        'optimize-*',
    ];

    /**
     * Sayfa bazlı cache süresi (saniye)
     */
    private int $cacheTtl = 86400; // 24 saat (günde 1 kez)

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sadece GET isteklerinde cache kontrol et
        if (!in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        // Exclude edilen path'leri atla
        if ($this->isExcludedPath($request)) {
            return $next($request);
        }

        // Giriş yapmış kullanıcılar için cache yok
        if (Auth::check() || Auth::guard('dealer')->check()) {
            return $next($request);
        }

        // Cache dosyasını kontrol et
        $cacheFile = $this->getCacheFilePath($request);

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $this->cacheTtl) {
            // Cache'den servis et - DB sorgusu YOK
            $html = file_get_contents($cacheFile);
            return response($html, 200, [
                'Content-Type' => 'text/html; charset=UTF-8',
                'X-Page-Cache' => 'HIT',
            ]);
        }

        // Normal render et
        $response = $next($request);

        // Başarılı HTML response'ları cache'e kaydet
        if ($this->shouldCache($response)) {
            $this->saveToCache($cacheFile, $response->getContent());
        }

        $response->headers->set('X-Page-Cache', 'MISS');

        return $response;
    }

    /**
     * Cache dosya yolunu oluştur
     */
    private function getCacheFilePath(Request $request): string
    {
        $locale = app()->getLocale();
        $url = $request->getPathInfo();
        $query = $request->getQueryString();
        $key = md5($locale . '|' . $url . '|' . ($query ?? ''));

        $dir = storage_path('framework/page-cache');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir . '/' . $key . '.html';
    }

    /**
     * Response cache'lenebilir mi?
     */
    private function shouldCache(Response $response): bool
    {
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        if ($response instanceof StreamedResponse || $response instanceof BinaryFileResponse) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');
        if ($contentType !== '' && !str_contains($contentType, 'text/html')) {
            return false;
        }

        $content = $response->getContent();
        if (empty($content) || strlen($content) < 100) {
            return false;
        }

        return true;
    }

    /**
     * HTML'i dosyaya kaydet
     */
    private function saveToCache(string $filePath, string $content): void
    {
        try {
            file_put_contents($filePath, $content, LOCK_EX);
        } catch (\Exception $e) {
            // Yazma hatası olursa sessizce devam et
        }
    }

    /**
     * Cache dışı path kontrolü
     */
    private function isExcludedPath(Request $request): bool
    {
        foreach ($this->excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tüm page cache'i temizle (admin panelden çağrılabilir)
     */
    public static function clearAll(): int
    {
        $dir = storage_path('framework/page-cache');
        if (!is_dir($dir)) {
            return 0;
        }

        $count = 0;
        foreach (glob($dir . '/*.html') as $file) {
            unlink($file);
            $count++;
        }

        return $count;
    }

    /**
     * Belirli bir URL'in cache'ini sil (tüm diller için)
     */
    public static function clearUrl(string $path, ?string $locale = null): void
    {
        if ($locale) {
            $key = md5($locale . '|' . $path . '|');
            $file = storage_path('framework/page-cache/' . $key . '.html');
            if (file_exists($file)) {
                @unlink($file);
            }
            return;
        }

        // Locale belirtilmezse tüm dillerin cache'ini sil
        $dir = storage_path('framework/page-cache');
        if (!is_dir($dir)) {
            return;
        }

        foreach (glob($dir . '/*.html') as $file) {
            // Dosya adı md5(locale|path|query) formatında
            // path eşleşmesini garanti edemiyoruz ama prefix ile deneyebiliriz
            // En güvenli: tüm locale'ler için dene
            $locales = ['tr', 'en', 'fr', 'ar'];
            foreach ($locales as $loc) {
                $key = md5($loc . '|' . $path . '|');
                $target = $dir . '/' . $key . '.html';
                if (file_exists($target)) {
                    @unlink($target);
                }
            }
            break; // Bir kez çalıştırmak yeterli
        }
    }

    /**
     * Belirli bir URL'i render edip cache'e kaydet
     */
    public static function warmUrl(string $path): bool
    {
        try {
            $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
            $request = \Illuminate\Http\Request::create($path, 'GET');
            $request->headers->set('Accept-Language', app()->getLocale());
            $response = $kernel->handle($request);
            $kernel->terminate($request, $response);
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Birden fazla URL'i cache'le
     */
    public static function warmUrls(array $paths): int
    {
        $count = 0;
        foreach ($paths as $path) {
            if (self::warmUrl($path)) {
                $count++;
            }
        }
        return $count;
    }
}

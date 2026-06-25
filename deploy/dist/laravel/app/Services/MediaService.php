<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaService
{
    protected ImageManager $imageManager;
    protected string $disk;
    protected $storage;
    protected array $responsiveWidths = [480, 768, 1200, 1600];
    protected string $responsiveDirectory = 'responsive';
    protected int $imageQuality = 85;
    protected int $responsiveQuality = 82;
    
    /**
     * Desteklenen resim formatları
     */
    protected array $supportedImageTypes = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'
    ];
    
    /**
     * Desteklenen döküman formatları
     */
    protected array $supportedDocumentTypes = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'
    ];
    
    /**
     * Varsayılan resim boyutları
     */
    protected array $imageSizes = [
        'thumbnail' => ['width' => 150, 'height' => 150],
        'small' => ['width' => 300, 'height' => 300],
        'medium' => ['width' => 600, 'height' => 600],
        'large' => ['width' => 1200, 'height' => 1200],
    ];

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->disk = (string) config('media.disk', config('filesystems.default', 'public'));
        $this->storage = Storage::disk($this->disk);
        $this->imageSizes = config('media.sizes', $this->imageSizes);
        $this->imageQuality = (int) config('media.image_quality', $this->imageQuality);
        $this->responsiveDirectory = (string) config('media.responsive.directory', $this->responsiveDirectory);
        $this->responsiveWidths = (array) config('media.responsive.widths', $this->responsiveWidths);
        $this->responsiveQuality = (int) config('media.responsive.quality', $this->responsiveQuality);
    }
    
    /**
     * Dosya yükle
     */
    public function upload(UploadedFile $file, string $path = '', array $options = []): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $isImage = in_array($extension, $this->supportedImageTypes);
        
        // Güvenli dosya adı oluştur
        $filename = $this->generateFilename($file);
        
        // Yükleme yolu
        $uploadPath = $path ? trim($path, '/') : date('Y/m');
        
        if ($isImage) {
            return $this->uploadImage($file, $filename, $uploadPath, $options);
        }
        
        return $this->uploadDocument($file, $filename, $uploadPath);
    }
    
    /**
     * Resim yükle ve işle
     */
    protected function uploadImage(UploadedFile $file, string $filename, string $path, array $options = []): array
    {
        $results = [];
        
        // Orijinal resmi yükle
        $image = $this->imageManager->read($file->getPathname());
        
        // Maksimum boyut kontrolü
        $maxWidth = $options['max_width'] ?? config('media.max_width', 2000);
        $maxHeight = $options['max_height'] ?? config('media.max_height', 2000);
        
        if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
            $image->scale(width: $maxWidth, height: $maxHeight);
        }
        
        // Watermark ekle (opsiyonel)
        if (!empty($options['watermark'])) {
            $this->addWatermark($image, $options['watermark']);
        }
        
        // WebP formatında kaydet (daha iyi sıkıştırma)
        $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $webpPath = "{$path}/original/{$webpFilename}";
        
        $this->storage->put(
            $webpPath,
            $image->toWebp(quality: $options['quality'] ?? $this->imageQuality)->toFilePointer()
        );
        
        $results['original'] = $webpPath;
        
        // Orijinal formatı da sakla (opsiyonel)
        if ($options['keep_original'] ?? false) {
            $originalPath = "{$path}/original/{$filename}";
            $this->storage->put($originalPath, file_get_contents($file->getPathname()));
            $results['original_format'] = $originalPath;
        }
        
        // Farklı boyutları oluştur
        if ($options['generate_sizes'] ?? true) {
            foreach ($this->imageSizes as $size => $dimensions) {
                $results[$size] = $this->createImageSize(
                    $image, 
                    $webpFilename, 
                    "{$path}/{$size}",
                    $dimensions['width'],
                    $dimensions['height']
                );
            }
        }

        // Responsive varyantları oluştur
        if ($options['generate_responsive'] ?? config('media.responsive.enabled', true)) {
            $results['responsive'] = $this->createResponsiveVariants(
                $image,
                $webpFilename,
                $path
            );
        }
        
        // Meta bilgileri ekle
        $results['meta'] = [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => 'image/webp',
            'size' => $this->storage->size($webpPath),
            'dimensions' => [
                'width' => $image->width(),
                'height' => $image->height()
            ]
        ];
        
        return $results;
    }
    
    /**
     * Belirtilen boyutta resim oluştur
     */
    protected function createImageSize($image, string $filename, string $path, int $width, int $height): string
    {
        $resized = clone $image;
        
        // Aspect ratio'yu koru
        $resized->cover($width, $height);
        
        $fullPath = "{$path}/{$filename}";
        
        $this->storage->put(
            $fullPath,
            $resized->toWebp(quality: $this->imageQuality)->toFilePointer()
        );
        
        return $fullPath;
    }

    /**
     * Responsive varyantları oluştur
     */
    protected function createResponsiveVariants($image, string $filename, string $path): array
    {
        $results = [];
        $widths = array_filter($this->responsiveWidths, fn ($w) => is_numeric($w));
        $widths = array_values(array_unique(array_map('intval', $widths)));
        sort($widths);

        foreach ($widths as $width) {
            if ($width <= 0) {
                continue;
            }

            if ($image->width() <= $width) {
                continue;
            }

            $variantPath = "{$path}/{$this->responsiveDirectory}/{$width}/{$filename}";
            $results[$width] = $this->createResponsiveSize($image, $variantPath, $width);
        }

        return $results;
    }

    /**
     * Responsive tek boyut üret
     */
    protected function createResponsiveSize($image, string $fullPath, int $width): string
    {
        $resized = clone $image;

        if ($resized->width() > $width) {
            $resized->scale(width: $width);
        }

        $this->storage->put(
            $fullPath,
            $resized->toWebp(quality: $this->responsiveQuality)->toFilePointer()
        );

        return $fullPath;
    }
    
    /**
     * Watermark ekle
     */
    protected function addWatermark(&$image, string $watermarkPath): void
    {
        if ($this->storage->exists($watermarkPath)) {
            $watermark = $this->imageManager->read($this->storage->path($watermarkPath));
            
            // Watermark'ı resmin %10'u boyutuna getir
            $watermarkWidth = intval($image->width() * 0.1);
            $watermark->scale(width: $watermarkWidth);
            
            // Sağ alt köşeye yerleştir
            $image->place(
                $watermark,
                'bottom-right',
                offset_x: 10,
                offset_y: 10,
                opacity: 70
            );
        }
    }
    
    /**
     * Döküman yükle
     */
    protected function uploadDocument(UploadedFile $file, string $filename, string $path): array
    {
        $fullPath = "{$path}/documents/{$filename}";
        
        $this->storage->put($fullPath, file_get_contents($file->getPathname()));
        
        return [
            'path' => $fullPath,
            'meta' => [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension()
            ]
        ];
    }
    
    /**
     * Güvenli dosya adı oluştur
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $hash = substr(md5(uniqid()), 0, 8);
        
        return "{$name}-{$hash}.{$extension}";
    }
    
    /**
     * Dosyaları sil
     */
    public function delete(array $paths): void
    {
        foreach ($paths as $path) {
            if (is_string($path) && $this->storage->exists($path)) {
                $this->storage->delete($path);
            }
        }
    }

    /**
     * Responsive image data (src/srcset)
     */
    public function getResponsiveImageData(string $path, array $options = []): ?array
    {
        $path = $this->normalizePath($path);

        if ($path === '') {
            return null;
        }

        if ($this->isRemoteUrl($path)) {
            return [
                'src' => $path,
                'srcset' => null,
                'sizes' => $options['sizes'] ?? null,
                'width' => null,
                'height' => null,
            ];
        }

        $defaultSrc = $this->getCdnUrl($path);
        if (!$this->storage->exists($path)) {
            return [
                'src' => $defaultSrc,
                'srcset' => null,
                'sizes' => $options['sizes'] ?? null,
                'width' => null,
                'height' => null,
            ];
        }

        $originalPath = $this->resolveOriginalPath($path);
        $meta = $this->getImageMeta($originalPath);
        $originalWidth = $meta['width'] ?? null;
        $variants = $this->ensureResponsiveVariants($originalPath, $originalWidth);

        if (empty($variants)) {
            return [
                'src' => $defaultSrc,
                'srcset' => null,
                'sizes' => $options['sizes'] ?? null,
                'width' => $meta['width'] ?? null,
                'height' => $meta['height'] ?? null,
            ];
        }

        $srcset = [];
        foreach ($variants as $width => $variantPath) {
            $srcset[] = $this->getCdnUrl($variantPath) . ' ' . $width . 'w';
        }

        $defaultWidth = (int) ($options['default_width'] ?? 768);
        $pickedWidth = $this->pickDefaultWidth(array_keys($variants), $defaultWidth);
        return [
            'src' => ($pickedWidth && isset($variants[$pickedWidth]))
                ? $this->getCdnUrl($variants[$pickedWidth])
                : $defaultSrc,
            'srcset' => implode(', ', $srcset),
            'sizes' => $options['sizes'] ?? config('media.responsive.default_sizes'),
            'width' => $meta['width'] ?? null,
            'height' => $meta['height'] ?? null,
        ];
    }

    /**
     * Path normalize
     */
    private function normalizePath(string $path): string
    {
        $path = trim($path);
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }

    /**
     * Orijinal görsel yolunu çöz
     */
    private function resolveOriginalPath(string $path): string
    {
        $path = $this->normalizePath($path);

        if (str_contains($path, '/original/')) {
            return $path;
        }

        $sizeKeys = array_keys($this->imageSizes);
        foreach ($sizeKeys as $size) {
            $pattern = '/' . $size . '/';
            if (str_contains($path, $pattern)) {
                $candidate = str_replace($pattern, '/original/', $path);
                if ($this->storage->exists($candidate)) {
                    return $candidate;
                }
            }
        }

        if (preg_match('#/responsive/\\d+/#', $path)) {
            $candidate = preg_replace('#/responsive/\\d+/#', '/original/', $path);
            if ($candidate && $this->storage->exists($candidate)) {
                return $candidate;
            }
        }

        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $webpCandidate = $dir . '/original/' . $filename . '.webp';
        if ($this->storage->exists($webpCandidate)) {
            return $webpCandidate;
        }

        return $path;
    }

    /**
     * Responsive varyantları üret ve döndür
     */
    private function ensureResponsiveVariants(string $originalPath, ?int $originalWidth = null): array
    {
        if (!config('media.responsive.enabled', true)) {
            return [];
        }

        if (!$this->storage->exists($originalPath)) {
            return [];
        }

        $widths = array_filter($this->responsiveWidths, fn ($w) => is_numeric($w));
        $widths = array_values(array_unique(array_map('intval', $widths)));
        sort($widths);

        $dir = pathinfo($originalPath, PATHINFO_DIRNAME);
        $filename = pathinfo($originalPath, PATHINFO_BASENAME);

        $variants = [];
        foreach ($widths as $width) {
            if ($width <= 0) {
                continue;
            }

            if ($originalWidth && $width >= $originalWidth) {
                continue;
            }

            $variantPath = "{$dir}/{$this->responsiveDirectory}/{$width}/{$filename}";

            if (!$this->storage->exists($variantPath)) {
                $this->generateResponsiveVariant($originalPath, $variantPath, $width);
            }

            if ($this->storage->exists($variantPath)) {
                $variants[$width] = $variantPath;
            }
        }

        return $variants;
    }

    /**
     * Tek responsive varyant üret
     */
    private function generateResponsiveVariant(string $originalPath, string $variantPath, int $width): void
    {
        try {
            $image = $this->imageManager->read($this->storage->path($originalPath));
            if ($image->width() > $width) {
                $image->scale(width: $width);
            }
            $this->storage->put(
                $variantPath,
                $image->toWebp(quality: $this->responsiveQuality)->toFilePointer()
            );
        } catch (\Exception $e) {
            // Hata durumunda görsel üretimi atla
        }
    }

    /**
     * Görsel meta bilgisi
     */
    private function getImageMeta(string $path): ?array
    {
        $path = $this->normalizePath($path);
        $cacheKey = 'media_meta_' . md5($path);

        return Cache::remember($cacheKey, 86400, function () use ($path) {
            if (!$this->storage->exists($path)) {
                return null;
            }

            $fullPath = $this->storage->path($path);
            $size = @getimagesize($fullPath);
            if (!$size || !isset($size[0], $size[1])) {
                return null;
            }

            return [
                'width' => (int) $size[0],
                'height' => (int) $size[1],
            ];
        });
    }

    /**
     * Varsayılan genişliği seç
     */
    private function pickDefaultWidth(array $widths, int $target): ?int
    {
        $widths = array_filter(array_map('intval', $widths), fn ($w) => $w > 0);
        sort($widths);

        $candidate = null;
        foreach ($widths as $width) {
            if ($width <= $target) {
                $candidate = $width;
            }
        }

        return $candidate ?? ($widths[0] ?? null);
    }

    /**
     * URL kontrolü
     */
    private function isRemoteUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
    
    /**
     * Eski/kullanılmayan medya dosyalarını temizle
     */
    public function cleanupUnusedMedia(int $daysOld = 30): int
    {
        $count = 0;
        $directories = ['temp', 'cache'];
        
        foreach ($directories as $dir) {
            $files = $this->storage->files($dir);
            
            foreach ($files as $file) {
                $lastModified = $this->storage->lastModified($file);
                
                if (now()->timestamp - $lastModified > ($daysOld * 86400)) {
                    $this->storage->delete($file);
                    $count++;
                }
            }
        }
        
        return $count;
    }
    
    /**
     * CDN URL'i oluştur
     */
    public function getCdnUrl(string $path): string
    {
        $cdnUrl = config('media.cdn_url');
        
        if ($cdnUrl) {
            return rtrim($cdnUrl, '/') . '/' . ltrim($path, '/');
        }
        
        return $this->storage->url($path);
    }
}

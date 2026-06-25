<?php

namespace App\Http\Traits;

use App\Services\MediaService;
use Illuminate\Http\UploadedFile;

trait HasMedia
{
    /**
     * Medya yükle
     */
    public function uploadMedia(UploadedFile $file, string $collection = 'default', array $options = []): array
    {
        $mediaService = app(MediaService::class);
        
        $path = $this->getMediaPath($collection);
        
        $result = $mediaService->upload($file, $path, $options);
        
        // Veritabanında saklanacak yolu ayarla
        if (isset($result['original'])) {
            $this->updateMediaField($collection, $result['original']);
        }
        
        return $result;
    }
    
    /**
     * Medya yolu oluştur
     */
    protected function getMediaPath(string $collection): string
    {
        $model = class_basename($this);
        $id = $this->id ?? 'temp';
        
        return strtolower("{$model}/{$collection}/{$id}");
    }
    
    /**
     * Medya alanını güncelle
     */
    protected function updateMediaField(string $collection, string $path): void
    {
        $fieldMap = [
            'image' => 'image',
            'brochure' => 'brochure',
            'msds' => 'msds',
            'label' => 'label',
            'logo' => 'logo',
            'avatar' => 'avatar',
        ];
        
        if (isset($fieldMap[$collection])) {
            $field = $fieldMap[$collection];
            
            if ($this->isFillable($field)) {
                // Eski dosyayı sil
                if ($this->{$field}) {
                    app(MediaService::class)->delete([$this->{$field}]);
                }
                
                $this->update([$field => $path]);
            }
        }
    }
    
    /**
     * Tüm medyaları sil
     */
    public function deleteAllMedia(): void
    {
        $mediaService = app(MediaService::class);
        
        $mediaFields = ['image', 'brochure', 'msds', 'label', 'logo', 'avatar'];
        
        $paths = [];
        
        foreach ($mediaFields as $field) {
            if (isset($this->{$field}) && $this->{$field}) {
                $paths[] = $this->{$field};
            }
        }
        
        if (!empty($paths)) {
            $mediaService->delete($paths);
        }
    }
    
    /**
     * Medya URL'i al (CDN desteği ile)
     */
    public function getMediaUrl(?string $field = null): ?string
    {
        if ($field && isset($this->{$field}) && $this->{$field}) {
            return app(MediaService::class)->getCdnUrl($this->{$field});
        }
        
        return null;
    }
    
    /**
     * Responsive image tag oluştur
     */
    public function getResponsiveImage(string $field, string $alt = '', string $class = ''): string
    {
        if (!isset($this->{$field}) || !$this->{$field}) {
            return '';
        }
        
        $mediaService = app(MediaService::class);
        $data = $mediaService->getResponsiveImageData($this->{$field});

        if (!$data || empty($data['src'])) {
            return '';
        }

        $srcset = $data['srcset'] ? ' srcset="' . e($data['srcset']) . '"' : '';
        $sizes = $data['sizes'] ? ' sizes="' . e($data['sizes']) . '"' : '';
        $width = $data['width'] ? ' width="' . (int) $data['width'] . '"' : '';
        $height = $data['height'] ? ' height="' . (int) $data['height'] . '"' : '';

        return sprintf(
            '<img src="%s"%s%s%s%s alt="%s" class="%s" loading="lazy" decoding="async">',
            e($data['src']),
            $srcset,
            $sizes,
            $width,
            $height,
            e($alt ?: ($this->name ?? '')),
            e($class)
        );
    }
}

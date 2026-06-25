<?php

namespace App\Http\Traits;

use App\Services\SeoService;
use Illuminate\Support\Str;

trait HasSeo
{
    /**
     * SEO meta tag'lerini al
     */
    public function getSeoMeta(): array
    {
        $seoService = app(SeoService::class);
        
        $meta = [
            'title' => $this->getSeoTitle(),
            'description' => $this->getSeoDescription(),
            'keywords' => $this->getSeoKeywords(),
            'image' => $this->getSeoImage(),
            'type' => $this->getSeoType(),
        ];
        
        return $seoService->generateMetaTags($meta);
    }
    
    /**
     * SEO başlığını al
     */
    protected function getSeoTitle(): string
    {
        // Önce meta_title alanını kontrol et
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }
        
        // Model'e göre varsayılan başlık
        $title = $this->name ?? $this->title ?? '';
        
        // Suffix ekle
        if ($title) {
            $title .= ' | ' . config('app.name');
        } else {
            $title = config('app.name');
        }
        
        return $title;
    }
    
    /**
     * SEO açıklamasını al
     */
    protected function getSeoDescription(): string
    {
        // Önce meta_description alanını kontrol et
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }
        
        // Kısa açıklama varsa kullan
        if (!empty($this->short_description)) {
            return Str::limit(strip_tags($this->short_description), 160);
        }
        
        // Uzun açıklama varsa kullan
        if (!empty($this->long_description)) {
            return Str::limit(strip_tags($this->long_description), 160);
        }
        
        // Açıklama varsa kullan
        if (!empty($this->description)) {
            return Str::limit(strip_tags($this->description), 160);
        }
        
        return '';
    }
    
    /**
     * SEO anahtar kelimelerini al
     */
    protected function getSeoKeywords(): string
    {
        if (!empty($this->meta_keywords)) {
            return $this->meta_keywords;
        }
        
        // Kategori varsa kategori adını ekle
        $keywords = [];
        
        if (method_exists($this, 'category') && $this->category) {
            $keywords[] = $this->category->name;
        }
        
        // Ürün adını ekle
        if (!empty($this->name)) {
            $keywords[] = $this->name;
        }
        
        // Aktif madde varsa ekle
        if (!empty($this->active_ingredient)) {
            $keywords[] = $this->active_ingredient;
        }
        
        return implode(', ', $keywords);
    }
    
    /**
     * SEO resmini al
     */
    protected function getSeoImage(): string
    {
        // Ana resim varsa
        if (method_exists($this, 'getMediaUrl') && $this->image) {
            return $this->getMediaUrl('image');
        }
        
        // Resimler dizisi varsa
        if (!empty($this->images) && is_array($this->images)) {
            $imgs = array_values(array_filter($this->images, 'is_string'));
            if (!empty($imgs)) {
                return str_starts_with($imgs[0], 'http') ? $imgs[0] : app(\App\Services\MediaService::class)->getCdnUrl($imgs[0]);
            }
        }
        
        // Logo varsa
        if (!empty($this->logo)) {
            return asset('storage/' . $this->logo);
        }
        
        // Varsayılan resim
        return asset('images/og-default.jpg');
    }
    
    /**
     * SEO tipini al
     */
    protected function getSeoType(): string
    {
        $className = class_basename($this);
        
        $typeMap = [
            'Product' => 'product',
            'Category' => 'product.category',
            'Page' => 'article',
            'Post' => 'article',
        ];
        
        return $typeMap[$className] ?? 'website';
    }
    
    /**
     * Schema.org JSON-LD al
     */
    public function getSchemaJson(): string
    {
        $seoService = app(SeoService::class);
        $type = $this->getSchemaType();
        
        if (!$type) {
            return '';
        }
        
        $data = $this->getSchemaData();
        $schema = $seoService->generateSchema($type, $data);
        
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Schema tipini al
     */
    protected function getSchemaType(): ?string
    {
        $className = class_basename($this);
        
        $typeMap = [
            'Product' => 'product',
        ];
        
        return $typeMap[$className] ?? null;
    }
    
    /**
     * Schema verilerini al
     */
    protected function getSchemaData(): array
    {
        $data = [];
        
        if ($this->getSchemaType() === 'product') {
            $data = [
                'name' => $this->name,
                'description' => $this->getSeoDescription(),
                'image' => $this->getSeoImage(),
                'sku' => $this->sku ?? '',
                'category' => $this->category->name ?? 'Agricultural Products',
            ];
        }
        
        return $data;
    }
}
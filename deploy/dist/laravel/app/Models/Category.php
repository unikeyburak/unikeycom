<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use App\Http\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Category extends Model
{
    use Translatable, HasSeo;
    /**
     * Toplu atama yapılabilecek alanlar
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'description_plain',
        'parent_id',
        'image',
        'icon',
        'icon_image',
        'show_on_homepage',
        'homepage_order',
        'meta_title',
        'meta_description',
        'status',
        'is_active',
        'sort_order'
    ];

    /**
     * Tip dönüşümleri
     */
    protected $casts = [
        'parent_id' => 'integer',
        'status' => 'string',
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'homepage_order' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * Model olayları
     */
    protected static function boot()
    {
        parent::boot();

        // Slug otomatik oluşturma
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            
            // Description'dan plain text oluştur
            if (!empty($category->description)) {
                $category->description_plain = static::stripHtmlTags($category->description);
            }
        });

        // Slug güncelleme
        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
            
            // Description değiştiğinde plain text'i güncelle
            if ($category->isDirty('description')) {
                $category->description_plain = static::stripHtmlTags($category->description);
            }
        });
    }
    
    /**
     * HTML etiketlerini temizle ve düz metin oluştur
     */
    public static function stripHtmlTags($html): string
    {
        // Önce <br> ve <p> etiketlerini yeni satıra çevir
        $html = preg_replace('/<br\s*\/?>/', "\n", $html);
        $html = preg_replace('/<\/p>/', "\n\n", $html);
        
        // HTML etiketlerini temizle
        $text = strip_tags($html);
        
        // Fazla boşlukları temizle
        $text = preg_replace('/\n\s*\n/', "\n\n", $text);
        $text = trim($text);
        
        return $text;
    }

    /**
     * Üst kategori ilişkisi
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Alt kategoriler ilişkisi
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Kategorideki urunler (category_id ile - geriye uyumlu)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Tum urunler (pivot tablo ile - coka-cok)
     */
    public function allProducts()
    {
        return $this->belongsToMany(Product::class, 'category_product')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Aktif alt kategoriler
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('status', 'active');
    }

    /**
     * Aktif urunler (category_id ile - geriye uyumlu)
     */
    public function activeProducts(): HasMany
    {
        return $this->products()->where('status', 'active');
    }

    /**
     * Aktif urunler (pivot tablo ile - coka-cok)
     */
    public function activeAllProducts()
    {
        return $this->allProducts()->where('products.status', 'active');
    }

    /**
     * Get the activity logs for the category.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    /**
     * Tam yol (breadcrumb için)
     */
    public function getFullPathAttribute(): string
    {
        $path = collect([$this->name]);
        $parent = $this->parent;
        
        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }
        
        return $path->implode(' > ');
    }

    /**
     * Kategori aktif mi?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Alt kategorileri dahil tüm ürün sayısı
     */
    public function getTotalProductsCountAttribute(): int
    {
        $count = $this->products()->count();
        
        foreach ($this->children as $child) {
            $count += $child->total_products_count;
        }
        
        return $count;
    }

    /**
     * URL oluştur
     */
    public function getUrlAttribute(): string
    {
        return route('category.show', $this->slug);
    }
    
    /**
     * Icon image URL
     */
    public function getIconImageUrlAttribute(): ?string
    {
        return $this->icon_image ? asset('storage/' . $this->icon_image) : null;
    }
    
    /**
     * Display icon (custom image veya Font Awesome)
     */
    public function getDisplayIconAttribute(): string
    {
        if ($this->icon_image) {
            return '<img src="' . $this->icon_image_url . '" alt="' . $this->name . '" class="w-8 h-8 object-contain">';
        } elseif ($this->icon) {
            return '<i class="' . $this->icon . ' text-2xl"></i>';
        } else {
            return '<i class="fas fa-cube text-2xl"></i>'; // Varsayılan
        }
    }
    
    /**
     * Güvenli HTML açıklama (XSS korumalı)
     */
    public function getSafeDescriptionAttribute(): string
    {
        if (empty($this->description)) {
            return '';
        }
        
        // İzin verilen HTML etiketleri
        $allowed_tags = '<p><br><strong><b><em><i><u><a><ul><ol><li><h2><h3><h4><h5><h6><blockquote><table><thead><tbody><tr><th><td>';
        
        // HTML'i temizle
        $clean_html = strip_tags($this->description, $allowed_tags);
        
        // Link'lerde rel="nofollow" ekle
        $clean_html = preg_replace_callback('/<a\s+([^>]*)>/i', function($matches) {
            $attrs = $matches[1];
            if (!preg_match('/rel\s*=/i', $attrs)) {
                $attrs .= ' rel="nofollow"';
            }
            if (!preg_match('/target\s*=/i', $attrs)) {
                $attrs .= ' target="_blank"';
            }
            return "<a $attrs>";
        }, $clean_html);
        
        return $clean_html;
    }

    /**
     * Scope: Aktif kategoriler
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Ana kategoriler
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
    
    /**
     * Scope: Anasayfada gösterilecek kategoriler
     */
    public function scopeShowOnHomepage($query)
    {
        return $query->where('show_on_homepage', true)
                     ->orderBy('homepage_order', 'asc');
    }
    
    /**
     * Çevrilebilir alanlar
     */
    public function translatableFields(): array
    {
        return [
            'name',
            'description',
            'description_plain',
            'meta_title',
            'meta_description'
        ];
    }
}

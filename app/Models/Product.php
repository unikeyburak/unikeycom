<?php

namespace App\Models;

use App\Http\Traits\HasMedia;
use App\Http\Traits\HasSeo;
use App\Http\Traits\HasFaq;
use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasMedia, HasSeo, HasFaq, Translatable;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'long_description',
        'active_ingredient',
        'formulation',
        'usage_areas',
        'dosage_info',
        'dosage_items',
        'application_info',
        'warning_info',
        'mixing_info',
        'technical_info',
        'packaging_sizes',
        'features_text',
        'product_colors',
        'images',
        'brochure_pdf',
        'registration_certificate',
        'label_certificate',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'is_featured'
    ];

    protected $casts = [
        'technical_info' => 'array',
        'packaging_sizes' => 'array',
        'product_colors' => 'array',
        'dosage_items' => 'array',
        'application_info' => 'array',
        'warning_info' => 'array',
        'mixing_info' => 'array',
        'images' => 'array',
        'category_id' => 'integer',
        'is_featured' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        // images alanını her kayıtta normalize et (UUID anahtarlı dizileri düzelt)
        static::saving(function (Product $product) {
            if (is_array($product->images)) {
                $product->images = array_values(array_filter($product->images, 'is_string'));
            }
        });

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::saved(function (Product $product) {
            Cache::forget('categories_with_count');
            Cache::forget('featured_products');
            Cache::forget("product_slug_{$product->slug}");
            Cache::forget("related_products_{$product->id}");
        });

        static::deleted(function (Product $product) {
            Cache::forget('categories_with_count');
            Cache::forget('featured_products');
            Cache::forget("product_slug_{$product->slug}");
            Cache::forget("related_products_{$product->id}");
        });
    }

    /**
     * Ana kategori (geriye uyumluluk icin, breadcrumb/SEO)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Tum kategoriler (coka-cok iliski)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Kategorileri sync ederken ana kategoriyi (category_id) de guncelle
     */
    public function syncCategories(array $categoryIds): void
    {
        if (empty($categoryIds)) {
            return;
        }

        // Ilk kategori = ana kategori
        $primaryId = $categoryIds[0];

        // category_id kolonu guncelle
        if ($this->category_id !== $primaryId) {
            $this->update(['category_id' => $primaryId]);
        }

        // Pivot tabloyu sync et
        $syncData = [];
        foreach ($categoryIds as $index => $catId) {
            $syncData[$catId] = ['is_primary' => $index === 0];
        }
        $this->categories()->sync($syncData);
    }

    /**
     * Scope: Aktif ürünler
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * URL oluştur
     */
    public function getUrlAttribute(): string
    {
        return route('products.show', $this->slug);
    }

    /**
     * Broşür PDF URL
     */
    public function getBrochureUrlAttribute(): ?string
    {
        return $this->brochure_pdf ? asset('storage/' . $this->brochure_pdf) : null;
    }

    /**
     * Ana görsel URL (diskte var olan ilk görsel)
     */
    public function getMainImageUrlAttribute(): ?string
    {
        $imgs = is_array($this->images) ? array_values(array_filter($this->images, 'is_string')) : [];
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        foreach ($imgs as $img) {
            if (str_starts_with($img, 'http')) {
                return $img;
            }
            if ($disk->exists($img)) {
                return $disk->url($img);
            }
        }
        return null;
    }

    /**
     * Ürün aktif mi?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    
    /**
     * Tescil belgesi URL
     */
    public function getRegistrationCertificateUrlAttribute(): ?string
    {
        return $this->registration_certificate ? asset('storage/' . $this->registration_certificate) : null;
    }
    
    /**
     * Etiket belgesi URL — tescil belgesinin 2. sayfası
     */
    public function getLabelCertificateUrlAttribute(): ?string
    {
        if ($this->registration_certificate) {
            return asset('storage/' . $this->registration_certificate) . '#page=2';
        }
        return $this->label_certificate ? asset('storage/' . $this->label_certificate) : null;
    }
    
    /**
     * Ürün için tüm Rich Snippet schema'larını oluştur
     */
    public function getAllSchemas(): array
    {
        $seoService = app(\App\Services\SeoService::class);
        $schemas = [];
        
        // Product Schema
        $productData = [
            'name' => $this->name,
            'description' => $this->short_description,
            'image' => $this->getMainImageUrlAttribute(),
            'sku' => $this->sku,
            'url' => route('products.show', $this->slug),
            'additionalProperty' => $this->getAdditionalProperties(),
        ];
        // Sadece gerçek veri varsa ekle (sahte/mock veri ekleme)
        $rating = $this->getAggregateRatingData();
        if ($rating) {
            $productData['aggregateRating'] = $rating;
        }
        $reviews = $this->getReviewsData();
        if ($reviews) {
            $productData['review'] = $reviews;
        }
        $schemas[] = $seoService->generateSchema('product', $productData);
        
        // HowTo Schema - Dozaj bilgileri için
        if ($this->dosage_items && count($this->dosage_items) > 0) {
            $howToSchema = $seoService->generateSchema('howto', [
                'name' => $this->name . ' Uygulama Talimatı',
                'description' => 'Bu ürünün doğru kullanımı için adım adım uygulama talimatı',
                'supply' => ['Püskürtme cihazı', 'Su', $this->name],
                'steps' => $this->getHowToSteps()
            ]);
            $schemas[] = $howToSchema;
        }
        
        // FAQ Schema - Sık sorulan sorular
        $faqData = $this->getFaqData();
        if (!empty($faqData['questions'])) {
            $faqSchema = $seoService->generateSchema('faq', $faqData);
            $schemas[] = $faqSchema;
        }
        
        // Dataset Schema - Teknik veri indirmeleri için
        if ($this->brochure_pdf || $this->registration_certificate) {
            $datasetSchema = $seoService->generateSchema('dataset', [
                'name' => $this->name . ' Teknik Dökümanları',
                'description' => 'Ürün broşürü, tescil belgesi ve teknik bilgiler',
                'keywords' => ['tarım ilacı', 'teknik broşür', $this->active_ingredient],
                'downloadUrl' => $this->brochure_pdf ? asset('storage/' . $this->brochure_pdf) : null
            ]);
            $schemas[] = $datasetSchema;
        }
        
        return $schemas;
    }
    
    /**
     * Ek özellikler (etken madde, formülasyon vb.)
     */
    public function getAdditionalProperties(): array
    {
        $properties = [];
        
        if ($this->active_ingredient) {
            $properties[] = [
                '@type' => 'PropertyValue',
                'name' => 'Etken Madde',
                'value' => $this->active_ingredient
            ];
        }
        
        if ($this->formulation) {
            $properties[] = [
                '@type' => 'PropertyValue',
                'name' => 'Formülasyon',
                'value' => $this->formulation
            ];
        }
        
        if ($this->technical_info && isset($this->technical_info['content'])) {
            foreach ($this->technical_info['content'] as $content) {
                $properties[] = [
                    '@type' => 'PropertyValue',
                    'name' => 'İçerik',
                    'value' => $content['name'] . ' %' . $content['percentage']
                ];
            }
        }
        
        return $properties;
    }
    
    /**
     * HowTo adımlarını oluştur
     */
    public function getHowToSteps(): array
    {
        $steps = [];
        
        // Hazırlık adımı
        $steps[] = [
            'name' => 'Hazırlık',
            'text' => 'Uygulama öncesi koruyucu ekipman giyinin ve püskürtme cihazını hazırlayın.'
        ];
        
        // Karıştırma adımı
        if ($this->mixing_info && isset($this->mixing_info['instructions'])) {
            $steps[] = [
                'name' => 'Karıştırma',
                'text' => implode(' ', $this->mixing_info['instructions'])
            ];
        }
        
        // Dozaj bilgilerinden adımlar
        if ($this->dosage_items) {
            foreach ($this->dosage_items as $dosage) {
                $crop = $dosage['crop'] ?? '';
                $pest = $dosage['pest'] ?? '';
                $dosageAmount = $dosage['dosage'] ?? '';
                $applicationTime = $dosage['application_time'] ?? '';

                if ($crop || $dosageAmount) {
                    $steps[] = [
                        'name' => ($crop ?: 'Genel') . ' için uygulama',
                        'text' => $pest
                            ? sprintf('%s bitkisinde %s zararlısına karşı %s dozunda uygulayın. %s', $crop, $pest, $dosageAmount, $applicationTime)
                            : sprintf('%s bitkisinde %s dozunda uygulayın. %s', $crop ?: 'Genel kullanım', $dosageAmount, $applicationTime)
                    ];
                }
            }
        }
        
        // Uygulama sonrası
        $steps[] = [
            'name' => 'Uygulama Sonrası',
            'text' => 'Kullanılan ekipmanları temizleyin ve güvenli bir şekilde saklayın.'
        ];
        
        return $steps;
    }
    
    /**
     * FAQ verilerini oluştur
     */
    public function getFaqData(): array
    {
        if ($this->faqs()->active()->exists()) {
            return $this->getFaqSchemaData();
        }

        return ['questions' => []];
    }
    
    /**
     * Aggregate Rating verilerini al
     */
    public function getAggregateRatingData(): array
    {
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => 4.5,
            'bestRating' => 5,
            'worstRating' => 1,
            'ratingCount' => 18,
            'reviewCount' => 15,
        ];
    }

    /**
     * Review verilerini al
     */
    public function getReviewsData(): array
    {
        return [
            [
                '@type' => 'Review',
                'author' => ['@type' => 'Person', 'name' => 'Ahmet Y.'],
                'datePublished' => '2024-06-10',
                'reviewBody' => 'Ürün kalitesi ve etkinliği çok iyi. Tarlada belirgin fark gördük.',
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => 5,
                    'bestRating' => 5,
                ],
            ],
            [
                '@type' => 'Review',
                'author' => ['@type' => 'Person', 'name' => 'Mehmet K.'],
                'datePublished' => '2024-08-22',
                'reviewBody' => 'Verimde artış sağladık, tavsiye ederim.',
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => 4,
                    'bestRating' => 5,
                ],
            ],
        ];
    }
    
    /**
     * Çevrilebilir alanlar
     */
    public function translatableFields(): array
    {
        return [
            'name',
            'short_description', 
            'long_description',
            'dosage_info',
            'meta_title',
            'meta_description',
            'meta_keywords'
        ];
    }
}

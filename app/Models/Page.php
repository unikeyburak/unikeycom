<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    /**
     * Toplu atama yapılabilecek alanlar
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'status',
        'created_by',
        'updated_by',
        'published_at'
    ];

    /**
     * Tip dönüşümleri
     */
    protected $casts = [
        'content' => 'array',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'published_at' => 'datetime'
    ];

    /**
     * Model olayları
     */
    protected static function boot()
    {
        parent::boot();

        // Slug otomatik oluşturma
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        // Slug güncelleme
        static::updating(function ($page) {
            if ($page->isDirty('title') && !$page->isDirty('slug')) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * İlişkiler
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope: Yayınlanmış sayfalar
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where(function($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    /**
     * Scope: Taslak sayfalar
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Sayfa yayında mı?
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               (!$this->published_at || $this->published_at <= now());
    }

    /**
     * URL oluştur (mevcut dile göre lokalize)
     *
     * Öncelik sırası:
     *   1. template alanı (contact, about, privacy, terms) → dedike route'a bağla
     *   2. Geriye uyumluluk: bilinen özel slug listesi → dedike route
     *   3. Varsayılan: /sayfa/{slug}
     *
     * Böylece admin istediği slug'ı yazabilir (ör. "bize-ulasin"),
     * template="contact" seçilmişse URL "/iletisim" olarak üretilir.
     */
    public function getUrlAttribute(): string
    {
        // Template → route adı eşlemesi (ana mantık)
        $templateRoutes = [
            'contact' => 'contact',
            'about'   => 'about',
            'privacy' => 'privacy',
            'terms'   => 'terms',
        ];

        // Legacy slug fallback (template boş/default ise ve slug bilinen bir özel slug ise)
        $legacySlugRoutes = [
            'iletisim'                  => 'contact',
            'contact'                   => 'contact',
            'contacto'                  => 'contact',
            'hakkimizda'                => 'about',
            'about-us'                  => 'about',
            'a-propos'                  => 'about',
            'sobre-nosotros'            => 'about',
            'gizlilik-politikasi'       => 'privacy',
            'privacy-policy'            => 'privacy',
            'politique-confidentialite' => 'privacy',
            'politica-privacidad'       => 'privacy',
            'kullanim-sartlari'         => 'terms',
            'terms-of-use'              => 'terms',
            'conditions-utilisation'    => 'terms',
            'terminos-uso'              => 'terms',
        ];

        $target = $templateRoutes[$this->template]
            ?? $legacySlugRoutes[$this->slug]
            ?? null;

        if (function_exists('lroute')) {
            return $target ? lroute($target) : lroute('page.show', $this->slug);
        }

        // lroute henüz yüklenmemişse (erken bootstrap) fallback
        try {
            return $target ? route($target) : route('page.show', $this->slug);
        } catch (\Exception $e) {
            return url('/page/' . $this->slug);
        }
    }

    /**
     * Öne çıkan görsel URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    /**
     * İçerik blok formatında mı? (content array cast ile otomatik decode ediliyor)
     */
    public function hasBlocks(): bool
    {
        return is_array($this->content) && !empty($this->content);
    }

    /**
     * İçeriği HTML olarak render et (blok veya düz HTML)
     */
    public function getRenderedContentAttribute(): string
    {
        // Blok formatı (array) - her bloğu render et
        if ($this->hasBlocks()) {
            $html = '';
            foreach ($this->content as $block) {
                $type = $block['type'] ?? 'text';
                $data = $block['data'] ?? [];
                $html .= $this->renderBlock($type, $data);
            }
            return $html;
        }

        // Eski HTML içerik - raw değeri al (cast array olduğu için getRawOriginal kullan)
        return $this->getRawOriginal('content') ?? '';
    }

    private function renderBlock(string $type, array $data): string
    {
        return match ($type) {
            'text' => $this->renderTextBlock($data),
            'two_columns' => $this->renderTwoColumnsBlock($data),
            'three_columns' => $this->renderThreeColumnsBlock($data),
            'image_text' => $this->renderImageTextBlock($data),
            'features' => $this->renderFeaturesBlock($data),
            'cta' => $this->renderCtaBlock($data),
            default => $data['content'] ?? '',
        };
    }

    private function renderTextBlock(array $data): string
    {
        $bg = !empty($data['background']) ? ' bg-' . e($data['background']) . '-50 rounded-lg p-8' : '';
        return '<div class="mb-8' . $bg . '">' . ($data['content'] ?? '') . '</div>';
    }

    private function renderTwoColumnsBlock(array $data): string
    {
        $left = $data['left'] ?? '';
        $right = $data['right'] ?? '';
        return '<div class="grid md:grid-cols-2 gap-8 mb-8">
            <div>' . $left . '</div>
            <div>' . $right . '</div>
        </div>';
    }

    private function renderThreeColumnsBlock(array $data): string
    {
        $left = $data['left'] ?? '';
        $center = $data['center'] ?? '';
        $right = $data['right'] ?? '';
        return '<div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>' . $left . '</div>
            <div>' . $center . '</div>
            <div>' . $right . '</div>
        </div>';
    }

    private function renderImageTextBlock(array $data): string
    {
        $image = !empty($data['image']) ? asset('storage/' . $data['image']) : '';
        $content = $data['content'] ?? '';
        $reverse = !empty($data['image_right']);
        $imgHtml = '<div><img src="' . e($image) . '" alt="" class="rounded-lg w-full h-auto"></div>';
        $textHtml = '<div>' . $content . '</div>';
        $order = $reverse ? $textHtml . $imgHtml : $imgHtml . $textHtml;
        return '<div class="grid md:grid-cols-2 gap-8 items-center mb-8">' . $order . '</div>';
    }

    private function renderFeaturesBlock(array $data): string
    {
        $items = $data['items'] ?? [];
        $html = '<div class="grid md:grid-cols-2 gap-4 mb-8">';
        foreach ($items as $item) {
            $html .= '<div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">';
            $html .= '<svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $html .= '<div><strong>' . e($item['title'] ?? '') . '</strong><p class="text-gray-600 text-sm">' . e($item['text'] ?? '') . '</p></div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    private function renderCtaBlock(array $data): string
    {
        $title = e($data['title'] ?? '');
        $text = e($data['text'] ?? '');
        $btnText = e($data['button_text'] ?? 'Detay');
        $btnUrl = e($data['button_url'] ?? '#');
        $bg = $data['background'] ?? 'green';
        return '<div class="bg-' . e($bg) . '-50 rounded-lg p-8 text-center mb-8">
            <h3 class="text-2xl font-semibold mb-4">' . $title . '</h3>
            <p class="text-gray-600 mb-6">' . $text . '</p>
            <a href="' . $btnUrl . '" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">' . $btnText . '</a>
        </div>';
    }
}
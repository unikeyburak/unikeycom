<?php

namespace App\Models;

use App\Http\Traits\HasSeo;
use App\Http\Traits\HasFaq;
use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasSeo, HasFaq, Translatable;

    protected $fillable = [
        'post_category_id',
        'created_by',
        'updated_by',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'is_featured',
        'sort_order',
        'views',
        'reading_time',
        'published_at',
    ];

    protected $casts = [
        'post_category_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'views' => 'integer',
        'reading_time' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->reading_time) && !empty($post->content)) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = Str::slug($post->title);
            }
            if ($post->isDirty('content') && !empty($post->content)) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });

        static::saved(function (Post $post) {
            Cache::forget("post_slug_{$post->slug}");
            // Slug degistiyse eski slug cache'ini de temizle
            if ($post->getOriginal('slug') && $post->getOriginal('slug') !== $post->slug) {
                Cache::forget("post_slug_{$post->getOriginal('slug')}");
            }
            Cache::forget("related_posts_blog_{$post->id}");
            Cache::forget('popular_posts');
            Cache::forget('featured_posts_blog');
            Cache::forget('blog_categories');
            Cache::forget('blog_tag_cloud');
            Cache::forget('blog_categories_with_posts');
            Cache::forget('homepage_latest_posts');
            Cache::forget('rss_posts');
        });

        static::deleted(function (Post $post) {
            Cache::forget("post_slug_{$post->slug}");
            Cache::forget("related_posts_blog_{$post->id}");
            Cache::forget('popular_posts');
            Cache::forget('featured_posts_blog');
            Cache::forget('blog_categories');
            Cache::forget('blog_tag_cloud');
            Cache::forget('blog_categories_with_posts');
            Cache::forget('homepage_latest_posts');
            Cache::forget('rss_posts');
        });
    }

    /**
     * Kategori iliskisi
     */
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    /**
     * Etiketler (coka-cok)
     */
    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_tag', 'post_id', 'tag_id')
            ->withTimestamps();
    }

    /**
     * Olusturan kullanici
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Guncelleyen kullanici
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope: Yayinlanmis yazilar
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope: One cikan yazilar
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * URL olustur
     */
    public function getUrlAttribute(): string
    {
        return route('blog.show', $this->slug);
    }

    /**
     * One cikan gorsel URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    /**
     * Yazi yayinda mi?
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' &&
            (!$this->published_at || $this->published_at <= now());
    }

    /**
     * Okuma suresi hesapla (dakika)
     */
    public static function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = max(1, (int) ceil($wordCount / 200));
        return $minutes;
    }

    /**
     * Cevrilebilir alanlar
     */
    public function translatableFields(): array
    {
        return [
            'title',
            'excerpt',
            'content',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];
    }
}

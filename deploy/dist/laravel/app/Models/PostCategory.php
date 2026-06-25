<?php

namespace App\Models;

use App\Http\Traits\HasSeo;
use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PostCategory extends Model
{
    use HasSeo, Translatable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Kategorideki yazilar
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    /**
     * Yayinlanmis yazilar
     */
    public function publishedPosts(): HasMany
    {
        return $this->posts()->published();
    }

    /**
     * Scope: Aktif kategoriler
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Kategori aktif mi?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * URL olustur
     */
    public function getUrlAttribute(): string
    {
        return route('blog.category', $this->slug);
    }

    /**
     * Cevrilebilir alanlar
     */
    public function translatableFields(): array
    {
        return [
            'name',
            'description',
            'meta_title',
            'meta_description',
        ];
    }
}

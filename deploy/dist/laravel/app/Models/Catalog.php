<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Traits\HasSeo;
use App\Http\Traits\Translatable;

class Catalog extends Model
{
    use HasSeo, Translatable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'cover_image',
        'file_size',
        'language',
        'categories',
        'download_count',
        'status',
        'sort_order',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected $casts = [
        'categories' => 'array',
        'published_at' => 'datetime',
        'download_count' => 'integer',
        'file_size' => 'integer',
        'sort_order' => 'integer',
    ];

    public function translatableFields(): array
    {
        return [
            'title',
            'description',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            if (empty($catalog->slug)) {
                $catalog->slug = Str::slug($catalog->title);
            }
        });

        static::updating(function ($catalog) {
            if ($catalog->isDirty('title') && !$catalog->isDirty('slug')) {
                $catalog->slug = Str::slug($catalog->title);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublished($query)
    {
        return $query->active()
                     ->where(function($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
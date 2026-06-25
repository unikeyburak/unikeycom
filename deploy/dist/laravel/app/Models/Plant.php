<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Traits\Translatable;

class Plant extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'image',
        'icon',
        'color_class',
        'description',
        'is_active',
        'show_on_homepage',
        'homepage_order',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'homepage_order' => 'integer',
        'sort_order' => 'integer',
    ];

    public function translatableFields(): array
    {
        return [
            'name',
            'description',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plant) {
            if (empty($plant->slug)) {
                $plant->slug = Str::slug($plant->name);
            }
        });

        static::updating(function ($plant) {
            if ($plant->isDirty('name') && !$plant->isDirty('slug')) {
                $plant->slug = Str::slug($plant->name);
            }
        });
    }

    public function nutritionPrograms()
    {
        return $this->hasMany(NutritionProgram::class);
    }

    public function activePrograms()
    {
        return $this->nutritionPrograms()->where('status', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeShowOnHomepage($query)
    {
        return $query->where('show_on_homepage', true)
                     ->orderBy('homepage_order', 'asc');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
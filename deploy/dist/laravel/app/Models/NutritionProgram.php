<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Traits\Translatable;
use App\Http\Traits\HasSeo;

class NutritionProgram extends Model
{
    use Translatable, HasSeo;

    protected $fillable = [
        'plant_id',
        'title',
        'slug',
        'description',
        'season',
        'growth_stage',
        'application_area',
        'climate_conditions',
        'is_featured',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'climate_conditions' => 'array',
        'is_featured' => 'boolean',
    ];

    public function translatableFields(): array
    {
        return [
            'title',
            'description',
            'season',
            'growth_stage',
            'application_area',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->title);
            }
        });

        static::updating(function ($program) {
            if ($program->isDirty('title') && !$program->isDirty('slug')) {
                $program->slug = Str::slug($program->title);
            }
        });
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function stages()
    {
        return $this->hasMany(NutritionProgramStage::class, 'program_id')->orderBy('stage_order');
    }

    public function benefits()
    {
        return $this->hasMany(NutritionProgramBenefit::class, 'program_id')->orderBy('sort_order');
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getUrlAttribute()
    {
        return route('nutrition-programs.show', [$this->plant->slug, $this->slug]);
    }

    public function getTotalProductsAttribute()
    {
        return $this->stages->sum(function ($stage) {
            return $stage->products->count();
        });
    }

    public function getAllProductsAttribute()
    {
        $products = collect();
        
        foreach ($this->stages as $stage) {
            foreach ($stage->products as $programProduct) {
                if (!$products->contains('id', $programProduct->product_id)) {
                    $products->push($programProduct->product);
                }
            }
        }
        
        return $products;
    }
}
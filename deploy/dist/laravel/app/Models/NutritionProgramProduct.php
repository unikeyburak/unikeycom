<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Translatable;

class NutritionProgramProduct extends Model
{
    use Translatable;

    protected $fillable = [
        'stage_id',
        'product_id',
        'dosage',
        'application_method',
        'frequency',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function translatableFields(): array
    {
        return [
            'dosage',
            'application_method',
            'frequency',
            'notes',
        ];
    }

    public function stage()
    {
        return $this->belongsTo(NutritionProgramStage::class, 'stage_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
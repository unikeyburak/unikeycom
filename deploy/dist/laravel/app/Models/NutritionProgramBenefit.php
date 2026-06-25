<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Translatable;

class NutritionProgramBenefit extends Model
{
    use Translatable;

    protected $fillable = [
        'program_id',
        'title',
        'description',
        'icon',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function translatableFields(): array
    {
        return [
            'title',
            'description',
        ];
    }

    public function program()
    {
        return $this->belongsTo(NutritionProgram::class, 'program_id');
    }
}
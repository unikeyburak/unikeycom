<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Translatable;

class NutritionProgramStage extends Model
{
    use Translatable;

    protected $fillable = [
        'program_id',
        'title',
        'stage_order',
        'timing',
        'duration',
        'description',
        'notes',
    ];

    protected $casts = [
        'notes' => 'array',
        'stage_order' => 'integer',
    ];

    public function translatableFields(): array
    {
        return [
            'title',
            'timing',
            'duration',
            'description',
        ];
    }

    public function program()
    {
        return $this->belongsTo(NutritionProgram::class, 'program_id');
    }

    public function products()
    {
        return $this->hasMany(NutritionProgramProduct::class, 'stage_id')->orderBy('sort_order');
    }
}
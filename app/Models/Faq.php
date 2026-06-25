<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Polymorphic ilişki
     */
    public function faqable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Aktif FAQ'ları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Sıralı FAQ'ları getir
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * FAQ Schema formatına dönüştür
     */
    public function toSchemaFormat(): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_code',
        'field',
        'value'
    ];

    /**
     * Çevrilebilir model ilişkisi
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Dil ilişkisi
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
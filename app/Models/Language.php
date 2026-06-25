<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag',
        'direction',
        'is_active',
        'is_default',
        'sort_order',
        'date_format',
        'currency'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'date_format' => 'array',
        'currency' => 'array'
    ];

    /**
     * Varsayılan dili al
     */
    public static function getDefault(): ?self
    {
        return self::where('is_default', true)->first();
    }

    /**
     * Aktif dilleri al
     */
    public static function getActive()
    {
        return self::where('is_active', true)
                   ->orderBy('sort_order')
                   ->orderBy('name')
                   ->get();
    }

    /**
     * Dil koduna göre bul
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    /**
     * Varsayılan yap
     */
    public function makeDefault(): void
    {
        // Diğer tüm dillerin varsayılanını kaldır
        self::where('is_default', true)->update(['is_default' => false]);
        
        // Bu dili varsayılan yap
        $this->update(['is_default' => true]);
    }

    /**
     * RTL mi kontrol et
     */
    public function isRtl(): bool
    {
        return $this->direction === 'rtl';
    }
}
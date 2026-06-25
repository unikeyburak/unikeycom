<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * Toplu atanabilir alanlar
     *
     * @var array<string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Tarih alanları
     *
     * @var array<string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Model kaydedildiğinde cache'i temizle
     */
    protected static function booted()
    {
        $clearCache = function ($setting) {
            Cache::forget('settings.' . $setting->key);
            // Toplu cache'leri tek seferde temizle
            static::clearGlobalCache();
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }

    /**
     * Tum global settings cache'lerini temizle
     */
    public static function clearGlobalCache(): void
    {
        Cache::forget('settings');
        Cache::forget('all_settings');
        Cache::forget('all_settings_parsed');
        Cache::forget('filament_settings_form_data');
        Cache::forget('mega_menu_categories');
        Cache::forget('nav_categories');
    }

    /**
     * Ayar değerini al (cache destekli)
     */
    public static function get($key, $default = null)
    {
        return Cache::remember('settings.' . $key, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return self::parseValue($setting->value, $setting->type);
        });
    }

    /**
     * Ayar değerini kaydet
     */
    public static function set($key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => self::serializeValue($value, $type), 'type' => $type]
        );
    }

    /**
     * Değeri tipine göre parse et
     */
    protected static function parseValue($value, $type)
    {
        return match ($type) {
            'json' => json_decode($value, true),
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            default => $value,
        };
    }

    /**
     * Değeri kaydetmek için serileştir
     */
    protected static function serializeValue($value, $type)
    {
        return match ($type) {
            'json' => json_encode($value),
            'boolean' => $value ? 'true' : 'false',
            default => $value,
        };
    }
}

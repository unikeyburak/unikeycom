<?php

namespace App\Http\Traits;

use App\Models\Translation;
use App\Models\Language;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

trait Translatable
{
    /**
     * Çevrilebilir alanlar
     */
    abstract public function translatableFields(): array;

    /**
     * Boot trait
     */
    public static function bootTranslatable()
    {
        // Model silindiğinde çevirileri de sil
        static::deleting(function ($model) {
            $model->translations()->delete();
        });
    }

    /**
     * Çeviri ilişkisi
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Belirli bir dil için çevirileri al
     */
    public function translationsFor(string $languageCode): MorphMany
    {
        return $this->translations()->where('language_code', $languageCode);
    }

    /**
     * Çeviriyi al veya varsayılanı döndür
     */
    public function translate(string $field, ?string $languageCode = null, bool $fallback = true)
    {
        $languageCode = $languageCode ?? App::getLocale();

        // Eğer translations zaten eager loaded ise, DB sorgusu yapmadan collection'dan bul
        if ($this->relationLoaded('translations')) {
            $translation = $this->translations
                ->where('language_code', $languageCode)
                ->where('field', $field)
                ->first();

            if ($translation) {
                return $translation->value;
            }

            // Fallback: varsayılan dile bak
            if ($fallback && $languageCode !== config('app.fallback_locale', 'tr')) {
                $fallbackTranslation = $this->translations
                    ->where('language_code', config('app.fallback_locale', 'tr'))
                    ->where('field', $field)
                    ->first();

                if ($fallbackTranslation) {
                    return $fallbackTranslation->value;
                }
            }

            return $this->getAttribute($field);
        }

        // Eager loaded değilse cache kullan
        $cacheKey = "translation.{$this->getMorphClass()}.{$this->id}.{$languageCode}.{$field}";

        $translation = Cache::remember($cacheKey, 3600, function () use ($field, $languageCode) {
            return $this->translations()
                ->where('language_code', $languageCode)
                ->where('field', $field)
                ->first();
        });

        if ($translation) {
            return $translation->value;
        }

        // Fallback: varsayılan dile bak
        if ($fallback && $languageCode !== config('app.fallback_locale', 'tr')) {
            return $this->translate($field, config('app.fallback_locale', 'tr'), false);
        }

        // Hiç çeviri yoksa orijinal değeri döndür
        return $this->getAttribute($field);
    }

    /**
     * Dizi (JSON) alanlar için çeviri al.
     * translate() çeviri varsa string(JSON), yoksa fallback olarak array döndürür;
     * bu metot her iki durumu da normalize edip her zaman array döndürür.
     */
    public function translateArray(string $field, ?string $languageCode = null): array
    {
        $value = $this->translate($field, $languageCode);

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($value) ? $value : [];
    }

    /**
     * Çeviri kaydet
     */
    public function setTranslation(string $field, string $value, string $languageCode): self
    {
        // Çevirilebilir alan mı kontrol et
        if (!in_array($field, $this->translatableFields())) {
            throw new \InvalidArgumentException("Field '{$field}' is not translatable");
        }

        // Mevcut çeviriyi güncelle veya yeni oluştur
        $this->translations()->updateOrCreate(
            [
                'language_code' => $languageCode,
                'field' => $field
            ],
            [
                'value' => $value
            ]
        );

        // Cache'i temizle
        Cache::forget("translation.{$this->getMorphClass()}.{$this->id}.{$languageCode}.{$field}");

        return $this;
    }

    /**
     * Toplu çeviri kaydet
     */
    public function setTranslations(array $translations, string $languageCode): self
    {
        foreach ($translations as $field => $value) {
            if (in_array($field, $this->translatableFields())) {
                $this->setTranslation($field, $value, $languageCode);
            }
        }

        return $this;
    }

    /**
     * Tüm çevirileri al
     */
    public function getAllTranslations(string $field): array
    {
        $translations = [];
        
        $results = $this->translations()
            ->where('field', $field)
            ->with('language')
            ->get();

        foreach ($results as $translation) {
            $translations[$translation->language_code] = $translation->value;
        }

        // Varsayılan değeri de ekle
        $defaultLang = Language::getDefault();
        if ($defaultLang && !isset($translations[$defaultLang->code])) {
            $translations[$defaultLang->code] = $this->getAttribute($field);
        }

        return $translations;
    }

    /**
     * Magic method - çeviriyi otomatik al
     */
    public function __get($key)
    {
        // Eğer _translated suffix'i varsa çeviriyi al
        if (str_ends_with($key, '_translated')) {
            $field = str_replace('_translated', '', $key);
            if (in_array($field, $this->translatableFields())) {
                return $this->translate($field);
            }
        }

        return parent::__get($key);
    }

    /**
     * Dil için eksik çevirileri kontrol et
     */
    public function getMissingTranslations(string $languageCode): array
    {
        $missing = [];
        
        foreach ($this->translatableFields() as $field) {
            $translation = $this->translations()
                ->where('language_code', $languageCode)
                ->where('field', $field)
                ->first();

            if (!$translation || empty($translation->value)) {
                $missing[] = $field;
            }
        }

        return $missing;
    }

    /**
     * Çeviri kopyala
     */
    public function copyTranslations(string $fromLanguage, string $toLanguage): self
    {
        $translations = $this->translationsFor($fromLanguage)->get();

        foreach ($translations as $translation) {
            $this->setTranslation($translation->field, $translation->value, $toLanguage);
        }

        return $this;
    }
}
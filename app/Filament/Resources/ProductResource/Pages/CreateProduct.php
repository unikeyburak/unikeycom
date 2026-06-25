<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    /** Çevrilebilir alanlar (TranslatableInput ile yönetilen) */
    protected array $tFields = ['name', 'short_description', 'long_description', 'meta_title', 'meta_description'];

    /** Forma gelen translations[lang][field] verisi */
    protected array $productTranslations = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1) Çevirileri ayır
        $this->productTranslations = $data['translations'] ?? [];
        unset($data['translations']);

        // 2) Varsayılan dil değerlerini ana kolonlara yaz (base = varsayılan dil)
        $defaultLang = Language::getDefault();
        if ($defaultLang && isset($this->productTranslations[$defaultLang->code])) {
            foreach ($this->tFields as $f) {
                if (array_key_exists($f, $this->productTranslations[$defaultLang->code])) {
                    $data[$f] = $this->productTranslations[$defaultLang->code][$f];
                }
            }
        }

        // 3) Slug boşsa varsayılan dildeki addan üret
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // 4) Görseller — sadece yerel dosyalar (mevcut mantık)
        unset($data['_remote_image_urls']);
        $data['images'] = array_values(array_filter(
            $data['images'] ?? [],
            fn ($p) => is_string($p) && !str_starts_with($p, 'http')
        ));

        return $data;
    }

    protected function afterCreate(): void
    {
        // Çevirileri translations tablosuna yaz
        if (!empty($this->productTranslations)) {
            foreach ($this->productTranslations as $languageCode => $fields) {
                foreach ($fields as $field => $value) {
                    if ($value !== null && $value !== '') {
                        $this->record->setTranslation($field, $value, $languageCode);
                    }
                }
            }
        }
    }
}

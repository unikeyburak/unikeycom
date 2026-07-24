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

    /** Çevrilebilir metin alanları (TranslatableInput ile yönetilen) */
    protected array $tFields = ['name', 'short_description', 'long_description', 'features_text', 'meta_title', 'meta_description'];

    /** Çevrilebilir dizi/JSON alanları (translations tablosunda JSON blob olarak saklanır) */
    protected array $tArrayFields = ['technical_info', 'dosage_items', 'application_info', 'warning_info', 'mixing_info'];

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
            $dc = $defaultLang->code;

            // Metin alanları
            foreach ($this->tFields as $f) {
                if (array_key_exists($f, $this->productTranslations[$dc])) {
                    $data[$f] = $this->productTranslations[$dc][$f];
                }
            }

            // Dizi alanları (array cast — doğrudan dizi yazılır)
            foreach ($this->tArrayFields as $f) {
                if (array_key_exists($f, $this->productTranslations[$dc])) {
                    $val = $this->productTranslations[$dc][$f];
                    if (!is_array($val)) {
                        $data[$f] = [];
                    } elseif ($f === 'technical_info') {
                        // KeyValue (assoc) — anahtarlar korunmalı (array_values onları siler)
                        $data[$f] = array_filter($val, fn ($v) => !is_array($v));
                    } else {
                        $data[$f] = array_values($val); // Repeater (list)
                    }
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
        if (empty($this->productTranslations)) {
            return;
        }

        $defaultCode = optional(Language::getDefault())->code;

        foreach ($this->productTranslations as $languageCode => $fields) {
            foreach ($fields as $field => $value) {
                $isArray = in_array($field, $this->tArrayFields, true);

                // Dizi alanlarında varsayılan dil ana kolonda tutulur; çeviri satırı yazma
                if ($isArray) {
                    if ($languageCode === $defaultCode) {
                        continue;
                    }
                    $arr = is_array($value) ? $value : [];
                    $arr = $field === 'technical_info'
                        ? array_filter($arr, fn ($v) => !is_array($v)) // assoc — anahtarları koru
                        : array_values($arr);                          // Repeater (list)
                    if (!empty($arr)) {
                        $this->record->setTranslation(
                            $field,
                            json_encode($arr, JSON_UNESCAPED_UNICODE),
                            $languageCode
                        );
                    }
                } elseif ($value !== null && $value !== '') {
                    $this->record->setTranslation($field, $value, $languageCode);
                }
            }
        }
    }
}

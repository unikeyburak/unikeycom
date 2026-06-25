<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    /** Çevrilebilir alanlar (TranslatableInput ile yönetilen) */
    protected array $tFields = ['name', 'short_description', 'long_description', 'features_text', 'meta_title', 'meta_description'];

    /** Forma gelen translations[lang][field] verisi */
    protected array $productTranslations = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Formu doldururken: mevcut çevirileri translations[lang][field] olarak yükle.
     * Varsayılan dilde çeviri kaydı yoksa ana kolon değerine düş (mevcut Türkçe içerik).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $languages = Language::getActive();
        $defaultLang = Language::getDefault();

        $data['translations'] = [];

        foreach ($languages as $language) {
            foreach ($this->tFields as $field) {
                $val = $this->record->translate($field, $language->code, false);

                // Varsayılan dilde çeviri kaydı yoksa ana kolona düş
                if (($val === null || $val === '') && $defaultLang && $language->code === $defaultLang->code) {
                    $val = $this->record->getAttribute($field);
                }

                if ($val !== null) {
                    $data['translations'][$language->code][$field] = $val;
                }
            }
        }

        return $data;
    }

    /**
     * Kaydetmeden önce: çevirileri ayır + varsayılan dili ana kolonlara yaz + görselleri birleştir.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 1) Çevirileri ayır
        $this->productTranslations = $data['translations'] ?? [];
        unset($data['translations']);

        // 2) Varsayılan dil değerlerini ana kolonlara yaz
        $defaultLang = Language::getDefault();
        if ($defaultLang && isset($this->productTranslations[$defaultLang->code])) {
            foreach ($this->tFields as $f) {
                if (array_key_exists($f, $this->productTranslations[$defaultLang->code])) {
                    $data[$f] = $this->productTranslations[$defaultLang->code][$f];
                }
            }
        }

        // 3) Görseller — yerel + harici URL'leri birleştir (mevcut mantık)
        $local = array_values(array_filter(
            $data['images'] ?? [],
            fn ($p) => is_string($p) && !str_starts_with($p, 'http')
        ));
        $remoteItems = $data['_remote_image_urls'] ?? [];
        $remote = array_values(array_filter(
            array_column($remoteItems, 'url'),
            fn ($u) => is_string($u) && str_starts_with($u, 'http')
        ));
        $data['images'] = array_values(array_merge($local, $remote));
        unset($data['_remote_image_urls']);

        return $data;
    }

    protected function afterSave(): void
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

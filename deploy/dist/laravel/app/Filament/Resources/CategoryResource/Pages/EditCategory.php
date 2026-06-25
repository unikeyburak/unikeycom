<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Mevcut çevirileri forma yükle
        $languages = Language::getActive();
        $translatableFields = ['name', 'description', 'meta_title', 'meta_description'];

        $data['translations'] = [];

        foreach ($languages as $language) {
            foreach ($translatableFields as $field) {
                $translation = $this->record->translate($field, $language->code, false);
                if ($translation !== null) {
                    $data['translations'][$language->code][$field] = $translation;
                }
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Translations array'ini data'dan ayır
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);

        // Varsayılan dildeki değerleri ana tabloya da kaydet
        $defaultLang = Language::getDefault();
        if ($defaultLang && isset($this->translations[$defaultLang->code])) {
            $defaultTranslations = $this->translations[$defaultLang->code];

            if (isset($defaultTranslations['name'])) {
                $data['name'] = $defaultTranslations['name'];
            }
            if (isset($defaultTranslations['description'])) {
                $data['description'] = $defaultTranslations['description'];
            }
            if (isset($defaultTranslations['meta_title'])) {
                $data['meta_title'] = $defaultTranslations['meta_title'];
            }
            if (isset($defaultTranslations['meta_description'])) {
                $data['meta_description'] = $defaultTranslations['meta_description'];
            }
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Çevirileri kaydet
        if (!empty($this->translations)) {
            foreach ($this->translations as $languageCode => $fields) {
                foreach ($fields as $field => $value) {
                    if ($value !== null && $value !== '') {
                        $this->record->setTranslation($field, $value, $languageCode);
                    }
                }
            }
        }
    }

    protected array $translations = [];
}

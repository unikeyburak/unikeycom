<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Translations array'ini data'dan ayır
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);

        // Varsayılan dildeki name'i slug için kullan
        $defaultLang = Language::getDefault();
        if ($defaultLang && isset($this->translations[$defaultLang->code]['name'])) {
            $data['name'] = $this->translations[$defaultLang->code]['name'];

            // Slug boşsa otomatik oluştur
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }
        }

        // Varsayılan dildeki description'ı da kaydet
        if ($defaultLang && isset($this->translations[$defaultLang->code]['description'])) {
            $data['description'] = $this->translations[$defaultLang->code]['description'];
        }

        // SEO alanları için de varsayılan dil değerlerini kaydet
        if ($defaultLang) {
            if (isset($this->translations[$defaultLang->code]['meta_title'])) {
                $data['meta_title'] = $this->translations[$defaultLang->code]['meta_title'];
            }
            if (isset($this->translations[$defaultLang->code]['meta_description'])) {
                $data['meta_description'] = $this->translations[$defaultLang->code]['meta_description'];
            }
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Çevirileri kaydet
        if (!empty($this->translations)) {
            foreach ($this->translations as $languageCode => $fields) {
                foreach ($fields as $field => $value) {
                    if (!empty($value)) {
                        $this->record->setTranslation($field, $value, $languageCode);
                    }
                }
            }
        }
    }

    protected array $translations = [];
}

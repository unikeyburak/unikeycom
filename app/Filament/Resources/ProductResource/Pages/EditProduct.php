<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    /** Çevrilebilir metin alanları (TranslatableInput ile yönetilen) */
    protected array $tFields = ['name', 'short_description', 'long_description', 'features_text', 'meta_title', 'meta_description'];

    /** Çevrilebilir dizi/JSON alanları (translations tablosunda JSON blob olarak saklanır) */
    protected array $tArrayFields = ['technical_info', 'dosage_items', 'application_info', 'warning_info', 'mixing_info'];

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
     * - Metin alanları: çeviri yoksa varsayılan dilde ana kolona düşülür.
     * - Dizi alanları: çeviri varsa onu, yoksa ana kolon dizisini (TR) başlangıç olarak yükle
     *   (kullanıcı her dil sekmesinde TR yapıyı görüp yerinde çevirir).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $languages   = Language::getActive();
        $defaultLang = Language::getDefault();

        $data['translations'] = [];

        foreach ($languages as $language) {
            // Metin alanları
            foreach ($this->tFields as $field) {
                $val = $this->record->translate($field, $language->code, false);

                if (($val === null || $val === '') && $defaultLang && $language->code === $defaultLang->code) {
                    $val = $this->record->getAttribute($field);
                }

                if ($val !== null) {
                    $data['translations'][$language->code][$field] = $val;
                }
            }

            // Dizi alanları
            foreach ($this->tArrayFields as $field) {
                $val = $this->record->translateArray($field, $language->code);

                // technical_info: nested/import içeriği formda gösterme (KeyValue düz beklenir)
                if ($field === 'technical_info' && !empty($val)) {
                    $val = array_filter($val, fn ($v) => !is_array($v));
                }

                if (!empty($val)) {
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
            $dc = $defaultLang->code;

            // Metin alanları
            foreach ($this->tFields as $f) {
                if (array_key_exists($f, $this->productTranslations[$dc])) {
                    $data[$f] = $this->productTranslations[$dc][$f];
                }
            }

            // Dizi alanları
            foreach ($this->tArrayFields as $f) {
                if (!array_key_exists($f, $this->productTranslations[$dc])) {
                    continue;
                }
                $val = $this->productTranslations[$dc][$f];
                $val = is_array($val) ? $val : [];

                if ($f === 'technical_info') {
                    // KeyValue (assoc) — anahtarları koru + DB'deki nested (import) içeriği koru
                    $flat = array_filter($val, fn ($v) => !is_array($v));
                    if ($this->record && $this->record->exists) {
                        $raw    = $this->record->getRawOriginal('technical_info');
                        $orig   = $raw ? json_decode($raw, true) : [];
                        $nested = array_filter((array) $orig, fn ($v) => is_array($v));
                        $data[$f] = array_merge($nested, $flat);
                    } else {
                        $data[$f] = $flat;
                    }
                } else {
                    // Repeater (list)
                    $data[$f] = array_values($val);
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
        if (empty($this->productTranslations)) {
            return;
        }

        $defaultCode = optional(Language::getDefault())->code;

        foreach ($this->productTranslations as $languageCode => $fields) {
            foreach ($fields as $field => $value) {
                $isArray = in_array($field, $this->tArrayFields, true);

                if ($isArray) {
                    // Varsayılan dil ana kolonda; çeviri satırı tutma
                    if ($languageCode === $defaultCode) {
                        continue;
                    }

                    $arr = is_array($value) ? $value : [];
                    if ($field !== 'technical_info') {
                        $arr = array_values($arr);
                    } else {
                        $arr = array_filter($arr, fn ($v) => !is_array($v));
                    }

                    if (!empty($arr)) {
                        $this->record->setTranslation(
                            $field,
                            json_encode($arr, JSON_UNESCAPED_UNICODE),
                            $languageCode
                        );
                    } else {
                        // Boş → çeviri satırını sil, sayfada TR'ye düşsün
                        $this->record->translations()
                            ->where('language_code', $languageCode)
                            ->where('field', $field)
                            ->delete();
                        Cache::forget("translation.{$this->record->getMorphClass()}.{$this->record->id}.{$languageCode}.{$field}");
                    }
                } elseif ($value !== null && $value !== '') {
                    $this->record->setTranslation($field, $value, $languageCode);
                }
            }
        }
    }
}

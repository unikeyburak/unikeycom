<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * Oluşturmadan önce: `_remote_image_urls` alanını temizle.
     * Yeni ürün oluştururken harici URL olmaz, ama Repeater boş dizi gönderebilir.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['_remote_image_urls']);

        // Sadece yerel dosyaları tut
        $data['images'] = array_values(array_filter(
            $data['images'] ?? [],
            fn ($p) => is_string($p) && !str_starts_with($p, 'http')
        ));

        return $data;
    }
}

<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Kaydetmeden önce: yerel görseller (FileUpload) + harici URL'ler (Repeater) birleştir.
     *
     * - `images`            → FileUpload'dan gelen yerel dosya yolları (http:// olmayan)
     * - `_remote_image_urls` → Repeater'dan kalan harici URL'ler (kullanıcı × ile silebildi)
     *
     * İkisi birleştirilerek `images` JSON kolonuna yazılır.
     * `_remote_image_urls` model'de olmadığı için data'dan temizlenir.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Yerel görseller — FileUpload state'i (http:// içermemeli ama garanti al)
        $local = array_values(array_filter(
            $data['images'] ?? [],
            fn ($p) => is_string($p) && !str_starts_with($p, 'http')
        ));

        // Harici URL'ler — Repeater'dan kalan satırlar
        $remoteItems = $data['_remote_image_urls'] ?? [];
        $remote = array_values(array_filter(
            array_column($remoteItems, 'url'),
            fn ($u) => is_string($u) && str_starts_with($u, 'http')
        ));

        // Birleştir: yerel görseller önce (ana görsel = ilk sıra)
        $data['images'] = array_values(array_merge($local, $remote));

        // Bu alan model'de yok, Eloquent'in görmemesi için temizle
        unset($data['_remote_image_urls']);

        return $data;
    }
}

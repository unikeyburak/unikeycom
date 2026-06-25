<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Medya Ayarları
    |--------------------------------------------------------------------------
    */
    
    // CDN URL (varsa)
    'cdn_url' => env('CDN_URL', null),

    // Medya diski
    'disk' => env('MEDIA_DISK', env('FILESYSTEM_DISK', 'public')),
    
    // Desteklenen dosya türleri
    'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'],
    'allowed_document_types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
    
    // Maksimum dosya boyutları (MB)
    'max_image_size' => 10, // 10MB
    'max_document_size' => 20, // 20MB
    
    // Resim işleme ayarları
    'image_quality' => 85, // WebP kalitesi (0-100)
    'max_width' => 2000,
    'max_height' => 2000,
    
    // Thumbnail boyutları
    'sizes' => [
        'thumbnail' => ['width' => 150, 'height' => 150],
        'small' => ['width' => 300, 'height' => 300],
        'medium' => ['width' => 600, 'height' => 600],
        'large' => ['width' => 1200, 'height' => 1200],
    ],

    // Responsive görseller
    'responsive' => [
        'enabled' => true,
        'directory' => 'responsive',
        'quality' => 82,
        'widths' => [480, 768, 1200, 1600],
        'default_sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw',
    ],
    
    // Watermark ayarları
    'watermark' => [
        'enabled' => false,
        'path' => 'watermark.png',
        'position' => 'bottom-right',
        'opacity' => 70,
        'size_percentage' => 10, // Resmin %10'u
    ],
    
    // Temizlik ayarları
    'cleanup' => [
        'temp_files_after_days' => 7,
        'unused_files_after_days' => 30,
    ],
];

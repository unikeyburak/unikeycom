<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'code' => 'tr',
                'name' => 'Türkçe',
                'native_name' => 'Türkçe',
                'flag' => '🇹🇷',
                'direction' => 'ltr',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1,
                'date_format' => [
                    'short' => 'd.m.Y',
                    'long' => 'd F Y',
                    'datetime' => 'd.m.Y H:i'
                ],
                'currency' => [
                    'code' => 'TRY',
                    'symbol' => '₺',
                    'position' => 'after',
                    'decimal_separator' => ',',
                    'thousands_separator' => '.'
                ]
            ],
            [
                'code' => 'en',
                'name' => 'İngilizce',
                'native_name' => 'English',
                'flag' => '🇬🇧',
                'direction' => 'ltr',
                'is_active' => false,
                'is_default' => false,
                'sort_order' => 2,
                'date_format' => [
                    'short' => 'm/d/Y',
                    'long' => 'F d, Y',
                    'datetime' => 'm/d/Y H:i'
                ],
                'currency' => [
                    'code' => 'USD',
                    'symbol' => '$',
                    'position' => 'before',
                    'decimal_separator' => '.',
                    'thousands_separator' => ','
                ]
            ],
            [
                'code' => 'es',
                'name' => 'İspanyolca',
                'native_name' => 'Español',
                'flag' => '🇪🇸',
                'direction' => 'ltr',
                'is_active' => false,
                'is_default' => false,
                'sort_order' => 3,
                'date_format' => [
                    'short' => 'd/m/Y',
                    'long' => 'd \d\e F \d\e Y',
                    'datetime' => 'd/m/Y H:i'
                ],
                'currency' => [
                    'code' => 'EUR',
                    'symbol' => '€',
                    'position' => 'after',
                    'decimal_separator' => ',',
                    'thousands_separator' => '.'
                ]
            ],
            [
                'code' => 'fr',
                'name' => 'Fransızca',
                'native_name' => 'Français',
                'flag' => '🇫🇷',
                'direction' => 'ltr',
                'is_active' => false,
                'is_default' => false,
                'sort_order' => 4,
                'date_format' => [
                    'short' => 'd/m/Y',
                    'long' => 'd F Y',
                    'datetime' => 'd/m/Y H:i'
                ],
                'currency' => [
                    'code' => 'EUR',
                    'symbol' => '€',
                    'position' => 'after',
                    'decimal_separator' => ',',
                    'thousands_separator' => ' '
                ]
            ],
            [
                'code' => 'ar',
                'name' => 'Arapça',
                'native_name' => 'العربية',
                'flag' => '🇸🇦',
                'direction' => 'rtl',
                'is_active' => false,
                'is_default' => false,
                'sort_order' => 5,
                'date_format' => [
                    'short' => 'd/m/Y',
                    'long' => 'd F Y',
                    'datetime' => 'd/m/Y H:i'
                ],
                'currency' => [
                    'code' => 'SAR',
                    'symbol' => 'ر.س',
                    'position' => 'after',
                    'decimal_separator' => '.',
                    'thousands_separator' => ','
                ]
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
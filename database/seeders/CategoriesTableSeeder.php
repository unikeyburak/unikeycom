<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bitki Koruma',
                'meta_title' => 'Bitki Koruma Ürünleri | Unikeyterra',
                'meta_description' => 'Tarımsal üretimde bitki sağlığını korumak için fungisit, herbisit ve insektisit ürünlerimizi keşfedin.',
                'children' => [
                    [
                        'name' => 'Fungisitler',
                        'meta_title' => 'Fungisit Ürünleri - Mantar İlaçları',
                        'meta_description' => 'Bitkilerdeki mantar hastalıklarına karşı etkili fungisit ürünlerimiz.'
                    ],
                    [
                        'name' => 'Herbisitler',
                        'meta_title' => 'Herbisit Ürünleri - Yabancı Ot İlaçları',
                        'meta_description' => 'Yabancı otlarla etkili mücadele için herbisit ürünlerimiz.'
                    ],
                    [
                        'name' => 'İnsektisitler',
                        'meta_title' => 'İnsektisit Ürünleri - Böcek İlaçları',
                        'meta_description' => 'Zararlı böceklere karşı güvenilir insektisit ürünlerimiz.'
                    ],
                    [
                        'name' => 'Akarisitler',
                        'meta_title' => 'Akarisit Ürünleri - Akar İlaçları',
                        'meta_description' => 'Akar ve kırmızı örümcek mücadelesi için akarisit ürünlerimiz.'
                    ]
                ]
            ],
            [
                'name' => 'Bitki Besleme',
                'meta_title' => 'Bitki Besleme Ürünleri | Unikeyterra',
                'meta_description' => 'Verimli tarımsal üretim için gübre ve bitki besleme ürünlerimizi inceleyin.',
                'children' => [
                    [
                        'name' => 'Taban Gübreler',
                        'meta_title' => 'Taban Gübre Çeşitleri',
                        'meta_description' => 'Toprak verimliliğini artıran taban gübre ürünlerimiz.'
                    ],
                    [
                        'name' => 'Yaprak Gübreler',
                        'meta_title' => 'Yaprak Gübre Çeşitleri',
                        'meta_description' => 'Hızlı emilim sağlayan yaprak gübre ürünlerimiz.'
                    ],
                    [
                        'name' => 'Özel Gübreler',
                        'meta_title' => 'Özel Formül Gübreler',
                        'meta_description' => 'Bitki ihtiyaçlarına özel formüle edilmiş gübrelerimiz.'
                    ],
                    [
                        'name' => 'Organomineral Gübreler',
                        'meta_title' => 'Organomineral Gübre Çeşitleri',
                        'meta_description' => 'Organik ve mineral içerik birleşimi gübrelerimiz.'
                    ]
                ]
            ],
            [
                'name' => 'Tohum',
                'meta_title' => 'Tohum Çeşitleri | Unikeyterra',
                'meta_description' => 'Yüksek verimli ve dayanıklı tohum çeşitlerimizi keşfedin.',
                'children' => [
                    [
                        'name' => 'Buğday Tohumu',
                        'meta_title' => 'Buğday Tohumu Çeşitleri',
                        'meta_description' => 'Yüksek verimli buğday tohumu çeşitlerimiz.'
                    ],
                    [
                        'name' => 'Mısır Tohumu',
                        'meta_title' => 'Mısır Tohumu Çeşitleri',
                        'meta_description' => 'Hibrit ve yerli mısır tohumu çeşitlerimiz.'
                    ],
                    [
                        'name' => 'Ayçiçeği Tohumu',
                        'meta_title' => 'Ayçiçeği Tohumu Çeşitleri',
                        'meta_description' => 'Yağlık ve çerezlik ayçiçeği tohumu çeşitlerimiz.'
                    ],
                    [
                        'name' => 'Yem Bitkileri Tohumu',
                        'meta_title' => 'Yem Bitkileri Tohumu',
                        'meta_description' => 'Hayvancılık için yem bitkileri tohumu çeşitlerimiz.'
                    ]
                ]
            ],
            [
                'name' => 'Biyostimülantlar',
                'meta_title' => 'Biyostimülant Ürünleri | Unikeyterra',
                'meta_description' => 'Bitki gelişimini destekleyen biyostimülant ürünlerimiz.',
                'children' => []
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);
            
            $categoryData['slug'] = Str::slug($categoryData['name']);
            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['slug'] = Str::slug($childData['name']);
                Category::create($childData);
            }
        }
    }
}

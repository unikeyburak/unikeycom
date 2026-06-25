<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Fungisitler
            [
                'category' => 'Fungisitler',
                'products' => [
                    [
                        'sku' => 'FNG-001',
                        'name' => 'MaxiGuard 500 SC',
                        'short_description' => 'Sistemik ve koruyucu etkili geniş spektrumlu fungisit',
                        'long_description' => 'MaxiGuard 500 SC, buğday, arpa, şeker pancarı ve domateste görülen mantar hastalıklarına karşı etkili sistemik fungisittir. Hem koruyucu hem de tedavi edici özelliğe sahiptir. Bitkinin tüm yeşil aksamına hızla nüfuz eder ve sisteme alınarak uzun süre koruma sağlar.',
                        'active_ingredient' => '500 g/l Azoxystrobin',
                        'formulation' => 'SC (Süspansiyon Konsantre)',
                        'usage_areas' => 'Buğday, Arpa, Şeker Pancarı, Domates, Patates',
                        'technical_info' => [
                            'Doz' => '50-75 ml/da',
                            'PHI' => '14 gün',
                            'Karışabilirlik' => 'Çoğu pestisit ile karışır',
                            'Uygulama Zamanı' => 'Hastalık belirtileri görülmeden önce',
                            'Ambalaj' => '1L, 5L, 20L'
                        ],
                        'meta_title' => 'MaxiGuard 500 SC Fungisit',
                        'meta_description' => 'Sistemik ve koruyucu etkili, 500 g/l Azoxystrobin içeren geniş spektrumlu fungisit. Buğday, arpa ve diğer ürünlerde mantar hastalıklarına karşı etkili.',
                        'meta_keywords' => 'fungisit, azoxystrobin, mantar ilacı, sistemik fungisit'
                    ],
                    [
                        'sku' => 'FNG-002',
                        'name' => 'CropShield Pro WG',
                        'short_description' => 'Külleme ve pas hastalıklarına karşı özel formülasyon',
                        'long_description' => 'CropShield Pro WG, tahıllarda külleme ve pas hastalıklarına karşı geliştirilmiş, suda dağılabilen granül formülasyonlu modern bir fungisittir. Hızlı sistemik etki gösterir ve uzun süre koruma sağlar.',
                        'active_ingredient' => '%50 Propiconazole',
                        'formulation' => 'WG (Suda Dağılan Granül)',
                        'usage_areas' => 'Buğday, Arpa, Çavdar, Yulaf',
                        'technical_info' => [
                            'Doz' => '25-30 g/da',
                            'PHI' => '21 gün',
                            'Uygulama Zamanı' => 'Hastalık belirtileri görüldüğünde',
                            'Ambalaj' => '1kg, 5kg',
                            'Çözünürlük' => 'Suda tam çözünür'
                        ],
                        'meta_title' => 'CropShield Pro WG - Külleme ve Pas İlacı',
                        'meta_description' => 'Tahıllarda külleme ve pas hastalıklarına karşı %50 Propiconazole içeren granül fungisit.',
                        'meta_keywords' => 'külleme ilacı, pas ilacı, propiconazole, tahıl fungisiti'
                    ],
                    [
                        'sku' => 'FNG-003',
                        'name' => 'BioProtect Plus',
                        'short_description' => 'Organik tarıma uygun biyolojik fungisit',
                        'long_description' => 'BioProtect Plus, Trichoderma harzianum içeren, organik tarımda kullanılabilen biyolojik fungisittir. Toprak kökenli hastalıklara karşı etkilidir. Faydalı mikroorganizmaları korur ve toprağın biyolojik dengesini bozmaz.',
                        'active_ingredient' => 'Trichoderma harzianum 1x10⁸ CFU/g',
                        'formulation' => 'WP (Islanabilir Toz)',
                        'usage_areas' => 'Sebze, Meyve, Süs Bitkileri',
                        'technical_info' => [
                            'Doz' => '200-300 g/da',
                            'PHI' => '0 gün',
                            'Saklama' => 'Serin ve kuru yerde',
                            'Ambalaj' => '500g, 1kg',
                            'Organik Sertifika' => 'FiBL listesinde'
                        ],
                        'meta_title' => 'BioProtect Plus - Organik Biyolojik Fungisit',
                        'meta_description' => 'Trichoderma harzianum içeren, organik tarıma uygun biyolojik fungisit. Toprak kökenli hastalıklara karşı etkili.',
                        'meta_keywords' => 'biyolojik fungisit, organik fungisit, trichoderma, organik tarım'
                    ]
                ]
            ],
            // Herbisitler
            [
                'category' => 'Herbisitler',
                'products' => [
                    [
                        'sku' => 'HRB-001',
                        'name' => 'WeedMaster Gold EC',
                        'short_description' => 'Geniş ve dar yapraklı yabancı otlara karşı total herbisit',
                        'long_description' => 'WeedMaster Gold EC, geniş ve dar yapraklı yabancı otlara karşı güçlü sistematik etkiye sahip total herbisittir. Özellikle nadas alanları ve tarla kenarlarının temizliğinde kullanılır.',
                        'active_ingredient' => '480 g/l Glyphosate IPA tuzu',
                        'formulation' => 'EC (Emülsiyon Konsantre)',
                        'usage_areas' => 'Nadas alanları, Bahçe, Bağ, Tarla kenarları',
                        'technical_info' => [
                            'Doz' => '400-600 ml/da',
                            'Etki Süresi' => '7-10 gün',
                            'Yağmur Dayanımı' => '6 saat',
                            'Ambalaj' => '1L, 5L, 20L',
                            'Karışım' => 'Yayıcı yapıştırıcı ile kullanılabilir'
                        ],
                        'meta_title' => 'WeedMaster Gold EC Total Herbisit',
                        'meta_description' => 'Geniş spektrumlu, 480 g/l Glyphosate içeren total herbisit. Tüm yabancı otlara karşı etkili.',
                        'meta_keywords' => 'herbisit, yabancı ot ilacı, glyphosate, total herbisit'
                    ],
                    [
                        'sku' => 'HRB-002',
                        'name' => 'CerealGuard 75 WG',
                        'short_description' => 'Tahıllarda geniş yapraklı yabancı otlara karşı seçici herbisit',
                        'long_description' => 'CerealGuard 75 WG, buğday ve arpada geniş yapraklı yabancı otlara karşı seçici herbisittir. Tahıla zarar vermeden yabancı otları kontrol eder.',
                        'active_ingredient' => '%75 Tribenuron-methyl',
                        'formulation' => 'WG (Suda Dağılan Granül)',
                        'usage_areas' => 'Buğday, Arpa',
                        'technical_info' => [
                            'Doz' => '1.5-2 g/da',
                            'Uygulama Zamanı' => 'Yabancı otlar 2-6 yapraklı dönemde',
                            'PHI' => '30 gün',
                            'Ambalaj' => '100g, 500g',
                            'Sıcaklık' => '5-25°C arası uygulama'
                        ],
                        'meta_title' => 'CerealGuard 75 WG Tahıl Herbisiti',
                        'meta_description' => 'Tahıllarda geniş yapraklı yabancı otlara karşı %75 Tribenuron-methyl içeren seçici herbisit.',
                        'meta_keywords' => 'tahıl herbisiti, tribenuron-methyl, seçici herbisit, buğday ot ilacı'
                    ]
                ]
            ],
            // İnsektisitler
            [
                'category' => 'İnsektisitler',
                'products' => [
                    [
                        'sku' => 'INS-001',
                        'name' => 'InsectShield Max EC',
                        'short_description' => 'Emici ve çiğneyici böceklere karşı geniş spektrumlu insektisit',
                        'long_description' => 'InsectShield Max EC, sebze ve meyvelerde emici ve çiğneyici böceklere karşı hızlı ve uzun etkili insektisittir. Kontak ve mide zehiri olarak etki gösterir.',
                        'active_ingredient' => '200 g/l Chlorpyrifos-ethyl',
                        'formulation' => 'EC (Emülsiyon Konsantre)',
                        'usage_areas' => 'Domates, Biber, Patlıcan, Elma, Kiraz',
                        'technical_info' => [
                            'Doz' => '100-150 ml/100L su',
                            'PHI' => '7-21 gün (ürüne göre)',
                            'Etki Şekli' => 'Kontak ve mide zehiri',
                            'Ambalaj' => '250ml, 1L, 5L',
                            'Tekrar' => '10-14 gün ara ile'
                        ],
                        'meta_title' => 'InsectShield Max EC İnsektisit',
                        'meta_description' => 'Emici ve çiğneyici böceklere karşı 200 g/l Chlorpyrifos-ethyl içeren geniş spektrumlu insektisit.',
                        'meta_keywords' => 'insektisit, böcek ilacı, chlorpyrifos, tarım ilacı'
                    ]
                ]
            ],
            // Gübreler
            [
                'category' => 'Taban Gübreler',
                'products' => [
                    [
                        'sku' => 'GBR-001',
                        'name' => 'PowerBase 20-20-0+Zn',
                        'short_description' => 'Çinko katkılı kompoze taban gübresi',
                        'long_description' => 'PowerBase 20-20-0+Zn, yüksek fosfor içeriği ile kök gelişimini destekler. Çinko katkısı ile mikroelement ihtiyacını karşılar. Özellikle tahıl ekiminde kullanılır.',
                        'active_ingredient' => '%20 N, %20 P₂O₅, %1 Zn',
                        'formulation' => 'Granül',
                        'usage_areas' => 'Buğday, Arpa, Mısır, Ayçiçeği',
                        'technical_info' => [
                            'Doz' => '20-40 kg/da',
                            'Uygulama' => 'Ekim öncesi toprağa',
                            'Granül Boyutu' => '2-4 mm',
                            'Ambalaj' => '25kg, 50kg',
                            'Saklama' => 'Kuru ve serin yerde'
                        ],
                        'meta_title' => 'PowerBase 20-20-0+Zn Taban Gübresi',
                        'meta_description' => 'Çinko katkılı, %20 azot ve %20 fosfor içeren kompoze taban gübresi. Kök gelişimi için ideal.',
                        'meta_keywords' => 'taban gübre, kompoze gübre, çinkolu gübre, DAP gübre'
                    ]
                ]
            ],
            // Tohum
            [
                'category' => 'Buğday Tohumu',
                'products' => [
                    [
                        'sku' => 'THM-001',
                        'name' => 'Altın Başak - Ekmeklik Buğday',
                        'short_description' => 'Yüksek verimli, kışlık ekmeklik buğday tohumu',
                        'long_description' => 'Altın Başak ekmeklik buğday çeşidi, yüksek verim potansiyeli ve hastalıklara dayanıklılığı ile öne çıkar. Orta erkenci, kışa dayanıklı ve yatmaya mukavim özellik gösterir.',
                        'active_ingredient' => 'Sertifikalı Buğday Tohumu',
                        'formulation' => 'R2 Sertifikalı Tohum',
                        'usage_areas' => 'Tüm buğday ekim alanları',
                        'technical_info' => [
                            'Verim Potansiyeli' => '600-800 kg/da',
                            'Bin Tane Ağırlığı' => '38-42 g',
                            'Ekim Normu' => '22-25 kg/da',
                            'Protein Oranı' => '%12-14',
                            'Ambalaj' => '25kg'
                        ],
                        'meta_title' => 'Altın Başak Ekmeklik Buğday Tohumu',
                        'meta_description' => 'Yüksek verimli, hastalıklara dayanıklı kışlık ekmeklik buğday tohumu. 600-800 kg/da verim potansiyeli.',
                        'meta_keywords' => 'buğday tohumu, ekmeklik buğday, kışlık buğday, sertifikalı tohum'
                    ]
                ]
            ]
        ];

        foreach ($products as $group) {
            $categoryName = $group['category'];
            $category = Category::where('name', $categoryName)->first();
            
            if (!$category) {
                continue;
            }

            foreach ($group['products'] as $productData) {
                $productData['category_id'] = $category->id;
                $productData['slug'] = Str::slug($productData['name']);
                $productData['status'] = 'active';
                $productData['images'] = []; // Boş dizi
                
                Product::create($productData);
            }
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\NutritionProgram;
use App\Models\NutritionProgramStage;
use App\Models\NutritionProgramBenefit;
use App\Models\Product;
use Illuminate\Database\Seeder;

class NutritionProgramSeeder extends Seeder
{
    public function run()
    {
        // Bitkiler
        $plants = [
            [
                'name' => 'Domates',
                'slug' => 'domates',
                'scientific_name' => 'Solanum lycopersicum',
                'description' => 'Domates bitkisi için özel hazırlanmış besleme programları',
            ],
            [
                'name' => 'Biber',
                'slug' => 'biber',
                'scientific_name' => 'Capsicum annuum',
                'description' => 'Biber yetiştiriciliği için optimize edilmiş besin programları',
            ],
            [
                'name' => 'Buğday',
                'slug' => 'bugday',
                'scientific_name' => 'Triticum aestivum',
                'description' => 'Buğday tarımı için geliştirilmiş verim artırıcı programlar',
            ],
            [
                'name' => 'Mısır',
                'slug' => 'misir',
                'scientific_name' => 'Zea mays',
                'description' => 'Mısır üretiminde maksimum verim için besleme çözümleri',
            ],
            [
                'name' => 'Çilek',
                'slug' => 'cilek',
                'scientific_name' => 'Fragaria × ananassa',
                'description' => 'Çilek üretiminde kalite ve verim artırıcı programlar',
            ],
        ];

        foreach ($plants as $plantData) {
            $plant = Plant::create($plantData);

            // Her bitki için 2-3 program oluştur
            $this->createProgramsForPlant($plant);
        }
    }

    private function createProgramsForPlant($plant)
    {
        // Program 1: Erken Dönem
        $program1 = NutritionProgram::create([
            'plant_id' => $plant->id,
            'title' => $plant->name . ' Erken Dönem Besleme Programı',
            'slug' => $plant->slug . '-erken-donem',
            'description' => $plant->name . ' bitkisinin fide ve erken vejetatif dönemdeki besin ihtiyaçlarını karşılamak için özel olarak hazırlanmış program.',
            'season' => 'İlkbahar',
            'growth_stage' => 'Fide-Vejetatif',
            'application_area' => 'Yaprak + Toprak',
            'is_featured' => true,
            'status' => 'active',
        ]);

        // Faydalar ekle
        $this->addBenefits($program1, [
            ['title' => 'Güçlü Kök Gelişimi', 'description' => 'Fosfor ağırlıklı formül ile güçlü kök sistemi', 'icon' => 'fas fa-roots'],
            ['title' => 'Hızlı Büyüme', 'description' => 'Dengeli NPK ile hızlı vejetatif gelişim', 'icon' => 'fas fa-seedling'],
            ['title' => 'Stres Toleransı', 'description' => 'Mikro elementlerle artırılmış stres toleransı', 'icon' => 'fas fa-shield-alt'],
        ]);

        // Aşamalar ekle
        $stage1 = NutritionProgramStage::create([
            'program_id' => $program1->id,
            'title' => 'Fide Dönemi',
            'stage_order' => 1,
            'timing' => 'Dikimden hemen sonra',
            'duration' => '10-15 gün',
            'description' => 'Fidelerin tutması ve ilk gelişim için',
        ]);

        $stage2 = NutritionProgramStage::create([
            'program_id' => $program1->id,
            'title' => 'Vejetatif Gelişim',
            'stage_order' => 2,
            'timing' => 'Dikimden 15 gün sonra',
            'duration' => '20-30 gün',
            'description' => 'Güçlü gövde ve yaprak gelişimi için',
        ]);

        // Ürünleri bağla (mevcut ürünlerden rastgele seç)
        $this->attachProductsToStage($stage1);
        $this->attachProductsToStage($stage2);

        // Program 2: Verim Dönemi
        if (in_array($plant->slug, ['domates', 'biber', 'cilek'])) {
            $program2 = NutritionProgram::create([
                'plant_id' => $plant->id,
                'title' => $plant->name . ' Verim Dönemi Besleme Programı',
                'slug' => $plant->slug . '-verim-donemi',
                'description' => $plant->name . ' bitkisinin çiçeklenme ve meyve dönemindeki özel besin ihtiyaçları için geliştirilmiş program.',
                'season' => 'Yaz',
                'growth_stage' => 'Çiçeklenme-Meyve',
                'application_area' => 'Damlama + Yaprak',
                'is_featured' => true,
                'status' => 'active',
            ]);

            $this->addBenefits($program2, [
                ['title' => 'Yüksek Verim', 'description' => 'Potasyum ağırlıklı formül ile artırılmış meyve verimi', 'icon' => 'fas fa-chart-line'],
                ['title' => 'Meyve Kalitesi', 'description' => 'Kalsiyum ve mikro elementlerle üstün meyve kalitesi', 'icon' => 'fas fa-apple-alt'],
                ['title' => 'Uzun Hasat', 'description' => 'Sürekli beslenme ile uzatılmış hasat dönemi', 'icon' => 'fas fa-calendar-alt'],
            ]);
        }
    }

    private function addBenefits($program, $benefits)
    {
        foreach ($benefits as $index => $benefit) {
            NutritionProgramBenefit::create([
                'program_id' => $program->id,
                'title' => $benefit['title'],
                'description' => $benefit['description'],
                'icon' => $benefit['icon'],
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function attachProductsToStage($stage)
    {
        // Rastgele 2-3 ürün seç
        $products = Product::inRandomOrder()->limit(rand(2, 3))->get();
        
        foreach ($products as $index => $product) {
            $stage->products()->create([
                'product_id' => $product->id,
                'dosage' => rand(100, 300) . ' gr/da',
                'application_method' => ['Yapraktan', 'Topraktan', 'Damlamadan'][rand(0, 2)],
                'frequency' => ['7-10 günde bir', '15 günde bir', 'Ayda bir'][rand(0, 2)],
                'sort_order' => $index + 1,
            ]);
        }
    }
}
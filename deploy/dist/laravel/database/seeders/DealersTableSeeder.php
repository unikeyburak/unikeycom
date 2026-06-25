<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin kullanıcıyı al (onaylayan olarak kullanılacak)
        $adminUser = User::where('email', 'admin@unikeyterra.com')->first();

        $dealers = [
            [
                'company_name' => 'Ege Tarım Merkezi Ltd. Şti.',
                'tax_number' => '1234567890',
                'tax_office' => 'Konak',
                'phone' => '02324567890',
                'email' => 'info@egetarim.com.tr',
                'website' => 'www.egetarim.com.tr',
                'address' => 'Kemalpaşa Cad. No:123 Bornova',
                'city' => 'İzmir',
                'district' => 'Bornova',
                'postal_code' => '35060',
                'latitude' => 38.4192,
                'longitude' => 27.1287,
                'about' => 'Ege bölgesinin en büyük tarımsal ürün bayilerinden biri olarak 2010 yılından beri hizmet vermekteyiz.',
                'working_hours' => [
                    'monday' => '08:30-18:00',
                    'tuesday' => '08:30-18:00',
                    'wednesday' => '08:30-18:00',
                    'thursday' => '08:30-18:00',
                    'friday' => '08:30-18:00',
                    'saturday' => '09:00-13:00',
                    'sunday' => 'Kapalı'
                ],
                'social_media' => [
                    'facebook' => 'egetarimltd',
                    'instagram' => 'egetarim',
                    'linkedin' => 'ege-tarim-ltd'
                ],
                'status' => 'active',
                'approved_at' => now()->subDays(30),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Anadolu Ziraat Ticaret A.Ş.',
                'tax_number' => '9876543210',
                'tax_office' => 'Çankaya',
                'phone' => '03122345678',
                'email' => 'info@anadoluziraat.com',
                'website' => 'www.anadoluziraat.com',
                'address' => 'Ankara Yolu 5.km No:45',
                'city' => 'Ankara',
                'district' => 'Yenimahalle',
                'postal_code' => '06100',
                'latitude' => 39.9334,
                'longitude' => 32.8597,
                'about' => 'İç Anadolu bölgesinin güvenilir tarım ortağı. 25 yıllık deneyim.',
                'working_hours' => [
                    'monday' => '08:00-17:30',
                    'tuesday' => '08:00-17:30',
                    'wednesday' => '08:00-17:30',
                    'thursday' => '08:00-17:30',
                    'friday' => '08:00-17:30',
                    'saturday' => 'Kapalı',
                    'sunday' => 'Kapalı'
                ],
                'social_media' => [
                    'facebook' => 'anadoluziraat',
                    'twitter' => 'anadoluziraat'
                ],
                'status' => 'active',
                'approved_at' => now()->subDays(60),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Karadeniz Tarım San. ve Tic. Ltd. Şti.',
                'tax_number' => '5554443332',
                'tax_office' => 'Atakum',
                'phone' => '03624567890',
                'email' => 'bilgi@karadeniztarim.com',
                'website' => 'www.karadeniztarim.com',
                'address' => 'Atatürk Bulvarı No:234',
                'city' => 'Samsun',
                'district' => 'Atakum',
                'postal_code' => '55200',
                'latitude' => 41.2928,
                'longitude' => 36.3313,
                'about' => 'Karadeniz bölgesinin tarımsal ihtiyaçlarına 15 yıldır çözüm sunuyoruz.',
                'working_hours' => [
                    'monday' => '08:30-18:30',
                    'tuesday' => '08:30-18:30',
                    'wednesday' => '08:30-18:30',
                    'thursday' => '08:30-18:30',
                    'friday' => '08:30-18:30',
                    'saturday' => '09:00-14:00',
                    'sunday' => 'Kapalı'
                ],
                'social_media' => [
                    'instagram' => 'karadeniztarim'
                ],
                'status' => 'active',
                'approved_at' => now()->subDays(45),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Akdeniz Tarımsal Ürünler Ltd. Şti.',
                'tax_number' => '1112223334',
                'tax_office' => 'Muratpaşa',
                'phone' => '02423456789',
                'email' => 'info@akdeniztarim.net',
                'address' => 'Lara Cad. No:567',
                'city' => 'Antalya',
                'district' => 'Muratpaşa',
                'postal_code' => '07100',
                'latitude' => 36.8969,
                'longitude' => 30.7133,
                'about' => 'Seracılık ve tarım konusunda uzman kadromuzla hizmetinizdeyiz.',
                'status' => 'active',
                'approved_at' => now()->subDays(20),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'GAP Tarım Ürünleri A.Ş.',
                'tax_number' => '7778889990',
                'tax_office' => 'Haliliye',
                'phone' => '04143456789',
                'email' => 'gap@gaptarim.com.tr',
                'website' => 'www.gaptarim.com.tr',
                'address' => 'Atatürk Mahallesi GAP Cad. No:89',
                'city' => 'Şanlıurfa',
                'district' => 'Haliliye',
                'postal_code' => '63300',
                'latitude' => 37.1674,
                'longitude' => 38.7955,
                'about' => 'GAP bölgesinin en büyük tarımsal girdi tedarikçisi.',
                'working_hours' => [
                    'monday' => '07:30-18:00',
                    'tuesday' => '07:30-18:00',
                    'wednesday' => '07:30-18:00',
                    'thursday' => '07:30-18:00',
                    'friday' => '07:30-18:00',
                    'saturday' => '08:00-12:00',
                    'sunday' => 'Kapalı'
                ],
                'status' => 'active',
                'approved_at' => now()->subDays(90),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Çukurova Ziraat Ltd. Şti.',
                'tax_number' => '2223334445',
                'tax_office' => 'Seyhan',
                'phone' => '03224567890',
                'email' => 'info@cukurovaziraat.com',
                'address' => 'Turgut Özal Bulvarı No:123',
                'city' => 'Adana',
                'district' => 'Seyhan',
                'postal_code' => '01170',
                'latitude' => 37.0000,
                'longitude' => 35.3213,
                'status' => 'pending',
                'about' => 'Çukurova\'nın verimli topraklarında çiftçimizin yanındayız.'
            ],
            [
                'company_name' => 'Trakya Tarım Ticaret A.Ş.',
                'tax_number' => '6667778889',
                'tax_office' => 'Merkez',
                'phone' => '02842345678',
                'email' => 'bilgi@trakyatarim.com',
                'website' => 'www.trakyatarim.com',
                'address' => 'İstasyon Cad. No:45',
                'city' => 'Edirne',
                'district' => 'Merkez',
                'postal_code' => '22100',
                'latitude' => 41.6818,
                'longitude' => 26.5623,
                'about' => 'Trakya\'nın bereketli topraklarında modern tarımın öncüsü.',
                'status' => 'active',
                'approved_at' => now()->subDays(120),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Marmara Tarımsal Kalkınma Ltd. Şti.',
                'tax_number' => '3334445556',
                'tax_office' => 'Osmangazi',
                'phone' => '02242345678',
                'email' => 'info@marmaratarim.com',
                'address' => 'Mudanya Yolu No:78',
                'city' => 'Bursa',
                'district' => 'Osmangazi',
                'postal_code' => '16050',
                'latitude' => 40.1828,
                'longitude' => 29.0610,
                'about' => 'Marmara bölgesinin tarımsal kalkınmasına katkı sağlıyoruz.',
                'status' => 'inactive',
                'suspension_reason' => 'Geçici olarak faaliyetleri durduruldu.',
                'suspended_at' => now()->subDays(10)
            ],
            [
                'company_name' => 'Doğu Anadolu Tarım Ltd. Şti.',
                'tax_number' => '8889990001',
                'tax_office' => 'Yakutiye',
                'phone' => '04423456789',
                'email' => 'info@doguanadolutarim.com',
                'address' => 'Cumhuriyet Cad. No:234',
                'city' => 'Erzurum',
                'district' => 'Yakutiye',
                'postal_code' => '25100',
                'latitude' => 39.9334,
                'longitude' => 41.2764,
                'about' => 'Doğu Anadolu\'nun zorlu iklim şartlarına uygun ürünler sunuyoruz.',
                'status' => 'active',
                'approved_at' => now()->subDays(180),
                'approved_by' => $adminUser ? $adminUser->id : null
            ],
            [
                'company_name' => 'Orta Karadeniz Tarım San. Tic. A.Ş.',
                'tax_number' => '4445556667',
                'tax_office' => 'İlkadım',
                'phone' => '03623456789',
                'email' => 'info@ortakaradeniztarim.com',
                'address' => '19 Mayıs Bulvarı No:567',
                'city' => 'Samsun',
                'district' => 'İlkadım',
                'postal_code' => '55020',
                'latitude' => 41.2797,
                'longitude' => 36.3361,
                'status' => 'pending',
                'about' => 'Fındık ve diğer tarımsal ürünlerde uzman kadromuzla hizmetinizdeyiz.'
            ]
        ];

        foreach ($dealers as $dealer) {
            // JSON alanlarını encode et
            if (isset($dealer['working_hours'])) {
                $dealer['working_hours'] = json_encode($dealer['working_hours']);
            }
            if (isset($dealer['social_media'])) {
                $dealer['social_media'] = json_encode($dealer['social_media']);
            }
            
            Dealer::create($dealer);
        }
    }
}
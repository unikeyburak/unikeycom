<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // İlk admin kullanıcıyı al
        $adminUser = User::where('email', 'admin@unikeyterra.com')->first();
        
        if (!$adminUser) {
            $adminUser = User::first();
        }

        $pages = [
            [
                'title' => 'Hakkımızda',
                'content' => '<h1>Hakkımızda</h1>
                
                <p><strong>Unikeyterra</strong>, 1998 yılından bu yana Türk tarımına hizmet veren, sektörün güvenilir isimlerinden biridir.</p>
                
                <h2>Misyonumuz</h2>
                <p>Modern tarım teknolojilerini ve en kaliteli tarımsal girdileri çiftçilerimizle buluşturarak, sürdürülebilir ve verimli tarımsal üretimi desteklemek.</p>
                
                <h2>Vizyonumuz</h2>
                <p>Türkiye\'nin tarımsal üretimde öncü ve yenilikçi çözüm ortağı olmak, dünya standartlarında ürün ve hizmetlerle ülkemizin tarımsal potansiyelini artırmak.</p>
                
                <h2>Değerlerimiz</h2>
                <ul>
                    <li><strong>Güvenilirlik:</strong> Müşterilerimize ve iş ortaklarımıza karşı her zaman dürüst ve şeffaf olmak.</li>
                    <li><strong>Kalite:</strong> En yüksek kalite standartlarında ürün ve hizmet sunmak.</li>
                    <li><strong>Yenilikçilik:</strong> Sürekli araştırma ve geliştirme ile sektöre yenilikler katmak.</li>
                    <li><strong>Sürdürülebilirlik:</strong> Çevreye duyarlı ve sürdürülebilir tarım uygulamalarını desteklemek.</li>
                    <li><strong>Müşteri Odaklılık:</strong> Müşterilerimizin ihtiyaçlarını önceleyerek çözüm üretmek.</li>
                </ul>',
                'template' => 'default',
                'meta_title' => 'Hakkımızda - Unikeyterra',
                'meta_description' => 'Unikeyterra olarak 1998\'den bu yana Türk tarımına hizmet veriyoruz. Misyonumuz, vizyonumuz ve değerlerimiz.',
                'meta_keywords' => 'unikeyterra hakkında, tarım şirketi, tarımsal ürünler, kurumsal',
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'title' => 'İletişim',
                'content' => '<h1>İletişim</h1>
                
                <p>Unikeyterra olarak, müşterilerimizin ve iş ortaklarımızın sorularını yanıtlamak ve en iyi hizmeti sunmak için buradayız.</p>
                
                <h2>İletişim Bilgileri</h2>
                
                <div class="contact-info">
                    <p><strong>Merkez Ofis:</strong><br>
                    Atatürk Cad. No:123<br>
                    Yenişehir, Ankara 06420<br>
                    Türkiye</p>
                    
                    <p><strong>Telefon:</strong> +90 312 123 45 67<br>
                    <strong>Faks:</strong> +90 312 123 45 68<br>
                    <strong>E-posta:</strong> info@unikeyterra.com</p>
                    
                    <p><strong>Müşteri Hizmetleri:</strong><br>
                    Telefon: 444 2 AGR (247)<br>
                    E-posta: destek@unikeyterra.com</p>
                </div>
                
                <h2>Çalışma Saatleri</h2>
                <p>Pazartesi - Cuma: 08:30 - 18:00<br>
                Cumartesi: 09:00 - 13:00<br>
                Pazar: Kapalı</p>
                
                <h2>Bölge Müdürlükleri</h2>
                <p><strong>Ege Bölge Müdürlüğü:</strong> İzmir - Tel: +90 232 123 45 67<br>
                <strong>Akdeniz Bölge Müdürlüğü:</strong> Antalya - Tel: +90 242 123 45 67<br>
                <strong>Karadeniz Bölge Müdürlüğü:</strong> Samsun - Tel: +90 362 123 45 67<br>
                <strong>Güneydoğu Bölge Müdürlüğü:</strong> Şanlıurfa - Tel: +90 414 123 45 67</p>',
                'template' => 'contact',
                'meta_title' => 'İletişim - Unikeyterra',
                'meta_description' => 'Unikeyterra iletişim bilgileri, adres, telefon ve e-posta. Müşteri hizmetleri ve bölge müdürlükleri.',
                'meta_keywords' => 'iletişim, adres, telefon, müşteri hizmetleri, bölge müdürlükleri',
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'title' => 'Kalite Politikamız',
                'content' => '<h1>Kalite Politikamız</h1>
                
                <p>Unikeyterra olarak, kaliteyi sadece ürünlerimizde değil, tüm iş süreçlerimizde ve hizmetlerimizde bir yaşam biçimi olarak benimsiyoruz.</p>
                
                <h2>Kalite Taahhüdümüz</h2>
                <p>Müşterilerimize sunduğumuz tüm ürün ve hizmetlerde en yüksek kalite standartlarını sağlamayı taahhüt ediyoruz. Bu kapsamda:</p>
                
                <ul>
                    <li>ISO 9001:2015 Kalite Yönetim Sistemi sertifikasına sahibiz</li>
                    <li>Tüm ürünlerimiz uluslararası kalite standartlarına uygun olarak üretilir veya tedarik edilir</li>
                    <li>Düzenli kalite kontrol ve denetim süreçleri uygularız</li>
                    <li>Müşteri memnuniyetini sürekli ölçer ve iyileştiririz</li>
                </ul>
                
                <h2>Sertifikalarımız</h2>
                <ul>
                    <li>ISO 9001:2015 Kalite Yönetim Sistemi</li>
                    <li>ISO 14001:2015 Çevre Yönetim Sistemi</li>
                    <li>OHSAS 18001 İş Sağlığı ve Güvenliği</li>
                    <li>TSE Hizmet Yeterlilik Belgesi</li>
                </ul>
                
                <h2>Kalite Kontrol Sürecimiz</h2>
                <p>Ürünlerimizin kalitesini garanti altına almak için:</p>
                <ol>
                    <li>Tedarikçi seçimi ve değerlendirmesi</li>
                    <li>Ürün kabul testleri</li>
                    <li>Depolama koşulları kontrolü</li>
                    <li>Sevkiyat öncesi son kontroller</li>
                    <li>Müşteri geri bildirimlerinin değerlendirilmesi</li>
                </ol>',
                'template' => 'default',
                'meta_title' => 'Kalite Politikamız - Unikeyterra',
                'meta_description' => 'Unikeyterra kalite politikası, ISO sertifikaları ve kalite kontrol süreçleri. Müşteri memnuniyeti önceliğimizdir.',
                'meta_keywords' => 'kalite politikası, iso 9001, kalite kontrol, sertifikalar',
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'title' => 'Gizlilik Politikası',
                'content' => '<h1>Gizlilik Politikası</h1>
                
                <p>Son Güncelleme: ' . now()->format('d.m.Y') . '</p>
                
                <p>Unikeyterra olarak, web sitemizi ziyaret eden kullanıcılarımızın gizliliğini korumayı taahhüt ediyoruz. Bu gizlilik politikası, kişisel verilerinizin nasıl toplandığı, kullanıldığı ve korunduğu hakkında bilgi vermektedir.</p>
                
                <h2>Toplanan Bilgiler</h2>
                <p>Web sitemizi ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda aşağıdaki bilgileri toplayabiliriz:</p>
                <ul>
                    <li>Ad, soyad ve iletişim bilgileri</li>
                    <li>E-posta adresi ve telefon numarası</li>
                    <li>Şirket bilgileri ve vergi numarası</li>
                    <li>IP adresi ve tarayıcı bilgileri</li>
                    <li>Web sitesi kullanım verileri</li>
                </ul>
                
                <h2>Bilgilerin Kullanımı</h2>
                <p>Topladığımız bilgileri şu amaçlarla kullanırız:</p>
                <ul>
                    <li>Ürün ve hizmetlerimizi sunmak</li>
                    <li>Siparişlerinizi işlemek ve takip etmek</li>
                    <li>Müşteri desteği sağlamak</li>
                    <li>Yasal yükümlülüklerimizi yerine getirmek</li>
                    <li>Hizmetlerimizi geliştirmek</li>
                </ul>
                
                <h2>Bilgilerin Korunması</h2>
                <p>Kişisel verilerinizi korumak için endüstri standardı güvenlik önlemleri kullanıyoruz. Verileriniz şifreli bağlantılar üzerinden iletilir ve güvenli sunucularda saklanır.</p>
                
                <h2>Çerezler</h2>
                <p>Web sitemizde çerezler kullanılmaktadır. Çerezler, web sitesi deneyiminizi iyileştirmek ve size daha kişiselleştirilmiş hizmet sunmak için kullanılır.</p>
                
                <h2>İletişim</h2>
                <p>Gizlilik politikamız hakkında sorularınız varsa, lütfen bizimle iletişime geçin:<br>
                E-posta: privacy@unikeyterra.com<br>
                Telefon: +90 312 123 45 67</p>',
                'template' => 'default',
                'meta_title' => 'Gizlilik Politikası - Unikeyterra',
                'meta_description' => 'Unikeyterra gizlilik politikası ve kişisel verilerin korunması. KVKK uyumlu gizlilik bildirimi.',
                'meta_keywords' => 'gizlilik politikası, kvkk, kişisel veriler, çerezler',
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'title' => 'Kullanım Şartları',
                'content' => '<h1>Kullanım Şartları</h1>
                
                <p>Unikeyterra web sitesini kullanmaya başlamadan önce lütfen bu kullanım şartlarını dikkatlice okuyunuz.</p>
                
                <h2>Genel Şartlar</h2>
                <p>Bu web sitesini kullanarak, aşağıdaki şartları kabul etmiş sayılırsınız:</p>
                
                <ol>
                    <li>Web sitesindeki tüm içerikler Unikeyterra\'ya aittir ve telif hakları ile korunmaktadır.</li>
                    <li>Site içeriğini kopyalamak, dağıtmak veya değiştirmek yasaktır.</li>
                    <li>Verilen bilgilerin doğruluğu garanti edilmekle birlikte, Unikeyterra sorumluluk kabul etmez.</li>
                    <li>Ürün fiyatları ve stok durumları önceden haber verilmeksizin değiştirilebilir.</li>
                    <li>Web sitesinin kesintisiz ve hatasız çalışacağı garanti edilmez.</li>
                </ol>
                
                <h2>Kullanıcı Sorumlulukları</h2>
                <ul>
                    <li>Doğru ve güncel bilgi vermek</li>
                    <li>Yasalara ve etik kurallara uymak</li>
                    <li>Başkalarının haklarına saygı göstermek</li>
                    <li>Güvenlik açıklarını istismar etmemek</li>
                </ul>
                
                <h2>Sorumluluk Reddi</h2>
                <p>Unikeyterra, web sitesinin kullanımından doğabilecek doğrudan veya dolaylı zararlardan sorumlu tutulamaz.</p>
                
                <h2>Değişiklikler</h2>
                <p>Unikeyterra, bu kullanım şartlarını önceden bildirmeksizin değiştirme hakkını saklı tutar.</p>',
                'template' => 'default',
                'meta_title' => 'Kullanım Şartları - Unikeyterra',
                'meta_description' => 'Unikeyterra web sitesi kullanım şartları ve koşulları. Yasal bilgiler ve sorumluluklar.',
                'meta_keywords' => 'kullanım şartları, yasal bilgiler, sorumluluk reddi',
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'title' => 'Sıkça Sorulan Sorular',
                'content' => '<h1>Sıkça Sorulan Sorular</h1>
                
                <h2>Sipariş ve Teslimat</h2>
                
                <h3>Nasıl sipariş verebilirim?</h3>
                <p>Siparişlerinizi bayi portalı üzerinden veya müşteri temsilciniz aracılığıyla verebilirsiniz. Toplu siparişler için özel fiyatlandırma yapılmaktadır.</p>
                
                <h3>Minimum sipariş miktarı var mı?</h3>
                <p>Evet, her ürün için belirlenen minimum sipariş miktarları bulunmaktadır. Detaylı bilgi için müşteri hizmetlerimizle iletişime geçebilirsiniz.</p>
                
                <h3>Teslimat süresi ne kadar?</h3>
                <p>Stokta bulunan ürünler için teslimat süresi 2-5 iş günüdür. Özel sipariş ürünleri için süre değişebilir.</p>
                
                <h2>Ürünler ve Kullanım</h2>
                
                <h3>Ürünleriniz orijinal mi?</h3>
                <p>Tüm ürünlerimiz orijinal ve lisanslıdır. Üretici firmalardan direkt tedarik edilmektedir.</p>
                
                <h3>Teknik destek sağlıyor musunuz?</h3>
                <p>Evet, uzman ziraat mühendislerimiz ürünlerin doğru kullanımı konusunda ücretsiz teknik destek sağlamaktadır.</p>
                
                <h3>İade ve değişim şartları nelerdir?</h3>
                <p>Hatalı veya hasarlı ürünler 7 gün içinde iade edilebilir. Ürün ambalajı açılmamış olmalıdır.</p>
                
                <h2>Bayilik ve İş Ortaklığı</h2>
                
                <h3>Nasıl bayi olabilirim?</h3>
                <p>Bayilik başvuruları web sitemizden veya 444 2 AGR numaralı müşteri hizmetlerimizden yapılabilir.</p>
                
                <h3>Bayi olmanın avantajları nelerdir?</h3>
                <p>Özel fiyatlandırma, vade imkanları, teknik destek ve pazarlama desteği gibi birçok avantaj sunuyoruz.</p>',
                'template' => 'default',
                'meta_title' => 'Sıkça Sorulan Sorular - Unikeyterra',
                'meta_description' => 'Unikeyterra hakkında sıkça sorulan sorular ve cevapları. Sipariş, teslimat, ürünler ve bayilik.',
                'meta_keywords' => 'sss, sıkça sorulan sorular, yardım, destek',
                'status' => 'published',
                'published_at' => now()
            ]
        ];

        foreach ($pages as $pageData) {
            $pageData['slug'] = Str::slug($pageData['title']);
            $pageData['created_by'] = $adminUser->id;
            
            Page::create($pageData);
        }
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        $now = Carbon::now();

        // Admin kullanıcısının ID'sini al (yoksa 1 varsay)
        $adminId = DB::table('users')->orderBy('id')->value('id') ?? 1;

        $pages = [
            [
                'title' => 'Hakkımızda',
                'slug' => 'hakkimizda',
                'template' => 'default',
                'meta_title' => 'Hakkımızda - Unikeyterra',
                'meta_description' => 'Unikeyterra hakkında detaylı bilgi. Tarım sektöründeki deneyimimiz ve vizyonumuz.',
                'status' => 'published',
                'created_by' => $adminId,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'content' => '
<div class="mb-12 text-center">
    <h2 class="text-3xl font-bold mb-4">Tarımın Geleceğine Yön Veriyoruz</h2>
    <p class="text-lg text-gray-600">
        Unikeyterra olarak, Türkiye\'nin tarım sektöründe güvenilir ve yenilikçi çözüm ortağıyız.
    </p>
</div>

<div class="grid md:grid-cols-2 gap-8 mb-12">
    <div>
        <h3 class="text-2xl font-semibold mb-4">Vizyonumuz</h3>
        <p class="text-gray-700 mb-4">
            Modern tarım teknolojileri ve sürdürülebilir çözümlerle Türk tarımını dünya standartlarında
            üretim yapabilir hale getirmek. Çiftçilerimizin verimliliğini artırarak, ülkemizin tarımsal
            üretim potansiyelini en üst seviyeye taşımak.
        </p>
        <p class="text-gray-700">
            Kaliteli ürün portföyümüz ve uzman kadromuzla, tarım sektörünün ihtiyaçlarına en uygun
            çözümleri sunmak için çalışıyoruz.
        </p>
    </div>
    <div>
        <h3 class="text-2xl font-semibold mb-4">Misyonumuz</h3>
        <p class="text-gray-700 mb-4">
            Tarım sektöründeki deneyimimiz ve bilgi birikimimizle, çiftçilerimize en kaliteli ürünleri
            en uygun koşullarda sunmak. Teknik destek ve danışmanlık hizmetlerimizle üreticilerimizin
            yanında olmak.
        </p>
        <p class="text-gray-700">
            Sürdürülebilir tarım ilkeleri doğrultusunda, çevre dostu ürünler ve uygulamalar geliştirerek
            gelecek nesillere yaşanabilir bir dünya bırakmak.
        </p>
    </div>
</div>

<div class="bg-green-50 rounded-lg p-8 mb-12">
    <h3 class="text-2xl font-semibold mb-6 text-center">Değerlerimiz</h3>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="text-center">
            <h4 class="font-semibold mb-2">Güvenilirlik</h4>
            <p class="text-gray-600 text-sm">
                Verdiğimiz sözlerin arkasında durur, müşterilerimizin güvenini kazanmayı öncelik kabul ederiz.
            </p>
        </div>
        <div class="text-center">
            <h4 class="font-semibold mb-2">İnovasyon</h4>
            <p class="text-gray-600 text-sm">
                Sürekli gelişim ve yenilikçi yaklaşımlarla sektörde öncü olmayı hedefleriz.
            </p>
        </div>
        <div class="text-center">
            <h4 class="font-semibold mb-2">Sürdürülebilirlik</h4>
            <p class="text-gray-600 text-sm">
                Çevre dostu ürün ve uygulamalarla doğaya saygılı üretimi destekleriz.
            </p>
        </div>
    </div>
</div>
',
            ],
            [
                'title' => 'İletişim',
                'slug' => 'iletisim',
                'template' => 'contact',
                'meta_title' => 'İletişim - Unikeyterra',
                'meta_description' => 'Unikeyterra ile iletişime geçin. Ürünlerimiz ve hizmetlerimiz hakkında bilgi alın.',
                'status' => 'published',
                'created_by' => $adminId,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'content' => '',
            ],
            [
                'title' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'template' => 'default',
                'meta_title' => 'Gizlilik Politikası - Unikeyterra',
                'meta_description' => 'Unikeyterra gizlilik politikası ve kişisel verilerin korunması.',
                'status' => 'published',
                'created_by' => $adminId,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'content' => '
<p class="lead">
    Unikeyterra olarak, müşterilerimizin gizliliğine önem veriyoruz. Bu gizlilik politikası,
    web sitemizi ziyaret ettiğinizde topladığımız bilgileri ve bunları nasıl kullandığımızı açıklar.
</p>

<h2>1. Toplanan Bilgiler</h2>
<p>Web sitemizi ziyaret ettiğinizde aşağıdaki bilgiler toplanabilir:</p>
<ul>
    <li>İsim, e-posta adresi ve telefon numarası (iletişim formu aracılığıyla)</li>
    <li>Şirket adı ve vergi bilgileri (bayi başvurusu yapıldığında)</li>
    <li>IP adresi ve tarayıcı bilgileri</li>
    <li>Çerezler aracılığıyla toplanan kullanım verileri</li>
</ul>

<h2>2. Bilgilerin Kullanımı</h2>
<p>Topladığımız bilgileri aşağıdaki amaçlarla kullanırız:</p>
<ul>
    <li>Size daha iyi hizmet sunmak ve taleplerinize yanıt vermek</li>
    <li>Ürün ve hizmetlerimiz hakkında bilgilendirme yapmak</li>
    <li>Web sitemizin performansını iyileştirmek</li>
    <li>Yasal yükümlülüklerimizi yerine getirmek</li>
</ul>

<h2>3. Bilgi Güvenliği</h2>
<p>
    Kişisel verilerinizin güvenliğini sağlamak için gerekli tüm teknik ve idari önlemleri alırız.
    Verileriniz, yetkisiz erişim, kayıp veya kötüye kullanıma karşı korunur.
</p>

<h2>4. Üçüncü Taraflarla Paylaşım</h2>
<p>
    Kişisel verilerinizi, yasal zorunluluklar dışında üçüncü taraflarla paylaşmayız.
    Ancak, hizmetlerimizi sunmak için güvenilir iş ortaklarımızla sınırlı bilgi paylaşımı yapabiliriz.
</p>

<h2>5. Çerezler</h2>
<p>
    Web sitemiz, kullanıcı deneyimini iyileştirmek için çerezler kullanır. Tarayıcınızın
    ayarlarından çerezleri devre dışı bırakabilirsiniz, ancak bu durumda bazı özellikler
    düzgün çalışmayabilir.
</p>

<h2>6. Veri Saklama Süresi</h2>
<p>
    Kişisel verilerinizi, ilgili mevzuatta öngörülen süreler boyunca veya veri işleme
    amacının gerektirdiği süre boyunca saklarız.
</p>

<h2>7. Haklarınız</h2>
<p>KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
<ul>
    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
    <li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li>
    <li>Kişisel verilerinizin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
    <li>Yurt içinde veya yurt dışında kişisel verilerinizin aktarıldığı üçüncü kişileri bilme</li>
    <li>Kişisel verilerinizin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme</li>
    <li>Kişisel verilerinizin silinmesini veya yok edilmesini isteme</li>
</ul>

<h2>8. İletişim</h2>
<p>Gizlilik politikamız hakkında sorularınız varsa, lütfen bizimle iletişime geçin.</p>

<h2>9. Politika Güncellemeleri</h2>
<p>
    Bu gizlilik politikası zaman zaman güncellenebilir. Önemli değişiklikler olması durumunda
    web sitemizde duyuru yapılacaktır.
</p>
',
            ],
            [
                'title' => 'Kullanım Şartları',
                'slug' => 'kullanim-sartlari',
                'template' => 'default',
                'meta_title' => 'Kullanım Şartları - Unikeyterra',
                'meta_description' => 'Unikeyterra web sitesi kullanım şartları ve koşulları.',
                'status' => 'published',
                'created_by' => $adminId,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'content' => '
<p class="lead">
    Bu web sitesini kullanarak aşağıdaki şart ve koşulları kabul etmiş sayılırsınız.
    Bu şartları kabul etmiyorsanız, lütfen siteyi kullanmayınız.
</p>

<h2>1. Genel Hükümler</h2>
<p>
    Bu web sitesi Unikeyterra tarafından işletilmektedir. Site üzerindeki tüm içerik,
    tasarım, logo ve diğer materyaller telif hakkı ve fikri mülkiyet hakları kapsamında korunmaktadır.
</p>

<h2>2. Site Kullanımı</h2>
<p>Bu web sitesini kullanırken:</p>
<ul>
    <li>Yürürlükteki tüm yasalara ve düzenlemelere uygun hareket etmeyi</li>
    <li>Üçüncü tarafların haklarına saygı göstermeyi</li>
    <li>Site güvenliğini tehdit edecek eylemlerden kaçınmayı</li>
    <li>Yanıltıcı veya yanlış bilgi vermemeyi</li>
    <li>Sitenin normal işleyişini bozmamayı</li>
</ul>
<p>kabul edersiniz.</p>

<h2>3. Fikri Mülkiyet Hakları</h2>
<p>
    Bu web sitesindeki tüm içerik (metin, görsel, video, logo, grafik vb.) Unikeyterra\'ya
    aittir veya lisanslıdır. İzin almadan kopyalanamaz, çoğaltılamaz veya dağıtılamaz.
</p>

<h2>4. Ürün Bilgileri</h2>
<p>
    Sitede yer alan ürün bilgileri, teknik özellikler ve fiyatlar bilgilendirme amaçlıdır.
    Unikeyterra, önceden haber vermeksizin bu bilgilerde değişiklik yapma hakkını saklı tutar.
</p>

<h2>5. Sorumluluk Sınırlaması</h2>
<p>Unikeyterra:</p>
<ul>
    <li>Site içeriğinin eksiksiz ve hatasız olduğunu garanti etmez</li>
    <li>Sitenin kesintisiz ve güvenli olacağını taahhüt etmez</li>
    <li>Sitedeki bilgilerin kullanımından doğacak zararlardan sorumlu değildir</li>
    <li>Üçüncü taraf sitelerine verilen bağlantılardan sorumlu değildir</li>
</ul>

<h2>6. Bayi ve Kullanıcı Hesapları</h2>
<p>Bayi hesabı oluştururken:</p>
<ul>
    <li>Verdiğiniz bilgilerin doğru ve güncel olduğunu</li>
    <li>Hesap güvenliğinden sorumlu olduğunuzu</li>
    <li>Hesabınızın başkaları tarafından kullanılmasına izin vermeyeceğinizi</li>
    <li>Hesabınızda gerçekleşen tüm işlemlerden sorumlu olduğunuzu</li>
</ul>
<p>kabul edersiniz.</p>

<h2>7. Gizlilik</h2>
<p>Kişisel verilerinizin işlenmesi, Gizlilik Politikamıza tabidir.</p>

<h2>8. Uygulanacak Hukuk</h2>
<p>
    Bu kullanım şartları Türkiye Cumhuriyeti kanunlarına tabidir. Herhangi bir
    uyuşmazlık durumunda Türkiye mahkemeleri yetkilidir.
</p>

<h2>9. Değişiklikler</h2>
<p>
    Unikeyterra, bu kullanım şartlarını önceden bildirmeksizin değiştirme hakkını
    saklı tutar. Değişiklikler sitede yayınlandığı andan itibaren geçerli olacaktır.
</p>
',
            ],
        ];

        foreach ($pages as $page) {
            // Zaten varsa ekleme (slug benzersiz)
            if (!DB::table('pages')->where('slug', $page['slug'])->exists()) {
                DB::table('pages')->insert($page);
            }
        }
    }

    public function down(): void
    {
        DB::table('pages')->whereIn('slug', [
            'hakkimizda',
            'iletisim',
            'gizlilik-politikasi',
            'kullanim-sartlari',
        ])->delete();
    }
};

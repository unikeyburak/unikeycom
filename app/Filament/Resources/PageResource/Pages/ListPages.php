<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->ensureStaticPagesExist();
    }

    private function ensureStaticPagesExist(): void
    {
        $staticPages = [
            [
                'title' => 'Hakkımızda',
                'slug' => 'hakkimizda',
                'template' => 'default',
                'meta_title' => 'Hakkımızda - Unikeyterra',
                'meta_description' => 'Unikeyterra hakkında detaylı bilgi. Tarım sektöründeki deneyimimiz ve vizyonumuz.',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h2>Tarımın Geleceğine Yön Veriyoruz</h2><p>Unikeyterra olarak, Türkiye\'nin tarım sektöründe güvenilir ve yenilikçi çözüm ortağıyız.</p>',
                            'background' => '',
                        ],
                    ],
                    [
                        'type' => 'two_columns',
                        'data' => [
                            'left' => '<h3>Vizyonumuz</h3><p>Modern tarım teknolojileri ve sürdürülebilir çözümlerle Türk tarımını dünya standartlarında üretim yapabilir hale getirmek. Çiftçilerimizin verimliliğini artırarak, ülkemizin tarımsal üretim potansiyelini en üst seviyeye taşımak.</p>',
                            'right' => '<h3>Misyonumuz</h3><p>Tarım sektöründeki deneyimimiz ve bilgi birikimimizle, çiftçilerimize en kaliteli ürünleri en uygun koşullarda sunmak. Teknik destek ve danışmanlık hizmetlerimizle üreticilerimizin yanında olmak.</p>',
                        ],
                    ],
                    [
                        'type' => 'three_columns',
                        'data' => [
                            'left' => '<h3>Güvenilirlik</h3><p>Verdiğimiz sözlerin arkasında durur, müşterilerimizin güvenini kazanmayı öncelik kabul ederiz.</p>',
                            'center' => '<h3>İnovasyon</h3><p>Sürekli gelişim ve yenilikçi yaklaşımlarla sektörde öncü olmayı hedefleriz.</p>',
                            'right' => '<h3>Sürdürülebilirlik</h3><p>Çevre dostu ürün ve uygulamalarla doğaya saygılı üretimi destekleriz.</p>',
                        ],
                    ],
                    [
                        'type' => 'cta',
                        'data' => [
                            'title' => 'Bizimle İletişime Geçin',
                            'text' => 'Ürünlerimiz ve hizmetlerimiz hakkında detaylı bilgi almak için bize ulaşın.',
                            'button_text' => 'İletişime Geç',
                            'button_url' => '/iletisim',
                            'background' => 'green',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'İletişim',
                'slug' => 'iletisim',
                'template' => 'contact',
                'meta_title' => 'İletişim - Unikeyterra',
                'meta_description' => 'Unikeyterra ile iletişime geçin. Ürünlerimiz ve hizmetlerimiz hakkında bilgi alın.',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<p>Ürünlerimiz ve hizmetlerimiz hakkında detaylı bilgi almak için bizimle iletişime geçebilirsiniz.</p>',
                            'background' => '',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'template' => 'default',
                'meta_title' => 'Gizlilik Politikası - Unikeyterra',
                'meta_description' => 'Unikeyterra gizlilik politikası ve kişisel verilerin korunması.',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<p>Unikeyterra olarak, müşterilerimizin gizliliğine önem veriyoruz.</p><h2>1. Toplanan Bilgiler</h2><ul><li>İsim, e-posta adresi ve telefon numarası</li><li>Şirket adı ve vergi bilgileri</li><li>IP adresi ve tarayıcı bilgileri</li><li>Çerezler aracılığıyla toplanan kullanım verileri</li></ul><h2>2. Bilgilerin Kullanımı</h2><ul><li>Size daha iyi hizmet sunmak</li><li>Ürün ve hizmetlerimiz hakkında bilgilendirme yapmak</li><li>Web sitemizin performansını iyileştirmek</li><li>Yasal yükümlülüklerimizi yerine getirmek</li></ul><h2>3. Bilgi Güvenliği</h2><p>Kişisel verilerinizin güvenliğini sağlamak için gerekli tüm teknik ve idari önlemleri alırız.</p><h2>4. Üçüncü Taraflarla Paylaşım</h2><p>Kişisel verilerinizi, yasal zorunluluklar dışında üçüncü taraflarla paylaşmayız.</p><h2>5. Çerezler</h2><p>Web sitemiz, kullanıcı deneyimini iyileştirmek için çerezler kullanır.</p><h2>6. KVKK Kapsamında Haklarınız</h2><ul><li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li><li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li><li>Düzeltilmesini veya silinmesini isteme</li></ul><h2>7. İletişim</h2><p>Gizlilik politikamız hakkında sorularınız varsa, lütfen bizimle iletişime geçin.</p>',
                            'background' => '',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Kullanım Şartları',
                'slug' => 'kullanim-sartlari',
                'template' => 'default',
                'meta_title' => 'Kullanım Şartları - Unikeyterra',
                'meta_description' => 'Unikeyterra web sitesi kullanım şartları ve koşulları.',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<p>Bu web sitesini kullanarak aşağıdaki şart ve koşulları kabul etmiş sayılırsınız.</p><h2>1. Genel Hükümler</h2><p>Bu web sitesi Unikeyterra tarafından işletilmektedir.</p><h2>2. Site Kullanımı</h2><ul><li>Yürürlükteki tüm yasalara uygun hareket etmeyi</li><li>Üçüncü tarafların haklarına saygı göstermeyi</li><li>Site güvenliğini tehdit edecek eylemlerden kaçınmayı kabul edersiniz.</li></ul><h2>3. Fikri Mülkiyet Hakları</h2><p>Bu web sitesindeki tüm içerik Unikeyterra\'ya aittir. İzin almadan kopyalanamaz.</p><h2>4. Ürün Bilgileri</h2><p>Sitede yer alan ürün bilgileri bilgilendirme amaçlıdır.</p><h2>5. Sorumluluk Sınırlaması</h2><ul><li>Site içeriğinin eksiksiz ve hatasız olduğunu garanti etmez</li><li>Sitenin kesintisiz olacağını taahhüt etmez</li></ul><h2>6. Uygulanacak Hukuk</h2><p>Bu kullanım şartları Türkiye Cumhuriyeti kanunlarına tabidir.</p>',
                            'background' => '',
                        ],
                    ],
                ],
            ],
        ];

        $userId = auth()->id() ?? 1;

        foreach ($staticPages as $pageData) {
            if (!Page::where('slug', $pageData['slug'])->exists()) {
                Page::create(array_merge($pageData, [
                    'status' => 'published',
                    'published_at' => now(),
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]));
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

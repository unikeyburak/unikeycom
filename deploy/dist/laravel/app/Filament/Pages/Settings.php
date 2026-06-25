<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Cache;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Site Ayarları';
    protected static ?string $title = 'Site Ayarları';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    // Onbelleklenmis kategori listeleri (form render basina 1 kez yuklenir)
    protected ?array $cachedParentCategories = null;
    protected ?array $cachedAllActiveCategories = null;

    protected function getParentCategoryOptions(): array
    {
        if ($this->cachedParentCategories === null) {
            $this->cachedParentCategories = Cache::remember('filament_settings_parent_cats', 300, fn () =>
                Category::query()
                    ->whereNull('parent_id')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->all()
            );
        }
        return $this->cachedParentCategories;
    }

    protected function getAllActiveCategoryOptions(): array
    {
        if ($this->cachedAllActiveCategories === null) {
            $this->cachedAllActiveCategories = Cache::remember('filament_settings_all_cats', 300, fn () =>
                Category::query()
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->all()
            );
        }
        return $this->cachedAllActiveCategories;
    }

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $settings = Cache::remember('filament_settings_form_data', 60, function () {
            $raw = Setting::all()->pluck('value', 'key')->toArray();

            $jsonFields = ['header_menu', 'meta_menu', 'footer_columns', 'social_media', 'hero_slides', 'mega_menu'];
            foreach ($jsonFields as $field) {
                $raw[$field] = isset($raw[$field]) ? (json_decode($raw[$field], true) ?? []) : [];
            }

            $raw['hero_slider_autoplay'] = isset($raw['hero_slider_autoplay'])
                ? (int) $raw['hero_slider_autoplay']
                : 6000;

            return $raw;
        });

        $this->data = $settings;
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Ayarlar')
                    ->tabs([
                        Tabs\Tab::make('Genel Ayarlar')
                            ->schema([
                                Section::make('Site Bilgileri')
                                    ->schema([
                                        Forms\Components\TextInput::make('site_name')
                                            ->label('Site Adı')
                                            ->required(),
                                            
                                        Forms\Components\Textarea::make('site_description')
                                            ->label('Site Açıklaması')
                                            ->rows(3)
                                            ->helperText('Ana sayfa meta description için kullanılır'),
                                            
                                        Forms\Components\TextInput::make('site_keywords')
                                            ->label('Anahtar Kelimeler')
                                            ->helperText('Virgülle ayırarak yazın'),
                                    ]),
                                    
                                Section::make('İletişim Bilgileri')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('contact_phone')
                                                    ->label('Telefon')
                                                    ->tel()
                                                    ->placeholder('0312 123 45 67'),

                                                Forms\Components\TextInput::make('contact_email')
                                                    ->label('E-posta')
                                                    ->email(),
                                            ]),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('contact_address_label')
                                                    ->label('Ofis Adres Başlığı')
                                                    ->placeholder('Ofis / Merkez'),

                                                Forms\Components\TextInput::make('contact_factory_label')
                                                    ->label('Fabrika Adres Başlığı')
                                                    ->placeholder('Fabrika / Üretim Tesisi'),
                                            ]),

                                        Forms\Components\Textarea::make('contact_address')
                                            ->label('Ofis Adresi')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('contact_city')
                                                    ->label('Ofis Şehir'),

                                                Forms\Components\TextInput::make('contact_postcode')
                                                    ->label('Posta Kodu'),
                                            ]),

                                        Forms\Components\Textarea::make('contact_address_factory')
                                            ->label('Fabrika Adresi')
                                            ->rows(2),

                                        Forms\Components\TextInput::make('contact_city_factory')
                                            ->label('Fabrika Şehir'),
                                    ]),

                                Section::make('Google Harita Embed')
                                    ->description('Google Maps → Paylaş → Haritayı yerleştir → iframe src="..." kısmındaki URL\'yi yapıştırın')
                                    ->schema([
                                        Forms\Components\TextInput::make('map_office_title')
                                            ->label('Ofis Başlığı')
                                            ->placeholder('Ofis — Konak / İzmir')
                                            ->default('Ofis — Konak / İzmir'),

                                        Forms\Components\Textarea::make('map_office_embed')
                                            ->label('Ofis Harita Embed URL')
                                            ->rows(3)
                                            ->placeholder('https://www.google.com/maps/embed?pb=...')
                                            ->helperText('Google Maps iframe src değeri'),

                                        Forms\Components\TextInput::make('map_factory_title')
                                            ->label('Fabrika Başlığı')
                                            ->placeholder('Fabrika — Torbalı / İzmir')
                                            ->default('Fabrika — Torbalı / İzmir'),

                                        Forms\Components\Textarea::make('map_factory_embed')
                                            ->label('Fabrika Harita Embed URL')
                                            ->rows(3)
                                            ->placeholder('https://www.google.com/maps/embed?pb=...')
                                            ->helperText('Boş bırakılırsa ikinci harita gösterilmez'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Ana Sayfa')
                            ->schema([
                                Section::make('Hero Slider')
                                    ->schema([
                                        Actions::make([
                                            FormAction::make('fillHeroSlidesFromDefaults')
                                                ->label('Varsayılan Sliderı Yükle')
                                                ->color('gray')
                                                ->action(function (Set $set) {
                                                    $set('hero_slides', $this->buildHeroSlidesDefaults());

                                                    Notification::make()
                                                        ->title('Varsayılan slider dolduruldu')
                                                        ->success()
                                                        ->send();
                                                }),
                                        ])->key('hero_slider_actions'),

                                        Forms\Components\TextInput::make('hero_slider_autoplay')
                                            ->label('Otomatik Geçiş (ms)')
                                            ->numeric()
                                            ->default(6000)
                                            ->helperText('0 = kapalı, 6000 = 6 saniye'),

                                        Forms\Components\Repeater::make('hero_slides')
                                            ->label('Slider Slaytları')
                                            ->schema([
                                                Forms\Components\Toggle::make('is_active')
                                                    ->label('Aktif')
                                                    ->default(true)
                                                    ->columnSpanFull(),

                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Görsel')
                                                    ->image()
                                                    ->directory('settings/hero')
                                                    ->maxSize(2048)
                                                    ->columnSpanFull()
                                                    ->helperText('Yüklenen görsel önceliklidir, boş bırakılırsa URL kullanılır.'),

                                                Forms\Components\TextInput::make('image_url')
                                                    ->label('Görsel URL')
                                                    ->url()
                                                    ->columnSpanFull()
                                                    ->helperText('Dış link kullanmak isterseniz URL girin.'),

                                                Forms\Components\Fieldset::make('Basit Mod (Katman kullanmıyorsanız)')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title')
                                                            ->label('Başlık')
                                                            ->maxLength(100),

                                                        Forms\Components\TextInput::make('subtitle')
                                                            ->label('Alt Başlık')
                                                            ->maxLength(100),

                                                        Forms\Components\Textarea::make('description')
                                                            ->label('Açıklama')
                                                            ->rows(2)
                                                            ->maxLength(255),

                                                        Forms\Components\Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('primary_label')
                                                                    ->label('Birincil Buton Metni')
                                                                    ->maxLength(50),

                                                                Forms\Components\TextInput::make('primary_url')
                                                                    ->label('Birincil Buton Linki')
                                                                    ->maxLength(255),

                                                                Forms\Components\TextInput::make('secondary_label')
                                                                    ->label('İkincil Buton Metni')
                                                                    ->maxLength(50),

                                                                Forms\Components\TextInput::make('secondary_url')
                                                                    ->label('İkincil Buton Linki')
                                                                    ->maxLength(255),
                                                            ]),

                                                        Forms\Components\Grid::make(3)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('text_x')
                                                                    ->label('X Konumu (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(8),

                                                                Forms\Components\TextInput::make('text_y')
                                                                    ->label('Y Konumu (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(55),

                                                                Forms\Components\Select::make('text_align')
                                                                    ->label('Hizalama')
                                                                    ->options([
                                                                        'left' => 'Sol',
                                                                        'center' => 'Orta',
                                                                        'right' => 'Sağ',
                                                                    ])
                                                                    ->default('left'),

                                                                Forms\Components\TextInput::make('text_width')
                                                                    ->label('Genişlik')
                                                                    ->default('min(90vw, 560px)')
                                                                    ->helperText('CSS değeri'),
                                                            ]),
                                                    ])
                                                    ->columnSpanFull(),

                                                Forms\Components\Repeater::make('layers')
                                                    ->label('Katmanlar')
                                                    ->schema([
                                                        Forms\Components\Toggle::make('is_active')
                                                            ->label('Katman Aktif')
                                                            ->default(true)
                                                            ->columnSpanFull(),

                                                        Forms\Components\Select::make('type')
                                                            ->label('Katman Tipi')
                                                            ->options([
                                                                'text' => 'Metin',
                                                                'button' => 'Buton',
                                                                'image' => 'Görsel',
                                                            ])
                                                            ->default('text')
                                                            ->required(),

                                                        Forms\Components\Textarea::make('content')
                                                            ->label('Metin İçeriği')
                                                            ->rows(3)
                                                            ->columnSpanFull()
                                                            ->visible(fn (Get $get) => $get('type') === 'text'),

                                                        Forms\Components\TextInput::make('button_label')
                                                            ->label('Buton Metni')
                                                            ->maxLength(50)
                                                            ->visible(fn (Get $get) => $get('type') === 'button'),

                                                        Forms\Components\TextInput::make('button_url')
                                                            ->label('Buton Linki')
                                                            ->maxLength(255)
                                                            ->visible(fn (Get $get) => $get('type') === 'button'),

                                                        Forms\Components\Select::make('button_style')
                                                            ->label('Buton Stili')
                                                            ->options([
                                                                'primary' => 'Birincil (Yeşil)',
                                                                'secondary' => 'İkincil (Beyaz)',
                                                                'outline' => 'Çerçeveli',
                                                            ])
                                                            ->default('primary')
                                                            ->visible(fn (Get $get) => $get('type') === 'button'),

                                                        Forms\Components\FileUpload::make('image')
                                                            ->label('Katman Görseli')
                                                            ->image()
                                                            ->directory('settings/hero')
                                                            ->maxSize(2048)
                                                            ->columnSpanFull()
                                                            ->visible(fn (Get $get) => $get('type') === 'image'),

                                                        Forms\Components\TextInput::make('image_url')
                                                            ->label('Katman Görsel URL')
                                                            ->url()
                                                            ->columnSpanFull()
                                                            ->visible(fn (Get $get) => $get('type') === 'image'),

                                                        Forms\Components\TextInput::make('image_alt')
                                                            ->label('Görsel Alt Metni')
                                                            ->maxLength(150)
                                                            ->visible(fn (Get $get) => $get('type') === 'image'),

                                                        Forms\Components\Fieldset::make('Konum (Masaüstü)')
                                                            ->schema([
                                                                Forms\Components\TextInput::make('x')
                                                                    ->label('X (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(8),

                                                                Forms\Components\TextInput::make('y')
                                                                    ->label('Y (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(55),

                                                                Forms\Components\Select::make('align')
                                                                    ->label('Hizalama')
                                                                    ->options([
                                                                        'left' => 'Sol',
                                                                        'center' => 'Orta',
                                                                        'right' => 'Sağ',
                                                                    ])
                                                                    ->default('left'),
                                                            ])
                                                            ->columns(3)
                                                            ->columnSpanFull(),

                                                        Forms\Components\Fieldset::make('Konum (Mobil)')
                                                            ->schema([
                                                                Forms\Components\TextInput::make('x_mobile')
                                                                    ->label('X (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(8),

                                                                Forms\Components\TextInput::make('y_mobile')
                                                                    ->label('Y (%)')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->maxValue(100)
                                                                    ->default(60),

                                                                Forms\Components\Select::make('align_mobile')
                                                                    ->label('Hizalama')
                                                                    ->options([
                                                                        'left' => 'Sol',
                                                                        'center' => 'Orta',
                                                                        'right' => 'Sağ',
                                                                    ])
                                                                    ->default('left'),
                                                            ])
                                                            ->columns(3)
                                                            ->columnSpanFull(),

                                                        Forms\Components\Fieldset::make('Boyut')
                                                            ->schema([
                                                                Forms\Components\TextInput::make('width')
                                                                    ->label('Genişlik (CSS)')
                                                                    ->placeholder('min(90vw, 560px)')
                                                                    ->helperText('Örn: 420px, 60%, min(90vw, 560px)'),

                                                                Forms\Components\TextInput::make('height')
                                                                    ->label('Yükseklik (CSS)')
                                                                    ->placeholder('auto')
                                                                    ->helperText('Örn: 120px, auto'),

                                                                Forms\Components\TextInput::make('font_size')
                                                                    ->label('Yazı Boyutu (CSS)')
                                                                    ->placeholder('32px')
                                                                    ->visible(fn (Get $get) => in_array($get('type'), ['text', 'button'], true)),
                                                            ])
                                                            ->columns(3)
                                                            ->columnSpanFull(),

                                                        Forms\Components\Fieldset::make('Boyut (Mobil)')
                                                            ->schema([
                                                                Forms\Components\TextInput::make('width_mobile')
                                                                    ->label('Genişlik (CSS)')
                                                                    ->placeholder('min(92vw, 520px)'),

                                                                Forms\Components\TextInput::make('height_mobile')
                                                                    ->label('Yükseklik (CSS)')
                                                                    ->placeholder('auto'),

                                                                Forms\Components\TextInput::make('font_size_mobile')
                                                                    ->label('Yazı Boyutu (CSS)')
                                                                    ->placeholder('24px')
                                                                    ->visible(fn (Get $get) => in_array($get('type'), ['text', 'button'], true)),
                                                            ])
                                                            ->columns(3)
                                                            ->columnSpanFull(),

                                                        Forms\Components\TextInput::make('z_index')
                                                            ->label('Z-Index')
                                                            ->numeric()
                                                            ->default(2),

                                                        Forms\Components\Fieldset::make('Animasyon')
                                                            ->schema([
                                                                Forms\Components\Select::make('animation')
                                                                    ->label('Animasyon')
                                                                    ->options([
                                                                        'none' => 'Yok',
                                                                        'fade' => 'Fade',
                                                                        'slide-up' => 'Slide Up',
                                                                        'slide-down' => 'Slide Down',
                                                                        'slide-left' => 'Slide Left',
                                                                        'slide-right' => 'Slide Right',
                                                                        'zoom' => 'Zoom',
                                                                    ])
                                                                    ->default('fade'),

                                                                Forms\Components\TextInput::make('delay')
                                                                    ->label('Gecikme (ms)')
                                                                    ->numeric()
                                                                    ->default(0),

                                                                Forms\Components\TextInput::make('duration')
                                                                    ->label('Süre (ms)')
                                                                    ->numeric()
                                                                    ->default(700),
                                                            ])
                                                            ->columns(3)
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns(2)
                                                    ->defaultItems(0)
                                                    ->reorderable()
                                                    ->collapsible()
                                                    ->itemLabel(fn (array $state): ?string => $state['type'] ?? null)
                                                    ->addActionLabel('Katman Ekle')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(function (array $state): ?string {
                                                // Önce başlık (en okunabilir)
                                                if (!empty($state['title'])) {
                                                    return $state['title'];
                                                }
                                                // Sonra görsel URL
                                                if (!empty($state['image_url'])) {
                                                    return $state['image_url'];
                                                }
                                                // FileUpload array döndürür — güvenli işle
                                                $image = $state['image'] ?? null;
                                                if (is_array($image)) {
                                                    $first = reset($image);
                                                    return $first ? 'Görsel: ' . basename((string) $first) : null;
                                                }
                                                return $image ? 'Görsel: ' . basename((string) $image) : null;
                                            })
                                            ->addActionLabel('Slide Ekle'),
                                    ]),

                                Section::make('Marka Filmi (Video Bölümü)')
                                    ->description('Ana sayfadaki video showcase bölümü ayarları')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\TextInput::make('brand_video_url')
                                            ->label('Video URL (YouTube veya MP4)')
                                            ->placeholder('https://www.youtube.com/watch?v=XXXXXXXXXXX')
                                            ->helperText('YouTube linki veya doğrudan .mp4 URL. Boş bırakılırsa video bölümü görünmez.')
                                            ->url()
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('brand_video_title')
                                            ->label('Video Başlığı')
                                            ->placeholder('Tarımın Geleceğine Yolculuk')
                                            ->maxLength(100)
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('brand_video_subtitle')
                                            ->label('Video Alt Açıklaması')
                                            ->placeholder('Keysol Agro ile sürdürülebilir tarımın nasıl mümkün olduğunu keşfedin.')
                                            ->rows(2)
                                            ->maxLength(200)
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('brand_video_thumbnail')
                                            ->label('Özel Kapak Görseli')
                                            ->image()
                                            ->directory('settings/video')
                                            ->maxSize(2048)
                                            ->helperText('Boş bırakılırsa YouTube videosu için otomatik thumbnail kullanılır.')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Ana Sayfa SEO')
                                    ->description('Arama motorlarında görünecek sayfa başlığı ve açıklaması')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_meta_title')
                                            ->label('Sayfa Başlığı (Title)')
                                            ->placeholder('Örn: Keysol Agro | Tarımsal Ürünler Kataloğu')
                                            ->maxLength(70)
                                            ->helperText('Tavsiye edilen: 50–60 karakter. Boş bırakılırsa site adı kullanılır.')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('home_meta_description')
                                            ->label('Meta Açıklama (Description)')
                                            ->placeholder('Örn: Keysol Agro — Fungisit, herbisit, gübre ve bitki besleme ürünleri kataloğu. Tarımsal çözümlerimizi keşfedin.')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Tavsiye edilen: 150–160 karakter.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Header Ayarları')
                            ->schema([
                                Section::make('Logo ve Başlık')
                                    ->schema([
                                        Forms\Components\FileUpload::make('site_logo')
                                            ->label('Logo')
                                            ->image()
                                            ->directory('settings')
                                            ->maxSize(1024)
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml']),
                                            
                                        Forms\Components\FileUpload::make('site_favicon')
                                            ->label('Favicon')
                                            ->image()
                                            ->directory('settings')
                                            ->maxSize(512)
                                            ->acceptedFileTypes(['image/png', 'image/x-icon']),
                                    ]),
                                    
                                Section::make('Header Menü')
                                    ->schema([
                                        Forms\Components\Repeater::make('header_menu')
                                            ->label('Menü Öğeleri')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Başlık')
                                                    ->required(),
                                                    
                                                Forms\Components\TextInput::make('url')
                                                    ->label('Link')
                                                    ->required()
                                                    ->placeholder('/hakkimizda'),
                                                    
                                                Forms\Components\Toggle::make('is_external')
                                                    ->label('Dış Link')
                                                    ->helperText('Yeni sekmede açılacak'),
                                                    
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label('Sıra')
                                                    ->numeric()
                                                    ->default(0),
                                            ])
                                            ->columns(4)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->addActionLabel('Menü Öğesi Ekle'),
                                    ]),
                                    
                                Section::make('Üst Meta-Bar (Header Üst Şeridi)')
                                    ->description('Header\'ın üstündeki koyu şerit. Sol taraf = slogan + sosyal medya ikonları. Sağ taraf = aşağıdaki meta menü + dil + küçük CTA.')
                                    ->schema([
                                        Forms\Components\TextInput::make('header_tagline')
                                            ->label('Üst Şerit Slogan Metni (sol)')
                                            ->placeholder('Doğadan gelen güç — Tarımda güvenilir çözüm ortağınız')
                                            ->helperText('Üst şeridin sol tarafında görünür. Boş bırakılırsa sosyal medya ikonları ile dolar.')
                                            ->maxLength(200)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('header_meta_cta_text')
                                            ->label('Küçük CTA Metni (sağ, meta-bar)')
                                            ->placeholder('Katalog İndir'),

                                        Forms\Components\TextInput::make('header_meta_cta_url')
                                            ->label('Küçük CTA Linki (sağ, meta-bar)')
                                            ->placeholder('/katalog'),

                                        Forms\Components\Repeater::make('meta_menu')
                                            ->label('Meta Menü Öğeleri (sağ üst)')
                                            ->helperText('Hakkımızda, İletişim, SSS gibi kurumsal kısa linkler. Sadece masaüstünde görünür.')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Başlık')
                                                    ->required(),

                                                Forms\Components\TextInput::make('url')
                                                    ->label('Link')
                                                    ->required()
                                                    ->placeholder('/hakkimizda'),

                                                Forms\Components\Toggle::make('is_external')
                                                    ->label('Dış Link')
                                                    ->helperText('Yeni sekmede açılır'),

                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label('Sıra')
                                                    ->numeric()
                                                    ->default(0),
                                            ])
                                            ->columns(4)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->addActionLabel('Meta Menü Öğesi Ekle')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->collapsed(),

                                Section::make('Header Ana CTA (Büyük Buton)')
                                    ->description('Ana header barın sağındaki büyük buton (örn. "Bayi Girişi").')
                                    ->schema([
                                        Forms\Components\TextInput::make('header_cta_text')
                                            ->label('CTA Buton Metni')
                                            ->placeholder('Bayi Girişi'),

                                        Forms\Components\TextInput::make('header_cta_url')
                                            ->label('CTA Buton Linki')
                                            ->placeholder('/bayi-girisi'),

                                        Forms\Components\Toggle::make('header_show_phone')
                                            ->label('(Eski) Telefonu Göster')
                                            ->default(true)
                                            ->hidden(),

                                        Forms\Components\Toggle::make('header_show_email')
                                            ->label('(Eski) E-postayı Göster')
                                            ->default(true)
                                            ->hidden(),
                                    ])
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Mega Menü')
                            ->schema([
                                Section::make('Mega Menü Yönetimi')
                                    ->schema([
                                        Actions::make([
                                            FormAction::make('fillMegaMenuFromCategories')
                                                ->label('Kategorilerden Yükle')
                                                ->color('gray')
                                                ->action(function (Set $set) {
                                                    $set('mega_menu', $this->buildMegaMenuDefaults());

                                                    Notification::make()
                                                        ->title('Mega menü kategorilerden dolduruldu')
                                                        ->success()
                                                        ->send();
                                                }),
                                        ])->key('mega_menu_actions'),

                                        Forms\Components\Repeater::make('mega_menu')
                                            ->label('Mega Menü Öğeleri')
                                            ->schema([
                                                Forms\Components\Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\Select::make('category_id')
                                                            ->label('Üst Kategori')
                                                            ->options(fn () => $this->getParentCategoryOptions())
                                                            ->searchable()
                                                            ->preload()
                                                            ->helperText('Seçilirse başlık ve link otomatik doldurulur.'),

                                                        Forms\Components\TextInput::make('title')
                                                            ->label('Başlık')
                                                            ->placeholder('Bitki Koruma'),

                                                        Forms\Components\TextInput::make('url')
                                                            ->label('Link')
                                                            ->placeholder('/urunler?category=bitki-koruma'),
                                                    ]),

                                                Forms\Components\Toggle::make('use_auto_children')
                                                    ->label('Alt kategorileri otomatik getir')
                                                    ->default(true)
                                                    ->helperText('Alt kategori listesi boşsa otomatik altlar gösterilir.'),

                                                Forms\Components\Repeater::make('subcategories')
                                                    ->label('Alt Kategoriler')
                                                    ->schema([
                                                        Forms\Components\Select::make('category_id')
                                                            ->label('Alt Kategori')
                                                            ->options(function (Get $get) {
                                                                $parentId = $get('../../category_id');
                                                                $allCats = $this->getAllActiveCategoryOptions();

                                                                if ($parentId) {
                                                                    // Parent'a gore filtrele (memory'den, DB'den degil)
                                                                    $childIds = Cache::remember(
                                                                        "cat_children_{$parentId}",
                                                                        300,
                                                                        fn () => Category::where('parent_id', $parentId)
                                                                            ->where('status', 'active')
                                                                            ->pluck('id')
                                                                            ->all()
                                                                    );
                                                                    return array_intersect_key($allCats, array_flip($childIds));
                                                                }

                                                                return $allCats;
                                                            })
                                                            ->searchable()
                                                            ->preload()
                                                            ->helperText('Seçilirse başlık ve link otomatik doldurulur.'),

                                                        Forms\Components\TextInput::make('title')
                                                            ->label('Başlık')
                                                            ->placeholder('Akarisitler'),

                                                        Forms\Components\TextInput::make('url')
                                                            ->label('Link')
                                                            ->placeholder('/urunler?category=akarisitler'),
                                                    ])
                                                    ->columns(3)
                                                    ->defaultItems(0)
                                                    ->reorderable()
                                                    ->reorderableWithButtons()
                                                    ->collapsible()
                                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                                    ->addActionLabel('Alt Kategori Ekle'),

                                                Forms\Components\Toggle::make('use_auto_promos')
                                                    ->label('Görsel kartları otomatik oluştur')
                                                    ->default(true)
                                                    ->helperText('Kart listesi boşsa otomatik görseller gösterilir.'),

                                                Forms\Components\Repeater::make('promo_cards')
                                                    ->label('Görsel Kartlar')
                                                    ->schema([
                                                        Forms\Components\Select::make('category_id')
                                                            ->label('Kategori')
                                                            ->options(fn () => $this->getAllActiveCategoryOptions())
                                                            ->searchable()
                                                            ->preload()
                                                            ->helperText('Seçilirse başlık ve link otomatik doldurulur.'),

                                                        Forms\Components\TextInput::make('title')
                                                            ->label('Başlık')
                                                            ->placeholder('Akarisitler'),

                                                        Forms\Components\TextInput::make('url')
                                                            ->label('Link')
                                                            ->placeholder('/urunler?category=akarisitler'),

                                                        Forms\Components\FileUpload::make('image')
                                                            ->label('Görsel')
                                                            ->image()
                                                            ->directory('settings/mega-menu')
                                                            ->maxSize(2048)
                                                            ->helperText('Yüklenen görsel önceliklidir.')
                                                            ->columnSpan(2),

                                                        Forms\Components\TextInput::make('image_url')
                                                            ->label('Görsel URL')
                                                            ->url()
                                                            ->helperText('Dış link kullanmak isterseniz URL girin.')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->columns(4)
                                                    ->defaultItems(0)
                                                    ->reorderable()
                                                    ->reorderableWithButtons()
                                                    ->collapsible()
                                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                                    ->addActionLabel('Görsel Kart Ekle'),
                                            ])
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->addActionLabel('Mega Menü Öğesi Ekle'),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Footer Ayarları')
                            ->schema([
                                Section::make('Footer İçeriği')
                                    ->schema([
                                        Forms\Components\RichEditor::make('footer_about')
                                            ->label('Footer Hakkında Metni')
                                            ->toolbarButtons(['bold', 'italic', 'link'])
                                            ->columnSpanFull(),
                                            
                                        Forms\Components\Repeater::make('footer_columns')
                                            ->label('Footer Kolonları')
                                            ->schema([
                                                Forms\Components\TextInput::make('column_title')
                                                    ->label('Kolon Başlığı')
                                                    ->required(),
                                                    
                                                Forms\Components\Repeater::make('links')
                                                    ->label('Linkler')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title')
                                                            ->label('Link Başlığı')
                                                            ->required(),
                                                            
                                                        Forms\Components\TextInput::make('url')
                                                            ->label('Link URL')
                                                            ->required(),
                                                            
                                                        Forms\Components\Toggle::make('is_external')
                                                            ->label('Dış Link'),
                                                    ])
                                                    ->columns(3)
                                                    ->defaultItems(0)
                                                    ->reorderable()
                                                    ->reorderableWithButtons()
                                                    ->collapsible()
                                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                                            ])
                                            ->columns(1)
                                            ->defaultItems(0)
                                            ->maxItems(4)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['column_title'] ?? null)
                                            ->addActionLabel('Footer Kolonu Ekle'),
                                    ]),
                                    
                                Section::make('Copyright ve Alt Bilgi')
                                    ->schema([
                                        Forms\Components\TextInput::make('footer_copyright')
                                            ->label('Copyright Metni')
                                            ->placeholder('© 2024 Unikeyterra. Tüm hakları saklıdır.')
                                            ->columnSpanFull(),
                                            
                                        Forms\Components\Textarea::make('footer_bottom_text')
                                            ->label('Footer Alt Metin')
                                            ->rows(2)
                                            ->helperText('Footer en altında görünecek metin'),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Sosyal Medya')
                            ->schema([
                                Section::make('Sosyal Medya Hesapları')
                                    ->schema([
                                        Forms\Components\Repeater::make('social_media')
                                            ->label('Sosyal Medya Linkleri')
                                            ->schema([
                                                Forms\Components\Select::make('platform')
                                                    ->label('Platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'twitter' => 'Twitter/X',
                                                        'instagram' => 'Instagram',
                                                        'linkedin' => 'LinkedIn',
                                                        'youtube' => 'YouTube',
                                                        'whatsapp' => 'WhatsApp',
                                                    ])
                                                    ->required(),
                                                    
                                                Forms\Components\TextInput::make('url')
                                                    ->label('Profil URL')
                                                    ->url()
                                                    ->required(),
                                                    
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label('Sıra')
                                                    ->numeric()
                                                    ->default(0),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['platform'] ?? null)
                                            ->addActionLabel('Sosyal Medya Hesabı Ekle'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    protected function buildMegaMenuDefaults(): array
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['children' => function ($query) {
                $query
                    ->where('status', 'active')
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return $categories->map(function ($category) {
            $subcategories = $category->children->map(function ($child) {
                return [
                    'category_id' => $child->id,
                    'title' => $child->name,
                    'url' => route('products.category', $child->slug, false),
                ];
            })->values()->all();

            return [
                'category_id' => $category->id,
                'title' => $category->name,
                'url' => route('products.category', $category->slug, false),
                'use_auto_children' => true,
                'subcategories' => $subcategories,
                'use_auto_promos' => true,
                'promo_cards' => [],
            ];
        })->values()->all();
    }

    protected function buildHeroSlidesDefaults(): array
    {
        return [
            [
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                'title' => 'Tarımın Geleceği İçin',
                'subtitle' => 'Güvenilir Çözümler',
                'description' => 'Modern tarım teknolojileri ve kaliteli ürünlerle verimliliği artırın',
                'text_x' => 8,
                'text_y' => 55,
                'text_align' => 'left',
                'text_width' => 'min(90vw, 560px)',
                'text_x_mobile' => 8,
                'text_y_mobile' => 60,
                'text_align_mobile' => 'left',
                'text_width_mobile' => 'min(92vw, 520px)',
                'primary_label' => 'Ürünleri Keşfet',
                'primary_url' => route('products.index', [], false),
                'secondary_label' => 'İletişime Geç',
                'secondary_url' => route('contact', [], false),
            ],
            [
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                'title' => 'Sürdürülebilir Üretim',
                'subtitle' => 'Akıllı Tarım Çözümleri',
                'description' => 'Verimli üretim için yenilikçi gübre, tohum ve bitki koruma çözümleri',
                'text_x' => 50,
                'text_y' => 55,
                'text_align' => 'center',
                'text_width' => 'min(90vw, 640px)',
                'text_x_mobile' => 50,
                'text_y_mobile' => 60,
                'text_align_mobile' => 'center',
                'text_width_mobile' => 'min(92vw, 520px)',
                'primary_label' => 'Katalogu İncele',
                'primary_url' => route('products.index', [], false),
                'secondary_label' => 'Bayi Başvurusu',
                'secondary_url' => route('dealer.register', [], false),
            ],
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Kaydet')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $jsonFields = ['header_menu', 'meta_menu', 'footer_columns', 'social_media', 'hero_slides', 'mega_menu'];
        $booleanFields = ['header_show_phone', 'header_show_email'];
        $integerFields = ['hero_slider_autoplay'];

        // Tum ayarlari tek seferde hazirla
        $upsertData = [];
        $now = now();

        foreach ($data as $key => $value) {
            if ($value === null) {
                continue;
            }

            $type = 'text';
            if (in_array($key, $jsonFields)) {
                $type = 'json';
            } elseif (in_array($key, $booleanFields)) {
                $type = 'boolean';
            } elseif (in_array($key, $integerFields)) {
                $type = 'integer';
            }

            $serialized = match ($type) {
                'json' => json_encode($value),
                'boolean' => $value ? 'true' : 'false',
                default => (string) $value,
            };

            $upsertData[] = [
                'key' => $key,
                'value' => $serialized,
                'type' => $type,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }

        // Tek sorgu ile toplu upsert (N+1 yerine 1 sorgu)
        if (!empty($upsertData)) {
            Setting::upsert($upsertData, ['key'], ['value', 'type', 'updated_at']);
        }

        // Cache'i tek seferde temizle (100+ forget yerine tek metot)
        Setting::clearGlobalCache();

        // Page cache temizle — logo/menu degisiklikleri aninda yansisin
        \App\Http\Middleware\CachePublicPages::clearUrl('/');

        Notification::make()
            ->title('Ayarlar kaydedildi — cache güncellendi')
            ->success()
            ->send();
    }
}

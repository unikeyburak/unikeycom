<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\DosageImportService;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    
    protected static ?string $modelLabel = 'Ürün';
    protected static ?string $pluralModelLabel = 'Ürünler';
    protected static ?string $navigationLabel = 'Ürünler';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Katalog Yönetimi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Temel Bilgiler')
                    ->description('Ürünün temel bilgilerini girin')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Ana Kategori')
                                    ->options(Category::query()->where('status', 'active')->orderBy('name')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false),

                                Forms\Components\Select::make('categories')
                                    ->label('Tum Kategoriler')
                                    ->multiple()
                                    ->relationship('categories', 'name')
                                    ->options(Category::query()->where('status', 'active')->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->helperText('Urun birden fazla kategoride gorunebilir'),
                                    
                                Forms\Components\TextInput::make('name')
                                    ->label('Ürün Adı')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                        if (!$get('slug')) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                    
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                    
                                Forms\Components\TextInput::make('sku')
                                    ->label('Stok Kodu (SKU)')
                                    ->maxLength(100),
                            ]),
                            
                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'draft' => 'Taslak',
                                'active' => 'Aktif',
                                'inactive' => 'Pasif',
                            ])
                            ->default('draft')
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Öne Çıkan Ürün')
                            ->helperText('Ana sayfada görüntülenecektir'),
                    ])
                    ->columns(1),
                    
                Tabs::make('Detaylar')
                    ->tabs([
                        Tabs\Tab::make('Açıklamalar')
                            ->schema([
                                Forms\Components\Textarea::make('short_description')
                                    ->label('Kısa Açıklama')
                                    ->helperText('Ürün kartlarında ve sayfanın üstünde (resmin yanında) bold olarak görünür.')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('long_description')
                                    ->label('Detaylı Açıklama (Resmin Yanında)')
                                    ->helperText('Ürün fotoğrafının sağında, kısa açıklamanın altında görünür. Ürünü tanıtan paragraf metni buraya yazılır.')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold','italic','underline','strike',
                                        'heading','bulletList','orderedList',
                                        'blockquote','table','link',
                                    ]),

                                Forms\Components\RichEditor::make('features_text')
                                    ->label('Özellikler Sekmesi İçeriği')
                                    ->helperText('Ürün sayfasındaki "Özellikler" sekmesinde görünen içerik. Madde listesi, tablo veya metin girebilirsiniz.')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold','italic','underline','strike',
                                        'heading','bulletList','orderedList',
                                        'blockquote','table','link',
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Teknik Bilgiler')
                            ->schema([
                                Forms\Components\TextInput::make('active_ingredient')
                                    ->label('Aktif Madde')
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('formulation')
                                    ->label('Formülasyon')
                                    ->maxLength(255),
                                    
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('pasteTechnicalInfo')
                                        ->label('Tablodan Yapistir')
                                        ->icon('heroicon-o-clipboard-document-list')
                                        ->color('success')
                                        ->modalHeading('Teknik Bilgi Yapistir')
                                        ->modalDescription('Web sayfasindan veya Excel\'den kopyaladiginiz ozellik-deger tablosunu yapistirin. Her satir bir ozellik olacak.')
                                        ->modalSubmitActionLabel('Aktar')
                                        ->modalWidth('xl')
                                        ->form([
                                            Forms\Components\Textarea::make('paste_data')
                                                ->label('Tablo Verisi')
                                                ->required()
                                                ->rows(10)
                                                ->placeholder("Gorunus\tBerrak sivi\nYogunluk\t1.25 g/ml\npH\t6.5-7.5")
                                                ->helperText('Her satirda: Ozellik [TAB veya | veya ; veya :] Deger. Web sayfasindan tabloyu Ctrl+C / Ctrl+V ile yapistirin.'),
                                            Forms\Components\Toggle::make('append_mode')
                                                ->label('Mevcut verilere ekle')
                                                ->helperText('Kapali ise mevcut teknik bilgiler silinip yenileriyle degistirilir')
                                                ->default(false),
                                        ])
                                        ->action(function (array $data, Forms\Set $set, Forms\Get $get): void {
                                            $text = trim($data['paste_data']);
                                            if (empty($text)) {
                                                Notification::make()->warning()->title('Veri bulunamadi')->send();
                                                return;
                                            }

                                            $lines = preg_split('/\r?\n/', $text);
                                            $lines = array_filter($lines, fn($l) => trim($l) !== '');

                                            $parsed = [];
                                            foreach ($lines as $line) {
                                                $pair = null;
                                                // Delimiter onceligi: TAB > | > ; > :
                                                if (str_contains($line, "\t")) {
                                                    $pair = explode("\t", $line, 2);
                                                } elseif (str_contains($line, '|')) {
                                                    $pair = explode('|', $line, 2);
                                                } elseif (str_contains($line, ';')) {
                                                    $pair = explode(';', $line, 2);
                                                } elseif (str_contains($line, ':')) {
                                                    $pair = explode(':', $line, 2);
                                                }

                                                if ($pair && count($pair) === 2) {
                                                    $key = trim($pair[0]);
                                                    $val = trim($pair[1]);
                                                    if ($key !== '') {
                                                        $parsed[$key] = $val;
                                                    }
                                                }
                                            }

                                            if (empty($parsed)) {
                                                Notification::make()->warning()
                                                    ->title('Veri ayrilamadi')
                                                    ->body('Satirlarda ozellik ve deger ayirilabilecek bir ayrac bulunamadi (TAB, |, ; veya :)')
                                                    ->send();
                                                return;
                                            }

                                            $existing = $data['append_mode'] ? ($get('technical_info') ?? []) : [];
                                            $merged = array_merge($existing, $parsed);
                                            $set('technical_info', $merged);

                                            Notification::make()->success()
                                                ->title('Basariyla aktarildi')
                                                ->body(count($parsed) . ' teknik bilgi ' . ($data['append_mode'] ? 'eklendi.' : 'yuklendi.'))
                                                ->send();
                                        }),
                                ]),

                                Forms\Components\CheckboxList::make('packaging_sizes')
                                    ->label('Ambalaj Boyutları')
                                    ->options([
                                        // Katı / Toz (torba ikonu)
                                        '250 gr'  => '250 gr',
                                        '500 gr'  => '500 gr',
                                        '1 kg'    => '1 kg',
                                        '5 kg'    => '5 kg',
                                        '10 kg'   => '10 kg',
                                        '15 kg'   => '15 kg',
                                        '20 kg'   => '20 kg',
                                        '25 kg'   => '25 kg',
                                        '1000 kg' => '1000 kg (Big Bag)',
                                        // Sıvı (bidon ikonu)
                                        '250 cc'  => '250 cc',
                                        '500 cc'  => '500 cc',
                                        '1 L'     => '1 L',
                                        '5 L'     => '5 L',
                                        '10 L'    => '10 L',
                                        '15 L'    => '15 L',
                                        '20 L'    => '20 L',
                                        '25 L'    => '25 L',
                                        '1000 L'  => '1000 L (IBC)',
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull()
                                    ->helperText('Katı/toz ürünler için kg/gr → torba ikonu | Sıvı ürünler için L/cc → bidon ikonu olarak gösterilir'),

                                Forms\Components\CheckboxList::make('product_colors')
                                    ->label('Ürün Renk Seçenekleri')
                                    ->helperText('Ürünün mevcut renk varyantlarını işaretleyin. Ürün sayfasında renkli daireler olarak görünür.')
                                    ->options([
                                        'Beyaz'       => '⬜ Beyaz',
                                        'Krem'        => '🟨 Krem',
                                        'Sarı'        => '🟡 Sarı',
                                        'Açık Sarı'   => '💛 Açık Sarı',
                                        'Turuncu'     => '🟠 Turuncu',
                                        'Kırmızı'     => '🔴 Kırmızı',
                                        'Pembe'       => '🩷 Pembe',
                                        'Mor'         => '🟣 Mor',
                                        'Leylak'      => '💜 Leylak',
                                        'Mavi'        => '🔵 Mavi',
                                        'Lacivert'    => '🫐 Lacivert',
                                        'Açık Mavi'   => '🩵 Açık Mavi',
                                        'Turkuaz'     => '🩵 Turkuaz',
                                        'Yeşil'       => '🟢 Yeşil',
                                        'Açık Yeşil'  => '💚 Açık Yeşil',
                                        'Koyu Yeşil'  => '🌲 Koyu Yeşil',
                                        'Kahverengi'  => '🟤 Kahverengi',
                                        'Bej'         => '🫙 Bej',
                                        'Gri'         => '🩶 Gri',
                                        'Siyah'       => '⚫ Siyah',
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),

                                Forms\Components\KeyValue::make('technical_info')
                                    ->label('Teknik Bilgiler')
                                    ->keyLabel('Özellik')
                                    ->valueLabel('Değer')
                                    ->addButtonLabel('Yeni Özellik Ekle')
                                    ->reorderable()
                                    ->columnSpanFull()
                                    ->helperText('İçerik, bileşenler, fiziksel özellikler vb.')
                                    ->afterStateHydrated(function (Forms\Components\KeyValue $component, $state) {
                                        // KeyValue sadece string value destekler; nested array olanları filtrele
                                        if (!is_array($state)) return;
                                        $flat = array_filter($state, fn($v) => !is_array($v));
                                        $component->state($flat);
                                    })
                                    ->dehydrateStateUsing(function ($state, $record) {
                                        $flat = is_array($state) ? array_filter($state, fn($v) => !is_array($v)) : [];
                                        // DB'deki nested array'leri (content vs.) koru - schema.org için kullanılıyor
                                        if ($record && $record->exists) {
                                            $raw    = $record->getRawOriginal('technical_info');
                                            $orig   = $raw ? json_decode($raw, true) : [];
                                            $nested = array_filter((array) $orig, fn($v) => is_array($v));
                                            return array_merge($nested, $flat);
                                        }
                                        return $flat;
                                    }),
                            ]),
                            
                        Tabs\Tab::make('Dozaj ve Uygulama')
                            ->schema([
                                Forms\Components\Section::make('Dozaj Bilgileri')
                                    ->schema([
                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('pasteDosage')
                                                ->label('Tablodan Yapistir')
                                                ->icon('heroicon-o-clipboard-document-list')
                                                ->color('success')
                                                ->modalHeading('Dozaj Verisi Yapistir')
                                                ->modalDescription('Tabloyu kopyalayip asagiya yapistirin. Sutun eslemesini otomatik veya manuel yapabilirsiniz.')
                                                ->modalSubmitActionLabel('Aktar')
                                                ->modalWidth('2xl')
                                                ->form([
                                                    Forms\Components\Textarea::make('paste_data')
                                                        ->label('Tablo Verisi')
                                                        ->required()
                                                        ->rows(10)
                                                        ->helperText('Web sayfasindan tabloyu secip Ctrl+C / Ctrl+V ile yapistirin.'),

                                                    Forms\Components\Select::make('mapping_mode')
                                                        ->label('Sutun Esleme')
                                                        ->options([
                                                            'auto' => 'Otomatik (basliklardan algila)',
                                                            'manual' => 'Manuel (sutun numarasi sec)',
                                                        ])
                                                        ->default('auto')
                                                        ->live()
                                                        ->helperText('Otomatik mod baslik satirindaki "Bitki Adi", "Topraktan Uygulama" gibi isimleri tanir. Tanimazsa manuel secin.'),

                                                    Forms\Components\Grid::make(3)
                                                        ->schema([
                                                            Forms\Components\Select::make('col_crop')
                                                                ->label('Bitki')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default('1'),
                                                            Forms\Components\Select::make('col_sulama')
                                                                ->label('Sulama Dozu')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default(''),
                                                            Forms\Components\Select::make('col_yapraktan')
                                                                ->label('Yapraktan Dozu')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default(''),
                                                            Forms\Components\Select::make('col_topraktan')
                                                                ->label('Topraktan Dozu')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default(''),
                                                            Forms\Components\Select::make('col_period')
                                                                ->label('Uygulama Zamani')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default(''),
                                                            Forms\Components\Select::make('col_notes')
                                                                ->label('Not')
                                                                ->options(['' => '-', '1' => '1. Sutun', '2' => '2. Sutun', '3' => '3. Sutun', '4' => '4. Sutun', '5' => '5. Sutun', '6' => '6. Sutun', '7' => '7. Sutun', '8' => '8. Sutun'])
                                                                ->default(''),
                                                        ])
                                                        ->visible(fn (Forms\Get $get) => $get('mapping_mode') === 'manual'),

                                                    Forms\Components\Toggle::make('has_header')
                                                        ->label('Ilk satir baslik satiri (atla)')
                                                        ->default(true)
                                                        ->visible(fn (Forms\Get $get) => $get('mapping_mode') === 'manual'),

                                                    Forms\Components\Toggle::make('append_mode')
                                                        ->label('Mevcut verilere ekle')
                                                        ->helperText('Kapali ise mevcut dozaj verileri silinip yenileriyle degistirilir')
                                                        ->default(false),
                                                ])
                                                ->action(function (array $data, Forms\Set $set, Forms\Get $get): void {
                                                    try {
                                                        $service = new DosageImportService();

                                                        if (($data['mapping_mode'] ?? 'auto') === 'manual') {
                                                            $columnMap = array_filter([
                                                                'crop'               => !empty($data['col_crop']) ? (int) $data['col_crop'] : null,
                                                                'sulama_dosage'      => !empty($data['col_sulama']) ? (int) $data['col_sulama'] : null,
                                                                'yapraktan_dosage'   => !empty($data['col_yapraktan']) ? (int) $data['col_yapraktan'] : null,
                                                                'topraktan_dosage'   => !empty($data['col_topraktan']) ? (int) $data['col_topraktan'] : null,
                                                                'application_period' => !empty($data['col_period']) ? (int) $data['col_period'] : null,
                                                                'notes'              => !empty($data['col_notes']) ? (int) $data['col_notes'] : null,
                                                            ]);
                                                            $skipHeader = $data['has_header'] ?? true;
                                                            $rows = $service->parseWithManualMapping($data['paste_data'], $columnMap, $skipHeader);
                                                        } else {
                                                            $rows = $service->parsePastedText($data['paste_data']);
                                                        }

                                                        if (empty($rows)) {
                                                            Notification::make()
                                                                ->warning()
                                                                ->title('Veri bulunamadi')
                                                                ->body('Yapistirilan metinde gecerli dozaj verisi bulunamadi.')
                                                                ->send();
                                                            return;
                                                        }

                                                        $existing = $data['append_mode'] ? ($get('dosage_items') ?? []) : [];
                                                        $merged = array_merge(array_values($existing), $rows);
                                                        $set('dosage_items', $merged);

                                                        Notification::make()
                                                            ->success()
                                                            ->title('Basariyla aktarildi')
                                                            ->body(count($rows) . ' dozaj satiri ' . ($data['append_mode'] ? 'eklendi.' : 'yuklendi.'))
                                                            ->send();

                                                    } catch (\Exception $e) {
                                                        Notification::make()
                                                            ->danger()
                                                            ->title('Aktarma hatasi')
                                                            ->body($e->getMessage())
                                                            ->send();
                                                    }
                                                }),
                                        ]),

                                        Forms\Components\Repeater::make('dosage_items')
                                            ->label('Dozaj Tablosu')
                                            ->schema([
                                                Forms\Components\TextInput::make('crop')
                                                    ->label('Bitki/Urun')
                                                    ->required()
                                                    ->columnSpan(2),

                                                Forms\Components\TextInput::make('sulama_dosage')
                                                    ->label('Sulama Dozu')
                                                    ->placeholder('Orn: 2-3 kg/da'),

                                                Forms\Components\TextInput::make('yapraktan_dosage')
                                                    ->label('Yapraktan Dozu')
                                                    ->placeholder('Orn: 200-300 g/100L'),

                                                Forms\Components\TextInput::make('topraktan_dosage')
                                                    ->label('Topraktan Dozu')
                                                    ->placeholder('Orn: 3-5 kg/da'),

                                                Forms\Components\TextInput::make('application_period')
                                                    ->label('Uygulama Zamani')
                                                    ->placeholder('Orn: Ciceklenme oncesi'),

                                                Forms\Components\TextInput::make('notes')
                                                    ->label('Not')
                                                    ->placeholder('Ek bilgi'),
                                            ])
                                            ->columns(7)
                                            ->defaultItems(1)
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->itemLabel(fn (array $state): ?string =>
                                                $state['crop'] ?? null
                                            )
                                            ->columnSpanFull(),
                                    ]),
                                    
                                Forms\Components\Section::make('Uygulama Bilgileri')
                                    ->schema([
                                        Forms\Components\Repeater::make('application_info')
                                            ->label('Uygulama Notları')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Başlık')
                                                    ->required()
                                                    ->placeholder('Örn: Uygulama Yöntemi'),
                                                    
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Açıklama')
                                                    ->rows(3)
                                                    ->required(),
                                            ])
                                            ->defaultItems(1)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->columnSpanFull(),
                                    ]),
                                    
                                Forms\Components\Section::make('Uyarılar ve Karışım')
                                    ->schema([
                                        Forms\Components\Repeater::make('warning_info')
                                            ->label('Uyarılar')
                                            ->simple(
                                                Forms\Components\TextInput::make('warning')
                                                    ->label('Uyarı')
                                                    ->required()
                                            )
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->addActionLabel('Uyarı Ekle'),
                                            
                                        Forms\Components\Repeater::make('mixing_info')
                                            ->label('Karışım Bilgileri')
                                            ->schema([
                                                Forms\Components\Select::make('compatibility')
                                                    ->label('Uyumluluk')
                                                    ->options([
                                                        'compatible' => 'Karıştırılabilir',
                                                        'incompatible' => 'Karıştırılamaz',
                                                        'conditional' => 'Şartlı Karıştırılabilir',
                                                    ])
                                                    ->required(),
                                                    
                                                Forms\Components\TextInput::make('product_name')
                                                    ->label('Ürün/Madde Adı')
                                                    ->required(),
                                                    
                                                Forms\Components\Textarea::make('notes')
                                                    ->label('Notlar')
                                                    ->rows(2),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['product_name'] ?? null)
                                            ->addActionLabel('Karışım Bilgisi Ekle'),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Görseller ve Belgeler')
                            ->schema([
                                // ── Harici kaynaklı görseller (WordPress / URL import) ──────────────────
                                Section::make('Harici Kaynak Görseller')
                                    ->description("Bu görseller harici URL'den geliyor. × ile tek tek silebilir, \"Tümünü İndir\" ile sunucuya aktarabilirsiniz.")
                                    ->schema([
                                        Forms\Components\Repeater::make('_remote_image_urls')
                                            ->label(false)
                                            ->schema([
                                                Forms\Components\Placeholder::make('img_thumb')
                                                    ->label(false)
                                                    ->content(fn ($get) => new \Illuminate\Support\HtmlString(
                                                        '<img src="' . e($get('url')) . '" '
                                                        . 'style="height:72px;width:auto;max-width:140px;border-radius:6px;'
                                                        . 'border:1px solid #e2e8f0;object-fit:contain;" loading="lazy">'
                                                    ))
                                                    ->columnSpan(1),
                                                Forms\Components\TextInput::make('url')
                                                    ->label('URL')
                                                    ->readOnly()
                                                    ->columnSpan(3),
                                            ])
                                            ->columns(4)
                                            ->addable(false)
                                            ->reorderable(false)
                                            ->columnSpanFull()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): string =>
                                                basename(parse_url($state['url'] ?? '', PHP_URL_PATH) ?? 'görsel')
                                            )
                                            ->afterStateHydrated(function (Forms\Components\Repeater $component, $state, $record) {
                                                if (!$record || empty($record->images)) {
                                                    $component->state([]);
                                                    return;
                                                }
                                                $remotes = array_values(array_filter(
                                                    $record->images,
                                                    fn ($p) => str_starts_with($p, 'http')
                                                ));
                                                $component->state(array_map(fn ($url) => ['url' => $url], $remotes));
                                            }),

                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('download_remote_images')
                                                ->label('Tümünü Sunucuya İndir')
                                                ->icon('heroicon-o-cloud-arrow-down')
                                                ->color('warning')
                                                ->size('sm')
                                                ->requiresConfirmation()
                                                ->modalHeading('Harici Görselleri Sunucuya İndir')
                                                ->modalDescription('Harici URL\'lerdeki görseller sunucunuza indirilip yerel olarak kaydedilecek. Bu işlem biraz zaman alabilir.')
                                                ->modalSubmitActionLabel('İndir ve Kaydet')
                                                ->action(function ($record): void {
                                                    if (!$record || empty($record->images)) {
                                                        Notification::make()->warning()->title('İndirilecek görsel yok')->send();
                                                        return;
                                                    }
                                                    $newImages = [];
                                                    $downloaded = 0;
                                                    $failed = 0;
                                                    foreach ($record->images as $imageUrl) {
                                                        if (!str_starts_with($imageUrl, 'http')) {
                                                            $newImages[] = $imageUrl;
                                                            continue;
                                                        }
                                                        try {
                                                            $response = Http::timeout(30)->withOptions(['verify' => false])->get($imageUrl);
                                                            if (!$response->successful()) { $newImages[] = $imageUrl; $failed++; continue; }
                                                            $content  = $response->body();
                                                            $ext      = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                                                            $name     = Str::slug($record->slug ?? $record->name) . '-' . substr(md5($imageUrl), 0, 6) . '.' . $ext;
                                                            $path     = 'products/original/' . $name;
                                                            Storage::disk('public')->put($path, $content);
                                                            $newImages[] = $path;
                                                            $downloaded++;
                                                        } catch (\Exception $e) {
                                                            $newImages[] = $imageUrl;
                                                            $failed++;
                                                        }
                                                    }
                                                    $record->update(['images' => $newImages]);
                                                    $msg = $downloaded . ' görsel indirildi.';
                                                    if ($failed > 0) $msg .= ' ' . $failed . ' görsel indirilemedi.';
                                                    Notification::make()->success()
                                                        ->title('Görseller aktarıldı')
                                                        ->body($msg . ' Sayfa yenileniyor...')
                                                        ->send();
                                                    redirect(request()->header('Referer'));
                                                })
                                                ->visible(function ($record) {
                                                    if (!$record || empty($record->images)) return false;
                                                    foreach ($record->images as $img) {
                                                        if (str_starts_with($img, 'http')) return true;
                                                    }
                                                    return false;
                                                }),
                                        ]),
                                    ])
                                    ->collapsible()
                                    ->collapsed()
                                    ->visible(function ($record) {
                                        if (!$record || empty($record->images)) return false;
                                        return (bool) collect($record->images)->first(fn ($p) => str_starts_with($p, 'http'));
                                    }),

                                // ── Yerel görsel yönetimi ────────────────────────────────────────────────
                                Forms\Components\FileUpload::make('images')
                                    ->label('Ürün Görselleri')
                                    ->helperText('× ile sil · sürükle-bırak ile sırala · kalem ikonu ile düzenle · "Dosya Seç" ile yeni görsel ekle. İlk görsel ana görsel olarak kullanılır.')
                                    ->multiple()
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                                    ->imageEditorEmptyFillColor('#ffffff')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->maxSize(3072)
                                    ->maxFiles(15)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->reorderable()
                                    ->appendFiles()
                                    ->panelLayout('grid')
                                    ->downloadable()
                                    ->openable()
                                    ->columnSpanFull()
                                    ->saveUploadedFileUsing(function ($file) {
                                        $result = app(\App\Services\MediaService::class)->upload($file, 'products', [
                                            'generate_sizes'      => true,
                                            'generate_responsive' => true,
                                        ]);
                                        return $result['original'] ?? null;
                                    })
                                    ->deleteUploadedFileUsing(function (string $file): void {
                                        // Dosyayı diskten SİLMİYORUZ — sadece listeden kaldırıyoruz.
                                        // Fiziksel silmek istersen: Storage::disk('public')->delete($file);
                                    })
                                    ->afterStateHydrated(function (Forms\Components\FileUpload $component, $state) {
                                        // Yalnızca yerel (http:// olmayan) görselleri FileUpload'a aktar.
                                        // Harici URL'ler yukarıdaki Repeater tarafından yönetilir.
                                        if (is_array($state)) {
                                            $local = array_values(array_filter($state, fn ($p) => !str_starts_with($p, 'http')));
                                            $component->state($local);
                                        }
                                    }),
                                    // NOT: dehydrateStateUsing yok — FileUpload state'i doğrudan kaydedilir.
                                    // Harici URL'lerle birleştirme EditProduct::mutateFormDataBeforeSave'de yapılır.

                                    
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Group::make([
                                            Forms\Components\FileUpload::make('brochure_pdf')
                                                ->label('Brosur')
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->directory('certificates')
                                                ->maxSize(10240)
                                                ->helperText('PDF, maks 10MB'),
                                            Forms\Components\Actions::make([
                                                Forms\Components\Actions\Action::make('download_brochure_url')
                                                    ->label('Linkten Indir')
                                                    ->icon('heroicon-o-link')
                                                    ->color('gray')
                                                    ->size('sm')
                                                    ->modalHeading('Brosur - Linkten Indir')
                                                    ->modalSubmitActionLabel('Indir ve Kaydet')
                                                    ->form([
                                                        Forms\Components\TextInput::make('url')
                                                            ->label('PDF Linki')
                                                            ->url()
                                                            ->required()
                                                            ->placeholder('https://ornek.com/dosya.pdf'),
                                                    ])
                                                    ->action(function (array $data, Forms\Get $get, $record): void {
                                                        if (!$record) {
                                                            Notification::make()->warning()->title('Once urunu kaydedin')->send();
                                                            return;
                                                        }
                                                        $result = self::downloadPdfFromUrl($data['url'], 'brosur', $record->slug ?? $record->name ?? 'dosya');
                                                        if ($result['success']) {
                                                            $record->update(['brochure_pdf' => $result['path']]);
                                                            Notification::make()->success()
                                                                ->title('Brosur indirildi ve kaydedildi')
                                                                ->body('Dosya: /storage/' . $result['path'] . ' — Sayfa yenileniyor...')
                                                                ->send();
                                                            redirect(request()->header('Referer'));
                                                        } else {
                                                            Notification::make()->danger()->title('Indirme hatasi')->body($result['error'])->send();
                                                        }
                                                    }),
                                            ]),
                                        ]),

                                        Forms\Components\Group::make([
                                            Forms\Components\FileUpload::make('registration_certificate')
                                                ->label('Tescil Belgesi')
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->directory('certificates')
                                                ->maxSize(10240)
                                                ->helperText('PDF, maks 10MB'),
                                            Forms\Components\Actions::make([
                                                Forms\Components\Actions\Action::make('download_registration_url')
                                                    ->label('Linkten Indir')
                                                    ->icon('heroicon-o-link')
                                                    ->color('gray')
                                                    ->size('sm')
                                                    ->modalHeading('Tescil Belgesi - Linkten Indir')
                                                    ->modalSubmitActionLabel('Indir ve Kaydet')
                                                    ->form([
                                                        Forms\Components\TextInput::make('url')
                                                            ->label('PDF Linki')
                                                            ->url()
                                                            ->required()
                                                            ->placeholder('https://ornek.com/tescil.pdf'),
                                                    ])
                                                    ->action(function (array $data, Forms\Get $get, $record): void {
                                                        if (!$record) {
                                                            Notification::make()->warning()->title('Once urunu kaydedin')->send();
                                                            return;
                                                        }
                                                        $result = self::downloadPdfFromUrl($data['url'], 'tescil', $record->slug ?? $record->name ?? 'dosya');
                                                        if ($result['success']) {
                                                            $record->update(['registration_certificate' => $result['path']]);
                                                            Notification::make()->success()
                                                                ->title('Tescil belgesi indirildi ve kaydedildi')
                                                                ->body('Dosya: /storage/' . $result['path'] . ' — Sayfa yenileniyor...')
                                                                ->send();
                                                            redirect(request()->header('Referer'));
                                                        } else {
                                                            Notification::make()->danger()->title('Indirme hatasi')->body($result['error'])->send();
                                                        }
                                                    }),
                                            ]),
                                        ]),

                                        Forms\Components\Group::make([
                                            Forms\Components\FileUpload::make('label_certificate')
                                                ->label('Etiket Belgesi')
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->directory('certificates')
                                                ->maxSize(10240)
                                                ->helperText('PDF, maks 10MB'),
                                            Forms\Components\Actions::make([
                                                Forms\Components\Actions\Action::make('download_label_url')
                                                    ->label('Linkten Indir')
                                                    ->icon('heroicon-o-link')
                                                    ->color('gray')
                                                    ->size('sm')
                                                    ->modalHeading('Etiket Belgesi - Linkten Indir')
                                                    ->modalSubmitActionLabel('Indir ve Kaydet')
                                                    ->form([
                                                        Forms\Components\TextInput::make('url')
                                                            ->label('PDF Linki')
                                                            ->url()
                                                            ->required()
                                                            ->placeholder('https://ornek.com/etiket.pdf'),
                                                    ])
                                                    ->action(function (array $data, Forms\Get $get, $record): void {
                                                        if (!$record) {
                                                            Notification::make()->warning()->title('Once urunu kaydedin')->send();
                                                            return;
                                                        }
                                                        $result = self::downloadPdfFromUrl($data['url'], 'etiket', $record->slug ?? $record->name ?? 'dosya');
                                                        if ($result['success']) {
                                                            $record->update(['label_certificate' => $result['path']]);
                                                            Notification::make()->success()
                                                                ->title('Etiket belgesi indirildi ve kaydedildi')
                                                                ->body('Dosya: /storage/' . $result['path'] . ' — Sayfa yenileniyor...')
                                                                ->send();
                                                            redirect(request()->header('Referer'));
                                                        } else {
                                                            Notification::make()->danger()->title('Indirme hatasi')->body($result['error'])->send();
                                                        }
                                                    }),
                                            ]),
                                        ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Başlık')
                                    ->maxLength(255)
                                    ->helperText('Boş bırakılırsa ürün adı kullanılacaktır'),
                                    
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Açıklama')
                                    ->rows(3)
                                    ->maxLength(160)
                                    ->helperText('Arama motorlarında görünecek açıklama (maks 160 karakter)'),
                                    
                                Forms\Components\TagsInput::make('meta_keywords')
                                    ->label('Anahtar Kelimeler')
                                    ->separator(',')
                                    ->splitKeys([',', 'Tab', 'Enter'])
                                    ->helperText('Virgülle ayırarak girin veya toplu yapıştırın'),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Ana Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Tum Kategoriler')
                    ->badge()
                    ->separator(',')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Ürün Adı')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('active_ingredient')
                    ->label('Aktif Madde')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Durum')
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'active',
                        'warning' => 'inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'draft' => 'Taslak',
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                        default => $state,
                    }),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->multiple()
                    ->preload(),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'draft' => 'Taslak',
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Öne Çıkan')
                    ->placeholder('Tümü')
                    ->trueLabel('Sadece Öne Çıkanlar')
                    ->falseLabel('Öne Çıkan Olmayanlar'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Görüntüle'),
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
                Tables\Actions\Action::make('duplicate')
                    ->label('Kopyala')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('info')
                    ->action(function (Product $record): void {
                        $newProduct = $record->replicate();
                        $newProduct->name = $record->name . ' (Kopya)';
                        $newProduct->slug = Str::slug($newProduct->name) . '-' . uniqid();
                        $newProduct->sku = $record->sku . '-COPY-' . strtoupper(substr(uniqid(), -4));
                        $newProduct->status = 'draft';
                        $newProduct->is_featured = false;
                        $newProduct->created_at = now();
                        $newProduct->updated_at = now();
                        $newProduct->save();
                        
                        // JSON verilerini kopyala
                        $newProduct->technical_info = $record->technical_info;
                        $newProduct->application_info = $record->application_info;
                        $newProduct->warning_info = $record->warning_info;
                        $newProduct->mixing_info = $record->mixing_info;
                        $newProduct->dosage_items = $record->dosage_items;
                        $newProduct->save();
                        
                        Notification::make()
                            ->success()
                            ->title('Ürün başarıyla kopyalandı')
                            ->body('Yeni ürünü düzenleme sayfasına yönlendiriliyorsunuz...')
                            ->send();
                        
                        redirect()->to(ProductResource::getUrl('edit', ['record' => $newProduct]));
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Ürünü Kopyala')
                    ->modalDescription('Bu ürünün bir kopyası oluşturulacak. Kopya ürün taslak olarak kaydedilecektir.')
                    ->modalSubmitActionLabel('Kopyala'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('duplicate')
                        ->label('Seçilenleri Kopyala')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                $newProduct = $record->replicate();
                                $newProduct->name = $record->name . ' (Kopya)';
                                $newProduct->slug = Str::slug($newProduct->name) . '-' . uniqid();
                                $newProduct->sku = $record->sku . '-COPY-' . strtoupper(substr(uniqid(), -4));
                                $newProduct->status = 'draft';
                                $newProduct->is_featured = false;
                                $newProduct->created_at = now();
                                $newProduct->updated_at = now();
                                $newProduct->save();
                                
                                // JSON verilerini kopyala
                                $newProduct->technical_info = $record->technical_info;
                                $newProduct->application_info = $record->application_info;
                                $newProduct->warning_info = $record->warning_info;
                                $newProduct->mixing_info = $record->mixing_info;
                                $newProduct->dosage_items = $record->dosage_items;
                                $newProduct->save();
                            }
                            
                            Notification::make()
                                ->success()
                                ->title('Ürünler başarıyla kopyalandı')
                                ->body(count($records) . ' ürün kopyalandı.')
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Seçili Ürünleri Kopyala')
                        ->modalDescription('Seçili ürünlerin kopyaları oluşturulacak. Tüm kopyalar taslak olarak kaydedilecektir.')
                        ->modalSubmitActionLabel('Kopyala')
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ])
                ->label('Toplu İşlemler'),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\FaqsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    
    /**
     * URL'den PDF indirip certificates klasorune kaydet.
     */
    protected static function downloadPdfFromUrl(string $url, string $type, string $slug): array
    {
        try {
            $response = Http::timeout(30)->withOptions([
                'verify' => false,
            ])->get($url);

            if (!$response->successful()) {
                return ['success' => false, 'error' => 'Dosya indirilemedi (HTTP ' . $response->status() . ')'];
            }

            $content = $response->body();

            if (strlen($content) < 100) {
                return ['success' => false, 'error' => 'Indirilen dosya cok kucuk, gecerli bir PDF olmayabilir.'];
            }

            $safeSlug = Str::slug($slug) ?: 'urun';
            $fileName = $safeSlug . '-' . $type . '-' . time() . '.pdf';
            $storagePath = 'certificates/' . $fileName;

            Storage::disk('public')->put($storagePath, $content);

            return ['success' => true, 'path' => $storagePath];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Indirme hatasi: ' . $e->getMessage()];
        }
    }

    // Navigation badge kaldırıldı — shared hosting'de her sayfa yüklenişinde DB sorgusu yapıyordu
}

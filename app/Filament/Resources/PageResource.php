<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Sayfalar';

    protected static ?string $pluralLabel = 'Sayfalar';

    protected static ?string $label = 'Sayfa';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sayfa Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!empty($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(Page::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->rules(['alpha_dash']),

                        Forms\Components\Select::make('template')
                            ->label('Şablon')
                            ->options([
                                'default' => 'Varsayılan',
                                'about' => 'Hakkımızda',
                                'contact' => 'İletişim',
                                'custom' => 'Özel'
                            ])
                            ->default('default')
                            ->required(),

                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Öne Çıkan Görsel (Hero Arka Plan)')
                            ->image()
                            ->maxSize(5120)
                            ->directory('pages')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Sayfa İçeriği')
                    ->description('Blokları sürükleyerek sıralayabilir, yeni blok ekleyebilirsiniz.')
                    ->schema([
                        Forms\Components\Builder::make('content')
                            ->label('')
                            ->blocks([
                                // --- Tam Genişlik Metin ---
                                Forms\Components\Builder\Block::make('text')
                                    ->label('Metin Bloğu')
                                    ->icon('heroicon-o-document-text')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->label('İçerik')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'strike',
                                                'underline',
                                            ]),
                                        Forms\Components\Select::make('background')
                                            ->label('Arka Plan Rengi')
                                            ->options([
                                                '' => 'Yok',
                                                'green' => 'Yeşil',
                                                'blue' => 'Mavi',
                                                'gray' => 'Gri',
                                                'yellow' => 'Sarı',
                                            ])
                                            ->default(''),
                                    ]),

                                // --- İki Kolon ---
                                Forms\Components\Builder\Block::make('two_columns')
                                    ->label('İki Kolon (Yan Yana)')
                                    ->icon('heroicon-o-view-columns')
                                    ->schema([
                                        Forms\Components\RichEditor::make('left')
                                            ->label('Sol Kolon')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles', 'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                        Forms\Components\RichEditor::make('right')
                                            ->label('Sağ Kolon')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles', 'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                    ]),

                                // --- Üç Kolon (Zengin Metin) ---
                                Forms\Components\Builder\Block::make('three_columns')
                                    ->label('Üç Kolon (Yan Yana)')
                                    ->icon('heroicon-o-squares-2x2')
                                    ->schema([
                                        Forms\Components\RichEditor::make('left')
                                            ->label('Sol Kolon')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles', 'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                        Forms\Components\RichEditor::make('center')
                                            ->label('Orta Kolon')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles', 'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                        Forms\Components\RichEditor::make('right')
                                            ->label('Sağ Kolon')
                                            ->required()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content')
                                            ->toolbarButtons([
                                                'attachFiles', 'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                    ]),

                                // --- Görsel + Metin ---
                                Forms\Components\Builder\Block::make('image_text')
                                    ->label('Görsel + Metin (Yan Yana)')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Görsel')
                                            ->image()
                                            ->required()
                                            ->directory('pages/content')
                                            ->maxSize(5120),
                                        Forms\Components\RichEditor::make('content')
                                            ->label('Metin İçerik')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold', 'bulletList', 'h2', 'h3',
                                                'italic', 'link', 'orderedList', 'underline',
                                            ]),
                                        Forms\Components\Toggle::make('image_right')
                                            ->label('Görsel sağda olsun')
                                            ->default(false),
                                    ]),

                                // --- Özellik Listesi ---
                                Forms\Components\Builder\Block::make('features')
                                    ->label('Özellik Listesi (İkonlu)')
                                    ->icon('heroicon-o-check-badge')
                                    ->schema([
                                        Forms\Components\Repeater::make('items')
                                            ->label('Özellikler')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Başlık')
                                                    ->required(),
                                                Forms\Components\Textarea::make('text')
                                                    ->label('Açıklama')
                                                    ->rows(2),
                                            ])
                                            ->defaultItems(4)
                                            ->columns(2),
                                    ]),

                                // --- CTA (Aksiyon Butonu) ---
                                Forms\Components\Builder\Block::make('cta')
                                    ->label('Aksiyon Bölümü (CTA)')
                                    ->icon('heroicon-o-cursor-arrow-ripple')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Başlık')
                                            ->required(),
                                        Forms\Components\Textarea::make('text')
                                            ->label('Açıklama')
                                            ->rows(2),
                                        Forms\Components\TextInput::make('button_text')
                                            ->label('Buton Yazısı')
                                            ->default('Detaylı Bilgi'),
                                        Forms\Components\TextInput::make('button_url')
                                            ->label('Buton Linki')
                                            ->url()
                                            ->default('/iletisim'),
                                        Forms\Components\Select::make('background')
                                            ->label('Arka Plan')
                                            ->options([
                                                'green' => 'Yeşil',
                                                'blue' => 'Mavi',
                                                'gray' => 'Gri',
                                            ])
                                            ->default('green'),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->blockNumbers(false),
                    ]),

                Forms\Components\Section::make('SEO Ayarları')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Başlık')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Açıklama')
                            ->maxLength(500)
                            ->rows(3),

                        Forms\Components\Textarea::make('meta_keywords')
                            ->label('Meta Anahtar Kelimeler')
                            ->helperText('Virgülle ayırarak yazın')
                            ->rows(2),
                    ])
                    ->collapsed(),

                Forms\Components\Section::make('Yayın Ayarları')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'draft' => 'Taslak',
                                'published' => 'Yayında',
                            ])
                            ->default('draft')
                            ->required(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Yayınlanma Tarihi')
                            ->helperText('Gelecek tarih seçerseniz, sayfa o tarihte otomatik yayınlanır')
                            ->displayFormat('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('URL kopyalandı')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('template')
                    ->label('Şablon')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'default' => 'Varsayılan',
                        'about' => 'Hakkımızda',
                        'contact' => 'İletişim',
                        'custom' => 'Özel',
                        default => $state,
                    }),

                Tables\Columns\IconColumn::make('status')
                    ->label('Durum')
                    ->icon(fn (string $state): string => match ($state) {
                        'published' => 'heroicon-o-check-circle',
                        'draft' => 'heroicon-o-pencil',
                        default => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'draft' => 'Taslak',
                        'published' => 'Yayında',
                    ]),

                Tables\Filters\SelectFilter::make('template')
                    ->label('Şablon')
                    ->options([
                        'default' => 'Varsayılan',
                        'about' => 'Hakkımızda',
                        'contact' => 'İletişim',
                        'custom' => 'Özel',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->url(fn (Page $record): string => $record->url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}

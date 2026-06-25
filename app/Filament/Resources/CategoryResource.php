<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Forms\Components\TranslatableInput;
use App\Models\Category;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    
    protected static ?string $modelLabel = 'Kategori';
    protected static ?string $pluralModelLabel = 'Kategoriler';
    protected static ?string $navigationLabel = 'Kategoriler';
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Katalog Yönetimi';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        $languages = Language::getActive();
        $hasMultipleLanguages = $languages->count() > 1;

        return $form
            ->schema([
                Section::make('Kategori Bilgileri')
                    ->description($hasMultipleLanguages ? 'Her dil için kategori bilgilerini girin' : 'Kategori detaylarını girin')
                    ->schema([
                        // Kategori Adı - Çok Dilli
                        TranslatableInput::make('name')
                            ->label('Kategori Adı'),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Tüm diller için aynı URL kullanılır'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Üst Kategori')
                            ->options(function (?Category $record) {
                                return Category::query()
                                    ->where('id', '!=', $record?->id)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->helperText('Boş bırakırsanız ana kategori olur'),

                        // Açıklama - Çok Dilli RichEditor
                        TranslatableInput::makeRichEditor('description')
                            ->label('Açıklama'),

                        Forms\Components\FileUpload::make('icon_image')
                            ->label('Anasayfa Kategori Görseli')
                            ->image()
                            ->disk('public')
                            ->directory('categories/icons')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->imagePreviewHeight('160')
                            ->helperText('Anasayfada kategori kartında gösterilir. JPG/PNG/WEBP/SVG, maks 2MB'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Kategori Sayfası Görseli')
                            ->image()
                            ->directory('categories')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->saveUploadedFileUsing(function ($file) {
                                $result = app(\App\Services\MediaService::class)->upload($file, 'categories', [
                                    'generate_sizes' => true,
                                    'generate_responsive' => true,
                                ]);

                                return $result['original'] ?? null;
                            })
                            ->helperText('Kategori detay sayfasında kullanılır. Maks 2MB, JPG/PNG/WEBP'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Durum')
                                    ->options([
                                        'active' => 'Aktif',
                                        'inactive' => 'Pasif',
                                    ])
                                    ->default('active')
                                    ->native(false)
                                    ->helperText('Pasif kategoriler sitede görünmez'),

                                Forms\Components\Toggle::make('show_on_homepage')
                                    ->label('Anasayfada Göster')
                                    ->default(false)
                                    ->helperText('Açık ise bu kategori anasayfada görünür'),

                                Forms\Components\TextInput::make('homepage_order')
                                    ->label('Anasayfa Sırası')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Küçük sayı önce gelir (0, 1, 2...)')
                                    ->visible(fn (Forms\Get $get) => $get('show_on_homepage')),
                            ]),
                    ])
                    ->columns(1),

                Section::make('SEO Ayarları')
                    ->description($hasMultipleLanguages ? 'Her dil için SEO ayarlarını girin' : 'Arama motoru optimizasyonu')
                    ->schema([
                        // Meta Başlık - Çok Dilli
                        TranslatableInput::make('meta_title')
                            ->label('Meta Başlık'),

                        // Meta Açıklama - Çok Dilli
                        TranslatableInput::makeTextarea('meta_description', 3)
                            ->label('Meta Açıklama'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kategori Adı')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Üst Kategori')
                    ->searchable()
                    ->placeholder('Ana Kategori')
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Ürün Sayısı')
                    ->counts('products')
                    ->badge()
                    ->color('success'),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => $state === 'active' ? 'Aktif' : 'Pasif')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                    ])
                    ->placeholder('Tümü'),
                    
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Üst Kategori')
                    ->options([
                        null => 'Ana Kategoriler',
                    ] + Category::whereNull('parent_id')->pluck('name', 'id')->toArray())
                    ->placeholder('Tümü'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil')
                    ->before(function (DeleteAction $action, Category $record): void {
                        if ($record->products()->exists()) {
                            Notification::make()
                                ->title('Bu kategoride ürünler bulunuyor.')
                                ->body('Önce ürünleri silin veya başka kategoriye taşıyın.')
                                ->danger()
                                ->send();
                            $action->halt();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ])
                ->label('Toplu İşlemler'),
            ])
            ->defaultPaginationPageOption(25);
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    
    // Navigation badge kaldırıldı — shared hosting'de her sayfa yüklenişinde DB sorgusu yapıyordu
}

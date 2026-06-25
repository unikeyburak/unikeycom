<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogResource\Pages;
use App\Models\Catalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Kataloglar';

    protected static ?string $pluralLabel = 'Kataloglar';

    protected static ?string $label = 'Katalog';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Katalog Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, ?Catalog $record) {
                                if (!$record && !empty($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(Catalog::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->rules(['alpha_dash']),

                        Forms\Components\Select::make('language')
                            ->label('Dil')
                            ->options([
                                'tr' => 'Türkçe',
                                'en' => 'English',
                                'fr' => 'Français',
                                'es' => 'Español',
                                'ar' => 'العربية',
                            ])
                            ->default('tr')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'active'   => 'Aktif',
                                'inactive' => 'Pasif',
                            ])
                            ->default('active')
                            ->required(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->helperText('Küçük sayı önce görünür'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Yayınlanma Tarihi')
                            ->displayFormat('d.m.Y H:i')
                            ->default(now()),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Açıklama')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Dosya')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('PDF Dosyası')
                            ->required()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(51200) // 50 MB
                            ->directory('catalogs/pdf')
                            ->disk('public')
                            ->helperText('Maksimum 50 MB, sadece PDF')
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $path = is_array($state) ? reset($state) : $state;
                                    if ($path && Storage::disk('public')->exists($path)) {
                                        $set('file_size', Storage::disk('public')->size($path));
                                    }
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('file_size')
                            ->label('Dosya Boyutu (byte)')
                            ->numeric()
                            ->readOnly()
                            ->helperText('Dosya yüklendiğinde otomatik doldurulur'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Kapak Görseli')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Kapak Görseli')
                            ->image()
                            ->maxSize(5120)
                            ->directory('catalogs/covers')
                            ->disk('public')
                            ->helperText('Önerilen boyut: 600×800 px (3:4 oran)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('İstatistikler')
                    ->schema([
                        Forms\Components\TextInput::make('download_count')
                            ->label('İndirme Sayısı')
                            ->numeric()
                            ->default(0)
                            ->readOnly(),
                    ])
                    ->collapsed()
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Kapak')
                    ->disk('public')
                    ->height(60)
                    ->width(45)
                    ->defaultImageUrl(fn () => null),

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(45),

                Tables\Columns\TextColumn::make('language')
                    ->label('Dil')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'tr' => 'primary',
                        'en' => 'info',
                        'fr' => 'warning',
                        'es' => 'success',
                        'ar' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn ($state) => $state === 'active' ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state === 'active' ? 'Aktif' : 'Pasif'),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Boyut')
                    ->formatStateUsing(fn ($state) => $state
                        ? ($state >= 1048576
                            ? number_format($state / 1048576, 1) . ' MB'
                            : number_format($state / 1024, 0) . ' KB')
                        : '-'
                    ),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('İndirme')
                    ->sortable()
                    ->numeric(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'active'   => 'Aktif',
                        'inactive' => 'Pasif',
                    ]),

                Tables\Filters\SelectFilter::make('language')
                    ->label('Dil')
                    ->options([
                        'tr' => 'Türkçe',
                        'en' => 'English',
                        'fr' => 'Français',
                        'es' => 'Español',
                        'ar' => 'العربية',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('İndir')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Catalog $record): string => route('catalogs.download', $record->slug))
                    ->openUrlInNewTab()
                    ->color('success'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'edit'   => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }
}

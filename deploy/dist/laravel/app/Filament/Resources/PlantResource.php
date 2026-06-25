<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantResource\Pages;
use App\Filament\Resources\PlantResource\RelationManagers;
use App\Models\Plant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PlantResource extends Resource
{
    protected static ?string $model = Plant::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    
    protected static ?string $navigationLabel = 'Bitkiler';
    
    protected static ?string $pluralLabel = 'Bitkiler';
    
    protected static ?string $label = 'Bitki';
    
    protected static ?string $navigationGroup = 'Bitki Besleme';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bitki Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Bitki Adı')
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
                            ->unique(Plant::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('scientific_name')
                            ->label('Bilimsel Adı')
                            ->maxLength(255),
                            
                        Forms\Components\FileUpload::make('image')
                            ->label('Bitki Görseli')
                            ->image()
                            ->maxSize(5120)
                            ->directory('plants')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->saveUploadedFileUsing(function ($file) {
                                $result = app(\App\Services\MediaService::class)->upload($file, 'plants', [
                                    'generate_sizes' => true,
                                    'generate_responsive' => true,
                                ]);

                                return $result['original'] ?? null;
                            }),
                            
                        Forms\Components\RichEditor::make('description')
                            ->label('Açıklama')
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('icon')
                            ->label('İkon (Font Awesome)')
                            ->placeholder('fas fa-seedling')
                            ->helperText('Font Awesome icon class'),
                            
                        Forms\Components\Select::make('color_class')
                            ->label('Renk')
                            ->options([
                                'green' => 'Yeşil',
                                'blue' => 'Mavi',
                                'red' => 'Kırmızı',
                                'yellow' => 'Sarı',
                                'purple' => 'Mor',
                                'orange' => 'Turuncu',
                            ])
                            ->default('green'),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                            
                        Forms\Components\Toggle::make('show_on_homepage')
                            ->label('Anasayfada Göster')
                            ->default(true),
                            
                        Forms\Components\TextInput::make('homepage_order')
                            ->label('Anasayfa Sırası')
                            ->numeric()
                            ->default(0)
                            ->visible(fn (Forms\Get $get) => $get('show_on_homepage')),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Genel Sıralama')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Bitki Adı')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('scientific_name')
                    ->label('Bilimsel Adı')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('nutritionPrograms_count')
                    ->label('Program Sayısı')
                    ->counts('nutritionPrograms')
                    ->badge(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Durum')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Durum'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\NutritionProgramsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlants::route('/'),
            'create' => Pages\CreatePlant::route('/create'),
            'edit' => Pages\EditPlant::route('/{record}/edit'),
        ];
    }
}

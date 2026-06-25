<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    
    protected static ?string $navigationLabel = 'SSS (FAQ)';
    
    protected static ?string $modelLabel = 'Sıkça Sorulan Soru';
    
    protected static ?string $pluralModelLabel = 'Sıkça Sorulan Sorular';
    
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('faqable_type')
                    ->label('İlişkilendirilecek Tür')
                    ->options([
                        Product::class => 'Ürün',
                        Category::class => 'Kategori',
                        Page::class => 'Sayfa',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('faqable_id', null)),
                    
                Forms\Components\Select::make('faqable_id')
                    ->label('İlişkilendirilecek Öğe')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search, Forms\Get $get) {
                        $type = $get('faqable_type');
                        if (!$type) return [];
                        
                        $query = $type::query();
                        
                        if ($type === Product::class) {
                            return $query->where('name', 'like', "%{$search}%")
                                ->limit(50)
                                ->pluck('name', 'id');
                        } elseif ($type === Category::class) {
                            return $query->where('name', 'like', "%{$search}%")
                                ->limit(50)
                                ->pluck('name', 'id');
                        } elseif ($type === Page::class) {
                            return $query->where('title', 'like', "%{$search}%")
                                ->limit(50)
                                ->pluck('title', 'id');
                        }
                        
                        return [];
                    })
                    ->getOptionLabelUsing(function ($value, Forms\Get $get) {
                        $type = $get('faqable_type');
                        if (!$type || !$value) return null;
                        
                        $model = $type::find($value);
                        
                        if ($type === Product::class) {
                            return $model?->name;
                        } elseif ($type === Category::class) {
                            return $model?->name;
                        } elseif ($type === Page::class) {
                            return $model?->title;
                        }
                        
                        return null;
                    }),
                    
                Forms\Components\TextInput::make('question')
                    ->label('Soru')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                    
                Forms\Components\Textarea::make('answer')
                    ->label('Cevap')
                    ->required()
                    ->rows(3)
                    ->columnSpan('full'),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sıralama')
                    ->numeric()
                    ->default(0),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Soru')
                    ->searchable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('answer')
                    ->label('Cevap')
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('faqable_type')
                    ->label('Tür')
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            Product::class => 'Ürün',
                            Category::class => 'Kategori',
                            Page::class => 'Sayfa',
                            default => '-'
                        };
                    }),
                    
                Tables\Columns\TextColumn::make('faqable.name')
                    ->label('İlişkili Öğe')
                    ->getStateUsing(function ($record) {
                        if ($record->faqable_type === Product::class) {
                            return $record->faqable?->name;
                        } elseif ($record->faqable_type === Category::class) {
                            return $record->faqable?->name;
                        } elseif ($record->faqable_type === Page::class) {
                            return $record->faqable?->title;
                        }
                        return '-';
                    })
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Durum')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('faqable_type')
                    ->label('Tür')
                    ->options([
                        Product::class => 'Ürün',
                        Category::class => 'Kategori', 
                        Page::class => 'Sayfa',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif Durumu'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
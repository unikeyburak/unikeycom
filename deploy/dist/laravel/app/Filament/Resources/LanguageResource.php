<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    
    protected static ?string $navigationGroup = 'Sistem Yönetimi';
    
    protected static ?string $navigationLabel = 'Dil Yönetimi';
    
    protected static ?string $modelLabel = 'Dil';
    
    protected static ?string $pluralModelLabel = 'Diller';
    
    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dil Bilgileri')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label('Dil Kodu')
                                    ->required()
                                    ->maxLength(5)
                                    ->helperText('Örnek: tr, en, fr, es, ar')
                                    ->unique(ignoreRecord: true),
                                    
                                Forms\Components\TextInput::make('name')
                                    ->label('Dil Adı')
                                    ->required()
                                    ->maxLength(50)
                                    ->helperText('Örnek: Türkçe, English, Français'),
                                    
                                Forms\Components\TextInput::make('native_name')
                                    ->label('Yerel Adı')
                                    ->required()
                                    ->maxLength(50)
                                    ->helperText('Dilin kendi dilindeki adı'),
                                    
                                Forms\Components\TextInput::make('flag')
                                    ->label('Bayrak Kodu')
                                    ->maxLength(10)
                                    ->helperText('Örnek: 🇹🇷, 🇬🇧, 🇫🇷')
                                    ->placeholder('🇹🇷'),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('Ayarlar')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('direction')
                                    ->label('Yazı Yönü')
                                    ->options([
                                        'ltr' => 'Soldan Sağa (LTR)',
                                        'rtl' => 'Sağdan Sola (RTL)'
                                    ])
                                    ->default('ltr')
                                    ->required(),
                                    
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sıralama')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Düşük sayı önce gösterilir'),
                            ]),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(false)
                                    ->reactive()
                                    ->helperText('Bu dil sitede kullanılabilir mi?'),
                                    
                                Forms\Components\Toggle::make('is_default')
                                    ->label('Varsayılan')
                                    ->default(false)
                                    ->helperText('Site varsayılan dili')
                                    ->disabled(fn ($state, $record) => !$state && $record?->is_default),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('Bölgesel Ayarlar')
                    ->schema([
                        Forms\Components\KeyValue::make('date_format')
                            ->label('Tarih Formatları')
                            ->keyLabel('Format Türü')
                            ->valueLabel('Format')
                            ->default([
                                'short' => 'd.m.Y',
                                'long' => 'd F Y',
                                'datetime' => 'd.m.Y H:i'
                            ]),
                            
                        Forms\Components\KeyValue::make('currency')
                            ->label('Para Birimi Ayarları')
                            ->keyLabel('Ayar')
                            ->valueLabel('Değer')
                            ->default([
                                'code' => 'TRY',
                                'symbol' => '₺',
                                'position' => 'after',
                                'decimal_separator' => ',',
                                'thousands_separator' => '.'
                            ]),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flag')
                    ->label('Bayrak')
                    ->searchable(false)
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('code')
                    ->label('Kod')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Dil Adı')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('native_name')
                    ->label('Yerel Adı')
                    ->searchable(),
                    
                Tables\Columns\BadgeColumn::make('direction')
                    ->label('Yön')
                    ->colors([
                        'primary' => 'ltr',
                        'warning' => 'rtl',
                    ])
                    ->formatStateUsing(fn (string $state): string => $state === 'ltr' ? 'LTR' : 'RTL'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                Tables\Columns\IconColumn::make('is_default')
                    ->label('Varsayılan')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif Durumu'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Pasif Yap' : 'Aktif Yap')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(function (Language $record) {
                        $record->update(['is_active' => !$record->is_active]);
                        
                        Notification::make()
                            ->title($record->is_active ? 'Dil aktif edildi' : 'Dil pasif edildi')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('make_default')
                    ->label('Varsayılan Yap')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn ($record) => !$record->is_default && $record->is_active)
                    ->requiresConfirmation()
                    ->action(function (Language $record) {
                        $record->makeDefault();
                        
                        Notification::make()
                            ->title('Varsayılan dil değiştirildi')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => !$record->is_default),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->is_default) {
                                    Notification::make()
                                        ->title('Varsayılan dil silinemez')
                                        ->danger()
                                        ->send();
                                    return false;
                                }
                            }
                        }),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
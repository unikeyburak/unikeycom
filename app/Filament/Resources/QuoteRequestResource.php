<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Filament\Resources\QuoteRequestResource\RelationManagers;
use App\Models\QuoteRequest;
use App\Models\Dealer;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Illuminate\Support\Collection;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;
    
    protected static ?string $modelLabel = 'Teklif Talebi';
    protected static ?string $pluralModelLabel = 'Teklif Talepleri';
    protected static ?string $navigationLabel = 'Teklif Talepleri';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Müşteri İlişkileri';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Teklif Bilgileri')
                    ->description('Teklif talebi detayları')
                    ->schema([
                        Forms\Components\Select::make('dealer_id')
                            ->label('Bayi')
                            ->options(Dealer::where('status', 'approved')->pluck('company_name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                            
                        Forms\Components\Select::make('product_id')
                            ->label('Ürün')
                            ->options(Product::where('status', 'active')->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Miktar')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->disabled(fn (string $context): bool => $context === 'edit'),
                                    
                                Forms\Components\Select::make('unit')
                                    ->label('Birim')
                                    ->options([
                                        'Adet' => 'Adet',
                                        'Kg' => 'Kilogram',
                                        'Lt' => 'Litre',
                                        'Ton' => 'Ton',
                                        'Paket' => 'Paket',
                                    ])
                                    ->default('Adet')
                                    ->required()
                                    ->native(false)
                                    ->disabled(fn (string $context): bool => $context === 'edit'),
                            ]),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('delivery_city')
                                    ->label('Teslimat Şehri')
                                    ->maxLength(100)
                                    ->disabled(fn (string $context): bool => $context === 'edit'),
                                    
                                Forms\Components\DatePicker::make('delivery_date')
                                    ->label('Teslimat Tarihi')
                                    ->displayFormat('d/m/Y')
                                    ->minDate(now())
                                    ->disabled(fn (string $context): bool => $context === 'edit'),
                            ]),
                            
                        Forms\Components\TextInput::make('usage_purpose')
                            ->label('Kullanım Amacı')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                            
                        Forms\Components\Select::make('payment_method')
                            ->label('Ödeme Yöntemi')
                            ->options([
                                'Nakit' => 'Nakit',
                                'Vadeli' => 'Vadeli',
                                'Kredi Kartı' => 'Kredi Kartı',
                                'Havale/EFT' => 'Havale/EFT',
                            ])
                            ->native(false)
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                            
                        Forms\Components\Textarea::make('notes')
                            ->label('Bayi Notları')
                            ->rows(3)
                            ->columnSpanFull()
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                    ]),
                    
                Section::make('Durum ve Admin İşlemleri')
                    ->description('Teklif durumu ve admin notları')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'pending' => 'Beklemede',
                                'processing' => 'İşleniyor',
                                'completed' => 'Tamamlandı',
                                'cancelled' => 'İptal',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notları')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Bu notlar sadece yöneticiler tarafından görülür'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dealer.company_name')
                    ->label('Bayi')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Ürün')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Miktar')
                    ->formatStateUsing(fn (string $state, $record): string => $state . ' ' . $record->unit)
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Durum')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Beklemede',
                        'processing' => 'İşleniyor',
                        'completed' => 'Tamamlandı',
                        'cancelled' => 'İptal',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('delivery_city')
                    ->label('Teslimat Şehri')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('Teslimat Tarihi')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Ödeme')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Talep Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('notes')
                    ->label('Bayi Notu')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('admin_notes')
                    ->label('Admin Notu')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'pending' => 'Beklemede',
                        'processing' => 'İşleniyor',
                        'completed' => 'Tamamlandı',
                        'cancelled' => 'İptal',
                    ]),
                    
                Tables\Filters\SelectFilter::make('dealer_id')
                    ->label('Bayi')
                    ->relationship('dealer', 'company_name')
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Başlangıç'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Bitiş'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Görüntüle'),
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Durumu Güncelle')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Yeni Durum')
                                ->options([
                                    'pending' => 'Beklemede',
                                    'processing' => 'İşleniyor',
                                    'completed' => 'Tamamlandı',
                                    'cancelled' => 'İptal',
                                ])
                                ->required(),
                        ])
                        ->action(fn (Collection $records, array $data) => 
                            $records->each(fn ($record) => 
                                $record->update(['status' => $data['status']])
                            )
                        )
                        ->deselectRecordsAfterCompletion(),
                ])
                ->label('Toplu İşlemler'),
            ])
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('Henüz teklif talebi yok')
            ->emptyStateDescription('Bayiler ürünler için teklif talebinde bulunduğunda burada görünecektir.');
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
            'index' => Pages\ListQuoteRequests::route('/'),
            'create' => Pages\CreateQuoteRequest::route('/create'),
            'view' => Pages\ViewQuoteRequest::route('/{record}'),
            'edit' => Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
    
    // Navigation badge kaldırıldı — shared hosting'de her sayfa yüklenişinde DB sorgusu yapıyordu
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealerResource\Pages;
use App\Filament\Resources\DealerResource\RelationManagers;
use App\Models\Dealer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealerApprovedMail;
use App\Models\DealerUser;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class DealerResource extends Resource
{
    protected static ?string $model = Dealer::class;
    
    protected static ?string $modelLabel = 'Bayi';
    protected static ?string $pluralModelLabel = 'Bayiler';
    protected static ?string $navigationLabel = 'Bayiler';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Bayi Yönetimi';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Firma Bilgileri')
                    ->description('Bayi firma bilgilerini girin')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('company_name')
                                    ->label('Firma Adı')
                                    ->required()
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('contact_name')
                                    ->label('Yetkili Kişi')
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('email')
                                    ->label('E-posta')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20)
                                    ->placeholder('0532 123 45 67'),
                            ]),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('WhatsApp')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('0532 123 45 67'),
                                    
                                Forms\Components\TextInput::make('website')
                                    ->label('Web Sitesi')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://example.com'),
                            ]),
                    ])
                    ->columns(1),
                    
                Section::make('Adres ve Vergi Bilgileri')
                    ->description('Bayi adres ve vergi bilgileri')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('city')
                                    ->label('Şehir')
                                    ->required()
                                    ->maxLength(100),
                                    
                                Forms\Components\TextInput::make('district')
                                    ->label('İlçe')
                                    ->required()
                                    ->maxLength(100),
                            ]),
                            
                        Forms\Components\Textarea::make('address')
                            ->label('Adres')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tax_number')
                                    ->label('Vergi Numarası')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),
                                    
                                Forms\Components\TextInput::make('tax_office')
                                    ->label('Vergi Dairesi')
                                    ->required()
                                    ->maxLength(100),
                            ]),
                            
                        Forms\Components\TextInput::make('postal_code')
                            ->label('Posta Kodu')
                            ->maxLength(10),
                    ]),
                    
                Section::make('Durum ve Notlar')
                    ->description('Bayi durumu ve admin notları')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(false)
                            ->helperText('Bayinin sisteme giriş yapabilmesi için aktif olmalı'),
                            
                        Forms\Components\Toggle::make('is_verified')
                            ->label('Doğrulanmış')
                            ->default(false)
                            ->helperText('Doğrulanmış bayiler özel fiyatları görebilir'),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('credit_limit')
                                    ->label('Kredi Limiti')
                                    ->numeric()
                                    ->prefix('₺')
                                    ->default(0),
                                    
                                Forms\Components\Select::make('payment_terms')
                                    ->label('Ödeme Koşulları')
                                    ->options([
                                        '0' => 'Peşin',
                                        '15' => '15 Gün',
                                        '30' => '30 Gün',
                                        '45' => '45 Gün',
                                        '60' => '60 Gün',
                                        '90' => '90 Gün',
                                    ])
                                    ->default('0'),
                            ]),
                            
                        Forms\Components\Textarea::make('notes')
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
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Firma Adı')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('contact_name')
                    ->label('Yetkili')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('E-posta kopyalandı'),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('city')
                    ->label('Şehir')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Doğrulanmış')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('credit_limit')
                    ->label('Kredi Limiti')
                    ->money('try')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif Durumu'),
                    
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Doğrulama Durumu'),
                    
                Tables\Filters\Filter::make('city')
                    ->form([
                        Forms\Components\TextInput::make('city')
                            ->label('Şehir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city'],
                                fn (Builder $query, $city): Builder => $query->where('city', 'like', '%' . $city . '%'),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Dealer $record): bool => !$record->is_verified)
                    ->action(function (Dealer $record): void {
                        // Geçici şifre oluştur
                        $temporaryPassword = Str::random(12);
                        
                        // Bayi kullanıcısı oluştur veya güncelle
                        $dealerUser = DealerUser::where('dealer_id', $record->id)
                            ->where('role', 'owner')
                            ->first();
                            
                        if (!$dealerUser) {
                            $dealerUser = DealerUser::create([
                                'dealer_id' => $record->id,
                                'name' => $record->contact_name ?? $record->company_name,
                                'email' => $record->email,
                                'password' => Hash::make($temporaryPassword),
                                'phone' => $record->phone,
                                'role' => 'owner',
                                'is_active' => true,
                            ]);
                        } else {
                            $dealerUser->update([
                                'password' => Hash::make($temporaryPassword),
                                'is_active' => true,
                            ]);
                        }
                        
                        // Bayi durumunu güncelle
                        $record->update([
                            'is_verified' => true,
                            'is_active' => true,
                            'verified_at' => now(),
                        ]);
                        
                        // Onay e-postası gönder
                        Mail::to($record->email)->send(new DealerApprovedMail($record, $dealerUser, $temporaryPassword));
                        
                        Notification::make()
                            ->title('Bayi Onaylandı')
                            ->body("'{$record->company_name}' başarıyla onaylandı ve giriş bilgileri e-posta ile gönderildi.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make()
                    ->label('Görüntüle'),
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Seçilenleri Aktifleştir')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(fn ($record) => 
                            $record->update(['is_active' => true])
                        ))
                        ->deselectRecordsAfterCompletion(),
                        
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Seçilenleri Pasifleştir')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(fn ($record) => 
                            $record->update(['is_active' => false])
                        ))
                        ->deselectRecordsAfterCompletion(),
                        
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ])
                ->label('Toplu İşlemler'),
            ])
            ->emptyStateIcon('heroicon-o-building-storefront')
            ->emptyStateHeading('Henüz bayi kaydı yok')
            ->emptyStateDescription('Yeni bayi ekleyerek başlayabilirsiniz.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Bayi Ekle'),
            ]);
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
            'index' => Pages\ListDealers::route('/'),
            'create' => Pages\CreateDealer::route('/create'),
            'edit' => Pages\EditDealer::route('/{record}/edit'),
        ];
    }
    
    // Navigation badge kaldırıldı — shared hosting'de her sayfa yüklenişinde DB sorgusu yapıyordu
}
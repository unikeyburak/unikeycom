<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactFormResource\Pages;
use App\Filament\Resources\ContactFormResource\RelationManagers;
use App\Models\ContactForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ContactFormResource extends Resource
{
    protected static ?string $model = ContactForm::class;
    
    protected static ?string $modelLabel = 'İletişim Formu';
    protected static ?string $pluralModelLabel = 'İletişim Formları';
    protected static ?string $navigationLabel = 'İletişim Formları';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Müşteri İlişkileri';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('E-posta kopyalandı'),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Belirtilmemiş'),
                    
                Tables\Columns\TextColumn::make('subject')
                    ->label('Konu')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('message')
                    ->label('Mesaj')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Gönderim Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Adresi')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
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
                    ->label('Görüntüle')
                    ->modalHeading('İletişim Formu Detayları')
                    ->modalWidth('xl'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ])
                ->label('Toplu İşlemler'),
            ])
            ->emptyStateIcon('heroicon-o-envelope')
            ->emptyStateHeading('Henüz iletişim formu gönderimi yok')
            ->emptyStateDescription('Ziyaretçiler iletişim formu gönderdiğinde burada görünecektir.');
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('İletişim Bilgileri')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Ad Soyad'),
                                Infolists\Components\TextEntry::make('email')
                                    ->label('E-posta')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Telefon')
                                    ->copyable()
                                    ->placeholder('Belirtilmemiş'),
                            ]),
                        
                        Infolists\Components\TextEntry::make('subject')
                            ->label('Konu')
                            ->columnSpanFull(),
                            
                        Infolists\Components\TextEntry::make('message')
                            ->label('Mesaj')
                            ->columnSpanFull()
                            ->html()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state))),
                    ]),
                    
                Infolists\Components\Section::make('Teknik Bilgiler')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('ip_address')
                                    ->label('IP Adresi'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Gönderim Tarihi')
                                    ->dateTime('d.m.Y H:i'),
                            ]),
                        
                        Infolists\Components\TextEntry::make('user_agent')
                            ->label('Tarayıcı Bilgisi')
                            ->columnSpanFull()
                            ->placeholder('Belirtilmemiş'),
                    ])
                    ->collapsible(),
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
            'index' => Pages\ListContactForms::route('/'),
            'view' => Pages\ViewContactForm::route('/{record}'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    // Navigation badge kaldırıldı — shared hosting'de her sayfa yüklenişinde DB sorgusu yapıyordu
}
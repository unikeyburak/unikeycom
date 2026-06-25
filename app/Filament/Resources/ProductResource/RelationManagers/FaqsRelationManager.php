<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $title = 'Sıkça Sorulan Sorular (FAQ)';
    
    protected static ?string $modelLabel = 'SSS';
    
    protected static ?string $pluralModelLabel = 'SSS\'ler';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Soru')
                    ->searchable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('answer')
                    ->label('Cevap')
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif Durumu'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Yeni SSS Ekle')
                    ->successNotificationTitle('SSS başarıyla eklendi'),
                    
                Tables\Actions\Action::make('generate_auto')
                    ->label('Otomatik SSS Oluştur')
                    ->icon('heroicon-o-sparkles')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Otomatik SSS Oluştur')
                    ->modalDescription('Ürün bilgilerinden otomatik olarak SSS\'ler oluşturulacak. Devam etmek istiyor musunuz?')
                    ->action(function () {
                        $product = $this->ownerRecord;
                        $faqs = [];
                        
                        // Etken madde
                        if ($product->active_ingredient) {
                            $faqs[] = [
                                'question' => 'Bu ürünün etken maddesi nedir?',
                                'answer' => $product->active_ingredient . ' etken maddesini içerir.',
                                'sort_order' => 10
                            ];
                        }
                        
                        // Formülasyon
                        if ($product->formulation) {
                            $faqs[] = [
                                'question' => 'Ürünün formülasyonu nedir?',
                                'answer' => 'Bu ürün ' . $product->formulation . ' formülasyonundadır.',
                                'sort_order' => 20
                            ];
                        }
                        
                        // Dozaj
                        if ($product->dosage_items && count($product->dosage_items) > 0) {
                            $crops = array_column($product->dosage_items, 'crop');
                            $faqs[] = [
                                'question' => 'Hangi bitkilerde kullanılır?',
                                'answer' => 'Bu ürün ' . implode(', ', $crops) . ' bitkilerinde kullanılmaktadır.',
                                'sort_order' => 30
                            ];
                        }
                        
                        // Güvenlik
                        $faqs[] = [
                            'question' => 'Güvenli kullanım için nelere dikkat edilmeli?',
                            'answer' => 'Koruyucu ekipman kullanın, çocuklardan uzak tutun ve kullanım talimatlarına uygun şekilde uygulayın.',
                            'sort_order' => 100
                        ];
                        
                        foreach ($faqs as $faq) {
                            $product->faqs()->create($faq);
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Otomatik SSS\'ler oluşturuldu')
                            ->success()
                            ->send();
                    }),
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
}
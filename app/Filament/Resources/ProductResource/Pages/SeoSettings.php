<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Actions;
use Filament\Notifications\Notification;

class SeoSettings extends Page
{
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.seo-settings';
    
    protected static ?string $title = 'SEO ve Rich Snippets Yönetimi';
    
    public ?array $data = [];
    
    public Product $record;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        $this->form->fill([
            'meta_title' => $this->record->meta_title,
            'meta_description' => $this->record->meta_description,
            'meta_keywords' => $this->record->meta_keywords,
            'enable_faq' => $this->record->faqs()->exists(),
            'enable_howto' => !empty($this->record->dosage_items),
            'enable_reviews' => false, // Henüz review sistemi yok
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Meta Tag Yönetimi')
                    ->description('Arama motorları için optimize edilmiş meta bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Başlık')
                            ->maxLength(60)
                            ->helperText(fn ($state) => (60 - strlen($state ?? '')) . ' karakter kaldı')
                            ->reactive(),
                            
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Açıklama')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText(fn ($state) => (160 - strlen($state ?? '')) . ' karakter kaldı')
                            ->reactive(),
                            
                        Forms\Components\TextInput::make('meta_keywords')
                            ->label('Anahtar Kelimeler')
                            ->helperText('Virgülle ayırarak yazın'),
                    ]),
                    
                Forms\Components\Section::make('Rich Snippets Ayarları')
                    ->description('Google zengin sonuçları için schema ayarları')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('enable_faq')
                                    ->label('FAQ Schema')
                                    ->helperText('Sıkça sorulan sorular gösterilsin')
                                    ->reactive(),
                                    
                                Forms\Components\Toggle::make('enable_howto')
                                    ->label('HowTo Schema')
                                    ->helperText('Uygulama talimatı gösterilsin')
                                    ->reactive(),
                                    
                                Forms\Components\Toggle::make('enable_reviews')
                                    ->label('Review Schema')
                                    ->helperText('Yorumlar gösterilsin')
                                    ->disabled()
                                    ->reactive(),
                                    
                                Forms\Components\Toggle::make('enable_video')
                                    ->label('Video Schema')
                                    ->helperText('Video içerik varsa gösterilsin')
                                    ->disabled()
                                    ->reactive(),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('Schema Önizleme')
                    ->description('Google\'da nasıl görüneceği')
                    ->schema([
                        Forms\Components\ViewField::make('schema_preview')
                            ->view('filament.forms.components.schema-preview'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Kaydet')
                ->action('save'),
                
            Actions\Action::make('test_schema')
                ->label('Schema Test Et')
                ->color('secondary')
                ->url('https://search.google.com/test/rich-results', shouldOpenInNewTab: true),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $this->record->update([
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keywords' => $data['meta_keywords'],
        ]);
        
        Notification::make()
            ->title('SEO ayarları güncellendi')
            ->success()
            ->send();
    }
}
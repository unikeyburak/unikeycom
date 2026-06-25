<?php

namespace App\Filament\Resources\ImportResource\Pages;

use App\Filament\Resources\ImportResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class WordPressImport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ImportResource::class;

    protected static string $view = 'filament.pages.wordpress-import';

    protected static ?string $title = 'WordPress Veri Aktarımı';

    public ?string $import_method = 'api';
    public ?string $url = '';
    public ?string $consumer_key = '';
    public ?string $consumer_secret = '';
    public $csv_file = null;
    public ?string $db_host = 'localhost';
    public ?string $db_name = '';
    public ?string $db_user = '';
    public ?string $db_password = '';
    public ?string $table_prefix = 'wp_';
    public bool $test_mode = true;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Import Yöntemi')
                ->schema([
                    Radio::make('import_method')
                        ->label('Aktarım Yöntemi')
                        ->options([
                            'api' => 'REST API',
                            'csv' => 'CSV Dosyası',
                            'sql' => 'Doğrudan SQL'
                        ])
                        ->default('api')
                        ->reactive(),

                    Toggle::make('test_mode')
                        ->label('Test Modu')
                        ->helperText('Test modunda veriler kaydedilmez')
                        ->default(true),
                ]),

            Section::make('API Ayarları')
                ->schema([
                    TextInput::make('url')
                        ->label('WordPress Site URL')
                        ->url()
                        ->placeholder('https://siteadi.com')
                        ->required(),

                    TextInput::make('consumer_key')
                        ->label('WooCommerce Consumer Key')
                        ->placeholder('ck_...')
                        ->helperText('WooCommerce > Ayarlar > Gelişmiş > REST API\'den alınır'),

                    TextInput::make('consumer_secret')
                        ->label('WooCommerce Consumer Secret')
                        ->placeholder('cs_...')
                        ->password()
                        ->helperText('Consumer Key ile birlikte oluşturulur'),
                ])
                ->visible(fn () => $this->import_method === 'api'),

            Section::make('CSV Ayarları')
                ->schema([
                    FileUpload::make('csv_file')
                        ->label('CSV Dosyası')
                        ->acceptedFileTypes(['text/csv', 'application/csv'])
                        ->required()
                        ->helperText('Örnek CSV şablonu: database/imports/wordpress-import-template.csv'),
                ])
                ->visible(fn () => $this->import_method === 'csv'),

            Section::make('SQL Ayarları')
                ->schema([
                    TextInput::make('db_host')
                        ->label('Database Host')
                        ->default('localhost')
                        ->required(),
                    
                    TextInput::make('db_name')
                        ->label('Database Adı')
                        ->required(),
                    
                    TextInput::make('db_user')
                        ->label('Database Kullanıcı')
                        ->required(),
                    
                    TextInput::make('db_password')
                        ->label('Database Şifre')
                        ->password()
                        ->required(),
                    
                    TextInput::make('table_prefix')
                        ->label('Tablo Öneki')
                        ->default('wp_')
                        ->required(),
                ])
                ->columns(2)
                ->visible(fn () => $this->import_method === 'sql'),
        ];
    }

    public function import(): void
    {
        $data = $this->form->getState();

        try {
            $params = [
                'method' => $data['import_method'],
            ];

            if ($data['test_mode']) {
                $params['--test'] = true;
            }

            switch ($data['import_method']) {
                case 'api':
                    $params['--url'] = $data['url'];
                    if (!empty($data['consumer_key'])) {
                        $params['--consumer_key'] = $data['consumer_key'];
                    }
                    if (!empty($data['consumer_secret'])) {
                        $params['--consumer_secret'] = $data['consumer_secret'];
                    }
                    break;

                case 'csv':
                    if ($data['csv_file'] instanceof TemporaryUploadedFile) {
                        $path = $data['csv_file']->store('imports');
                        $params['--file'] = storage_path('app/' . $path);
                    }
                    break;

                case 'sql':
                    $params['--db_host'] = $data['db_host'];
                    $params['--db_name'] = $data['db_name'];
                    $params['--db_user'] = $data['db_user'];
                    $params['--db_password'] = $data['db_password'];
                    $params['--db_prefix'] = $data['table_prefix'];
                    break;
            }

            // Artisan komutunu çalıştır
            set_time_limit(300);
            Artisan::call('import:wordpress', $params);
            $output = Artisan::output();

            // Sonuclari parse et
            $imported = 0;
            $skipped = 0;
            $errors = 0;
            if (preg_match('/Toplam aktarılan: (\d+)/', $output, $m)) $imported = (int) $m[1];
            if (preg_match('/Atlanan: (\d+)/', $output, $m)) $skipped = (int) $m[1];
            if (preg_match('/Hatalı: (\d+)/', $output, $m)) $errors = (int) $m[1];

            $body = "{$imported} ürün aktarıldı, {$skipped} atlandı.";
            if ($errors > 0) {
                $body .= " {$errors} hatalı.";
            }

            // Test modu uyarisi
            if ($data['test_mode']) {
                $body .= "\n(Test modu - değişiklikler kaydedilmedi)";
            }

            if ($imported > 0 || $skipped > 0) {
                Notification::make()
                    ->title('Import Başarılı!')
                    ->body($body)
                    ->success()
                    ->send();
            } elseif ($errors > 0) {
                Notification::make()
                    ->title('Import Hatası')
                    ->body($body . "\n\nDetay:\n" . Str::limit($output, 500))
                    ->danger()
                    ->send();
            } else {
                Notification::make()
                    ->title('Import Tamamlandı')
                    ->body($output)
                    ->warning()
                    ->send();
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title('Import Hatası')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function downloadTemplate()
    {
        $path = public_path('imports/wordpress-import-template.csv');
        
        if (!file_exists($path)) {
            // Template'i oluştur
            $template = "Ürün Adı,SKU,Kategori,Etken Madde,Formülasyon,Dozaj,Açıklama,Kullanım Talimatı,Uyarı Metni,Karışım Bilgisi\n";
            $template .= '"Örnek Fungisit","FNG-001","Fungisitler","Azoxystrobin","WG (Suda Dağılan Granül)","Domates: 20 gr/da, Biber: 25 gr/da","Geniş spektrumlu sistemik fungisit","Sabah erken saatlerde uygulayın","Arılara zararlıdır","Diğer fungisitlerle karıştırılabilir"';
            
            $dir = dirname($path);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            file_put_contents($path, $template);
        }

        return response()->download($path);
    }
}
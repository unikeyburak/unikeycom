<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class ExportWordPressData extends Command
{
    protected $signature = 'export:wordpress {--url=} {--username=} {--password=} {--output=wordpress-export.csv}';
    protected $description = 'WordPress sitesinden veri export et (REST API veya CSV)';

    public function handle()
    {
        $url = $this->option('url') ?? $this->ask('WordPress site URL\'i');
        $username = $this->option('username') ?? $this->ask('WordPress kullanıcı adı');
        $password = $this->option('password') ?? $this->secret('WordPress şifre');
        $output = $this->option('output');
        
        $this->info('WordPress verisi export ediliyor...');
        
        // Basic Auth ile API'ye bağlan
        $headers = [
            'Authorization' => 'Basic ' . base64_encode("{$username}:{$password}")
        ];
        
        // CSV Writer hazırla
        $csv = Writer::createFromPath($output, 'w+');
        $csv->insertOne([
            'Ürün Adı',
            'SKU',
            'Kategori',
            'Etken Madde',
            'Formülasyon',
            'Dozaj',
            'Açıklama',
            'Kullanım Talimatı',
            'Uyarı Metni',
            'Karışım Bilgisi',
            'Görsel URL',
            'PDF Broşür',
            'Ruhsat Belgesi'
        ]);
        
        $page = 1;
        $exported = 0;
        
        do {
            // WooCommerce API'yi dene
            $response = Http::withHeaders($headers)->get("{$url}/wp-json/wc/v3/products", [
                'per_page' => 100,
                'page' => $page
            ]);
            
            if (!$response->successful()) {
                // Custom post type dene
                $response = Http::withHeaders($headers)->get("{$url}/wp-json/wp/v2/product", [
                    'per_page' => 100,
                    'page' => $page
                ]);
            }
            
            $products = $response->json();
            
            if (empty($products)) {
                break;
            }
            
            foreach ($products as $product) {
                // Kategori adını al
                $categoryName = '';
                if (!empty($product['categories'])) {
                    $catId = $product['categories'][0]['id'] ?? $product['categories'][0];
                    $catResponse = Http::withHeaders($headers)->get("{$url}/wp-json/wc/v3/products/categories/{$catId}");
                    if ($catResponse->successful()) {
                        $category = $catResponse->json();
                        $categoryName = $category['name'] ?? '';
                    }
                }
                
                // Meta verileri al
                $metaData = [];
                foreach ($product['meta_data'] ?? [] as $meta) {
                    $metaData[$meta['key']] = $meta['value'];
                }
                
                // ACF verileri
                $acf = $product['acf'] ?? [];
                
                // Görsel URL
                $imageUrl = '';
                if (!empty($product['images'])) {
                    $imageUrl = $product['images'][0]['src'];
                }
                
                // CSV satırı oluştur
                $csv->insertOne([
                    $product['name'],
                    $product['sku'] ?? '',
                    $categoryName,
                    $metaData['_active_ingredient'] ?? $acf['active_ingredient'] ?? '',
                    $metaData['_formulation'] ?? $acf['formulation'] ?? '',
                    $this->extractDosageText($product),
                    strip_tags($product['description'] ?? ''),
                    $metaData['_usage_instructions'] ?? $acf['usage_instructions'] ?? '',
                    $metaData['_warning_text'] ?? $acf['warning_text'] ?? '',
                    $metaData['_mixing_info'] ?? $acf['mixing_info'] ?? '',
                    $imageUrl,
                    $metaData['_brochure_pdf'] ?? $acf['brochure_pdf'] ?? '',
                    $metaData['_certificate_pdf'] ?? $acf['certificate_pdf'] ?? ''
                ]);
                
                $exported++;
            }
            
            $this->info("Sayfa {$page} işlendi. Toplam: {$exported} ürün");
            $page++;
            
        } while (count($products) > 0);
        
        $this->info("Export tamamlandı! Toplam {$exported} ürün {$output} dosyasına kaydedildi.");
        
        // WordPress Export Plugin önerisi
        $this->info("\nAlternatif: WordPress Admin > Tools > Export");
        $this->info("- 'All Export Pro' veya 'WP All Import/Export' eklentilerini kullanabilirsiniz");
        $this->info("- WooCommerce kullanıyorsanız: WooCommerce > Status > Tools > Export");
    }
    
    private function extractDosageText($product)
    {
        $dosage = $product['meta_data']['_dosage_table'] ?? 
                  $product['acf']['dosage_table'] ?? 
                  $product['meta_data']['_dosage'] ?? 
                  '';
        
        if (empty($dosage)) {
            return '';
        }
        
        // HTML tabloyu text'e dönüştür
        $dosage = strip_tags($dosage, '<br>');
        $dosage = str_replace('<br>', ', ', $dosage);
        $dosage = preg_replace('/\s+/', ' ', $dosage);
        
        return trim($dosage);
    }
}
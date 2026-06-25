<x-filament-panels::page>
    <form wire:submit.prevent="import">
        {{ $this->form }}

        <div class="mt-6 flex gap-3">
            <x-filament::button type="submit" icon="heroicon-m-arrow-down-tray">
                {{ $this->test_mode ? 'Test Et' : 'İçe Aktar' }}
            </x-filament::button>

            @if($this->import_method === 'csv')
                <x-filament::button type="button" wire:click="downloadTemplate" color="gray" icon="heroicon-m-document-arrow-down">
                    Örnek CSV İndir
                </x-filament::button>
            @endif
        </div>
    </form>

    <div class="mt-8 prose dark:prose-invert max-w-none">
        <h3>Kullanım Talimatları</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 not-prose">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold mb-3">1. REST API</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    WordPress sitenizin REST API'sini kullanarak veri aktarır.
                </p>
                <ul class="text-sm space-y-1 text-gray-600 dark:text-gray-400">
                    <li>• Application Password oluşturun</li>
                    <li>• WooCommerce API desteği</li>
                    <li>• Otomatik kategori eşleme</li>
                </ul>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold mb-3">2. CSV Import</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    CSV dosyası ile toplu ürün aktarımı.
                </p>
                <ul class="text-sm space-y-1 text-gray-600 dark:text-gray-400">
                    <li>• Örnek şablonu indirin</li>
                    <li>• Excel'de düzenleyin</li>
                    <li>• UTF-8 formatında kaydedin</li>
                </ul>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold mb-3">3. SQL Bağlantı</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Doğrudan veritabanı bağlantısı ile aktarım.
                </p>
                <ul class="text-sm space-y-1 text-gray-600 dark:text-gray-400">
                    <li>• En hızlı yöntem</li>
                    <li>• Uzak DB desteği</li>
                    <li>• Tüm meta veriler korunur</li>
                </ul>
            </div>
        </div>

        <h3>WordPress Eklenti Önerileri</h3>
        <ul>
            <li><strong>WP All Export Pro:</strong> Profesyonel export eklentisi</li>
            <li><strong>WooCommerce CSV Export:</strong> WooCommerce için özel</li>
            <li><strong>Advanced Custom Fields:</strong> ACF verilerini de aktarır</li>
        </ul>

        <h3>Komut Satırı Kullanımı</h3>
        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg overflow-x-auto"><code># API ile import
php artisan import:wordpress api --url=https://site.com --test

# CSV ile import  
php artisan import:wordpress csv --file=/path/to/file.csv

# WordPress'ten export
php artisan export:wordpress --url=https://site.com</code></pre>
    </div>
</x-filament-panels::page>
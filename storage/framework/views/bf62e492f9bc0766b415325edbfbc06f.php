<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <form wire:submit.prevent="import">
        <?php echo e($this->form); ?>


        <div class="mt-6 flex gap-3">
            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','icon' => 'heroicon-m-arrow-down-tray']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'heroicon-m-arrow-down-tray']); ?>
                <?php echo e($this->test_mode ? 'Test Et' : 'İçe Aktar'); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->import_method === 'csv'): ?>
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'button','wire:click' => 'downloadTemplate','color' => 'gray','icon' => 'heroicon-m-document-arrow-down']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'downloadTemplate','color' => 'gray','icon' => 'heroicon-m-document-arrow-down']); ?>
                    Örnek CSV İndir
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/pages/wordpress-import.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Ürün Kataloğu'); ?>
<?php $__env->startSection('header', 'Ürün Kataloğu'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filtreler -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('dealer.products')); ?>" class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Arama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('Ürün Ara')); ?></label>
                    <input type="text" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>"
                           placeholder="<?php echo e(__('Ürün adı veya aktif madde...')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('Kategori')); ?></label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <option value=""><?php echo e(__('Tüm Kategoriler')); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
                
                <!-- Sıralama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('Sıralama')); ?></label>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>><?php echo e(__('İsim (A-Z)')); ?></option>
                        <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>><?php echo e(__('İsim (Z-A)')); ?></option>
                        <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>><?php echo e(__('En Yeni')); ?></option>
                    </select>
                </div>
                
                <!-- Butonlar -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                        <?php echo e(__('Filtrele')); ?>

                    </button>
                    <a href="<?php echo e(route('dealer.products')); ?>" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-center">
                        <?php echo e(__('Temizle')); ?>

                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Ürünler -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
        <img src="<?php echo e(Storage::url($product->image)); ?>" 
             alt="<?php echo e($product->name); ?>"
             class="w-full h-48 object-cover rounded-t-lg">
        <?php else: ?>
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
            <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <div class="p-4">
            <div class="mb-2">
                <span class="text-xs bg-cyan-100 text-cyan-800 px-2 py-1 rounded">
                    <?php echo e($product->category->name); ?>

                </span>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                <?php echo e($product->name); ?>

            </h3>
            
            <p class="text-sm text-gray-600 mb-1">
                <strong><?php echo e(__('Aktif Madde')); ?>:</strong> <?php echo e($product->active_ingredient); ?>

            </p>

            <p class="text-sm text-gray-600 mb-4">
                <strong><?php echo e(__('Formülasyon')); ?>:</strong> <?php echo e($product->formulation); ?>

            </p>
            
            <div class="flex gap-2">
                <a href="<?php echo e(route('dealer.products.show', $product)); ?>"
                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm">
                    <?php echo e(__('Detay')); ?>

                </a>
                <a href="<?php echo e(route('dealer.products.quote', $product)); ?>"
                   class="flex-1 px-3 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors text-center text-sm">
                    <?php echo e(__('Teklif Al')); ?>

                </a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full">
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-lg font-medium text-gray-900"><?php echo e(__('Ürün bulunamadı.')); ?></p>
            <p class="mt-2 text-sm text-gray-500"><?php echo e(__('Arama kriterlerinizi değiştirerek tekrar deneyin.')); ?></p>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- Sayfalama -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
<div class="mt-8">
    <?php echo e($products->withQueryString()->links()); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dealer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/products/index.blade.php ENDPATH**/ ?>
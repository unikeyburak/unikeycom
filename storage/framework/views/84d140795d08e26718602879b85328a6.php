<?php $__env->startSection('title', 'Teklif Taleplerim'); ?>
<?php $__env->startSection('header', 'Teklif Taleplerim'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow">
    <!-- Filtreler -->
    <div class="p-6 border-b">
        <form method="GET" action="<?php echo e(route('dealer.quotes')); ?>" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('Durum')); ?></label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    <option value=""><?php echo e(__('Tümü')); ?></option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Beklemede')); ?></option>
                    <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>><?php echo e(__('İşleniyor')); ?></option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>><?php echo e(__('Tamamlandı')); ?></option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>><?php echo e(__('İptal')); ?></option>
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('Tarih Aralığı')); ?></label>
                <div class="flex gap-2">
                    <input type="date" 
                           name="start_date" 
                           value="<?php echo e(request('start_date')); ?>"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    <input type="date" 
                           name="end_date" 
                           value="<?php echo e(request('end_date')); ?>"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                </div>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                    <?php echo e(__('Filtrele')); ?>

                </button>
                <a href="<?php echo e(route('dealer.quotes')); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <?php echo e(__('Temizle')); ?>

                </a>
            </div>
        </form>
    </div>
    
    <!-- Tablo -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        #ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e(__('Ürün')); ?>

                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e(__('Miktar')); ?>

                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e(__('Durum')); ?>

                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e(__('Tarih')); ?>

                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e(__('İşlem')); ?>

                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        #<?php echo e($quote->id); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quote->product->image): ?>
                            <img src="<?php echo e(Storage::url($quote->product->image)); ?>" 
                                 alt="<?php echo e($quote->product->name); ?>"
                                 class="w-10 h-10 rounded object-cover mr-3">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($quote->product->name); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($quote->product->active_ingredient); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($quote->quantity); ?> <?php echo e($quote->unit); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-cyan-100 text-cyan-800',
                                'cancelled' => 'bg-red-100 text-red-800'
                            ];
                            $statusTexts = [
                                'pending' => __('Beklemede'),
                                'processing' => __('İşleniyor'),
                                'completed' => __('Tamamlandı'),
                                'cancelled' => __('İptal')
                            ];
                        ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusClasses[$quote->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e($statusTexts[$quote->status] ?? __('Bilinmiyor')); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>
                            <p><?php echo e($quote->created_at->format('d.m.Y')); ?></p>
                            <p class="text-xs"><?php echo e($quote->created_at->format('H:i')); ?></p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo e(route('dealer.quotes.show', $quote)); ?>" 
                           class="text-cyan-600 hover:text-cyan-900">
                            <?php echo e(__('Detay')); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium"><?php echo e(__('Henüz teklif talebiniz bulunmuyor')); ?></p>
                        <p class="mt-2 text-sm"><?php echo e(__('Ürün kataloğundan teklif talebi oluşturabilirsiniz.')); ?></p>
                        <a href="<?php echo e(route('dealer.products')); ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                            <?php echo e(__('Ürün Kataloğuna Git')); ?>

                        </a>
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Sayfalama -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quotes->hasPages()): ?>
    <div class="px-6 py-4 border-t">
        <?php echo e($quotes->withQueryString()->links()); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dealer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/quotes/index.blade.php ENDPATH**/ ?>
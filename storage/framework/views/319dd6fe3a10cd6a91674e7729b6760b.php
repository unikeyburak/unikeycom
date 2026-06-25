<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('header', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Bekleyen Teklifler -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600"><?php echo e(__('Bekleyen Teklifler')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending_quotes'] ?? 0); ?></p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Toplam Teklifler -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600"><?php echo e(__('Toplam Teklifler')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_quotes'] ?? 0); ?></p>
            </div>
            <div class="bg-cyan-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Kredi Limiti -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dealer->credit_limit): ?>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600"><?php echo e(__('Kullanılabilir Kredi')); ?></p>
                <p class="text-2xl font-bold text-gray-900">₺<?php echo e(number_format($dealer->available_credit ?? 0, 2)); ?></p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(__('Limit')); ?>: ₺<?php echo e(number_format($dealer->credit_limit, 2)); ?></p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <!-- Hesap Durumu -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600"><?php echo e(__('Hesap Durumu')); ?></p>
                <p class="text-lg font-semibold <?php echo e($dealer->is_verified ? 'text-cyan-600' : 'text-yellow-600'); ?>">
                    <?php echo e($dealer->is_verified ? __('Onaylı') : __('Onay Bekliyor')); ?>

                </p>
            </div>
            <div class="<?php echo e($dealer->is_verified ? 'bg-cyan-100' : 'bg-yellow-100'); ?> p-3 rounded-full">
                <svg class="w-6 h-6 <?php echo e($dealer->is_verified ? 'text-cyan-600' : 'text-yellow-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Son Teklifler -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentQuotes && $recentQuotes->count() > 0): ?>
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold"><?php echo e(__('Son Teklif Taleplerim')); ?></h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3 px-4"><?php echo e(__('Ürün')); ?></th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3 px-4"><?php echo e(__('Miktar')); ?></th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3 px-4"><?php echo e(__('Durum')); ?></th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3 px-4"><?php echo e(__('Tarih')); ?></th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3 px-4"><?php echo e(__('İşlem')); ?></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-4 px-4">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($quote->product->name); ?></p>
                        </td>
                        <td class="py-4 px-4">
                            <p class="text-sm text-gray-900"><?php echo e($quote->quantity); ?> <?php echo e($quote->unit); ?></p>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($quote->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($quote->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                   ($quote->status == 'completed' ? 'bg-cyan-100 text-cyan-800' : 'bg-red-100 text-red-800'))); ?>">
                                <?php echo e($quote->status == 'pending' ? __('Beklemede') :
                                   ($quote->status == 'processing' ? __('İşleniyor') :
                                   ($quote->status == 'completed' ? __('Tamamlandı') : __('İptal')))); ?>

                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <p class="text-sm text-gray-500"><?php echo e($quote->created_at->format('d.m.Y H:i')); ?></p>
                        </td>
                        <td class="py-4 px-4">
                            <a href="<?php echo e(route('dealer.quotes.show', $quote)); ?>" 
                               class="text-cyan-600 hover:text-cyan-900 text-sm font-medium">
                                <?php echo e(__('Detay')); ?>

                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="<?php echo e(route('dealer.quotes')); ?>" class="text-cyan-600 hover:text-cyan-700 text-sm font-medium">
                <?php echo e(__('Tüm Teklifleri Görüntüle')); ?> →
            </a>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- Hoşgeldin Mesajı -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$dealer->is_verified): ?>
<div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800"><?php echo e(__('Hesabınız Onay Bekliyor')); ?></h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p><?php echo e(__('Bayi başvurunuz incelenmektedir. Onaylandığında e-posta ile bilgilendirileceksiniz.')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="mt-8 bg-cyan-50 border border-cyan-200 rounded-lg p-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-cyan-800"><?php echo e(__('Hoş Geldiniz!')); ?></h3>
            <div class="mt-2 text-sm text-cyan-700">
                <p><?php echo e($dealer->company_name); ?> - <?php echo e(__('Bayi panelinize hoş geldiniz. Ürün kataloğunu inceleyebilir ve teklif talebinde bulunabilirsiniz.')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dealer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/dashboard.blade.php ENDPATH**/ ?>
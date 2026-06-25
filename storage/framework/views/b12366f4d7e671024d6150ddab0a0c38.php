<?php $__env->startSection('title', 'Teklif Detayı #'.$quote->id); ?>
<?php $__env->startSection('header', 'Teklif Detayı'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow">
    <!-- Üst Bilgi -->
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">#<?php echo e($quote->id); ?> - <?php echo e($quote->product->name); ?></h3>
            <p class="text-sm text-gray-500"><?php echo e($quote->created_at->format('d.m.Y H:i')); ?></p>
        </div>
        <div>
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
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?php echo e($statusClasses[$quote->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                <?php echo e($statusTexts[$quote->status] ?? __('Bilinmiyor')); ?>

            </span>
        </div>
    </div>
    
    <!-- İçerik -->
    <div class="p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Sol Kolon -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-4"><?php echo e(__('Ürün Bilgileri')); ?></h4>
                
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quote->product->image): ?>
                    <div>
                        <img src="<?php echo e(Storage::url($quote->product->image)); ?>" 
                             alt="<?php echo e($quote->product->name); ?>"
                             class="w-32 h-32 rounded-lg object-cover">
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Ürün Adı')); ?></p>
                        <p class="font-medium"><?php echo e($quote->product->name); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Aktif Madde')); ?></p>
                        <p class="font-medium"><?php echo e($quote->product->active_ingredient); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Formülasyon')); ?></p>
                        <p class="font-medium"><?php echo e($quote->product->formulation); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Sağ Kolon -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-4"><?php echo e(__('Teklif Detayları')); ?></h4>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Talep Edilen Miktar')); ?></p>
                        <p class="font-medium text-lg"><?php echo e($quote->quantity); ?> <?php echo e($quote->unit); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Teslimat Şehri')); ?></p>
                        <p class="font-medium"><?php echo e($quote->delivery_city); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('İstenen Teslimat Tarihi')); ?></p>
                        <p class="font-medium">
                            <?php echo e($quote->delivery_date ? \Carbon\Carbon::parse($quote->delivery_date)->format('d.m.Y') : __('Belirtilmemiş')); ?>

                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Kullanım Amacı')); ?></p>
                        <p class="font-medium"><?php echo e($quote->usage_purpose ?: __('Belirtilmemiş')); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600"><?php echo e(__('Ödeme Şekli')); ?></p>
                        <p class="font-medium"><?php echo e($quote->payment_method ?: __('Belirtilmemiş')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quote->notes): ?>
        <div class="mt-6 pt-6 border-t">
            <h4 class="font-semibold text-gray-900 mb-2"><?php echo e(__('Ek Notlar')); ?></h4>
            <p class="text-gray-700"><?php echo e($quote->notes); ?></p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <!-- Durum Geçmişi -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quote->status_history && count($quote->status_history) > 0): ?>
    <div class="px-6 py-4 border-t">
        <h4 class="font-semibold text-gray-900 mb-4"><?php echo e(__('Durum Geçmişi')); ?></h4>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $quote->status_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">
                        <?php echo e($statusTexts[$history['status']] ?? $history['status']); ?>

                    </p>
                    <p class="text-xs text-gray-500">
                        <?php echo e(\Carbon\Carbon::parse($history['date'])->format('d.m.Y H:i')); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($history['note'])): ?>
                        - <?php echo e($history['note']); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <!-- Alt Butonlar -->
    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
        <a href="<?php echo e(route('dealer.quotes')); ?>" 
           class="text-gray-600 hover:text-gray-900">
            ← <?php echo e(__('Geri Dön')); ?>

        </a>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quote->status === 'pending'): ?>
        <form method="POST" action="<?php echo e(route('dealer.quotes.cancel', $quote)); ?>" 
              onsubmit="return confirm('<?php echo e(__('Bu teklif talebini iptal etmek istediğinizden emin misiniz?')); ?>')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <?php echo e(__('İptal Et')); ?>

            </button>
        </form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dealer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/quotes/show.blade.php ENDPATH**/ ?>
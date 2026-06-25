<?php $__env->startSection('title', ($catalog->translate('title') ?? $catalog->title) . ' - ' . ($settings['site_name'] ?? config('app.name'))); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'title'    => $catalog->translate('title') ?? $catalog->title,
    'subtitle' => $catalog->description
        ? ($catalog->translate('description') ?? $catalog->description)
        : null,
    'image'    => 'https://images.unsplash.com/photo-1481349518771-20055b2a7b24?auto=format&fit=crop&w=2000&q=80',
    'ctaText'  => __('PDF İndir'),
    'ctaUrl'   => route('catalogs.download', $catalog->slug),
    'size'     => 'default',
    'overlay'  => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catalog->file_size): ?>
                        <span><?php echo e($catalog->file_size_formatted); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catalog->download_count > 0): ?>
                        <span><?php echo e(number_format($catalog->download_count)); ?> <?php echo e(__('indirme')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <a href="<?php echo e(route('catalogs.download', $catalog->slug)); ?>"
               class="flex-shrink-0 inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-6 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <?php echo e(__('PDF İndir')); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catalog->file_size): ?>
                    <span class="text-cyan-200 text-xs">(<?php echo e($catalog->file_size_formatted); ?>)</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>
    </div>
</section>


<section class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catalog->file_path): ?>
        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="height: 85vh;">
            <iframe
                src="<?php echo e(route('catalogs.view', $catalog->slug)); ?>"
                class="w-full h-full border-0"
                title="<?php echo e($catalog->translate('title') ?? $catalog->title); ?>">
            </iframe>
        </div>
        <p class="text-center text-sm text-gray-400 mt-3">
            <?php echo e(__('PDF görüntülenmiyor mu?')); ?>

            <a href="<?php echo e(route('catalogs.download', $catalog->slug)); ?>" class="text-cyan-600 hover:underline">
                <?php echo e(__('Buradan indirin')); ?>

            </a>
        </p>
        <?php else: ?>
        
        <div class="bg-white rounded-2xl shadow-sm flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-gray-500 font-medium mb-1"><?php echo e(__('PDF henüz yüklenmedi')); ?></h3>
            <p class="text-gray-400 text-sm"><?php echo e(__('Lütfen daha sonra tekrar deneyin.')); ?></p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="flex items-center justify-between mt-4">
            <a href="<?php echo e(lroute('catalogs.index')); ?>"
               class="inline-flex items-center gap-2 text-gray-500 hover:text-cyan-600 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <?php echo e(__('Tüm Kataloglar')); ?>

            </a>

            <a href="<?php echo e(route('catalogs.download', $catalog->slug)); ?>"
               class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <?php echo e(__('PDF İndir')); ?>

            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/catalogs/show.blade.php ENDPATH**/ ?>
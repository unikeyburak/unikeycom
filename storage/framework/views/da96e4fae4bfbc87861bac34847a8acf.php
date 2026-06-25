<?php $__env->startSection('title', $plant->name . ' Besleme Programları'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $plantImageUrl = null;
    if (!empty($plant->image)) {
        $plantImageUrl = str_starts_with($plant->image, 'http')
            ? $plant->image
            : \Illuminate\Support\Facades\Storage::url($plant->image);
    }
?>
<?php echo $__env->make('partials.page-header', [
    'title'    => $plant->name . ' ' . __('Besleme Programları'),
    'subtitle' => $plant->scientific_name ?: ($plant->description ? strip_tags($plant->description) : __('Uzman tarafından hazırlanmış besleme programları ile verimi artırın.')),
    'image'    => $plantImageUrl ?? 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="bg-white border-b border-gray-100 py-6">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center gap-10">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600"><?php echo e($programs->count()); ?></div>
                <div class="text-sm text-gray-600"><?php echo e(__('Program')); ?></div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600">
                    <?php echo e($programs->sum(function($p) { return $p->stages->count(); })); ?>

                </div>
                <div class="text-sm text-gray-600"><?php echo e(__('Aşama')); ?></div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyan-600">
                    <?php echo e($programs->sum(function($p) { return $p->all_products->count(); })); ?>

                </div>
                <div class="text-sm text-gray-600"><?php echo e(__('Ürün')); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- Programlar -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->count() > 0): ?>
                <h2 class="text-3xl font-bold text-gray-800 mb-8"><?php echo e(__('Mevcut Programlar')); ?></h2>
                
                <div class="space-y-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="md:flex">
                            <!-- Sol: Program Bilgileri -->
                            <div class="md:w-2/3 p-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($program->title); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->is_featured): ?>
                                        <span class="bg-cyan-100 text-cyan-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            <?php echo e(__('Önerilen')); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->description): ?>
                                <p class="text-gray-600 mb-6"><?php echo e($program->description); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <!-- Özellikler -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->season): ?>
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-calendar-alt text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500"><?php echo e(__('Mevsim')); ?></div>
                                        <div class="font-semibold"><?php echo e($program->season); ?></div>
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->growth_stage): ?>
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-chart-line text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500"><?php echo e(__('Dönem')); ?></div>
                                        <div class="font-semibold"><?php echo e($program->growth_stage); ?></div>
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-layer-group text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500"><?php echo e(__('Aşama')); ?></div>
                                        <div class="font-semibold"><?php echo e($program->stages->count()); ?></div>
                                    </div>
                                    
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <i class="fas fa-box text-2xl text-cyan-600 mb-2"></i>
                                        <div class="text-xs text-gray-500"><?php echo e(__('Ürün')); ?></div>
                                        <div class="font-semibold"><?php echo e($program->all_products->count()); ?></div>
                                    </div>
                                </div>
                                
                                <!-- Aşamalar -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->stages->count() > 0): ?>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-800 mb-3"><?php echo e(__('Uygulama Aşamaları')); ?></h4>
                                    <div class="flex flex-wrap gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $program->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center gap-2 bg-cyan-50 px-4 py-2 rounded-full">
                                            <div class="w-6 h-6 bg-cyan-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                                <?php echo e($loop->iteration); ?>

                                            </div>
                                            <span class="text-sm font-medium text-gray-700"><?php echo e($stage->title); ?></span>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <!-- Buton -->
                                <a href="<?php echo e($program->url); ?>" 
                                   class="inline-flex items-center gap-2 bg-cyan-600 text-white px-6 py-3 rounded-lg hover:bg-cyan-700 transition font-semibold">
                                    <i class="fas fa-arrow-right"></i>
                                    <?php echo e(__('Programı İncele')); ?>

                                </a>
                            </div>
                            
                            <!-- Sağ: Faydalar -->
                            <div class="md:w-1/3 bg-gradient-to-br from-cyan-50 to-cyan-100 p-8">
                                <h4 class="font-semibold text-gray-800 mb-4"><?php echo e(__('Program Faydaları')); ?></h4>
                                <div class="space-y-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $program->benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-600 rounded-full flex items-center justify-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($benefit->icon): ?>
                                                <i class="<?php echo e($benefit->icon); ?> text-white text-xs"></i>
                                            <?php else: ?>
                                                <i class="fas fa-check text-white text-xs"></i>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800"><?php echo e($benefit->title); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($benefit->description): ?>
                                            <div class="text-sm text-gray-600"><?php echo e($benefit->description); ?></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-gray-600 text-sm"><?php echo e(__('Program faydaları yakında eklenecek.')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-seedling text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500"><?php echo e(__('Bu bitki için henüz program eklenmemiş.')); ?></p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
        </div>
    </div>
</section>

<!-- İlgili Diğer Bitkiler -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedPlants->count() > 0): ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center"><?php echo e(__('Diğer Bitkiler')); ?></h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedPlants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPlant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('nutrition-programs.plant', $relatedPlant->slug)); ?>" 
               class="group text-center">
                <div class="relative mb-4 overflow-hidden rounded-xl bg-white aspect-square">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedPlant->image): ?>
                        <?php if (isset($component)) { $__componentOriginalecfc361c64744489ff7ee842d5dc46c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-image','data' => ['path' => $relatedPlant->image,'alt' => $relatedPlant->name,'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-300','sizes' => '120px','loading' => 'lazy','decoding' => 'async']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['path' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relatedPlant->image),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relatedPlant->name),'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-300','sizes' => '120px','loading' => 'lazy','decoding' => 'async']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalecfc361c64744489ff7ee842d5dc46c3)): ?>
<?php $attributes = $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3; ?>
<?php unset($__attributesOriginalecfc361c64744489ff7ee842d5dc46c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalecfc361c64744489ff7ee842d5dc46c3)): ?>
<?php $component = $__componentOriginalecfc361c64744489ff7ee842d5dc46c3; ?>
<?php unset($__componentOriginalecfc361c64744489ff7ee842d5dc46c3); ?>
<?php endif; ?>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-50 to-cyan-100">
                            <i class="fas fa-seedling text-4xl text-cyan-600"></i>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <h3 class="font-semibold text-gray-800 group-hover:text-cyan-600 transition-colors">
                    <?php echo e($relatedPlant->name); ?>

                </h3>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/nutrition-programs/plant.blade.php ENDPATH**/ ?>
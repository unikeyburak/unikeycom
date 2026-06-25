<?php
    $plants = \Illuminate\Support\Facades\Cache::remember('homepage_plant_programs_grid', 3600, function () {
        return \App\Models\Plant::active()
            ->showOnHomepage()
            ->withCount('nutritionPrograms')
            ->having('nutrition_programs_count', '>', 0)
            ->limit(12)
            ->get();
    });
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plants->count() > 0): ?>
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <!-- Başlık -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                <?php echo e(__('Bitki Besleme Programları')); ?>

            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('Tüm bitkiler için özel hazırlanmış besleme programlarımızı keşfedin')); ?>

            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('nutrition-programs.plant', $plant->slug)); ?>" 
               class="group text-center">
                <!-- Görsel Container -->
                <div class="relative mb-4 overflow-hidden rounded-xl bg-gradient-to-br from-cyan-50 to-cyan-100 aspect-square">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plant->image): ?>
                        <?php if (isset($component)) { $__componentOriginalecfc361c64744489ff7ee842d5dc46c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-image','data' => ['path' => $plant->image,'alt' => $plant->name,'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-300','sizes' => '120px','loading' => 'lazy','decoding' => 'async']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['path' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($plant->image),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($plant->name),'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-300','sizes' => '120px','loading' => 'lazy','decoding' => 'async']); ?>
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
                        <!-- Varsayılan İkon -->
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-seedling text-6xl text-cyan-600 group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Program Sayısı Badge -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plant->nutrition_programs_count > 0): ?>
                    <div class="absolute top-2 right-2 bg-cyan-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        <?php echo e($plant->nutrition_programs_count); ?> <?php echo e(__('Program')); ?>

                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Bitki Adı -->
                <h3 class="font-semibold text-gray-800 group-hover:text-cyan-600 transition-colors">
                    <?php echo e($plant->name); ?>

                </h3>
                
                <!-- Bilimsel Ad -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plant->scientific_name): ?>
                <p class="text-xs text-gray-500 italic mt-1">
                    <?php echo e($plant->scientific_name); ?>

                </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Tüm Bitkiler Butonu -->
        <div class="text-center mt-12">
            <a href="<?php echo e(lroute('nutrition-programs.index')); ?>" 
               class="inline-flex items-center gap-2 bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition font-semibold shadow-lg hover:shadow-xl">
                <i class="fas fa-th"></i>
                <?php echo e(__('Tüm Bitkileri Gör')); ?>

            </a>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/resources/views/components/plant-programs-grid.blade.php ENDPATH**/ ?>
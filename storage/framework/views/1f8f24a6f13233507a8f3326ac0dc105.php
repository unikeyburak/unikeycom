<?php
    $featuredPrograms = \App\Models\NutritionProgram::with(['plant', 'benefits', 'stages.products'])
        ->active()
        ->featured()
        ->limit(6)
        ->get();
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredPrograms->count() > 0): ?>
<section class="page-container programs-slider-container py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Başlık -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                <?php echo e(__('Bitki Besleme Programları')); ?>

            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('Bitkilerinizin tüm gelişim dönemlerinde yanınızdayız. Size özel hazırlanmış besleme programlarımızla maksimum verim elde edin.')); ?>

            </p>
        </div>

        <!-- Slider Container -->
        <div class="relative" x-data="programsSlider()">
            <!-- Slider Wrapper -->
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" 
                     :style="`transform: translateX(-${currentSlide * 100}%)`">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $featuredPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-full flex-shrink-0 px-4">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="lg:flex">
                                <!-- Sol Taraf - Program Bilgileri -->
                                <div class="lg:w-1/2 p-8 lg:p-12">
                                    <!-- Bitki Adı ve İkonu -->
                                    <div class="flex items-center gap-4 mb-6">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->plant->image): ?>
                                            <?php if (isset($component)) { $__componentOriginalecfc361c64744489ff7ee842d5dc46c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-image','data' => ['path' => $program->plant->image,'alt' => $program->plant->name,'class' => 'w-16 h-16 object-contain','sizes' => '64px','loading' => 'lazy','decoding' => 'async']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['path' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($program->plant->image),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($program->plant->name),'class' => 'w-16 h-16 object-contain','sizes' => '64px','loading' => 'lazy','decoding' => 'async']); ?>
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
                                            <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-seedling text-cyan-600 text-2xl"></i>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800"><?php echo e($program->plant->name); ?></h3>
                                            <p class="text-gray-500"><?php echo e($program->title); ?></p>
                                        </div>
                                    </div>

                                    <!-- Program Açıklaması -->
                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                        <?php echo e(Str::limit($program->description, 200)); ?>

                                    </p>

                                    <!-- Özellikler -->
                                    <div class="grid grid-cols-2 gap-4 mb-8">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->season): ?>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-calendar-alt text-cyan-600"></i>
                                            <div>
                                                <p class="text-xs text-gray-500"><?php echo e(__('Mevsim')); ?></p>
                                                <p class="font-semibold"><?php echo e($program->season); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->growth_stage): ?>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-chart-line text-cyan-600"></i>
                                            <div>
                                                <p class="text-xs text-gray-500"><?php echo e(__('Dönem')); ?></p>
                                                <p class="font-semibold"><?php echo e($program->growth_stage); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-box text-cyan-600"></i>
                                            <div>
                                                <p class="text-xs text-gray-500"><?php echo e(__('Ürün Sayısı')); ?></p>
                                                <p class="font-semibold"><?php echo e($program->total_products); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-layer-group text-cyan-600"></i>
                                            <div>
                                                <p class="text-xs text-gray-500"><?php echo e(__('Aşama')); ?></p>
                                                <p class="font-semibold"><?php echo e($program->stages->count()); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Butonlar -->
                                    <div class="flex gap-4">
                                        <a href="<?php echo e($program->url); ?>" 
                                           class="flex-1 bg-cyan-600 text-white text-center py-3 px-6 rounded-lg hover:bg-cyan-700 transition font-semibold">
                                            <?php echo e(__('Programı İncele')); ?>

                                        </a>
                                        <button @click="showProducts(<?php echo e($program->id); ?>)" 
                                                class="flex-1 border-2 border-cyan-600 text-cyan-600 text-center py-3 px-6 rounded-lg hover:bg-cyan-50 transition font-semibold">
                                            <?php echo e(__('Ürünleri Gör')); ?>

                                        </button>
                                    </div>
                                </div>

                                <!-- Sağ Taraf - Faydalar -->
                                <div class="lg:w-1/2 bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 lg:p-12">
                                    <h4 class="text-xl font-bold text-gray-800 mb-6">
                                        <?php echo e(__('Program Faydaları')); ?>

                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $program->benefits->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center mt-1">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($benefit->icon): ?>
                                                    <i class="<?php echo e($benefit->icon); ?> text-cyan-600 text-sm"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-check text-cyan-600"></i>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div>
                                                <h5 class="font-semibold text-gray-800"><?php echo e($benefit->title); ?></h5>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($benefit->description): ?>
                                                    <p class="text-sm text-gray-600"><?php echo e($benefit->description); ?></p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <!-- Varsayılan faydalar -->
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center mt-1">
                                                <i class="fas fa-chart-line text-cyan-600"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-semibold text-gray-800"><?php echo e(__('Verim Artışı')); ?></h5>
                                                <p class="text-sm text-gray-600"><?php echo e(__('Optimize edilmiş besin programı ile maksimum verim')); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center mt-1">
                                                <i class="fas fa-leaf text-cyan-600"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-semibold text-gray-800"><?php echo e(__('Sağlıklı Gelişim')); ?></h5>
                                                <p class="text-sm text-gray-600"><?php echo e(__('Bitkinin tüm ihtiyaçlarını karşılayan dengeli formül')); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center mt-1">
                                                <i class="fas fa-shield-alt text-cyan-600"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-semibold text-gray-800"><?php echo e(__('Hastalık Direnci')); ?></h5>
                                                <p class="text-sm text-gray-600"><?php echo e(__('Güçlü bitki yapısı ile artırılmış doğal direnç')); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <!-- Program Aşamaları Mini -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->stages->count() > 0): ?>
                                    <div class="mt-8">
                                        <h5 class="font-semibold text-gray-800 mb-3"><?php echo e(__('Uygulama Aşamaları')); ?></h5>
                                        <div class="flex gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $program->stages->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-sm font-bold text-cyan-600">
                                                    <?php echo e($index + 1); ?>

                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?>
                                                <div class="w-8 h-0.5 bg-cyan-300 mx-1"></div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                </div>
            </div>

            <!-- Slider Controls -->
            <?php if($featuredPrograms->count() > 1): ?>
            <button @click="prevSlide" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition">
                <i class="fas fa-chevron-left text-gray-600"></i>
            </button>
            <button @click="nextSlide" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition">
                <i class="fas fa-chevron-right text-gray-600"></i>
            </button>

            <!-- Dots -->
            <div class="flex justify-center gap-2 mt-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $featuredPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="currentSlide = <?php echo e($index); ?>" 
                        :class="currentSlide === <?php echo e($index); ?> ? 'bg-cyan-600' : 'bg-gray-300'"
                        class="w-3 h-3 rounded-full transition-colors"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Tüm Programlar Butonu -->
        <div class="text-center mt-12">
            <a href="<?php echo e(lroute('nutrition-programs.index')); ?>" 
               class="inline-flex items-center gap-2 bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition font-semibold">
                <i class="fas fa-list"></i>
                <?php echo e(__('Tüm Programları Gör')); ?>

            </a>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
function programsSlider() {
    return {
        currentSlide: 0,
        totalSlides: <?php echo e($featuredPrograms->count()); ?>,
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        
        showProducts(programId) {
            // Program ürünlerini modal veya yeni sayfada göster
            window.location.href = `/bitki-besleme/program/${programId}/urunler`;
        },
        
        init() {
            // Otomatik geçiş
            setInterval(() => {
                this.nextSlide();
            }, 8000);
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/resources/views/components/nutrition-programs-slider.blade.php ENDPATH**/ ?>
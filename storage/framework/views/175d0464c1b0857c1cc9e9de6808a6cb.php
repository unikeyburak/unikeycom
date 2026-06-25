<?php
    // HomeController'dan gelen $plants varsa onu kullan, yoksa cache'den al
    $plants = $plants ?? \Illuminate\Support\Facades\Cache::remember('homepage_plants', 3600, function () {
        return \App\Models\Plant::active()->orderBy('name')->limit(20)->get(['id', 'name', 'slug', 'image', 'scientific_name']);
    });
?>

<section class="py-16 bg-gradient-to-br from-cyan-50 to-cyan-100">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    <?php echo e(__('Bitki Besleme Programlarımız')); ?>

                </h2>
                <p class="text-lg text-gray-600">
                    <?php echo e(__('Bitkileriniz için özel olarak hazırlanmış beslenme programlarını keşfedin')); ?>

                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl p-8" x-data="plantSearch()">
                <form @submit.prevent="search">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Bitki Seçimi -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Bitki Türü')); ?>

                            </label>
                            <select 
                                x-model="selectedPlant" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                            >
                                <option value=""><?php echo e(__('Bitki seçiniz...')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($plant->slug); ?>"><?php echo e($plant->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Mevsim Seçimi -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Mevsim')); ?>

                            </label>
                            <select 
                                x-model="selectedSeason" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                            >
                                <option value=""><?php echo e(__('Tüm mevsimler')); ?></option>
                                <option value="spring"><?php echo e(__('İlkbahar')); ?></option>
                                <option value="summer"><?php echo e(__('Yaz')); ?></option>
                                <option value="autumn"><?php echo e(__('Sonbahar')); ?></option>
                                <option value="winter"><?php echo e(__('Kış')); ?></option>
                            </select>
                        </div>
                        
                        <!-- Arama Butonu -->
                        <div class="flex items-end">
                            <button 
                                type="submit" 
                                class="px-8 py-3 bg-cyan-600 text-white font-semibold rounded-lg hover:bg-cyan-700 transition-colors shadow-md hover:shadow-lg flex items-center gap-2"
                                :disabled="!selectedPlant"
                                :class="{ 'opacity-50 cursor-not-allowed': !selectedPlant }"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <?php echo e(__('Ara')); ?>

                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Popüler Aramalar -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3"><?php echo e(__('Popüler Bitkiler')); ?></h4>
                    <div class="flex flex-wrap gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plants->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button 
                                @click="quickSearch('<?php echo e($plant->slug); ?>')"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-cyan-100 hover:text-cyan-700 transition text-sm font-medium"
                            >
                                <?php echo e($plant->name); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- İstatistikler -->
            <?php
                $stats = \Illuminate\Support\Facades\Cache::remember('homepage_stats', 3600, function () {
                    return [
                        'plants' => \App\Models\Plant::active()->count(),
                        'programs' => \App\Models\NutritionProgram::active()->count(),
                        'products' => \App\Models\Product::active()->count(),
                    ];
                });
            ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <div class="text-center">
                    <div class="text-4xl font-bold text-cyan-600 mb-2"><?php echo e($stats['plants']); ?>+</div>
                    <div class="text-gray-600"><?php echo e(__('Bitki Çeşidi')); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-cyan-600 mb-2"><?php echo e($stats['programs']); ?>+</div>
                    <div class="text-gray-600"><?php echo e(__('Besleme Programı')); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-cyan-600 mb-2"><?php echo e($stats['products']); ?>+</div>
                    <div class="text-gray-600"><?php echo e(__('Ürün')); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
function plantSearch() {
    return {
        selectedPlant: '',
        selectedSeason: '',
        
        search() {
            if (!this.selectedPlant) return;
            
            let url = `/bitki-besleme/${this.selectedPlant}`;
            if (this.selectedSeason) {
                url += `?mevsim=${this.selectedSeason}`;
            }
            
            window.location.href = url;
        },
        
        quickSearch(plantSlug) {
            this.selectedPlant = plantSlug;
            this.search();
        }
    }
}
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/html/resources/views/components/plant-search-widget.blade.php ENDPATH**/ ?>
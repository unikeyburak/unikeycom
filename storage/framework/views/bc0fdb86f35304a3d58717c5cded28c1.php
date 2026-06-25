<?php $__env->startSection('title', ($currentCategory ? $currentCategory->translate('name') : __('Ürünler')) . ' - ' . ($settings['site_name'] ?? config('app.name'))); ?>
<?php $__env->startSection('meta_description', $meta['description'] ?? ''); ?>

<?php $__env->startSection('content'); ?>


<div class="hero-band bg-earth-600">
    <div class="mx-auto max-w-6xl px-5 pb-16 pt-4 lg:pb-24 lg:pt-8">
        <nav aria-label="breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-sm text-white/60">
            <a href="<?php echo e(route('home')); ?>" class="transition hover:text-white"><?php echo e(__('Ana Sayfa')); ?></a>
            <span aria-hidden="true">/</span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentCategory): ?>
                <a href="<?php echo e(lroute('products.index')); ?>" class="transition hover:text-white"><?php echo e(__('Ürünler')); ?></a>
                <span aria-hidden="true">/</span>
                <span class="text-white/90"><?php echo e($currentCategory->translate('name')); ?></span>
            <?php else: ?>
                <span class="text-white/90"><?php echo e(__('Ürünler')); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>
        <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-300"><?php echo e(__('Ürün Kataloğu')); ?></span>
        <h1 class="mt-3 max-w-2xl text-[clamp(2.2rem,4.5vw,3.4rem)] font-medium leading-[1.08] tracking-tight text-white">
            <?php echo e($currentCategory ? $currentCategory->translate('name') : __('Bitkinizin her dönemine uygun çözümler')); ?>

        </h1>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentCategory && $currentCategory->translate('description')): ?>
            <div class="mt-4 max-w-2xl text-[15px] leading-relaxed text-white/80"><?php echo e(Str::limit(strip_tags($currentCategory->translate('description')), 220)); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<section class="mx-auto max-w-6xl px-5 py-12 lg:py-16">

    
    <div class="mb-8 flex flex-wrap items-center gap-2.5" aria-label="<?php echo e(__('Kategori filtresi')); ?>">
        <a href="<?php echo e(lroute('products.index')); ?>"
           class="rounded-full px-5 py-2.5 text-sm font-bold transition <?php echo e(!$currentCategory ? 'bg-leaf-600 text-white' : 'bg-leaf-500/10 text-leaf-700 hover:bg-leaf-500/20'); ?>">
            <?php echo e(__('Tümü')); ?>

        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(lroute('products.category', $category->slug)); ?>"
               class="rounded-full px-5 py-2.5 text-sm font-bold transition <?php echo e(($currentCategory && $currentCategory->id === $category->id) ? 'bg-leaf-600 text-white' : 'bg-leaf-500/10 text-leaf-700 hover:bg-leaf-500/20'); ?>">
                <?php echo e($category->translate('name')); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="mb-9 flex flex-col gap-4 border-b border-hair pb-6 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-ink-soft"><span class="font-bold text-ink"><?php echo e($products->total()); ?></span> <?php echo e(__('ürün bulundu')); ?></p>
        <div class="flex flex-wrap items-center gap-3">
            <form action="<?php echo e(lroute('products.search')); ?>" method="GET" class="flex">
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="<?php echo e(__('Ürün ara...')); ?>"
                       class="w-44 rounded-l-lg border border-hair px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-leaf-300 sm:w-56">
                <button type="submit" class="rounded-r-lg bg-leaf-600 px-4 py-2.5 text-white transition hover:bg-leaf-700" aria-label="<?php echo e(__('Ara')); ?>">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </form>
            <form action="<?php echo e($currentCategory ? lroute('products.category', $currentCategory->slug) : lroute('products.index')); ?>" method="GET">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('q')): ?><input type="hidden" name="q" value="<?php echo e(request('q')); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <select name="sort" onchange="this.form.submit()" class="rounded-lg border border-hair px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-leaf-300">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentCategory): ?>
                        <option value="category" <?php echo e((!request('sort') || request('sort') == 'category') ? 'selected' : ''); ?>><?php echo e(__('Kategoriye Göre')); ?></option>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>><?php echo e(__('İsim (A-Z)')); ?></option>
                    <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>><?php echo e(__('İsim (Z-A)')); ?></option>
                    <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>><?php echo e(__('En Yeni')); ?></option>
                </select>
            </form>
        </div>
    </div>

    
    <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $productImages = is_array($product->images) ? array_values(array_filter($product->images, 'is_string')) : [];
                $firstValidImage = null;
                foreach ($productImages as $_img) {
                    if (str_starts_with($_img, 'http') || \Illuminate\Support\Facades\Storage::disk('public')->exists($_img)) {
                        $firstValidImage = $_img;
                        break;
                    }
                }
            ?>
            <a href="<?php echo e(lroute('products.show', $product->slug)); ?>" class="group block rounded-2xl bg-white p-4 ring-1 ring-hair transition-all hover:-translate-y-1 hover:ring-leaf-400">
                <div class="overflow-hidden rounded-xl bg-gradient-to-b from-leaf-50/70 to-white p-3">
                    <div class="flex aspect-[3/4] items-center justify-center overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstValidImage): ?>
                            <?php if (isset($component)) { $__componentOriginalecfc361c64744489ff7ee842d5dc46c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-image','data' => ['path' => $firstValidImage,'alt' => $product->name,'class' => 'max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105','sizes' => '(max-width: 640px) 45vw, 22vw','loading' => 'lazy','decoding' => 'async']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['path' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($firstValidImage),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->name),'class' => 'max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105','sizes' => '(max-width: 640px) 45vw, 22vw','loading' => 'lazy','decoding' => 'async']); ?>
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
                            <svg class="h-16 w-16 text-leaf-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <span class="mt-4 inline-block text-xs font-bold uppercase tracking-wide text-leaf-600"><?php echo e($product->category?->translate('name')); ?></span>
                <h3 class="mt-1 line-clamp-2 font-extrabold text-ink transition-colors group-hover:text-leaf-700"><?php echo e($product->name); ?></h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->short_description): ?>
                    <p class="mt-0.5 line-clamp-2 text-sm text-ink-soft"><?php echo e(Str::limit(strip_tags($product->short_description), 80)); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-12 text-center text-ink-soft"><?php echo e(__('Ürün bulunamadı.')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="mt-10">
        <?php echo e($products->withQueryString()->links()); ?>

    </div>
</section>


<section class="bg-earth-700">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 px-5 py-14 text-center lg:flex-row lg:justify-between lg:py-16 lg:text-left">
        <div class="max-w-2xl">
            <h2 class="text-2xl font-extrabold text-white lg:text-3xl"><?php echo e(__('Hangi ürün size uygun, emin değil misiniz?')); ?></h2>
            <p class="mt-3 text-base leading-relaxed text-white/80"><?php echo e(__('Toprak analizinizi ve kültürünüzü paylaşın; agronomi ekibimiz size özel bir besleme programı hazırlasın.')); ?></p>
        </div>
        <a href="<?php echo e(lroute('contact')); ?>" class="inline-flex shrink-0 items-center justify-center gap-2 rounded bg-leaf-500 px-7 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-600">
            <?php echo e(__('İletişime Geç')); ?> <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/index.blade.php ENDPATH**/ ?>
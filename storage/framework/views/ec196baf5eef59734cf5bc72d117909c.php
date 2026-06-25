<?php
    $menuLabel = $menuLabel ?? __('Ürünler');
    $menuUrl = $menuUrl ?? lroute('products.index');
    $menuIsExternal = $menuIsExternal ?? false;
    $defaultCategories = $navCategories ?? collect();
    $customMegaMenu = collect($settings['mega_menu'] ?? [])->filter(fn ($item) => is_array($item));
    $categoryMap = collect($megaMenuCategories ?? [])->keyBy('id');

    // Kategori ID => ürünler haritası (eager loaded products'tan - pivot veya FK)
    $categoryProductsMap = collect($megaMenuCategories ?? [])->mapWithKeys(function ($cat) {
        $productsList = $cat->relationLoaded('allProducts')
            ? $cat->allProducts
            : ($cat->products ?? collect());
        $products = $productsList
            ->filter(fn ($p) => !empty($p->images) && is_array($p->images) && count($p->images) > 0)
            ->take(6);
        return [$cat->id => $products];
    });

    $normalizeText = function ($value) {
        $value = is_string($value) ? trim($value) : '';
        return $value !== '' ? $value : null;
    };

    $resolveCategory = function ($categoryId) use ($categoryMap) {
        if (!$categoryId) {
            return null;
        }
        $id = is_numeric($categoryId) ? (int) $categoryId : $categoryId;
        return $categoryMap->get($id);
    };

    $resolveUrl = function ($url, $category) use ($normalizeText) {
        $url = $normalizeText($url);
        if ($url) {
            return $url;
        }
        if ($category) {
            return route('products.category', $category->slug);
        }
        return null;
    };

    $buildAutoPromos = function ($category, $children) use ($categoryProductsMap) {
        $products = collect();
        if ($categoryProductsMap->has($category->id)) {
            $products = $products->merge($categoryProductsMap->get($category->id));
        }
        foreach ($children as $child) {
            if ($categoryProductsMap->has($child->id)) {
                $products = $products->merge($categoryProductsMap->get($child->id));
            }
        }
        $products = $products->unique('id')->shuffle()->take(6);

        return $products->map(function ($product) {
            return [
                'title' => $product->name,
                'url' => route('products.show', $product->slug),
                'image_path' => is_array($product->images) ? (array_values($product->images)[0] ?? null) : null,
            ];
        })->values()->all();
    };

    $buildAutoMenuItems = function ($categories) use ($buildAutoPromos) {
        $items = collect();
        foreach ($categories as $category) {
            $children = $category->children ?? collect();
            $desc = $category->translate('description_plain');
            $items->push([
                'key' => (string) $category->id,
                'label' => $category->translate('name'),
                'url' => route('products.category', $category->slug),
                'description' => ($desc !== '' && $desc !== null) ? $desc : null,
                'subcategories' => $children->map(function ($child) {
                    return [
                        'title' => $child->translate('name'),
                        'url' => route('products.category', $child->slug),
                    ];
                })->values(),
                'promos' => collect($buildAutoPromos($category, $children)),
            ]);
        }
        return $items;
    };

    $menuItems = collect();

    if ($customMegaMenu->isNotEmpty()) {
        foreach ($customMegaMenu as $index => $item) {
            $category = $resolveCategory($item['category_id'] ?? null);
            $label = $category ? $category->translate('name') : $normalizeText($item['title'] ?? null);
            $url = $resolveUrl($item['url'] ?? null, $category);
            $key = (string) ($category->id ?? 'custom-' . $index);
            $useAutoChildren = filter_var($item['use_auto_children'] ?? true, FILTER_VALIDATE_BOOLEAN);
            $useAutoPromos = filter_var($item['use_auto_promos'] ?? true, FILTER_VALIDATE_BOOLEAN);

            if (!$label || !$url) {
                continue;
            }

            $subcategories = collect($item['subcategories'] ?? [])
                ->map(function ($child) use ($resolveCategory, $resolveUrl, $normalizeText) {
                    $childCategory = $resolveCategory($child['category_id'] ?? null);
                    $title = $childCategory ? $childCategory->translate('name') : $normalizeText($child['title'] ?? null);
                    $link = $resolveUrl($child['url'] ?? null, $childCategory);
                    if (!$title || !$link) {
                        return null;
                    }
                    return ['title' => $title, 'url' => $link];
                })
                ->filter()
                ->values();

            if ($subcategories->isEmpty() && $useAutoChildren && $category) {
                $subcategories = $categoryMap
                    ->filter(fn ($child) => (int) $child->parent_id === (int) $category->id)
                    ->map(function ($child) {
                        return ['title' => $child->translate('name'), 'url' => route('products.category', $child->slug)];
                    })
                    ->values();
            }

            $promos = collect($item['promo_cards'] ?? [])
                ->map(function ($promo) use ($resolveCategory, $resolveUrl, $normalizeText) {
                    $promoCategory = $resolveCategory($promo['category_id'] ?? null);
                    $title = $promoCategory ? $promoCategory->translate('name') : $normalizeText($promo['title'] ?? null);
                    $link = $resolveUrl($promo['url'] ?? null, $promoCategory) ?? '#';
                    $imagePath = $normalizeText($promo['image'] ?? null);
                    $imageUrl = $normalizeText($promo['image_url'] ?? null);
                    $image = $imagePath ? \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath) : $imageUrl;
                    if (!$title || !$image) {
                        return null;
                    }
                    return ['title' => $title, 'url' => $link, 'image' => $image];
                })
                ->filter()
                ->values();

            if ($promos->isEmpty() && $useAutoPromos && $category) {
                $children = $categoryMap
                    ->filter(fn ($child) => (int) $child->parent_id === (int) $category->id)
                    ->values();
                $promos = collect($buildAutoPromos($category, $children));
            }

            $itemDesc = $normalizeText($item['description'] ?? null);
            if (!$itemDesc && $category) {
                $catDesc = $category->translate('description_plain');
                $itemDesc = ($catDesc !== '' && $catDesc !== null) ? $catDesc : null;
            }

            $menuItems->push([
                'key' => $key,
                'label' => $label,
                'url' => $url,
                'description' => $itemDesc,
                'subcategories' => $subcategories,
                'promos' => $promos,
            ]);
        }

        if ($menuItems->isEmpty()) {
            $menuItems = $buildAutoMenuItems($defaultCategories);
        }
    } else {
        $menuItems = $buildAutoMenuItems($defaultCategories);
    }
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($menuItems->isEmpty()): ?>
    <a href="<?php echo e($menuUrl); ?>" class="transition hover:text-white/70" <?php if($menuIsExternal): ?> target="_blank" <?php endif; ?>>
        <?php echo e($menuLabel); ?>

    </a>
<?php else: ?>
    
    <a href="<?php echo e($menuUrl); ?>" data-mega-btn aria-haspopup="true" aria-expanded="false" aria-controls="mega"
       class="inline-flex items-center gap-1 transition hover:text-white/70" <?php if($menuIsExternal): ?> target="_blank" <?php endif; ?>>
        <?php echo e($menuLabel); ?>

        <svg class="h-3.5 w-3.5 transition-transform" data-mega-chev viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
    </a>

    
    <div id="mega" class="fixed inset-0 z-50" aria-hidden="true" role="dialog" aria-label="<?php echo e(__('Ürün kategorileri')); ?>" aria-modal="true">
        <div class="absolute inset-0 bg-earth-900/55 backdrop-blur-sm" data-mega-close></div>
        <div class="mega-sheet absolute inset-x-0 top-0 max-h-[100dvh] overflow-y-auto bg-white text-ink shadow-2xl">
            <div class="mx-auto max-w-6xl px-5 py-6 lg:py-8">

                
                <div class="flex items-center justify-between border-b border-hair pb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-leaf-600 text-white"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg></span>
                        <h2 class="text-lg font-extrabold tracking-tight text-ink"><?php echo e(__('Ürün Kategorileri')); ?></h2>
                    </div>
                    <button type="button" data-mega-close aria-label="<?php echo e(__('Kapat')); ?>" class="grid h-10 w-10 place-items-center rounded-full text-ink-soft transition hover:bg-leaf-500/10 hover:text-leaf-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                
                <div class="grid grid-cols-1 gap-0 lg:grid-cols-[260px_1fr]">
                    <ul class="border-b border-hair py-3 lg:border-b-0 lg:border-r lg:py-5 lg:pr-3" role="tablist" aria-label="<?php echo e(__('Ana kategoriler')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <button type="button" role="tab" data-mega-cat="<?php echo e($item['key']); ?>"
                                        class="group flex w-full items-center justify-between gap-2 rounded-lg px-4 py-2.5 text-left text-[15px] font-bold transition <?php echo e($index === 0 ? 'active bg-leaf-600 text-white' : 'text-ink hover:bg-leaf-500/10'); ?>"
                                        aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>">
                                    <span><?php echo e($item['label']); ?></span>
                                    <svg class="h-4 w-4 opacity-0 transition group-hover:opacity-60 group-[.active]:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>

                    <div class="py-5 lg:pl-8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div data-mega-panel="<?php echo e($item['key']); ?>" <?php if($index !== 0): ?> hidden <?php endif; ?>>
                                <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                                    <div>
                                        <h3 class="text-2xl font-extrabold tracking-tight text-ink"><?php echo e($item['label']); ?></h3>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['description'])): ?>
                                            <p class="mt-1 max-w-lg text-sm leading-relaxed text-ink-soft line-clamp-2"><?php echo e($item['description']); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <a href="<?php echo e($item['url']); ?>" class="inline-flex shrink-0 items-center gap-1.5 rounded bg-leaf-600 px-4 py-2.5 text-sm font-extrabold text-white transition hover:bg-leaf-700">
                                        <?php echo e(__('Tümünü Gör')); ?>

                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                    </a>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['subcategories']->count() > 0): ?>
                                    <div class="mb-5 flex flex-wrap gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item['subcategories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e($child['url']); ?>" class="rounded-full border border-hair px-3.5 py-1.5 text-sm font-semibold text-ink transition hover:border-leaf-400 hover:bg-leaf-50 hover:text-leaf-700"><?php echo e($child['title']); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['promos']->count() > 0): ?>
                                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item['promos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e($promo['url']); ?>" class="reveal-item group block overflow-hidden rounded-2xl bg-white ring-1 ring-hair transition-all hover:-translate-y-1 hover:ring-leaf-400">
                                                <div class="bg-gradient-to-b from-leaf-50/70 to-white p-3">
                                                    <div class="aspect-[5/4] w-full overflow-hidden rounded-[10px] bg-leaf-50">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($promo['image_path'])): ?>
                                                            <?php if (isset($component)) { $__componentOriginalecfc361c64744489ff7ee842d5dc46c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalecfc361c64744489ff7ee842d5dc46c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-image','data' => ['path' => $promo['image_path'],'alt' => $promo['title'],'class' => 'h-full w-full object-cover transition-transform duration-300 group-hover:scale-105','sizes' => '200px','loading' => 'lazy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['path' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($promo['image_path']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($promo['title']),'class' => 'h-full w-full object-cover transition-transform duration-300 group-hover:scale-105','sizes' => '200px','loading' => 'lazy']); ?>
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
                                                        <?php elseif(!empty($promo['image'])): ?>
                                                            <img src="<?php echo e($promo['image']); ?>" alt="<?php echo e($promo['title']); ?>" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-between gap-2 px-4 py-3.5">
                                                    <span class="block font-extrabold text-ink transition group-hover:text-leaf-700"><?php echo e($promo['title']); ?></span>
                                                    <svg class="h-4 w-4 shrink-0 text-leaf-600 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                                </div>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/resources/views/partials/mega-menu.blade.php ENDPATH**/ ?>
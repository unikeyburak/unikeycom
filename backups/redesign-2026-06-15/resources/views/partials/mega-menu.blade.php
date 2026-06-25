@php
    $menuLabel = $menuLabel ?? __('Ürünler');
    $menuUrl = $menuUrl ?? lroute('products.index');
    $menuIsExternal = $menuIsExternal ?? false;
    $defaultCategories = $navCategories ?? collect();
    $customMegaMenu = collect($settings['mega_menu'] ?? [])->filter(fn ($item) => is_array($item));
    $categoryMap = collect($megaMenuCategories ?? [])->keyBy('id');

    // Kategori ID => ürünler haritası (eager loaded products'tan - pivot veya FK)
    $categoryProductsMap = collect($megaMenuCategories ?? [])->mapWithKeys(function ($cat) {
        // Pivot tablo varsa allProducts, yoksa products iliskisi yuklenmis olur
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
        // Kategoriye ait ürünleri topla (ana kategori + alt kategoriler)
        $products = collect();

        // Ana kategorinin ürünleri
        if ($categoryProductsMap->has($category->id)) {
            $products = $products->merge($categoryProductsMap->get($category->id));
        }

        // Alt kategorilerin ürünleri
        foreach ($children as $child) {
            if ($categoryProductsMap->has($child->id)) {
                $products = $products->merge($categoryProductsMap->get($child->id));
            }
        }

        // Tekrarları kaldır ve karıştır, 4 tane al
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
            // Kategori varsa her zaman çeviri kullan, yoksa title alanını kullan
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
                    // Kategori varsa her zaman çeviri kullan
                    $title = $childCategory ? $childCategory->translate('name') : $normalizeText($child['title'] ?? null);
                    $link = $resolveUrl($child['url'] ?? null, $childCategory);

                    if (!$title || !$link) {
                        return null;
                    }

                    return [
                        'title' => $title,
                        'url' => $link,
                    ];
                })
                ->filter()
                ->values();

            if ($subcategories->isEmpty() && $useAutoChildren && $category) {
                $subcategories = $categoryMap
                    ->filter(fn ($child) => (int) $child->parent_id === (int) $category->id)
                    ->map(function ($child) {
                        return [
                            'title' => $child->translate('name'),
                            'url' => route('products.category', $child->slug),
                        ];
                    })
                    ->values();
            }

            $promos = collect($item['promo_cards'] ?? [])
                ->map(function ($promo) use ($resolveCategory, $resolveUrl, $normalizeText) {
                    $promoCategory = $resolveCategory($promo['category_id'] ?? null);
                    // Kategori varsa her zaman çeviri kullan
                    $title = $promoCategory ? $promoCategory->translate('name') : $normalizeText($promo['title'] ?? null);
                    $link = $resolveUrl($promo['url'] ?? null, $promoCategory) ?? '#';
                    $imagePath = $normalizeText($promo['image'] ?? null);
                    $imageUrl = $normalizeText($promo['image_url'] ?? null);
                    $image = $imagePath ? \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath) : $imageUrl;

                    if (!$title || !$image) {
                        return null;
                    }

                    return [
                        'title' => $title,
                        'url' => $link,
                        'image' => $image,
                    ];
                })
                ->filter()
                ->values();

            if ($promos->isEmpty() && $useAutoPromos && $category) {
                $children = $categoryMap
                    ->filter(fn ($child) => (int) $child->parent_id === (int) $category->id)
                    ->values();
                $promos = collect($buildAutoPromos($category, $children));
            }

            // Açıklama: önce custom item'dan al, yoksa kategorinin description_plain'inden
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
@endphp

@if($menuItems->isEmpty())
    <a href="{{ $menuUrl }}" class="text-gray-700 hover:text-cyan-600 font-medium transition-colors" @if($menuIsExternal) target="_blank" @endif>
        {{ $menuLabel }}
    </a>
@else
    <div class="static group" data-mega-menu>
        <a href="{{ $menuUrl }}" class="flex items-center gap-2 text-gray-700 hover:text-cyan-600 font-medium transition-colors" @if($menuIsExternal) target="_blank" @endif>
            {{ $menuLabel }}
            <svg class="w-4 h-4 text-gray-400 group-hover:text-cyan-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </a>

        <div class="absolute left-1/2 top-full mt-4 w-[min(1100px,95vw)] -translate-x-1/2 rounded-2xl border border-gray-100 bg-white shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="grid grid-cols-12 gap-6 p-6">
                <div class="col-span-3 border-r border-gray-100">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-4">{{ __('Kategoriler') }}</p>
                    <ul class="space-y-1">
                        @foreach($menuItems as $index => $item)
                            <li>
                                <a href="{{ $item['url'] }}"
                                   data-mega-trigger
                                   data-category-id="{{ $item['key'] }}"
                                   class="flex items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-cyan-50 hover:text-cyan-700 transition-colors">
                                    <span class="font-medium">{{ $item['label'] }}</span>
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-span-5">
                    @foreach($menuItems as $index => $item)
                        <div class="space-y-4 {{ $index === 0 ? '' : 'hidden' }}" data-mega-panel data-category-id="{{ $item['key'] }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($item['subcategories']->count() > 0)
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Alt Kategoriler') }}</p>
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item['label'] }}</h3>
                                </div>
                                <a href="{{ $item['url'] }}" class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                    {{ __('Tümünü Gör') }}
                                </a>
                            </div>

                            @if($item['subcategories']->count() > 0)
                            <div class="flex flex-col gap-1">
                                @foreach($item['subcategories'] as $child)
                                    <a href="{{ $child['url'] }}"
                                       class="rounded-lg border border-gray-100 px-3 py-2 text-sm text-gray-700 hover:border-cyan-200 hover:text-cyan-700 hover:bg-cyan-50 transition-colors">
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach
                            </div>
                            @endif

                            @if(!empty($item['description']))
                            <p class="mt-3 text-sm text-gray-500 leading-relaxed line-clamp-4">
                                {{ $item['description'] }}
                            </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="col-span-4">
                    @foreach($menuItems as $index => $item)
                        <div class="grid grid-cols-2 gap-3 {{ $index === 0 ? '' : 'hidden' }}" data-mega-promos data-category-id="{{ $item['key'] }}">
                            @foreach($item['promos'] as $promo)
                                <a href="{{ $promo['url'] }}"
                                   class="relative overflow-hidden rounded-xl border border-gray-100 bg-gray-100 group/mega-card">
                                    <div class="aspect-[4/3] w-full overflow-hidden">
                                        @if(!empty($promo['image_path']))
                                            <x-responsive-image
                                                :path="$promo['image_path']"
                                                :alt="$promo['title']"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover/mega-card:scale-105"
                                                sizes="140px"
                                                loading="lazy"
                                            />
                                        @elseif(!empty($promo['image']))
                                            <img src="{{ $promo['image'] }}" alt="{{ $promo['title'] }}"
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover/mega-card:scale-105"
                                                 loading="lazy">
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent"></div>
                                    <span class="absolute bottom-2 left-2 right-2 text-xs font-semibold text-white drop-shadow">
                                        {{ $promo['title'] }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

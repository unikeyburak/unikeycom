<?php $__env->startSection('title',
    ($currentCategory ? $currentCategory->translate('name') . ' - ' : '') .
    ($currentTag ? $currentTag->name . ' - ' : '') .
    ($searchQuery ? __('Arama') . ': ' . $searchQuery . ' - ' : '') .
    __('Blog') . ' - ' . config('app.name')
); ?>

<?php $__env->startSection('content'); ?>

<?php
    $blogHeroTitle = $currentCategory
        ? $currentCategory->translate('name')
        : ($currentTag ? '#' . $currentTag->name : ($searchQuery ? '"' . $searchQuery . '"' : __('Blog')));
    $blogHeroSubtitle = !$currentCategory && !$currentTag && !$searchQuery
        ? __('Tarım dünyasından en güncel haberler ve bilgiler')
        : ($currentCategory ? ($currentCategory->translate('description') ?? null)
        : ($searchQuery ? __('Arama sonuçları') : null));
?>
<?php echo $__env->make('partials.page-header', [
    'title'    => $blogHeroTitle,
    'subtitle' => $blogHeroSubtitle,
    'image'    => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'small',
    'overlay'  => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="pt-8 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div></div>

                
                <form action="<?php echo e(lroute('blog.search')); ?>" method="GET" class="flex-shrink-0">
                    <div class="relative">
                        <input type="text" name="q" value="<?php echo e($searchQuery ?? ''); ?>"
                               placeholder="<?php echo e(__('Blog\'da ara...')); ?>"
                               class="w-full sm:w-64 pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-full bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categories) && $categories->count() > 0): ?>
                <nav class="flex items-center gap-2 overflow-x-auto pb-1 -mb-px" style="-webkit-overflow-scrolling: touch;">
                    <a href="<?php echo e(lroute('blog.index')); ?>"
                       class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                              <?php echo e(!$currentCategory && !$currentTag && !$searchQuery
                                  ? 'bg-cyan-600 text-white'
                                  : 'text-gray-600 hover:bg-gray-100'); ?>">
                        <?php echo e(__('Tümü')); ?>

                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('blog.category', $cat->slug)); ?>"
                           class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors
                                  <?php echo e($currentCategory && $currentCategory->id === $cat->id
                                      ? 'bg-cyan-600 text-white'
                                      : 'text-gray-600 hover:bg-gray-100'); ?>">
                            <?php echo e($cat->translate('name')); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </nav>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$currentCategory && !$currentTag && !$searchQuery): ?>
    

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($featuredPost) && $featuredPost): ?>
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <a href="<?php echo e(route('blog.show', $featuredPost->slug)); ?>" class="group block">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-gray-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredPost->featured_image): ?>
                            <img src="<?php echo e(asset('storage/' . $featuredPost->featured_image)); ?>"
                                 alt="<?php echo e($featuredPost->title); ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-50 to-cyan-100">
                                <svg class="w-20 h-20 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredPost->category): ?>
                            <span class="inline-block text-sm font-semibold text-cyan-600 uppercase tracking-wide mb-3">
                                <?php echo e($featuredPost->category->name); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <h2 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-4 group-hover:text-cyan-600 transition-colors leading-tight">
                            <?php echo e($featuredPost->title); ?>

                        </h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredPost->excerpt): ?>
                            <p class="text-gray-500 text-base lg:text-lg mb-6 line-clamp-3 leading-relaxed">
                                <?php echo e(Str::limit(strip_tags($featuredPost->excerpt), 200)); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <time datetime="<?php echo e($featuredPost->published_at?->toDateString()); ?>">
                                <?php echo e($featuredPost->published_at?->format('d.m.Y') ?? $featuredPost->created_at->format('d.m.Y')); ?>

                            </time>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredPost->reading_time): ?>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($featuredPost->reading_time); ?> dk okuma
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-2 text-cyan-600 font-medium group-hover:gap-3 transition-all">
                                <?php echo e(__('Devamını Oku')); ?>

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryPosts)): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catSection->latestPosts && $catSection->latestPosts->count() > 0): ?>
            <section class="py-12 <?php echo e($loop->even ? 'bg-gray-50' : 'bg-white'); ?>">
                <div class="container mx-auto px-4">
                    
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900"><?php echo e($catSection->translate('name')); ?></h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catSection->posts_count > 3): ?>
                            <a href="<?php echo e(route('blog.category', $catSection->slug)); ?>"
                               class="text-sm font-medium text-cyan-600 hover:text-cyan-700 flex items-center gap-1 group/link">
                                <?php echo e(__('Tümünü Gör')); ?>

                                <svg class="w-4 h-4 group-hover/link:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $catSection->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('blog.partials.card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((!isset($featuredPost) || !$featuredPost) && (!isset($categoryPosts) || $categoryPosts->isEmpty())): ?>
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 text-center">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Henüz yazı bulunamadı')); ?></h3>
                <p class="text-gray-500"><?php echo e(__('Yakında yeni yazılar eklenecektir.')); ?></p>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php else: ?>
    
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($posts)): ?>
                
                <nav class="mb-6 text-sm text-gray-500">
                    <a href="<?php echo e(route('home')); ?>" class="hover:text-cyan-600 transition-colors"><?php echo e(__('Ana Sayfa')); ?></a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo e(lroute('blog.index')); ?>" class="hover:text-cyan-600 transition-colors"><?php echo e(__('Blog')); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentCategory): ?>
                        <span class="mx-2">/</span>
                        <span class="text-gray-900"><?php echo e($currentCategory->translate('name')); ?></span>
                    <?php elseif($currentTag): ?>
                        <span class="mx-2">/</span>
                        <span class="text-gray-900"><?php echo e($currentTag->name); ?></span>
                    <?php elseif($searchQuery): ?>
                        <span class="mx-2">/</span>
                        <span class="text-gray-900"><?php echo e(__('Arama')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </nav>

                
                <div class="mb-8">
                    <p class="text-sm text-gray-500">
                        <span class="font-semibold text-gray-900"><?php echo e($posts->total()); ?></span> <?php echo e(__('yazı bulundu')); ?>

                    </p>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($posts->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('blog.partials.card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="mt-12">
                        <?php echo e($posts->withQueryString()->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-20">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Yazı bulunamadı')); ?></h3>
                        <p class="text-gray-500 mb-6"><?php echo e(__('Aradığınız kriterlere uygun yazı bulunmuyor.')); ?></p>
                        <a href="<?php echo e(lroute('blog.index')); ?>" class="inline-flex items-center gap-2 text-cyan-600 hover:text-cyan-700 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <?php echo e(__('Tüm yazılara dön')); ?>

                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/blog/index.blade.php ENDPATH**/ ?>
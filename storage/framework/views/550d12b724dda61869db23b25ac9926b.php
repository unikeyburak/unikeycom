
<meta name="description" content="<?php echo e($meta['description'] ?? ''); ?>">
<meta name="keywords" content="<?php echo e($meta['keywords'] ?? ''); ?>">
<meta name="author" content="<?php echo e($settings['site_name'] ?? ''); ?>">


<link rel="canonical" href="<?php echo e($meta['canonical'] ?? request()->url()); ?>">


<meta property="og:type" content="<?php echo e($meta['type'] ?? 'website'); ?>">
<meta property="og:url" content="<?php echo e($meta['url'] ?? request()->url()); ?>">
<meta property="og:title" content="<?php echo e($meta['title'] ?? $settings['site_name'] ?? ''); ?>">
<meta property="og:description" content="<?php echo e($meta['description'] ?? ''); ?>">
<meta property="og:image" content="<?php echo e($meta['image'] ?? asset('images/og-default.jpg')); ?>">
<meta property="og:image:alt" content="<?php echo e($meta['title'] ?? $settings['site_name'] ?? ''); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($meta['image_width']) && !empty($meta['image_height'])): ?>
<meta property="og:image:width" content="<?php echo e($meta['image_width']); ?>">
<meta property="og:image:height" content="<?php echo e($meta['image_height']); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta property="og:locale" content="<?php echo e($ogLocales['primary'] ?? $meta['locale'] ?? 'tr_TR'); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ($ogLocales['alternates'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altLocale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<meta property="og:locale:alternate" content="<?php echo e($altLocale); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta property="og:site_name" content="<?php echo e($settings['site_name'] ?? ''); ?>">


<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo e($meta['url'] ?? request()->url()); ?>">
<meta name="twitter:title" content="<?php echo e($meta['title'] ?? $settings['site_name'] ?? ''); ?>">
<meta name="twitter:description" content="<?php echo e($meta['description'] ?? ''); ?>">
<meta name="twitter:image" content="<?php echo e($meta['image'] ?? asset('images/og-default.jpg')); ?>">
<meta name="twitter:image:alt" content="<?php echo e($meta['title'] ?? $settings['site_name'] ?? ''); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings['twitter_handle'])): ?>
<meta name="twitter:site" content="<?php echo e($settings['twitter_handle']); ?>">
<meta name="twitter:creator" content="<?php echo e($settings['twitter_handle']); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<meta name="robots" content="<?php echo e($meta['robots'] ?? 'index, follow'); ?>">


<?php ($hreflangList = $hreflangLinks ?? ($meta['hreflang'] ?? [])); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($hreflangList)): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $hreflangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="alternate" hreflang="<?php echo e($lang['hreflang']); ?>" href="<?php echo e($lang['href']); ?>">
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($schema)): ?>
    <script type="application/ld+json">
    <?php echo $schema; ?>

    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($schemas)): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schemas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schemaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script type="application/ld+json">
        <?php echo json_encode($schemaItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH /var/www/html/resources/views/partials/seo-meta.blade.php ENDPATH**/ ?>
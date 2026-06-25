
<?php
    $title     = $title     ?? '';
    $subtitle  = $subtitle  ?? null;
    $image     = $image     ?? null;
    $ctaText   = $ctaText   ?? null;
    $ctaUrl    = $ctaUrl    ?? null;
    $videoUrl  = $videoUrl  ?? null;
    $size      = $size      ?? 'default';
    $overlay   = $overlay   ?? true;

    $sizeClass = match($size) {
        'large'   => 'page-header-hero--large',
        'small'   => 'page-header-hero--small',
        default   => 'page-header-hero--default',
    };
?>

<header class="page-header-hero <?php echo e($sizeClass); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image): ?>
        <div class="page-header-hero__bg" style="background-image: url('<?php echo e($image); ?>');"></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overlay): ?>
            <div class="page-header-hero__overlay"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <div class="page-header-hero__bg page-header-hero__bg--gradient"></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="page-header-hero__content">
        <div class="container mx-auto px-4">
            <div class="page-header-hero__inner">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subtitle && $size === 'large'): ?>
                    <span class="page-header-hero__eyebrow"><?php echo e($subtitle); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <h1 id="page-title" class="page-header-hero__title"><?php echo e($title); ?></h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subtitle && $size !== 'large'): ?>
                    <p class="page-header-hero__subtitle"><?php echo e($subtitle); ?></p>
                <?php elseif($subtitle && $size === 'large'): ?>
                    <p class="page-header-hero__subtitle"><?php echo e($subtitle); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ctaText && $ctaUrl): ?>
                    <div class="page-header-hero__actions">
                        <a href="<?php echo e($ctaUrl); ?>" class="page-header-hero__cta">
                            <?php echo e($ctaText); ?>

                            <svg class="page-header-hero__cta-arrow" width="18" height="12" viewBox="0 0 18 12" fill="none">
                                <path d="M1 6h16m0 0L12 1m5 5l-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videoUrl): ?>
                            <button type="button" class="page-header-hero__play"
                                    x-data
                                    @click="$dispatch('open-video-modal', { url: '<?php echo e($videoUrl); ?>' })"
                                    aria-label="<?php echo e(__('Videoyu oynat')); ?>">
                                <span class="page-header-hero__play-circle">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="currentColor">
                                        <path d="M14 8L0 16V0z"/>
                                    </svg>
                                </span>
                                <span class="page-header-hero__play-text"><?php echo e(__('Tanıtım Videosu')); ?></span>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php elseif($videoUrl): ?>
                    <div class="page-header-hero__actions">
                        <button type="button" class="page-header-hero__play"
                                x-data
                                @click="$dispatch('open-video-modal', { url: '<?php echo e($videoUrl); ?>' })"
                                aria-label="<?php echo e(__('Videoyu oynat')); ?>">
                            <span class="page-header-hero__play-circle">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="currentColor">
                                    <path d="M14 8L0 16V0z"/>
                                </svg>
                            </span>
                            <span class="page-header-hero__play-text"><?php echo e(__('Tanıtım Videosu')); ?></span>
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /var/www/html/resources/views/partials/page-header.blade.php ENDPATH**/ ?>
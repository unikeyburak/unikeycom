<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'path',
    'alt' => '',
    'class' => '',
    'sizes' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'decoding' => 'async',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'path',
    'alt' => '',
    'class' => '',
    'sizes' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'decoding' => 'async',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $data = app(\App\Services\MediaService::class)->getResponsiveImageData(
        $path,
        ['sizes' => $sizes]
    );
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data && !empty($data['src'])): ?>
    <?php
        $baseAttributes = [
            'class' => $class,
            'loading' => $loading,
            'decoding' => $decoding,
        ];

        if (!empty($fetchpriority)) {
            $baseAttributes['fetchpriority'] = $fetchpriority;
        }
    ?>
    <img <?php echo e($attributes->merge($baseAttributes)); ?>

         src="<?php echo e($data['src']); ?>"
         <?php if(!empty($data['srcset'])): ?> srcset="<?php echo e($data['srcset']); ?>" <?php endif; ?>
         <?php if(!empty($data['sizes'])): ?> sizes="<?php echo e($data['sizes']); ?>" <?php endif; ?>
         <?php if(!empty($data['width'])): ?> width="<?php echo e((int) $data['width']); ?>" <?php endif; ?>
         <?php if(!empty($data['height'])): ?> height="<?php echo e((int) $data['height']); ?>" <?php endif; ?>
         alt="<?php echo e($alt); ?>">
<?php else: ?>
    <div class="<?php echo e($class); ?> flex items-center justify-center bg-gray-100">
        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/resources/views/components/responsive-image.blade.php ENDPATH**/ ?>
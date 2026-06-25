<?php $__env->startSection('title', $page->meta_title ?? $page->title . ' - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', $page->meta_description); ?>
<?php $__env->startSection('meta_keywords', $page->meta_keywords); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'title'    => $page->title,
    'subtitle' => $page->meta_description ?? null,
    'image'    => $page->featured_image_url ?? 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Content -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <style>
                .page-content figure figcaption { display: none !important; }
                .page-content figure { margin: 1rem 0; }
                .page-content figure img { border-radius: 0.5rem; max-width: 100%; height: auto; }
            </style>
            <div class="page-content prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-cyan-600 hover:prose-a:text-cyan-700 prose-img:rounded-lg">
                <?php echo $page->rendered_content; ?>

            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/pages/show.blade.php ENDPATH**/ ?>
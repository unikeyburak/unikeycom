{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><?php echo e(config('app.name')); ?> - Blog</title>
        <link><?php echo e(lroute('blog.index')); ?></link>
        <description><?php echo e(config('app.name')); ?> - Blog</description>
        <language>tr</language>
        <lastBuildDate><?php echo e($posts->first()?->published_at?->toRssString() ?? now()->toRssString()); ?></lastBuildDate>
        <atom:link href="<?php echo e(route('blog.rss')); ?>" rel="self" type="application/rss+xml" />

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <item>
            <title><![CDATA[<?php echo e($post->title); ?>]]></title>
            <link><?php echo e(route('blog.show', $post->slug)); ?></link>
            <guid isPermaLink="true"><?php echo e(route('blog.show', $post->slug)); ?></guid>
            <description><![CDATA[<?php echo e($post->excerpt ?? Str::limit(strip_tags($post->content), 300)); ?>]]></description>
            <pubDate><?php echo e($post->published_at?->toRssString() ?? $post->created_at->toRssString()); ?></pubDate>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
            <category><![CDATA[<?php echo e($post->category->name); ?>]]></category>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </item>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </channel>
</rss>
<?php /**PATH /var/www/html/resources/views/blog/rss.blade.php ENDPATH**/ ?>
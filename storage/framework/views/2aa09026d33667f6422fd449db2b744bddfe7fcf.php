<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo e(url('')); ?></loc>
        <lastmod><?php echo e(gmdate(DateTime::W3C)); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo e(url('about-us')); ?></loc>
        <lastmod><?php echo e(gmdate(DateTime::W3C)); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo e(url('lien-he')); ?></loc>
        <lastmod><?php echo e(gmdate(DateTime::W3C)); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <?php if(count($router) > 0): ?>
    <?php $__currentLoopData = $router; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('routerURL',['slug' => $v->slug])); ?></loc>
        <lastmod><?php echo e(gmdate(DateTime::W3C, strtotime($v->created_at))); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php /*@if(count($Tags) > 0)
    @foreach($Tags as $v)
    <url>
        <loc>{{ route('tagURL',['slug' => $v->slug]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($v->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @endif
    @if(count($Brands) > 0)
    @foreach($Brands as $v)
    <url>
        <loc>{{ route('brandURL',['slug' => $v->slug]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($v->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @endif*/ ?>
</urlset><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/home/sitemap.blade.php ENDPATH**/ ?>
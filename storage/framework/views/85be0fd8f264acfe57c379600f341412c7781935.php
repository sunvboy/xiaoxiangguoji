<div class="ps-widget ps-widget--blog">
    <div class="ps-widget">
        <h3 class="ps-widget__title">Tìm kiếm</h3>
        <div class="nav-ps-widget">
            <form action="<?php echo e(route('categoryArticle.search')); ?>" method="GET">
                <input type="text" name="keyword" placeholder="Tìm kiếm">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
    <?php
    $listMenus = getMenus('danh-muc-bai-viet');
    ?>
    <?php if(!empty($listMenus->menu_items) && count($listMenus->menu_items) > 0): ?>
    <div class="ps-widget ps-widget__block">
        <h4 class="ps-widget__title">Danh mục bài viết</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
        <div class="ps-widget__content">
            <ul class="ps-widget--category">
                <?php $__currentLoopData = $listMenus->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(url($item->slug)); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo e($item->title); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <?php
    $listNews =
        \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
        ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])
        ->with(['posts' => function ($query) {
            $query->limit(5)->get();
        }])
        ->first();
    ?>

    <?php if(!empty($listNews)): ?>
    <?php if(!empty($listNews->posts)): ?>
    <div class="ps-widget  Recent-Post-sb">
        <h4 class="ps-widget__title"><?php echo e($listNews->title); ?> mới</h4>
        <div class="nav-Recent-Post-sb">
            <?php $__currentLoopData = $listNews->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item">
                <div class="img">
                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                        <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                    </a>
                </div>
                <div class="nav-img">
                    <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                    <p class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php $tags = \App\Models\Tag::select('title', 'slug')->where(['module' => 'articles'])->orderBy('order', 'asc')->orderBy('id', 'desc')->limit(20)->get(); ?>
    <?php if(!empty($tags)): ?>
    <div class="ps-widget Popular-Tag-sb">
        <h4 class="ps-widget__title">Tags</h4>
        <div class="nav-Popular-Tag-sb">
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('tagURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>


    <div class="all__sidebar-contact">
        <div class="all__sidebar-contact-image dark__image">
            <img class="img__full" src="<?php echo e(asset($fcSystem['banner_3'])); ?>" alt="banner">
        </div>
    </div>
</div><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/article/frontend/aside.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>

<main class="main-new-2 main-new-detail">

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_0'])); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="tp-breadcrumb-link-active">
                                <a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"> \ <?php echo e($v->title); ?></a>
                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <h2 class="tp-breadcrumb-title">Trang <?php echo e($catalogues->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-new-2">

        <div class="second-new-2">
            <div class="container">

                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="content-left">
                            <h1 class="title-primary"><?php echo e($detail->title); ?></h1>
                            <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->created_at)->format('d/m/Y - h:i')); ?></p>
                            <div class="content-content">
                                <?php echo $detail->description; ?>

                            </div>
                            <div class="content-content">
                                <?php echo $detail->content; ?>

                                <div class="sharethis-inline-share-buttons"></div>
                            </div>

                            <?php if(!$sameArticle->isEmpty()): ?>
                            <div class="item-modul-1 bai-viet-lien-quan">
                                <div class="tp-section text-p">
                                    <h3 class="tp-section-title">Bài viết liên quan</h3>
                                </div>
                                <div class="nav-content">
                                    <div class="row">
                                        <?php $__currentLoopData = $sameArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($k==0): ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item">
                                                <div class="img hover-zoom">
                                                    <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                                        <img src="<?php echo e(asset($v->image)); ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="nav-img">
                                                    <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                                    <p class="desc"><?php echo strip_tags($v->description); ?></p>
                                                    <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y')); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item-right">
                                                <?php $__currentLoopData = $sameArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($k>0): ?>
                                                <div class="item-2">
                                                    <div class="img hover-zoom">
                                                        <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>"></a>
                                                    </div>
                                                    <div class="nav-img">
                                                        <h3 class="titl-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                                        <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y')); ?></p>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=66765bc7f75dab0019adeb9f&product=inline-share-buttons&source=platform" async="async"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/article/frontend/article/index.blade.php ENDPATH**/ ?>
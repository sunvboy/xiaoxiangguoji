<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-detail-new pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="ps-breadcrumb__item active"><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"><?php echo e($v->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="ps-page__content">

            <section class="content-detail-new">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-12">
                        <div class="content-detail-left bg-white">
                            <h1 class="title-pr"><?php echo e($detail->title); ?></h1>
                            <div class="date-view">
                                <ul>
                                    <li>
                                        <i class="fa fa-calendar-o" aria-hidden="true"></i> Ngày đăng: <?php echo e($detail->created_at); ?>

                                    </li>
                                    <li>
                                        <i class="fa fa-eye" aria-hidden="true"></i>lượt xem: <?php echo e($detail->viewed); ?> lượt xem
                                    </li>
                                </ul>
                            </div>
                            <div class="content-content">
                                <?php echo $detail->content; ?>

                                <div class="prev-next">
                                    <ul>
                                        <?php if(!empty($previous)): ?>
                                        <li class="prev">
                                            <a href="<?php echo e(route('routerURL',['slug' => $previous->slug])); ?>" class="title-3"><?php echo e($previous->title); ?></a>
                                            <a href="<?php echo e(route('routerURL',['slug' => $previous->slug])); ?>">Prev<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($next)): ?>
                                        <li class="next">
                                            <a href="<?php echo e(route('routerURL',['slug' => $next->slug])); ?>" class="title-3"><?php echo e($next->title); ?></a>
                                            <a href="<?php echo e(route('routerURL',['slug' => $next->slug])); ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Next</a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>




                    </div>
                    <div class="col-md-3 col-sm-3 col-12">
                        <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>
                </div>
            </section>
            <?php if(!$sameArticle->isEmpty()): ?>
            <div class="other-new bg-white">
                <div class="title-title-2">
                    <h2 class="title-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Bài viết liên quan
                    </h2>
                </div>
                <div class="slider-new owl-carousel owl-loaded owl-drag">
                    <?php $__currentLoopData = $sameArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">
                        <div class="img hover-zoom">
                            <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                <img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>">
                            </a>
                        </div>
                        <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                        <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i>Ngày đăng: <?php echo e($v->created_at); ?></p>
                        <p class="desc"><?php echo e(strip_tags($v->description)); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>


        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/article/frontend/article/index.blade.php ENDPATH**/ ?>
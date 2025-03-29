<?php $__env->startSection('content'); ?>
<main class="main-new-2" style="margin-bottom: 50px;">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_0'])); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active">
                                <a href="<?php echo e(url('/')); ?>">Trang chủ</a>
                            </span>
                            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="tp-breadcrumb-link-active">
                                <a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"> \ <?php echo e($v->title); ?></a>
                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <h2 class="tp-breadcrumb-title">Trang <?php echo e($detail->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="">
        <div class="second-new-2">
            <div class="container">
                <div class="border-t">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="content-left">
                                <?php if(!empty($data)): ?>
                                <div class="item-modul-1">
                                    <div class="nav-content" style="margin-top: 0px;">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="item-right">
                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="item-2">
                                                        <div class="img hover-zoom">
                                                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>" style="height: auto;"></a>
                                                        </div>
                                                        <div class="nav-img">
                                                            <h3 class="titl-3" style="height: auto;"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                                            <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></p>
                                                            <div>
                                                                <?php echo e(strip_tags($item->description)); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <?php echo e($data->links()); ?>

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
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/article/frontend/category/index.blade.php ENDPATH**/ ?>
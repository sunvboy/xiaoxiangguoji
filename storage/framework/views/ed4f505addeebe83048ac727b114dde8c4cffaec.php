<?php $__env->startSection('content'); ?>
<main>

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_4'])); ?>">
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

    <!-- services-area-start -->
    <section class="services-area tp-services-2-wrap pt-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-40">
                        <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="<?php echo e($detail->title); ?>"></span>
                        <h5 class="tp-section-subtitle"><?php echo e($detail->title); ?></h5>
                        <h3 class="tp-section-title"><?php echo e(strip_tags($detail->description)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(!empty($data)): ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="tp-services-2 mb-30">
                        <div class="tp-services-2-thumb p-relative">
                            <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                            <div class="tp-services-2-icon">
                                <span><i class="flaticon-disabled"></i></span>
                            </div>
                        </div>
                        <div class="tp-services-2-content">
                            <h4 class="tp-services-2-title"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h4>
                            <div class="tp-services-2-list mb-35">
                                <div class="tp-services-2-list-item d-flex">
                                    <!-- <span><img src="<?php echo e(asset('frontend/ncare/assets/img/icon/services-2-icon-1.svg')); ?>" alt="<?php echo e($item->title); ?>"></span> -->
                                    <p><?php echo e(strip_tags($item->description)); ?></p>
                                </div>
                            </div>
                            <div class="tp-services-2-btn">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem chi tiết<span><i class="fa-sharp fa-solid fa-plus"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </div>
        </div>
    </section>
    <!-- services-area-end -->


</main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/article/frontend/category/service.blade.php ENDPATH**/ ?>
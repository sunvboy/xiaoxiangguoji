<?php $__env->startSection('content'); ?>
<main class="main-new-2 main-video">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_1'])); ?>">
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
                        <h2 class="tp-breadcrumb-title"><?php echo e($detail->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content-video">
        <div class="container">
            <?php
            $image_json = json_decode($detail->image_json, TRUE);
            ?>
            <?php if(!empty($image_json)): ?>
            <div class="item-video">
                <div class="row">
                    <?php $__currentLoopData = $image_json; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-sm-6 col-6">
                        <div class="item">
                            <div class="img">
                                <a data-fancybox="gallery" href="<?php echo e(asset($v)); ?>">
                                    <img src="<?php echo e($v); ?>" alt="<?php echo e($detail->title); ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
    .main-video .content-video .item .img::before {
        display: none;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('javascript'); ?>
<link rel="stylesheet" href="<?php echo e(asset('frontend/ncare/assets/css/fancybox.css')); ?>">
<script src="<?php echo e(asset('frontend/ncare/assets/js/fancybox.umd.js')); ?>">
</script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/media/frontend/media/index.blade.php ENDPATH**/ ?>
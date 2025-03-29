<?php $__env->startSection('content'); ?>
<main class="main-new-2">
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
    <div class="content-new-2 customer-tp-news">
        <?php if(!empty($data)): ?>
        <div class="top-new-2">
            <div class="container">
                <div class="row customer-tp-news-one">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k == 0): ?>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="item-large">
                            <div class="img hover-zoom">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>"></a>
                                <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></p>
                            </div>
                            <div class="nav-img">

                                <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                <p class="desc">
                                    <?php echo e(strip_tags($item->description)); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($k == 1 || $k == 2): ?>
                        <div class=" item-small">
                            <div class="img hover-zoom">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>"></a>
                                <p class="date"><i class="fa-solid fa-calendar-days"></i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></p>
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="second-new-2 customer-tp-news-two">
            <div class="container">
                <div class="border-t">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="content-left">
                                <?php if(!empty($detail->children)): ?>
                                <?php $__currentLoopData = $detail->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($item->posts6)): ?>
                                <div class="item-modul-1 customer-tp-news-two-items">
                                    <div class="tp-section text-p">
                                        <h3 class="tp-section-title"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                    </div>
                                    <div class="nav-content">
                                        <div class="row">
                                            <?php $__currentLoopData = $item->posts6; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($k==0): ?>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="item">
                                                    <div class="img hover-zoom">
                                                        <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                                            <img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>">
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
                                                    <?php $__currentLoopData = $item->posts6; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($k > 0): ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/article/frontend/category/children.blade.php ENDPATH**/ ?>
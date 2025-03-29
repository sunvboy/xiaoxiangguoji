<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-category-new pb-120 bg-gray">
    <div class="container">
        <div></div>
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="ps-breadcrumb__item active"><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"><?php echo e($v->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>
        <div class="ps-page__content">
            <?php if(!empty($data)): ?>
            <section class="health-corner bg-white">
                <div class="section-title-2 cat">
                    <h2 class=" ps-section__title title title split-in-fade"> <i class="fa fa-plus-circle" aria-hidden="true"></i><?php echo e($detail->title); ?></h2>
                </div>

                <div class="row">
                    <?php foreach ($data as $k => $item) { ?>
                        <?php if($k == 0): ?>
                        <div class="col-md-7 col-xs-7 col-xs-12">
                            <div class="item-large">
                                <div class="img  hover-zoom">
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                        <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                    </a>
                                </div>
                                <p class="category-link"><a href="<?php echo e(route('routerURL',['slug' => $item->slugC])); ?>"><?php echo e($item->titleC); ?></a></p>
                                <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php } ?>

                    <div class="col-md-5 col-xs-5 col-xs-12">

                        <?php foreach ($data as $k => $item) { ?>
                            <?php if($k > 0 && $k<=5): ?> <div class="item-small">
                                <div class="item">
                                    <div class="img hover-zoom">
                                        <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                            <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                        </a>
                                    </div>
                                    <div class="nav-img">
                                        <p class="category-link"><a href="<?php echo e(route('routerURL',['slug' => $item->slugC])); ?>"><?php echo e($item->titleC); ?></a></p>
                                        <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                    </div>
                                </div>
                    </div>
                    <?php endif; ?>
                <?php } ?>
                </div>
        </div>
        </section>
        <?php endif; ?>

        <section class="modul-second-new">
            <div class="row">
                <div class="col-md-9 col-sm-9 col-12">
                    <?php if(!empty($detail->children)): ?>
                    <?php $__currentLoopData = $detail->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key == 0): ?>
                    <?php if(!empty($item->posts)): ?>
                    <div class="item-item bg-white">
                        <div class="item-large">
                            <div class="title-tab">
                                <div class="section-title-2 cat">
                                    <h2 class=" ps-section__title title title split-in-fade"> <i class="fa fa-plus-circle" aria-hidden="true"></i><?php echo e($item->title); ?></h2>
                                </div>
                                <div class="readmore">
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem tất cả<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="nav-item-large">
                                <div class="row">
                                    <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($k==0): ?>
                                    <div class="col-md-8 col-sm-8 col-12">
                                        <div class="item-1">
                                            <div class="img">
                                                <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                                    <img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>">
                                                </a>
                                            </div>
                                            <div class="nav-img">
                                                <p class="category-link"><a href="<?php echo e(route('routerURL',['slug' => $v->slugC])); ?>"><?php echo e($v->titleC); ?></a></p>
                                                <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                                <div class="desc">
                                                    <?php echo $v->description; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($k==1): ?>
                                    <div class="col-md-4 col-sm-4 col-12">
                                        <div class="item-1 item-2">
                                            <div class="nav-img">
                                                <p class="category-link"><a href="<?php echo e(route('routerURL',['slug' => $v->slugC])); ?>"><?php echo e($v->titleC); ?></a></p>
                                                <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                                <div class="desc">
                                                    <?php echo $v->description; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="nav-item-large-2">
                                <div class="row">
                                    <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($k>1 && $k<=4): ?> <div class="col-md-4 col-sm-4 col-12">
                                        <div class="item">
                                            <p class="category-link"><a href="<?php echo e(route('routerURL',['slug' => $v->slugC])); ?>"><?php echo e($v->titleC); ?></a></p>
                                            <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                        </div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>

                <?php if($key == 1): ?>
                <?php if(!empty($item->posts)): ?>
                <div class="modul-new-sale bg-white">
                    <div class="title-tab">
                        <div class="section-title-2 cat">
                            <h2 class=" ps-section__title title title split-in-fade"> <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e($item->title); ?></h2>
                        </div>
                        <div class="readmore">
                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem tất cả<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="slider-new-sale owl-carousel">
                        <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <div class="img">
                                <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>"></a>
                            </div>
                            <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php if($key > 1): ?>
                <?php if(!empty($item->posts)): ?>
                <div class="modul-new-2 bg-white">
                    <div class="title-tab">
                        <div class="section-title-2 cat">
                            <h2 class=" ps-section__title title title split-in-fade"> <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e($item->title); ?></h2>
                        </div>
                        <div class="readmore">
                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem tất cả<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="nav-modul-new-2">
                        <div class="row">
                            <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($k<=1): ?> <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="item">
                                    <div class="img">
                                        <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                            <img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>">
                                        </a>
                                    </div>
                                    <div class="nav-img">
                                        <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                        <p class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo e($v->created_at); ?></p>
                                        <div class="desc">
                                            <?php echo $v->description; ?>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="nav-modul-new-2 nav-modul-new-3">
                    <div class="row">
                        <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($k > 1 && $key <= 5): ?> <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="item">
                                <div class="img">
                                    <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>">
                                        <img src="<?php echo e(asset($v->image)); ?>" alt="<?php echo e($v->title); ?>">
                                    </a>
                                </div>
                                <div class="nav-img">
                                    <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>"><?php echo e($v->title); ?></a></h3>
                                    <p class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i><?php echo e($v->created_at); ?></p>

                                </div>
                            </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<div class="col-md-3 col-sm-3 col-12">
    <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
</div>
</section>


</div>
</div>


</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/article/frontend/category/children.blade.php ENDPATH**/ ?>
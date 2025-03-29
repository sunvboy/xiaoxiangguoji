
<?php $__env->startSection('content'); ?>
<main class="main-new-2 main-QA">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_6'])); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span class="tp-breadcrumb-link-active"><a href="url('/')"> \ <?php echo e($detail->faculty_categories->title); ?></a></span>
                            <span class="tp-breadcrumb-link-active"><a href="<?php echo e(route('FacultiesURL',['slug' => $detail->slug])); ?>"> \ <?php echo e($detail->title); ?></a></span>
                        </div>
                        <h2 class="tp-breadcrumb-title"><?php echo e($detail->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-QA">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <aside class="aside-left">
                        <?php if(!empty($FacultyCategory)): ?>
                        <?php $__currentLoopData = $FacultyCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item-sb">
                            <h3 class="title-3" style="text-transform: uppercase;"><?php echo e($item->title); ?></h3>
                            <div class="nav-item-sb">
                                <ul>
                                    <?php if(!empty($item->faculties)): ?>
                                    <?php $__currentLoopData = $item->faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('FacultiesURL',['slug' => $item->slug])); ?>"><i class="fa-solid fa-angle-right"></i><?php echo e($item->title); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </aside>
                </div>
                <div class="col-md-9 col-sm-9 col-12">
                    <div class="content-left">
                        <h1 class="title-primary"><?php echo e($detail->title); ?></h1>
                        <div class="flex-container flex-start">
                            <div style="margin-right:30px;">
                                <div class="flex-container">
                                    <div class="icon-leader"></div>
                                    <div style="align-self:center">
                                        <div>Trưởng khoa/phòng:</div>
                                        <div class="name-coso"><?php echo e($detail->truong_khoa); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex-container">
                                    <div class="icon-nv"></div>
                                    <div style="align-self:center">
                                        <div>Nhân lực:</div>
                                        <div class="name-coso"><?php echo e($detail->nhan_luc); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-content">
                            <?php echo $detail->description; ?>

                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
    .flex-container {
        padding: 0;
        margin: 0;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-flow: row wrap;
        -ms-flex-flow: row wrap;
        -moz-flex-flow: row wrap;
        flex-flow: row wrap;
        width: 100%;
        justify-content: space-between
            /* space-around;*/
        ;
    }

    .flex-start {
        justify-content: flex-start;
    }

    .icon-leader {
        background: url(http://benhvienungbuouhanoi.vn/images/icon-leader.png) no-repeat left center;
        width: 43px;
        min-height: 43px;
    }

    .icon-nv {
        background: url(http://benhvienungbuouhanoi.vn/images/icon-nv.png) no-repeat left center;
        width: 63px;
        min-height: 43px;
    }

    .name-coso {
        font-size: 18px;
        font-weight: normal;
        font-weight: bold
    }

    .name-coso {
        font-size: 18px;
        font-weight: normal;
        font-weight: bold
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/faculty/frontend/faculty/index.blade.php ENDPATH**/ ?>
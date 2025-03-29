<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-category-new pb-120 bg-gray">
    <div class="container">
        <div></div>
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">Kết quả tìm kiếm</a></li>

        </ul>
        <div class="ps-page__content">
            <?php if(!empty($data)): ?>
            <section class="modul-second-new">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-12">
                        <div class="modul-new-2 bg-white" style="margin: 0px;">
                            <div class="nav-modul-new-2">
                                <div class="row">
                                    <?php foreach ($data as $k => $item) { ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item">
                                                <div class="img">
                                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                                        <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                                    </a>
                                                </div>
                                                <div class="nav-img">
                                                    <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                                    <p class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo e($item->created_at); ?></p>
                                                    <div class="desc">
                                                        <?php echo $item->description; ?> </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="mt-10">
                                        <?php echo $data->links() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-12">
                        <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/article/frontend/search/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-category-sick pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active"><a href="<?php echo e(route('category.index')); ?>">Bệnh lý</a></li>
            <li class="ps-breadcrumb__item active"><a href="javascript:void(0)"><?php echo e($detail->title); ?></a></li>

        </ul>
        <div class="ps-page__content" style="padding-top: 0px;">
            <?php if(!empty($data)): ?>
            <div class="bottom-sick bg-white">
                <div class="ps-section__tab">
                    <div class="tab-content" id="bestsellerTabContent">
                        <div class="tab-pane fade show active" id="blood" role="tabpanel" aria-labelledby="blood-tab" style="display: block !important;">
                            <ul class="list-content" id="js_htmlBenhchuyenkhoa">
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="ps-pagination ps-pagination-benhchuyenkhoa">
                                <?php echo $__env->make('homepage.common.pagination', ['paginator' => $data, 'interval' => 2], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/page/frontend/categoryChild.blade.php ENDPATH**/ ?>
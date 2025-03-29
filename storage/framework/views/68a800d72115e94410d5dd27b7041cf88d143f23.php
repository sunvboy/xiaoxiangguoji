
<?php $__env->startSection('title'); ?>
<title>Crawler</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Crawler",
        "src" => route('product_tmps.index'),
    ],
    [
        "title" => "Danh sách",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Crawler
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <a href="<?php echo e(route('product_tmps.create')); ?>" class="btn btn-primary shadow-md mr-2">1. Lấy dữ liệu từ server</a>
            <div>
                <a href="<?php echo e(route('product_tmps.crawler')); ?>" class="btn btn-primary shadow-md mr-2">2. Crawler</a>
                <a href="<?php echo e(route('product_tmps.crawler_version')); ?>" class="btn btn-primary shadow-md mr-2" target="_blank">3. Cập nhập product_versions </a>
                <a href="<?php echo e(route('product_tmps.crawler_stock')); ?>" class="btn btn-primary shadow-md mr-2" target="_blank">4. Cập nhập product_stocks</a>
                <a href="<?php echo e(route('product_tmps.crawler_image')); ?>" class="btn btn-primary shadow-md mr-2" target="_blank">5. Download hình ảnh</a>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap text-center">ID</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <?php echo $v->id; ?>
                        </td>
                        <td>
                            <?php echo e($v->name); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            <?php echo e($data->links()); ?>

        </div>
        <!-- END: Pagination -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/product/backend/tmps/index.blade.php ENDPATH**/ ?>
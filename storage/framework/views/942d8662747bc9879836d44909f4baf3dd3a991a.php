<?php $__env->startSection('title'); ?>
<title>Thêm mới mã giảm giá</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách coupon",
        "src" => route('coupons.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0);',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới coupon
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('coupons.store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo $__env->make('coupon.common.coupon',['action' => 'create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script>
    var product_ids = '<?php echo json_encode(old('product_ids')); ?>';
    var exclude_product_ids = '<?php echo json_encode(old('exclude_product_ids')); ?>';
    var product_categories = '<?php echo json_encode(old('product_categories')); ?>';
    var exclude_product_categories = '<?php echo json_encode(old('exclude_product_categories')); ?>';
</script>
<?php echo $__env->make('coupon.common.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/coupon/create.blade.php ENDPATH**/ ?>
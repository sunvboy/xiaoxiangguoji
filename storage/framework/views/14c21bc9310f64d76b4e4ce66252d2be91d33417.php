<?php $__env->startSection('title'); ?>
<title>Cập nhập mã giảm giá</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
    $array = array(
        [
            "title" => "Danh sách coupon",
            "src" => route('coupons.index'),
        ],
        [
            "title" => "Cập nhập",
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
            Cập nhập coupon
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('coupons.update',['id'=>$detail->id])); ?>"
        method="post" enctype="multipart/form-data">
        <?php echo $__env->make('coupon.common.coupon',['action' => 'update'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>
</div>
<?php $__env->startPush('javascript'); ?>
<script>
var product_ids = '<?php echo $detail->product_ids; ?>';
var exclude_product_ids = '<?php echo $detail->exclude_product_ids; ?>';
var product_categories = '<?php echo $detail->product_categories; ?>';
var exclude_product_categories = '<?php echo $detail->exclude_product_categories; ?>';
</script>
<?php echo $__env->make('coupon.common.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/coupon/edit.blade.php ENDPATH**/ ?>
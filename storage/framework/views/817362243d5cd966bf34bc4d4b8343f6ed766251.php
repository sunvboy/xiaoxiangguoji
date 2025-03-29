<!--Start: title SEO -->
<?php $__env->startSection('title'); ?>
<title>Quản trị website</title>
<?php $__env->stopSection(); ?>
<!--END: title SEO -->
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Dashboard",
        "src" => route('admin.dashboard'),
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<!--Start: add javascript only index.html -->
<?php $__env->startSection('css-dashboard'); ?>
<?php $__env->stopSection(); ?>
<!--END: add javascript only index.html -->
<!-- START: main -->
<?php $__env->startSection('content'); ?>
<div class="content">

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/dashboard/home/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<?php echo htmlBreadcrumb($page->title); ?>

<div class="py-9 bg-[#edf0f3]">
    <div class="container">
        <div class="max-w-[448px] mx-auto flex flex-col justify-center">
            <div>
                <img src="<?php echo e(asset('images/dat-hang-thanh-cong.svg')); ?>" width="327" alt="" class="mx-auto">
            </div>
            <div class="p-4 bg-[#fff] rounded-2xl flex flex-col justify-center items-center space-y-5">
                <h3 class="text-[#022da4] font-bold text-[20px]  mb-0">Đặt hàng thành công</h3>
                <div class="text-[16px] text-center">
                    Dược sỹ sẽ liên hệ với bạn trong 5-10 phút nữa để xác nhận.
                </div>
                <a href="<?php echo e(url('/')); ?>" class="ps-btn ps-btn--warning flex w-auto">Về trang chủ</a>

            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('frontend/css/app.css')); ?>" rel="stylesheet" async>

<style>
    .breadcrumb {
        margin-bottom: 0px !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/cart/success.blade.php ENDPATH**/ ?>
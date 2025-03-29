<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 pb-120 bg-gray">
    <div id="main" class="wrapper main-login main-register">
        <div class="container">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
                <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">Quên mật khẩu</a></li>
            </ul>
            <div class="content-main-login">
                <h3 class="title-1">Quên mật khẩu</h3>
                <div class="login-left  bg-white">
                    <form action="" method="POST" id="form-auth">
                        <div>
                            <?php echo csrf_field(); ?>
                            <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($error); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                            <?php if(session('success')): ?>
                            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="item">
                            <label for="">Hãy nhập số điện Email của bạn vào bên dưới để bắt đầu quá trình khôi phục mật khẩu.</label>
                            <input type="text" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
                        </div>


                        <div class="btn-login" style="margin-top: 0px;">
                            <button id="submit-auth" type="submit" class="btn-submit-contact"><?php echo e(trans('index.ForgotPasswordSend')); ?></button>
                            <button id="submit-auth-loading" type="button" class="btn-submit-contact">Loading...</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script>
    $(function() {
        $('#submit-auth-loading').hide();
        $("#form-auth").submit(function(event) {
            $('#submit-auth').hide();
            $('#submit-auth-loading').show();
        });
    })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/customer/frontend/auth/reset-password.blade.php ENDPATH**/ ?>
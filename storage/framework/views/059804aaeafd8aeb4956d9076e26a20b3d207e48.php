<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 pb-120 bg-gray">
    <div id="main" class="wrapper main-login main-register">
        <div class="container">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
                <li class="ps-breadcrumb__item active"><a href="javascript:void(0)"><?php echo e($seo['meta_title']); ?></a></li>
            </ul>
            <div class="content-main-login">
                <h3 class="title-1"><?php echo e($seo['meta_title']); ?></h3>
                <div class="login-left  bg-white">
                    <form action="<?php echo e(route('customer.register-store')); ?>" method="POST" id="form-auth">
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
                            <label for="">Họ và tên</label>
                            <input type="text" name="name" placeholder="Họ và tên" value="<?php echo e(old('name')); ?>" required>

                        </div>
                        <div class="item">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" placeholder="Số điện thoại" value="<?php echo e(old('phone')); ?>" required>
                        </div>
                        <div class="item">
                            <label for="">Email</label>
                            <input type="text" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="item">
                            <label for="">Địa chỉ</label>
                            <input type="text" name="address" placeholder="Địa chỉ" value="<?php echo e(old('address')); ?>">
                        </div>
                        <div class="item">
                            <label for="">Mật khẩu</label>
                            <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                        </div>
                        <div class="item">
                            <label for="">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu của bạn" required>
                        </div>
                        <p class="note"><input type="checkbox" required><?php echo e(strip_tags($page->description)); ?></p>
                        <div class="btn-login">
                            <button type="submit" class="btn-submit-contact">Đăng Ký</button>
                        </div>
                        <div class="item" style="padding-top: 20px;">
                            Bạn chưa đã tài khoản? <a href="<?php echo e(route('customer.login')); ?>" style="color:#022da4">Đăng nhập ngay</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/customer/frontend/auth/register.blade.php ENDPATH**/ ?>
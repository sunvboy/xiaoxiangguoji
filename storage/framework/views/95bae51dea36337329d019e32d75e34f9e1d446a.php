<!DOCTYPE html>
<html class="bg-black">

<head>
    <meta charset="UTF-8">
    <title>Admin | <?php echo e(env('BE_TITLE_SEO')); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="<?php echo e(asset('backend/css/app.css')); ?>" />

</head>

<body class="login">
    <div class="container">
        <div class="w-full min-h-screen p-5 md:p-20 flex items-center justify-center">
            <div class="w-96 ">
                <img class="mx-auto w-16" alt="<?php echo e(env('BE_TITLE_SEO')); ?>" src="<?php echo e(asset('backend/images/logo.svg')); ?>">
                <div class="text-white dark:text-slate-300 text-2xl font-medium text-center mt-2">Đăng nhập quản trị
                    website</div>
                <div
                    class="box px-5 py-8 mt-10 max-w-[450px] relative before:content-[''] before:z-[-1] before:w-[95%] before:h-full before:bg-slate-200 before:border before:border-slate-200 before:-mt-5 before:absolute before:rounded-lg before:mx-auto before:inset-x-0 before:dark:bg-darkmode-600/70 before:dark:border-darkmode-500/60">
                    <form action="<?php echo e(route('admin.login-store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" icon-name="alert-triangle" data-lucide="alert-triangle"
                                class="lucide lucide-alert-triangle w-6 h-6 mr-2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z">
                                </path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg> <b>Success!</b> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" icon-name="x" data-lucide="x"
                                    class="lucide lucide-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg> </button>
                        </div>
                        <?php endif; ?>
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon"
                                class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                                <polygon
                                    points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="btn-close text-white" data-tw-dismiss="alert"
                                aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x"
                                    class="lucide lucide-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <?php endif; ?>
                        <input type="text" class="form-control py-3 px-4 block" placeholder="Email"
                            value="<?php echo e(old('email')); ?>" name="email">
                        <input type="password" class="form-control py-3 px-4 block mt-4" placeholder="Mật khẩu"
                            name="password">
                        <div class="text-slate-500 flex text-xs sm:text-sm mt-4 justify-end">
                            <div class="flex items-center mr-auto hidden">
                                <input type="checkbox" class="form-check-input border mr-2" id="remember-me">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div>
                            <a href="<?php echo e(route('admin.reset-password')); ?>">Quên mật khẩu?</a>
                        </div>
                        <div class="mt-5 xl:mt-8 text-center">
                            <button class="btn btn-primary w-full xl:mr-3" type="submit">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="<?php echo e(asset('backend/js/app.js')); ?>"></script>
    <!-- END: JS Assets-->
</body>

</html><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/user/backend/auth/login.blade.php ENDPATH**/ ?>
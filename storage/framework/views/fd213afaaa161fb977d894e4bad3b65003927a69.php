<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-infomation pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active"><a href="<?php echo e(route('customer.updateInformation')); ?>"><?php echo e($seo['meta_title']); ?></a></li>

        </ul>
        <div class="content-infomation">

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php echo $__env->make('customer/frontend/auth/common/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="content-information-1  bg-white">
                        <h2 class="title-2"><?php echo e($seo['meta_title']); ?></h2>
                        <div class="img">
                            <img src="<?php echo e(asset('frontend/img/avatar-profile.svg')); ?>" alt="">
                        </div>
                        <div class="form">

                            <div class="nav-form">
                                <ul>
                                    <li>
                                        <span class="span-1">Họ và tên:</span>
                                        <span class="span-2"><?php echo e($detail->name); ?></span>
                                    </li>
                                    <li>
                                        <span class="span-1">Số điện thoại:</span>
                                        <span class="span-2"><?php echo e($detail->phone); ?></span>
                                    </li>
                                    <li>
                                        <span class="span-1">Email:</span>
                                        <span class="span-2"><?php echo e($detail->email); ?></span>
                                    </li>
                                    <li>
                                        <span class="span-1">Ngày sinh:</span>
                                        <span class="span-2"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d', $detail->birthday)->format('d/m/Y')); ?></span>
                                    </li>
                                    <li>
                                        <span class="span-1">Địa chỉ:</span>
                                        <span class="span-2"><?php echo e($detail->address); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="change-information change-information-1">
                            <button>Thay đổi thông tin</button>
                        </div>
                        <form id="form-information" class="content-change-information">
                            <?php echo csrf_field(); ?>
                            <div>
                                <div class="alert alert-danger" style="display: none;">

                                </div>
                                <div class="alert alert-success" style="display: none;">

                                </div>
                            </div>
                            <div class="item-child">
                                <label for="">Họ và tên</label>
                                <input type="text" name="name" value="<?php echo e($detail->name); ?>">
                            </div>
                            <div class="item-child">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" value="<?php echo e($detail->phone); ?>">
                            </div>
                            <div class="item-child">
                                <label for="">Email</label>
                                <input type="text" name="email" value="<?php echo e($detail->email); ?>" disabled>
                            </div>
                            <div class="item-child">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="address" value="<?php echo e($detail->address); ?>">
                            </div>
                            <div class="item-sex">
                                <label for="">Giới tính</label>
                                <ul>
                                    <li>
                                        <input type="radio" name="gender" value="male" <?php if($detail->gender == 'male'): ?> checked <?php endif; ?>>Nam
                                    </li>
                                    <li>
                                        <input type="radio" name="gender" value="female" <?php if($detail->gender == 'female'): ?> checked <?php endif; ?>>Nữ
                                    </li>
                                </ul>
                            </div>
                            <div class="item-child">
                                <label for="">Ngày sinh</label>
                                <input type="date" name="birthday" value="<?php echo e($detail->birthday); ?>">
                            </div>
                            <div class="change-information">
                                <button type="submit" class="js_submit_information">Cập nhật thông tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script>
    $(document).ready(function() {
        $(".js_submit_information").click(function(e) {
            e.preventDefault();
            var _token = $("#form-information input[name='_token']").val();
            var name = $("#form-information input[name='name']").val();
            var phone = $("#form-information input[name='phone']").val();
            var address = $("#form-information input[name='address']").val();
            var gender = $("#form-information input[name='gender']").val();
            var birthday = $("#form-information input[name='birthday']").val();
            $.ajax({
                url: "<?php echo route('customer.updateInformation') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    name: name,
                    phone: phone,
                    address: address,
                    birthday: birthday,
                    gender: gender,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-information .alert-danger").css('display', 'none');
                        $("#form-information .alert-success").css('display', 'block');
                        $("#form-information .alert-success").html("<?php echo trans('index.InformationSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-information .alert-danger").css('display', 'block');
                        $("#form-information .alert-success").css('display', 'none');
                        $("#form-information .alert-danger").html(data.error);
                    }
                }
            });
        });
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/customer/frontend/manager/information.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>

<main class="main-new-2 main-book">

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_2'])); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span> \ <?php echo e($page->title); ?></span>
                        </div>
                        <h2 class="tp-breadcrumb-title"><?php echo e($page->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content-box">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="content-box-left">
                        <?php echo $page->description; ?>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-right">
                        <h3 class="title-4">ĐẶT LỊCH KHÁM</h3>
                        <form action="" class="form-subscribe">
                            <?php echo csrf_field(); ?>
                            <div class="alert alert-danger print-error-msg " style="display: none">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline"></span>
                            </div>
                            <div class="alert alert-success print-success-msg" style="display: none">
                                <span class="font-bold"></span>
                            </div>
                            <input type="text" placeholder="Họ và tên" name="fullname">
                            <input type="text" placeholder="Số điện thoại" name="phone">
                            <input type="text" placeholder="Email" name="email">
                            <textarea name="message" id="" placeholder="Triệu chứng"></textarea>
                            <div class="btn">
                                <button class="btn-submit">Đăng ký ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo route('contactFrontend.subcribers') ?>",
                type: 'POST',
                data: {
                    _token: $(".form-subscribe input[name='_token']").val(),
                    fullname: $(".form-subscribe input[name='fullname']").val(),
                    email: $(".form-subscribe input[name='email']").val(),
                    phone: $(".form-subscribe input[name='phone']").val(),
                    message: $(".form-subscribe textarea[name='message']").val(),
                },
                success: function(data) {
                    if (data.status == 200) {
                        $(".form-subscribe .print-error-msg").css('display', 'none');
                        $(".form-subscribe .print-success-msg").css('display', 'block');
                        $(".form-subscribe .print-success-msg span").html("<?php echo $fcSystem['message_1'] ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        $(".form-subscribe .print-error-msg").css('display', 'block');
                        $(".form-subscribe .print-success-msg").css('display', 'none');
                        $(".form-subscribe .print-error-msg span").html(data.error);
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/page/frontend/order.blade.php ENDPATH**/ ?>
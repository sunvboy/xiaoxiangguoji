<div class="item-sb item-sb-form">
    <h3 class="title-3"><?php echo e($fcSystem['title_4']); ?></h3>
    <div class="nav-item-sb">
        <p class="desc-1"><?php echo e($fcSystem['title_5']); ?></p>
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
<!-- end: box 9-->
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
<?php $__env->stopPush(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/homepage/common/subscribers.blade.php ENDPATH**/ ?>
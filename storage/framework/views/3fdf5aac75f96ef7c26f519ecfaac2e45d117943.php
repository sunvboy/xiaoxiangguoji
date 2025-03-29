<?php
$coursesAll = \App\Models\Course::select('id', 'title', 'slug', 'image')->where(['alanguage' => config('app.locale'), 'publish' => 0])->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
$address = \App\Models\Address::select('id', 'title')->where(['alanguage' => config('app.locale'), 'publish' => 0])->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
$title = !empty($title) ? $title : $fcSystem['title_35'];
?>
<div class="item-aside mb-[15px] md:mb-[25px] border border-gray-200 rounded-[10px] p-[15px]">
    <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
        <?php echo e($title); ?>

    </h3>
    <div class="nav-post">
        <form action="" class="form-subscribe">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('homepage.common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <input type="text" name="fullname" placeholder="<?php echo e($fcSystem['title_29']); ?>" class="w-full px-4 h-[40px] border border-gray-200 mb-[15px]">
            <input type="text" name="phone" placeholder="<?php echo e($fcSystem['title_21']); ?>" class="w-full px-4 h-[40px] border border-gray-200 mb-[15px]">
            <input type="text" name="email" placeholder="Email" class="px-4 w-full h-[40px] border border-gray-200 mb-[15px]">
            <div class="item <?php if(!empty($course_id)): ?> hidden <?php endif; ?>">
                <label class="text-color_primary"><?php echo e($fcSystem['title_30']); ?></label>
                <select name="course" class="w-full h-[40px] border border-gray-200 mb-[15px] mt-[10px] px-3">
                    <?php if(!empty($coursesAll) && count($coursesAll) > 0): ?>
                    <?php $__currentLoopData = $coursesAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->title); ?>" <?php if (!empty($course_id) && $course_id == $item->id) { ?> selected <?php } ?>><?php echo e($item->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="item ">
                <label for="" class="text-color_primary inline-block w-full mb-[10px]"><?php echo e($fcSystem['title_31']); ?></label>
                <select name="address" id="" class="w-full h-[40px] border border-gray-200 mb-[15px] px-3">
                    <?php if(!empty($address) && count($address) > 0): ?>
                    <?php $__currentLoopData = $address; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->title); ?>"><?php echo e($item->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="item ">
                <label for="" class="text-color_primary inline-block w-full mb-[10px]"><?php echo e($fcSystem['title_32']); ?></label>
                <input type="text" name="message" placeholder="<?php echo e($fcSystem['title_33']); ?>" class="px-4 w-full h-[40px] border border-gray-200 mb-[15px]">
                <input type="text" name="code" placeholder="<?php echo e($fcSystem['title_34']); ?>" class="px-4 w-full h-[40px] border border-gray-200 mb-[15px] hidden">
            </div>
            <input type="submit" value="<?php echo e($fcSystem['title_35']); ?>" class="btn-submit w-full h-[40px] bg-color_primary text-white border border-color_primary transition-all hover:bg-white hover:text-color_primary">
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
                    address: $(".form-subscribe select[name='address']").val(),
                    message: $(".form-subscribe input[name='message']").val(),
                    code: $(".form-subscribe input[name='code']").val(),
                    course: $(".form-subscribe select[name='course']").val(),
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
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/subscribers.blade.php ENDPATH**/ ?>
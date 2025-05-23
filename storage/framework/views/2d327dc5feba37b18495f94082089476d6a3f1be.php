<a class="click-li-bell text-f16" href="javascript:void(0)">
    <i class="fa-solid fa-bell text-f25"></i>
    <?php if(count($notifications) > 0): ?>
    <span class="absolute bg-red-700 w-4 h-4 text-center leading-[25px] rounded-full text-white -top-1 -right-1 text-[10px] flex justify-center items-center">
        <?php if(count($notifications) > 9): ?>
        9+
        <?php else: ?>
        <?php echo e(count($notifications)); ?>

        <?php endif; ?>
    </span>
    <?php endif; ?>

</a>
<?php if(!empty($notifications) && count($notifications) > 0): ?>
<ul class="nav-sub-bell absolute bg-white right-0 top-[43px] z-10 shadow transition-all" style="width: 300px">
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="p-[10px] border-b border-gray-200">
        <a href="<?php echo e(route('quizzes.frontend.answer',['slug' => $item->QuestionOptionUser->quizzes->slug,'id' => $item->question_option_user_id,'notifications' => $item->id])); ?>" class="transition-all hover:text-color_primary">
            <div class="nav-img">
                <h3 class="text-f15 leading-[22px] h-[44px] overflow-hidden font-semibold">
                    <?php echo e($item->message); ?>

                </h3>
                <p class="date text-f13 text-gray-700 mt-[2px]">
                    <i class="fa-solid fa-calendar-days"></i>
                    <?php echo e($item->created_at); ?>

                </p>
            </div>
        </a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <li class="view-all text-center p-[10px]">
        <a href="<?php echo e(route('notification.frontend.index')); ?>" class="bold-1 hover:text-color_primary transition-all">Xem tất cả<i class="fa-solid fa-chevron-right ml-[5px] text-f12"></i></a>
    </li>
</ul>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/mobile/notifications.blade.php ENDPATH**/ ?>
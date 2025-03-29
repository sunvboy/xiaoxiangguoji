<a href="<?php echo e(route('notification.frontend.index')); ?>" class="text-white text-f23 inline-block relative w-[30px]">
    <i class="fa-solid fa-bell mr-[5px]"></i>
    <?php if(count($notifications) > 0): ?>
    <span class="bg-red-700 text-f12 w-[23px] h-[23px] rounded-full inline-block text-center top-[-10px] right-[-3px] leading-[23px] absolute">
        <?php if(count($notifications) > 9): ?>
        9+
        <?php else: ?>
        <?php echo e(count($notifications)); ?>

        <?php endif; ?>
    </span>
    <?php endif; ?>
</a>
<?php if(!empty($notifications) && count($notifications) > 0): ?>
<div class="sub-bell absolute right-0  bg-white rounded-md shadow-lg overflow-hidden z-20" style="width:20rem;">
    <div class="py-2">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <a <?php if (!empty($item->QuestionOptionUser)) { ?> href="<?php echo e(route('quizzes.frontend.answer',['slug' => $item->QuestionOptionUser->quizzes->slug,'id' => $item->question_option_user_id,'notifications' => $item->id])); ?>" <?php } ?> class="flex flex-col px-4 py-3 border-b hover:bg-gray-100 <?php if($item->view == 1): ?> bg-white <?php else: ?> bg-gray-200 <?php endif; ?>">
            <p class="text-gray-600 text-sm">
                <span class="font-bold"><?php echo e($item->message); ?></span>
            </p>
            <div class="text-xs text-blue-600 dark:text-blue-500"><?php echo e($item->created_at); ?></div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <a href="<?php echo e(route('notification.frontend.index')); ?>" class="block bg-primary text-white text-center font-bold py-2">Xem tất cả</a>
</div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/notifications.blade.php ENDPATH**/ ?>
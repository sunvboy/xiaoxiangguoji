<?php
$courseCategory = \App\Models\CourseCategory::where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])->get();
?>
<?php if(!empty($courseCategory) && count($courseCategory) > 0): ?>
<div class="<?php echo e(!empty($class) ? $class : 'item-aside mb-[15px] md:mb-[25px]'); ?>">
    <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
        <?php echo e($fcSystem['title_15']); ?>

    </h3>
    <ul>
        <?php $__currentLoopData = $courseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="mb-[10px] transition-all hover:pl-[15px]">
            <a href="<?php echo e($item->slug); ?>" class="hover:text-color_primary transition-all"><i class="fa-solid fa-right-long mr-[10px]"></i><?php echo e($item->title); ?></a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/courseCategory.blade.php ENDPATH**/ ?>
<?php if(!empty($data) && count($data) > 0): ?>
<div class="scrollBar">
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    if ($item->type == 1) {
        $color = "#ea580c";
    } else if ($item->type == 2) {
        $color = "#4f46e5";
    } else if ($item->type == 3) {
        $color = "#059669";
    } else if ($item->type == 4) {
        $color = "#059669";
    } else if ($item->type == 5) {
        $color = "#059669";
    }

    ?>
    <div class="border-b py-2">
        <a class="font-bold js_handleAddAutocomplete" href="javascript:void(0)" data-id="<?php echo $item->id; ?>"><span class="font-bold" style="color: <?php echo e($color); ?>"><?php echo e($item->code); ?></span><br> <?php echo $item->title; ?></a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
    <?php echo e($data->links()); ?>

</div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/question/autocomplete.blade.php ENDPATH**/ ?>
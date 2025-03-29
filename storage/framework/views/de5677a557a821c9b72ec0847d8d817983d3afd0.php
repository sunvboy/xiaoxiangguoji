<?php $__env->startSection('title'); ?>
<title>Cấu hình</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => 'javascript:void(0)',
    ],
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="box p-6 mt-7 flex flex-col items-center" style="padding:24px">

        <div class="grid grid-cols-12 gap-6 w-full ">
            <?php $__currentLoopData = config('generals'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(in_array($item['module'], $dropdown)): ?>
            <?php if(!empty($item['permission'])): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($item['permission'])): ?>
            <a href="<?php echo e(route($item['href'])); ?>" class="col-span-3 px-4 py-3 flex" style="background-color: #F2F9FF">
                <div class="" style="width: 32px;">
                    <?php echo $item['svg'] ?>
                </div>
                <div class="flex-1 ml-2 ">
                    <h6 class="font-bold"><?php echo e($item['name']); ?></h6>
                    <div class="mt-1">
                        <?php echo e($item['description']); ?>

                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php else: ?>
            <a href="<?php echo e(route($item['href'])); ?>" class="col-span-3 px-4 py-3 flex" style="background-color: #F2F9FF">
                <div class="" style="width: 32px;">
                    <?php echo $item['svg'] ?>
                </div>
                <div class="flex-1 ml-2 ">
                    <h6 class="font-bold"><?php echo e($item['name']); ?></h6>
                    <div class="mt-1">
                        <?php echo e($item['description']); ?>

                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/general/index.blade.php ENDPATH**/ ?>
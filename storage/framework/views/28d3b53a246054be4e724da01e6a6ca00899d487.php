<?php $__env->startSection('title'); ?>
<title>Cấu hình đơn hàng</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Cấu hình đơn hàng",
        "src" => route('orders.config'),
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Cấu hình đơn hàng
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap text-center">ID</th>
                        <th class="whitespace-nowrap">Tiêu đề</th>
                        <th class="whitespace-nowrap">Vị trí</th>
                        <th class="whitespace-nowrap">Hiển thị</th>
                        <th class="whitespace-nowrap ">#</th>
                    </tr>
                </thead>
                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <?php echo e($v->id); ?>

                        </td>
                        <td>
                            <?php echo e($v->title); ?>

                        </td>
                        <?php echo $__env->make('components.order',['module' => 'order_configs'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <td>
                            <?php echo $__env->make('components.publishTable',['module' => 'order_configs','title' => 'publish','id' =>
                            $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </td>
                        <td class="">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_edit')): ?>
                            <a class="flex items-center mr-3" href="<?php echo e(route('orders.configEdit',['id'=>$v->id])); ?>">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                Edit
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/order/config/index.blade.php ENDPATH**/ ?>
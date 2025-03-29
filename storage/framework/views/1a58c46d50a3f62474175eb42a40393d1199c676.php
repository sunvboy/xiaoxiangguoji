
<?php $__env->startSection('title'); ?>
<title>Cấp bậc thành viên</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Cấp bậc thành viên",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cấp bậc thành viên
        </h1>
    </div>
    <?php if(empty($detail)): ?>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('customer_levels.store')); ?>" method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>
    <?php else: ?>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('customer_levels.update',['id' => $detail->id])); ?>" method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Cập nhập</button>
                </div>
            </div>
        </div>
    </form>

    <?php endif; ?>


    <div class=" col-span-12 lg:col-span-12">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="text-center">Tiêu đề</th>
                    <th>Vị trí</th>
                    <th>Ngày tạo</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="odd " id="post-<?php echo $v->id; ?>">
                    <td class="whitespace-nowrap text-left">
                        <?php echo e($v->title); ?>

                    </td>
                    <?php echo $__env->make('components.order',['module' => $module], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <td class="whitespace-nowrap">
                        <?php echo e($v->created_at); ?>

                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="<?php echo e(route('customer_levels.index',['id'=>$v->id])); ?>">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                Edit
                            </a>
                            <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/customer/backend/level/index.blade.php ENDPATH**/ ?>
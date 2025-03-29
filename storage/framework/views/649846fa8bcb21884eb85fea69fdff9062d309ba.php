<?php $__env->startSection('title'); ?>
<title>Cập nhập nhóm thành viên</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
    $array = array(
        [
            "title" => "Danh sách nhóm thành viên",
            "src" => route('roles.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('roles.update',['id' => $detailRole->id])); ?>"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label text-base font-semibold">Tên nhóm thành viên</label>
                    <?php echo Form::text('title', $detailRole->title, ['class' => 'form-control w-full ']); ?>
                </div>

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::text('description', $detailRole->description, ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>

            </div>
            <!-- END: Album Ảnh -->
            <div class=" box p-5 mt-3 space-y-5">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="grid grid-cols-12 ">
                    <div class="col-span-12 md:col-span-4">
                        <label
                            class="form-label text-base font-semibold"><?php echo e(config('permissions.modules')[$v->title]); ?></label>
                    </div>
                    <?php $__currentLoopData = $v->permissionsChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($val->title != 'Copy hình ảnh' && $val->title != 'Di chuyển hình ảnh'): ?>

                    <div class="col-span-12 xl:col-span-2">
                        <label for="check<?php echo e($val->id); ?>">
                            <input <?php echo e($permissionChecked->contains('id',$val->id) ? 'checked' : ''); ?>

                                name="permission_id[]" type="checkbox" class="inputChild" value="<?php echo e($val->id); ?>"
                                id="check<?php echo e($val->id); ?>" />
                            <?php echo e(!empty(config('permissions.actions')[$val->title])?config('permissions.actions')[$val->title]:$val->title); ?>

                        </label>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/user/backend/role/edit.blade.php ENDPATH**/ ?>
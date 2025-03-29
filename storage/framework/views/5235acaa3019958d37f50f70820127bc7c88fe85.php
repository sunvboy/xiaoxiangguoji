<?php $__env->startSection('title'); ?>
<title>Quản lý vận chuyển</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(

    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Quản lý vận chuyển",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- END: Data List -->
            <div class=" col-span-12">
                <div class="flex justify-between flex-wrap sm:flex-nowrap items-center">
                    <div class="">
                        <h2 class=" text-lg font-medium">Quản lý vận chuyển</h2>
                    </div>
                    <div class="">
                        <?php if(env('APP_ENV') == "local"): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ships_create')): ?>
                        <a href="<?php echo e(route('ships.create')); ?>" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- BEGIN: Data List -->
                <div class=" col-span-12 overflow-auto lg:overflow-visible">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                                <th class="whitespace-nowrap">HIỂN THỊ</th>
                                <th class="whitespace-nowrap">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="odd " id="post-<?php echo $v->id; ?>">

                                <td>
                                    <div class="flex justify-center items-center">
                                        <div class="w-10 h-10 image-fit zoom-in mr-2">
                                            <?php if(!empty($v->image)): ?>
                                            <img class=" rounded-full" src="<?php echo e(asset($v->image)); ?>" style="object-fit: contain;">
                                            <?php else: ?>
                                            <img class=" rounded-full" src="<?php echo e(asset('images/404.png')); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 text-left">
                                            <?php if($v->id == 3): ?>
                                            <a class="flex items-center mr-3" href="<?php echo e(route('ships.index_province')); ?>">
                                                <?php echo $v->title; ?>
                                            </a>
                                            <?php else: ?>
                                            <?php echo $v->title; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-40">
                                    <?php echo $__env->make('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                                    $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <?php if($v->id == 3): ?>
                                        <a class="flex items-center mr-3" href="<?php echo e(route('ships.index_province')); ?>">
                                            <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                            Quản lý
                                        </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ships_edit')): ?>
                                        <a class="flex items-center mr-3" href="<?php echo e(route('ships.edit',['id'=>$v->id])); ?>">
                                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                            Edit
                                        </a>
                                        <?php endif; ?>
                                        <?php if(env('APP_ENV') == "local"): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ships_destroy')): ?>
                                        <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                            Delete
                                        </a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/ship/backend/index.blade.php ENDPATH**/ ?>
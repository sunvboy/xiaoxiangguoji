
<?php $__env->startSection('title'); ?>
<title>Danh sách bài đã thi</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách bài đã thi",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="flex justify-between mt-10 items-center">
        <h1 class=" text-lg font-medium ">
            Danh sách bài đã thi
        </h1>
        <div class="flex items-center space-x-2">

            <a href="<?php echo e(route('question_option_users.export',[
            'customer_categories_id' => request()->get('customer_categories_id'),
            'customer_id' => request()->get('customer_id'),
            'quiz_id' => request()->get('quiz_id'),
            'keyword'=>request()->get('keyword')
            ])); ?>" class="btn btn-success shadow-md text-white">Xuất excel</a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <div class="flex space-x-2 ">
                <?php /*  @if(empty($catalogue))
                <select class="flex-auto form-control ajax-delete-all mr10 w-36" style="height:42px" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
                    <option>Hành động</option>
                    <option value="">Xóa</option>
                </select>
                @endif*/ ?>
                <form action="" class="justify-between flex-1 grid grid-cols-12 gap-2" id="search" style="margin-bottom: 0px;">
                    <?php if(!empty($customer_categories)): ?>
                    <div class="mr10 col-span-4">
                        <?php echo Form::select('customer_categories_id', $customer_categories, request()->get('customer_categories_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($customers)): ?>
                    <div class="mr10 col-span-4">
                        <?php echo Form::select('customer_id', $customers, request()->get('customer_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($quizzes)): ?>
                    <div class="mr10 col-span-4">
                        <?php echo Form::select('quiz_id', $quizzes, request()->get('quiz_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    <?php endif; ?>
                    <input type="search" name="keyword" class="keyword form-control filter col-span-2" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
                    <button class="flex-auto btn btn-primary col-span-1">
                        <i data-lucide="search"></i>
                    </button>
                </form>

            </div>

        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;" class="hidden">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Thành viên</th>
                        <th class="whitespace-nowrap">Bài thi</th>
                        <th class="whitespace-nowrap">Trạng thái</th>
                        <th class="whitespace-nowrap">Điểm</th>
                        <th class="whitespace-nowrap">NGÀY THI</th>
                        <th class="whitespace-nowrap text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td class="hidden">
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        <td>
                            <?php echo e($data->firstItem()+$loop->index); ?>

                        </td>
                        <td>
                            <?php if(!empty($v->customer)): ?>
                            <span class="font-bold"><?php echo e($v->customer->name); ?></span><br>
                            <?php echo e($v->customer->customer_categories->title); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($v->quizzes)): ?>
                            <a class="font-bold text-primary underline" href="<?php echo e(route('question_option_users.edit',['id' => $v->id])); ?>"><?php echo e($v->quizzes->title); ?></a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($v->status == 'wait')): ?>
                            <a class="font-bold btn btn-danger btn-sm text-white" href="javascript:void(0)">Chưa chấm</a>
                            <?php else: ?>
                            <a class="font-bold btn btn-success btn-sm text-white" href="javascript:void(0)">Đã chấm</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($v->status == 'success')): ?>
                            <?php echo e($v->score_total); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($v->created_at): ?>
                            <?php echo e(Carbon\Carbon::parse($v->created_at)->diffForHumans()); ?>

                            <?php endif; ?>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_option_users_edit')): ?>
                                <a class="flex items-center mr-3" href="<?php echo e(route('question_option_users.edit',['id'=>$v->id])); ?>">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Chấm bài
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quizzes_destroy')): ?>
                                <a class="flex items-center text-danger ajax-delete hidden" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            <?php echo e($data->links()); ?>

        </div>
        <!-- END: Pagination -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/customer/index.blade.php ENDPATH**/ ?>
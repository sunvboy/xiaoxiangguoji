<?php $__env->startSection('title'); ?>

<title>Danh sách nhóm câu hỏi thường gặp</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>

<?php

$array = array(

    [

        "title" => "Danh sách nhóm câu hỏi thường gặp",

        "src" => 'javascript:void(0)',

    ]

);

echo breadcrumb_backend($array);

?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <h1 class=" text-lg font-medium mt-10">

        Danh sách câu hỏi thường gặp

    </h1>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">

            <?php echo $__env->make('components.search',['module'=>$module], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faqs_create')): ?>

            <a href="<?php echo e(route('faq_categories.create')); ?>" class="btn btn-primary shadow-md mr-2">Thêm mới</a>

            <?php endif; ?>

        </div>

        <!-- BEGIN: Data List -->

        <div class=" col-span-12 overflow-auto lg:overflow-visible">

            <table class="table table-report -mt-2">

                <thead>

                    <tr>

                        <th style="width:40px;">

                            <input type="checkbox" id="checkbox-all">

                        </th>

                        <th class="whitespace-nowrap">STT</th>

                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>

                        <th class="whitespace-nowrap">VỊ TRÍ</th>

                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>

                        <th class="whitespace-nowrap">NGÀY TẠO</th>


                        <th class="whitespace-nowrap">#</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr class="odd " id="post-<?php echo $v->id; ?>">

                        <td>

                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">

                        </td>

                        <td>

                            <?php echo e($data->firstItem()+$loop->index); ?>


                        </td>

                        <td>
                            <?php echo $v->title; ?>

                        </td>


                        <td>

                            <?php echo e(!empty($v->user) ? $v->user->name : ''); ?>


                        </td>

                        <?php echo $__env->make('components.order',['module' => $module], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



                        <td>

                            <?php if($v->created_at): ?>

                            <?php echo e(Carbon\Carbon::parse($v->created_at)->diffForHumans()); ?>


                            <?php endif; ?>

                        </td>


                        <td class="table-report__action w-56">

                            <div class="flex justify-center items-center">

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faqs_edit')): ?>

                                <a class="flex items-center mr-3" href="<?php echo e(route('faq_categories.edit',['id'=>$v->id])); ?>">

                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>

                                    Edit

                                </a>

                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faqs_destroy')): ?>

                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">

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
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/faq/backend/category/index.blade.php ENDPATH**/ ?>
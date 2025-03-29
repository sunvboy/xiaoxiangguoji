<?php $__env->startSection('title'); ?>
<title>Danh sách tags</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách tags",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách tags
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <?php echo $__env->make('components.search',['module'=>$module,'configIs' => $configIs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tags_create')): ?>
            <a href="<?php echo e(route('tags.create')); ?>" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
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
                        <th class="whitespace-nowrap">MODULE</th>
                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>

                        <th class="whitespace-nowrap">HIỂN THỊ</th>
                        <?php echo $__env->make('components.table.is_thead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php /* if (in_array('articles', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Bài viết nổi bật</th>
                        <?php }?>
                        <?php if (in_array('products', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Sản phẩm nổi bật</th>
                        <?php }?>
                        <?php if (in_array('tours', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Tour nổi bật</th>
                        <?php }*/ ?>

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
                            <a href="<?php echo e(route('tagURL',['slug' => $v->slug])); ?>" target="_blank"><?php echo $v->title; ?></a>
                        </td>

                        <?php echo $__env->make('components.order',['module' => $module], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <td>
                            <?php echo $v->module; ?>
                        </td>
                        <td>
                            <?php echo e($v->user->name); ?>

                        </td>
                        <td>
                            <?php if($v->created_at): ?>
                            <?php echo e(Carbon\Carbon::parse($v->created_at)->diffForHumans()); ?>

                            <?php endif; ?>
                        </td>
                        <td class="w-40">
                            <?php echo $__env->make('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </td>
                        <?php echo $__env->make('components.table.is_tbody', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php /* if (in_array('articles', $dropdown)) { ?>
                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isArticle','id' =>
                            $v->id])
                        </td>
                        <?php }?>
                        <?php if (in_array('products', $dropdown)) { ?>

                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isProduct','id' =>
                            $v->id])
                        </td>
                        <?php }?>
                        <?php if (in_array('tours', $dropdown)) { ?>

                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isTour','id' =>
                            $v->id])
                        </td>
                        <?php }*/ ?>

                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tags_edit')): ?>
                                <a class="flex items-center mr-3" href="<?php echo e(route('tags.edit',['id'=>$v->id])); ?>">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tags_destroy')): ?>
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
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/tag/backend/tag/index.blade.php ENDPATH**/ ?>
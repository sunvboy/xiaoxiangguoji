<?php $__env->startSection('title'); ?>
<title>Danh sách sản phẩm</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách sản phẩm",
        "src" => route('products.index'),
    ],
    [
        "title" => "Danh sách",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class="text-lg font-medium mt-10">
        Danh sách sản phẩm
    </h1>
    <div class=" grid grid-cols-12 gap-2 justify-between mt-5 mb-5">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_create')): ?>
        <div class="col-span-12 flex justify-end space-x-2">
            <a class="full-search btn btn-danger " href="javascript:void(0);">Tìm kiếm nâng cao</a>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary shadow-md">Thêm mới</a>
            <a href="<?php echo e(route('products.export')); ?>" class="btn btn-primary shadow-md hidden">Export excel</a>
        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_destroy')): ?>
        <?php if(empty($catalogue)): ?>
        <select class="form-control ajax-delete-all-product mr10 col-span-2 " data-title="Lưu ý: Khi bạn xóa danh sách sản phẩm, toàn bộ sản phẩm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!">
            <option>Hành động</option>
            <option value="">Xóa</option>
        </select>
        <?php endif; ?>
        <?php endif; ?>
        <?php if(isset($configIs)): ?>
        <div class="col-span-2">
            <select class="form-control mr10 filter" name="type">
                <option value="" selected>Chọn hiển thị</option>
                <?php $__currentLoopData = $configIs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->type); ?>" <?php if (!empty(request()->get('type')) && request()->get('type') == $value->module) { ?>selected<?php } ?>><?php echo e($value->title); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>
        <?php if(isset($catalogues)): ?>
        <div class="col-span-4">
            <?php echo Form::select('catalogue_id', $catalogues, request()->get('catalogue_id'), ['class' => 'form-control tom-select tom-select-custom filter catalogue_id ', 'data-placeholder' => "Select your favorite actors"]); ?>
        </div>
        <?php endif; ?>
        <input type="search" name="keyword" class="keyword form-control filter col-span-4" placeholder="Tên sản phẩm, mã sản phẩm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
    </div>
    <!-- START: tìm kiếm -->
    <div class="mb10 row filter-more grid grid-cols-12 gap-6 justify-between mt-5 hidden">
        <div class="col-span-4">
            <label class="form-label text-base font-semibold">Nhập khoảng giá</label>
            <div class="sm:grid grid-cols-2 gap-2">
                <div class="input-group">
                    <div class="input-group-text">Từ</div>
                    <input type="text" class="form-control int filter h-10" name="start_price" value="">
                </div>
                <div class="input-group">
                    <div class="input-group-text">Đến</div>
                    <input type="text" class="form-control int filter h-10" name="end_price" value="">
                </div>
            </div>
        </div>
        <div class="col-span-4  <?php if (!in_array('tags', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Tags</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm tag..." data-header="Tags" multiple="multiple" name="tags[]" tabindex="-1" hidden="hidden">
                <?php if(isset($tags)): ?>
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tag->id); ?>">
                    <?php echo e($tag->title); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-span-4 <?php if (!in_array('brands', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Thương hiệu</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm thương hiệu..." data-header="Thương hiệu" multiple="multiple" name="brands[]" tabindex="-1" hidden="hidden">
                <?php if(isset($brands)): ?>
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($brand->id); ?>">
                    <?php echo e($brand->title); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-span-12" id="selected_attr"></div>
        <div class="col-span-12">
            <div id="choose_attr">
                <label class="form-label text-base font-semibold">Thuộc tính</label>
                <input type="text" class="hidden filter" name="attr" value="">
                <ul class="list_attr_catalogue bg-white p-3" style="display: none">
                </ul>
            </div>
        </div>
    </div>
    <!-- END: tìm kiếm -->
    <div class="grid grid-cols-12 gap-6 ">
        <div id="data_product" class="col-span-12 overflow-auto lg:overflow-visible">
            <?php echo $__env->make('product.backend.product.index.data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<?php echo $__env->make('product.backend.product.index.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/backend/product/index.blade.php ENDPATH**/ ?>
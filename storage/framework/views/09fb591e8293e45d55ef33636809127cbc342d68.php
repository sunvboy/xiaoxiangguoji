<?php
$code = CodeRender('products');
$title = !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : '');
$slug = !empty(old('slug')) ? old('slug') : (!empty($detail->slug) ? $detail->slug : '');
$code = !empty(old('code')) ? old('code') : (!empty($detail->code) ? $detail->code : CodeRender('products'));
$description = !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : '');
$content = !empty(old('content')) ? old('content') : (!empty($detail->content) ? $detail->content : '');
$unit = !empty(old('unit')) ? old('unit') : (!empty($detail->unit) ? $detail->unit : '');
$ships = !empty(old('ships')) ? old('ships') : (!empty($detail->ships) ? json_decode($detail->ships, TRUE) : '');
$price_import =  !empty(old('price_import')) ? old('price_import') : (!empty($detail->price_import) ? number_format($detail->price_import, '0', ',', '.') : '');
$price =  !empty(old('price')) ? old('price') : (!empty($detail->price) ? number_format($detail->price, '0', ',', '.') : '');
$price_sale =  !empty(old('price_sale')) ? old('price_sale') : (!empty($detail->price_sale) ? number_format($detail->price_sale, '0', ',', '.') : '');
$price_contact =  !empty(old('price_contact')) ? old('price_contact') : (!empty($detail->price_contact) ? number_format($detail->price_contact, '0', ',', '.') : '');
if (!empty($copy)) {
    $code = CodeRender('products');
}
?>
<!-- BEGIN: Form Layout -->
<div class=" box p-5">
    <div>
        <label class="form-label text-base font-semibold">Tên sản phẩm</label>
        <?php echo Form::text('title', $title, ['class' => 'form-control w-full title']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Đường dẫn</label>
        <div class="input-group">
            <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
            </div>
            <?php echo Form::text('slug', $slug, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Mã sản phẩm</label>
        <?php echo Form::text('code', $code, ['class' => 'form-control w-full ']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Mô tả</label>
        <div class="mt-2">
            <?php echo Form::textarea('description', $description, ['id' => 'ckDescription', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Thông tin sản phẩm</label>
        <div class="mt-2">
            <?php echo Form::textarea('content', $content, ['id' => 'ckContent', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
        </div>
    </div>
</div>
<!-- start: Album Ảnh -->
<div class=" box p-5 mt-3 space-y-3">
    <div>
        <?php echo $__env->make('components.dropzone',['action' => $action], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<!-- END: Album Ảnh -->
<div class="box p-5 mt-3 space-y-3 ">
    <div>
        <label class="form-label text-base font-semibold">Giá sản phẩm</label>
    </div>
    <div class="grid grid-cols-3 gap-6">
        <div>
            <label class="form-label text-base font-semibold">Giá</label>
            <?php echo Form::text('price', $price, ['class' => 'form-control int price', 'autocomplete' => 'off']);; ?>
            <div class="flex mt-3 items-center">
                <div class="mr-1">
                    <?php if (isset($price_contact) && $price_contact == 1) { ?>
                        <input type="checkbox" checked name="price_contact" value="1" class="checkbox-item">
                    <?php } else { ?>
                        <input type="checkbox" name="price_contact" value="1" class="checkbox-item">
                    <?php } ?>
                </div>
                <div>
                    Liên hệ để biết giá
                </div>
            </div>
        </div>
        <div class="">
            <label class="form-label text-base font-semibold">Giá khuyến mại</label>
            <?php echo Form::text('price_sale', $price_sale, ['class' => 'form-control int ', 'autocomplete' => 'off']);; ?>
        </div>
        <div class="">
            <label class="form-label text-base font-semibold">Đơn vị tính</label>
            <?php echo Form::text('unit', $unit, ['class' => 'form-control', 'autocomplete' => 'off']);; ?>
        </div>
        <div class="col-span-3">
            <label class="form-label text-base font-semibold  flex items-center">Giá nhập
                <a href="" class="text-primary tooltip" title='Giá "tự động gợi ý" khi bạn "tạo đơn nhập hàng" từ nhà cung cấp. Bạn có thể thay đổi tùy theo giá nhập hàng thực tế.'>
                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i>
                </a>
            </label>
            <?php echo Form::text('price_import', $price_import, ['class' => 'form-control int ', 'autocomplete' => 'off']);; ?>
        </div>
    </div>
</div>
<?php echo $__env->make('product.backend.product.common.taxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class=" box p-5 mt-3 space-y-3 <?php if (!in_array('ships', $dropdown)) { ?>hidden<?php } ?>">
    <div>
        <label class="form-label text-base font-semibold">Vận chuyển</label>
    </div>
    <!-- START: Cân nặng, Kích cỡ(DxRxC) -->
    <div class="flex flex-col md:flex-row gap-2">
        <div class="w-1/2">
            <div>
                <label class="form-label text-base font-semibold">Cân nặng(gram)</label>
                <?php echo Form::text('ships[weight]', !empty($ships['weight']) ? $ships['weight'] : '', ['class' => 'form-control w-full ']); ?>
            </div>
        </div>
        <div class="w-1/2">
            <div>
                <label class="form-label text-base font-semibold">Kích cỡ(DxRxC)</label>
                <div class="flex gap-2">
                    <div class="w-1/3">
                        <?php echo Form::text('ships[length]', !empty($ships['length']) ? $ships['length'] : '', ['class' => 'form-control w-full ']); ?>
                    </div>
                    <div class="w-1/3">
                        <?php echo Form::text('ships[width]', !empty($ships['width']) ? $ships['width'] : '', ['class' => 'form-control w-full ']); ?>
                    </div>
                    <div class="w-1/3">
                        <?php echo Form::text('ships[height]', !empty($ships['height']) ? $ships['height'] : '', ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
</div><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/backend/product/common/_detail.blade.php ENDPATH**/ ?>
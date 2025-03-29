<?php
$code = CodeRender('courses');
$title = !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : '');
$slug = !empty(old('slug')) ? old('slug') : (!empty($detail->slug) ? $detail->slug : '');
$code = !empty(old('code')) ? old('code') : (!empty($detail->code) ? $detail->code : CodeRender('courses'));
$description = !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : '');
$content = !empty(old('content')) ? old('content') : (!empty($detail->content) ? $detail->content : '');
$price =  !empty(old('price')) ? old('price') : (!empty($detail->price) ? number_format($detail->price, '0', ',', '.') : '');
$price_sale =  !empty(old('price_sale')) ? old('price_sale') : (!empty($detail->price_sale) ? number_format($detail->price_sale, '0', ',', '.') : '');
$price_contact =  !empty(old('price_contact')) ? number_format(old('price_contact'), '0', ',', '.') : (!empty($detail->price_contact) ? number_format($detail->price_contact, '0', ',', '.') : '');
if (!empty($copy)) {
    $code = CodeRender('courses');
}
?>
<div>
    <label class="form-label text-base font-semibold">Tiêu đề khóa học</label>
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
    <label class="form-label text-base font-semibold">Mã khóa học</label>
    <?php echo Form::text('code', $code, ['class' => 'form-control w-full title']); ?>
</div>
<div class="mt-3">
    <label class="form-label text-base font-semibold">Mô tả</label>
    <div class="mt-2">
        <?php echo Form::textarea('description', $description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
    </div>
</div>
<div class="grid grid-cols-2 gap-6 mt-3">
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

</div><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/course/backend/course/form.blade.php ENDPATH**/ ?>
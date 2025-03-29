<?php
$code = CodeRender('courses');
$title = !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : '');
$slug = !empty(old('slug')) ? old('slug') : (!empty($detail->slug) ? $detail->slug : '');
$code = !empty(old('code')) ? old('code') : (!empty($detail->code) ? $detail->code : CodeRender('courses'));
$description = !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : '');
?>
<div>
    <label class="form-label text-base font-semibold">Tiêu đề các phòng,khoa</label>
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
    <label class="form-label text-base font-semibold">Nội dung</label>
    <div class="mt-2">
        <?php echo Form::textarea('description', $description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
    </div>
</div>
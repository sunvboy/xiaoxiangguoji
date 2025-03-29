<div class="mt-3 box-experience">
    <div id="box-experience" class="space-y-5">
        <?php
        $data = old('options');
        $ids = old('ids');
        if (!empty($data)) {
            $isTrue = old('isTrueValue');
            if (!empty($isTrue)) {
                $isTrue = explode(',', $isTrue);
            }
            if (!empty($data['a'])) {
                foreach ($data['a'] as $key => $item) {
        ?>
                    <div class="preview box p-5">
                        <div>
                            <label class="form-label text-base font-semibold">Tiêu đề</label>
                            <div class="mt-2">
                                <?php echo Form::textarea('description[]', !empty($data['description']) ? $data['description'][$key] : "", ['id' => 'ckDescription-' . $key . '', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                            </div>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[<?php echo e($key+1); ?>]" value="A" <?php if($isTrue[$key]=='A' ): ?> checked <?php endif; ?>>
                                    <span>A</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[a][]', !empty($ids['a'][$key]) ? $ids['a'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[a][]', $item, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[<?php echo e($key+1); ?>]" value="B" <?php if($isTrue[$key]=='B' ): ?> checked <?php endif; ?>>
                                    <span>B</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[b][]', !empty($ids['b'][$key]) ? $ids['b'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[b][]', !empty($data['b']) ? $data['b'][$key] : "", ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[<?php echo e($key+1); ?>]" value="C" <?php if($isTrue[$key]=='C' ): ?> checked <?php endif; ?>>
                                    <span>C</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[c][]', !empty($ids['c'][$key]) ? $ids['c'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[c][]', !empty($data['c']) ? $data['c'][$key] : "", ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[<?php echo e($key+1); ?>]" value="D" <?php if($isTrue[$key]=='D' ): ?> checked <?php endif; ?>>
                                    <span>C</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[d][]', !empty($ids['d'][$key]) ? $ids['d'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[d][]', !empty($data['d']) ? $data['d'][$key] : "", ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } elseif (!empty($detail->question_options)) { ?>
            <?php
            $data = collect($detail->question_options)->groupBy('order');
            if (!empty($data) && count($data) > 0) {

                foreach ($data as $key => $item) {
                    if (!empty($item) && count($item) > 0) {
            ?>

                        <div class="preview box p-5">
                            <div>
                                <label class="form-label text-base font-semibold">Tiêu đề</label>
                                <div class="mt-2">
                                    <?php echo Form::textarea('description[]', !empty($item) ? $item[0]['description'] : "", ['id' => 'ckDescription-' . $key . '', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                                </div>
                            </div>
                            <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $order = '';
                            switch ($v->characters) {
                                case 'A':
                                    $order = "a";
                                    break;
                                case 'B':
                                    $order = "b";
                                    break;
                                case 'C':
                                    $order = "c";
                                    break;
                                case 'D':
                                    $order = "d";
                                    break;
                                default:
                                    break;
                            }
                            ?>
                            <div class="input-group mt-2">
                                <div class="input-group-text">
                                    <label class="flex items-center space-x-1">
                                        <input class="form-check-input checkedTrue" type="radio" name="isTrue[<?php echo e($key+1); ?>]" value="<?php echo e($v->characters); ?>" <?php if($v->characters == $v->isTrue): ?> checked <?php endif; ?>>
                                        <span><?php echo e($v->characters); ?></span>
                                    </label>
                                </div>
                                <?php echo Form::textarea('options[' . $order . '][]', $v->title, ['id' => 'ckDescriptionQO-' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                                <?php echo Form::text('ids[' . $order . '][]', $v->id, ['class' => 'form-control w-full hidden']); ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="mt-2">
                                <button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

        <?php } else { ?>
            <div class="preview box p-5">
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('description[]', "", ['id' => 'ckDescription-1', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                    </div>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <label class="flex items-center space-x-1">
                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="A" checked>
                            <span>A</span>
                        </label>
                    </div>
                    <?php echo Form::textarea('options[a][]', "", ['id' => 'ckDescriptionQOC-1' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <label class="flex items-center space-x-1">
                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="B">
                            <span>B</span>
                        </label>
                    </div>
                    <?php echo Form::textarea('options[b][]', "", ['id' => 'ckDescriptionQOC-2' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <label class="flex items-center space-x-1">
                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="C">
                            <span>C</span>
                        </label>
                    </div>
                    <?php echo Form::textarea('options[c][]', "", ['id' => 'ckDescriptionQOC-3' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <label class="flex items-center space-x-1">
                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="D">
                            <span>C</span>
                        </label>
                    </div>
                    <?php echo Form::textarea('options[d][]', "", ['id' => 'ckDescriptionQOC-4' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="mt-3">
        <button type="button" class="btn btn-success text-white js_handleAdd">Thêm mới</button>
    </div>
</div><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/question/update/experience.blade.php ENDPATH**/ ?>
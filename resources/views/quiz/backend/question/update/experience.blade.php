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
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="A" @if($isTrue[$key]=='A' ) checked @endif>
                                    <span>A</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[a][]', !empty($ids['a'][$key]) ? $ids['a'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[a][]', $item, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="B" @if($isTrue[$key]=='B' ) checked @endif>
                                    <span>B</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[b][]', !empty($ids['b'][$key]) ? $ids['b'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[b][]', !empty($data['b']) ? $data['b'][$key] : "", ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="C" @if($isTrue[$key]=='C' ) checked @endif>
                                    <span>C</span>
                                </label>
                            </div>
                            <?php echo Form::text('ids[c][]', !empty($ids['c'][$key]) ? $ids['c'][$key] : '', ['class' => 'form-control w-full hidden']); ?>
                            <?php echo Form::text('options[c][]', !empty($data['c']) ? $data['c'][$key] : "", ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <label class="flex items-center space-x-1">
                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="D" @if($isTrue[$key]=='D' ) checked @endif>
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
                            <div class="hidden">
                                <label class="form-label text-base font-semibold">Tiêu đề</label>
                                <div class="mt-2">
                                    <?php echo Form::textarea('description[]', !empty($item) ? $item[0]['description'] : "", ['id' => 'ckDescription-' . $key . '', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                                </div>
                            </div>
                            @foreach ($item as $k => $v)
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
                                        <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="{{$v->characters}}" @if($v->characters == $v->isTrue) checked @endif>
                                        <span>{{$v->characters}}</span>
                                    </label>
                                </div>
                                <?php echo Form::textarea('options[' . $order . '][]', $v->title, ['id' => 'ckDescriptionQO-' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                                <?php echo Form::text('ids[' . $order . '][]', $v->id, ['class' => 'form-control w-full hidden']); ?>
                            </div>
                            @endforeach
                            <div class="mt-2">
                                <button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

        <?php } else { ?>
            <div class="preview box p-5">
                <div class="hidden">
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
</div>
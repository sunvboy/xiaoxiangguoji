<?php
$reads = $detail->question_options->where('characters', null)->all();
$booleans = $detail->question_options->where('characters', '!=', null)->all();
$booleans = collect($booleans)->groupBy('order');
?>
<div class="read_list space-y-5">
    @if(!empty($reads))
    @foreach($reads as $k=>$v)
    <div class="flex justify-between space-x-5">
        <div class="flex-1 read-title-first-{{$v->id}}">
            @if($v->description == 'title')
            <h3 class="font-bold read_title_{{$v->id}} read_title">{{$v->title}}</h3>
            @else
            <div class="flex items-center text-danger font-bold  read_input_{{$v->id}} read_input" data-text="{{$v->title}}">
                <?php
                $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v->title);
                ?>
                {!!$str!!}
            </div>
            @endif
        </div>
        <div>
            <div class="flex items-center space-x-2 read_action">
                <a class="flex items-center mr-3 read_edit" data-id='{{$v->id}}' data-type='{{$v->description}}' href="javascript:void(0)">
                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                    Edit
                </a>
                <a class="flex items-center mr-3 text-danger read_delete" data-id='{{$v->id}}' data-type='{{$v->description}}' href="javascript:void(0)">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                    Xóa
                </a>
            </div>
            <a class="flex items-center mr-3 hidden text-success read_save" data-id='{{$v->id}}' href="javascript:void(0)">
                <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                Save
            </a>
        </div>
    </div>
    @endforeach
    @endif

</div>
<div class="mt-5 flex justify-end read_add">
    <a href="javascript:void(0)" class="btn btn-success text-white">Thêm mới</a>
</div>
<div class="mt-3 box-experience">
    <div id="box-experience" class="space-y-5">
        <?php
        if (!empty($booleans) && count($booleans) > 0) {

            foreach ($booleans as $key => $item) {
                if (!empty($item) && count($item) > 0) {
        ?>
                    <div class="preview box p-5">
                        <div>
                            <label class="form-label text-base font-semibold">Tiêu đề</label>
                            <div class="mt-2">
                                <?php echo Form::textarea('description[]', !empty($item) ? $item[0]['description'] : "", ['id' => 'ckDescriptionType5-' . $key . '', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
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
                            <?php echo Form::textarea('options[' . $order . '][]', $v->title, ['id' => 'ckDescriptionQOC-' . $v->id, 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
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

    </div>
    <div class="mt-3">
        <button type="button" class="btn btn-success text-white js_handleAdd">Thêm mới câu trắc nghiệm</button>
    </div>
</div>
@push('javascript')
<script>
    $(document).on('click', '.read_add', function(e) {
        e.preventDefault()
        var html = '';
        html += '<div class="flex justify-between space-x-5 box-read-add">';
        html += '<div class="flex-1">';
        html += '<input type="text" value="" class="form-control read_input_add">';
        html += '</div>';
        html += '<a class="flex items-center mr-3 text-success read_save_add" href="javascript:void(0)">';
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="save" data-lucide="save" class="lucide lucide-save w-4 h-4 mr-1"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>';
        html += ' Save';
        html += '</a>';
        html += '</div>';
        $('.read_list').append(html)
        $('.read_add').addClass('hidden');
    })
    $(document).on('click', '.read_save_add', function(e) {
        var value = $('.read_input_add').val();
        if (!value) {
            toastr.error('Nội dung không được để trống', 'Error!')
        } else {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: '<?php echo route('questions.createRewrite') ?>',
                type: "POST",
                dataType: "JSON",
                data: {
                    question_id: <?php echo $detail->id ?>,
                    value: value,
                },
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success(data.message, 'Success!')
                        $('.box-read-add').remove()
                        var html = '';
                        html += '<div class="flex justify-between space-x-5">';
                        html += '<div class="flex-1 read-title-first-' + data.detail.id + '">';
                        html += data.html;
                        html += '</div>';
                        html += '<div>';
                        html += '<div class="flex items-center space-x-2 read_action">';
                        html += '<a class="flex items-center mr-3 read_edit" href="javascript:void(0)" data-id="' + data.detail.id + '" data-type="' + data.detail.description + '" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit w-4 h-4 mr-1"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
                        html += ' Edit';
                        html += '</a>';
                        html += '<a class="flex items-center mr-3 text-danger read_delete"  data-id="' + data.detail.id + '" data-type="title" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
                        html += 'Xóa';
                        html += '</a>';
                        html += '</div>';
                        html += '<a class="flex items-center mr-3 text-success hidden read_save" data-id="' + data.detail.id + '" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="save" data-lucide="save" class="lucide lucide-save w-4 h-4 mr-1"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>';
                        html += 'Save';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        $('.read_list').append(html)
                        $('.read_add').removeClass('hidden');
                    } else {
                        toastr.error(data.message, 'ERROR!')
                    }
                }
            });
        }
    })
</script>
<script>
    $(document).on('click', '.read_edit', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        $(this).parent().parent().find('.read_action').addClass('hidden')
        $(this).parent().parent().parent().find('.read_save').removeClass('hidden')
        if (type == 'title') {
            var text = $('.read_title_' + id).text();
            $('.read_title_' + id).html('<input type="text" value="' + text + '" class="form-control read_value_save_' + id + '">')
        } else {
            var text = $('.read_input_' + id).attr('data-text');
            $('.read_input_' + id).html('<input type="text" value="' + text + '" class="form-control read_value_save_' + id + '">')
        }
    })
    $(document).on('click', '.read_save', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        var value = $('.read_value_save_' + id).val();
        var _this = $(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: '<?php echo route('questions.updateRewrite') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                value: value,
            },
            success: function(data) {
                if (data.status == 200) {
                    toastr.success(data.message, 'Success!')
                    _this.parent().find('.read_action').removeClass('hidden')
                    _this.parent().find('.read_edit').attr('data-type', data.type)
                    _this.addClass('hidden')
                    $('.read-title-first-' + id).html(data.html)
                }
            }
        });
    })
    $(document).on('click', '.read_delete', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        var _this = $(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: '<?php echo route('questions.deleteRewrite') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                if (data.status == 200) {
                    toastr.success(data.message, 'Success!')
                    _this.parent().parent().parent().remove()
                }
            }
        });
    })
</script>
@endpush
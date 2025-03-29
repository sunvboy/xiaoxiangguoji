<div class="rewrite_list space-y-5">
    @if(!empty($detail->question_options))
    @foreach($detail->question_options as $k=>$v)
    <div class="flex justify-between space-x-5">
        <div class="flex-1 rewrite-title-first-{{$v->id}}">
            @if($v->description == 'title')
            <h3 class="font-bold rewrite_title_{{$v->id}} rewrite_title">{{$v->title}}</h3>
            @else
            <div class="flex items-center text-danger font-bold  rewrite_input_{{$v->id}} rewrite_input" data-text="{{$v->title}}">
                <?php
                $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v->title);
                ?>
                {!!$str!!}
            </div>
            @endif
        </div>
        <div>
            <div class="flex items-center space-x-2 rewrite_action">
                <a class="flex items-center mr-3 rewrite_edit" data-id='{{$v->id}}' data-type='{{$v->description}}' href="javascript:void(0)">
                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                    Edit
                </a>
                <a class="flex items-center mr-3 text-danger rewrite_delete" data-id='{{$v->id}}' data-type='{{$v->description}}' href="javascript:void(0)">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                    Xóa
                </a>
            </div>
            <a class="flex items-center mr-3 hidden text-success rewrite_save" data-id='{{$v->id}}' href="javascript:void(0)">
                <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                Save
            </a>
        </div>
    </div>
    @endforeach
    @endif
</div>
<div class="mt-5 flex justify-end rewrite_add">
    <a href="javascript:void(0)" class="btn btn-success text-white">Thêm mới</a>
</div>
@push('javascript')
<script>
    $(document).on('click', '.rewrite_add', function(e) {
        e.preventDefault()
        var html = '';
        html += '<div class="flex justify-between space-x-5 box-rewrite-add">';
        html += '<div class="flex-1">';
        html += '<input type="text" value="" class="form-control rewrite_input_add">';
        html += '</div>';
        html += '<a class="flex items-center mr-3 text-success rewrite_save_add" href="javascript:void(0)">';
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="save" data-lucide="save" class="lucide lucide-save w-4 h-4 mr-1"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>';
        html += ' Save';
        html += '</a>';
        html += '</div>';
        $('.rewrite_list').append(html)
        $('.rewrite_add').addClass('hidden');
    })
    $(document).on('click', '.rewrite_save_add', function(e) {
        var value = $('.rewrite_input_add').val();
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
                        $('.box-rewrite-add').remove()
                        var html = '';
                        html += '<div class="flex justify-between space-x-5">';
                        html += '<div class="flex-1 rewrite-title-first-' + data.detail.id + '">';
                        html += data.html;
                        html += '</div>';
                        html += '<div>';
                        html += '<div class="flex items-center space-x-2 rewrite_action">';
                        html += '<a class="flex items-center mr-3 rewrite_edit" href="javascript:void(0)" data-id="' + data.detail.id + '" data-type="' + data.detail.description + '" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit w-4 h-4 mr-1"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
                        html += ' Edit';
                        html += '</a>';
                        html += '<a class="flex items-center mr-3 text-danger rewrite_delete"  data-id="' + data.detail.id + '" data-type="title" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
                        html += 'Xóa';
                        html += '</a>';
                        html += '</div>';
                        html += '<a class="flex items-center mr-3 text-success hidden rewrite_save" data-id="' + data.detail.id + '" href="javascript:void(0)">';
                        html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="save" data-lucide="save" class="lucide lucide-save w-4 h-4 mr-1"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>';
                        html += 'Save';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        $('.rewrite_list').append(html)
                        $('.rewrite_add').removeClass('hidden');
                    } else {
                        toastr.error(data.message, 'ERROR!')
                    }
                }
            });
        }
    })
</script>
<script>
    $(document).on('click', '.rewrite_edit', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        $(this).parent().parent().find('.rewrite_action').addClass('hidden')
        $(this).parent().parent().parent().find('.rewrite_save').removeClass('hidden')
        if (type == 'title') {
            var text = $('.rewrite_title_' + id).text();
            $('.rewrite_title_' + id).html('<input type="text" value="' + text + '" class="form-control rewrite_value_save_' + id + '">')
        } else {
            var text = $('.rewrite_input_' + id).attr('data-text');
            $('.rewrite_input_' + id).html('<input type="text" value="' + text + '" class="form-control rewrite_value_save_' + id + '">')
        }
    })
    $(document).on('click', '.rewrite_save', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        var value = $('.rewrite_value_save_' + id).val();
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
                    _this.parent().find('.rewrite_action').removeClass('hidden')
                    _this.parent().find('.rewrite_edit').attr('data-type', data.type)
                    _this.addClass('hidden')
                    $('.rewrite-title-first-' + id).html(data.html)
                }
            }
        });
    })
    $(document).on('click', '.rewrite_delete', function(e) {
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
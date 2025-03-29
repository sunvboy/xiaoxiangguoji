@extends('dashboard.layout.dashboard')

@section('title')
<title>Chỉnh sửa câu hỏi</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách câu hỏi",
        "src" => route('questions.index'),
    ],
    [
        "title" => "Chỉnh sửa",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Chỉnh sửa câu hỏi
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('questions.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-12">
            <div class="box p-5">
                @include('components.alert-error')
                @csrf

                <div>
                    <label class="form-label text-base font-semibold">CODE</label>
                    <?php echo Form::text('code', $detail->code, ['class' => 'form-control w-full', 'disabled']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">TYPE</label>
                    <?php echo Form::select('typeValue', ['1' => "Trắc nghiệm", "2" => "Tự luận", "3" => "Nói", "4" => "Rewrite", "5" => "Read and TRUE of FALSE"], $detail->type, ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors", 'disabled']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nội dung câu hỏi</label>
                    <?php echo Form::textarea('title', $detail->title, ['id' => 'ckContent', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <?php if ($detail->type == 1) { ?>
                    @include('quiz.backend.question.update.experience')
                <?php } ?>
                <?php if ($detail->type == 3) { ?>
                    <!-- Nói -->
                    <div class="mt-3 box-speak space-y-5">
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">File Upload</label>
                            <div class="flex items-center">
                                <?php echo Form::text('file', $detail->file, ['class' => 'form-control w-full', 'onclick' => "openKCFinder($(this), 'image')"]); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- Nói -->
                <?php if ($detail->type == 4) { ?>
                    <div class="mt-3 box-rewrite space-y-5">
                        @include('quiz.backend.question.update.rewrite')
                    </div>
                <?php } ?>
                <?php if ($detail->type == 5) { ?>
                    <div class="mt-3 box-read space-y-5">
                        @include('quiz.backend.question.update.read')
                    </div>
                <?php } ?>
                <div class="mt-3">
                    <input class="" name="isTrueValue" value="" type="hidden">
                    <input class="" name="type" value="{{$detail->type}}" type="hidden">
                    <button type="submit" class="btn btn-primary">Cập nhập</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('javascript')
<script>
    $(document).on('change', '.checkedTrue', function(e) {
        loadIsTrue()
    })
    // $(document).on('change', 'select[name="type"]', function(e) {
    //     loadDefault()
    // })
    // loadDefault()
    loadIsTrue()

    // function loadDefault() {
    //     var value = $('select[name="type"]').find(":selected").val();
    //     if (value == 1) {
    //         //trắc nghiệm
    //         $('.box-experience').show()
    //         $('.box-speak').hide()
    //         $('.box-rewrite').hide()
    //         $('.box-read').hide()
    //     } else if (value == 2) {
    //         //Nói
    //         $('.box-experience').hide()
    //         $('.box-speak').hide()
    //         $('.box-rewrite').hide()
    //         $('.box-read').hide()
    //     } else if (value == 3) {
    //         //Viết
    //         $('.box-experience').hide()
    //         $('.box-speak').show()
    //         $('.box-rewrite').hide()
    //         $('.box-read').hide()
    //     } else if (value == 4) {
    //         //Rewrite
    //         $('.box-experience').hide()
    //         $('.box-speak').hide()
    //         $('.box-rewrite').show()
    //         $('.box-read').hide()
    //     } else if (value == 5) {
    //         //Read and TRUE of FALSE
    //         $('.box-experience').hide()
    //         $('.box-speak').hide()
    //         $('.box-rewrite').hide()
    //         $('.box-read').show()
    //     }
    // }

    function loadIsTrue() {
        var sList = "";
        $('.checkedTrue:checked').each(function() {
            var sThisVal = (this.checked ? "1" : "0");
            sList += (sList == "" ? $(this).val() : "," + $(this).val());
        });
        $('input[name="isTrueValue"]').val(sList)
    }
    $(document).on('click', '.js_handleAdd', function(e) {
        var html = '';
        var microtime = (Date.now() % 1000) / 1000;
        var editorId = 'editor_' + microtime;
        html += '<div class="preview box p-5">'
        html += '<div class="hidden">'
        html += '<label class="form-label text-base font-semibold">Tiêu đề</label>'
        html += '<div class="mt-2">'
        html += '<textarea id="' + editorId + '" class="ck-editor-description" style="font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px" name="description[]" cols="50" rows="10"></textarea>'
        html += '</div>'
        html += '</div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="A" checked>'
        html += '<span>A</span>'
        html += '</label>'
        html += '</div>'
        html += '<textarea id="' + editorId + '_a" class="ck-editor-description" style="font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px" name="options[a][]" cols="50" rows="10"></textarea>'
        html += '</div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="B">'
        html += '<span>B</span>'
        html += '</label>'
        html += '</div>'
        html += '<textarea id="' + editorId + '_b" class="ck-editor-description" style="font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px" name="options[b][]" cols="50" rows="10"></textarea>'
        html += '</div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="C">'
        html += '<span>C</span>'
        html += '</label>'
        html += '</div>'
        html += '<textarea id="' + editorId + '_c" class="ck-editor-description" style="font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px" name="options[c][]" cols="50" rows="10"></textarea>'
        html += ' </div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="D">'
        html += '      <span>D</span>'
        html += '</label>'
        html += '</div>'
        html += '<textarea id="' + editorId + '_d" class="ck-editor-description" style="font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px" name="options[d][]" cols="50" rows="10"></textarea>'
        html += '</div>'
        html += '<div class="mt-2">'
        html += '<button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>'
        html += '</div>'
        html += ' </div>'
        $('#box-experience').append(html)
        loadIsTrue();
        loadCKeditor(editorId)
        loadCKeditor(editorId + '_a')
        loadCKeditor(editorId + '_b')
        loadCKeditor(editorId + '_c')
        loadCKeditor(editorId + '_d')
    })

    function loadCKeditor(q) {
        CKEDITOR.replace(q, {
            height: 200,
            extraPlugins: "colorbutton, panelbutton, link, justify, lineheight, font, codemirror, copyformatting,  ",
            removeButtons: "",
            entities: false,
            entities_latin: false,
            allowedContent: true,
            toolbarGroups: [{
                    name: "clipboard",
                    groups: ["clipboard", "undo"],
                },
                {
                    name: "editing",
                    groups: ["find", "selection", "spellchecker"],
                },
                {
                    name: "links",
                },
                {
                    name: "insert",
                },
                {
                    name: "forms",
                },
                {
                    name: "tools",
                },
                {
                    name: "document",
                    groups: ["mode", "document", "doctools"],
                },
                {
                    name: "colors",
                },
                {
                    name: "others",
                },
                "/",
                {
                    name: "basicstyles",
                    groups: ["basicstyles", "cleanup"],
                },
                {
                    name: "paragraph",
                    groups: ["list", "indent", "blocks", "align", "bidi"],
                },
                {
                    name: "styles",
                },
            ],
        }).on("change", function(e) {
            if (e.editor.name == "ckDescription") {
                var metaDescription =
                    document.getElementById("seoDescription").value;
                if (metaDescription == "") {
                    let data = decodeEntities(e.editor.getData());
                    var parser = new DOMParser();
                    var dom = parser.parseFromString(
                        "<!doctype html><body>" + data,
                        "text/html"
                    );
                    var decodedString = dom.body.textContent;
                    document.getElementById("metaDescription").innerHTML =
                        decodedString.slice(0, 320);
                }
            }
        });
    }
    $(document).on('click', '.js_handleRemove', function(e) {
        $(this).parent().parent().remove()
        loadIsTrue();
    })
</script>
@endpush

<?php $__env->startSection('title'); ?>
<title>Thêm mới câu hỏi</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách câu hỏi",
        "src" => route('questions.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới câu hỏi
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('questions.store')); ?>" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-12">
            <div class="box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
                <?php
                $code = CodeRender('questions');
                ?>
                <div>
                    <label class="form-label text-base font-semibold">CODE</label>
                    <?php echo Form::text('code', $code, ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">TYPE</label>
                    <?php echo Form::select('type', ['1' => "Trắc nghiệm", "2" => "Tự luận", "3" => "Nói", "4" => "Rewrite", "5" => "Read and TRUE of FALSE"], old('type'), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>


                <?php /*<div class="mt-3">
                    <label class="form-label text-base font-semibold">Nội dung câu hỏi</label>
                    <?php echo Form::textarea('title', '', ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div><div class="mt-3 box-experience hidden">
                    <!-- Trắc nghiệm -->
                    <div class="space-y-5" id="box-experience">
                        <?php
                        $data = old('options');
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
                                            <?php echo Form::text('options[a][]', $item, ['class' => 'form-control w-full']); ?>
                                        </div>
                                        <div class="input-group mt-2">
                                            <div class="input-group-text">
                                                <label class="flex items-center space-x-1">
                                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="B" @if($isTrue[$key]=='B' ) checked @endif>
                                                    <span>B</span>
                                                </label>
                                            </div>
                                            <?php echo Form::text('options[b][]', !empty($data['b']) ? $data['b'][$key] : "", ['class' => 'form-control w-full']); ?>
                                        </div>
                                        <div class="input-group mt-2">
                                            <div class="input-group-text">
                                                <label class="flex items-center space-x-1">
                                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="C" @if($isTrue[$key]=='C' ) checked @endif>
                                                    <span>C</span>
                                                </label>
                                            </div>
                                            <?php echo Form::text('options[c][]', !empty($data['c']) ? $data['c'][$key] : "", ['class' => 'form-control w-full']); ?>
                                        </div>
                                        <div class="input-group mt-2">
                                            <div class="input-group-text">
                                                <label class="flex items-center space-x-1">
                                                    <input class="form-check-input checkedTrue" type="radio" name="isTrue[{{$key+1}}]" value="D" @if($isTrue[$key]=='D' ) checked @endif>
                                                    <span>C</span>
                                                </label>
                                            </div>
                                            <?php echo Form::text('options[d][]', !empty($data['d']) ? $data['d'][$key] : "", ['class' => 'form-control w-full']); ?>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>
                                        </div>
                                    </div>
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
                                    <?php echo Form::text('options[a][]', "", ['class' => 'form-control w-full']); ?>
                                </div>
                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <label class="flex items-center space-x-1">
                                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="B">
                                            <span>B</span>
                                        </label>
                                    </div>
                                    <?php echo Form::text('options[b][]',  "", ['class' => 'form-control w-full']); ?>
                                </div>
                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <label class="flex items-center space-x-1">
                                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="C">
                                            <span>C</span>
                                        </label>
                                    </div>
                                    <?php echo Form::text('options[c][]', "", ['class' => 'form-control w-full']); ?>
                                </div>
                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <label class="flex items-center space-x-1">
                                            <input class="form-check-input checkedTrue" type="radio" name="isTrue[1]" value="D">
                                            <span>C</span>
                                        </label>
                                    </div>
                                    <?php echo Form::text('options[d][]', "", ['class' => 'form-control w-full']); ?>
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

                <!-- Nói -->
                <div class="box-speak space-y-5 mt-3">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">File Upload</label>
                        <div class="flex items-center">
                            <?php echo Form::text('file', "", ['class' => 'form-control w-full', 'onclick' => "openKCFinder($(this), 'image')"]); ?>
                        </div>
                    </div>
                </div>*/ ?>
                <div class="mt-3">
                    <input class="" name="isTrueValue" value="" type="hidden">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<?php /*<script>
    $(document).on('change', '.checkedTrue', function(e) {
        loadIsTrue()
    })
    $(document).on('change', 'select[name="type"]', function(e) {
        loadDefault()
    })
    loadDefault()
    loadIsTrue()

    function loadDefault() {
        var value = $('select[name="type"]').find(":selected").val();
        if (value == 1) {
            //trắc nghiệm
            $('.box-experience').show()
            $('.box-speak').hide()
            $('.box-rewrite').hide()
            $('.box-read').hide()
        } else if (value == 2) {
            //Nói
            $('.box-experience').hide()
            $('.box-speak').hide()
            $('.box-rewrite').hide()
            $('.box-read').hide()
        } else if (value == 3) {
            //Viết
            $('.box-experience').hide()
            $('.box-speak').show()
            $('.box-rewrite').hide()
            $('.box-read').hide()
        } else if (value == 4) {
            //Rewrite
            $('.box-experience').hide()
            $('.box-speak').hide()
            $('.box-rewrite').show()
            $('.box-read').hide()
        } else if (value == 5) {
            //Read and TRUE of FALSE
            $('.box-experience').hide()
            $('.box-speak').hide()
            $('.box-rewrite').hide()
            $('.box-read').show()
        }
    }

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
        html += '<div>'
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
        html += '<?php echo Form::text('options[a][]', "", ['class' => 'form-control w-full']); ?>'
        html += '</div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="B">'
        html += '<span>B</span>'
        html += '</label>'
        html += '</div>'
        html += '<?php echo Form::text('options[b][]', "", ['class' => 'form-control w-full']); ?>'
        html += '</div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="C">'
        html += '<span>C</span>'
        html += '</label>'
        html += '</div>'
        html += '<?php echo Form::text('options[c][]', "", ['class' => 'form-control w-full']); ?>'
        html += ' </div>'
        html += '<div class="input-group mt-2">'
        html += '<div class="input-group-text">'
        html += '<label class="flex items-center space-x-1">'
        html += '<input class="form-check-input checkedTrue" type="radio" name="isTrue[' + editorId + ']" value="D">'
        html += '      <span>D</span>'
        html += '</label>'
        html += '</div>'
        html += ' <?php echo Form::text('options[d][]', "", ['class' => 'form-control w-full']); ?>'
        html += '</div>'
        html += '<div class="mt-2">'
        html += '<button type="button" class="btn btn-danger text-white js_handleRemove">Xóa</button>'
        html += '</div>'
        html += ' </div>'
        $('#box-experience').append(html)
        loadIsTrue();
        CKEDITOR.replace(editorId, {
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
    })
    $(document).on('click', '.js_handleRemove', function(e) {
        $(this).parent().parent().remove()
        loadIsTrue();
    })
</script>*/ ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/question/create.blade.php ENDPATH**/ ?>
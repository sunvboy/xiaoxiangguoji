<?php
if ($errors->any()) {
    $catalogue  = old('attribute_catalogue');
    $checkbox  = old('checkbox_val');
    $attribute = old('attribute');
} else if ($action == 'update') {
    $version_json = json_decode(base64_decode($detail->version_json), true);
    $checkbox = $version_json[0];
    $catalogue  = $version_json[1];
    $attribute = $version_json[2];
}
if (isset($title_version)) {
    $version = count($title_version);
} else {
    $version = 0;
}
?>
<div class="box p-5 mt-3 space-y-3 <?php if (!in_array('attributes', $dropdown)) { ?>hidden<?php } ?>">
    <div>
        <label class="form-label text-base font-semibold">Bộ lọc </label>
    </div>
    <div class="ibox mb-5 block-version" data-countattribute_catalogue="<?php echo count($htmlAttribute) - 1 ?>">
        <div class="ibox-title">
            <div class="grid grid-cols-3 justify-between text-base  items-center">
                <div class="col-span-2">
                    <h5>Chọn bộ lọc thuộc tính cho khóa học</h5>
                </div>
                <div class="text-right">
                    <a class="show-version btn btn-danger btn-sm" href="javascript:void(0)" <?php echo (!empty($catalogue)) ? 'style="display:none"' : '' ?>>
                        <i data-lucide="plus" class="w-6 h-6 text-white"></i>
                    </a>
                    <a class="hide-version btn btn-danger btn-sm" href="javascript:void(0)" <?php echo (!empty($catalogue)) ? '' : 'style="display:none"' ?>>Đóng</a>
                </div>
            </div>
        </div>
        <div class="ibox-content mt-5" style=" <?php echo (!empty($catalogue)) ? '' : 'display:none"' ?>">
            <div class="block-attribute">
                <div class="mb-3 overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="s_tdVariable hidden">Sản phẩm biến thể</td>
                                <td style="width: 30%;">Tên thuộc tính</td>
                                <td style="width: 50%;">Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy)</td>
                                <td style="width: 10%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($catalogue)) { ?>
                                <?php foreach ($catalogue as $key => $value) {
                                    if (isset($attribute_json[$key])) { ?>
                                        <tr data-id="<?php echo $value ?>" <?php echo (isset($checkbox[$key]) && $checkbox[$key] == 1) ? 'class="bg-choose"' : '' ?>>
                                            <td class="s_tdVariable hidden" data-index="<?php echo $key ?>">
                                                <?php if (isset($checkbox[$key]) && $checkbox[$key] == 1) { ?>
                                                    <input type="checkbox" checked name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="1" class="hidden">
                                                    <div for="" class="label-checkboxitem checked"></div>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="0" class="hidden">
                                                    <div for="" class="label-checkboxitem "></div>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <select class="form-control select3" name="attribute_catalogue[]" tabindex="-1" aria-hidden="true">
                                                    <?php $__currentLoopData = $htmlAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k); ?>" <?php echo e($value == $k ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php if ($value == 0) { ?>
                                                    <input type="text" class="form-control" disabled="disabled">
                                                <?php } else { ?>
                                                    <select name="attribute[<?php echo $key ?>][]" data-stt="<?php echo e($key); ?>" data-json="<?php echo (isset($attribute_json[$key])) ? base64_encode(json_encode($attribute_json[$key])) : '' ?>" data-condition="<?php echo $value ?>" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes" style="width: 100%;">
                                                    </select>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a type="button" class="text-danger delete-attribute" data-id="">
                                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height20px">
                                                        <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex" style="padding: 0px 20px 10px 20px;">
                    <a href="javascript:void(0)" data-attribute="<?php echo base64_encode(json_encode($htmlAttribute)) ?>" class="add-attribute btn btn-danger" data-id=""><i class="fa fa-plus"></i> Thêm thuộc tính cho
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<script>
    var attributes = new Array();
    $(document).ready(function() {
        $('.block-attribute input[name="checkbox[]"]').each(function() {
            if ($(this).is(':checked')) {
                var _this = $(this).parent().parent();
                var id = _this.find('select[name="attribute_catalogue[]"]').val();
                attributes[id] = [];
                var index = _this.find('td:first-child').attr('data-index');
                _this.find('select[name="attribute[' + index + '][]"] option:selected').each(function() {
                    attributes[id].push($(this).text());
                });
            }
        })
    })
</script>
<script>
    $('.select2').select2();
    $('.select3').select2();

    function selectMultipe(object, select = "title") {
        let condition = object.attr('data-condition');
        let title = object.attr('data-title');
        let module = object.attr('data-module');
        let key = object.attr('data-key');
        object.select2({
            minimumInputLength: 0,
            placeholder: title,
            ajax: {
                url: BASE_URL_AJAX + 'ajax/select2',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                deley: 250,
                data: function(params) {
                    return {
                        locationVal: params.term,
                        module: module,
                        key: key,
                        select: select,
                        condition: condition,
                    };
                },
                processResults: function(data) {
                    // console.log(data);
                    return {
                        results: $.map(data, function(obj, i) {
                            return obj
                        })
                    }
                },
                cache: true,
            }
        });
    }
    $('.selectMultipe').each(function(key1, index) {
        let _this = $(this);
        let select = _this.attr('data-select');
        select = (typeof select == 'undefined') ? 'title' : select;
        let key = _this.attr('data-key');
        key = (typeof key == 'undefined') ? 'id' : key;
        let module = _this.attr('data-module');
        let json = _this.attr('data-json');
        value = (typeof json != "undefined") ? window.atob(json) : '';
        console.log(value);
        let parse = JSON.parse(value);
        if (parse != 'undefined' && parse.length) {
            for (let i = 0; i < parse.length; i++) {
                var option = new Option(parse[i].text, parse[i].id, true, true);
                _this.append(option).trigger('change');
            }
        }
        selectMultipe($(this), select);
    });
</script>
<script type="text/javascript">
    /*======================xử lí khối thêm phiên bản======================*/
    // Click "Đóng"
    $(document).on('click', '.block-version .hide-version', function(e) {
        e.preventDefault();
        let _this = $(this);
        _this.parents('.block-version').find('.show-version').show();
        _this.parents('.block-version').find('.hide-version').hide();
        _this.parents('.block-version').find('.ibox-content').hide();
    });
    // Click "Thêm mới"
    $(document).on('click', '.block-version .show-version', function(e) {
        e.preventDefault();
        let _this = $(this);
        _this.parent('div').find('.hide-version').show();
        _this.hide();
        _this.parents('.block-version').find('.ibox-content').show();
    });
    var attribute_catalogue = [];
    //Click " Thêm thuộc tính cho sản phẩm"
    $(document).on('click', '.add-attribute', function() {
        let _this = $(this);
        let attr = _this.attr('data-attribute');
        $('.block-attribute').find('table tbody').append(render_attribute(attr, attribute_catalogue));
        $('.select3').each(function(key, index) {
            $(this).select2();
        });
        $countAttr = $('.block-attribute table tbody').find('tr').length;
        $countattribute_catalogue = $('.block-version').attr('data-countattribute_catalogue');
        if (parseFloat($countAttr) >= parseFloat($countattribute_catalogue)) {
            $('.add-attribute').hide()
        } else {
            $('.add-attribute').show()
        }
    });
    $(document).on('change', 'select[name="attribute_catalogue[]"]', function() {
        let _this = $(this);
        let catalogue_id = _this.val();
        if (catalogue_id != 0) {
            let index = _this.parents('tr').find('td:first').attr('data-index');
            _this.parents('tr').find('td:eq(2)').html(render_select2(catalogue_id, index));
        } else {
            _this.parents('tr').find('td:eq(2)').html('<input type="text" class="form-control" disabled="disabled">');
        }
        $('.selectMultipe').each(function(key, index) {
            selectMultipe($(this));
        });
    });

    function render_select2(condition = '', index = '') {
        return '<select name="attribute[' + index + '][]" data-condition="' + condition + '" data-json="" data-stt="' + index + '" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes"  style="width: 100%;"></select>';
    }


    function render_attribute(attr, attribute_catalogue) {
        var type = $('.s_handleSelectTypeProduct').val();
        var classType = '';
        if (type === 'simple') {
            classType = 'hidden'
        }
        let index = $('.block-attribute tbody tr').length;
        attr = JSON.parse(window.atob(attr));
        let key = Object.keys(attr);
        let value = Object.values(attr);
        let html = '<tr>';
        html = html + '<td class="hidden s_tdVariable ' + classType + '" data-index="' + index + '" style="width: 10%">';
        html = html + '<input type="checkbox" name="checkbox[]" value="1" class="checkbox-item" disabled>';
        html = html + '<input type="text" name="checkbox_val[]" value="0" class="hidden">';
        html = html + '<div for="" class="label-checkboxitem"></div>';
        html = html + '</td>';
        html = html + '<td style="width: 30%">';
        html = html + '<select name="attribute_catalogue[]" class="form-control select3"> style="width:100%" >';
        let pos = '';
        for (let i = 0; i < key.length; i++) {
            pos = attribute_catalogue.indexOf(key[i]);
            if (pos == -1) {
                html = html + '<option value="' + key[i] + '">' + value[i] + '</option>';
            } else {
                html = html + '<option disabled="disabled" value="' + key[i] + '">' + value[i] + '</option>';
            }
        }
        html = html + '</select>';
        html = html + '</td>';
        html = html + '<td style="width: 50%">';
        html = html + '<input type="text" class="form-control" disabled="disabled">';
        html = html + '</td>';
        html = html + '<td style="width: 10%">';
        html = html + '<a href="javascript:void(0)" class=" delete-attribute flex items-center text-danger" data-id="" >Xóa</a>';
        html = html + '</td>';
        html = html + '</tr>';
        $('.select3').each(function(key, index) {
            $(this).select2();
        });
        return html;
    }


    //Click "Xóa category attributes"
    $(document).on('click', '.block-attribute .delete-attribute', function() {
        //click bỏ tích
        let _this = $(this);
        _this.parents('tr').remove();
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/course/backend/course/attribute.blade.php ENDPATH**/ ?>
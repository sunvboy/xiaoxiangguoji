@push('javascript')
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
    // Click "Thêm mới"
    $(document).on('click', '.block-version .show-version', function(e) {
        e.preventDefault();
        let _this = $(this);
        _this.parent('div').find('.hide-version').show();
        _this.hide();
        _this.parents('.block-version').find('.ibox-content').show();
    });
    // Click "Đóng"
    $(document).on('click', '.block-version .hide-version', function(e) {
        e.preventDefault();
        let _this = $(this);
        _this.parents('.block-version').find('.show-version').show();
        _this.parents('.block-version').find('.hide-version').hide();
        _this.parents('.block-version').find('.ibox-content').hide();
    });
    var attribute_catalogue = [];
    //Click " Thêm thuộc tính cho sản phẩm"
    $(document).on('click', '.add-attribute', function() {
        let _this = $(this);
        let attr = _this.attr('data-attribute');
        $('.block-attribute').find('table tbody').append(render_attribute(attr, attribute_catalogue));
        check_attribute();
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
        check_attribute(_this);
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
    //click "Sản phảm biến thể"
    $(document).on('click', 'input[name="checkbox[]"]', function() {
        let val = $(this).parents('td').find('input[name="checkbox_val[]"]').val();
        if (val == 1) {
            $(this).parents('td').find('input[name="checkbox_val[]"]').val(0);
        } else {
            $(this).parents('td').find('input[name="checkbox_val[]"]').val(1);
        }
        let check = $('input[name="checkbox[]"]:checked').length;
    });

    function render_select2(condition = '', index = '') {
        return '<select name="attribute[' + index + '][]" data-condition="' + condition + '" data-json="" data-stt="' + index + '" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes"  style="width: 100%;"></select>';
    }

    function check_attribute(_this = '') {
        attribute_catalogue = new Array();
        $('.block-attribute select[name="attribute_catalogue[]"]').each(function() {
            let val = $(this).find('option:selected').val();
            if (val != 0) {
                attribute_catalogue.push(val);
            }
        });
        // xóa hết disable đi
        $('.block-attribute select[name="attribute_catalogue[]"]').find("option").removeAttr("disabled");
        for (let i = 0; i < attribute_catalogue.length; i++) {
            // thêm disable ở những cái nào trong mảng
            $('.block-attribute select[name="attribute_catalogue[]"]').find("option[value=" + attribute_catalogue[i] + "]").prop('disabled', !$('#one').prop('disabled'));
            $('.block-attribute select[name="attribute_catalogue[]"]').select2();
        }
        // // nếu cái option nào được chọn thì xóa disable cua nó đi
        $('.block-attribute select[name="attribute_catalogue[]"]').find("option:selected").removeAttr("disabled");
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
        html = html + '<td class="s_tdVariable ' + classType + '" data-index="' + index + '" style="width: 10%">';
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

    function updateTitleJson(text = '') {
        $('.js_add_option').removeClass('active');
        $('input[value="' + text + '"]').parent().addClass('active');
        $('.js_add_option.active').next().each(function() {
            var arrayTitle = $(this).val().split('-');
            var titleJsonNew = '';
            arrayTitle.forEach(function(v, i) {
                if (v != text && v != '') {
                    titleJsonNew += v + '-';
                }
            })
            $(this).val(titleJsonNew);
        });
    }
    /*CLICK: 'Sản phẩm biến thể'*/
    $(document).on('change', '.block-attribute input[name="checkbox[]"]', function() {
        if ($(this).is(':checked')) {
            var _this = $(this).parent().parent();
            var id = _this.find('select[name="attribute_catalogue[]"]').val();
            if (id > 0) {
                if (attributes.length == 0) {
                    attributes[id] = [];
                    var index = _this.find('td:first-child').attr('data-index');
                    _this.find('select[name="attribute[' + index + '][]"] option:selected').each(function() {
                        attributes[id].push($(this).text());
                    });
                    get_vesion(attributes);
                    console.log("click check box == 1");
                    console.log('Sản phẩm biến thể attributes', attributes);
                } else {
                    var index = _this.find('td:first-child').attr('data-index');
                    var attributesNew = new Array();
                    attributesNew[id] = [];
                    attributes[id] = [];
                    _this.find('select[name="attribute[' + index + '][]"] option:selected').each(function() {
                        attributesNew[id].push($(this).text());
                    });
                    if (attributesNew[id].length > 0) {
                        //lấy tất cả item checkbox
                        var attributesE = new Array();
                        $('.checkbox-item:checked').each(function() {
                            var idE = $(this).parent().parent().find('select[name="attribute_catalogue[]"]').val();
                            attributesE[idE] = [];
                            $(this).parent().parent().find('select.selectMultipe option:selected').each(function() {
                                attributesE[idE].push($(this).text());
                            });
                        });
                        attributesNew[id].forEach(function(value, index) {
                            if (index == 0) {
                                attributesE[id] = attributesE[id].filter(item => item != value);
                                $('input[name="title_version[]"]').each(function() {
                                    $(this).val($(this).val() + '&&&&' + value);
                                });
                                var addHtml = '';
                                // addHtml = addHtml + '<input type="hidden" name="title_check[]" value="' + value + '">';
                                addHtml = addHtml + '<span class="text-xs whitespace-nowrap text-success bg-success/20 pending  pending-success/20 rounded-full px-2 py-1 mr-1 ">' + value + '</span >';
                                $('.js_add_option').append(addHtml);
                            }
                            attributes[id].push(value);
                        })
                        //end
                        get_vesion(attributesE);
                        console.log("click check box > 1");
                        console.log('attributesNew', attributesNew[id]);
                        console.log('attributesE', attributesE);
                        console.log('attributes', attributes);
                    }
                }
            }
        } else {
            /*Bỏ tích: Sản phẩm biến thể*/
            var _thisRV = $(this).parent().parent();
            var idRV = _thisRV.find('select[name="attribute_catalogue[]"] option:selected').val();
            var lengthCheckboxRV = $('.checkbox-item:checked').length;
            // console.log('lengthCheckboxRV ', lengthCheckboxRV);
            const allowed = [idRV];
            // console.log('allowed', allowed);
            //cập nhập lại data => attributes
            attributes = Object.keys(attributes)
                .filter(key => !allowed.includes(key))
                .reduce((obj = [], key) => {
                    obj[key] = attributes[key];
                    return obj;
                }, []);
            _thisRV.find('select.selectMultipe option:selected').each(function(key, value) {
                var text = $(this).text();
                //update title_json
                updateTitleJson(text);
                //end
                if (key == 0) {
                    if (lengthCheckboxRV == 0) {
                        $('input[value="' + text + '"]').parent().parent().parent().remove();
                    } else {
                        $('input[value="' + text + '"]').next().remove();
                        $('input[value="' + text + '"]').remove();
                    }
                }
                if (key > 0) {
                    $('input[value="' + $(this).text() + '"]').parent().parent().parent().remove();
                }
            });
            $(this).parent().parent().find('.checkbox-item').removeAttr("checked");
            // console.log("click bỏ tích checkbox attributes", attributes);
        }
    });
    /*change: Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy) */
    $(document).on('select2:select', '.selectMultipe', function(e) {
        var lengthCheckbox = $(this).parent().parent().find('.checkbox-item:checked').length;
        $(this).parent().parent().find('.checkbox-item').removeAttr("disabled");
        var index = $(this).parent().parent().find('td:first-child').attr('data-index');
        var id = $(this).parent().parent().find('select[name="attribute_catalogue[]"] option:selected').val();
        if (lengthCheckbox > 0) {
            // if (attributes.length > 1) {
            //     tmp_array_remove.forEach(function(data, index) {
            //         attributes[index] = attributes[index].concat(data);
            //     });
            //     tmp_array_remove = new Array();
            // }
            // let attributesNew = attributes.filter((person, i) => i != id);
            var attributesE = new Array();
            $('.checkbox-item:checked').each(function() {
                var idE = $(this).parent().parent().find('select[name="attribute_catalogue[]"]').val();
                attributesE[idE] = [];
                $(this).parent().parent().find('select.selectMultipe option:selected').each(function() {
                    attributesE[idE].push($(this).text());
                });
            });
            attributesE[id] = attributesE[id].filter(item => item == e.params.data.text);
            attributes[id].push(e.params.data.text);
            console.log("click thêm thuộc tính attributes", attributesE);
            get_vesion(attributesE);
        }
    });
    /*click bỏ: : Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy) */
    $(document).on('select2:unselect', '.block-attribute select', function(e) {
        var text = e.params.data.text;
        var id = $(this).parent().parent().find('select[name="attribute_catalogue[]"] option:selected').val();
        var index = $(this).parent().parent().find('td:first-child').attr('data-index');
        var check = $(this).parent().find('select[name="attribute[' + index + '][]"] option:selected').length;
        var lengthCheckbox = $('.checkbox-item:checked').length;
        //update title_json
        updateTitleJson(text);
        //end
        if (check == 0 && lengthCheckbox > 1) {
            $('input[value="' + text + '"]').next().remove();
            $('input[value="' + text + '"]').remove();
            $(this).parent().parent().removeClass('bg-active');
            $(this).parent().parent().find('.checkbox-item').removeAttr("checked");
            $(this).parent().parent().find('.checkbox-item').prop("disabled", true);
        } else {
            if (check == 0) {
                $(this).parent().parent().removeClass('bg-active');
                $(this).parent().parent().find('.checkbox-item').removeAttr("checked");
                $(this).parent().parent().find('.checkbox-item').prop("disabled", true);
            }
            $('input[value="' + text + '"]').parent().parent().parent().remove();
        }
        if (attributes.length > 0) {
            attributes[id] = attributes[id].filter(person => person != text);
        }
        console.log("click bỏ thuộc tính " + text);
        console.log(attributes);
    });
    //Click "Xóa category attributes"
    $(document).on('click', '.block-attribute .delete-attribute', function() {
        //click bỏ tích
        var _thisRV = $(this).parent().parent();
        var idRV = _thisRV.find('select[name="attribute_catalogue[]"] option:selected').val();
        var lengthCheckboxRV = $('.checkbox-item:checked').length;
        console.log(lengthCheckboxRV);
        const allowed = [idRV];
        //cập nhập lại data => attributes
        attributes = Object.keys(attributes)
            .filter(key => !allowed.includes(key))
            .reduce((obj = [], key) => {
                obj[key] = attributes[key];
                return obj;
            }, []);
        // console.log(attributes);
        _thisRV.find('select.selectMultipe option:selected').each(function(key, value) {
            var text = $(this).text();
            //update title_json
            updateTitleJson(text);
            //end
            if (key == 0) {
                if (lengthCheckboxRV == 1) {
                    $('input[value="' + text + '"]').parent().parent().parent().remove();
                } else {
                    $('input[value="' + text + '"]').next().remove();
                    $('input[value="' + text + '"]').remove();
                }
            }
            if (key > 0) {
                $('input[value="' + text + '"]').parent().parent().parent().remove();
            }
        });
        $(this).parent().parent().find('.checkbox-item').removeAttr("checked");
        console.log("click xóa danh mục thuộc tính");
        console.log(attributes);
        let _this = $(this);
        _this.parents('tr').remove();
        let val = _this.parents('tr').find('select[name="attribute_catalogue[]"] option:checked').val();
        $('.block-attribute select[name="attribute_catalogue[]"]').find("option[value=" + val + "]").prop('disabled', false);
        $('.block-attribute select[name="attribute_catalogue[]"]').select2("destroy").select2();
        check_attribute();
        let pos = attribute_catalogue.indexOf(val);
        attribute_catalogue.splice(pos, 1);
        $countAttr = $('.block-attribute table tbody').find('tr').length;
        $countattribute_catalogue = $('.block-version').attr('data-countattribute_catalogue');
        if (parseFloat($countAttr) >= parseFloat($countattribute_catalogue)) {
            $('.add-attribute').hide()
        } else {
            $('.add-attribute').show()
        }
    });

    function get_vesion(attributesVersion = []) {
        let price_old = $('input[name="price"]').val();
        let price_sale = $('input[name="price_sale"]').val();
        let price_import = $('input[name="price_import"]').val();
        let weight = $('input[name="ships[weight]"]').val();
        let length = $('input[name="ships[length]"]').val();
        let width = $('input[name="ships[width]"]').val();
        let height = $('input[name="ships[height]"]').val();
        var attrs = [];
        for (const [attr, values] of Object.entries(attributesVersion))
            attrs.push(values.map(v => ({
                [attr]: v
            })));
        attrs = attrs.reduce((a, b) => a.flatMap(d => b.map(e => ({
            ...d,
            ...e,
        }))));
        var item = '';
        var stt = $('.dd3-content').length;
        attrs.forEach(function(data, index) {
            stt++;
            var code = $('input[name="code"]').val() + '-' + stt;
            item = item + '<div class="mb-2 dd3-content">';
            item = item + '<div class="relative flex items-center">';
            item = item + '<input type="checkbox" name="" value="" class="mr-3 cursor-pointer s_checkboxItem">';
            item = item + '<img src="<?php echo url('images/404.png') ?>" class="mr-3 s_imgAvatar" style="width: 45px;height: 45px;object-fit: cover;">';
            item = item + '<a href="javascript:void(0)" class="form-label mb-0 accordion w-full js_add_option ">';
            var title = '';
            $.each(data, function(i, v) {
                if (i == 0) {
                    title += v;
                } else {
                    title += '&&&&' + v
                }
                item = item + '<input type="hidden" name="title_check[]" value="' + v + '">';
                item = item + '<span class="text-xs whitespace-nowrap text-success bg-success/20 pending  pending-success/20 rounded-full px-2 py-1 mr-1 ' + slug(v) + '">' + v + '</span >';
            })
            item = item + '</a>';
            item = item + '<input type="hidden" name="title_version[]" value="' + title + '">';
            item = item + '<a href="javascript:void(0)" class="text-danger version_remove" data-number="1">Xóa</a>';
            item = item + '</div>';
            item = item + '<div class="version_item_size hidden">';
            item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
            item = item + '<div class="">';
            item = item + '<label class="form-label">Hình ảnh</label>';
            item = item + '<div class="flex items-center space-x-3">';
            item = item + '<div class="avatar" style="cursor: pointer;flex:none">';
            item = item + '<img src="<?php echo url('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">';
            item = item + '</div>';
            item = item + '<input type="text" name="image_version[]" style="cursor: not-allowed;opacity: 0.56;" value="" class="form-control" placeholder="Đường dẫn của ảnh" autocomplete="off">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div>';
            item = item + '<label class="form-label">Mã sản phẩm</label>';
            item = item + '<input type="text" name="code_version[]" value="' + code + '" class="form-control" placeholder="" >';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="grid grid-cols-3 gap-3 mt-3">';
            item = item + '<div class="">';
            item = item + '<label class="form-label">Giá nhập</label>';
            item = item + '<input type="text" value="' + price_import + '" name="price_import_version[]" class="form-control int price" placeholder="">';
            item = item + '</div>';
            item = item + '<div>';
            item = item + '<label class="form-label">Giá</label>';
            item = item + '<input type="text" value="' + price_old + '" name="price_version[]" class="form-control int price" placeholder="">';
            item = item + '</div>';
            item = item + '<div class="">';
            item = item + '<label class="form-label">Giá ưu đãi</label>';
            item = item + '<input type="text" value="' + price_sale + '" name="price_sale_version[]" class="form-control int price" placeholder="">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="mt-3">';
            item = item + '<h2 class="font-bold text-base mr-auto">Quản lý tồn kho</h2>';
            item = item + '<div class="mt-3">';
            item = item + '<div class="form-switch">';
            /*item = item + '<select class="form-select selectStock" name="_stock_status[]">';
            item = item + '<option value="0" selected>Không quản lý</option>';
            item = item + '<option value="1" >Có quản lý tồn kho</option>';
            item = item + '</select>'; */
            item = item + '<input type="text" name="_stock_status[]" value="0" class="hidden">';
            item = item + '<div class="form-check">';
            item = item + '<input id="horizontal-form-' + stt + '" class="form-check-input selectStock" type="checkbox" value="1">';
            item = item + '<label class="form-check-label" for="horizontal-form-' + stt + '">Quản lý tồn kho</label>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="showStock hidden">';
            item = item + '<div class="mt-3">';
            item = item + '<input type="text" name="_outstock_status[]" value="0" class="hidden">';
            item = item + '<div class="form-check">';
            item = item + '<input id="horizontal-status-' + stt + '" class="form-check-input selectStockStatus" type="checkbox" value="1">';
            item = item + '<label class="form-check-label" for="horizontal-status-' + stt + '">Đồng ý cho đặt hàng khi đã hết hàng</label>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="flex mt-3 gap-6">';
            item = item + '<div class="w-1/2">';
            item = item + '<div>';
            item = item + '<label class="form-label text-base font-semibold">Cân nặng(gram)</label>';
            item = item + '<input type="text" value="' + weight + '" name="_ships_weight[]" class="form-control" placeholder="">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="w-1/2">';
            item = item + '<div>';
            item = item + '<label class="form-label text-base font-semibold">Kích cỡ(DxRxC)</label>';
            item = item + '<div class="flex gap-2">';
            item = item + '<div class="w-1/3">';
            item = item + '<input type="text" value="' + length + '" name="_ships_length[]" class="form-control" placeholder="">';
            item = item + '</div>';
            item = item + '<div class="w-1/3">';
            item = item + '<input type="text" value="' + width + '" name="_ships_width[]" class="form-control" placeholder="">';
            item = item + '</div>';
            item = item + '<div class="w-1/3">';
            item = item + '<input type="text" value="' + height + '" name="_ships_height[]" class="form-control" placeholder="">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
        })
        $('#table_version').append(item);
        $('#table_version').show();
    }
    /*xóa phiên bản sản phẩm */
    $(document).on('click', '.version_remove', function() {
        $(this).parent().parent().remove();
    })
    /*click show chi tiết kích thước trong màu sắc */
    $(document).on('click', '.accordion', function() {
        $(this).parent().parent().find('.version_item_size').toggleClass('hidden');
    })
    $(document).on('click', '.selectStock', function() {
        var value = $(this).parent().parent().find('.selectStock:checked').val();
        console.log(value);
        if (value == 1) {
            $(this).parent().parent().parent().parent().find('.showStock').removeClass('hidden');
            $(this).parent().parent().find('input[name="_stock_status[]"]').val(1);
        } else {
            $(this).parent().parent().parent().parent().find('.showStock').addClass('hidden');
            $(this).parent().parent().find('input[name="_stock_status[]"]').val(0);
        }
    })
    $(document).on('click', '.selectStockStatus', function() {
        var value = $(this).parent().parent().find('.selectStockStatus:checked').val();
        console.log(value);
        if (value == 1) {
            $(this).parent().parent().find('input[name="_outstock_status[]"]').val(1);
        } else {
            $(this).parent().parent().find('input[name="_outstock_status[]"]').val(0);
        }
    })
    $(document).on('keyup', '.js_stock_address_value', function() {
        var total = 0;
        var list = $(this).parent().parent().parent();
        list.find('.js_stock_address_value').each(function(idx, li) {
            var value = $(this).val();
            if (value > 0) {
                value = value.replace(".", "");
                total += parseInt(value);
            }
        });
        $(this).parent().parent().parent().parent().parent().parent().parent().find('input[name="_stock[]"]').val(total)
    })
</script>
<script>
    $(document).on('click', '.s_popupSelectImg', function(e) {
        e.preventDefault();
        var html = '';
        html += '<div class="h-32 box_uploadImg">'
        html += '<div class="h-full bg-slate-100 dark:bg-darkmode-400 rounded-md">'
        html += '<h3 class="h-full font-medium flex items-center justify-center text-2xl cursor-pointer s_thumbnail"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-plus" data-lucide="file-plus" class="lucide lucide-file-plus block mx-auto"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></h3>'
        html += '</div>'
        html += '</div>'
        $('input[name="album[]"]').each(function() {
            html += '<div class="h-32 box_Img">';
            html += '<div class="h-full bg-slate-100 dark:bg-darkmode-400 rounded-md">'
            html += '<a href="javascript:void(0)" data-src="' + $(this).val() + '" class="s_changeImg"><img src="' + $(this).val() + '" class="h-32 rounded-md w-full cursor-pointer"></a>'
            html += '</div>'
            html += '</div>'
        })
        $('.s_listSelectImg').html(html)
    })
    $(document).on('click', '.s_changeImg', function(e) {
        $('.s_changeImg').removeClass('active')
        $('.s_changeImg .MuiSvgIcon-root').remove()
        $(this).addClass('active')
        $(this).append('<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>')
        e.preventDefault();
        var src = $(this).attr('data-src');
        $('.s_inputImg').val(src)
    })
    $(document).on("click", ".s_thumbnail", function() {
        CKFinder.modal({
            chooseFiles: true,
            width: 1000,
            height: 700,
            top: 0,
            onInit: function(finder) {
                finder.on('files:choose', function(evt) {
                    var file = evt.data.files.first();
                    var url = escapeHtml(file.getUrl());
                    var html = '';
                    html += '<div class="h-32 box_Img">';
                    html += '<div class="h-full bg-slate-100 dark:bg-darkmode-400 rounded-md">'
                    html += '<a href="javascript:void(0)" data-src="' + url + '" class="s_changeImg"><img src="' + url + '" class="h-32 rounded-md w-full cursor-pointer"></a>'
                    html += '</div>'
                    html += '</div>'
                    $('.box_uploadImg').after(html)
                });
            }
        });
    });
    $(document).on('click', '.s_saveImg', function(e) {
        var src = $('.s_inputImg').val()
        if (src == '') {
            $('.s_errorUploadImg').show()
            return false
        }
        $(".s_checkboxItem").each(function() {
            if ($(this).is(":checked")) {
                $(this).parent().find('.s_imgAvatar').attr("src", src);
                $(this).parent().parent().find('.img-thumbnail').attr("src", src);
                $(this).parent().parent().find('input[name="image_version[]"]').val(src);
            }
        });
        $('.s_errorUploadImg').hide()
        const myModal = tailwind.Modal.getInstance(document.querySelector("#superlarge-modal-size-preview"));
        myModal.hide();
    })
    $(document).on("click", ".s_checkAll", function() {
        let _this = $(this);
        if (_this.prop("checked")) {
            $(".s_checkboxItem").prop("checked", true);
        } else {
            $(".s_checkboxItem").prop("checked", false);
        }
        s_change_background();
        $('.s_updateImg').removeClass('hidden')
    });
    $(document).on("click", ".s_checkboxItem", function() {
        if ($(".s_checkboxItem").length) {
            if ($(".s_checkboxItem:checked").length == $(".s_checkboxItem").length) {
                $(".s_checkAll").prop("checked", true);
            } else {
                $(".s_checkAll").prop("checked", false);
            }
        }
        s_change_background();
        $('.s_updateImg').removeClass('hidden')
    });

    function s_change_background() {
        $(".s_checkboxItem").each(function() {
            if ($(this).is(":checked")) {
                $(this).parent().addClass("bg-active");
            } else {
                $(this).parent().removeClass("bg-active");
            }
        });
    }
</script>
<script>
    $(document).on('click', '.s_popupPriceAttr', function(e) {
        var title = $(this).attr('data-title');
        var type = $(this).attr('data-type');
        $('#modalPriceAttr input[name="price"]').attr('placeholder', title)
        $('#modalPriceAttr input[name="typeModal"]').val(type)
    })
    $(document).on('click', '.s_savePrice', function(e) {
        var price = $('#modalPriceAttr input[name="price"]').val();
        var type = $('#modalPriceAttr input[name="typeModal"]').val();
        $(".s_checkboxItem").each(function() {
            if ($(this).is(":checked")) {
                if (type === 'price_import') {
                    $(this).parent().parent().find('input[name="price_import_version[]"]').val(price);
                } else if (type === 'price_sale') {
                    $(this).parent().parent().find('input[name="price_sale_version[]"]').val(price);
                } else {
                    $(this).parent().parent().find('input[name="price_version[]"]').val(price);
                }
            }
        });
    })
</script>
<script>
    $(document).on('click', '.s_save_ships_weight', function(e) {
        var weight = $('#modal_ships_weight input[name="_ships_weight_modal"]').val();
        var length = $('#modal_ships_weight input[name="_ships_length_modal"]').val();
        var width = $('#modal_ships_weight input[name="_ships_width_modal"]').val();
        var height = $('#modal_ships_weight input[name="_ships_height_modal"]').val();
        console.log(length)
        $(".s_checkboxItem").each(function() {
            if ($(this).is(":checked")) {
                $(this).parent().parent().find('input[name="_ships_weight[]"]').val(weight);
                $(this).parent().parent().find('input[name="_ships_length[]"]').val(length);
                $(this).parent().parent().find('input[name="_ships_width[]"]').val(width);
                $(this).parent().parent().find('input[name="_ships_height[]"]').val(height);
            }
        });
    })
</script>
<script>
    $(document).on('change', '#checkbox-switch-stock', function(e) {
        if ($(this).is(":checked")) {
            $('.s_box_stock_status').removeClass('hidden')
            $('.s_box_stock_status input').prop('checked', false);
        } else {
            $('.s_box_stock_status').addClass('hidden')
        }
    })
    $(document).on('click', '.s_save_stock', function(e) {
        var stock_status = 0;
        if ($('.s_box_stock_status input').is(":checked")) {
            stock_status = 1;
        }
        if ($('#checkbox-switch-stock').is(":checked")) {
            $(".s_checkboxItem").each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().find('input.selectStock').prop('checked', true);
                    $(this).parent().parent().find('.showStock').removeClass('hidden');
                    $(this).parent().parent().find('input[name="_stock_status[]"]').val(1);
                }
            });
        } else {
            $(".s_checkboxItem").each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().find('input.selectStock').prop('checked', false);
                    $(this).parent().parent().find('input[name="_stock_status[]"]').val(0);
                }
            });
        }
        if (stock_status) {
            $(".s_checkboxItem").each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().find('input.selectStockStatus').prop('checked', true);
                    $(this).parent().parent().find('input[name="_outstock_status[]"]').val(1);
                }
            });
        } else {
            $(".s_checkboxItem").each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().find('input.selectStockStatus').prop('checked', false);
                    $(this).parent().parent().find('input[name="_outstock_status[]"]').val(0);
                }
            });
        }
    })
</script>
<style>
    .bg-active {
        background-color: #ffc !important
    }

    #superlarge-modal-size-preview {
        z-index: 99 !important;
    }

    .s_changeImg.active {
        position: relative;
    }

    .s_changeImg.active::before {
        position: absolute;
        content: '';
    }

    .MuiSvgIcon-root {
        position: absolute;
        width: 30px;
        height: 30px;
        bottom: 0px;
        right: 0px;
    }

    .MuiSvgIcon-root path {
        fill: #0088FF;
    }

    .dd3-content {
        display: block;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        line-height: 32px;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 0;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        position: relative;
    }

    .dd3-content .relative {
        padding-left: 10px;
        height: 45px;
        line-height: 45px;
    }

    .version_remove {
        position: absolute;
        right: 15px;
        top: 50%;
        text-align: center;
        text-indent: 0px;
        transform: translateY(-50%);
    }

    .version_item_size {
        padding: 20px;
        background: #fff;
    }

    #table_version td {
        padding: 5px
    }

    .checkbox-item:disabled {
        cursor: not-allowed;
        background-color: rgb(241, 245, 249, 1);
    }
</style>
@endpush
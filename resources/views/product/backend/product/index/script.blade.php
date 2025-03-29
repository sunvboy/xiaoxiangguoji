<script>
    /*tìm kiếm theo kí tự*/
    $(document).on('change', 'select[name="catalogue_id"]', function(e) {
        let _this = $(this);
        let catalogue_id = _this.val();

        $.post(BASE_URL_AJAX + "products/ajax/get-attrid", {
                catalogue_id: catalogue_id,
                "_token": $('meta[name="csrf-token"]').attr("content"),
            },
            function(data) {
                let json = JSON.parse(data);
                let html = '';
                let attribute_catalogue1 = json.attribute_catalogue;
                if (attribute_catalogue1 == '') {
                    html = '<li> Danh mục không có thuộc tính</li>';
                } else {
                    html = attribute_catalogue1;
                }
                $('.list_attr_catalogue').html('').html(html).show();
            });
    });
    $(document).on('click', '.attr', function() {
        if ($(this).find('input[name="attr[]"]:checked').length) {
            $(this).find('input[name="attr[]"]').prop('checked', false);
            $(this).find('.label-checkboxitem').removeClass('checked');
        } else {
            $(this).find('input[name="attr[]"]').prop('checked', true);
            $(this).find('.label-checkboxitem').addClass('checked');
        }
        let attr = '';
        $('#selected_attr').html('');
        $('input[name="attr[]"]:checked').each(function(key, index) {
            let id = $(this).val();
            let text = $(this).parent('div').text();
            let attr_id = $(this).parents('li').attr('data-keyword');
            attr = attr + attr_id + ';' + id + ';';
            $('#selected_attr').append(
                '<label class="btn btn-primary show mb-2 mr-2 btn-sm del"  data-id="' + id + '">' +
                text +
                '<span>&nbsp;x</span></label>');
        });
        if (attr == '') {
            $('#selected_attr').html('<span>Chọn thuộc tính</span>');
        }
        $('#choose_attr > input').val(attr).change();
    })
    $(document).on('click', '#selected_attr .del', function() {
        let _this = $(this);
        let id = _this.attr('data-id');
        let attr = '';
        $('input[name="attr[]"]:checked').each(function(key, index) {
            let id_check = $(this).val();
            if (id == id_check) {
                $(this).prop('checked', false);
                $(this).parent('div').find('label').removeClass('checked');
                _this.remove();
            } else {
                let text = $(this).parent('div').text();
                let attr_id = $(this).parents('li').attr('data-keyword');
                attr = attr + attr_id + ';' + id_check + ';';
            }
        });
        $('#choose_attr > input').val(attr).change();
    })
    $(document).on('click', '#choose_attr', function() {
        if ($('input[name="attr[]"]:checked').length == 0) {
            $('#choose_attr').find('.form-control').html('<span>Chọn thuộc tính</span>');
        }
        $('#choose_attr').find('.list_attr_catalogue').show();
    })
    /*xử lý khoảng giá*/
    $(document).on('click', '#filter_price div:eq(0)', function() {
        console.log(1);
        let _this = $(this);
        $('#filter_price').find('div:eq(1)').show();
    })
    $(document).mouseup(function(e) {
        let start_price = $('#filter_price').find('input[name="start_price"]').val();
        let end_price = $('#filter_price').find('input[name="end_price"]').val();
        if (start_price == 0 && end_price == 0) {
            let container = $("#filter_price div:eq(1)");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        }
        start_price = replace(start_price);
        end_price = replace(end_price);
        if (parseFloat(start_price) < parseFloat(end_price)) {
            let container = $("#filter_price div:eq(1)");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        }
    });
    $(document).on('change', 'input[name="start_price"], input[name="end_price"]', function() {
        let _this = $(this);
        let start_price = _this.parent('div').find('input[name="start_price"]').val();
        let end_price = _this.parent('div').find('input[name="end_price"]').val();
        start_price = replace(start_price);
        end_price = replace(end_price);
        if (end_price != 0) {
            if (parseFloat(start_price) >= parseFloat(end_price)) {
                toastr.warning('Giá bắt đầu không thể nhỏ hơn giá kết thúc', '');
            } else {
                _this.parents('#filter_price').find('div:eq(0)').html('Giá từ <b>' + addCommas(start_price) +
                    '</b> đ đến <b>' + addCommas(end_price) + '</b> đ');
                _this.find('div:eq(1)').slideToggle();
            }
        }
    })
    /*tìm kiếm nâng cao*/
    $(document).on('click', '.full-search', function(e) {
        e.preventDefault();
        $('.filter-more').toggleClass('hidden');
        if ($('.filter-more').hasClass('filter-more-open')) {
            $('.full-search').html('Bỏ tìm kiếm nâng cao ');
        } else {
            $('.full-search').html('Tìm kiếm nâng cao');
            $('.filter-more').find('input').trigger('change');
            $('.filter-more').find('select').trigger('change');
        }
    })
    /*filter search*/
    var time;
    $(document).on('keyup change', '.filter', function() {
        let page = $('.pagination .active a').text();
        time = setTimeout(function() {
            get_list_object(page);
        }, 500);
        return false;
    });
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        get_list_object(page);
    });

    function get_list_object(page = 1) {

        let keyword = $('.keyword').val();
        let catalogue_id = $('.catalogue_id').val();
        let brand = $('select[name="brands[]"]').val();
        let tag = $('select[name="tags[]"]').val();
        let start_price = $('input[name="start_price"]').val();
        let end_price = $('input[name="end_price"]').val();
        let attr = $('input[name="attr"]').val();
        let type = $('select[name="type"]').val();

        let ajaxUrl = BASE_URL_AJAX + 'products/ajax/list-product';
        $.get(ajaxUrl, {
                keyword: keyword,
                page: page,
                catalogue_id: catalogue_id,
                brand: brand,
                tag: tag,
                attr: attr,
                start_price: start_price,
                end_price: end_price,
                type: type,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#data_product').html(data);
            });
    }
    /*START: Xóa 1 bản ghi*/
    $(document).on("click", ".ajax-delete-product", function(e) {
        e.preventDefault();

        let _this = $(this);
        let param = {
            title: _this.attr("data-title"),
            id: _this.attr("data-id"),
        };
        let parent = _this.attr("data-parent"); /*Đây là khối mà sẽ ẩn sau khi xóa */
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: param.title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = '<?php echo route('products.delete') ?>';
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: param.id,
                        },
                        success: function(data) {
                            if (data.code === 200) {
                                $(".post-" + param.id).remove();
                                swal({
                                    title: "Xóa thành công!",
                                    text: "Sản phẩm đã được xóa khỏi danh sách.",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(jqXhr, json, errorThrown) {
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = "";
                            $.each(errors["errors"], function(index, value) {
                                errorsHtml += value + "/ ";
                            });
                            $("#myModal .alert").html(errorsHtml).show();
                        },
                    });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            }
        );
    });
    /*END: Xóa 1 bản ghi*/

    /*START: XÓA tất cả bản ghi */
    $(document).on('change', '.ajax-delete-all-product', function() {
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        $('.checkbox-item:checked').each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error"
            }, function() {
                location.reload();
            });
            return false;
        }
        let param = {
            'title': _this.attr('data-title'),
            'list': id_checked,
        }
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: param.title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo route('products.deleteAll') ?>',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            param: param
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                for (let i = 0; i < id_checked.length; i++) {
                                    $('#post-' + id_checked[i]).hide().remove()
                                }
                                swal({
                                    title: "Xóa thành công!",
                                    text: "Các bản ghi đã được xóa khỏi danh sách.",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            });
    });
    /*END: XÓA tất cả bản ghi */
</script>
@push('javascript')
<script>
    $(document).on('click', '.js_showExcel', function(e) {
        $(this).addClass('hidden')
        $('.js_hideExcel').removeClass('hidden')
        $('.html_boxExcel').removeClass('hidden')
    })
    $(document).on('click', '.js_hideExcel', function(e) {
        $(this).addClass('hidden')
        $('.js_showExcel').removeClass('hidden')
        $('.html_boxExcel').addClass('hidden')

    })
    $(document).on('click', '.js_handleDownExcel', function(e) {
        e.preventDefault()
        var date_start = $('input[name="date_start_excel"]').val()
        var date_end = $('input[name="date_end_excel"]').val()
        var user_id = $('select[name="user_id"]').val()
        var status_excel = $('select[name="status_excel"]').val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "<?php echo route('deals.invoices.ajax.export') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                date_start: date_start,
                date_end: date_end,
                user_id: user_id,
                status: status_excel,
            },
            success: function(data) {

                window.open(data.file);
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = "";
                $.each(errors["errors"], function(index, value) {
                    errorsHtml += value + "/ ";
                });
                console.log(errorsHtml)
            },
        });
    })
</script>
<script>
    new TomSelect(".tom-select-field-category", {
        plugins: [{
            remove_button: {
                title: 'Remove this item',
            },

        }],
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect(".tom-select-field-status", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
<script type="text/javascript">
    $(function() {
        $('input[name="date_start_excel"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="date_end_excel"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
    });
    $(document).on("click", ".ajax-delete-invoices", function(e) {
        e.preventDefault();

        let _this = $(this);
        let param = {
            title: _this.attr("data-title"),
            name: _this.attr("data-name"),
            module: _this.attr("data-module"),
            id: _this.attr("data-id"),
            router: _this.attr("data-router"),
            child: _this.attr("data-child"),
        };
        let parent =
            _this.attr("data-parent"); /*Đây là khối mà sẽ ẩn sau khi xóa */
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
                    let formURL = BASE_URL_AJAX + "ajax/ajax-delete";
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
                            module: param.module,
                            id: param.id,
                            router: param.router,
                            child: param.child,
                        },
                        success: function(data) {
                            if (data.code === 200) {
                                if (typeof parent != "undefined") {
                                    _this
                                        .parents("." + parent + "")
                                        .hide()
                                        .remove();
                                } else {
                                    _this.parent().parent().hide().remove();
                                }
                                if (param.child == 1) {
                                    $("#listData" + param.id).remove();
                                }

                                swal({
                                    title: "Xóa thành công!",
                                    text: "Hạng mục đã được xóa khỏi danh sách.",
                                    type: "success",
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error",
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
                        type: "error",
                    });
                }
            }
        );
    });
</script>
<style>
    .ts-control>* {
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        position: relative;
    }

    .ts-control {
        padding: 0.625rem;
        border-radius: 0.5rem;
    }

    .ts-dropdown [data-selectable] .highlight {
        background: rgba(255, 237, 40, .4) !important;
        border-radius: 1px;
    }

    .ts-wrapper.multi.has-items .ts-control {
        padding: calc(8px - 0px - 0px) 8px calc(8px - 0px - 3px - 0px);
    }
</style>
@endpush
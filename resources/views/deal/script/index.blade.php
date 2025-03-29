@push('javascript')
<script>
    $(document).on('click', '.js_handleCustomer', function(e) {
        var customer_id = $(this).attr('data-id')
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
            url: "{{route('deals.search')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                customer_id: customer_id,
            },
            success: function(data) {
                $('#data_product').html(data.html);
            }
        });
    })
</script>
<script>
    $(document).on('click', '.handle_updateDealView', function(e) {
        var id = $(this).val();
        var isChecked = $(this).is(":checked");
        var perpage = $('select[name="perpage"]').val();
        var customer_id = $('select[name="customer_id"]').val()
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var status = $('select[name="status"]').val()
        var date_end = $('input[name="date_end"]').val()
        var product = $('select[name="product"]').val()
        var source_date_start = $('input[name="source_date_start"]').val()
        var source_date_end = $('input[name="source_date_end"]').val()
        var keyword = $('input[name="keyword"]').val()
        var catalogue_child_id = $('select[name="catalogue_child_id"]').val()

        let sorts = []; /*Lấy id bản ghi */
        $(".js_sort.active").each(function() {
            sorts.push($(this).attr('data-value'));
        });
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: '<?php echo route('deals.ajax.updateDealView') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                isChecked: isChecked,
                type: "<?php echo $type ?>",
                active: "<?php echo $active ?>",
                handle: "update",
                sorts: sorts,
                customer_id: customer_id,
                catalogue_child_id: catalogue_child_id,
                catalogue_id: catalogue_id,
                status: status,
                catalogue_id: catalogue_id,
                date_end: date_end,
                product: product,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: false,
                perpage: perpage
            },
            success: function(data) {
                $('#data_product').html(data.html);
                $('.w3-table-all').scroltable();
            }
        });
    })
    $(document).on('click', '.js_sort', function(e) {
        e.preventDefault();
        $('input[name="sorts"]').val($(this).attr('data-value'))
        loadAjaxDataIndex()

    })
    $(document).on('click', '.js_sort_maintain ', function(e) {
        e.preventDefault();
        $('input[name="sorts"]').val($(this).attr('data-value'))
        loadAjaxDataIndex()

    })
    $(document).on('click', '.js_sort_website', function(e) {
        e.preventDefault();
        $('input[name="sorts"]').val($(this).attr('data-value'))
        loadAjaxDataIndex()

    })
    $(document).on('click', '.js_sort_vps', function(e) {
        e.preventDefault();
        $('input[name="sorts"]').val($(this).attr('data-value'))
        loadAjaxDataIndex()

    })
    $(document).on('click', '.btn-search-submit', function(e) {
        e.preventDefault();
        loadAjaxDataIndex()
    })
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadAjaxDataIndex(page);
        $("body,html").animate({
            scrollTop: 0
        }, 200);
    });
    //chọn số bản ghi trên trang
    $(document).on('change', '.js_perPage', function(e) {
        e.preventDefault()
        loadAjaxDataIndex()
    })
    // cập nhập giai đoạn
    $(document).on("change", ".js_changeStatus", function() {

        let _this = $(this);
        let status = _this.val();
        let active = _this.attr("data-active");
        let id_checked = []; /*Lấy id bản ghi */
        $(".checkbox-item:checked").each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error",
            });
            return false;
        }
        let page = $('.pagination .active span').text();

        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: "",
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
                    $.ajax({
                        type: "POST",
                        url: "<?php echo route('deals.ajax.updateStatus') ?>",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            id_checked: id_checked,
                            status: status,
                            active: active,
                        },
                        success: function(data) {
                            if (data.code == 200) {

                                //cập nhập giai đoạn về mặc định
                                _this.val($('.js_changeStatus option:first').val());
                                //load lại data
                                loadAjaxDataIndex(page)
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error",
                                });
                            }
                        },
                        complete: function() {
                            swal({
                                title: "Cập nhập giai đoạn thành công!",
                                text: "",
                                type: "success",
                            });
                        }
                    });
                } else {
                    swal({
                            title: "Hủy bỏ",
                            text: "Thao tác bị hủy bỏ",
                            type: "error",
                        },
                        function() {
                            location.reload();
                        }
                    );
                }
            }
        );
    });

    function loadAjaxDataIndex(page = 1) {
        var perpage = $('select[name="perpage"]').val();
        var sorts = $('input[name="sorts"]').val()
        var keyword = $('input[name="keyword"]').val()
        var keywordID = $('input[name="keywordID"]').val()
        var keywordDomain = $('input[name="keywordDomain"]').val()
        var customer_id = $('select[name="customer_id"]').val()
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var status = $('select[name="status"]').val()
        var date_end = $('input[name="date_end"]').val()
        var product = $('select[name="product"]').val()
        var catalogue_child_id = $('select[name="catalogue_child_id"]').val()
        var source_date_start = $('input[name="source_date_start"]').val()
        var source_date_end = $('input[name="source_date_end"]').val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.w3-table-all').scroltable();
                $('.lds-dual-ring-container').addClass('hidden')
            },
            url: '<?php echo route('deals.ajax.updateDealView') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                type: "<?php echo $type ?>",
                active: "<?php echo $active ?>",
                perpage: perpage,
                page: page,
                sorts: sorts,
                handle: "sort",
                customer_id: customer_id,
                catalogue_id: catalogue_id,
                status: status,
                catalogue_id: catalogue_id,
                date_end: date_end,
                product: product,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                keywordDomain: keywordDomain,
                keywordID: keywordID,
                catalogue_child_id: catalogue_child_id,
                company: false
            },
            success: function(data) {
                $('#data_product').html(data.html);
                $('.w3-table-all').scroltable();
            }
        });
    }
</script>
<!-- Cập nhập thay đổi ở index - gia hạn -->
@include('deal.script.change')
@endpush
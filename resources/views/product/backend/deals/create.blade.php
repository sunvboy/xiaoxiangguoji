@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới Mua Kèm Deal Sốc</title>
@endsection
<!--START: breadcrumb -->
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Mua Kèm Deal Sốc",
        "src" => route('product_deals.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
<!--END: breadcrumb -->
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới Mua Kèm Deal Sốc
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" id="submitFormDeals" role="form" action="{{route('product_deals.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-12">
            @csrf
            <!-- START: Box sản phẩm chính -->
            <div class="box p-5 mt-3">
                <input type="hidden" name="productOne" value="show">
                <div class="flex justify-between items-center">
                    <div class="font-bold text-lg uppercase">Sản Phẩm Chính</div>
                    <a href="javascript:void(0)" class="btn btn-danger addProduct1">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Thêm Sản phẩm
                    </a>
                    <a href="javascript:void(0)" class="btn btn-primary editProduct1" style="display: none;" onclick="editProduct1()">
                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Thay đổi
                    </a>
                </div>
                <div class="mt-5 space-y-3" style="display:none">
                    <div class="box-search relative flex items-center space-x-2 hideClickShowTwo">
                        <input type="text" class="form-control w-full inputSearchProductOne" placeholder="Tìm kiếm mã, tên sản phẩm">
                        <button type="button" class="btn btn-primary btnSearchProductOne">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div id="listsProductOne">
                        @include('product.backend.deals.common.product_one')
                    </div>
                    <div class="flex justify-end">
                        <a href="javascript:void(0)" class="btn btn-danger saveBox1" onclick="saveBox1()">Lưu</a>
                    </div>
                </div>
            </div>
            <!-- END: Box sản phẩm chính -->
            <!-- START: Box Sản Phẩm mua kèm -->
            <div class="box p-5 mt-3 box-product-two disabled">
                <input type="hidden" name="productTwo" value="show">
                <div class="flex justify-between items-center">
                    <div class="font-bold text-lg uppercase">Sản Phẩm mua kèm</div>
                    <a href="javascript:void(0)" class="btn btn-danger addProduct2">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Thêm Sản phẩm
                    </a>
                    <a href="javascript:void(0)" class="btn btn-primary editProduct2" style="display: none;" onclick="editProduct2()">
                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Thay đổi
                    </a>
                </div>
                <div class="mt-5 space-y-3" style="display:none">
                    <div class="box-search relative flex items-center space-x-2 hideClickShowOne">
                        <input type="text" class="form-control w-full inputSearchProductTwo" placeholder="Tìm kiếm mã, tên sản phẩm">
                        <button type="button" class="btn btn-primary btnSearchProductTwo">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div id="listsProductTwo">
                        @include('product.backend.deals.common.product_two')
                    </div>
                    <div class="flex justify-end">
                        <a href="javascript:void(0)" class="btn btn-danger saveBox2" onclick="saveBox2()">Lưu</a>
                    </div>
                </div>
            </div>
            <!-- END: Box Sản Phẩm mua kèm -->
            <div class="mt-3">
                <div class="text-right mt-5">
                    <button type="submit" id="btnSubmitDeal" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>

    </form>
</div>
<!-- BEGIN: Modal Content sản phẩm chính-->
<div id="modalProductOne" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto uppercase">Chọn Sản Phẩm</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <form method="" id="formSearchProduct" class="grid grid-cols-6 gap-4 gap-y-3">
                    @if(isset($catalogues))
                    <div class="col-span-2">
                        <?php echo Form::select('catalogues', $catalogues, '', ['class' => 'form-control tom-select tom-select-custom filter catalogue_id ', 'data-placeholder' => "Select your favorite actors"]); ?>
                    </div>
                    @endif
                    <div class="col-span-3">
                        <?php echo Form::text('keyword', request()->get('keyword'), ['class' => 'form-control ', 'placeholder' => 'Tìm kiếm mã, tên sản phẩm...', 'style' => 'height:42px']); ?>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Tìm kiếm
                    </button>
                </form>
                <div class="mt-5 scrollbar">
                    <div class="overflow-x-auto" id="data_product">
                        @include('product.backend.deals.common.product')
                    </div>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1">Hủy</button>
                <button type="button" class="btn btn-primary btnSubmitProductModal">Xác nhận</button>
            </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Modal-->
@endsection
@push('javascript')
<style>
    .scrollbar {
        height: 500px;
        overflow-y: scroll;
    }

    .scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar-thumb {
        background-color: #000000;
    }
</style>
<!-- ajax phân trang -->
<script type="text/javascript">
    $(document).on('click', '.addProduct1', function(event) {
        event.preventDefault();
        $.post("<?php echo route('product_deals.pagination') ?>", {
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#data_product').html(data);
                const myModal = tailwind.Modal.getInstance(document.querySelector("#modalProductOne"))
                $('.btnSubmitProductModal').removeClass('btnSubmitProductTwo').addClass('btnSubmitProductOne')
                myModal.show();
            });
    });
    $(document).on('click', '.addProduct2', function(event) {
        event.preventDefault();
        $.post("<?php echo route('product_deals.pagination') ?>", {
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#data_product').html(data);
                const myModal = tailwind.Modal.getInstance(document.querySelector("#modalProductOne"))
                $('.btnSubmitProductModal').removeClass('btnSubmitProductOne').addClass('btnSubmitProductTwo')
                myModal.show();
            });
    });
    $(document).on('click', '.paginationProduct a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        get_list_object(page);
    });
    $(document).on('submit', '#formSearchProduct', function(event) {
        event.preventDefault();
        get_list_object(1);
    });

    function get_list_object(page = 1) {
        $.post("<?php echo route('product_deals.pagination') ?>", {
                page: page,
                catalogues: $('#formSearchProduct select[name="catalogues"]').val(),
                keyword: $('#formSearchProduct input[name="keyword"]').val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#data_product').html(data);
            });
    }
</script>
<!-- START: input Check All -->
<script>
    $(document).on('click', '#checkbox-all-deals', function() {
        let _this = $(this);
        let table = _this.parents('table');
        if ($('#checkbox-all-deals').length) {
            if (table.find('#checkbox-all-deals').prop('checked')) {
                table.find('.checkbox-item-deals:not(.disabled)').prop('checked', true);
            } else {
                table.find('.checkbox-item-deals:not(.disabled)').prop('checked', false);
            }
        }
        $('.checkbox-item-deals:not(.disabled)').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('tr').addClass('bg-active');
            } else {
                $(this).parents('tr').removeClass('bg-active');
            }
        });
    });
    $(document).on('click', '.checkbox-item-deals:not(.disabled)', function() {
        let _this = $(this);
        $('.checkbox-item-deals:not(.disabled)').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('tr').addClass('bg-active');
            } else {
                $(this).parents('tr').removeClass('bg-active');
            }
        });
        let table = _this.parents('table');
        if (table.find('.checkbox-item-deals:not(.disabled)').length) {
            if (table.find('.checkbox-item-deals:not(.disabled):checked').length == table.find('.checkbox-item-deals:not(.disabled)').length) {
                table.find('#checkbox-all-deals').prop('checked', true);
            } else {
                table.find('#checkbox-all-deals').prop('checked', false);
            }
        }
    });
    /*START: input Check All Product One*/
    $(document).on('click', '#checkbox-all-one', function() {
        let _this = $(this);
        let table = _this.parents('table');
        if ($('#checkbox-all-one').length) {
            if (table.find('#checkbox-all-one').prop('checked')) {
                table.find('.checkbox-item-one:not(.disabled)').prop('checked', true);
            } else {
                table.find('.checkbox-item-one:not(.disabled)').prop('checked', false);
            }
        }
        $('.checkbox-item-one:not(.disabled)').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('tr').addClass('bg-active');
            } else {
                $(this).parents('tr').removeClass('bg-active');
            }
        });
        $('.countProductOne').html(countAllDealOne().length)
    });
    $(document).on('click', '.checkbox-item-one:not(.disabled)', function() {
        let _this = $(this);
        $('.checkbox-item-one:not(.disabled)').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('tr').addClass('bg-active');
            } else {
                $(this).parents('tr').removeClass('bg-active');
            }
        });
        let table = _this.parents('table');
        if (table.find('.checkbox-item-one:not(.disabled)').length) {
            if (table.find('.checkbox-item-one:not(.disabled):checked').length == table.find('.checkbox-item-one:not(.disabled)').length) {
                table.find('#checkbox-all-one').prop('checked', true);
            } else {
                table.find('#checkbox-all-one').prop('checked', false);
            }
        }
        $('.countProductOne').html(countAllDealOne().length)
    });

    function countAllDealOne() {
        let ids = []; /*Lấy id bản ghi */
        $('.checkbox-item-one:checked').each(function() {
            ids.push($(this).val());
        });
        return ids;
    }
    /*END: input Check All Product One*/
    $(document).on('click', '#checkbox-all-two', function() {
        if ($(this).prop('checked')) {
            $('.checkbox-item-two:not(.disabled)').prop('checked', true);
        } else {
            $('.checkbox-item-two:not(.disabled)').prop('checked', false);
        }
        $('.countProductTwo').html(countProductTwo().length)
    });
    $(document).on('click', '.checkbox-item-two:not(.disabled)', function() {
        let _this = $('#checkbox-all-two').parent().parent().parent();
        if (_this.find('.checkbox-item-two:not(.disabled)').length) {
            if (_this.find('.checkbox-item-two:not(.disabled):checked').length == _this.find('.checkbox-item-two:not(.disabled)').length) {
                $('#checkbox-all-two').prop('checked', true);
            } else {
                $('#checkbox-all-two').prop('checked', false);
            }
        }
        $('.countProductTwo').html(countProductTwo().length)
    });

    function countProductTwo() {
        let ids = []; /*Lấy id bản ghi */
        $('.checkbox-item-two:checked').each(function() {
            ids.push($(this).val());
        });
        return ids;
    }
</script>
<!-- END: input Check All -->
<script>
    //ấn nút submit "Xác nhận"
    $(document).on('click', '.btnSubmitProductOne', function(e) {
        e.preventDefault();
        let _this = $(this);
        let ids = []; /*Lấy id bản ghi */
        $('.checkbox-item-deals:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.length <= 0) {
            toastr.error('Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này', 'Error!')
            return false;
        }
        $.post("<?php echo route('product_deals.saveProductOne') ?>", {
                ids: ids,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductOne').html(data);
                $('#listsProductOne').parent().show();
                const myModal = tailwind.Modal.getInstance(document.querySelector("#modalProductOne"));
                myModal.hide();
            });
    })
    $(document).on('click', '.btnSubmitProductTwo', function(e) {
        e.preventDefault();
        let _this = $(this);
        let ids = []; /*Lấy id bản ghi */
        $('.checkbox-item-deals:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.length <= 0) {
            toastr.error('Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này', 'Error!')
            return false;
        }
        $.post("<?php echo route('product_deals.saveProductTwo') ?>", {
                ids: ids,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductTwo').html(data);
                $('#listsProductTwo').parent().show();
                const myModal = tailwind.Modal.getInstance(document.querySelector("#modalProductOne"));
                myModal.hide();
            });
    })
    //ajax phân trang "Sản phẩm chính"
    $(document).on('click', '.paginationProductOne a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var keyword = $('.inputSearchProductOne').val();
        var productOne = $('input[name="productOne"]').val();
        $.post("<?php echo route('product_deals.saveProductOne') ?>", {
                page: page,
                productOne: productOne,
                keyword: keyword,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductOne').html(data);
            });
    });
    $(document).on('click', '.paginationProductTwo a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var keyword = $('.inputSearchProductTwo').val();
        var productTwo = $('input[name="productTwo"]').val();
        $.post("<?php echo route('product_deals.saveProductTwo') ?>", {
                page: page,
                productTwo: productTwo,
                keyword: keyword,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductTwo').html(data);
            });
    });
    //xóa 1 bản ghi
    $(document).on("click", ".handleRemoveItemProductOne", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        swal({
                title: "Xóa sản phẩm",
                text: 'Bạn có chắc muốn xóa?',
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
                    $.post("<?php echo route('product_deals.saveProductOne') ?>", {
                            id: id,
                            type: 'delete',
                            "_token": $('meta[name="csrf-token"]').attr("content")
                        },
                        function(data) {
                            $('#listsProductOne').html(data);
                            swal({
                                title: "Xóa thành công!",
                                text: "Hạng mục đã được xóa khỏi danh sách.",
                                type: "success"
                            });
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
    $(document).on("click", ".handleRemoveItemProductTwo", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        swal({
                title: "Xóa sản phẩm",
                text: 'Bạn có chắc muốn xóa?',
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
                    $.post("<?php echo route('product_deals.saveProductTwo') ?>", {
                            id: id,
                            type: 'delete',
                            "_token": $('meta[name="csrf-token"]').attr("content")
                        },
                        function(data) {
                            $('#listsProductTwo').html(data);
                            swal({
                                title: "Xóa thành công!",
                                text: "Hạng mục đã được xóa khỏi danh sách.",
                                type: "success"
                            });
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
    //xóa nhiều bản ghi
    $(document).on('click', '.ajax-delete-all-product-one', function(event) {
        event.preventDefault();
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        $('.checkbox-item-one:checked').each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error"
            });
            return false;
        }
        let parent = _this.attr('data-parent'); /*Đây là khối mà sẽ ẩn sau khi xóa */
        swal({
                title: "Xóa sản phẩm",
                text: 'Bạn có chắc muốn xóa?',
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
                    $.post("<?php echo route('product_deals.saveProductOne') ?>", {
                            id_checked: id_checked,
                            type: 'delete-all',
                            "_token": $('meta[name="csrf-token"]').attr("content")
                        },
                        function(data) {
                            $('#listsProductOne').html(data);
                            swal({
                                title: "Xóa thành công!",
                                text: "Hạng mục đã được xóa khỏi danh sách.",
                                type: "success"
                            });
                        });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    });
                }
            });
    });
    $(document).on('click', '.ajax-delete-all-product-two', function(event) {
        event.preventDefault();
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        $('.checkbox-item-two:checked').each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error"
            });
            return false;
        }
        let parent = _this.attr('data-parent'); /*Đây là khối mà sẽ ẩn sau khi xóa */
        swal({
                title: "Xóa sản phẩm",
                text: 'Bạn có chắc muốn xóa?',
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
                    $.post("<?php echo route('product_deals.saveProductTwo') ?>", {
                            id_checked: id_checked,
                            type: 'delete-all',
                            "_token": $('meta[name="csrf-token"]').attr("content")
                        },
                        function(data) {
                            $('#listsProductTwo').html(data);
                            swal({
                                title: "Xóa thành công!",
                                text: "Hạng mục đã được xóa khỏi danh sách.",
                                type: "success"
                            });
                        });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    });
                }
            });
    });
    //search sản phẩm
    $(document).on('click', '.btnSearchProductOne', function(event) {
        event.preventDefault();
        var keyword = $('.inputSearchProductOne').val();
        $.post("<?php echo route('product_deals.saveProductOne') ?>", {
                keyword: keyword,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductOne').html(data);
            });
    })
    $(document).on('click', '.btnSearchProductTwo', function(event) {
        event.preventDefault();
        var keyword = $('.inputSearchProductTwo').val();
        $.post("<?php echo route('product_deals.saveProductTwo') ?>", {
                keyword: keyword,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#listsProductTwo').html(data);
            });
    })


    $(document).on('change', '.inputPrice', function(e) {
        var rowid = $(this).attr('rowid')
        var price = $(this).val()
        $.post("<?php echo route('product_deals.changePrice') ?>", {
                rowid: rowid,
                price: price,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {

            });
    })

    function saveBox1() {
        $('input[name="productOne"]').val('hide');
        $('.addProduct1').hide();
        $('.editProduct1').show();
        $('.saveBox1').hide();
        $('.hideClickShowTwo').hide();
        $('.box-product-two').removeClass('disabled');
    }

    function editProduct1() {
        $('input[name="productOne"]').val('show');
        $('.addProduct1').show();
        $('.editProduct1').hide();
        $('.saveBox1').show();
        $('.hideClickShowTwo').show();
        $('.box-product-two').addClass('disabled');

        $('input[name="productTwo"]').val('hide');
        $('.addProduct2').hide();
        $('.editProduct2').show();
        $('.hideClickShowOne').hide();
        $('.saveBox2').hide();
    }



    function saveBox2() {
        $('input[name="productTwo"]').val('hide');
        $('.addProduct2').hide();
        $('.editProduct2').show();
        $('.hideClickShowOne').hide();
        $('.saveBox2').hide();
    }

    function editProduct2() {
        $('input[name="productTwo"]').val('show');
        $('.addProduct2').show();
        $('.editProduct2').hide();
        $('.saveBox2').show();
        $('.hideClickShowOne').show();
    }
</script>
<script>
    $(document).on('click', '#btnSubmitDeal', function(e) {
        e.preventDefault()
        var productOne = $('input[name="productOne"]').val()
        var productTwo = $('input[name="productTwo"]').val()
        if ($('.tableProductOne tbody tr').length == 0) {
            toastr.error("Vui lòng chọn ít nhất 1 sản phẩm chính.", 'Error!')
            return false
        }
        if (productOne == 'show') {
            toastr.error("Vui lòng lưu thông tin sản phẩm chính.", 'Error!')
            return false
        }
        if ($('.itemProductTwo').length == 0) {
            toastr.error("Vui lòng chọn ít nhất 1 sản phẩm mua kèm.", 'Error!')
            return false
        }
        if (productTwo == 'show') {
            toastr.error("Vui lòng lưu thông tin sản phẩm mua kèm.", 'Error!')
            return false
        }
        $('#submitFormDeals').submit();
        // $.ajax({
        //     url: "<?php echo route('product_deals.store') ?>",
        //     type: 'POST',
        //     data: {
        //         _token: $('meta[name="csrf-token"]').attr("content"),
        //         title: $("input[name='title']").val(),
        //     },
        //     success: function(data) {
        //         console.log(data.error);
        //         if ($.isEmptyObject(data.error)) {

        //         } else {
        //             $(".print-error-msg").html(data.error);
        //             return false;
        //         }
        //     },
        //     success: function(data) {
        //         console.log(data.error);
        //         if ($.isEmptyObject(data.error)) {


        //         } else {
        //             $(".print-error-msg span").html(data.error);
        //             $(".print-error-msg").show();
        //             return false;
        //         }
        //     }
        // });
    })
</script>
@endpush
@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách phiếu thu</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách phiếu thu",
        "src" => route('receipt_vouchers.index'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class="flex justify-between items-center mt-10">
        <h1 class=" text-lg font-medium ">
            Danh sách phiếu thu
        </h1>
        <div class="flex flex-col md:flex-row gap-2 justify-end md:items-center">
            @can('receipt_vouchers_index')
            <a href="{{route('receipt_groups.index')}}" class="flex items-center space-x-1 btn btn-primary">
                <span>Danh sách loại phiếu thu</span>
            </a>
            @endcan
            @can('receipt_vouchers_create')
            <a href="{{route('receipt_vouchers.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="col-span-2">
            <div class="dropdown w-full" id="myDropdown">
                <button class="dropdown-toggle btn btn-primary w-full" aria-expanded="false" data-tw-toggle="dropdown">Hành động</button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li> <a href="javascript:void(0)" class="dropdown-item ajax-DeletePaymentVoucher">Hủy phiếu thu</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="" class="col-span-10 grid grid-cols-12 gap-2" id="search" style="margin-bottom: 0px;">
            <?php echo Form::select('module', $table, request()->get('module'), ['class' => 'form-control col-span-2']); ?>
            <input type="search" name="created_at" class="form-control col-span-3 mr-2" placeholder="Ngày tạo" autocomplete="off" value="<?php echo request()->get('created_at') ?>">
            <div class="col-span-5 flex space-x-2">
                <input type="search" name="keyword" class="form-control " placeholder="Tìm kiếm theo mã phiếu thu, tham chiếu, mã chứng từ gốc" autocomplete="off" value="<?php echo request()->get('keyword') ?>">
                <button class="btn btn-primary" type="submit">
                    <i data-lucide="search"></i>
                </button>
            </div>
            <a href="javascript:void(0)" class="col-span-2 flex items-center btn btn-default space-x-2 tp-cart">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                <span>Bộ lọc khác</span>
            </a>
        </form>
        <!-- BEGIN: Data List -->
        <div id="loadData" class=" col-span-12">
            @include('cashbook.receipt.receipt.data')
        </div>
    </div>
</div>
<div class="offcanvas-overlay fixed inset-0 bg-black opacity-50 z-50 hidden" style="background: #0000007a;"></div>
<div id="offcanvasSearch" style="width:520px;max-width: 100%;z-index: 99;" class="offcanvas left-auto right-0 transform fixed font-normal text-sm top-0 z-50 h-screen w-80 lg:w-96 transition-all ease-in-out duration-300 bg-white overflow-y-auto hidden animated fadeInRight">
    <div class="p-2">
        <div class="flex flex-wrap justify-between items-center pb-6 mb-6 border-b border-solid border-gray-600">
            <h4 class="font-normal text-xl">Bộ lọc</h4>
            <button class="offcanvas-close hover:text-green-500">
                <svg class="w-4 h-4 " viewBox="0 0 16 14">
                    <path d="M15 0L1 14m14 0L1 0" stroke="currentColor" fill="none" fill-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="mt-5 space-y-3">
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Nhóm người nhận</label>
                <select multiple="multiple" class="form-control tom-select tom-select-custom tomselected" data-placeholder="Tìm kiếm..." style="height:42px" name="module" id="tomselect-1" tabindex="-1" hidden="hidden">
                    @if(!empty($table))
                    @foreach($table as $key=>$item)
                    <option value="{{$key}}" @if(request()->get('module') == $key && $key != 0) selected="selected" @endif>{{$item}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Hình thức thanh toán</label>
                <?php echo Form::select('type', config('payment.method'), request()->get('type'), ['multiple', 'class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Tìm kiếm...o", 'style' => 'height:42px']); ?>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Loại phiếu</label>
                <?php echo Form::select('group_id', $categories, request()->get('group_id'), ['multiple', 'class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Tìm kiếm...", 'style' => 'height:42px']); ?>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Chi nhánh</label>
                <select class="form-control tom-select tom-select-custom tomselected" data-placeholder="Tìm kiếm..." style="height:42px" name="address_id" multiple>
                    <option value="0">Chọn chi nhánh</option>
                    @if(!$address->isEmpty())
                    @foreach($address as $item)
                    <option value="{{$item->id}}" @if(request()->get('address_id') == $item->id) selected @endif>{{$item->title}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Ngày tạo</label>
                <input type="search" name="created_at" class="keyword form-control" placeholder="" autocomplete="off" value="<?php echo request()->get('created_at') ?>">
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Người tạo</label>
                <?php echo Form::select('userid_created', $users, request()->get('userid_created'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Tìm kiếm...", 'style' => 'height:42px']); ?>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Hạch toán kết quả kinh doanh</label>
                <?php echo Form::select('checked', ['-1' => 'Chọn hạch toán kết quả kinh doanh', '0' => 'Không', '1' => 'Có'], request()->get('checked'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Tìm kiếm...", 'style' => 'height:42px']); ?>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Trạng thái</label>
                <?php echo Form::select('status', $status['method'], request()->get('status'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Tìm kiếm...", 'style' => 'height:42px']); ?>
            </div>
            <div class="flex-auto space-y-1">
                <label class="font-medium mb-2">Tìm kiếm theo mã phiếu thu, tham chiếu, mã chứng từ gốc</label>
                <input type="search" name="keyword" class="keyword form-control" placeholder="" autocomplete="off" value="<?php echo request()->get('keyword') ?>">
            </div>
            <div class="flex justify-end">
                <button class="btn btn-primary js_searchPaymentVouchers" type="button">
                    Tìm kiếm
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script type="text/javascript" src="{{asset('library/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('library/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/daterangepicker/daterangepicker.css')}}" />
<script type="text/javascript">
    $(function() {
        $('input[name="created_at"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " to "
            }
        });
    });
</script>
<script>
    $('.tp-cart').click(function() {
        $('.offcanvas-overlay').toggleClass('hidden');
        $('#offcanvasSearch').toggleClass('hidden');
    });
    $(".offcanvas-close, .offcanvas-overlay").on("click", function(e) {
        e.preventDefault();
        $('.offcanvas-overlay').addClass('hidden');
        $('#offcanvasSearch').addClass('hidden ');
    });
    /*START: XÓA tất cả bản ghi */
    $(document).on('change', '.ajax-delete-payment-voucher', function() {
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
            'module': _this.attr('data-module'),
            'router': _this.attr('data-router'),
            'child': _this.attr('data-child'),
            'list': id_checked,
        }
        let parent = _this.attr('data-parent'); /*Đây là khối mà sẽ ẩn sau khi xóa */
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
                        url: BASE_URL_AJAX + "ajax/ajax-delete-all",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            param: param
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
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
<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getListObjectPaymentVouchers(page);
    });

    function getListObjectPaymentVouchers(page = 1) {
        $.ajax({
            url: "<?php echo route('receipt_vouchers.ajaxSearch') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                module: $('#offcanvasSearch select[name="module"]').val(),
                type: $('#offcanvasSearch select[name="type"]').val(),
                group_id: $('#offcanvasSearch select[name="group_id"]').val(),
                address_id: $('#offcanvasSearch select[name="address_id"]').val(),
                created_at: $('#offcanvasSearch input[name="created_at"]').val(),
                userid_created: $('#offcanvasSearch select[name="userid_created"]').val(),
                checked: $('#offcanvasSearch select[name="checked"]').val(),
                status: $('#offcanvasSearch select[name="status"]').val(),
                keyword: $('#offcanvasSearch input[name="keyword"]').val(),
                page: page,
            },
            success: function(data) {
                $('#loadData').html(data);
                $('.offcanvas-overlay').addClass('hidden');
                $('#offcanvasSearch').addClass('hidden ');
            }
        });
    }
    $(document).on('click', '.js_searchPaymentVouchers', function(e) {
        getListObjectPaymentVouchers(1);
    })
    /*START: Hủy phiếu thu */
    $(document).on('click', '.ajax-DeletePaymentVoucher', function() {
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        var rv = true;
        $('.checkbox-item:checked').each(function() {
            var checked = $(this).attr('data-check');
            if (checked == 1) {
                swal({
                    title: "Thông báo",
                    text: "Không được hủy các phiếu thu Tự động, Thanh toán cho đơn nhập hàng và trạng thái “Đã hủy”",
                    type: "error"
                });
                return rv = false;
            }
        });
        const myDropdown = tailwind.Dropdown.getOrCreateInstance(document.querySelector("#myDropdown"));
        myDropdown.hide();
        if (rv == true) {
            $('.checkbox-item:checked').each(function() {
                var checked = $(this).attr('data-check');
                if (checked == 0) {
                    id_checked.push($(this).val());
                }
            });
            if (id_checked.length <= 0) {
                swal({
                    title: "Thông báo",
                    text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                    type: "error"
                });
                return false;
            } else {
                swal({
                        title: "Bạn chắc chắn muốn hủy phiếu thu này?",
                        text: 'Thao tác này sẽ hủy các phiếu thu bạn đã chọn. Thao tác này không thể khôi phục.',
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
                                url: "{{route('receipt_vouchers.ajaxDelete')}}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id_checked: id_checked
                                },
                                success: function(data) {
                                    if ($.isEmptyObject(data.error)) {
                                        swal({
                                            title: "Xử lý dữ liệu hoàn tất!",
                                            text: data.success,
                                            type: "success"
                                        }, function() {
                                            location.reload();
                                        });
                                    } else {
                                        swal({
                                            title: "Thông báo",
                                            text: data.error,
                                            type: "error"
                                        });
                                        return false;
                                    }
                                }
                            });
                        } else {
                            swal({
                                title: "Hủy bỏ",
                                text: "Thao tác bị hủy bỏ",
                                type: "error"
                            });
                        }
                    });
            }

        }
    });
    /*END: Hủy phiếu thu */
</script>
@endpush
@extends('dashboard.layout.dashboard')
@section('title')
<title>Tạo đơn nhập hàng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đơn nhập hàng",
        "src" => route('product_purchases.index'),
    ],
    [
        "title" => "Tạo đơn nhập hàng",
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
            Tạo đơn nhập hàng
        </h1>
    </div>
    <form id="formPurchases" class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('product_purchases.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="col-span-12 lg:col-span-8 space-y-3">
            <div class="hidden">
                <input type="text" class="" value="" placeholder="" name="suppliers_id">
            </div>
            <!-- BEGIN: Form Layout -->
            <div class="">
                @include('components.alert-error')
                @csrf
                <div class="alert alert-danger-soft show flex items-center mb-2 print-error-msg" role="alert" style="display: none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span></span>
                </div>
            </div>
            <!-- START: Tìm kiếm nhà cung cấp -->
            @include('product.backend.purchases.create.suppliers')
            <!-- END: Tìm kiếm nhà cung cấp -->
            <!-- START: Thông tin sản phẩm-->
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin sản phẩm
                    </h2>
                </div>
                <div class="p-5 grid ">
                    <div class="relative">
                        <div class="flex space-x-2">
                            <input autocomplete="off" class="form-control js_search_products w-full" placeholder="Tìm kiếm nhà cung cấp theo tên, mã sản phẩm, ..." type="text">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary w-24" data-tw-toggle="modal" data-tw-target="#modal-select-products">Chọn nhiều</a>
                        </div>
                        <div class="absolute top-10 left-0 w-full border shadow bg-white z-10" id="loadDataProducts" style="display: none;">
                            @include('product.backend.purchases.create.products')
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Mã sản phẩm</th>
                                    <th class="whitespace-nowrap">Tên sản phẩm</th>
                                    <th class="text-center whitespace-nowrap">Đơn vị</th>
                                    <th class="text-center whitespace-nowrap">Số lượng </th>
                                    <th class="text-center whitespace-nowrap">Giá nhập</th>
                                    <th class="text-center whitespace-nowrap">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="listItemCart">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between p-4">
                        <span class="font-bold flex-1 text-right">Số lượng</span>
                        <span class="js_quantity_purchases text-right w-32">0</span>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="font-bold flex-1 text-right">Tạm tính</span>
                        <span class="js_provisional_purchases text-right w-32">0</span>
                    </div>
                    @include('product.backend.purchases.create.discount')
                    <div class="js_html_VAT">
                    </div>
                    @include('product.backend.purchases.create.surcharge')
                    <div class="flex justify-between p-4">
                        <div class="font-bold flex-1 text-right">Tiền cần trả</div>
                        <div class="js_totalPriceCart text-right w-32">0</div>
                    </div>
                </div>
            </div>
            <!-- END: Thông tin sản phẩm-->
            <!-- START: THANH TOÁN -->
            <div class="box">
                <div class="flex flex-col sm:flex-row items-start md:items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400 gap-3">
                    <h2 class="font-medium text-base mr-auto">
                        THANH TOÁN
                    </h2>
                    <div class="label">
                        <input type="checkbox" class="js_handle_financialStatusValue" id="financialStatusValue" name="financialStatusValue" value="1">
                        <label for="financialStatusValue" class="cursor-pointer">
                            Thanh toán với nhà cung cấp
                        </label>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-2 gap-3 hidden js_html_financialStatusValue">
                    <div class="col-span-2 md:col-span-1">
                        <div>
                            <label class="form-label text-base font-semibold">Hình thức thanh toán</label>
                            <?php echo Form::select('financialInfo[method]', $paymentMethod, '', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <div>
                            <label class="form-label text-base font-semibold">Số tiền thanh toán</label>
                            <?php echo Form::text('price_suppliers', !empty(old('price_suppliers')) ? old('price_suppliers') : 0, ['class' => 'form-control float']); ?>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div>
                            <label class="form-label text-base font-semibold">Tham chiếu</label>
                            <?php echo Form::text('financialInfo[reference]', '', ['class' => 'form-control', 'placeholder' => 'Ví dụ: mã giao dịch ngân hàng,...']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: THANH TOÁN -->
            <!-- START: NHẬP KHO -->
            <div class="box">
                <div class="flex flex-col sm:flex-row items-start md:items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400 gap-3">
                    <h2 class="font-medium text-base mr-auto">
                        NHẬP KHO
                    </h2>
                    <div class="label">
                        <label class="cursor-pointer">
                            <input type="checkbox" value="1" name="receiveStatusValue">
                            Nhập hàng vào kho
                        </label>
                    </div>
                </div>
            </div>
            <!-- END: NHẬP KHO -->
            <!-- END: Form Layout -->
            <div class="hidden md:flex justify-end">
                <button type="submit" class="btn btn-primary js_submitStorePurchases">Đặt hàng và duyệt</button>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4">
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin đơn nhập hàng
                    </h2>
                </div>
                <div class="p-5 space-y-3">
                    <div>
                        <label class="form-label text-base font-semibold">Mã đơn nhập hàng</label>
                        <?php echo Form::text('code', !empty(old('code')) ? old('code') : CodeRender('purchases'), ['class' => 'form-control']); ?>
                    </div>
                    <div>
                        <label class="form-label text-base font-semibold">Chi nhánh</label>
                        <select class="tom-select tom-select-custom w-full tomselected" data-placeholder="Tìm kiếm chi nhánh..." name="address_id" id="tomselect-1" tabindex="-1" hidden="hidden">
                            <?php if (in_array('addresses', $dropdown)) { ?>
                                @if(!empty($listAddress))
                                @foreach($listAddress as $item)
                                <option value="{{$item->id}}" @if($item->active ==1) selected @endif>{{$item->title}}</option>
                                @endforeach
                                @endif
                            <?php } ?>
                        </select>
                    </div>
                    <div class="">
                        <label class="form-label text-base font-semibold">Ghi chú</label>
                        <?php echo Form::textarea('note', old('note'), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                    </div>
                    <div>
                        <label class="form-label text-base font-semibold">Tham chiếu</label>
                        <?php echo Form::text('reference', old('reference'), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                    </div>
                    <div class="">
                        <label class="form-label text-base font-semibold">Ngày hẹn giao</label>
                        <?php echo Form::text('dueOn', !empty(old('dueOn')) ? old('dueOn') : date('Y-m-d'), ['class' => 'form-control w-full datetimepicker', 'placeholder' => '']); ?>
                    </div>
                    <div class="flex md:hidden text-right">
                        <button type="submit" class="btn btn-primary js_submitStorePurchases">Đặt hàng và duyệt</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    .btn-default.active {
        color: #fff;
        background-color: red;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    .table-report:not(.table-report--bordered):not(.table-report--tabulator) td:first-child {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        text-align: center;
    }

    .table-report:not(.table-report--bordered):not(.table-report--tabulator) td:first-child {
        border-left-width: 0px;
    }

    .table-report:not(.table-report--bordered):not(.table-report--tabulator) td:last-child {
        border-right-width: 0px;
    }

    .table-report:not(.table-report--bordered):not(.table-report--tabulator) td:last-child {
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    @media (min-width: 767px) {
        .md\:hidden {
            display: none;
        }
    }

    .pagination .page-item.active .page-link {
        font-weight: 500;
        background: rgb(var(--color-primary) / var(--tw-bg-opacity));
        color: #fff;
    }

    .lg\:pl-20 {
        padding-left: 5rem;
    }

    .pb-2 {
        padding-bottom: 0.5rem;
    }

    .cursor-no-drop {
        cursor: no-drop;
    }

    .hover\:text-white:hover {
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }

    .hover\:bg-global:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(214 28 31 / var(--tw-bg-opacity));
    }

    .space-y-2> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
    }

    .space-x-2> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 0;
        margin-right: calc(0.5rem * var(--tw-space-x-reverse));
        margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
    }

    .stardust-icon {
        color: #ee4d2d;
    }

    .list_shipping_item {
        display: flex;
        flex: 1;
        background-color: #fafafa;
        box-shadow: inset 4px 0 0 #ee4d2d;
    }

    .list_shipping_item .priceA {
        color: #ee4d2d;
    }

    .scrollbar {
        overflow-y: overlay;
    }

    .scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar {
        width: 6px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #D62929;
    }
</style>
@endsection
@push('javascript')
<?php /*Modal Chọn nhiều sản phẩm*/ ?>
<div id="modal-select-products" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-between">
                <h2 class="font-medium text-base mr-auto">
                    Chọn nhiều sản phẩm
                </h2>
                <button type="button" data-tw-dismiss="modal" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body space-y-3">
                <div class="">
                    <input type="text" class="form-control js_searchProductModal" placeholder="Tìm kiếm sản phẩm">
                </div>
                <div id="loadDataModalProducts">
                    @include('product.backend.purchases.create.modal.data')
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Thoát</button>
                <button type="button" class="btn btn-primary js_addToCartModalProduct">Thêm vào đơn</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<?php /*END: Modal chọn nhiều sản phẩm*/ ?>
<?php /*START: Modal thông báo ERROR*/ ?>
<div id="warning-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x-circle" data-lucide="x-circle" class="lucide lucide-x-circle w-16 h-16 text-danger mx-auto mt-3">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <div class="text-3xl mt-5">Lỗi...</div>
                    <div class="text-slate-500 mt-2 print-error-msg text-lg"></div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Đóng</button> </div>
            </div>
        </div>
    </div>
</div>
<?php /*END: Modal thông báo ERROR*/ ?>
<?php /*START: thêm phụ phí*/ ?>
<div id="modal-add-surcharge" class="modal" tabindex="-1" aria-hidden="true">
    <form class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex justify-between items-center">
                <h2 class="font-medium text-base mr-auto">
                    Thêm chi phí
                </h2>
                <button type="button" data-tw-dismiss="modal" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body space-y-3">
                <div class="listItemSurcharge space-y-3">
                    <div class="item flex space-x-4 items-center">
                        <div class="w-3/5">
                            <input type="text" name="surcharge[title]" value="" class="form-control" placeholder="Tên chi phí" required>
                        </div>
                        <div class="w-1/5">
                            <input type="text" name="surcharge[price]" value="" class="form-control int" placeholder="0" required>
                        </div>
                        <div class="w-1/5">
                            <a href="javascript:void(0)" class="js_deleteSurcharge">
                                <svg viewBox="0 0 20 20" focusable="false" aria-hidden="true" style="fill: red;width:20px;height:20px">
                                    <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"> &lt; /path&gt; </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="flex justify-between items-center border-t pt-3">
                    <a href="javascript:void(0)" class="font-bold text-danger flex space-x-2 items-center js_addSurcharge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Thêm chi phí
                    </a>
                    <div class="">
                        Tổng chi phí: <span class="js_totalSurcharge text-danger"> 0</span>
                    </div>

                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Thoát</button>
                <button type="submit" class="btn btn-primary">Áp dụng</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </form>
</div>
<?php /*END: thêm phụ phí*/ ?>
<script type="text/javascript" src="{{asset('library/datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/datetimepicker/jquery.datetimepicker.min.css')}}" />
<script type="text/javascript">
    $.datetimepicker.setLocale('vi');
    $('.datetimepicker').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: 0
    });
</script>
<!-- START: Modal select product -->
<script>
    $(document).on('click', '.js_handleSelectModalProduct', function() {
        var checkBoxes = $(this).parent().find('input');
        checkBoxes.prop("checked", !checkBoxes.prop("checked"))
    })

    $(document).on('keyup', '.js_searchProductModal', function() {
        getObjectModalProducts();
    })
    $(document).on('click', '.paginationModalProducts .pagination a', function(event) {
        event.preventDefault();
        console.log(1);
        var page = $(this).attr('href').split('page=')[1];
        getObjectModalProducts(page);
    });

    function getObjectModalProducts(page = 1) {
        let keyword = $('.js_searchProductModal').val();
        $.post("<?php echo route('product_purchases.ajaxListProducts') ?>", {
                keyword: keyword,
                type: 'modal.data',
                page: page,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#loadDataModalProducts').html(data);
            });
    }
</script>
<!-- END: Modal select product -->

<!-- Click Nhà cung cấp -->
<script>
    $(".js_search_suppliers").focus(function() {
        $("#loadDataSuppliers").show()
    });
    var resultsSelected = false;
    $("#loadDataSuppliers").hover(
        function() {
            resultsSelected = true;
        },
        function() {
            resultsSelected = false;
        }
    );
    $(".js_search_suppliers").blur(function() {
        if (!resultsSelected) { //if you click on anything other than the results
            $("#loadDataSuppliers").hide(); //hide the results
        }
    })
    $(document).on('click', '.js_handle_suppliers', function() {
        $("#loadDataSuppliers").hide();
        var id = $(this).attr('data-id');
        let data = $(this).attr('data-info');
        data = window.atob(data); //decode base64
        let json = JSON.parse(data);
        var item = '';
        item = item + ' <div class="flex items-center justify-between">';
        item = item + '<div class="item flex items-center hover:text-danger cursor-pointer js_handleCloseInfoSuppliers">';
        item = item + '<div class="w-10 h-10 rounded-full">';
        item = item + '<img src="https://ui-avatars.com/api/?name=' + json.title + '" class="rounded-full w-full">';
        item = item + '</div>';
        item = item + '<div class="flex items-center">';
        item = item + '<span class="mx-2 font-bold text-danger">';
        item = item + json.title;
        item = item + '</span>';
        item = item + '<span class=" ml-2 font-bold text-danger">';
        item = item + '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
        item = item + '</span>';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '<div>';
        item = item + 'Công nợ: <b>' + numberWithCommas(json.debt) + '₫</b>';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '<div class="mt-3 border-t pt-3">';
        item = item + '<h2 class="font-medium text-base mr-auto">';
        item = item + 'Thông tin chi tiết:';
        item = item + '</h2>';
        item = item + '<div>';
        item = item + '<p>Mã nhà cung cấp: ' + json.code + '</p>';
        item = item + '<p> Số điện thoại: ' + json.phone + '</p>';
        item = item + '<p>Email: ' + json.email + '</p>';
        item = item + '<p>Địa chỉ: ' + json.address + '</p>';
        item = item + '</div>';
        item = item + '</div>';
        setTimeout(function() {
            $('.js_search_suppliers').hide();
            $('#loadDataInfoSuppliers').html(item);
            $('input[name="suppliers_id"]').val(id);
        }, 100); //sau 100ms thì mới thực hiện
    })
    $(document).on('click', '.js_handleCloseInfoSuppliers', function(event) {
        $('#loadDataInfoSuppliers').html('');
        $('.js_search_suppliers').show();
        $('input[name="suppliers_id"]').val('');

    });
    $(document).on('click', '.paginationSuppliers .pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getObjectSuppliers(page);
    });

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
    $('.js_search_suppliers').keyup(delay(function(e) {
        e.preventDefault();
        getObjectSuppliers();
    }, 500));

    function getObjectSuppliers(page = 1) {
        let keyword = $('.js_search_suppliers').val();
        let ajaxUrl = "<?php echo route('product_purchases.ajaxListSuppliers') ?>";
        $.post(ajaxUrl, {
                keyword: keyword,
                page: page,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#loadDataSuppliers').html(data);
                setTimeout(function() {
                    $('#loadDataSuppliers').removeClass('hidden');
                }, 100)
                console.log('Quyen')
            });
    }
</script>
<!-- END: Click Nhà cung cấp -->

<!-- START: Click "THANH TOÁN" show to div -->
<script>
    $(document).on('change', '.js_handle_financialStatusValue', function(event) {
        event.preventDefault();
        var value = $('input[name="financialStatusValue"]:checked').val();
        if (value == 1) {
            $('.js_html_financialStatusValue').removeClass('hidden')
        } else {
            $('.js_html_financialStatusValue').addClass('hidden')
        }
    });
</script>
<!-- END: Click "THANH TOÁN" -->
<!-- START: keyup price_suppliers check-->
<script>
    $(document).on('keyup', 'input[name="price_suppliers"]', function(event) {
        event.preventDefault();
        var value = $(this).val().replace('.', "");
        var max = Number($(this).attr('max'));
        if (value > max) {
            $(this).val(numberWithCommas(max));
        } else {
            $(this).val(numberWithCommas(value));
        }
    });
</script>
<!-- END: keyup price_suppliers check-->
<!-- START: validate form-->
<script>
    $(".js_submitStorePurchases").click(function(e) {
        $.ajax({
            url: "<?php echo route('product_purchases.validateForm') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                suppliers_id: $("input[name='suppliers_id']").val(),
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#formPurchases').submit();
                } else {
                    $("#warning-modal-preview .print-error-msg").html(data.error);
                    const myModalError = tailwind.Modal.getOrCreateInstance(document.querySelector("#warning-modal-preview"));
                    myModalError.show();
                    return false;
                }
            }
        });
        return false;
    });
</script>
<!-- END: validate form-->
<!-- START: script chiết khấu -->
<script>
    $(document).on('click', '.js_typeDiscountTP', function() {
        var type = $(this).attr('data-type');
        $('.js_typeDiscountTP').removeClass('active')
        $(this).addClass('active')
        if (type == 'percent') {
            $('.js_valueDiscountTP').attr('max', 100)
        } else {
            $('.js_valueDiscountTP').attr('max', '')
        }
        $('.js_valueDiscountTP').attr('data-type', type)
    })
</script>
<!-- END: script chiết khấu -->
<!-- START: phụ phí -->
<script>
    $(document).on('click', '.js_addSurcharge', function(e) {
        let html = '';
        html = html + '<div class="item flex space-x-4 items-center">';
        html = html + '<div class="w-3/5">';
        html = html + '<input type="text" name="surcharge[title]" value="" class="form-control" placeholder="Tên chi phí" required>';
        html = html + '</div>';
        html = html + '<div class="w-1/5">';
        html = html + '<input type="text" name="surcharge[price]" value="" class="form-control int" placeholder="0" required>';
        html = html + '</div>';
        html = html + '<div class="w-1/5">';
        html = html + ' <a href="javascript:void(0)" class="js_deleteSurcharge"><svg viewBox="0 0 20 20" focusable="false" aria-hidden="true" style="fill: red;width:20px;height:20px"><path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"> &lt; /path&gt; </path></svg></a>';
        html = html + '</div>';
        html = html + '</div>';
        $('.listItemSurcharge').append(html);
    })
    $(document).on('click', '.js_deleteSurcharge', function() {
        let _this = $(this);
        _this.parents('.item').remove();
    });


    $(document).on('keyup', 'input[name="surcharge[price]"]', function(e) {
        var sum = 0;
        $('input[name="surcharge[price]"]').each(function() {
            var value = $(this).val().replace(/\./gi, "");
            sum += parseInt(value);
        });
        $('.js_totalSurcharge').html(numberWithCommas(sum) + 'đ')
    })
</script>
<!-- END: phụ phí -->
<!--START: script xử lí sản phẩm và cart -->
<script>
    /*START: search product none modal */
    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
    $(".js_search_products").focus(function() {
        $("#loadDataProducts").show()
    });
    var resultsSelected = false;
    $("#loadDataProducts").hover(
        function() {
            resultsSelected = true;
        },
        function() {
            resultsSelected = false;
        }
    );
    $(".js_search_products").blur(function() {
        if (!resultsSelected) {
            $("#loadDataProducts").hide();
        }
    })
    $(document).on('click', '.js_close_listProduct', function() {
        $("#loadDataProducts").hide();
    })
    $(document).on('click', '.paginationProducts .pagination a', function(event) {
        event.preventDefault();
        console.log(1);
        var page = $(this).attr('href').split('page=')[1];
        getObjectProducts(page);
    });
    $('.js_search_products').keyup(delay(function(e) {
        e.preventDefault();
        getObjectProducts();
    }, 500));

    function getObjectProducts(page = 1) {
        let keyword = $('.js_search_products').val();
        $.post("<?php echo route('product_purchases.ajaxListProducts') ?>", {
                keyword: keyword,
                type: 'products',
                page: page,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#loadDataProducts').html(data);
            });
    }
    /*END: search product none modal */


    /*START: click item sản phẩm addtocart*/
    $(document).on('click', '.js_handleSelectProducts', function(event) {
        event.preventDefault();
        $.post("<?php echo route('product_purchases.addToCartPurchases') ?>", {
                id: $(this).attr('data-id'),
                type: $(this).attr('data-type'),
                id_version: $(this).attr('data-id-version'),
                title_version: $(this).attr('data-title-version'),
                price: $(this).attr('data-price'),
                image: $(this).attr('data-image'),
                unit: $(this).attr('data-unit'),
                discountValue: $('input[name="discount[value]"]').val(),
                discountType: $('input[name="discount[type]"]').val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data)
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });
                }
            });
    });
    /*END: click item sản phẩm addtocart*/
    /*START: Submit Thêm vào đơn(modal products) */
    $(document).on('click', '.js_addToCartModalProduct', function(e) {
        var sList = [];
        $('input[name="checkboxItem"]:checked').each(function(i) {
            sList.push($(this).val());
        });
        $.post("<?php echo route('product_purchases.ajaxAddToCartModalPopup') ?>", {
                sList: sList,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data);
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal-select-products"));
                    myModal.hide();
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });
                }
            });
    })
    /*END: Submit Thêm vào đơn(modal products) */

    /*START: Cập nhập giỏ hàng theo "Số lượng" */
    $(document).on('change', '.js_updateCartPurchase', function() {
        $.post("<?php echo route('product_purchases.ajaxUpdateCartPurchases') ?>", {
                type: "update",
                quantity: $(this).val(),
                rowid: $(this).attr('data-rowid'),
                discountValue: $('input[name="discount[value]"]').val(),
                discountType: $('input[name="discount[type]"]').val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data)
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });
                }
            });
    })
    /*END: Cập nhập giỏ hàng theo "Số lượng" */
    /*START: Cập nhập giỏ hàng theo "Giá" */
    $(document).on('change', '.js_updateCartPricePurchase', function() {
        $.post("<?php echo route('product_purchases.ajaxUpdateCartPurchases') ?>", {
                type: "updatePrice",
                price: $(this).val(),
                rowid: $(this).attr('data-rowid'),
                discountValue: $('input[name="discount[value]"]').val(),
                discountType: $('input[name="discount[type]"]').val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data)
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });
                }
            });
    })
    /*END: Cập nhập giỏ hàng theo "Giá" */
    /*START: Xóa giỏ hàng */
    $(document).on('click', '.js_removeCartPurchase', function(e) {
        $.post("<?php echo route('product_purchases.ajaxUpdateCartPurchases') ?>", {
                type: "delete",
                rowid: $(this).attr('data-rowid'),
                discountValue: $('input[name="discount[value]"]').val(),
                discountType: $('input[name="discount[type]"]').val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data)
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });
                }
            });
    })
    /*END: Xóa giỏ hàng */
    /*START: Change input chiết khấu */
    $(document).on('click', '.js_addDiscount', function() {
        $.post("<?php echo route('product_purchases.addDiscount') ?>", {
                value: $('.js_valueDiscountTP').val(),
                type: $('.js_valueDiscountTP').attr('data-type'),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('.js_priceDiscount').html(numberWithCommas(data.priceDiscount) + 'đ')
                    $('.js_totalPriceCart').html(numberWithCommas(data.total) + 'đ')
                    $('input[name="price_total"]').html(data.total)
                } else {
                    swal({
                        title: "Thông báo!",
                        text: data.error,
                        type: "error"
                    });

                }
            });
    })
    /*END: Change input chiết khấu*/
    /*START: Submit Áp dụng chi phí */
    $(document).on('submit', '#modal-add-surcharge form', function(e) {
        e.preventDefault();
        var sum = 0;
        var title = [];
        var price = [];
        $('input[name="surcharge[price]"]').each(function() {
            sum += Number($(this).val().replace(".", ""));
            price.push($(this).val())
        });
        $('input[name="surcharge[title]"]').each(function() {
            title.push($(this).val())
        });
        $.post("<?php echo route('product_purchases.ajaxSaveSessionSurcharge') ?>", {
                sum: sum,
                title: title,
                price: price,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if ($.isEmptyObject(data.error)) {
                    loadDataCartTP(data);
                    $('.js_priceSurcharge').html(numberWithCommas(sum) + 'đ')
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal-add-surcharge"))
                    myModal.hide()
                } else {
                    console.log(data.error);
                }
            });
    })
    /*END: Submit Áp dụng chi phí */
    function loadDataCartTP(data) {
        $('.js_totalPriceCart').html(numberWithCommas(data.total) + 'đ');
        $('input[name="price_total"]').val(data.total);

        $('input[name="price_suppliers"]').val(numberWithCommas(data.total))
        $('input[name="price_suppliers"]').attr('max', data.total)

        $('.js_html_VAT').html('').html(data.htmlVAT);
        $('#listItemCart').html(data.html);
        $('.js_quantity_purchases').html(data.quantity);
        $('.js_provisional_purchases').html(numberWithCommas(data.provisional) + 'đ');
        $('.js_priceDiscount').html(numberWithCommas(data.priceDiscount) + 'đ')
        $("#loadDataProducts").hide();
    }
</script>
<!--END script xử lí sản phẩm và cart -->
@endpush
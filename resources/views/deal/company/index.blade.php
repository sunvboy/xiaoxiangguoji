@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách các hợp đồng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các hợp đồng",
        "src" => route('deals.index'),
    ],
    [
        "title" => $customer->name,
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<?php
$permissionChecked = collect($deal_views)->where('active', 1);
$permissionCheckedIndex = $permissionChecked->pluck('keyword');

$permissionCheckedWebsite = collect($deal_views_website)->where('active', 1);
$permissionCheckedIndexWebsite = $permissionCheckedWebsite->pluck('keyword');

$permissionCheckedVps = collect($deal_views_vps)->where('active', 1);
$permissionCheckedIndexVps = $permissionCheckedVps->pluck('keyword');
?>
<div class="p-4 space-y-5 ">
    <div>
        <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i>
            <span>Thông tin hồ sơ</span>
            <a href="{{ route('customers.edit',['id'=>$customer->id]) }}" class="font-normal underline " target="_blank">chỉnh sửa</a>

        </h3>
        <div class="bg-white p-5 text-sm">
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Tên công ty
                </div>
                <div class="flex-1">
                    {{$customer->name}}
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Loại hình công ty
                </div>
                <div class="flex-1">
                    {{!empty($customer->customer_categories) ?  $customer->customer_categories->title : ""}}
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Website
                </div>
                <div class="flex-1">
                    {{$customer->website}}
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Số điện thoại
                </div>
                <div class="flex-1">
                    {{$customer->hotline}}
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Email
                </div>
                <div class="flex-1">
                    {{$customer->email}}
                </div>
            </div>
            @if(!empty($customer->address))
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Địa chỉ
                </div>
                <div class="flex-1">
                    {{$customer->address}}
                </div>
            </div>
            @endif
            @if(!empty($customer->note))
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Ghi chú
                </div>
                <div class="flex-1">
                    {!! $customer->note !!}
                </div>
            </div>
            @endif
            <div class="flex items-center">
                <div class="w-[150px] font-bold">
                    Ảnh
                </div>
                <div class="flex-1">

                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg font-bold" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Gia hạn</button>
            </li>
            <li class="ml-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 font-bold" id="vps-tab" data-tabs-target="#vps" type="button" role="tab" aria-controls="vps" aria-selected="false">VPS</button>
            </li>
            <li class="ml-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 font-bold" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Các dịch vụ khác</button>
            </li>
        </ul>
    </div>
    <div id="data_product">
        <div id="default-tab-content">
            <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div>
                    <div class="relative overflow-x-auto table-container">
                        <div class="scroll-area">
                            @include('deal.component.search',['products' => $products,'active' => 'maintain'])
                            <div class="mb-3">
                                <div class="grid grid-cols-5 gap-1 mt-2" id="boxDealView" style="display: none;">
                                    @foreach($deal_views as $val)
                                    <label for="check{{$val->id}}" class="flex space-x-1">
                                        <input {{!empty($permissionChecked)?($permissionChecked->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealView w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                                        <span>{{$val->title}}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex flex-1 items-center space-x-2 justify-end">
                                        @include('deal.component.remove')
                                    </div>
                                </div>
                            </div>
                            <div id="data1">
                                @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndex,'data' => $data1,'active' => 'maintain'])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="vps" role="tabpanel" aria-labelledby="vps-tab">
                <div>
                    <div class="relative overflow-x-auto table-container">
                        <div class="scroll-area">
                            @include('deal.component.search-vps',['products' => $products,'active' => 'vps'])
                            <div class="mb-3">
                                <div class="grid grid-cols-5 gap-1 mt-2" id="boxDealViewVps" style="display: none;">
                                    @foreach($deal_views_vps as $val)
                                    <label for="check{{$val->id}}" class="flex space-x-1">
                                        <input {{!empty($permissionCheckedVps)?($permissionCheckedVps->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealViewVps w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                                        <span>{{$val->title}}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex flex-1 items-center space-x-2 justify-end">
                                        @include('deal.component.remove-vps')
                                    </div>
                                </div>
                            </div>
                            <div id="data3">
                                @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndexVps,'data' => $data3,'table' => 'w3-table-all-2','active' => 'vps'])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <div>
                    <div class="relative overflow-x-auto table-container">
                        <div class="scroll-area">
                            @include('deal.component.search-website',['products' => $products,'active' => 'website'])
                            <div class="mb-3">
                                <div class="grid grid-cols-5 gap-1 mt-2" id="boxDealViewWebsite" style="display: none;">
                                    @foreach($deal_views_website as $val)
                                    <label for="check{{$val->id}}" class="flex space-x-1">
                                        <input {{!empty($permissionCheckedWebsite)?($permissionCheckedWebsite->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealViewWebsite w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                                        <span>{{$val->title}}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex flex-1 items-center space-x-2 justify-end">
                                        @include('deal.component.remove-website')
                                    </div>
                                </div>
                            </div>
                            <div id="data2">
                                @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndexWebsite,'data' => $data2,'table' => 'w3-table-all-2','active' => 'website'])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
    <div class="lds-dual-ring "></div>
</div>
<script>
    $('.w3-table-all-2').scroltable();
    $('.w3-table-all-3').scroltable();
</script>
<script>
    //gia hạn
    $(document).on('click', '.js_sort_maintain', function(e) {
        e.preventDefault();
        e.preventDefault();
        $('input[name="sorts"]').val($(this).attr('data-value'))
        loadAjaxDataIndex()
    })
    $(document).on('click', '.btn-search-submit', function(e) {
        e.preventDefault();
        loadAjaxDataIndex()
    })
    $(document).on('click', '.pagination-maintain a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadAjaxDataIndex(page);
        $("body,html").animate({
            scrollTop: 0
        }, 200);
    });
    $(document).on('click', '.handle_updateDealView', function(e) {
        var id = $(this).val();
        var isChecked = $(this).is(":checked");
        var perpage = $('select[name="perpage"]').val();
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var status = $('select[name="status"]').val()
        var date_end = $('input[name="date_end"]').val()
        var product = $('select[name="product"]').val()
        var source_date_start = $('input[name="source_date_start"]').val()
        var source_date_end = $('input[name="source_date_end"]').val()
        var keyword = $('input[name="keyword"]').val()
        var sorts = $('input[name="sorts"]').val()
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
                type: "index",
                active: "maintain",
                handle: "update",
                sorts: sorts,
                customer_id: <?php echo $customer->id ?>,
                catalogue_id: catalogue_id,
                status: status,
                catalogue_id: catalogue_id,
                date_end: date_end,
                product: product,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                perpage: perpage
            },
            success: function(data) {
                $('#data1').html(data.html);
                $('.w3-table-all').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    })
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
        var catalogue_child_id = $('select[name="catalogue_child_id"]').val()
        var product = $('select[name="product"]').val()
        var status = $('select[name="status"]').val()
        var date_end = $('input[name="date_end"]').val()
        var source_date_start = $('input[name="source_date_start"]').val()
        var source_date_end = $('input[name="source_date_end"]').val()
        var keyword = $('input[name="keyword"]').val()
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
                type: "index",
                active: "maintain",
                sorts: sorts,
                handle: "sort",
                customer_id: <?php echo $customer->id ?>,
                catalogue_child_id: catalogue_child_id,
                product: product,
                status: status,
                date_end: date_end,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                page: page,
                perpage: perpage,
            },
            success: function(data) {
                $('#data1').html(data.html);
                $('.w3-table-all').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    }
    // website
    $(document).on('click', '.js_sort_website', function(e) {
        e.preventDefault();
        $('input[name="sorts_website"]').val($(this).attr('data-value'))
        loadAjaxDataIndexWebsite()
    })
    $(document).on('click', '.btn-search-submit-website', function(e) {
        e.preventDefault();
        loadAjaxDataIndexWebsite()
    })
    $(document).on('click', '.pagination-website a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadAjaxDataIndexWebsite(page);
        $("body,html").animate({
            scrollTop: 0
        }, 200);
    });
    $(document).on("change", ".js_changeStatusWebsite", function() {

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
                                _this.val($('.js_changeStatusWebsite option:first').val());
                                //load lại data
                                loadAjaxDataIndexWebsite(page)
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


    $(document).on('click', '.handle_updateDealViewWebsite', function(e) {
        var id = $(this).val();
        var isChecked = $(this).is(":checked");
        var perpage = $('select[name="perpage_web"]').val();
        var catalogue_id = $('select[name="catalogue_id_website"]').val()
        var catalogue_child_id = $('select[name="catalogue_child_id_website"]').val()
        var product = $('select[name="product_website"]').val()
        var status = $('select[name="status_website"]').val()
        var date_end = $('input[name="date_end_website"]').val()
        var source_date_start = $('input[name="source_date_start_website"]').val()
        var source_date_end = $('input[name="source_date_end_website"]').val()
        var keyword = $('input[name="keyword_website"]').val()
        var sorts = $('input[name="sorts_website"]').val()
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
                type: "index",
                active: "website",
                handle: "update",
                sorts: sorts,
                customer_id: <?php echo $customer->id ?>,
                catalogue_id: catalogue_id,
                catalogue_child_id: catalogue_child_id,
                product: product,
                status: status,
                date_end: date_end,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                perpage: perpage
            },
            success: function(data) {
                $('#data2').html(data.html);
                $('.w3-table-all-2').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    })

    function loadAjaxDataIndexWebsite(page = 1) {
        var perpage = $('select[name="perpage_web"]').val();
        var sorts = $('input[name="sorts_website"]').val()
        var catalogue_id = $('select[name="catalogue_id_website"]').val()
        var catalogue_child_id = $('select[name="catalogue_child_id_website"]').val()
        var product = $('select[name="product_website"]').val()
        var status = $('select[name="status_website"]').val()
        var date_end = $('input[name="date_end_website"]').val()
        var source_date_start = $('input[name="source_date_start_website"]').val()
        var source_date_end = $('input[name="source_date_end_website"]').val()
        var keyword = $('input[name="keyword_website"]').val()
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
                type: "index",
                active: "website",
                sorts: sorts,
                handle: "sort",
                customer_id: <?php echo $customer->id ?>,
                catalogue_id: catalogue_id,
                catalogue_child_id: catalogue_child_id,
                product: product,
                status: status,
                date_end: date_end,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                page: page,
                perpage: perpage
            },
            success: function(data) {
                $('#data2').html(data.html);
                $('.w3-table-all-2').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    }
    // vps
    $(document).on('click', '.js_sort_vps', function(e) {
        e.preventDefault();
        $('input[name="sorts_vps"]').val($(this).attr('data-value'))
        loadAjaxDataIndexVps()
    })
    $(document).on('click', '.btn-search-submit-vps', function(e) {
        e.preventDefault();
        loadAjaxDataIndexVps()
    })
    $(document).on('click', '.pagination-vps a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadAjaxDataIndexVps(page);
        $("body,html").animate({
            scrollTop: 0
        }, 200);
    });
    $(document).on("change", ".js_changeStatusVps", function() {

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
                                _this.val($('.js_changeStatusVps option:first').val());
                                //load lại data
                                loadAjaxDataIndexVps(page)
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
    $(document).on('click', '.handle_updateDealViewVps', function(e) {
        var id = $(this).val();
        var isChecked = $(this).is(":checked");
        var perpage = $('select[name="perpageVps"]').val();
        var product = $('select[name="product_vps"]').val()
        var status = $('select[name="status_vps"]').val()
        var date_end = $('input[name="date_end_vps"]').val()
        var source_date_start = $('input[name="source_date_start_vps"]').val()
        var source_date_end = $('input[name="source_date_end_vps"]').val()
        var keyword = $('input[name="keyword_vps"]').val()
        var sorts = $('input[name="sorts_vps"]').val()
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
                type: "index",
                active: "vps",
                handle: "update",
                sorts: sorts,
                customer_id: <?php echo $customer->id ?>,
                product: product,
                status: status,
                date_end: date_end,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                perpage: perpage
            },
            success: function(data) {
                $('#data3').html(data.html);
                $('.w3-table-all-3').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    })

    function loadAjaxDataIndexVps(page = 1) {
        var perpage = $('select[name="perpageVps"]').val();
        var sorts = $('input[name="sorts_vps"]').val()
        var product = $('select[name="product_vps"]').val()
        var status = $('select[name="status_vps"]').val()
        var date_end = $('input[name="date_end_vps"]').val()
        var source_date_start = $('input[name="source_date_start_vps"]').val()
        var source_date_end = $('input[name="source_date_end_vps"]').val()
        var keyword = $('input[name="keyword_vps"]').val()
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
                type: "index",
                active: "vps",
                sorts: sorts,
                handle: "sort",
                customer_id: <?php echo $customer->id ?>,
                product: product,
                status: status,
                date_end: date_end,
                source_date_start: source_date_start,
                source_date_end: source_date_end,
                keyword: keyword,
                company: true,
                perpage: perpage,
                page: page
            },
            success: function(data) {
                $('#data3').html(data.html);
                console.log(data.html)
                $('.w3-table-all-3').scroltable();
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
        });
    }
</script>
<style>
    .tom-select-field-customer,
    .tom-select-field-customer-website,
    .tom-select-field-customer-vps {
        display: none !important;
    }
</style>
@include('deal.script.change')
@endpush
@extends('dashboard.layout.dashboard')
@section('title')
<title>Quản lý thuế</title>
@endsection
@section('breadcrumb')
<?php
$array = array(

    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Quản lý thuế",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-4">
            <label class="font-medium text-base mr-auto">Thiết lập thuế sản phẩm mặc định</label>
            <div class="mt-2">
                Áp dụng thuế sản phẩm mặc định khi thêm mới sản phẩm
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8">
            <div class=" box">
                <div id="formTaxConfig" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2 md:col-span-1">
                                <label for="vertical-form-1" class="form-label font-semibold">Thuế bán hàng mặc định</label>
                                <select class="form-select" aria-label="Default select example" name="taxSale">
                                    @if(!$data->isEmpty())
                                    @foreach($data as $item)
                                    <option value="<?php echo $item->id ?>" @if($item->taxSale == 1) selected="selected" @endif>{{$item->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label for="vertical-form-2" class="form-label font-semibold">Thuế nhập hàng mặc định</label>
                                <select class="form-select" aria-label="Default select example" name="taxPurchase">
                                    @if(!$data->isEmpty())
                                    @foreach($data as $item)
                                    <option value="<?php echo $item->id ?>" @if($item->taxPurchase == 1) selected="selected" @endif> {{$item->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="font-semibold">Thuế</label>
                            <div class="flex flex-col sm:flex-row mt-2 space-x-5">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-4" class="form-check-input" type="radio" name="active" value="1" @if($config->active==1) checked="checked" @endif>
                                    <label class="form-check-label" for="radio-switch-4">Giá chưa bao gồm thuế</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-5" class="form-check-input" type="radio" name="active" value="2" @if($config->active==2) checked="checked" @endif>
                                    <label class="form-check-label" for="radio-switch-5">Giá đã bao gồm thuế</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-5">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-4">
            <label class="font-medium text-base mr-auto">Quản lý thuế sản phẩm</label>
            <div class="mt-2">
                Thiết lập các loại thuế phục vụ thuế đầu vào, đầu ra cho sản phẩm/dịch vụ.
                <p><span style="color: red;">Lưu ý: </span> Bạn không thể sửa mức thuế suất mặc định hoặc đang áp dụng trong sản phẩm</p>
            </div>
            @if(env('APP_ENV') == "local")
            @can('ships_create')
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#form-add-tax" class="btn btn-primary mt-5">Thêm mới</a>
            @endcan
            @endif
        </div>
        <div class="col-span-12 lg:col-span-8">
            <div class="box">
                <div class="overflow-auto lg:overflow-visible">
                    <div class="overflow-hidden">
                        @if(!$data->isEmpty())
                        <table class="w-full">
                            <thead class="border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Tên
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Mã
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Thuế suất
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
                                        #
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$item->title}}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$item->code}}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$item->value}}%
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            @can('taxes_edit')
                                            <a class="flex items-center mr-3 js_editTax" href="javascript:void(0)" data-id="{{$item->id}}">
                                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                                Edit
                                            </a>
                                            @endcan
                                            @can('taxes_destroy')
                                            <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $item->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                Delete
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('javascript')

<div id="form-add-tax" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Thêm thông tin thuế
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 FormAddTax">
                <div class="col-span-12">
                    <div class="alert alert-danger-soft show flex items-center mb-2 print-error-msg" role="alert" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span class=""></span>
                    </div>
                </div>
                <div class="col-span-12">
                    <label for="modal-form-1" class="form-label">Tên thuế<span style="color: red">*</span></label>
                    <input id="modal-form-1" type="text" class="form-control" name="title" placeholder="Ví dụ: VAT">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Mã thuế</label>
                    <input id="modal-form-2" type="text" class="form-control" name="code" placeholder="Ví dụ: THUEDAUVAO">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-3" class="form-label">Thuế suất(%)<span style="color: red">*</span></label>
                    <input id="modal-form-3" type="text" class="form-control" name="value" placeholder="Ví dụ: 10%">
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                <button type="button" class="btn btn-primary js_submitFormAddTax">Thêm mới</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<div id="form-update-tax" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Cập nhập thông tin thuế
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 FormUpdateTax">
                <div class="col-span-12">
                    <div class="alert alert-danger-soft show flex items-center mb-2 print-error-msg" role="alert" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span class=""></span>
                    </div>
                </div>
                <div class="col-span-12">
                    <label for="modal-form-1" class="form-label">Tên thuế<span style="color: red">*</span></label>
                    <input id="modal-form-1" type="text" class="form-control" name="title" placeholder="Ví dụ: VAT">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Mã thuế</label>
                    <input id="modal-form-2" type="text" class="form-control" name="code" placeholder="Ví dụ: THUEDAUVAO">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-3" class="form-label">Thuế suất(%)<span style="color: red">*</span></label>
                    <input id="modal-form-3" type="text" class="form-control" name="value" placeholder="Ví dụ: 10%">
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                <button type="button" class="btn btn-primary js_submitFormUpdateTax">Cập nhập</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.js_submitFormAddTax', function(e) {
        e.preventDefault();
        var title = $('.FormAddTax input[name="title"]').val();
        var code = $('.FormAddTax input[name="code"]').val();
        var value = $('.FormAddTax input[name="value"]').val();
        $.ajax({
            url: "<?php echo route('taxes.create') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: title,
                code: code,
                value: value,
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".FormAddTax .print-error-msg").css('display', 'none');
                    swal({
                        title: "Thông báo!",
                        text: data.success,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $(".FormAddTax .print-error-msg").css('display', 'flex');
                    $(".FormAddTax .print-success-msg").css('display', 'none');
                    $(".FormAddTax .print-error-msg span").html(data.error);
                }

            }
        });
    })
    $(document).on('click', '.js_editTax', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo route('taxes.edit') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: $(this).attr('data-id'),
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('.FormUpdateTax input[name="title"]').val(data.data.title);
                    $('.FormUpdateTax input[name="code"]').val(data.data.code);
                    $('.FormUpdateTax input[name="value"]').val(data.data.value);
                    $('.js_submitFormUpdateTax').attr('data-id', data.data.id);
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#form-update-tax"));
                    myModal.show();
                } else {
                    swal({
                        title: "Thông báo",
                        text: data.error,
                        type: "error"
                    });
                }

            }
        });
    })
    $(document).on('click', '.js_submitFormUpdateTax', function(e) {
        e.preventDefault();
        var title = $('.FormUpdateTax input[name="title"]').val();
        var code = $('.FormUpdateTax input[name="code"]').val();
        var value = $('.FormUpdateTax input[name="value"]').val();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "<?php echo route('taxes.update') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: title,
                code: code,
                value: value,
                id: id,
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".FormUpdateTax .print-error-msg").css('display', 'none');
                    swal({
                        title: "Thông báo!",
                        text: data.success,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $(".FormUpdateTax .print-error-msg").css('display', 'flex');
                    $(".FormUpdateTax .print-success-msg").css('display', 'none');
                    $(".FormUpdateTax .print-error-msg span").html(data.error);
                }

            }
        });
    })
    $(document).on('click', '#formTaxConfig button', function(e) {
        e.preventDefault();
        var taxSale = $('#formTaxConfig select[name="taxSale"]').val();
        var taxPurchase = $('#formTaxConfig select[name="taxPurchase"]').val();
        var active = $('#formTaxConfig input[name="active"]:checked').val();
        $.ajax({
            url: "<?php echo route('taxes.config') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                taxSale: taxSale,
                taxPurchase: taxPurchase,
                active: active,
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $("#formTaxConfig .print-error-msg").css('display', 'none');
                    swal({
                        title: "Thông báo!",
                        text: data.success,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $("#formTaxConfig .print-error-msg").css('display', 'flex');
                    $("#formTaxConfig .print-success-msg").css('display', 'none');
                    $("#formTaxConfig .print-error-msg span").html(data.error);
                }

            }
        });
    })
</script>
@endpush
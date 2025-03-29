@extends('dashboard.layout.dashboard')
@section('title')
<title>Gửi email gia hạn</title>
@endsection
@section('breadcrumb')
<?php

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Tag;

$routeIndex = '';
$array = array(
    [
        "title" => "Danh sách các hợp đồng",
        "src" => url()->previous(),
    ],
    [
        "title" => $detail->title,
        "src" => route('deals.edit', ['id' => $detail->id]),
    ],
    [
        "title" => "Gửi email gia hạn",
        "src" => 'javascript:void(0)',
    ]
);

echo breadcrumb_backend($array);
$source_date_start = \Carbon\Carbon::today()->format('d/m/Y');
$source_date_end = \Carbon\Carbon::today()->addYear()->format('d/m/Y');
$brands = Brand::get();
$tags = CategoryProduct::where('parentid', 1)->get();
?>

@endsection
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<form class="" action="{{route('deals.emailStore',['id' => $detail->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-4 space-y-5 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div class="col-span-3">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg font-bold" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Thông tin</button>
                        </li>
                    </ul>
                </div>
                <div id="default-tab-content">
                    <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid grid-cols-1 gap-8">
                            <div class="col-span-1">
                                <div class="w-full mx-auto bg-white  rounded-bl-[10px] rounded-br-[10px]">
                                    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin về giao dịch</h3>
                                    <div class="p-[10px] grid grid-cols-1 gap-8">
                                        <div>
                                            @include('components.alert-error')
                                            @csrf
                                            <ul class="p-0 m-0 ">
                                                <?php
                                                $customer_id = !empty(old('customer_id')) ? old('customer_id') : (!empty($detail->customer_id) ? $detail->customer_id : '');
                                                $category_products_default = !empty($active == 'website') ? 2 : 1;
                                                $catalogue_id = !empty(old('catalogue_id')) ? old('catalogue_id') : (!empty($detail->catalogue_id) ? $detail->catalogue_id : $category_products_default);
                                                ?>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] ">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Danh mục*</span></span>
                                                    <?php echo Form::select('catalogue_id', $category_products, $catalogue_id, ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục", 'required']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[5px]">
                                                    <span class="bg-white font-semibold flex-1 space-x-1">
                                                        <span class="text-red-600">Khách hàng - Công ty*</span>
                                                        <a href="{{route('deals.search',['id' => $customer_id])}}" target="_blank" class="text-blue-600 underline" id="dealSearchCompany">Chi tiết công ty</a>
                                                    </span>
                                                    <div class="space-x-1 flex">
                                                        <div class="flex-1">
                                                            <?php echo Form::select('customer_id', $customers, $customer_id, ['class' => 'tom-select tom-select-field-customer w-full', 'placeholder' => "Chọn khách hàng", 'required']); ?>
                                                        </div>
                                                        <div>
                                                            <textarea id="copyCustomer" class="hidden"></textarea>
                                                            <a href="javascript:void(0)" id="copyButton" data-tooltip-target="tooltip-default" class="text-white h-10 flex items-center bg-blue-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z"></path>
                                                                </svg>
                                                            </a>
                                                            <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-blue-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                Sao chép công ty
                                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[5px]">
                                                    <?php
                                                    if (!empty($detail->customer)) {
                                                        $email = explode(",", $detail->customer->email);
                                                    }
                                                    ?>
                                                    <span class="bg-white font-semibold flex-1">E-mail</span>
                                                    <?php echo Form::text('email', !empty(old('email')) ? old('email') : (!empty($detail->email) ? $detail->email : (!empty($email) ? $email[0] : '')), ['class' => 'form-control', 'placeholder' => 'E-mail']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[5px]">

                                                    <span class="bg-white font-semibold flex-1">CC</span>
                                                    <?php echo Form::text('email_cc', !empty(old('email_cc')) ? old('email_cc') : '', ['class' => 'form-control', 'placeholder' => 'E-mail cc']); ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 md:col-span-1">
                                <div class="w-full mx-auto bg-white  rounded-bl-[10px] rounded-br-[10px]">
                                    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Chọn sản phẩm</h3>
                                    <div class="p-[10px]">
                                        <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black">
                                            <thead class="text-xs ">
                                                <tr>
                                                    <th scope="col" class="p-2" style="width: 10px;">
                                                        <i class="fa-solid fa-gear text-lg"></i>
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Sản phẩm
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Tên miền
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Phân loại
                                                    </th>
                                                    <th scope="col" class="p-2 tdDeal hidden">
                                                        Duy trì
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Giá
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Số lượng
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Giảm giá (VNĐ)
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Thuế
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Tổng thuế (VNĐ)
                                                    </th>
                                                    <th scope="col" class="p-2">
                                                        Thành tiền (VNĐ)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="listProduct">
                                                <?php
                                                $phan_loai = [];
                                                if (!empty($detail)) {
                                                    if ($detail->catalogue_id == 1) {
                                                        $phan_loai = dropdown($brands, 'Phân loại', 'title', 'title');
                                                    } else if ($detail->catalogue_id == 2) {
                                                        $phan_loai = $category_products_child;
                                                    } else {
                                                        $phan_loai = $category_products;
                                                    }
                                                }
                                                ?>
                                                @if(!empty($detail->deal_relationships))
                                                @foreach($detail->deal_relationships as $item)
                                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd">
                                                    <td class="p-2">
                                                        <a href="javascript:void(0)" class="handleRemoveItemProduct"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="relative ">
                                                            <input name="product_title[]" class="form-control w-full" value="{{$item->title}}">
                                                        </div>
                                                        <div class="listProducts">
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <input name="product_domain[]" class="form-control w-full" value="{{$item->domain}}">
                                                    </td>
                                                    <td>
                                                        <select placeholder="" class="form-control" name="product_phanloai[]">
                                                            <option value="">Phân loại</option>
                                                            @if(!empty($phan_loai))
                                                            @foreach($phan_loai as $key=>$val)
                                                            <option value="{{$val}}" @if($item->phan_loai == $val) selected @endif>{{$val}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td class="p-2 tdDeal hidden">
                                                        <select placeholder="" class="form-control" name="product_duytri_deal[]">
                                                            <option value="">Duy trì</option>
                                                            @if(!empty($tags))
                                                            @foreach($tags as $val)
                                                            <option value="{{$val->title}}" @if($item->duy_tri == $val->title) selected @endif>{{$val->title}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td class="p-2">
                                                        <input name="product_price[]" class="form-control w-full" value="{{$item->price}}">
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="relative flex space-x-1">
                                                            <input name="product_quantity[]" class="form-control w-full" value="{{$item->quantity}}">
                                                            <select class="outline-none focus:outline-none hover:outline-none border-0 flex-1" data-placeholder="" name="product_unit[]">
                                                                <option value="year" @if($item->unit == 'year') selected @endif>Năm</option>
                                                                <option value="month" @if($item->unit == 'month') selected @endif>Tháng</option>
                                                                <option value="vnd" @if($item->unit == 'vnd') selected @endif>VNĐ</option>
                                                                <option value="cai" @if($item->unit == 'cai') selected @endif>Cái</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="flex space-x-1">
                                                            <input name="product_price_sale[]" class="form-control w-full" value="{{$item->sales}}">
                                                            <select class="outline-none focus:outline-none hover:outline-none border-0 flex-1 hidden" data-placeholder="" name="product_price_sale_type[]">
                                                                <option value="VND" @if($item->product_price_sale_type == 'VND') selected @endif>VNĐ</option>
                                                                <option value="percent" @if($item->product_price_sale_type == 'percent') selected @endif>%</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <select class="form-control" name="product_price_tax[]">
                                                            @foreach(config('tamphat')['tax'] as $ktax=>$tax)
                                                            <option value="{{$ktax}}" @if($item->tax == $ktax) selected @endif>{{$tax}}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" name="taxInputOfItem[]" class="taxInputOfItem hidden" value="{{$item->tax_price}}">
                                                    </td>
                                                    <td class="p-2 taxValueOfItem">
                                                        {{number_format($item->tax_price,'0',',','.')}}
                                                    </td>
                                                    <td class="p-2 totalValuePrice">
                                                        <?php
                                                        $totalPrice = ($item->price * $item->quantity) - $item->sales;
                                                        ?>
                                                        {{number_format($totalPrice+$item->tax_price,'0',',','.')}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr class="hidden">
                                                    <td class="p-2" colspan="2"><a href="javascript:void(0)" class="handleAddProduct max-w-[204px] cursor-pointer text-white bg-red-600 font-medium text-sm p-[10px] text-center rounded-lg z-10 flex justify-center">Thêm sản phẩm mới</a> </td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right" colspan="5">Tổng số không có chiết khấu và thuế: </td>
                                                    <td class="p-2 text-right price_1" colspan="5">{{!empty(old('price_1')) ? number_format(old('price_1'),'0',',','.') : (!empty($detail->price_1) ? number_format($detail->price_1,'0',',','.') : 0)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right" colspan="5">Số tiền chiết khấu: </td>
                                                    <td class="p-2 text-right price_2" colspan="5">{{!empty(old('price_2')) ? number_format(old('price_2'),'0',',','.') : (!empty($detail->price_2) ? number_format($detail->price_2,'0',',','.') : 0)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right" colspan="5">Tổng số trước thuế: </td>
                                                    <td class="p-2 text-right price_3" colspan="5">{{!empty(old('price_3')) ? number_format(old('price_3'),'0',',','.') : (!empty($detail->price_3) ? number_format($detail->price_3,'0',',','.') : 0)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right" colspan="5">Tổng thuế: </td>
                                                    <td class="p-2 text-right price_4" colspan="5">{{!empty(old('price_4')) ? number_format(old('price_4'),'0',',','.') : (!empty($detail->price_4) ? number_format($detail->price_4,'0',',','.') : 0)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right font-bold text-red-600" colspan="5">Tổng số tiền: </td>
                                                    <td class="p-2 text-right font-bold text-red-600 price_5" colspan="5">{{!empty(old('price_5')) ? number_format(old('price_5'),'0',',','.') : (!empty($detail->price_5) ? number_format($detail->price_5,'0',',','.') : 0)}} đ</td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input class="hidden" name="price_1" value="{{!empty(old('price_1')) ? old('price_1') : (!empty($detail->price_1) ? $detail->price_1 : 0)}}">
    <input class="hidden" name="price_2" value="{{!empty(old('price_2')) ? old('price_2') : (!empty($detail->price_2) ? $detail->price_2 : 0)}}">
    <input class="hidden" name="price_3" value="{{!empty(old('price_3')) ? old('price_3') : (!empty($detail->price_3) ? $detail->price_3 : 0)}}">
    <input class="hidden" name="price_4" value="{{!empty(old('price_4')) ? old('price_4') : (!empty($detail->price_4) ? $detail->price_4 : 0)}}">
    <input class="hidden" name="price_5" value="{{!empty(old('price_5')) ? old('price_5') : (!empty($detail->price_5) ? $detail->price_5 : 0)}}">
    <div class="relative">
        <div class="fixed bottom-0 bg-white shadow-lg w-full px-5 py-2 z-10">
            <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Gửi email
            </button>
        </div>
    </div>
</form>
@endsection
@push('javascript')
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
    new TomSelect(".tom-select-field-customer", {
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
</script>
<!-- Copy text -->
<script>
    $(document).ready(function() {
        $("#copyButton").click(function() {
            var textToCopy = $("#tomselect-3").find("option:selected").text();
            var tempInput = $("<input>");
            $("body").append(tempInput);
            tempInput.val(textToCopy).select();
            document.execCommand("copy");
            tempInput.remove();
            toastr.success("Sao chép thành công!", 'Thông báo')
        });
    });

    $(document).on('change', 'select[name="customer_id"]', function(e) {
        e.preventDefault()
        var id = $(this).val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.customer')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $('input[name="email"]').val(data.customer.email)
                $('#dealSearchCompany').attr('href', `<?php echo route('deals.search') ?>?id=${id}`)
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
    })
</script>
<script>
    loadCheckCategory()

    function loadCheckCategory() {
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var textCheck = $('select[name="catalogue_id"]').children("option:selected").text();
        if (catalogue_id == 1) {
            $('.tdDeal').removeClass('hidden')
        } else {
            $('.tdDeal').addClass('hidden')
        }

    }
</script>
<script>
    $(document).on('click', '.handleAddProduct', function(e) {
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var textCheck = $(this).children("option:selected").text();
        console.log(catalogue_id)
        e.preventDefault();
        var html = '';
        html += '<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd">'
        html += '<td class="p-2">'
        html += '<a href="javascript:void(0)" class="handleRemoveItemProduct"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">'
        html += '<path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />'
        html += '</svg></a>'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<div class="relative"><input name="product_title[]" class="form-control w-full"></div><div class="listProducts"></div>'
        html += '</td>'
        /*mới */
        <?php
        $phan_loai_1 = dropdown($brands, 'Phân loại', 'title', 'title');
        $phan_loai_2 = $category_products_child;
        $phan_loai = $category_products;
        ?>
        html += '<td class="p-2">'
        html += '<select placeholder="" class="form-control" name="product_phanloai[]">'
        html += '<option value="">Phân loại</option>'
        if (catalogue_id == 1) {
            <?php foreach ($phan_loai_1 as $item) { ?>
                html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
            <?php } ?>
        } else if (catalogue_id == 2) {
            <?php foreach ($phan_loai_2 as $item) { ?>
                html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
            <?php } ?>
        } else {
            <?php foreach ($phan_loai as $item) { ?>
                if (textCheck === '<?php echo $item ?>') {
                    html += '<option value="<?php echo $item ?>" selected><?php echo $item ?></option>'
                } else {
                    html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
                }
            <?php } ?>
        }
        html += '</select>'
        html += '</td>'

        html += '<td class="p-2 tdDeal">'
        html += '<select placeholder="" class="form-control" name="product_duytri_deal[]">'
        html += '<option value="">Duy trì</option>'
        <?php if (!empty($tags)) {
            foreach ($tags as $key => $val) { ?>
                html += '<option value="<?php echo $val->title ?>"><?php echo $val->title ?></option>'
        <?php }
        } ?>
        html += '</select>'
        html += '</td>'
        /*END: mới */
        html += '<td class="p-2">'
        html += '<input name="product_price[]" class="form-control w-full">'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<div class="relative flex space-x-1">'
        html += '<input name="product_quantity[]" class="form-control w-full" value="1">'
        html += '<select class="outline-none focus:outline-none hover:outline-none border-0 flex-1" data-placeholder="" name="product_unit[]">'
        html += '<option value="year">Năm</option>'
        html += '<option value="month">Tháng</option>'
        html += '<option value="vnd">VNĐ</option>'
        html += '<option value="cai">Cái</option>'
        html += '</select>'
        html += '</div>'
        html += '</td>'
        html += '<td class="p-2 flex space-x-1">'
        html += '<input name="product_price_sale[]" class="form-control w-full ">'
        html += '<select class="outline-none focus:outline-none hover:outline-none border-0 flex-1 hidden" data-placeholder="" name="product_price_sale_type[]">'
        html += '<option value="VND">VNĐ</option>'
        html += '<option value="percent">%</option>'
        html += '</select>'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<select class="form-control" name="product_price_tax[]">'
        html += '<option value="-1">Chưa tính thuế</option>'
        html += '<option value="0">0%</option>'
        html += '<option value="10">10%</option>'
        html += '</select><input type="text" name="taxInputOfItem[]" class="taxInputOfItem hidden">'
        html += '</td>'
        html += '<td class="p-2 taxValueOfItem">'
        html += '0đ'
        html += '</td>'
        html += '<td class="p-2 totalValuePrice">'
        html += '0đ'
        html += '</td>'
        html += '</tr>';
        $('#listProduct').append(html)
        loadCheckCategory()
    })
    $(document).on('click', '.handleRemoveItemProduct', function(e) {
        $(this).parent().parent().remove()
        loadCheckCategory()
        loadPrice()
    })
    /*Thay đổi sản phẩm */
    $(document).on('click', '.itemProduct', function(e) {
        e.preventDefault()
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var title = $(this).attr("data-title")
        var price = $(this).attr("data-price")
        var priceNoneFormat = $(this).attr("data-price-none")
        var categoryTitle = $(this).attr("data-category-title")
        if (catalogue_id == 2) {
            $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_phanloai_website[]"]').val(categoryTitle)
        } else {
            $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_duytri_deal[]"]').val(categoryTitle)
        }
        $(this).parent().parent().parent().parent().parent().find('input[name="product_title[]"]').val(title)
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price[]"]').val(price)
        var tax = $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_price_tax[]"]').val()
        var price_sale = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price_sale[]"]').val()
        var product_price_sale_type = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price_sale_type[]"]').val() /*Loại giảm giá */
        var quantity = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_quantity[]"]').val()
        var taxValueOfItem = totalValuePrice = totalSales = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        if (product_price_sale_type == 'percent') {
            totalSales = ((parseInt(price) * parseFloat(quantity)) / 100) * price_sale
        } else {
            totalSales = price_sale;
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(totalSales)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        // console.log("price - " + price)
        // console.log("tax - " + taxValueOfItem)
        // console.log("price_sale - " + taxValueOfItem)
        // console.log("quantity - " + taxValueOfItem)
        // console.log("taxValueOfItem - " + taxValueOfItem)
        $(this).parent().parent().parent().parent().parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().parent().parent().parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().parent().parent().parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        $('.listProducts').html('')
        loadPrice()
    })
    /*Thay đổi kiểu giảm giá */
    $(document).on('change', 'select[name="product_price_sale_type[]"]', function(e) {
        e.preventDefault()
        //tính lại thuế
        var product_price_sale_type = $(this).val()
        var price_sale = $(this).parent().find('input[name="product_price_sale[]"]').val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var taxValueOfItem = totalValuePrice = totalSales = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        if (product_price_sale_type == 'percent') {
            totalSales = ((parseInt(price) * parseFloat(quantity)) / 100) * price_sale
            console.log(price)
            console.log(quantity)
            console.log(price_sale)
            console.log(totalSales)
        } else {
            totalSales = price_sale;
        }
        totalValuePrice = ((price * parseFloat(quantity)) - parseInt(totalSales))
        if (price_sale && tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()

    })
    $(document).on('change', 'select[name="product_price_tax[]"]', function(e) {
        e.preventDefault()
        var tax = $(this).val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price_sale = $(this).parent().parent().find('input[name="product_price_sale[]"]').val()
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        var taxValueOfItem = totalValuePrice = 0
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        console.log(price)
        console.log(quantity)
        console.log(price_sale)
        console.log(tax)
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        loadPrice()

    })
    $(document).on('keyup', 'input[name="product_price[]"]', function(e) {
        e.preventDefault()
        var price = $(this).val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price_sale = $(this).parent().parent().find('input[name="product_price_sale[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        loadPrice()
    })
    $(document).on('keyup', 'input[name="product_quantity[]"]', function(e) {
        e.preventDefault()
        var quantity = $(this).val()
        var tax = $(this).parent().parent().parent().find('select[name="product_price_tax[]"]').val()
        var price = $(this).parent().parent().parent().find('input[name="product_price[]"]').val()
        var price_sale = $(this).parent().parent().parent().find('input[name="product_price_sale[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()
    })
    $(document).on('keyup', 'input[name="product_price_sale[]"]', function(e) {
        e.preventDefault()
        //tính lại thuế
        var price_sale = $(this).val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = ((price * parseFloat(quantity)) - parseInt(price_sale))
        if (price_sale && tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()
    })
    $(document).on('click keyup', 'input[name="product_title[]"]', function(e) {
        var keyword = $(this).val()
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.product')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                keyword: keyword,
            },
            success: function(data) {
                var html = ''
                html += '<div class="absolute w-[565px] h-[300px] bg-white z-[99999] rounded-lg" style="overflow-x: hidden;overflow-y: scroll;scrollbar-color: rgba(0, 0, 0, 0.21) transparent;scrollbar-width: thin;">' + data.html + '</div>'
                _this.parent().parent().find('.listProducts').append(html)
                if (!data.count) {
                    $('.titlePrd').html(keyword)
                }
            }
        });
    })
    $('body').click(function(e) {
        // Check if the click did not occur inside #myDiv
        // console.log($(e.target).closest('.listProducts input').length)
        if ($(e.target).closest('.listProducts').length || $(e.target).closest('input[name="product_title[]"]').length) {} else {
            $('.listProducts').html('')
        }
    });
    //load price 
    function loadPrice() {
        var total = sales = tax = 0;
        $('input[name="product_price[]"]').each(function() {
            var price = $(this).val()
            var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
            total += price * quantity
        });
        $('input[name="product_price_sale[]"]').each(function() {
            sales += parseInt($(this).val())
        });
        $('input[name="taxInputOfItem[]"]').each(function() {
            tax += parseInt($(this).val())
        });
        if (isNaN(sales)) {
            sales = 0
        }
        if (isNaN(tax)) {
            tax = 0
        }
        $('.price_1').html(numberWithCommas(total))
        $('.price_2').html(numberWithCommas(sales))
        $('.price_3').html(numberWithCommas(total - sales))
        $('.price_4').html(numberWithCommas(tax))
        $('.price_5').html(numberWithCommas(total - sales + tax))
        $('input[name="price_1"]').val(total)
        $('input[name="price_2"]').val(sales)
        $('input[name="price_3"]').val(total - sales)
        $('input[name="price_4"]').val(tax)
        $('input[name="price_5"]').val(total - sales + tax)
        $('input[name="price"]').val(numberWithCommas(total - sales + tax))
    }
</script>

@endpush
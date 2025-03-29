@extends('dashboard.layout.dashboard')
@section('title')
<title>{{!empty($action == 'create') ? "Thêm mới hợp đồng" : "Cập nhập hợp đồng"}}</title>
@endsection
@section('breadcrumb')
<?php

use App\Models\Brand;
use App\Models\Tag;

if ($action == 'create') {
    $array = array(
        [
            "title" => "Danh sách các HĐ thiết kế web + khác ",
            "src" => route('deals.index'),
        ],
        [
            "title" => "Thêm mới",
            "src" => 'javascript:void(0)',
        ]
    );
} else {
    $array = array(
        [
            "title" => "Danh sách các HĐ thiết kế web + khác ",
            "src" => route('deals.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
}

echo breadcrumb_backend($array);
$source_date_start = \Carbon\Carbon::today()->format('d/m/Y');
$source_date_end = \Carbon\Carbon::today()->addYear()->format('d/m/Y');
$brands = Brand::get();
$tags = Tag::get();
?>

@endsection
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<form class="" action="{{!empty($action == 'create') ? route('deals.store') : route('deals.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-4 space-y-5 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            @if($action == 'update')
            @include('deal.backend.status')
            @endif
            <div class="col-span-3">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg font-bold" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Thông tin</button>
                        </li>
                        @if($action == 'update')
                        <li class="ml-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 font-bold" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Hóa đơn</button>
                        </li>
                        @endif
                    </ul>
                </div>
                <div id="default-tab-content">
                    <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="col-span-1 md:col-span-2">
                                <div class="w-full mx-auto bg-white  rounded-bl-[10px] rounded-br-[10px]">
                                    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin về giao dịch</h3>
                                    <div class="p-[10px] grid grid-cols-2 gap-8">
                                        <div>
                                            @include('components.alert-error')
                                            @csrf
                                            <ul class="p-0 m-0 ">
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Danh mục*</span></span>
                                                    <?php echo Form::select('catalogue_id', $category_products, !empty(old('catalogue_id')) ? old('catalogue_id') : (!empty($detail->catalogue_id) ? $detail->catalogue_id : 1), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục", 'required']); ?>
                                                </li>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tên*</span></span>
                                                    <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : ''), ['class' => 'form-control', 'placeholder' => 'Tên công ty', 'required']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Tên miền web(cả phụ)</span>
                                                    <?php
                                                    $website = !empty(old('website')) ? old('website') : (!empty($detail->website) ? json_decode($detail->website, TRUE) : []);
                                                    $websites = [];
                                                    foreach ($website as $item) {
                                                        $websites[] = array(
                                                            $item => $item
                                                        );
                                                    }
                                                    ?>
                                                    <?php echo Form::select('website[]', $websites, !empty(old('website')) ? old('website') : (!empty($detail->website) ? json_decode($detail->website, TRUE) : ''), ['class' => 'tom-select tom-select-field-website w-full', 'placeholder' => "Chọn tên miền", 'required', 'multiple']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Giai đoạn</span>
                                                    <?php echo Form::select('status', config('tamphat')['status_web'], !empty(old('status')) ? old('status') : (!empty($detail->status) ? $detail->status : ''), ['class' => 'form-control', 'placeholder' => "Chọn giai đoạn"]); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">CHỌN DS : FREE HOSTING, TÊN MIỀN, SSL</span>
                                                    <?php echo Form::select('free[]', config('tamphat')['free'], !empty(old('free')) ? old('free') : (!empty($detail->free) ? json_decode($detail->free, TRUE) : ''), ['class' => 'tom-select tom-select-field-free w-full', 'placeholder' => "CHỌN DS : FREE HOSTING, TÊN MIỀN, SSL", 'multiple']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Loại giao dịch</span>
                                                    <?php echo Form::select('type', config('tamphat')['type'], !empty(old('type')) ? old('type') : (!empty($detail->type) ? $detail->type : ''), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); ?>
                                                </li>

                                                <li class="flex text-[15px] p-[5px] space-x-8">
                                                    <div class="w-full">
                                                        <span class="bg-white font-semibold flex-1">Chịu trách nghiệm<span class="text-red-600">*</span></span>
                                                        <?php echo Form::select('users_support[]', $users, !empty(old('users_support')) ? old('users_support') : (!empty($detail->users_support) ? json_decode($detail->users_support, TRUE) : ''), ['class' => 'tom-select tom-select-field-support w-full', 'placeholder' => "Chịu trách nghiệm", 'multiple', 'required']); ?>
                                                    </div>
                                                    <div class="w-1/2 hidden">
                                                        <span class="bg-white font-semibold flex-1">Người quan sát</span>
                                                        <?php echo Form::select('users_join[]', $users, !empty(old('users_join')) ? old('users_join') : (!empty($detail->users_join) ? json_decode($detail->users_join, TRUE) : ''), ['class' => 'tom-select tom-select-field-join w-full', 'placeholder' => "Người quan sát", 'multiple']); ?>
                                                    </div>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-2">
                                                    <span class="bg-white font-semibold flex-1">Hợp đồng</span>
                                                    <div class="relative">
                                                        <label for="file_input" class="cursor-pointer text-white bg-primary font-medium text-sm px-5 py-1.5 text-center rounded-lg z-10">
                                                            <span class="uploadFile">Upload file</span>
                                                            <input name="file" class="hidden" id="file_input" type="file" onchange="mainThamUrl(this)">
                                                        </label>
                                                        @if(!empty($detail) && !empty($detail->file))
                                                        <div class="mt-2">
                                                            <a href="{{$detail->file}}" target="_blank" class="text-blue-600 underline">{{$detail->file}}</a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <ul class="p-0 m-0 ">
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Nguồn</span>
                                                    <?php echo Form::select('source', config('tamphat')['source'], !empty(old('source')) ? old('source') : (!empty($detail->source) ? $detail->source : ''), ['class' => 'tom-select tom-select-field-source w-full', 'placeholder' => 'Chọn nguồn']); ?>
                                                </li>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Khách hàng - Công ty*</span></span>
                                                    <?php echo Form::select('customer_id', $customers, !empty(old('customer_id')) ? old('customer_id') : (!empty($detail->customer_id) ? $detail->customer_id : ''), ['class' => 'tom-select tom-select-field w-full', 'placeholder' => "Chọn khách hàng", 'required']); ?>
                                                    <div class="{{!empty(old('customer_id')) ? '' : (!empty($detail->customer_id) ? '' : 'hidden')}}" id="infoCustomer">
                                                        <?php
                                                        if (!empty($detail->customer)) {
                                                            $hotline = explode(",", $detail->customer->hotline);
                                                            $email = explode(",", $detail->customer->email);
                                                            $address = $detail->customer->address;
                                                        }
                                                        ?>
                                                        <ul class="p-0 m-0 form-control">
                                                            <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                                <span class="bg-white font-semibold flex-1">Điện thoại</span>
                                                                <?php echo Form::text('phone', !empty(old('phone')) ? old('phone') : (!empty($detail->phone) ? $detail->phone : (!empty($hotline) ? $hotline[0] : '')), ['class' => 'form-control', 'placeholder' => 'Điện thoại']); ?>
                                                            </li>
                                                            <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                                <span class="bg-white font-semibold flex-1">E-mail</span>
                                                                <?php echo Form::text('email', !empty(old('email')) ? old('email') : (!empty($detail->email) ? $detail->email : (!empty($email) ? $email[0] : '')), ['class' => 'form-control', 'placeholder' => 'E-mail']); ?>
                                                            </li>
                                                            <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                                <span class="bg-white font-semibold flex-1">Địa chỉ</span>
                                                                <?php echo Form::text('address', !empty(old('address')) ? old('address') : (!empty($detail->address) ? $detail->address : (!empty($address) ? $address : '')), ['class' => 'form-control', 'placeholder' => 'Địa chỉ']); ?>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Thông tin nguồn</span>
                                                    <?php echo Form::textarea('source_description', !empty(old('source_description')) ? old('source_description') : (!empty($detail->source_description) ? $detail->source_description : ''), ['class' => 'form-control', 'placeholder' => '']); ?>
                                                </li>
                                                <?php
                                                $ips = !empty(old('ips')) ? old('ips') : (!empty($detail->ips) ?  explode(',', $detail->ips) : []);
                                                ?>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">IPS</span>
                                                    <div class="space-y-1" id="htmlHotline">
                                                        @if(!empty($ips) && count($ips) > 0)
                                                        @foreach($ips as $item)
                                                        @if(!empty($item))
                                                        <div class="flex space-x-3">
                                                            <?php echo Form::text('ips[]', $item, ['class' => 'form-control', 'placeholder' => '']); ?>
                                                            <button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <div class="flex space-x-3">
                                                            <?php echo Form::text('ips[]', '', ['class' => 'form-control', 'placeholder' => '']); ?>
                                                            <button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <a href="javascript:void(0)" class="js_addHotline w-full cursor-pointer mt-2 float-left underline text-blue-600">
                                                        <i class="fa-solid fa-plus"></i>
                                                        Thêm
                                                    </a>
                                                </li>



                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] hidden">
                                                    <span class="bg-white font-semibold flex-1">Số tiền (VNĐ)</span>
                                                    <?php echo Form::text('price', !empty(old('price')) ? old('price') : (!empty($detail->price) ? number_format($detail->price, '0', '.', '.') : ''), ['class' => 'form-control int', 'placeholder' => '0']); ?>
                                                </li>




                                                <li class="flex text-[15px] p-[5px] space-x-8 hidden">
                                                    <div class="w-1/2">
                                                        <span class="bg-white font-semibold flex-1">Số tiền đã thu (VNĐ)</span>
                                                        <?php echo Form::text('price_collected', !empty(old('price_collected')) ? old('price_collected') : (!empty($detail->price_collected) ? number_format($detail->price_collected, '0', '.', '.') : ''), ['class' => 'form-control int', 'placeholder' => '0']); ?>
                                                    </div>
                                                    <div class="w-1/2">
                                                        <span class="bg-white font-semibold flex-1">Số tiền chưa thu (VNĐ)</span>
                                                        <?php echo Form::text('price_not_collected', !empty(old('price_not_collected')) ? old('price_not_collected') : (!empty($detail->price_not_collected) ? number_format($detail->price_not_collected, '0', '.', '.') : ''), ['class' => 'form-control int', 'placeholder' => '0']); ?>
                                                    </div>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] hidden">
                                                    <span class="bg-white font-semibold flex-1">CHỌN CÔNG TY TÂM PHÁT</span>
                                                    <?php echo Form::select('company', $companies, !empty(old('company')) ? old('company') : (!empty($detail->company) ? $detail->company : ''), ['class' => 'tom-select tom-select-field-company w-full', 'placeholder' => "CHỌN CÔNG TY TÂM PHÁT"]); ?>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-span-2">
                                            <ul class="p-0 m-0 ">
                                                <li class="flex text-[15px] p-[5px] space-x-8">
                                                    <div class="w-1/3">
                                                        <span class="bg-white font-semibold flex-1">Ngày thanh toán</span>
                                                        <?php echo Form::text('date_end', !empty(old('date_end')) ? old('date_end') : (!empty($detail->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date_end)->format('d/m/Y') : $source_date_start), ['class' => 'form-control', 'placeholder' => date('d/m/Y')]); ?>
                                                    </div>
                                                    <div class="w-1/3">
                                                        <span class="bg-white font-semibold flex-1">Ngày bắt đầu</span>
                                                        <?php echo Form::text('source_date_start', !empty(old('source_date_start')) ? old('source_date_start') : (!empty($detail->source_date_start) ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->source_date_start)->format('d/m/Y') : $source_date_start), ['class' => 'form-control', 'placeholder' => date('d/m/Y')]); ?>
                                                    </div>
                                                    <div class="w-1/3">
                                                        <span class="bg-white font-semibold flex-1">Ngày kết thúc</span>
                                                        <?php echo Form::text('source_date_end', !empty(old('source_date_end')) ? old('source_date_end') : (!empty($detail->source_date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->source_date_end)->format('d/m/Y') : $source_date_end), ['class' => 'form-control', 'placeholder' => date('d/m/Y')]); ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 relative">
                                @if($action == 'create')
                                <div class="crm-entity-overlay absolute rounded-[10px] cursor-no-drop"></div>
                                @endif
                                <div class="w-full mx-auto bg-white  rounded-bl-[10px] rounded-br-[10px] h-full">
                                    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fa-solid fa-message"></i> Hoạt động</h3>
                                    <div class="p-[10px]">
                                        @include('components.alert-error')
                                        @csrf
                                        <ul class="p-0 m-0 ">
                                            <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                <textarea class="form-control" id="textNote" placeholder="Việc cần làm" name="" cols="50" rows="10"></textarea>
                                            </li>
                                            <li class="p-[10px] w-full flex">
                                                <a href="javascript:void(0)" class="text-white handleSubmitNote bg-primary font-medium rounded-lg text-sm px-5 py-1.5 text-center">
                                                    <span>Lưu</span>
                                                </a>
                                            </li>

                                            <li id="listHistories">
                                                @include('deal.backend.histories')
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 md:col-span-3">
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
                                                </tr>
                                            </thead>
                                            <tbody id="listProduct">
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
                                                        <input name="product_price[]" class="form-control w-full" value="{{$item->price}}">
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="relative flex">
                                                            <input name="product_quantity[]" class="form-control w-full" value="{{$item->quantity}}">
                                                            <select class="" data-placeholder="" name="product_unit[]">
                                                                <option value="year" @if($item->unit == 'year') selected @endif>Năm</option>
                                                                <option value="month" @if($item->unit == 'month') selected @endif>Tháng</option>
                                                                <option value="vnd" @if($item->unit == 'vnd') selected @endif>VNĐ</option>
                                                                <option value="cai" @if($item->unit == 'cai') selected @endif>Cái</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <input name="product_price_sale[]" class="form-control w-full" value="{{$item->sales}}">
                                                    </td>
                                                    <td class="p-2">
                                                        <select class="form-control" name="product_price_tax[]">
                                                            <option value="-1" @if($item->tax == '-1') selected @endif>Chưa tính thuế</option>
                                                            <option value="0" @if($item->tax == '0') selected @endif>0%</option>
                                                            <option value="10" @if($item->tax == '10') selected @endif>10%</option>
                                                        </select>
                                                        <input type="text" name="taxInputOfItem[]" class="taxInputOfItem hidden" value="{{$item->tax_price}}">
                                                    </td>
                                                    <td class="p-2 taxValueOfItem">
                                                        {{number_format($item->tax_price,'0',',','.')}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd">
                                                    <td class="p-2">
                                                        <a href="javascript:void(0)" class="handleRemoveItemProduct"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="relative ">
                                                            <input name="product_title[]" class="form-control w-full">
                                                        </div>
                                                        <div class="listProducts">
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <input name="product_price[]" class="form-control w-full">
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="relative flex">
                                                            <input name="product_quantity[]" class="form-control w-full" value="1">
                                                            <select class="" data-placeholder="" name="product_unit[]">
                                                                <option value="year">Năm</option>
                                                                <option value="month">Tháng</option>
                                                                <option value="vnd">VNĐ</option>
                                                                <option value="cai">Cái</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <input name="product_price_sale[]" class="form-control w-full">
                                                    </td>
                                                    <td class="p-2">
                                                        <select class="form-control" name="product_price_tax[]">
                                                            <option value="-1">Chưa tính thuế</option>
                                                            <option value="0">0%</option>
                                                            <option value="10">10%</option>
                                                        </select>
                                                        <input type="text" name="taxInputOfItem[]" class="taxInputOfItem hidden">
                                                    </td>
                                                    <td class="p-2 taxValueOfItem">
                                                        0đ
                                                    </td>
                                                </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
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
                    @if($action == 'update')
                    <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                        <div class="flex justify-end">
                            <button class="handleCreateInvoices block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Tạo hóa đơn
                            </button>
                        </div>
                        <div class="relative overflow-x-auto mt-3">
                            <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black">
                                <thead class="text-xs text-white uppercase bg-primary dark:bg-gray-700 dark:text-black">
                                    <tr>
                                        <th scope="col" class="p-2">
                                            ID
                                        </th>
                                        <th scope="col" class="p-2">
                                            Trạng thái
                                        </th>
                                        <th scope="col" class="p-2">
                                            Tiêu đề hóa đơn
                                        </th>

                                        <th scope="col" class="p-2">
                                            Tiền hóa đơn (VNĐ)
                                        </th>
                                        <th scope="col" class="p-2">
                                            Ngày thanh toán
                                        </th>
                                        <th scope="col" class="p-2">
                                            Ngày kết thúc
                                        </th>
                                        <th scope="col" class="p-2">
                                            Chịu trách nghiệm
                                        </th>
                                        <th scope="col" class="p-2">
                                            Hủy
                                        </th>
                                        <th scope="col" class="p-2">
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="htmlDealInvoices">
                                    @include('deal.backend.invoices',['invoices' => $detail->deal_invoices])
                                </tbody>
                            </table>
                        </div>

                    </div>
                    @endif
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
            @if($action == 'update')
            <a href="javascript:void(0)" class="text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                Gửi email
            </a>
            @endif
            <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                {{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}
            </button>
        </div>
    </div>
</form>

@if($action == 'update')
<!-- Main modal -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-[#00000091] z-[9999]">
    @include('deal.backend.formInvoices',['action' => 'create','category_products' => $category_products])
</div>
<script>
    $(document).on('click', '.js_addHotline', function(e) {
        var html = '';
        html += '<div class="flex space-x-3">';
        html += '<input class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" name="ips[]" type="text" value="">';
        html += '<button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">';
        html += '<i class="fa-solid fa-trash"></i>'
        html += '</button>'
        html += '</div>'
        $('#htmlHotline').append(html)
        checkLengthHotline()
    })
    $(document).on('click', '.js_removeHotline', function(e) {
        e.preventDefault()
        $(this).parent().remove()
        checkLengthHotline()
    })

    function checkLengthHotline() {
        var lengthHotline = $('#htmlHotline>div').length;
        console.log(lengthHotline)
        if (!lengthHotline) {
            $('.js_addHotline').removeClass('mt-2')
        } else {
            $('.js_addHotline').addClass('mt-2')
        }
    }
</script>
<script>
    $(document).on('submit', '#formSubmitDealInvoices', function(e) {
        e.preventDefault();
        var catalogue_id = $('select[name="catalogue_idI"]').val();
        var id = $('input[name="idI"]').val();
        var action = $('input[name="actionI"]').val();
        var title = $('input[name="titleI"]').val();
        var price = $('input[name="priceI"]').val();
        var comment = $('textarea[name="commentI"]').val();
        var status = $('select[name="statusI"]').val();
        var status_tax = $('select[name="status_tax"]').val();
        var user_id = $('select[name="user_idI"]').val();
        var date_end = $('input[name="date_endI"]').val();
        var source_date_end = $('input[name="source_date_endI"]').val();
        var note = $('textarea[name="noteI"]').val();
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.createInvoices')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                catalogue_id: catalogue_id,
                id: id,
                action: action,
                title: title,
                price: price,
                comment: comment,
                status: status,
                status_tax: status_tax,
                user_id: user_id,
                date_end: date_end,
                source_date_end: source_date_end,
                note: note,
                deal_id: <?php echo $detail->id; ?>,
            },
            success: function(data) {
                $('#htmlDealInvoices').html(data.invoices);
                $('#authentication-modal').addClass('hidden')
            },
            complete: function(e) {
                if (action == 'create') {
                    toastr.success("Thêm mới hóa đơn thành công!", 'Thông báo')
                } else if (action == 'update') {
                    toastr.success("Cập nhập hóa đơn thành công!", 'Thông báo')
                }
            }
        });
    })
    $(document).on('click', '.handleCreateInvoices', function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.showInvoices')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                id: 0,
            },
            success: function(data) {
                $('#authentication-modal').html(data.html);
                $('#authentication-modal').removeClass('hidden').addClass('flex')
                new TomSelect(".tom-select-field-support-invoices", {
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
                new TomSelect(".tom-select-field-categoryI", {
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
            },

        });
    })
    $(document).on('click', '.handleUpdateInvoices', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id')
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.showInvoices')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $('#authentication-modal').html(data.html);
                $('#authentication-modal').removeClass('hidden').addClass('flex')
                new TomSelect(".tom-select-field-support-invoices", {
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
                new TomSelect(".tom-select-field-categoryI", {
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
            }
        });
    })
    $(document).on('click', 'button[data-modal-hide="authentication-modal"]', function(e) {
        $('#authentication-modal').addClass('hidden').removeClass('flex')

    })
    $(document).on('change', 'input[name="date_endI"]', function(e) {
        var value = $(this).val()
        var inputDateStr = value;
        var inputDateParts = inputDateStr.split("/");
        var day = parseInt(inputDateParts[0], 10);
        var month = parseInt(inputDateParts[1], 10) - 1; // Months are zero-based
        var year = parseInt(inputDateParts[2], 10);

        // Create a JavaScript Date object
        var inputDate = new Date(year, month, day);

        // Add one year to the date
        inputDate.setFullYear(inputDate.getFullYear() + 1);

        // Output the result in the same format
        var outputDay = inputDate.getDate();
        var outputMonth = inputDate.getMonth() + 1; // Months are zero-based
        var outputYear = inputDate.getFullYear();

        // Pad single digits with leading zero if necessary
        outputDay = outputDay < 10 ? "0" + outputDay : outputDay;
        outputMonth = outputMonth < 10 ? "0" + outputMonth : outputMonth;

        // Output the result in the format "dd/mm/yyyy"
        var outputDateStr = outputDay + "/" + outputMonth + "/" + outputYear;
        $('input[name="source_date_endI"]').val(outputDateStr)
    })
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
</script>
@endif
@endsection
@include('deal.backend.script')
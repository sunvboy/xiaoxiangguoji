@extends('dashboard.layout.dashboard')
@section('title')
<title>{{!empty($action == 'create') ? "Thêm mới hợp đồng" : "Cập nhập hợp đồng website"}}</title>
@endsection
@section('breadcrumb')
<?php

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Tag;

$routeIndex = '';
if ($action == 'create') {
    $array = array(
        [
            "title" => "Danh sách các hợp đồng",
            "src" => url()->previous(),
        ],
        [
            "title" => "Thêm mới",
            "src" => 'javascript:void(0)',
        ]
    );
} else {
    $array = array(
        [
            "title" => "Danh sách các hợp đồng",
            "src" => url()->previous(),
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
$tags = CategoryProduct::where('parentid', 1)->get();
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
                                            <?php
                                            $category_products_default = !empty($active == 'website') ? 2 : 1;
                                            $catalogue_id = !empty(old('catalogue_id')) ? old('catalogue_id') : (!empty($detail->catalogue_id) ? $detail->catalogue_id : $category_products_default);
                                            ?>
                                            <ul class="p-0 m-0 ">
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] ">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Danh mục*</span></span>
                                                    <?php echo Form::select('catalogue_id', $category_products, $catalogue_id, ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục", 'required']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] @if($action == 'update') hidden @endif">
                                                    <span class="bg-white font-semibold flex-1">Giai đoạn</span>
                                                    <div class="loadHtmlStatus">
                                                        @if($active == 'website')
                                                        <?php echo Form::select('status', config('tamphat')['status_web'], !empty(old('status')) ? old('status') : (!empty($detail->status) ? $detail->status : ''), ['class' => 'form-control', 'placeholder' => "Chọn giai đoạn"]); ?>
                                                        @else
                                                        <?php echo Form::select('status', config('tamphat')['status'], !empty(old('status')) ? old('status') : (!empty($detail->status) ? $detail->status : ''), ['class' => 'form-control', 'placeholder' => "Chọn giai đoạn"]); ?>
                                                        @endif
                                                    </div>
                                                </li>
                                                <?php /*<!-- Hiển thị website -->
                                                <li class="text-[15px] p-[5px] hidden" id="website">
                                                    <span class="bg-white font-semibold "><span class="text-red-600">Phân loại*</span></span>
                                                    <div class="flex flex-col">
                                                        <?php
                                                        $checkCatalogue = !empty(old('catalogue_child_id')) ? old('catalogue_child_id') : (!empty($detail->catalogue_child_id) ? explode(",", $detail->catalogue_child_id) : []);
                                                        ?>
                                                        @if(!empty($category_products_child))
                                                        @foreach($category_products_child as $key=>$item)
                                                        <label class="flex space-x-1 items-center cursor-pointer">
                                                            <input <?php echo !empty($checkCatalogue) && count($checkCatalogue) > 0 ? (in_array($item, $checkCatalogue) ? 'checked' : '') : '' ?> type="checkbox" name="catalogue_child_id[]" value="{{$item}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                            <span>{{$item}}</span>
                                                        </label>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </li>
                                                <!--END: Hiển thị website -->
                                                <!-- Hiển thị gia hạn + vps -->
                                                <li class="flex text-[15px] p-[5px] space-x-8 hidden" id="extend">
                                                    <div class="w-1/2">
                                                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Phân loại*</span></span>
                                                        <div class="flex flex-col">
                                                            @if(!empty($brands))
                                                            @foreach($brands as $item)
                                                            <label class="flex space-x-1 items-center cursor-pointer">
                                                                <input <?php echo !empty(old('brand_id')) && old('brand_id') == $item->id ? 'checked' : (!empty($detail->brand_id) && $detail->brand_id == $item->id ? 'checked' : '') ?> type="checkbox" name="brand_id" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                                <span>{{$item->title}}</span>
                                                            </label>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="w-1/2">
                                                        <span class="bg-white font-semibold flex-1">Duy trì</span>
                                                        <div class="flex flex-col">
                                                            <?php
                                                            $checkTags = !empty(old('tag_id')) ? old('tag_id') : (!empty($detail->tag_id) ? json_decode($detail->tag_id, TRUE) : []);
                                                            ?>
                                                            @if(!empty($tags))
                                                            @foreach($tags as $item)
                                                            <label class="flex space-x-1 items-center cursor-pointer">
                                                                <input <?php echo !empty($checkTags) && count($checkTags) > 0 ? (in_array($item->title, $checkTags) ? 'checked' : '') : '' ?> type="checkbox" name="tag_id[]" value="{{$item->title}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                                <span>{{$item->title}}</span>
                                                            </label>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <!--END: Hiển thị gia hạn + vps -->*/ ?>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tên hợp đồng*</span></span>
                                                    <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : ''), ['class' => 'form-control', 'placeholder' => 'Tên công ty', 'required']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tên miền web(cả phụ)*</span></span>
                                                    <?php
                                                    $website = !empty(old('website')) ? old('website') : (!empty($detail->website) ? json_decode($detail->website, TRUE) : []);

                                                    $websites = [];
                                                    if (!empty($website)) {
                                                        foreach ($website as $item) {
                                                            $websites[] = array(
                                                                $item => $item
                                                            );
                                                        }
                                                    }

                                                    ?>
                                                    <?php echo Form::select('website[]', $websites, !empty(old('website')) ? old('website') : (!empty($detail->website) ? json_decode($detail->website, TRUE) : ''), ['class' => 'tom-select tom-select-field-website w-full', 'placeholder' => "Chọn tên miền", 'required', 'multiple']); ?>
                                                </li>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] hidden" id="listFree">
                                                    <span class="bg-white font-semibold flex-1">CHỌN DS : FREE HOSTING, TÊN MIỀN, SSL</span>
                                                    <?php echo Form::select('free[]', config('tamphat')['free'], !empty(old('free')) ? old('free') : (!empty($detail->free) ? json_decode($detail->free, TRUE) : ''), ['class' => 'tom-select tom-select-field-free w-full', 'placeholder' => "CHỌN DS : FREE HOSTING, TÊN MIỀN, SSL", 'multiple']); ?>
                                                </li>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Loại giao dịch</span>
                                                    <?php echo Form::select('type', config('tamphat')['type'], !empty(old('type')) ? old('type') : (!empty($detail) ? $detail->type : 1), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); ?>
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
                                                        <div class="mt-2 flex items-center justify-between space-x-4 htmlFile">
                                                            <div>
                                                                <a href="{{asset($detail->file)}}" target="_blank" class="text-blue-600 underline">{{$detail->file}}</a>
                                                            </div>
                                                            <span class="flex-1">
                                                                <a href="javascript:void(0)" class="handleRemoveFile" data-id="{{$detail->id}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                    </svg>
                                                                </a>
                                                            </span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <ul class="p-0 m-0 ">
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] hidden">
                                                    <span class="bg-white font-semibold flex-1">Suspend</span>
                                                    <label class="inline-flex items-center cursor-pointer w-[50px]">
                                                        <input name="suspend" <?php echo !empty(old('suspend')) ? 'checked' : (!empty($detail->suspend) ? 'checked' : ''); ?> type="checkbox" value="1" class="sr-only peer">
                                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                                                    </label>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Nguồn</span>
                                                    <?php echo Form::select('source', config('tamphat')['source'], !empty(old('source')) ? old('source') : (!empty($detail->source) ? $detail->source : ''), ['class' => 'tom-select tom-select-field-source w-full', 'placeholder' => 'Chọn nguồn']); ?>
                                                </li>
                                                <?php
                                                $customer_id = !empty(old('customer_id')) ? old('customer_id') : (!empty($detail->customer_id) ? $detail->customer_id : '');
                                                ?>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
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
                                                            <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] hidden">
                                                                <div class=" flex space-x-1 justify-end">
                                                                    <a href="javascript:void(0)" data-tooltip-target="tooltip-default-update" class="text-white flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"></path>
                                                                        </svg>
                                                                    </a>
                                                                    <div id="tooltip-default-update" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-primary rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                        Cập nhập Khách hàng - Công ty
                                                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                                                    </div>
                                                                    <a href="javascript:void(0)" data-tooltip-target="tooltip-default-create" class="text-white flex items-center bg-green-500 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                                        </svg>
                                                                    </a>
                                                                    <div id="tooltip-default-create" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-green-500 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                        Thêm mới Khách hàng - Công ty
                                                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Thông tin nguồn</span>
                                                    <?php echo Form::textarea('source_description', !empty(old('source_description')) ? old('source_description') : (!empty($detail->source_description) ? $detail->source_description : ''), ['class' => 'form-control', 'placeholder' => '']); ?>
                                                </li>

                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">Ghi chú</span>
                                                    <?php echo Form::textarea('note', !empty(old('note')) ? old('note') : (!empty($detail->note) ? $detail->note : ''), ['class' => 'form-control', 'placeholder' => '']); ?>
                                                </li>
                                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                                    <span class="bg-white font-semibold flex-1">IP</span>
                                                    <?php echo Form::text('ips', !empty(old('ips')) ? old('ips') : (!empty($detail->ips) ? $detail->ips : ''), ['class' => 'form-control', 'placeholder' => '']); ?>
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
                                        @if($action == 'update')
                                        <input hidden name="check_tax_deal_invoices" value="{{$detail->deal_invoices->sum('price_tax')}}">
                                        <input hidden name="check_total_deal_invoices" value="{{$detail->deal_invoices->sum('total')}}">
                                        <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black @if($detail->deal_invoices->sum('price_tax') == $detail->price_4 && $detail->deal_invoices->sum('total') == $detail->price_5) tableComplete @endif">
                                            @else
                                            <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black">
                                                @endif

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
                                                            <input name="product_domain[]" class="form-control w-full" value="">
                                                        </td>
                                                        <td class="p-2">
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
                                                                <option value="{{$val->title}}">{{$val->title}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td class="p-2">
                                                            <input name="product_price[]" class="form-control w-full">
                                                        </td>
                                                        <td class="p-2">
                                                            <div class="relative flex space-x-1">
                                                                <input name="product_quantity[]" class="form-control w-full" value="1">
                                                                <select class="outline-none focus:outline-none hover:outline-none border-0 flex-1" data-placeholder="" name="product_unit[]">
                                                                    <option value="year">Năm</option>
                                                                    <option value="month">Tháng</option>
                                                                    <option value="vnd">VNĐ</option>
                                                                    <option value="cai">Cái</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="p-2 flex space-x-1">
                                                            <input name="product_price_sale[]" class="form-control w-full">
                                                            <select class="outline-none focus:outline-none hover:outline-none border-0 flex-1 hidden" data-placeholder="" name="product_price_sale_type[]">
                                                                <option value="VND">VNĐ</option>
                                                                <option value="percent">%</option>
                                                            </select>
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

                                                    @if($action == 'update')
                                                    <tr>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">Tổng số không có thuế - bitrix cũ: </td>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">{{number_format($detail->deal_invoices->sum('price'),'0',',','.')}} đ</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">Tổng thuế cũ - bitrix cũ: </td>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">{{number_format($detail->deal_invoices->sum('price_tax'),'0',',','.')}} đ</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">Tổng số tiền - bitrix cũ: </td>
                                                        <td class="p-2 text-right font-bold text-red-600" colspan="5">{{number_format($detail->deal_invoices->sum('total'),'0',',','.')}} đ</td>
                                                    </tr>
                                                    @endif
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
                                            Thuế (VNĐ)
                                        </th>
                                        <th scope="col" class="p-2">
                                            Tổng tiền (VNĐ)
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
            <a href="{{route('deals.email',['id' => $detail->id])}}" class="text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
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
<style>
    .tableComplete {
        background: url(<?php echo asset('backend/images/luat-doanh-nghiep-2014-coi-troi-cho-con-dau.jpg') ?>);
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: 145px;
    }
</style>
<!-- Main modal -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-[#00000091] z-[9999]">
    @include('deal.backend.formInvoices',['action' => 'create','category_products' => $category_products])
</div>
<script>
    function loadPirceConvert(price) {
        var numberWithDots = price;

        // Remove dots from the number
        var numberWithoutDots = numberWithDots.replace(/\./g, '');

        // Convert the string to a number
        var convertedNumber = parseInt(numberWithoutDots);
        return convertedNumberhtmlPriceTax
    }
    $(document).on('keyup', 'input[name="priceI"]', function(e) {
        e.preventDefault()
        var price = $(this).val()
        var status_tax = $('select[name="status_tax"]').val();
        var convertedVersion = loadPirceConvert(price);
        var tax = 0;
        if (convertedVersion > 0) {
            if (status_tax) {
                tax = (convertedVersion / 100) * status_tax
            }
        }
        $('input[name="priceTotal"]').val(numberWithCommas(parseInt(tax) + parseInt(convertedVersion)))
        $('.htmlPriceTax').html(numberWithCommas(tax) + ' VND')

    })
    $(document).on('change', 'select[name="status_tax"]', function(e) {
        e.preventDefault()
        var price = $('input[name="priceI"]').val()
        var status_tax = $(this).val();
        var convertedVersion = loadPirceConvert(price);
        var tax = 0;
        if (convertedVersion > 0) {
            if (status_tax) {
                tax = (convertedVersion / 100) * status_tax
            }
        }
        $('input[name="priceTotal"]').val(numberWithCommas(parseInt(tax) + parseInt(convertedVersion)))
        $('.htmlPriceTax').html(numberWithCommas(tax) + ' VND')

    })
    $(document).on('submit', '#formSubmitDealInvoices', function(e) {
        e.preventDefault();
        var catalogue_id = $('select[name="catalogue_idI"]').val();
        var id = $('input[name="idI"]').val();
        var action = $('input[name="actionI"]').val();
        var title = $('input[name="titleI"]').val();
        var price = $('input[name="priceI"]').val();
        var comment = $('textarea[name="commentI"]').val();
        var status = $('select[name="statusI"]').val();
        var user_id = $('select[name="user_idI"]').val();
        var date_end = $('input[name="date_endI"]').val();
        var source_date_end = $('input[name="source_date_endI"]').val();
        var note = $('textarea[name="noteI"]').val();
        var status_tax = $('select[name="status_tax"]').val();
        var invoices_price_1 = $('input[name="invoices_price_1"]').val();
        var invoices_price_2 = $('input[name="invoices_price_2"]').val();
        var invoices_price_3 = $('input[name="invoices_price_3"]').val();
        //hóa đơn
        var invoices_title = []
        var invoices_phan_loai = []
        var invoices_duy_tri = []
        var invoices_price = []
        var invoices_quantity = []
        var invoices_tax = []
        var invoices_tax_price = []
        var invoices_price_total = [];
        var deal_invoice_relationships_id = [];
        $('input[name="deal_invoice_relationships_id[]"]').each(function() {
            deal_invoice_relationships_id.push($(this).val());
        })
        $('input[name="invoices_title[]"]').each(function() {
            invoices_title.push($(this).val());
        })
        $('input[name="invoices_phan_loai[]"]').each(function() {
            invoices_phan_loai.push($(this).val());
        })
        $('input[name="invoices_duy_tri[]"]').each(function() {
            invoices_duy_tri.push($(this).val());
        })
        $('input[name="invoices_price[]"]').each(function() {
            invoices_price.push($(this).val());
        })
        $('input[name="invoices_quantity[]"]').each(function() {
            invoices_quantity.push($(this).val());
        })
        $('select[name="invoices_tax[]"]').each(function() {
            invoices_tax.push($(this).val());
        })
        $('input[name="invoices_tax_price[]"]').each(function() {
            invoices_tax_price.push($(this).val());
        })
        $('input[name="invoices_price_total[]"]').each(function() {
            invoices_price_total.push($(this).val());
        })
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
                //hóa đơn
                deal_invoice_relationships_id: deal_invoice_relationships_id,
                invoices_title: invoices_title,
                invoices_phan_loai: invoices_phan_loai,
                invoices_duy_tri: invoices_duy_tri,
                invoices_price: invoices_price,
                invoices_quantity: invoices_quantity,
                invoices_tax: invoices_tax,
                invoices_tax_price: invoices_tax_price,
                invoices_price_total: invoices_price_total,
                //end
                invoices_price_1: invoices_price_1,
                invoices_price_2: invoices_price_2,
                invoices_price_3: invoices_price_3,
                catalogue_id: catalogue_id,
                id: id,
                action: action,
                title: title,
                price: price,
                comment: comment,
                status: status,
                user_id: user_id,
                date_end: date_end,
                source_date_end: source_date_end,
                note: note,
                status_tax: status_tax,
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
                deal_id: <?php echo $detail->id ?>
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
                deal_id: <?php echo $detail->id ?>
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
    //thay đổi giá hóa đơn
    $(document).on('keyup', 'input[name="invoices_quantity[]"]', function(e) {
        var quantity = parseInt($(this).val());
        var price = parseInt($(this).parent().parent().find('input[name="invoices_price[]"]').val())
        var tax = parseFloat($(this).parent().parent().find('select[name="invoices_tax[]"]').val())
        var price_tax = 0;
        if (tax > 0) {
            price_tax = (price * quantity) / 100 * tax
        }

        $(this).parent().parent().find('input[name="invoices_tax_price[]"]').val(numberWithCommas(price_tax))
        $(this).parent().parent().find('.invoices_price_total').html(numberWithCommas((price * quantity) + price_tax))
        $(this).parent().parent().find('input[name="invoices_price_total[]"]').val((price * quantity) + price_tax)
        loadInvoicesTotalPrice()

    })
    $(document).on('keyup', 'input[name="invoices_price[]"]', function(e) {
        var price = parseInt($(this).val());
        var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
        var tax = parseFloat($(this).parent().parent().find('select[name="invoices_tax[]"]').val())
        var price_tax = 0;
        if (tax > 0) {
            price_tax = (price * quantity) / 100 * tax
        }

        $(this).parent().parent().find('input[name="invoices_tax_price[]"]').val(numberWithCommas(price_tax))
        $(this).parent().parent().find('.invoices_price_total').html(numberWithCommas((price * quantity) + price_tax))
        $(this).parent().parent().find('input[name="invoices_price_total[]"]').val((price * quantity) + price_tax)
        loadInvoicesTotalPrice()

    })
    $(document).on('change', 'select[name="invoices_tax[]"]', function(e) {
        var price = parseInt($(this).parent().parent().find('input[name="invoices_price[]"]').val())
        var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
        var tax = parseFloat($(this).val())
        var price_tax = 0;
        if (tax > 0) {
            price_tax = (price * quantity) / 100 * tax
        }
        $(this).parent().find('input[name="invoices_tax_price[]"]').val(numberWithCommas(price_tax))
        $(this).parent().parent().find('.invoices_price_total').html(numberWithCommas((price * quantity) + price_tax))
        $(this).parent().parent().find('input[name="invoices_price_total[]"]').val((price * quantity) + price_tax)
        loadInvoicesTotalPrice()
    })
    $(document).on('click', '.handleRemoveItemProductInvoices', function(e) {
        $(this).parent().parent().remove()
        loadInvoicesTotalPrice()
    })

    function loadInvoicesTotalPrice() {
        var priceTotal1 = priceTotal2 = priceTotal3 = 0;
        $('input[name="invoices_price[]').each(function() {
            var price = parseInt($(this).val());
            var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
            var tax = parseFloat($(this).parent().parent().find('select[name="invoices_tax[]"]').val())
            var price_tax = 0;
            if (tax > 0) {
                price_tax = (price * quantity) / 100 * tax
            }
            priceTotal1 += (price * quantity);
            priceTotal2 += price_tax;
            priceTotal3 += (price * quantity) + price_tax;
        })
        $('.invoices_price_1').html(numberWithCommas(priceTotal1) + ' đ')
        $('.invoices_price_2').html(numberWithCommas(priceTotal2) + ' đ')
        $('.invoices_price_3').html(numberWithCommas(priceTotal3) + ' đ')
        $('input[name="invoices_price_1"]').val(priceTotal1)
        $('input[name="invoices_price_2"]').val(priceTotal2)
        $('input[name="invoices_price_3"]').val(priceTotal3)

    }
</script>
@endif
<script>
    var catalogue_id = $('select[name="catalogue_id"]').val()
    var textCheck = $('select[name="catalogue_id"]').children("option:selected").text();
    if (catalogue_id == 1 || catalogue_id == 21199) {
        $('#website').addClass('hidden')
        $('#extend').removeClass('hidden')
    } else {
        $('#website').removeClass('hidden')
        $('#extend').addClass('hidden')
        $('#listFree').removeClass('hidden')
    }
    if (catalogue_id == 1) {
        $('.tdDeal').removeClass('hidden')
    } else {
        $('.tdDeal').addClass('hidden')
    }
    /*Check hiển thị deal*/
    <?php /*
    var html = '';
    <?php
    $phan_loai_1 = dropdown($brands, 'Phân loại', 'title', 'title');
    $phan_loai_2 = $category_products_child;
    $phan_loai = $category_products;
    ?>
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
    $('select[name="product_phanloai[]"]').html(html);*/ ?>

    $(document).on('change', 'select[name="catalogue_id"]', function(e) {
        var id = $(this).val();
        var textCheck = $(this).children("option:selected").text();
        var status = '<?php echo Form::select('status', config('tamphat')['status'], '', ['class' => 'form-control', 'placeholder' => "Chọn giai đoạn"]); ?>';
        var status_web = '<?php echo Form::select('status', config('tamphat')['status_web'], '', ['class' => 'form-control', 'placeholder' => "Chọn giai đoạn"]); ?>';

        var boxChangeStatus = '<ul class="flex space-x-2">';
        <?php foreach (config('tamphat')['status'] as $key => $item) { ?>
            boxChangeStatus += '<li data-status="<?php echo $key ?>" class="changeStatus flex-auto flex justify-center items-center font-medium cursor-pointer gd gd0"><?php echo $item ?></li>'
        <?php } ?>
        boxChangeStatus += '</ul>';
        var boxChangeStatusWeb = '<ul class="flex space-x-2">';
        <?php foreach (config('tamphat')['status_web'] as $key => $item) { ?>
            boxChangeStatusWeb += '<li data-status="<?php echo $key ?>" class="changeStatus flex-auto flex justify-center items-center font-medium cursor-pointer gd gd0"><?php echo $item ?></li>'
        <?php } ?>
        boxChangeStatusWeb += '</ul>';

        if (id == 1 || id == 21199) {
            $('#website').addClass('hidden')
            $('#extend').removeClass('hidden')
            $('.loadHtmlStatus').html(status);
            $('#listStatus').html(boxChangeStatus);
            $('#listFree').addClass('hidden')
        } else {
            $('#website').removeClass('hidden')
            $('#extend').addClass('hidden')
            $('.loadHtmlStatus').html(status_web);
            $('#listStatus').html(boxChangeStatusWeb);
            $('#listFree').removeClass('hidden')
        }
        //check
        if (id == 1) {
            $('.tdDeal').removeClass('hidden')
        } else {
            $('.tdDeal').addClass('hidden')
        }
        var html = '';
        <?php
        $phan_loai_1 = dropdown($brands, 'Phân loại', 'title', 'title');
        $phan_loai_2 = $category_products_child;
        $phan_loai = $category_products;
        ?>
        if (id == 1) {
            <?php foreach ($phan_loai_1 as $item) { ?>
                html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
            <?php } ?>
        } else if (id == 2) {
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
        $('select[name="product_phanloai[]"]').html(html);

    })
    $(document).on('change', 'select[name="customer_id"]', function(e) {
        var id = $(this).val();
        $('#dealSearchCompany').attr('href', `<?php echo route('deals.search') ?>?id=${id}`)
    })
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
</script>
@endsection
@include('deal.backend.script')
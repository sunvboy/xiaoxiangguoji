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
<?php
$permissionChecked = collect($deal_views)->where('active', 1);
$permissionCheckedIndex = $permissionChecked->pluck('keyword');
?>
<div class="p-4 space-y-5 ">
    <div>
        <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin hồ sơ</h3>
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
        </div>
    </div>
    <div id="data_product">

        @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndex,'data'=>$data])
    </div>
</div>
@endsection
@push('javascript')
@endpush

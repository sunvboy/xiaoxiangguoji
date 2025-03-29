@extends('dashboard.layout.dashboard')
@section('title')
<title>Hợp đồng sắp hết hạn</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các hợp đồng sắp hết hạn",
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
<div class="px-4 py-2 space-y-2">
    @include('deal.component.search')
    <div class="">
        @include('deal.index.views')

        <div class="flex justify-between items-center mt-2">
            <div class="flex flex-1 items-center space-x-2 justify-end">
                @include('deal.component.remove')
            </div>
        </div>
    </div>
    <div id="data_product">
        @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndex,'data'=>$data,'type' => 'expired'])
    </div>
    <div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
        <div class="lds-dual-ring "></div>
    </div>

</div>
@endsection
@include('deal.script.index',['type' => 'using'])
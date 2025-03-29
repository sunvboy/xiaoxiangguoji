@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách các hợp đồng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các hợp đồng",
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
$searchs = [];
if (!empty(request()->get('catalogue_id'))) {
    $searchs[] = $category_products[request()->get('catalogue_id')];
}
if (!empty(request()->get('status'))) {
    $searchs[] = config('tamphat')['status'][request()->get('status')];
}
if (!empty(request()->get('type') != '')) {
    $searchs[] = config('tamphat')['type'][request()->get('type')];
}
if (!empty(request()->get('date_end'))) {
    $searchs[] = request()->get('date_end');
}
if (!empty(request()->get('source_date_start'))) {
    $searchs[] = request()->get('source_date_start');
}
if (!empty(request()->get('source_date_end'))) {
    $searchs[] = request()->get('source_date_end');
}
if (!empty(request()->get('keyword'))) {
    $searchs[] = request()->get('keyword');
}
if (count($_GET) > 1 && !empty($searchs)) {
    $countSearchs = count($searchs);
    $searchs = array_slice($searchs, 0, 3);
    $searchs[] =  !empty($countSearchs - count($searchs) > 0) ? "và thêm " . $countSearchs - count($searchs) : '';
}
?>
<div class="px-4 py-2 space-y-2">
    <?php /* {!!QrCode::size(300)->generate('https://happytim.com.vn/')!!}
    {!!QrCode::size(300)->generate('https://happytim.com.vn/basic')!!}*/ ?>
    @include('deal.component.search')
    <div>
        @include('deal.index.views')
        <div class="flex justify-between items-center mt-2">
            <div class="flex flex-1 items-center space-x-2 justify-end">
                @include('deal.component.remove')
                @can('deals_create')
                <a href="{{route('deals.create')}}" class="text-white space-x-1 flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tạo</span>
                </a>
                @endcan
            </div>
        </div>
    </div>
    <div id="data_product">
        @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndex,'data'=>$data,'type' => 'index'])
    </div>
    <div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
        <div class="lds-dual-ring "></div>
    </div>
</div>
@endsection
@include('deal.script.index',['type' => 'index'])
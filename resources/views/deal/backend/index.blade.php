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
        <div class="grid grid-cols-5 gap-1 mt-2" id="boxDealView" style="display: none;">
            @foreach($deal_views as $val)
            <label for="check{{$val->id}}">
                <input {{!empty($permissionChecked)?($permissionChecked->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealView w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                {{$val->title}}
            </label>
            @endforeach
        </div>
        <div class="flex justify-between items-center mt-2">
            <div class="flex flex-1 items-center space-x-2 justify-end">
                <button disabled type="button" class="ajax-delete-all text-white  bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
                <a href="javascript:void(0)" class="buttonDealViewShow text-white space-x-1 flex items-center bg-blue-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <span>Hiển thị</span>
                </a>
                <a href="javascript:void(0)" style="display: none;" class="buttonDealViewHide text-white space-x-1 flex items-center bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <span>Đóng</span>
                </a>
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
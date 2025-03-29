@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách các hóa đơn</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các hóa đơn",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="px-4 py-2 space-y-2">
    @include('deal.invoices.search')
    <div>

        <div class="flex justify-between items-center mt-2">
            <div class="flex flex-1 items-center space-x-2 justify-end">
                <div class="flex space-x-1 html_boxExcel hidden">
                    <?php echo Form::select('user_id', $users, '', ['class' => 'form-control', 'placeholder' => "Chịu trách nghiệm"]); ?>
                    <?php echo Form::select('status_excel', ['0' => 'Chưa thanh toán', '1' => 'Đã thanh toán'], '', ['class' => 'form-control', 'placeholder' => "Chọn trạng thái"]); ?>
                    <input type="text" name="date_start_excel" class="form-control h-10" placeholder="Ngày bắt đầu thanh toán" value="">
                    <input type="text" name="date_end_excel" class="form-control h-10" placeholder="Ngày kết thúc thanh toán" value="">
                    <a href="javascript:void(0)" class="js_handleDownExcel flex space-x-1 text-white items-center  bg-green-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                        </svg>
                    </a>
                </div>
                <a href="javascript:void(0)" class="js_handleDownExcel flex hidden space-x-1 text-white items-center  bg-green-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                    </svg>
                    <span>Excel</span>
                </a>
                <a href="javascript:void(0)" class="js_hideExcel flex hidden space-x-1 text-white items-center  bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Đóng</span>
                </a>
                <button data-module="{{$module}}" disabled type="button" class="ajax-delete-all text-white  bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
                @can('deals_create')
                <a href="{{route('deals.invoices.create')}}" class="text-white space-x-1 flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tạo</span>
                </a>
                @endcan
            </div>
        </div>
    </div>
    <div id="data_product">
        @include('deal.invoices.data')
    </div>
    <div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
        <div class="lds-dual-ring "></div>
    </div>
</div>
@endsection
@include('deal.invoices.script',['type' => 'index'])
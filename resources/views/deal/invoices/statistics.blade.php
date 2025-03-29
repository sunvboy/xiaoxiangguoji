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

    <div>
        <div class="flex justify-between items-center mt-2">
            <div class="flex flex-1 items-center space-x-2 justify-end">
                <form method="GET" class="flex space-x-1 html_boxExcel" autocomplete="off">
                    <input type="text" name="keyword" class="form-control h-10" placeholder="Từ khóa tìm kiếm" value="{{request()->get('keywordpDe')}}">
                    <?php echo Form::select('user_id', $users, request()->get('user_id'), ['class' => 'form-control', 'placeholder' => "Chịu trách nghiệm"]); ?>
                    <?php echo Form::select('status', ['0' => 'Chưa thanh toán', '1' => 'Đã thanh toán'], request()->get('status'), ['class' => 'form-control', 'placeholder' => "Chọn trạng thái"]); ?>
                    <input type="text" name="date_start" class="form-control h-10" placeholder="Ngày bắt đầu thanh toán" value="{{request()->get('date_start')}}">
                    <input type="text" name="date_end" class="form-control h-10" placeholder="Ngày kết thúc thanh toán" value="{{request()->get('date_end')}}">
                    <button type="submit" class="text-white h-10 bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-3 py-2 text-center flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                        </svg>
                    </button>
                    <a href="javascript:void(0)" class="js_handleDownExcel h-10 flex space-x-1 text-white items-center  bg-green-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                        </svg>
                        <span>Excel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
    <div id="data_product">
        <div class="relative overflow-x-auto mt-3">
            <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black w3-table-all">
                <thead class="text-xs text-white uppercase bg-primary dark:bg-gray-700 dark:text-black ">
                    <tr>
                        <th scope="col" class="p-2 rounded-tl-md">

                        </th>

                        <th scope="col" class="p-2">

                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">

                        </th>
                        <th scope="col" class="p-2">

                        </th>
                        <th scope="col" class="p-2">

                        </th>
                        <th scope="col" class="p-2">

                        </th>
                        <th scope="col" class="p-2">
                            Tiền hóa đơn (VNĐ)
                        </th>
                        <th scope="col" class="p-2">
                            {{!empty($sumPrice) && count($sumPrice) > 0 ? number_format($sumPrice->sum('price'),'0',',','.'):''}}
                        </th>
                        <th scope="col" class="p-2">
                            {{!empty($sumPrice) && count($sumPrice) > 0 ? number_format($sumPrice->sum('price_tax'),'0',',','.'):''}}

                        </th>
                        <th scope="col" class="p-2">
                            {{!empty($sumPrice) && count($sumPrice) > 0 ? number_format($sumPrice->sum('total'),'0',',','.'):''}}

                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">
                        </th>
                        <th scope="col" class="p-2">
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="p-2">
                            ID
                        </th>

                        <th scope="col" class="p-2">
                            Trạng thái
                        </th>
                        <th scope="col" class="p-2">
                            Danh mục
                        </th>
                        <th scope="col" class="p-2">
                            Hợp đồng
                        </th>
                        <th scope="col" class="p-2">
                            Tiêu đề hóa đơn
                        </th>
                        <th scope="col" class="p-2">
                            Website
                        </th>
                        <th scope="col" class="p-2">
                            Phân loại
                        </th>
                        <th scope="col" class="p-2">
                            Duy trì
                        </th>
                        <th scope="col" class="p-2">
                            Thông tin nguồn
                        </th>
                        <th scope="col" class="p-2">
                            Sản phẩm
                        </th>
                        <th scope="col" class="p-2">
                            Tiền hóa đơn (VNĐ)
                        </th>
                        <th scope="col" class="p-2">
                            Thuế (VNĐ)
                        </th>
                        <th scope="col" class="p-2">
                            Tổng tiền thanh toán (VNĐ)
                        </th>
                        <th scope="col" class="p-2">
                            Ngày thanh toán
                        </th>
                        <th scope="col" class="p-2">
                            Công ty
                        </th>
                        <th scope="col" class="p-2">
                            Ngày tạo
                        </th>
                        <th scope="col" class="p-2">
                            Chịu trách nghiệm
                        </th>

                    </tr>
                </thead>
                <tbody id="htmlDealInvoices">
                    @if($data)
                    @foreach($data as $key=>$item)
                    <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->id}}
                        </th>
                        <td class="p-2">
                            <label class="inline-flex items-center cursor-pointer w-[50px]">
                                <input <?php echo ($item->status == 1) ? 'checked=""' : ''; ?> type="checkbox" value="" class="sr-only peer" disabled>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                            </label>
                        </td>
                        <td class="p-2">
                            {{!empty($item->category_products)?$item->category_products->title:''}}
                        </td>
                        <td class="p-2">
                            <a href="{{route('deals.edit',['id' => $item->deal_id])}}" class="font-medium underline" target="_blank">{{!empty($item->deal)?$item->deal->title:''}}</a>
                        </td>
                        <td class="p-2">
                            {{$item->title}}
                        </td>
                        <td class="p-2">
                            {{!empty($item->deal->website)?collect(json_decode($item->deal->website,TRUE))->join(', '):''}}
                        </td>
                        <?php
                        $duytri = '';
                        $duytri = !empty($item->deal) ? json_decode($item->deal->tag_id, TRUE) : [];
                        ?>
                        <td class="p-2">
                            <div style="width: 100px;">{{!empty($item->deal) ? $item->deal->brand_id : ''}}</div>
                        </td>
                        <td class="p-2">
                            {{collect($duytri)->join(', ')}}
                        </td>
                        <td class="p-2">
                            <div style="width: 200px;overflow: hidden; -webkit-line-clamp: 2;display: -webkit-box;-webkit-box-orient: vertical;overflow: hidden;position: relative;">{{ $item->comment}}</div>
                        </td>
                        <td class="p-2">
                            <div style="width: 200px;overflow: hidden; -webkit-line-clamp: 2;display: -webkit-box;-webkit-box-orient: vertical;overflow: hidden;position: relative;">{!!!empty($item->deal->deal_relationships) ? $item->deal->deal_relationships->pluck('title')->join('<br>') : ""!!}</div>
                        </td>

                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($item->price,'0',',','.')}}
                        </td>
                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($item->price_tax,'0',',','.')}}
                        </td>
                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($item->total,'0',',','.')}}
                        </td>
                        <td class="p-2">
                            <?php echo !empty($item->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->date_end)->format('d/m/Y') : ''; ?>
                        </td>
                        <td class="p-2">
                            <?php echo !empty($item->deal) ? (!empty($item->deal->customer) ? $item->deal->customer->name : '') : ''; ?>
                        </td>
                        <td class="p-2">
                            <?php echo !empty($item->created_at) ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y') : ''; ?>
                        </td>
                        <td class="p-2">
                            {{!empty($item->user)?$item->user->name:""}}
                        </td>
                    </tr>
                    @if(!empty($item->deal_invoice_relationships))
                    @foreach($item->deal_invoice_relationships as $val)
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                        <th class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        </th>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                            <div style="width: 100px;">{{$val->phan_loai}}</div>
                        </td>
                        <td class="p-2">
                            {{$val->duy_tri}}
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                            {{$val->title}}
                        </td>
                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($val->price*$val->quantity,'0',',','.')}}
                        </td>
                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($val->tax_price,'0',',','.')}}
                        </td>
                        <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{number_format($val->total,'0',',','.')}}
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                        <td class="p-2">
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-5 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            {{$data->links()}}
        </div>
    </div>
    <?php
    $usersEmpty = $sumPrice->groupBy('user_id')
    ?>
    @if(!empty($usersEmpty))
    <div class="grid grid-cols-5 gap-5 mt-10 text-sm">
        @foreach($usersEmpty as $key=>$item)
        <?php
        //lấy tên user
        $user = \App\Models\User::where('id', $key)->first();
        //lấy danh sách deal_invoice có trong sumPrice
        $deal_invoice_id = collect($sumPrice)->where('user_id', $key)->pluck('id');
        $deal_invoice_relationships = \App\Models\DealInvoiceRelationships::whereIn('deal_invoice_id', $deal_invoice_id)->get();
        $groupBy = !empty($deal_invoice_relationships) ? $deal_invoice_relationships->groupBy('duy_tri') : [];
        $total = 0;
        $tax = 0;
        $price = 0;
        ?>
        @if(!empty($groupBy))
        <div>
            <h2 class="font-bold bg-primary text-center py-2 text-white">{{!empty($user) ? $user->name: 'Chưa xác định'}}</h2>
            <div class="space-y-2">
                @foreach($groupBy as $key=>$val)
                <div class="flex items-center justify-between">
                    <div>{{!empty($key)?$key:"Khác"}}</div>
                    <div>{{number_format(collect($val)->sum('total'))}}</div>
                    <?php $total += collect($val)->sum('total'); ?>
                    <?php $tax += collect($val)->sum('tax_price'); ?>
                    <?php $price += collect($val)->sum('price'); ?>
                </div>
                @endforeach
                <div class="flex items-center justify-between text-red-600 font-bold">
                    <div>Tổng tiền</div>
                    <div>{{number_format($total-$tax)}}</div>
                </div>
                <div class="flex items-center justify-between text-red-600 font-bold">
                    <div>Thuế</div>
                    <div>{{number_format($tax)}}</div>
                </div>
                <div class="flex items-center justify-between text-red-600 font-bold">
                    <div>Thành tiền</div>
                    <div>{{number_format($total)}}</div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif
    <div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
        <div class="lds-dual-ring "></div>
    </div>
</div>
@endsection
@push('javascript')

<script>
    $(function() {
        $('input[name="date_start"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
    });
    $(document).on('click', '.js_handleDownExcel', function(e) {
        e.preventDefault()
        var date_start = $('input[name="date_start"]').val()
        var date_end = $('input[name="date_end"]').val()
        var user_id = $('select[name="user_id"]').val()
        var status_excel = $('select[name="status"]').val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "<?php echo route('deals.invoices.ajax.export') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                date_start: date_start,
                date_end: date_end,
                user_id: user_id,
                status: status_excel,
            },
            success: function(data) {

                window.open(data.file);
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = "";
                $.each(errors["errors"], function(index, value) {
                    errorsHtml += value + "/ ";
                });
                console.log(errorsHtml)
            },
        });
    })
</script>
@endpush
@extends('dashboard.layout.dashboard')
@section('title')
<title>Đặt hàng thành công</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách khách hàng",
        "src" => route('customers.index'),
    ],
    [
        "title" => "Danh sách đơn hàng",
        "src" => route('customers.orders', ['id' => $detailCustomer->id]),
    ],
    [
        "title" => "Đặt hàng thành công",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <div class="flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Thêm mới đơn hàng thành công
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0 hidden">
            <button class="btn btn-primary shadow-md mr-2"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="printer" class="lucide lucide-printer w-4 h-4 mr-2" data-lucide="printer">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg> Print </button>
        </div>
    </div>
    <div class="box mt-5">
        <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
            <div class="font-semibold text-primary text-3xl">Đơn hàng</div>
            <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-xl text-primary font-bold text-danger">#{{$detail->code}}</div>
                <div class="mt-1">Ngày đặt: {{$detail->created_at}}</div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row px-5 sm:px-20 pt-10 pb-10 sm:pb-20">
            <div>
                <div class="text-base text-slate-500">Thông tin khách hàng</div>
                <div class="text-lg font-medium text-primary mt-2">{{$detail->fullname}}</div>
                <div class="mt-1">{{$detail->email}}</div>
                <div class="mt-1">{{$detail->phone}}</div>
            </div>
            <div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
                <div class="text-base text-slate-500">Địa chỉ giao hàng</div>
                <div class="text-lg font-medium text-primary mt-2">{{$detail->address}}</div>
                <div class="mt-1"><b>Phường/Xã:</b> {{$detail->ward_name->name}}</div>
                <div class="mt-1"><b>Quận/Huyện:</b> {{$detail->district_name->name}}</div>
                <div class="mt-1"><b>Tỉnh/Thành phố:</b> {{$detail->city_name->name}}</div>
            </div>
        </div>
        <?php $cart = json_decode($detail->cart, TRUE); ?>

        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">Sản phẩm</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Số lượng</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Giá</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0 ?>
                        @if($cart)
                        @foreach( $cart as $k=>$v)
                        <?php
                        $total += $v['price'] * $v['quantity'];
                        $slug = !empty($v['slug']) ? $v['slug'] : '';
                        $unit = !empty($v['unit']) ? $v['unit'] : '';
                        $options = !empty($v['options']['title_version']) ? $v['options']['title_version'] : '';
                        ?>
                        <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap">{{$v['title']}}</div>
                                @if(!empty($options))
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap"> {{$options}}</div>
                                @endif
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">{{$v['quantity']}} {{$unit}}</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">{{number_format($v['price'],0,',','.')}}</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">{{number_format($v['price']*$v['quantity'],0,',','.')}}₫</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="3" class="!pt-6 border-transparent dark:!border-transparent text-right font-medium w-32">Tạm tính</td>
                            <td class="!pt-6 border-transparent dark:!border-transparent text-right font-medium w-32">{{number_format($detail->total_price,0,',','.')}}₫</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border-transparent dark:!border-transparent text-right font-medium w-32">Đơn vị vận chuyện</td>
                            <td class="border-transparent dark:!border-transparent text-right font-medium w-32">{{$detail['title_ship']}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border-transparent dark:!border-transparent text-right font-medium w-32">Phí vận chuyển</td>
                            <td class="border-transparent dark:!border-transparent text-right font-medium w-32">{{number_format($detail['fee_ship'],0,',','.')}}₫</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border-transparent dark:!border-transparent font-medium text-right w-32">Tổng tiền thanh toán</td>
                            <td class="border-transparent dark:!border-transparent text-right w-32 font-medium text-danger text-xl font-bold">{{number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship,0,',','.')}}₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
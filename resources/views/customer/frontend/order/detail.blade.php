@extends('homepage.layout.home')
@section('content')

<?php
$cart = json_decode($detail->cart, TRUE);
$coupon = json_decode($detail->coupon, TRUE);
if (config('app.locale') == 'en') {
    $_status = config('cart.status_en');
    $_payment = config('cart.payment_en');
} else if (config('app.locale') == 'tl') {
    $_status = config('cart.status_tl');
    $_payment = config('cart.payment_tl');
} else if (config('app.locale') == 'gm') {
    $_status = config('cart.status_gm');
    $_payment = config('cart.payment_gm');
} else {
    $_status = config('cart.status');
    $_payment = config('cart.payment');
}
?>
<nav class="relative w-full flex flex-wrap items-center justify-between py-2 bg-[#f9f9f9] text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
    <div class="container px-4 mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600 text-f13">{{trans('index.home')}}</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="{{route('customer.orders')}}" class="text-gray-500 hover:text-gray-600 text-f13">{{trans('index.PurchaseHistory')}}</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="javascript:void(0)" class="text-gray-500 hover:text-gray-600 text-f13">{{trans('index.OrderDetails')}} #{{$detail->code}}</a></li>
            </ol>
        </nav>
    </div>
</nav>
<main class="">
    <div class="container px-4 mx-auto">
        <div class="mt-4 flex flex-col md:flex-row items-start md:space-x-4">
            @include('customer/frontend/auth/common/sidebar')
            <div class="flex-1 w-full md:w-auto order-1 md:order-1">
                <div class="overflow-x-hidden shadowC rounded-xl p-6 space-y-4">
                    <div class="flex bg-white md:items-center flex-col md:flex-row justify-between space-y-2 md:space-y-0">
                        <div>
                            <h1 class="text-black font-bold text-xl">{{trans('index.OrderDetails')}}</h1>
                            <div class="text-sm">{{trans('index.BookingDate')}}: {{$detail->created_at}}</div>
                        </div>
                        <!-- Slider main container -->
                        <div>
                            <div class="flex items-center space-x-1 flex-wrap">
                                {{trans('index.ProductCode')}}: <b>#{{$detail->code}}</b> |
                                <span class="text-white font-bold rounded-xl p-1 text-xs <?php echo config('cart.class')[$detail->status] ?>">{{$_status[$detail->status]}}</span>
                                <?php /*?>
                                @if(!empty($detail->order_returns->status) == 1)
                                <span class="text-white font-bold rounded-xl p-1 text-xs bg-green-500">
                                    #{{trans('index.SuccessApproved')}}
                                </span>
                                @else
                                <span class="text-white font-bold rounded-xl p-1 text-xs bg-red-500">
                                    #{{trans('index.PendingApproved')}}
                                </span>
                                @endif
                                <?php */ ?>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <b class="text-sm uppercase">{{trans('index.ShipmentDetails')}}</b>
                                <div class="text-sm mt-2">
                                    <p>{{$detail->fullname}}</p>
                                    <p>{{$detail->address}} - {{$detail->ward_name->name}} - {{$detail->district_name->name}} - {{$detail->city_name->name}}</p>
                                    <p>{{trans('index.Phone')}} : {{$detail->phone}}</p>
                                </div>
                            </div>
                            <div>
                                <b class="text-sm uppercase">{{trans('index.DeliveryMethod')}}</b>
                                <div class="text-sm mt-2">
                                    {{$detail['title_ship']}}
                                </div>
                            </div>
                            <div>
                                <b class="text-sm uppercase">{{trans('index.PaymentMethods')}}</b>
                                <div class="text-sm mt-2">
                                    {{$_payment[$detail->payment]}}
                                </div>
                            </div>
                            @if($detail->note)
                            <div class="md:col-span-3">
                                <b class="text-sm uppercase">{{trans('index.Note')}}</b>
                                <div class="text-sm mt-2">
                                    {{$detail->note}}
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                    <div class="mt-5">
                        <h1 class="text-black font-bold text-xl">{{trans('index.Products')}}</h1>
                        <div class="overflow-x-auto relative mt-2">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 uppercase">
                                            {{trans('index.TitleProduct')}}
                                        </th>
                                        <th scope="col" class="py-3 px-6 uppercase">
                                            {{trans('index.Price')}}
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-center uppercase">
                                            {{trans('index.Amount')}}
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-center uppercase">
                                            {{trans('index.Provisional')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    @if($cart)
                                    @foreach( $cart as $k=>$v)
                                    <?php
                                    $total += $v['price'] * $v['quantity'];
                                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                                    $options = !empty($v['options']['title_version']) ? $v['options']['title_version'] : '';
                                    $unit = !empty($v['unit']) ? $v['unit'] : '';
                                    ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="py-4 px-2 text-gray-900 whitespace-nowrap dark:text-white ">
                                            {{$v['title']}}<br>
                                            @if($options)
                                            {{trans('index.Classify')}}: {{$options}}
                                            @endif
                                        </th>
                                        <td class="py-4 px-2">
                                            {{number_format($v['price'],0,',','.')}}₫
                                        </td>
                                        <td class="py-4 px-2 text-center">
                                            {{$v['quantity']}} {{$unit}}
                                        </td>
                                        <td class="py-4 px-2 text-center">
                                            {{number_format($v['price']*$v['quantity'],0,',','.')}}₫
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            {{trans('index.Provisional')}}
                                        </th>
                                        <td class="p-2 text-right">
                                            <span class="price">{{number_format($detail->total_price,0,',','.')}}₫</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            {{trans('index.TransportFee')}}
                                        </th>
                                        <td class="p-2 text-right">
                                            <span class="price">{{number_format($detail['fee_ship'],0,',','.')}}₫</span>
                                        </td>
                                    </tr>
                                    @if(isset($coupon))
                                    @foreach($coupon as $v)
                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            {{trans('index.DiscountCode')}}<span class="font-semibold text-danger">({{$v['name']}})</span>
                                        </th>
                                        <td class="p-2 text-right">
                                            <span class="price">-{{number_format($v['price'],0,',','.')}}₫</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if($detail->payment =='wallet')
                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            {{trans('index.TotalAmount')}}
                                        </th>
                                        <td class="p-2 text-right">
                                            <span class="price">{{number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship ,0,',','.')}}₫</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            {{trans('index.Paid')}}
                                        </th>
                                        <td class="p-2 text-right">
                                            <span class="price">{{number_format($detail->wallet,0,',','.')}}₫</span>
                                        </td>
                                    </tr>
                                    @endif

                                    <tr class="">
                                        <th colspan="3" class="p-2 text-right text-base">
                                            <strong>{{trans('index.TotalMoneyPayment')}}</strong>
                                        </th>
                                        <td class="p-2 text-right">
                                            <strong><span class="text-red-500 font-bold text-2xl">{{number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship-$detail->wallet ,0,',','.')}}₫</span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="mt-3 flex space-x-2 justify-between md:justify-end">
                        <a href="{{route('customer.copyOrder',['id' => $detail->id])}}" class="float-right font-bold h-9 leading-9  text-white bg-global cursor-pointer items-center rounded-md px-10 text-[16px]">{{trans('index.Repurchase')}}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.menu_order').filter(function() {
        return $(this).prop('href') === aurl;
    }).addClass('active');
    $(".menu_item_auth:eq(2)").addClass('active');
</script>
@endsection
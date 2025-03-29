@extends('dashboard.layout.dashboard')
@section('title')
<title>Tạo hoàn trả cho đơn nhập {{$detail->code}}</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đơn nhập hàng",
        "src" => route('product_purchases.index'),
    ],
    [
        "title" => "Đơn nhập hàng " . $detail->code,
        "src" => route("product_purchases.show", ['id' => $detail->id]),
    ],
    [
        "title" => "Tạo hoàn trả cho đơn nhập " . $detail->code,
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content space-y-5">
    <div class="flex justify-between">
        <div>
            <h1 class="text-3xl font-bold mt-10">
                Tạo hoàn trả cho đơn nhập {{$detail->code}}
            </h1>
        </div>

    </div>
    <form method="POST" action="{{route('product_purchases.return_store',['id' => $detail->id])}}" class="grid grid-cols-12 gap-6">
        @include('components.alert-error')
        @csrf
        <div class="col-span-12 lg:col-span-8 space-y-3">

            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin sản phẩm
                    </h2>
                    <div>
                        <label>
                            <input type="checkbox" name="checkSelectAllReturn">
                            Trả toàn bộ sản phẩm
                        </label>
                    </div>
                </div>
                <div class="p-5">
                    <div class="overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Mã sản phẩm</th>
                                    <th class="whitespace-nowrap">Tên sản phẩm</th>
                                    <th class="text-center whitespace-nowrap">Số lượng </th>
                                    <th class="text-center whitespace-nowrap">Giá hàng trả</th>
                                    <th class="text-center whitespace-nowrap">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalQuantity = 0;
                                ?>
                                @if(!empty($products['cart']))
                                @foreach($products['cart'] as $key=>$item)
                                <?php
                                $title_version = !empty($item['options']['title_version']) ? collect(json_decode($item['options']['title_version'], TRUE))->join('', ',') : '';
                                $quantity = !empty($quantityReturns[$key]) ? $item['quantity'] - $quantityReturns[$key] : $item['quantity'];
                                $totalQuantity += $quantity;
                                ?>
                                <tr class="">
                                    <td class="" style="text-align:left">{{$item['code']}}</td>
                                    <td class="w-40">
                                        <div class="flex space-x-2">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="{{$item['title']}}" class="tooltip rounded-full" src="{{$item['image']}}">
                                                </div>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" class="font-medium whitespace-nowrap">{{$item['title']}}</a><br>
                                                <i>{{$title_version}}</i>
                                                <?php
                                                $html = '';
                                                if ($item['taxes_type'] == 'tax') {
                                                    $html .= '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Giá đã bao gồm thuế(' . $item['taxes_import'] . '%)</div>';
                                                } else if ($item['taxes_type'] == 'notax') {
                                                    $html .= '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Giá chưa bao gồm thuế(' . $item['taxes_import'] . '%)</div>';
                                                }
                                                echo $html;
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-56 text-center">
                                        <div class="flex items-center">
                                            <input class="hidden" type="text" class="rowid[]" value="{{$key}}">
                                            <input type="number" name="quantity[{{$key}}]" class="form-control w-14 quantity" value="0" max="{{$quantity}}" data-rowid="{{$key}}" data-price="{{$item['price']}}" data-price-taxes="{{$item['price_taxes']}}" data-quantity="{{$quantity}}" data-vat="{{$item['taxes_value']}}">
                                            <span>/ {{$quantity}}</span>
                                        </div>
                                    </td>
                                    <td class="w-40 text-center">
                                        {{ number_format($item['price'], '0', ',', '.')}}đ
                                    </td>
                                    <td class="table-report__action w-56 text-center">0đ</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right">Số lượng hàng trả</span>
                            <span class="quantityReturn text-right w-32">0</span>
                        </div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right">Giá trị hàng trả</span>
                            <span class="priceReturn text-right w-32">0đ</span>
                        </div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right text-danger">Chiết khấu</span>
                            <span class="priceDiscount text-right w-32">0đ</span>
                        </div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right text-danger">VAT</span>
                            <span class="priceVAT text-right w-32">0đ</span>
                        </div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right text-danger">Chi phí</span>
                            <span class="priceSurcharge text-right w-32">0đ</span>
                        </div>
                        <div class="flex justify-between p-4">
                            <span class="font-bold flex-1 text-right text-danger">Tổng giá trị hàng trả</span>
                            <span class="priceTotalReturn text-right w-32">0đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $totalPrice = $detail->product_purchases_financials->sum('price') - $detail->product_purchases_returns->sum('price_total');
            ?>
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        NHẬN TIỀN HOÀN LẠI TỪ NHÀ CUNG CẤP
                    </h2>
                </div>
                <div class="grid grid-cols-2 p-5 gap-3">
                    @if($totalPrice)
                    <div>
                        <label class="">Nhập số tiền nhận lại</label>
                        <?php echo Form::text('price', old('price'), ['class' => 'form-control float mt-2']); ?>
                    </div>
                    <div>
                        <label class="">Phương thức thanh toán</label>
                        <select class="form-control mt-2" name="method">
                            @foreach(config('payment.method') as $key=>$item)
                            <option value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="">Tham chiếu</label>
                        <?php echo Form::text('reference', old('reference'), ['class' => 'form-control mt-2']); ?>
                    </div>
                    <div class="col-span-2">
                        Số tiền có thể nhận lại: <b class="text-danger">{{number_format($totalPrice,'0',',','.')}}đ</b>
                    </div>
                    @else
                    <div class="col-span-2">
                        Bạn không thể nhận tiền hoàn cho đơn nhập chưa có thanh toán
                    </div>

                    @endif
                    <div class="col-span-2 hidden md:flex justify-end ">
                        <button type="submit" class="btn btn-primary">Hoàn trả</button>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 space-y-3">
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin nhà cung cấp
                    </h2>
                </div>
                <div class="p-5">
                    <div class="" id="loadDataInfoSuppliers">
                        <div class="flex items-center justify-between">
                            <div class="item flex items-center hover:text-danger cursor-pointer js_handleCloseInfoSuppliers">
                                <div class="w-10 h-10 rounded-full"><img src="https://ui-avatars.com/api/?name={{$detail->suppliers->title}}" class="rounded-full w-full"></div>
                                <div class="flex items-center"><span class="mx-2 font-bold text-danger">{{$detail->suppliers->title}}</span>

                                </div>
                            </div>
                            <div>Công nợ: <b>{{number_format($detail->suppliers->debt,'0',',','.')}}₫</b></div>
                        </div>
                        <div class="mt-3 border-t pt-3">
                            <h2 class="font-medium text-base mr-auto">Thông tin chi tiết:</h2>
                            <div class="space-y-1">
                                <p>Mã nhà cung cấp: {{$detail->suppliers->code}}</p>
                                <p> Số điện thoại: {{$detail->suppliers->phone}}</p>
                                <p>Email: {{$detail->suppliers->email}}</p>
                                <p>Địa chỉ: {{$detail->suppliers->address}}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin đơn nhập
                    </h2>
                </div>
                <div class="p-5 space-y-2">
                    <p><b>Chi nhánh:</b> {{$detail->address->title}}</p>
                    <p><b>Ngày hẹn giao:</b> {{$detail->dueOn}}</p>
                    <p><b>Tham chiếu:</b> {{!empty($detail->reference)?$detail->reference:'---'}}</p>
                </div>
            </div>
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Lý do hoàn trả
                    </h2>
                </div>
                <div class="p-5 space-y-2">
                    <?php echo Form::textarea('note', old('note'), ['class' => 'form-control']); ?>
                </div>
                <div class="p-5 flex md:hidden justify-end ">
                    <button type="submit" class="btn btn-primary">Hoàn trả</button>
                </div>
            </div>

        </div>
    </form>
</div>
<style>
    @media (min-width: 768px) {
        .md\:hidden {
            display: none;
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    .before\:bg-slate-100::before {
        background-color: #dddddd;
    }

    .html_deletePurchase a {
        display: none;
    }

    #htmlShowPurchase input {
        border: 0px !important;
        box-shadow: none;
        pointer-events: none;
    }
</style>
@endsection
@push('javascript')
<script>
    var cart = [];
    $(document).on('click', 'input[name="checkSelectAllReturn"]', function() {
        var totalItem = 0;
        var totalPrice = 0;
        var totalVAT = 0;
        if ($(this).is(":checked")) {
            $("input.quantity").each(function() {
                var quantity = parseFloat($(this).attr('data-quantity'));
                var price = parseFloat($(this).attr('data-price'));
                var price_taxes = parseFloat($(this).attr('data-price-taxes'));
                var vat = parseFloat($(this).attr('data-vat'));
                totalVAT += vat * quantity
                totalItem += quantity
                totalPrice += (quantity * price_taxes)
                $(this).val(quantity);
                $(this).parent().parent().parent().find('.table-report__action').html(numberWithCommas(quantity * price) + 'đ');
            });
            loadDataReturns(totalItem, totalVAT, totalPrice);
        } else {
            $("input.quantity").each(function() {
                $(this).val(0);
            })
            $('.htmlVAT').html('')
            $('.quantityReturn').html('');
            $('.priceReturn').html('0đ');
            $('.priceTotalReturn').html('0đ');
            $('input[name="price"]').val(0);
            $('.priceDiscount').html('0đ');
            $('.priceSurcharge').html('0đ');
            $('.priceVAT').html('0đ');
        }
    })
    $(document).on('keyup', 'input.quantity', function(e) {
        var totalItem = 0;
        var totalPrice = 0;
        var totalVAT = 0;
        var val = parseInt($(this).val());
        var max = parseInt($(this).attr('max'));
        if (val < 0) {
            e.preventDefault();
            $(this).val(1);
        }
        if (val > max) {
            e.preventDefault();
            $(this).val(max);
        }
        $("input.quantity").each(function() {
            var quantity = parseFloat($(this).val());
            if (quantity > 0) {
                var price = parseFloat($(this).attr('data-price'));
                var price_taxes = parseFloat($(this).attr('data-price-taxes'));
                var vat = parseFloat($(this).attr('data-vat'));
                totalVAT += vat * quantity
                totalItem += quantity
                totalPrice += (quantity * price_taxes)
                $(this).val(quantity);
                $(this).parent().parent().parent().find('.table-report__action').html(numberWithCommas(quantity * price) + 'đ');
            }
        });
        loadDataReturns(totalItem, totalVAT, totalPrice);
    })

    function loadDataReturns(totalItem = 0, totalVAT = 0, totalPrice = 0) {
        if (totalItem < <?php echo $totalQuantity ?>) {
            $('input[name="checkSelectAllReturn"]').prop("checked", false)
        }
        var priceDiscount = parseFloat(<?php echo !empty($products['priceDiscount']) ? $products['priceDiscount'] : 0 ?>); /*Giảm giá */
        var priceSurcharge = parseFloat(<?php echo !empty($products['priceSurcharge']) ? $products['priceSurcharge'] : 0 ?>); /*Chi phí */
        var provisional = parseFloat(<?php echo !empty($products['provisional']) ? $products['provisional'] : 0 ?>); /*Giá tạm tính */
        $('.quantityReturn').html(totalItem);
        $('.priceVAT').html(numberWithCommas(totalVAT) + 'đ');
        $('.priceReturn').html(numberWithCommas(totalPrice) + 'đ');
        //chiết khấu
        var valuePriceDiscount = totalPrice / (provisional / priceDiscount);
        $('.priceDiscount').html(numberWithCommas(valuePriceDiscount) + 'đ');
        //Chi phí
        var valuePriceSurcharge = totalPrice / (provisional / priceSurcharge);
        $('.priceSurcharge').html(numberWithCommas(valuePriceSurcharge) + 'đ');
        $('.priceTotalReturn').html(numberWithCommas((totalPrice + valuePriceSurcharge + totalVAT - valuePriceDiscount)) + 'đ');
        $('input[name="price"]').val(numberWithCommas((totalPrice + valuePriceSurcharge + totalVAT - valuePriceDiscount)));
    }
</script>
@endpush
@extends('homepage.layout.home')
@section('content')
<?php
if (config('app.locale') == 'en') {
    $_payment = config('cart.payment_en');
} else if (config('app.locale') == 'tl') {
    $_payment = config('cart.payment_tl');
} else if (config('app.locale') == 'gm') {
    $_payment = config('cart.payment_gm');
} else {
    $_payment = config('cart.payment');
}
$fullname = $phone = $addres = $email = '';
if (old('fullname')) {
    $fullname = old('fullname');
} else {
    if (!empty($orderInfo['fullname'])) {
        $fullname = $orderInfo['fullname'];
    } else {
        if (!empty($addressCustomer)) {
            $fullname = $addressCustomer->name;
        } else {
            $fullname = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->name : '';
        }
    }
}
if (old('phone')) {
    $phone = old('phone');
} else {
    if (!empty($orderInfo['phone'])) {
        $phone = $orderInfo['phone'];
    } else {
        if (!empty($addressCustomer)) {
            $phone = $addressCustomer->phone;
        } else {
            $phone = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->phone : '';
        }
    }
}
if (old('address')) {
    $address = old('address');
} else {
    if (!empty($orderInfo['address'])) {
        $address = $orderInfo['address'];
    } else {
        if (!empty($addressCustomer)) {
            $address = $addressCustomer->address;
        } else {
            $address = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->address : '';
        }
    }
}
if (old('email')) {
    $email = old('email');
} else {
    if (!empty($orderInfo['email'])) {
        $email = $orderInfo['email'];
    } else {
        $email = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->email : '';
    }
}
?>

{!!htmlBreadcrumb($page->title)!!}
<div class="py-9 bg-white">
    <form id="myForm" class="checkout" action="{{route('cart.order')}}" method="POST">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 lg:col-span-7">
                    <div>
                        <h3 class="text-lg font-semibold mb-5 tracking-[0.7px] uppercase">{{trans('index.BillingInformation')}}</h3>
                        <div class="grid grid-cols-2 gap-x-5">
                            @if ($errors->any())
                            <div class="col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    @endforeach
                                </span>
                            </div>
                            @endif
                            @if(session('error'))
                            <div class="col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline">
                                    {{session('error')}}
                                </span>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">
                                <div class="flex items-center mb-">
                                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold">{{session('success')}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(isset($arrStock))
                            <div class="col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 ">
                                <strong class="font-bold">ERROR!</strong>
                                <div class="block sm:inline">
                                    @foreach($arrStock as $item)
                                    {{$item}} /
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="col-span-2">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">
                                    <strong class="font-bold">ERROR!</strong>
                                    <span class="block sm:inline"></span>
                                </div>
                            </div>
                            @csrf
                            <div class="col-span-2">
                                <div>
                                    <label class="mb-3 inline-block font-bold">{{trans('index.Fullname')}}</label>
                                    <?php echo Form::text('fullname', $fullname, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Email</label>

                                    <?php echo Form::text('email', $email, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <div>
                                    <label class="mb-3 inline-block font-bold">{{trans('index.Phone')}}</label>

                                    <?php echo Form::text('phone', $phone, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="col-span-2 mb-5">
                                <div>
                                    <label class="mb-3 inline-block font-bold">{{trans('index.Address')}}</label>
                                    <?php
                                    echo Form::text('address', $address, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-span-2 mb-5 grid grid-cols-1 md:grid-cols-3 md:gap-4">
                                <div>
                                    <label class="md:mb-3 inline-block font-bold">{{trans('index.City')}}</label>
                                    <?php
                                    echo Form::select('city_id', $listCity, $city_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'city']);
                                    ?>
                                </div>
                                <div>
                                    <label class="md:mb-3 inline-block font-bold">{{trans('index.District')}}</label>
                                    <?php
                                    echo Form::select('district_id', $listDistrict, $district_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'district', 'placeholder' => trans('index.District')]);
                                    ?>
                                </div>
                                <div>
                                    <label class="md:mb-3 inline-block font-bold">{{trans('index.Ward')}}</label>
                                    <?php
                                    echo Form::select('ward_id', $listWard, $ward_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'ward', 'placeholder' => trans('index.Ward')]);
                                    ?>
                                </div>
                            </div>
                            @if(!empty($getFeeShip))
                            <div class="js_box_shipping mb-5 col-span-2 ">
                                <div class="space-y-2">
                                    <div>
                                        <label class="mb-3 inline-block font-bold">{{trans('index.ShippingUnit')}}</label>
                                        <div>{{trans('index.SHIPPINGCHANNEL',[ 'name' => $fcSystem['homepage_brandname']])}}</div>
                                    </div>
                                    <div class="list_shipping space-y-2">
                                        <?php echo $getFeeShip['html']; ?>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!$payments->isEmpty())
                            <div class="col-span-2">
                                <label class="mb-3 inline-block font-bold">{{trans('index.PaymentMethods')}}</label>
                                <div class="space-y-4">
                                    <?php /*@if(!empty(Auth::guard('customer')->user()->price))
                                    <div>
                                        <label class="flex items-center cursor-pointer" onclick="handleSelectPayment(100)">
                                            <input name="payment" type="radio" class="mr-1 option-input radio" value="wallet" <?php echo !empty(old('payment') && old('payment') == 'wallet') ? 'checked' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] == 'wallet') ? 'checked' : '') ?>>
                                            <span>{{trans('index.WalletBalance')}}</span>
                                        </label>
                                        <div class="shadow shadow_payment shadow_payment_100 p-4 mt-2 <?php echo !empty(old('payment') && old('payment') != 'wallet') ? 'hidden' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] != 'wallet') ? 'hidden' : '') ?>">
                                            <span> {{trans('index.UseAvailableWalletBalance')}}: <span class="text-red-600 font-bold"><?php echo number_format(Auth::guard('customer')->user()->price, '0', ',', '.') ?>₫</span>
                                            </span>
                                        </div>
                                    </div>
                                    @endif*/ ?>
                                    @foreach($payments as $key=>$val)
                                    @if($key != 'wallet')
                                    <div>
                                        <label class="flex items-center cursor-pointer" onclick="handleSelectPayment(<?php echo $val->id ?>)">
                                            <input name="payment" type="radio" class="mr-1 option-input radio" value="{{$val->keyword}}" <?php echo !empty(old('payment') && old('payment') == $val->keyword) ? 'checked' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] == $val->keyword) ? 'checked' : (!empty($key == 0) ? 'checked' : '')) ?>>
                                            <span>{{$_payment[$val->keyword]}}</span>
                                        </label>
                                        <div class="shadow shadow_payment shadow_payment_<?php echo $val->id ?> p-4 mt-2 <?php echo !empty(old('payment') && old('payment') != $val->keyword) ? 'hidden' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] != $val->keyword) ? 'hidden' : (empty($key == 0) ? 'hidden' : '')) ?>">
                                            <?php echo $val->description ?>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="additional-info-wrap mt-3">
                            <h4 class="text-base font-bold mb-3">{{trans('index.OrderNotes')}}</h4>
                            <div class="additional-info">
                                <?php echo Form::textarea('note', !empty(old('note')) ? old('note') : (!empty($orderInfo['note']) ? $orderInfo['note'] : ''), ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 placeholder-current text-dark h-36 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-5 mt-4 mt-lg-0">
                    <div>
                        <h3 class="text-lg font-semibold mb-5 tracking-[0.7px] uppercase">{{trans('index.InformationLine')}}</h3>
                        <div class="bg-slate-100 p-2 md:p-10">
                            <div class="your-order-product-info">
                                <ul class="flex flex-wrap items-center justify-between">
                                    <li class="text-base font-semibold">{{trans('index.Products')}}</li>
                                    <li class="text-base font-semibold text-orange">{{trans('index.intomoney')}}</li>
                                </ul>
                                <ul class="border-t border-b py-5 my-5 space-y-3">
                                    <?php $total = $price_coupon = 0; //dd($cartController); 
                                    ?>
                                    @if($cartController)
                                    @foreach( $cartController as $k=> $v)
                                    <?php
                                    $total += $v['price'] * $v['quantity'];
                                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                                    $unit = !empty($v['unit']) ? $v['unit'] : '';
                                    $title_version = !empty($v['options']['title_version']) ? '<i class="font-medium">(' . $v['options']['title_version'] . ')</i>' : '';
                                    ?>
                                    <li class="flex flex-wrap items-start justify-between cart_item" data-rowid="{{$k}}">
                                        <div class="w-2/3 action-cart-item">
                                            <div class="title">
                                                <span class="">{{$v['title']}} <span class="font-medium"><?php echo $title_version ?></span> X <b class="text-orange">{{$v['quantity']}} {{$unit}}</b></span>
                                            </div>
                                            <div class="flex count p-2 h-11" style="padding:0;margin: 5px 0 0 0;">
                                                <div class="flex items-center">
                                                    <button data-rowid="{{$k}}" class="decrement flex-auto w-5 h-10 bg-white leading-none tp_cart_minus" aria-label="button">-</button>
                                                    <input type="number" min="1" max="{{ checkInventoryCheckout($v) }}" step="1" value="{{ $v['quantity'] }}" class="tp_cardQuantity flex-auto w-20 h-10 text-center focus:outline-none input-appearance-none card-quantity">
                                                    <button data-rowid="{{$k}}" class="increment flex-auto w-5 h-10 bg-white leading-none tp_cart_plus" aria-label="button" h-10>+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-1/3  text-right"><span class=" text-right text-orange font-semibold total-product-item">{{number_format($v['quantity'] * $v['price'])}}₫</span></div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                <ul class="flex flex-wrap items-center justify-between ">
                                    <li class="text-base font-semibold">{{trans('index.Provisional')}}</li>
                                    <li class="text-base font-semibold text-orange cart-total">
                                        {{ number_format($total) }}₫
                                    </li>
                                </ul>
                                <ul class="flex flex-wrap items-center justify-between ">
                                    <li class="text-base font-semibold">{{trans('index.TransportFee')}}</li>
                                    <li class="js_fee_shipping text-base font-semibold text-orange"></li>
                                    <?php
                                    $fee_ship = 0;
                                    $title_ship = '';
                                    ?>
                                    @if(!empty($getFeeShip['fee_ship']))
                                    <?php
                                    $fee_ship = $getFeeShip['fee_ship'];
                                    $title_ship = $getFeeShip['title_ship'];
                                    ?>
                                    @endif
                                    <input name="title_ship" class="hidden" value="{{$title_ship}}">
                                    <input name="fee_ship" class="hidden" value="{{$fee_ship}}">
                                </ul>
                                <?php if (in_array('coupons', $dropdown)) { ?>
                                    <div class="cart-coupon-html">
                                        @if (isset($coupon))
                                        @foreach ($coupon as $v)
                                        <?php $price_coupon += !empty($v['price']) ? $v['price'] : 0; ?>
                                        <ul class="flex flex-wrap items-center justify-between">
                                            <li class="w-1/2 text-base font-semibold">{{trans('index.DiscountCode')}} {{$v['name']}}</li>
                                            <li class="w-1/2 text-base font-semibold text-orange text-right">
                                                <span class="cart-coupon-price">
                                                    - {{number_format($v['price'])}}₫ <a href="javascript:void(0)" data-id="{{$v['id']}}" class="remove-coupon text-red-600 font-bold">[{{trans('index.Delete')}}]</a>
                                                </span>
                                            </li>
                                        </ul>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- START: mã giảm giá -->
                                    <div class="mt-5">
                                        <h3 class="text-md font-semibold mb-2">{{trans('index.EnterDiscountCode')}}</h3>
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative message-danger mb-2 hidden">
                                            <strong class="font-bold">ERROR!</strong>
                                            <span class="block sm:inline danger-title"></span>
                                        </div>
                                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md message-success mb-2 hidden">
                                            <div class="flex">
                                                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold success-title"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <input id="coupon_code" class="border border-solid border-gray-300 w-full px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base" placeholder="{{trans('index.EnterDiscountCode')}}" type="text">
                                            <button type="button" id="apply_coupon" class="absolute top-0 right-0 h-12 inline-block bg-global leading-none py-4 px-2 text-sm text-white transition-all hover:bg-orange uppercase font-semibold hover:text-white">{{trans('index.Apply')}}</button>
                                        </div>
                                    </div>
                                    <!-- END: mã giảm giá -->
                                <?php } ?>
                                <input type="text" class="hidden js_provisional_input" name="provisional" value="<?php echo $total - $price_coupon ?>">
                                <ul class="flex flex-wrap items-center justify-between border-t border-b  py-5 my-5">
                                    <li class="text-base font-semibold">{{trans('index.TotalPrice')}}</li>
                                    <li class="text-base font-semibold text-orange cart-total-final">
                                        {{ number_format($total-$price_coupon) }}₫
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="js_btn_submit block w-full text-center leading-none uppercase bg-global text-white text-sm bg-dark px-2 py-5 transition-all hover:bg-orange font-semibold">{{trans('index.Order')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@push('javascript')
<script>
    var cityid = '<?php echo $city_id ?>';
    var districtid = '<?php echo $district_id ?>';
    var wardid = '<?php echo $ward_id ?>';
    var fee_ship = parseFloat($('input[name="fee_ship"]').val());
    var provisional = parseFloat($('input[name="provisional"]').val());
    $('.js_fee_shipping').html(numberWithCommas(fee_ship) + '₫');
    $('.cart-total-final').html(numberWithCommas(fee_ship + provisional) + '₫');
</script>

<!-- loading -->
<style>
    .lds-ring {
        width: 80px;
        height: 80px;
        position: fixed;
        z-index: 9999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #000;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #000 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .lds-show {
        width: 100%;
        height: 100vh;
        float: left;
        position: fixed;
        z-index: 999999999999999999999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #0000004f;
    }
</style>
<div class="lds-show lds-show-1 hidden">
    <div class="lds-ring ">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<script>
    // $(document).ajaxStart(function() {
    //     $('.lds-show-1').removeClass('hidden');
    // }).ajaxStop(function() {
    //     $('.lds-show-1').addClass('hidden');
    // });
</script>
<script>
    $(".js_btn_submit").click(function(e) {
        e.preventDefault(e)
        $.ajax({
            url: "<?php echo route('cart.checkoutValidateFormCopyCart') ?>",
            type: 'POST',
            beforeSend: function() {
                $('.lds-show-1').removeClass('hidden');
            },
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                fullname: $("#myForm input[name='fullname']").val(),
                email: $("#myForm input[name='email']").val(),
                phone: $("#myForm input[name='phone']").val(),
                address: $("#myForm input[name='address']").val(),
                city_id: $("#myForm select[name='city_id']").val(),
                district_id: $("#myForm select[name='district_id']").val(),
                ward_id: $("#myForm select[name='ward_id']").val(),
            },
            beforeSend: function() {
                $(".lds-show-1").removeClass("hidden");
            },
            success: function(data) {
                if (data.status == 200) {
                    $('.lds-show-1').removeClass('hidden');
                    $('#myForm').submit();
                } else {
                    $(".lds-show-1").addClass("hidden");
                    $("#myForm .print-error-msg").css('display', 'block');
                    $("#myForm .print-success-msg").css('display', 'none');
                    $("#myForm .print-error-msg span").html(data.error);
                    $('html, body').animate({
                        scrollTop: $('#myForm').offset().top - 100
                    }, 100);
                    return false;
                }
            }
        });
        return false;
    })
</script>
@endpush
@push('css')
<link href="{{asset('frontend/css/app.css')}}" rel="stylesheet" async>
@endpush

@push('javascript')
<script src="{{asset('frontend/library/js/products.js')}}"></script>
@endpush
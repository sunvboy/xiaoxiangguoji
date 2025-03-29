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
<div class="py-9 bg-[#edf0f3]">
    <div class="container">
        <form id="myForm" class="checkout" action="{{route('cart.order')}}" method="POST">
            @csrf

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2">
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
                    <div class="bg-[#fff] rounded-xl p-[15px]">
                        <div class="flex items-center space-x-[12px] mb-[12px]">
                            <img alt="Thông tin người đặt" src="{{asset('images/user.png')}}" class="w-[24px] h-[24px]" />
                            <div class="text-[16px] font-semibold">Thông tin đặt hàng</div>
                        </div>

                        <div class="grid gap-[12px] grid-cols-2 pb-[12px] border-b">
                            <?php echo Form::text('fullname', $fullname, ['class' => 'outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'autocomplete' => 'off', 'placeholder' => 'Họ và tên']); ?>
                            <?php echo Form::text('phone', $phone, ['class' => 'outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'autocomplete' => 'off', 'placeholder' => 'Số điện thoại']); ?>
                            <?php echo Form::text('email', $email, ['class' => 'col-span-2 outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'autocomplete' => 'off', 'placeholder' => 'Email']); ?>
                        </div>
                        <div class="flex items-center space-x-[12px] my-[12px]">
                            <img alt="Thông tin người đặt" src="{{asset('images/pin.png')}}" class="w-[24px] h-[24px]" />
                            <div class="text-[16px] font-semibold">Địa chỉ nhận hàng</div>
                        </div>
                        <div class="grid gap-[12px] grid-cols-3 pb-[12px]">
                            <?php echo Form::text('address', $address, ['class' => 'col-span-3 outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'autocomplete' => 'off', 'placeholder' => 'Địa chỉ']); ?>

                            <?php
                            echo Form::select('city_id', $listCity, $city_id, ['class' => 'outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'id' => 'city']);
                            ?>
                            <?php
                            echo Form::select('district_id', $listDistrict, $district_id, ['class' => 'outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'id' => 'district', 'placeholder' => trans('index.District')]);
                            ?>
                            <?php
                            echo Form::select('ward_id', $listWard, $ward_id, ['class' => 'outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'id' => 'ward', 'placeholder' => trans('index.Ward')]);
                            ?>
                            <?php echo Form::textarea('note', !empty(old('note')) ? old('note') : (!empty($orderInfo['note']) ? $orderInfo['note'] : ''), ['class' => 'col-span-3 outline-none focus:outline-none hover:outline-none h-auto p-[16px] text-[16px] rounded-xl leading-6 bg-white border', 'autocomplete' => 'off', 'placeholder' => 'Thêm ghi chú (ví dụ: Hãy gọi trước khi giao)']); ?>

                        </div>

                    </div>
                    <?php /*<div class="py-[12px] font-semibold">{{trans('index.ShippingUnit')}}</div>
                    <div class="bg-[#fff] rounded-xl p-[15px]">
                        @if(!empty($getFeeShip))
                        <div class="js_box_shipping">
                            <div class="space-y-2">
                                <div class="uppercase">{{trans('index.SHIPPINGCHANNEL',[ 'name' => $fcSystem['homepage_brandname']])}}</div>
                                <div class="list_shipping space-y-2">
                                    <?php echo $getFeeShip['html']; ?>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>*/?>

                    <div class="py-[12px] font-semibold">Chọn hình thức thanh toán</div>
                    <div class="bg-[#fff] rounded-xl p-[15px]">
                        <ul class="flex flex-col">
                            @foreach($payments as $key=>$val)
                            @if($key != 'wallet')
                            <li class="py-[12px] px-[16px] border-b paymentItem">
                                <label class="flex items-center cursor-pointer" for="{{$val->keyword}}" onclick="handleSelectPayment(<?php echo $val->id ?>)">
                                    <input id="{{$val->keyword}}" name="payment" type="radio" value="{{$val->keyword}}" <?php echo !empty(old('payment') && old('payment') == $val->keyword) ? 'checked' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] == $val->keyword) ? 'checked' : (!empty($key == 0) ? 'checked' : '')) ?>>
                                    <img src="{{!empty(config('cart')['payment_image'][$val->keyword])?config('cart')['payment_image'][$val->keyword]:''}}" alt="avatar" class="w-[40px] h-[40px] ml-[20px]">
                                    <span class="pl-[12px] font-semibold">{{$_payment[$val->keyword]}}</span>
                                </label>
                                <div class="shadow_payment shadow_payment_<?php echo $val->id ?> p-4 mt-2 <?php echo !empty(old('payment') && old('payment') != $val->keyword) ? 'hidden' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] != $val->keyword) ? 'hidden' : (empty($key == 0) ? 'hidden' : '')) ?>">
                                    <?php echo $val->description ?>
                                </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>

                    </div>
                </div>
                <div class="col-span-1">
                    <?php $total = $price_coupon = 0; //dd($cartController); 
                    ?>
                    <div class="bg-[#fff] rounded-tl-2xl rounded-tr-2xl max-w-[384px] mx-auto">
                        <div class="p-[16px]">
                            @if($cartController)
                            @foreach( $cartController as $k=> $v)
                            <?php
                            $total += $v['price'] * $v['quantity'];
                            $slug = !empty($v['slug']) ? $v['slug'] : '';
                            $unit = !empty($v['unit']) ? $v['unit'] : '';
                            $title_version = !empty($v['options']['title_version']) ? '<i class="font-medium">(' . $v['options']['title_version'] . ')</i>' : '';
                            ?>
                            @endforeach
                            @endif
                            <!-- START: tạm tính -->
                            <div class="flex justify-between items-center">
                                <h3 class="text-[16px] mb-0">Tạm tính</h3>
                                <div class="text-[16px] cart-total">
                                    <?php echo number_format($total, '0', ',', '.') . '₫' ?>
                                </div>
                            </div>
                            <!-- START: Phí vận chuyển -->
                            <?php
                            $fee_ship = 0;
                            $title_ship = '';
                            ?>
                            <input name="title_ship" class="hidden" value="{{$title_ship}}">
                            <input name="fee_ship" class="hidden" value="{{$fee_ship}}">
                            <?php /*@if(!empty($getFeeShip['fee_ship']))
                            <?php
                            $fee_ship = $getFeeShip['fee_ship'];
                            $title_ship = $getFeeShip['title_ship'];
                            ?>
                            @endif
                            <div class="flex justify-between items-center">
                                <h3 class="text-[16px] mb-0">{{trans('index.TransportFee')}}</h3>
                                <div class="text-[16px] cart-total js_fee_shipping">
                                </div>
                            </div>*/?>
                            <!-- START: Mã giảm giá -->
                            <?php if (in_array('coupons', $dropdown)) { ?>
                                <div class="cart-coupon-html">
                                    @if (isset($coupon))
                                    @foreach ($coupon as $v)
                                    <?php $price_coupon += !empty($v['price']) ? $v['price'] : 0; ?>
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-[16px] mb-0">
                                            {{trans('index.DiscountCode')}} <span class="cart-coupon-name font-bold underline">{{$v['name']}}</span>
                                            <a href="javascript:void(0)" data-id="{{$v['id']}}" class="remove-coupon text-red-600 font-bold">[{{trans('index.Delete')}}]</a>
                                        </h3>
                                        <div class="text-[16px] cart-total">
                                            -<span class="amount cart-coupon-price"><?php echo number_format($v['price']) . '₫' ?>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="mt-3">
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
                                        <input id="coupon_code" class="border border-solid border-gray-300 w-full px-3 mb-5 placeholder-current text-dark h-[46px] focus:outline-none" placeholder="{{trans('index.EnterDiscountCode')}}" type="text">
                                        <button type="button" id="apply_coupon" class="absolute top-0 right-0 h-[46px] inline-block bg-[#022da4] leading-none py-4 px-[8px]  text-white transition-all hover:bg-orange font-semibold hover:text-white tracking-[0.7px] ">{{trans('index.Apply')}}</button>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- END: mã giảm giá -->

                            <div class="pt-[20px] border-t">
                                <div class="flex justify-between pb-[20px]">
                                    <input type="text" class="hidden js_provisional_input" name="provisional" value="<?php echo $total - $price_coupon ?>">
                                    <h3 class="text-[18px] font-bold">{{trans('index.TotalPrice')}}</h3>
                                    <div class="text-[18px] font-bold cart-total-final">
                                        <?php echo number_format($total - $price_coupon, '0', ',', '.') . '₫' ?>
                                    </div>
                                </div>
                                <button class="js_btn_submit ps-btn ps-btn--warning">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                    <div class="ml-[auto] pl-[2px]">
                        <svg width="400" height="24" viewBox="0 0 384 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0H384V15.25C384 17.8112 384 19.0917 383.615 20.1135C383.007 21.7306 381.731 23.0068 380.113 23.6154C379.092 24 377.811 24 375.25 24C373.55 24 372.7 24 372.131 23.8888C370.435 23.5578 371.033 23.8255 369.656 22.7819C369.194 22.4314 367.279 20.2894 363.449 16.0053C361.252 13.5472 358.057 12 354.5 12C349.957 12 346.004 14.524 343.967 18.2462C342.376 21.1529 339.814 24 336.5 24C333.186 24 330.624 21.1529 329.033 18.2462C326.996 14.524 323.043 12 318.5 12C313.957 12 310.004 14.524 307.967 18.2462C306.376 21.1529 303.814 24 300.5 24C297.186 24 294.624 21.1529 293.033 18.2462C290.996 14.524 287.043 12 282.5 12C277.957 12 274.004 14.524 271.967 18.2462C270.376 21.1529 267.814 24 264.5 24C261.186 24 258.624 21.1529 257.033 18.2462C254.996 14.524 251.043 12 246.5 12C241.957 12 238.004 14.524 235.967 18.2462C234.376 21.1529 231.814 24 228.5 24C225.186 24 222.624 21.1529 221.033 18.2462C218.996 14.524 215.043 12 210.5 12C205.957 12 202.004 14.524 199.967 18.2462C198.376 21.1529 195.814 24 192.5 24C189.186 24 186.624 21.1529 185.033 18.2462C182.996 14.524 179.043 12 174.5 12C169.957 12 166.004 14.524 163.967 18.2462C162.376 21.1529 159.814 24 156.5 24C153.186 24 150.624 21.1529 149.033 18.2462C146.996 14.524 143.043 12 138.5 12C133.957 12 130.004 14.524 127.967 18.2462C126.376 21.1529 123.814 24 120.5 24C117.186 24 114.624 21.1529 113.033 18.2462C110.996 14.524 107.043 12 102.5 12C97.9574 12 94.0044 14.524 91.9668 18.2462C90.3757 21.1529 87.8137 24 84.5 24C81.1863 24 78.6243 21.1529 77.0332 18.2462C74.9956 14.524 71.0426 12 66.5 12C61.9574 12 58.0044 14.524 55.9668 18.2462C54.3757 21.1529 51.8137 24 48.5 24C45.1863 24 42.6243 21.1529 41.0332 18.2462C38.9956 14.524 35.0426 12 30.5 12C27.1233 12 24.0723 13.3947 21.8918 15.6395C17.3526 20.3123 15.083 22.6487 14.5384 23.008C13.3234 23.8097 13.9452 23.5469 12.5236 23.8598C11.8864 24 11.0076 24 9.25 24C6.21942 24 4.70412 24 3.52376 23.4652C2.19786 22.8644 1.13557 21.8021 0.534817 20.4762C0 19.2959 0 17.7806 0 14.75V0Z" fill="white"></path>
                        </svg>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>

@endsection

@push('css')
<link href="{{asset('frontend/css/app.css')}}" rel="stylesheet" async>
<style>
    .breadcrumb {
        margin-bottom: 0px !important;
    }
</style>
@endpush

@push('javascript')
<script src="{{asset('frontend/library/js/products.js')}}"></script>
<script>
    var cityid = '<?php echo $city_id ?>';
    var districtid = '<?php echo $district_id ?>';
    var wardid = '<?php echo $ward_id ?>';
    /*var fee_ship = parseFloat($('input[name="fee_ship"]').val());
    var provisional = parseFloat($('input[name="provisional"]').val());
    $('.js_fee_shipping').html(numberWithCommas(fee_ship) + '₫');
    $('.cart-total-final').html(numberWithCommas(fee_ship + provisional) + '₫');*/
</script>
<script>
    $(".js_btn_submit").click(function(e) {
        e.preventDefault(e)
        $.ajax({
            url: "<?php echo route('cart.checkoutValidateFormCopyCart') ?>",
            type: 'POST',
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
                // $(".lds-show").removeClass("d-none");
            },
            success: function(data) {
                if (data.status == 200) {
                    $('#myForm').submit();
                    // $('.lds-show').removeClass('d-none');
                } else {
                    $("#myForm .print-error-msg").css('display', 'block');
                    $("#myForm .print-success-msg").css('display', 'none');
                    $("#myForm .print-error-msg span").html(data.error);
                    $('html, body').animate({
                        scrollTop: $('#myForm').offset().top - 100
                    }, 100);
                }
            },
        });
        return false;
    })
</script>
<style>
    input[type=radio] {
        position: relative;
        cursor: pointer;
        border-radius: 100%;
    }

    input[type=radio]:before {
        content: "";
        display: block;
        position: absolute;
        width: 20px;
        height: 20px;
        top: 0;
        left: -1px;
        background-color: #e9e9e9;
        border-radius: 100%;
    }

    input[type=radio]:checked:before {
        content: "";
        display: block;
        position: absolute;
        width: 20px;
        height: 20px;
        top: 0;
        left: 0;
        background-color: #1E80EF;
    }

    input[type=radio]:checked:after {
        content: "";
        display: block;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        top: 3px;
        left: 7px;
    }

    input:focus {
        outline: none;
        box-shadow: none;
    }
    .paymentItem:last-child{
    	border-bottom: 0px !important
    }
</style>
@include('homepage.common.loading')
@endpush
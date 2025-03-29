@extends('homepage.layout.home')
@section('content')
<?php $coupon = json_decode($detail->coupon, TRUE); ?>

<nav class="relative w-full flex flex-wrap items-center justify-between py-2 bg-[#f9f9f9] text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
    <div class="container px-4 mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex flex-wrap">
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
                <form action="{{route('cart.order')}}" id="myForm" method="post">
                    <input type="hidden" name="copyCartID" value="{{$detail->id}}">
                    <div class="shadowC rounded-xl p-6 space-y-10 md:space-y-4">
                        <div>
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
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline"></span>
                            </div>
                        </div>
                        <div class="">
                            <h2 class="font-bold text-lg">{{trans('index.OrderDetails')}}</h2>
                            <div class="listCart mt-5 space-y-3" id="listCart">
                                <?php $total = $price_coupon = 0; ?>
                                @if($cartCopy)
                                @foreach( $cartCopy as $k=>$v)
                                <?php
                                $total += $v['price'] * $v['quantity'];
                                ?>
                                <?php echo htmlItemCartCopyCustomer($k, $v) ?>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- START: chọn thêm sản phẩm -->
                        <div class="relative w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 absolute top-1/2 left-3 -translate-y-1/2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input placeholder="{{trans('index.MoreNewProducts')}}" type="text" value="" class="js_search_product rounded-lg border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300 focus:rounded-lg hover:outline-none hover:ring hover:ring-red-300 hover:rounded-lg pl-14" name="keyword" autocomplete="off">
                            <div class="js_list_product absolute w-full left-0 top-[44px] bg-white shadowC z-50 p-4" style="display: none">
                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-3 items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg>
                                        <h2 class="font-medium">{{trans('index.SelectProduct')}}</h2>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" class="js_close_listProduct">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-2 border-t" id="loadDataProduct">
                                    @include('customer.frontend.order.dataProduct')
                                </div>
                            </div>
                        </div>
                        <!-- END: chọn thêm sản phẩm -->
                        <div class="flex flex-col space-y-2">
                            <div class="flex">
                                <input type="text" class="hidden js_provisional_input" value="<?php echo $total ?>">
                                <div class="w-1/2 md:w-3/4 text-right">
                                    {{trans('index.Provisional')}}
                                </div>
                                <div class="flex-1 text-right font-bold js_provisional">
                                    {{number_format($total,0,',','.')}}₫
                                </div>
                            </div>
                            <div class="flex">
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
                                <input name="title_ship" type="text" class="hidden" value="{{$title_ship}}">
                                <input name="fee_ship" type="text" class="hidden" value="{{$fee_ship}}">
                                <div class="w-1/2 md:w-3/4 text-right">
                                    {{trans('index.TransportFee')}}
                                </div>
                                <div class="flex-1 text-right font-bold js_fee_shipping">
                                    {{number_format($fee_ship,'0',',','.')}}₫
                                </div>
                            </div>
                            <div class="flex text-base md:text-xl">
                                <div class="w-1/2 md:w-3/4 text-right font-black">
                                    {{trans('index.TotalPrice')}}
                                </div>
                                <div class="flex-1 text-right font-black text-global cart-total-copy">
                                    {{number_format($total+$fee_ship,0,',','.')}}₫
                                </div>
                            </div>
                        </div>
                        <!-- START: thông tin thanh toán -->
                        <div class="">
                            <div>
                                <h3 class="font-bold text-lg mb-5">{{trans('index.BillingInformation')}}</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-5">

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
                                    @csrf
                                    <div class="lg:col-span-2">
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.Fullname')}}</label>
                                            <?php echo Form::text('fullname', $detail->fullname, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div>
                                            <label class="mb-3 inline-block font-bold">Email</label>

                                            <?php echo Form::text('email', $detail->email, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.Phone')}}</label>

                                            <?php echo Form::text('phone', $detail->phone, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                        </div>
                                    </div>
                                    <div class="lg:col-span-2 mb-5">
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.Address')}}</label>
                                            <?php
                                            echo Form::text('address', $detail->address, ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="lg:col-span-2 mb-5 grid md:grid-cols-3 md:gap-4">
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.City')}}</label>
                                            <?php
                                            echo Form::select('city_id', $listCity, $detail->city_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'city']);
                                            ?>
                                        </div>
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.District')}}</label>
                                            <?php
                                            echo Form::select('district_id', $listDistrict, $detail->district_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'district', 'placeholder' => trans('index.District')]);
                                            ?>
                                        </div>
                                        <div>
                                            <label class="mb-3 inline-block font-bold">{{trans('index.Ward')}}</label>
                                            <?php
                                            echo Form::select('ward_id', $listWard, $detail->ward_id, ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-2 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'ward', 'placeholder' => trans('index.Ward')]);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="js_box_shipping mb-5 lg:col-span-2 ">
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
                                    @if(!$payments->isEmpty())
                                    <div class="lg:col-span-2">
                                        <label class="mb-3 inline-block font-bold">{{trans('index.PaymentMethods')}}</label>
                                        <div class="space-y-4">
                                            @foreach($payments as $key=>$val)
                                            <div>
                                                <label class="flex items-center cursor-pointer" onclick="handleSelectPayment(<?php echo $val->id ?>)">
                                                    <input name="payment" type="radio" class="mr-1 option-input radio" value="{{$val->keyword}}" <?php echo !empty(old('payment') && old('payment') == $val->keyword) ? 'checked' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] == $val->keyword) ? 'checked' : (!empty($key == 0) ? 'checked' : '')) ?>>
                                                    <span>{{ $val->title}}</span>
                                                </label>
                                                <div class="shadow shadow_payment shadow_payment_<?php echo $val->id ?> p-4 mt-2 <?php echo !empty(old('payment') && old('payment') != $val->keyword) ? 'hidden' : (!empty($orderInfo['payment']) && !empty($orderInfo['payment'] != $val->keyword) ? 'hidden' : (empty($key == 0) ? 'hidden' : '')) ?>">
                                                    <?php echo $val->description ?>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <style>
                                    .stardust-icon {
                                        color: #ee4d2d;
                                    }

                                    .list_shipping_item {
                                        display: flex;
                                        flex: 1;
                                        background-color: #fafafa;
                                        box-shadow: inset 4px 0 0 #ee4d2d;
                                    }

                                    .list_shipping_item .priceA {
                                        color: #ee4d2d;
                                    }
                                </style>
                                <div class="additional-info-wrap mt-3">
                                    <h4 class="text-base font-bold mb-3">{{trans('index.OrderNotes')}}</h4>
                                    <div class="additional-info">
                                        <?php echo Form::textarea('note', !empty(old('note')) ? old('note') : (!empty($orderInfo['note']) ? $orderInfo['note'] : ''), ['class' => 'border border-solid border-gray-300 w-full py-1 px-2 placeholder-current text-dark h-36 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                    </div>
                                </div>
                                <div class="mt-5 flex justify-end">
                                    <button type="submit" class="js_btn_submit_copy_cart text-center leading-none uppercase bg-red-600 text-white text-sm bg-dark px-10 py-5 transition-all hover:bg-orange font-semibold">{{trans('index.Order')}}</button>
                                    <button type="button" class="js_process_copy_cart text-center leading-none uppercase bg-red-600 text-white text-sm bg-dark px-10 py-5 transition-all hover:bg-orange font-semibold flex items-center hidden" disabled="">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!-- END: thông tin thanh toán -->
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>
<script>
    /*Select Product */
    var aurl = window.location.href; // Get the absolute url
    $('.menu_order').filter(function() {
        return $(this).prop('href') === aurl;
    }).addClass('active');
    $(".menu_item_auth:eq(2)").addClass('active');
    var resultsSelected = false;
    $(".js_list_product").hover(
        function() {
            resultsSelected = true;
        },
        function() {
            resultsSelected = false;
        }
    );
    $(".js_search_product").focus(function() {
        $(".js_list_product").show()
    });
    $(".js_search_product").blur(function() {
        if (!resultsSelected) { //if you click on anything other than the results
            $(".js_list_product").hide(); //hide the results
        }
    })
    $(document).on('click', '.js_close_listProduct', function() {
        $(".js_list_product").hide();
    })

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
    $('.js_search_product').keyup(delay(function(e) {
        e.preventDefault();
        get_list_object_copy_order();
    }, 500));
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        console.log(1);
        var page = $(this).attr('href').split('page=')[1];
        get_list_object_copy_order(page);
    });

    function get_list_object_copy_order(page = 1) {
        let keyword = $('.js_search_product').val();
        let ajaxUrl = "<?php echo route('customer.ajaxListProduct') ?>";
        $.post(ajaxUrl, {
                keyword: keyword,
                page: page,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#loadDataProduct').html(data);
            });
    }
    /*END */
</script>
<script>
    /*START: handle Cart*/

    /*START: AddToCart */
    $(document).on('click', '.js_handle_addToCart', function(event) {
        $.post("<?php echo route('customer.addToCartCopyOrder') ?>", {
                idCopyCart: "<?php echo $detail->id ?>",
                id: $(this).data('id'),
                idVersion: $(this).attr('data-id-version'),
                titleVersion: $(this).attr('data-title-version'),
                type: $(this).data('type'),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if (data.data.error != '') {
                    toastr.error(data.data.error, '<?php echo trans('index.Notify') ?>')
                } else {
                    loadDataCopyCart(data)
                    toastr.success(data.data.message, '<?php echo trans('index.Notify') ?>')
                }
            });
    });
    /*START: Update cart */
    $(document).on('change', '.js_change_copyCart', function() {
        var quantity = $(this).val();
        $.post("<?php echo route('customer.updateCartCopyOrder') ?>", {
                quantity: quantity,
                idCopyCart: <?php echo $detail->id ?>,
                type: "update",
                rowid: $(this).attr('data-rowid'),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                if (data.data.error != '') {
                    toastr.error(data.data.error, '<?php echo trans('index.Notify') ?>')
                } else {
                    loadDataCopyCart(data);
                    toastr.success(data.data.message, '<?php echo trans('index.Notify') ?>')
                }

            });
    })
    /*START: Delete cart */
    $(document).on('click', '.js_delete_copyCart', function(e) {
        e.preventDefault();
        $.post("<?php echo route('customer.updateCartCopyOrder') ?>", {
                idCopyCart: <?php echo $detail->id ?>,
                type: "delete",
                rowid: $(this).attr('data-rowid'),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                loadDataCopyCart(data)
                toastr.success(data.data.message, '<?php echo trans('index.Notify') ?>')
            });
    })
    /*START: Load data cart */
    function loadDataCopyCart(data) {
        $('#listCart').html(data.html);
        var fee = $('input[name="fee_ship"]').val();
        $('.cart-total-copy').html(numberWithCommas(parseFloat(data.provisional) + parseFloat(fee)) + '₫');
        $('.js_provisional').html(numberWithCommas(data.provisional) + '₫');
        $('.js_provisional_input').val(data.provisional);
        $(".js_list_product").hide();
    }
    /*END */
</script>
@endsection
@push('javascript')
<script>
    var cityid = '<?php echo $detail->city_id ?>';
    var districtid = '<?php echo $detail->district_id ?>';
    var wardid = '<?php echo $detail->ward_id ?>';
    /*Tính phí vận chuyển*/
    var provisional = $('.js_provisional_input').val();
    $(document).on('click', '.js_change_fee_shipping', function(e) {
        var provisional = $('.js_provisional_input').val();
        var fee = $(this).attr('data-fee');
        $('.cart-total-copy').html(numberWithCommas(parseFloat(provisional) + parseFloat(fee)) + '₫');
    });
    /*END */
</script>
<script>
    /*validate form before checkout*/
    $(".js_btn_submit_copy_cart").click(function(e) {
        $.ajax({
            url: "<?php echo route('customer.validateFormCopyCart') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                copyCartID: $("#myForm input[name='copyCartID']").val(),
                fullname: $("#myForm input[name='fullname']").val(),
                email: $("#myForm input[name='email']").val(),
                phone: $("#myForm input[name='phone']").val(),
                address: $("#myForm input[name='address']").val(),
                city_id: $("#myForm select[name='city_id']").val(),
                district_id: $("#myForm select[name='district_id']").val(),
                ward_id: $("#myForm select[name='ward_id']").val(),
            },
            success: function(data) {
                console.log(data);
                if (data.status == 200) {
                    $('.js_btn_submit_copy_cart').addClass('hidden');
                    $('.js_process_copy_cart').removeClass('hidden');
                    $('.lds-show-2').removeClass('hidden');
                    $('#myForm').submit();
                } else {
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
<style>
    .option-input {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        position: relative;
        height: 25px;
        width: 25px;
        transition: all 0.15s ease-out 0s;
        background: #cbd1d8;
        border: none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        margin-right: 0.5rem;
        outline: none;
        position: relative;
        z-index: 1000;
    }

    .option-input:hover {
        background: #9faab7;
    }

    .option-input:checked {
        background: #40e0d0;
    }

    .option-input:checked::before {
        display: flex;
        content: '';
        font-size: 25px;
        font-weight: bold;
        position: absolute;
        align-items: center;
        justify-content: center;
        width: 8px;
        height: 12px;
        border-width: 0 2px 2px 0;
        border-style: solid;
        border-color: #fff;
        transform-origin: bottom left;
        transform: rotate(45deg);
        top: 0px;
        left: 6px;
    }

    .option-input:checked::after {
        -webkit-animation: click-wave 0.65s;
        -moz-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #40e0d0;
        content: '';
        display: block;
        position: relative;
        z-index: 100;
    }

    .option-input.radio {
        border-radius: 50%;
    }

    .option-input.radio::after {
        border-radius: 50%;
    }

    @keyframes click-wave {
        0% {
            height: 40px;
            width: 40px;
            opacity: 0.35;
            position: relative;
        }

        100% {
            height: 200px;
            width: 200px;
            margin-left: -80px;
            margin-top: -80px;
            opacity: 0;
        }
    }
</style>
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
<div class="lds-show lds-show-2 hidden">
    <div class="lds-ring ">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<script>
    $(document).ajaxStart(function() {
        $('.lds-show-1').removeClass('hidden');
    }).ajaxStop(function() {
        $('.lds-show-1').addClass('hidden');
    });
</script>
@endpush
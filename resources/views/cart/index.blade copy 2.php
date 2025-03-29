@extends('homepage.layout.home')
@section('content')
<main class="py-10 md:py-16">
    <div class="container px-4 md:px-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-8">
                <h1 class="font-bold text-[22px] tracking-[0.7px] uppercase">{{$page->title}}</h1>
                <?php $price_coupon = 0; ?>
                <input type="hidden" name="fee_ship" value="0">
                @if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0 )
                @foreach($cart['cart'] as $k=>$item)
                <?php
                $stock = getStockProduct($item);
                $slug = !empty($item['slug']) ? $item['slug'] : '';
                $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
                ?>
                <div class="cart_item cart-{{$k}} flex gap-8">
                    <div class="w-[115px]">
                        <a href="{{$slug}}">
                            <img alt="{{$item['title']}}" src="{{asset($item['image'])}}">
                        </a>
                    </div>
                    <div class="flex-1 ">
                        <div class="flex flex-col justify-between h-full">
                            <div class="flex justify-between">
                                <div>
                                    <p class="tracking-wider text-base">{{$item['title']}}</p>
                                    <p class="">{{$title_version}}</p>
                                    <p class="text-red-600">{{number_format($item['price'])}}đ</p>
                                </div>
                                <?php /*
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs">
                                        Save for later
                                    </span>
                                    <span>
                                        <svg class="w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.695 4c-1.208 0-2.416.505-3.328 1.515-1.824 2.019-1.822 5.246 0 7.267l7.265 8.057a.493.493 0 0 0 .727 0l7.273-8.049c1.824-2.02 1.824-5.248 0-7.267-1.824-2.02-4.832-2.02-6.656 0L12 6.603l-.977-1.088C10.111 4.505 8.903 4 7.695 4Zm0 1.007c.934 0 1.864.401 2.594 1.209l1.351 1.49a.492.492 0 0 0 .727 0l1.343-1.474c1.46-1.615 3.736-1.615 5.196 0 1.459 1.615 1.459 4.242 0 5.857L12 19.735l-6.906-7.662c-1.458-1.617-1.46-4.242 0-5.858.73-.807 1.667-1.208 2.601-1.208Z" fill="#111"></path>
                                        </svg>

                                    </span>
                                </div>
                                */ ?>
                            </div>
                            <div class="flex justify-between">

                                <div>
                                    <div class="flex items-center">
                                        <button data-rowid="{{$k}}" class="tp_cart_minus flex justify-center items-center w-6 h-6 bg-gray-200 rounded-full">
                                            <svg class="w-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 12.5H4v-1h16v1Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <input type="number" min="1" data-rowid="{{$k}}" max="{{$stock}}" step="1" value="{{$item['quantity']}}" class="flex-auto w-8 text-center focus:outline-none input-appearance-none tp_cardQuantity">
                                        <button data-rowid="{{$k}}" class="tp_cart_plus flex justify-center items-center w-6 h-6 bg-gray-200 rounded-full">
                                            <svg class="w-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.5 11.5V4h1v7.5H20v1h-7.5V20h-1v-7.5H4v-1h7.5Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                                <a href="javascript:void(0)" data-rowid="{{$k}}" class="js-cart-remove flex items-center space-x-2 group hover:text-red-600">
                                    <span class="text-xs">
                                        Xóa
                                    </span>
                                    <span>
                                        <svg class="w-5 group-hover:text-red-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.782 12 19 18.218l-.782.782L12 12.782 5.782 19 5 18.218 11.218 12 5 5.782 5.782 5 12 11.218 18.218 5l.782.782L12.782 12Z"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div>


                <div class="bg-[#f7f7f7] p-8">

                    <!-- START: mã giảm giá -->
                    <div class="cart-coupon-html">
                        @if (isset($coupon))
                        @foreach ($coupon as $v)
                        <?php $price_coupon += !empty($v['price']) ? $v['price'] : 0; ?>
                        <table>
                            <tr>
                                <th>{{trans('index.DiscountCode')}} : <span class="cart-coupon-name">{{$v['name']}}</span></th>
                                <td>-<span class="amount cart-coupon-price"><?php echo number_format($v['price']) . '₫' ?></span>
                                    <a href="javascript:void(0)" data-id="{{$v['id']}}" class="remove-coupon text-red-600 font-bold">[{{trans('index.Delete')}}]</a>
                                </td>
                            </tr>
                        </table>
                        @endforeach
                        @endif
                    </div>
                    <?php if (in_array('coupons', $dropdown)) { ?>
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
                                <input id="coupon_code" class="border border-solid border-gray-300 w-full px-5 mb-5 placeholder-current text-dark h-[46px] focus:outline-none text-base" placeholder="{{trans('index.EnterDiscountCode')}}" type="text">
                                <button type="button" id="apply_coupon" class="absolute top-0 right-0 h-[46px] inline-block bg-global leading-none py-4 px-2 text-sm text-white transition-all hover:bg-orange uppercase font-semibold hover:text-white tracking-[0.7px] ">{{trans('index.Apply')}}</button>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- END: mã giảm giá -->
                    <div class="flex justify-between pb-5">
                        <h3 class="text-xl font-medium">{{trans('index.TotalPrice')}}</h3>
                        <div class="text-xl font-medium cart-total-final">
                            <?php echo number_format($cart['total'] - $price_coupon) . '₫' ?>
                        </div>
                    </div>

                    <div class="pt-5 border-t">
                        <a href="{{route('cart.checkout')}}" class="bg-global w-full text-center inline-block bg-dark leading-none py-4 px-5 md:px-8 text-sm text-white transition-all hover:bg-orange uppercase font-semibold hover:text-white tracking-[0.7px] ">{{trans('index.Pay')}}</a>
                    </div>
                </div>
            </div>

        </div>
        <div>

        </div>
    </div>

    </div>
</main>

<style>
    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

@endsection

@push('css')
<link href="{{asset('frontend/css/app.css')}}" rel="stylesheet" async>
@endpush
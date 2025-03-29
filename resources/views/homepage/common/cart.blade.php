<div class="backdrop__body-backdrop___1rvky fixed opacity-0 w-full h-screen left-0 top-0 right-0 bottom-0 bg-[#363636] z-[999] invisible"></div>

<div id="offcanvas-cart" class="fixed w-[340px] top-0 bottom-0 bg-white overflow-hidden z-[9999] translate-x-full invisible right-0">

    <div class="p-4">

        <div class="flex flex-wrap justify-between items-center pb-6 mb-6 border-b border-solid border-gray-600">

            <h4 class="font-normal text-sm uppercase font-semibold">{{trans('index.Cart')}}</h4>

            <button class="offcanvas-close hover:text-green-500">

                <svg class="w-4 h-4 " viewBox="0 0 16 14">

                    <path d="M15 0L1 14m14 0L1 0" stroke="currentColor" fill="none" fill-rule="evenodd"></path>

                </svg>

            </button>

        </div>

        <div id="cart-show-header" class="flex justify-between flex-col" <?php if (empty($cart['cart'])) { ?> style="display: none;height: calc(100vh - 110px);" <?php } else { ?>style="height: calc(100vh - 110px);" <?php } ?>>

            <ul class="h-96 overflow-y-auto cart-html-header scrollbar max-h-screen flex-1">

                @if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0 )

                @foreach($cart['cart'] as $k=>$item)

                <?php

                echo htmlItemCartHeader($k, $item);

                ?>

                @endforeach

                @endif

            </ul>

            <div class="h-[234px] flex justify-end flex-col">

                <div class="flex flex-wrap justify-between items-center py-4 my-6 border-t border-b border-solid border-gray-600 font-normal text-base text-dark capitalize">

                    {{trans('index.TotalPrice')}}:<span class="cart-total"><?php echo !empty($cart['total']) ? number_format($cart['total'], 0, ',', '.') . '₫' : '' ?></span>

                </div>

                <div class="text-center">

                    <a class="py-3 px-10 block bg-black border border-solid border-gray-600 uppercase font-semibold text-base hover:bg-red-600 hover:border-red-600 text-white transition-all leading-none" href="{{route('cart.index')}}">{{trans('index.Cart')}}</a>

                    <a class="py-3 px-10 block bg-white border border-solid border-gray-600 uppercase font-semibold text-base hover:bg-red-600 hover:border-red-600  hover:text-white transition-all leading-none  mt-3" href="{{route('cart.checkout')}}">{{trans('index.Pay')}}</a>

                </div>

            </div>

        </div>

        <div id="cart-none-header" <?php if (!empty($cart['cart'])) { ?> style="display: none" <?php } ?>>

            <div class="flex flex-col items-center justify-center space-y-4 text-center">

                <span class="block text-sm text-gray-400">{{trans('index.ThereAreNo')}}</span>

            </div>

        </div>

    </div>

</div>

<!-- functions tp -->

<script src="{{asset('library/toastr/toastr.min.js')}}"></script>

<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">

<script src="{{asset('frontend/library/js/products.js')}}"></script>

<!-- end -->
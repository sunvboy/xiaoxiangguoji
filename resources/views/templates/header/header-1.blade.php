<?php
$menu_header = getMenus('menu-header');
?>
<header class="hidden lg:block">
    <div class="container py-1 mx-auto px-4">
        <div class="grid grid-cols-12 justify-between items-center gap-8">
            <div class="col-span-2">
                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
            </div>
            <div class="col-span-8 flex-1">
                <div class="border-b-[1px] text-f14 py-[5px] mb-[8px]">
                    <ul class="flex flex-wrap">
                        <li class="mr-[15px] space-x-1 flex items-center">
                            <i class="fa-solid fa-phone"></i> <a href="tel:{{$fcSystem['contact_hotline']}}">HOTLINE: {{$fcSystem['contact_hotline']}}</a>
                        </li>
                        <li class="mr-[15px] space-x-1 flex items-center">
                            <i class="fa-solid fa-envelope"></i><a href="mailto:{{$fcSystem['contact_email']}}">{{$fcSystem['contact_email']}}</a>
                        </li>
                    </ul>
                </div>
                <?php echo getHtmlMenus($menu_header, array(
                    'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                    'li' => 'text-center',
                    'a' => 'px-2 uppercase flex items-center',
                    'hover_color' => 'hover:text-red-600',
                    'ul_2' => '',
                    'li_2' => '',
                    'ul_3' => '',
                    'li_3' => '',
                )); ?>
            </div>
            <div class="col-span-2">
                <ul class="flex lg:flex-grow space-x-4 float-right">
                    <li class="relative">
                        <a href="javascript:void(0)" class="js-tp-search">
                            <div class="text-f20 text-center relative overflow-hidden">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <span class="lg:mt-0 hover:text-red-600"> Tìm kiếm </span>
                        </a>
                        <div class="js-header-search absolute right-0 top-full hidden text-left w-[500px] z-10 bg-white p-[5px]">
                            <h3 class="flex justify-between font-bold text-red-600 mb-2">
                                Tìm kiếm
                                <span class="js-btnCloseSearch cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                            </h3>
                            <?php echo getHtmlFormSearch(array(
                                'action' => route('homepage.search'),
                                'placeholder' => 'Tìm kiếm sản phẩm',
                                'classForm' => '',
                                'classInput' => '',
                                'classButton' => '',
                            )) ?>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="tp-cart">
                            <div class="text-f20 text-center relative">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white right-[6px] -top-[10px] text-center cart-quantity">{{$cart['quantity']}}</span>
                            </div>
                            <span class="lg:mt-0 hover:text-red-600"> Giỏ hàng </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@include('templates/header/header-mobile')
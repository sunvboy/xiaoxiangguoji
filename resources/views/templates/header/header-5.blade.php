<?php
$menu_header = getMenus('menu-header');
?>
<header class="hidden lg:block">
    <div class="container py-[5px] mx-auto px-4">
        <div class="grid grid-cols-12 items-center justify-between">
            <div class="col-span-3">
                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
            </div>
            <div class="col-span-6">
                <?php echo getHtmlFormSearch(array(
                    'action' => route('homepage.search'),
                    'placeholder' => 'Tìm kiếm sản phẩm',
                    'classForm' => '',
                    'classInput' => '',
                    'classButton' => 'bg-orangefac15   text-white',
                )) ?>
            </div>
            <div class="col-span-3">
                <ul class="flex lg:flex-grow space-x-4 float-right">
                    <li>
                        <a href="javascript:void(0)" class="">
                            <div class="relative text-f23 text-center text-black">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="lg:mt-2 hover:text-red-600">Đăng nhập</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="">
                            <div class="relative text-f23 text-center text-black">
                                <i class="fa-solid fa-heart"></i>
                                <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white right-[6px] -top-[10px] text-center">0</span>
                            </div>
                            <span class="lg:mt-2 hover:text-red-600">Yêu thích</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="tp-cart">
                            <div class="relative text-f23 text-center text-black">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white right-[6px] -top-[10px] text-center cart-quantity">0</span>
                            </div>
                            <span class="lg:mt-2 hover:text-red-600"> Giỏ hàng </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-menu bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="row flex flex-wrap justify-start">

                <?php echo getHtmlMenus($menu_header, array(
                    'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                    'li' => 'text-center',
                    'a' => 'inline-block px-[8px] uppercase text-black font-bold py-[10px]',
                    'hover_color' => 'hover:text-orangefac15',
                    'ul_2' => '',
                    'li_2' => '',
                    'ul_3' => '',
                    'li_3' => '',
                )); ?>
            </div>
        </div>
    </div>
</header>
@include('templates/header/header-mobile')
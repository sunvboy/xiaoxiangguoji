<?php
$menu_header = getMenus('menu-header');
?>
<header class="hidden lg:block">
    <div class="container py-[10px] mx-auto px-4">
        <div class="grid grid-cols-12 justify-between items-center">
            <div class="col-span-3">
                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
            </div>
            <div class="col-span-6 flex justify-center flex-1 space-x-5">
                <?php echo getHtmlFormSearch(array(
                    'action' => route('homepage.search'),
                    'placeholder' => 'Tìm kiếm sản phẩm',
                    'classForm' => 'relative w-3/4',
                    'classInput' => '',
                    'classButton' => 'bg-orangefa text-white',
                )) ?>
                <div class="flex w-1/4 items-center space-x-2">
                    <div class="icon text-[25px]">
                        <i class="fa-solid fa-mobile"></i>
                    </div>
                    <div class="nav-icon">
                        <p class="text-f15 leading-5">
                            Tư vấn hỗ trợ<br><a href="tel:{{$fcSystem['contact_hotline']}}" class="text-[#d61c1f] font-black">{{$fcSystem['contact_hotline']}}</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-3">
                <ul class="flex space-x-4 justify-end">
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
    <div class="main-menu bg-gray-200">
        <div class="container mx-auto px-3">
            <div class="row flex flex-wrap justify-start">
                <?php echo getHtmlMenus($menu_header, array(
                    'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                    'li' => 'text-center',
                    'a' => 'hover:text-orangefa inline-block px-[8px] font-medium text-black py-[10px]',
                    'hover_color' => 'hover:text-orangefa',
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
<?php
$menu_header = getMenus('menu-header');
?>
<header class="hidden lg:block py-5">
    <div class="container-fluid mx-auto px-4">
        <div class="grid grid-cols-12 items-center justify-between">
            <div class="col-span-2">
                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
            </div>
            <div class="col-span-8  flex flex-wrap justify-center">
                <div class="main-menu">
                    <div class="row flex flex-wrap justify-start">
                        <?php echo getHtmlMenus($menu_header, array(
                            'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                            'li' => 'text-center',
                            'a' => 'inline-block px-[8px] uppercase text-black font-bold py-[10px]',
                            'hover_color' => 'hover:text-red-600',
                            'ul_2' => '',
                            'li_2' => '',
                            'ul_3' => '',
                            'li_3' => '',
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <ul class="flex lg:flex-grow space-x-5 justify-end mr-4">
                    <li class="relative">
                        <a href="javscript:void(0)" class="js-tp-search">
                            <div class="tp-link-icon text-f20 text-center text-black">
                                <i class="fa-solid fa-magnifying-glass hover:text-red-300"></i>
                            </div>
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
                                'classButton' => 'text-red-600 hover:text-red-300',
                            )) ?>
                        </div>
                    </li>
                    <li>
                        <a href="javscript:void(0)">
                            <div class="tp-link-icon text-f20 text-center text-black">
                                <i class="fa-solid fa-user hover:text-red-300"></i>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="tp-cart">
                            <div class="relative text-f20 text-center text-black">
                                <i class="fa-solid fa-cart-shopping hover:text-red-300"></i>
                                <span class="absolute w-4 h-4 leading-4 rounded-full bg-[#d61c1f] text-[10px] text-white -right-2 -top-2 text-center cart-quantity">0</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@include('templates/header/header-mobile')
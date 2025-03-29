<?php
$menu_header = getMenus('menu-header');
?>
<header class="hidden lg:block">
    <div class="border-b bg-black">
        <div class="container py-1 mx-auto px-4">
            <div class="grid">
                <div class="navbar-collapse collapse grow items-center">
                    <ul class="navbar-nav mr-auto flex space-x-5">
                        <li class="">
                            <a class="text-white hover:text-red-600 transition duration-150 ease-in-out flex items-center space-x-1 text-f14" href="tel:{{$fcSystem['contact_hotline']}}">
                                <span class="w-[25px] h-[25px] flex justify-center items-center bg-[#dddddd] rounded-full flex-none">
                                    <i class="fa-solid fa-phone text-red-600"></i>

                                </span>
                                <span>{{$fcSystem['contact_hotline']}}</span>
                            </a>
                        </li>
                        <li class="">
                            <a class="text-white hover:text-red-600 transition duration-150 ease-in-out flex items-center space-x-1 text-f14" href="mailto:{{$fcSystem['contact_email']}}">
                                <span class="w-[25px] h-[25px] flex justify-center items-center bg-[#dddddd] rounded-full flex-none">
                                    <i class="fa-solid fa-envelope text-red-600"></i>
                                </span>
                                <span class="md:hidden lg:block">
                                    {{$fcSystem['contact_email']}}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="text-white hover:text-red-600 transition duration-150 ease-in-out flex items-center space-x-1 text-f14" href="javascript:void(0)">
                                <span class="w-[25px] h-[25px] flex justify-center items-center bg-[#dddddd] rounded-full flex-none">
                                    <i class="fa-solid fa-location-dot text-red-600"></i>
                                </span>
                                <span>{{$fcSystem['contact_address']}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div></div>
            </div>
        </div>
    </div>

    <div class="container py-4 mx-auto px-3">
        <div class="grid grid-cols-12 items-center justify-between">
            <div class="col-span-2">
                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
            </div>
            <div class="col-span-6">
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
            <div class="col-span-4">
                <ul class="flex justify-between items-center">
                    <li class="flex-1">
                        <?php echo getHtmlFormSearch(array(
                            'action' => route('homepage.search'),
                            'placeholder' => 'Tìm kiếm sản phẩm',
                            'classForm' => '',
                            'classInput' => '',
                            'classButton' => 'bg-blue_primary  text-white',
                        )) ?>
                    </li>
                    <li class="w-14">
                        <a href="javascript:void(0)" class="tp-cart relative flex justify-end">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white right-0 top-0 text-center cart-quantity">0</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@include('templates/header/header-mobile')
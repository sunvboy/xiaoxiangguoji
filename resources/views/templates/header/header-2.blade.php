 <?php
    $menu_header = getMenus('menu-header');
    ?>
 <header class="hidden lg:block">
     <div class="container py-[10px] mx-auto px-4">
         <div class="grid grid-cols-12 justify-between items-center">
             <div class="col-span-2">
                 <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
             </div>
             <div class="col-span-6 form-search flex-1">
                 <?php echo getHtmlFormSearch(array(
                        'action' => route('homepage.search'),
                        'placeholder' => 'Tìm kiếm sản phẩm',
                        'classForm' => '',
                        'classInput' => '',
                        'classButton' => 'bg-green_primary text-white',
                    )) ?>
             </div>
             <div class="col-span-4">
                 <ul class="flex justify-end space-x-4 ">
                     <li>
                         <a href="javascript:void(0)" class="space-x-2">
                             <div class="w-[40px] h-[40px] rounded-full top-0 right-0 bg-green_primary text-white text-center text-f20 leading-10 float-left">
                                 <i class="fa-solid fa-file-code"></i>
                             </div>
                             <span class="lg:mt-0 hover:text-green_primary inline-block float-right leading-5">Theo dõi<br />đơn hàng</span>
                         </a>
                     </li>
                     <li>
                         <a href="javascript:void(0)" class="space-x-2">
                             <div class="w-[40px] h-[40px] rounded-full top-0 right-0 bg-green_primary text-white text-center text-f20 leading-10 float-left">
                                 <i class="fa-solid fa-user"></i>
                             </div>
                             <span class="lg:mt-0 hover:text-green_primary inline-block float-right leading-5">Tài khoản<br /> của bạn</span>
                         </a>
                     </li>
                     <li>
                         <a href="javascript:void(0)" class="tp-cart">
                             <div class="w-[40px] h-[40px] rounded-full top-0 right-0 bg-green_primary text-white text-center text-f20 leading-10 float-left relative">
                                 <i class="fa-solid fa-cart-shopping"></i>
                                 <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white right-0 top-0 text-center cart-quantity">{{$cart['quantity']}}</span>
                             </div>
                         </a>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
     <div class="main-menu bg-green_primary ">
         <div class="container mx-auto px-3">
             <div class="row flex flex-wrap justify-start items-center">
                 <div class="w-1/4 hinden md:block">
                     <h3 class="text-f16 text-white uppercase font-bold cursor-pointer py-[10px]">
                         <i class="fa-solid fa-bars mr-[10px]"></i>Danh mục sản phẩm
                     </h3>
                 </div>
                 <div class="w-full md:w-3/4">
                     <?php echo getHtmlMenus($menu_header, array(
                            'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                            'li' => 'text-center',
                            'a' => 'inline-block px-[8px] uppercase text-white py-[10px]',
                            'hover_color' => 'hover:text-red-600',
                            'ul_2' => '',
                            'li_2' => '',
                            'ul_3' => '',
                            'li_3' => '',
                        )); ?>

                 </div>
             </div>
         </div>
     </div>
 </header>
 @include('templates/header/header-mobile')
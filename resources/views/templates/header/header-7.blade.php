 <?php
    $menu_header = getMenus('menu-header');
    ?>
 <header class="hidden lg:block">
     <div class="container py-3 px-4 mx-auto">
         <div class="grid grid-cols-12 items-center justify-between">
             <div class="col-span-3">
                 <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
             </div>
             <div class="col-span-5">
                 <?php echo getHtmlFormSearch(array(
                        'action' => route('homepage.search'),
                        'placeholder' => 'Tìm kiếm sản phẩm',
                        'classForm' => '',
                        'classInput' => '',
                        'classButton' => 'bg-redeb3   text-white',
                    )) ?>
             </div>

             <div class="col-span-4">
                 <ul class="flex justify-end space-x-7 items-center">
                     <li>
                         <a href="tel:{{$fcSystem['contact_hotline']}}" class="flex items-center space-x-2">
                             <i class="fa-solid fa-phone text-redeb3 text-f25"></i>
                             <span class="lg:mt-0 leading-5">
                                 Tư vấn hỗ trợ<br />
                                 <span class="text-redeb3 font-bold text-f17">{{$fcSystem['contact_hotline']}}</span>
                             </span>
                         </a>
                     </li>
                     <li>
                         <a href="javascript:void(0)" class="flex items-center space-x-2">
                             <i class="fa-solid fa-user text-redeb3 text-f25"></i>
                             <span class="lg:mt-0 hover:text-red-600 inline-block float-right leading-5">Xin chào!<br />
                                 <span class="text-redeb3 font-bold text-f17">Đăng nhập</span>
                             </span>
                         </a>
                     </li>
                     <li>
                         <a href="javscript:void(0)" class="tp-search">
                             <div class="relative">
                                 <i class="fa-solid fa-cart-shopping text-f25"></i>
                                 <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white -right-[6px] -top-[10px] text-center cart-quantity">0</span>
                             </div>
                         </a>
                     </li>

                 </ul>
             </div>
         </div>
     </div>
     <div class="main-menu bg-redeb3">
         <div class="container mx-auto px-4">
             <div class="row flex items-center justify-start">
                 <div class="w-1/4 hidden md:block">
                     <div class="relative">
                         <h3 class="click-category text-f16 text-white uppercase font-bold cursor-pointer py-[10px] flex items-center">
                             <i class="fa-solid fa-bars mr-[10px]"></i><span>Danh mục sản phẩm</span>
                         </h3>
                         <nav class="nav-category bg-gray-100 absolute left-0 w-full z-10 top-11" style="display:none ;">
                             <ul class="submenu">
                                 <?php for ($i = 0; $i < 6; $i++) { ?>
                                     <li class="group border-b-[1px] py-[4px] px-[5px]">
                                         <a class="inline-block w-full text-f14 hover:text-redeb3 transition-all font-bold" href="">
                                             <span class="">
                                                 <img src="http://tailwind.tamphat.edu.vn//theme/library/img/img_2/index-cate-icon-1.png" alt="" class="w-[36px] inline-block" />
                                             </span>
                                             Sữa và thực phẩm
                                             <span class="ar text-f12 float-right mt-[10px] mr-[3px]"><i class="fa-solid fa-angle-right"></i></span>
                                         </a>
                                         <div class="sub-menu2 absolute bg-white w-[883px] z-10 -top-[3px] left-full  h-screen group-hover:block hidden">
                                             <div class="grid grid-cols-3 justify-between border border-[#ddd] p-[15px] gap-4">
                                                 <?php for ($j = 0; $j < 6; $j++) { ?>
                                                     <div class="">
                                                         <h3 class="text-f16 font-bold mb-[5px]">
                                                             <a href="" class="hover:text-redeb3 font-extrabold ">THẾ GIỚI SỮA BỘT</a>
                                                         </h3>
                                                         <ul class="space-y-2">
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                             <li class="font-medium text-f15">
                                                                 <a href="" class="hover:text-redeb3">Sữa Meiji</a>
                                                             </li>
                                                         </ul>
                                                     </div>
                                                 <?php } ?>
                                             </div>
                                         </div>
                                     </li>
                                 <?php } ?>
                             </ul>
                         </nav>
                     </div>
                 </div>
                 <script>
                     $(".click-category").click(function() {
                         $(".nav-category").slideToggle();
                     });
                 </script>
                 <div class="w-full md:w-3/4">
                     <?php echo getHtmlMenus($menu_header, array(
                            'ul' => 'flex lg:flex-grow md:space-x-0 lg:space-x-4',
                            'li' => 'text-center',
                            'a' => 'inline-block px-[8px] font-medium text-white py-[10px]',
                            'hover_color' => '',
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
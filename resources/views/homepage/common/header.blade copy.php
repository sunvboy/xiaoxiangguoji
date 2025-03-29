 <?php $menu_header = getMenus('menu-header'); ?>
 <header>
     <div class="container mx-auto">
         <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-800">
             <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                 <a href="{{getUrlHome()}}" class="flex items-center">
                     <img src="{{asset($fcSystem['homepage_logo'])}}" class="mr-3 h-6 sm:h-9" alt="{{$fcSystem['homepage_company']}}" />
                     <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{$fcSystem['homepage_brandname']}}</span>
                 </a>
                 <div class="flex items-center lg:order-2">
                     @if(!empty(Auth::guard('customer')->user()))
                     <a href="{{route('customer.dashboard')}}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                         {{Auth::guard('customer')->user()->name}}
                     </a>
                     @else
                     <a href="{{route('customer.login')}}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                         Đăng nhập
                     </a>
                     @endif
                     <div class="flex items-center space-x-1 relative cursor-pointer tp-cart hover:text-red-500 cursor-pointer js_TPCart">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                         </svg>
                         <div>
                             <span class="font-bold">Giỏ hàng</span>
                         </div>
                         <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white -right-[10px] -top-[15px] text-center cart-quantity">{{$cart['quantity']}}</span>
                     </div>
                 </div>
                 <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                     <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                         @if(!empty($menu_header->menu_items) && count($menu_header->menu_items) > 0)
                         @foreach($menu_header->menu_items as $item)
                         <li>
                             <a href="{{url($item->slug)}}" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                 {{$item->title}}
                             </a>
                             <?php /* Menu cấp 2
                             @if(!empty($item->menu_items) && count($item->menu_items) > 0)
                             <ul>
                                 @foreach($item->menu_items as $child)
                                 <li>
                                     <a href="{{url($child->slug)}}" class="block">
                                         {{$child->title}}
                                     </a>
                                 </li>
                                 @endforeach
                             </ul>
                             @endif
                             */ ?>
                         </li>
                         @endforeach
                         @endif
                     </ul>
                 </div>
             </div>
         </nav>

     </div>
 </header>
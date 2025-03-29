 <?php
    $menu_footer = getMenus('menu-footer');
    ?>
 <footer class="pt-7 md:pt-11 wow fadeInUp mt-10 text-black bg-[#f7f7f7]">
     <div class="container mx-auto pl-3 pr-3">
         <div class="row -mx-3 flex flex-wrap justify-between">
             <div class="lg:w-2/5 md:w-2/5 sm:w-full w-full px-3">
                 <div class="item">
                     <h3 class="title-footer text-f16 font-bold transform text-black mb-3">
                         Chúng tôi là ai ?
                     </h3>
                     <div class="nav-item text-f14 text-white">
                         <p class="mb-[5px]">
                             <?php echo $fcSystem['homepage_aboutus'] ?>
                         </p>
                         <p class="mb-[5px]">
                             <strong><i class="fa-solid fa-location-dot mr-[5px]"></i>Địa chỉ: </strong>{{$fcSystem['contact_address']}}
                         </p>
                         <p class="mb-[5px]">
                             <strong><i class="fa-solid fa-phone mr-[5px]"></i>Điện thoại: </strong>{{$fcSystem['contact_hotline']}}
                         </p>
                         <p class="mb-[5px]">
                             <strong><i class="fa-solid fa-envelope mr-[5px]"></i>Email: </strong>{{$fcSystem['contact_email']}}
                         </p>
                     </div>
                     <div class="social-footer mt-[15px]">
                         <h3 class="title-footer text-f16 font-bold  text-black mb-3">
                             Mạng xã hội
                         </h3>
                         <ul class="flex flex-wrap">
                             <li><a href="{{$fcSystem['social_facebook']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-facebook-f"></i></a></li>
                             <li><a href="{{$fcSystem['social_instagram']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-instagram"></i></a></li>
                             <li><a href="{{$fcSystem['social_google_plus']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-google"></i></a></li>
                             <li><a href="{{$fcSystem['social_youtube']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-youtube"></i></a></li>
                         </ul>
                     </div>

                 </div>
             </div>

             <?php echo getHtmlMenusFooter($menu_footer, array(
                    'class' => 'lg:w-1/5 md:w-1/5 sm:w-full w-full px-3lg:w-1/5 md:w-1/5 sm:w-full w-full px-3',
                    'class_title' => 'title-footer text-f16 font-bold transform text-black mb-3',
                    'class_ul' => 'list-disc pl-[20px]',
                    'class_li' => 'text-black mb-1',
                    'class_a' => 'text-f15 text-black hover:text-red-600',
                )); ?>
         </div>

     </div>
     <div class="copy-right p-2 mt-7 bg-black">
         <div class="container mx-auto pl-3 pr-3">
             <p class="text-white text-center text-f15">
                 {{$fcSystem['homepage_copyright']}}
             </p>
         </div>

     </div>
     <style>
         footer p {
             color: black;
         }
     </style>
 </footer>
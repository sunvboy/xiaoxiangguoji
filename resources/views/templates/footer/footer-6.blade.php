<?php
$menu_footer = getMenus('menu-footer');
?>
<footer class="pt-7 md:pt-11 wow fadeInUp mt-10">
    <div class="container mx-auto pl-3 pr-3">
        <div class="flex flex-wrap justify-center">
            <div class="w-full md:w-1/2 mb-[30px]">
                <form action="" class="text-center relative">
                    <input type="text" placeholder="Email của bạn" class="w-full  h-[40px] border border-gray-400 bg-white pl-[10px]">
                    <input type="submit" value="Đăng ký" class="bg-black text-white h-[40px] px-[15px] uppercase border border-black transition-all hover:bg-white hover:text-black cursor-pointer absolute top-0 right-0">
                </form>
                <div class="social-footer mt-[20px]">

                    <ul class="flex flex-wrap justify-center">
                        <li class="text-f17 mr-[15px]">
                            <a href="{{$fcSystem['social_facebook']}}" target="_blank" class="inline-block  text-center mr-[5px] hover:text-red-600"><i class="fa-brands fa-facebook-f mr-[8px]"></i>Facebook</a>
                        </li>
                        <li class="text-f17 mr-[15px]">
                            <a href="{{$fcSystem['social_instagram']}}" target="_blank" class="inline-block  text-center mr-[5px] hover:text-red-600"><i class="fa-brands fa-instagram mr-[8px]"></i> Instagram</a>
                        </li>
                        <li class="text-f17 mr-[15px]">
                            <a href="{{$fcSystem['social_google_plus']}}" target="_blank" class="inline-block  text-center mr-[5px] hover:text-red-600"><i class="fa-brands fa-google mr-[8px]"></i> Google</a>
                        </li>
                        <li class="text-f17">
                            <a href="{{$fcSystem['social_youtube']}}" target="_blank" class="inline-block  text-center mr-[5px] hover:text-red-600"><i class="fa-brands fa-youtube mr-[8px]"></i> Youtube</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row -mx-3 flex flex-wrap justify-between">
            <div class="lg:w-2/6 md:w-2/6 sm:w-full w-full px-3">
                <div class="item">
                    <h3 class="title-footer text-f16 font-bold transform text-black mb-3 uppercase">
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

                </div>
            </div>

            <?php echo getHtmlMenusFooter($menu_footer, array(
                'class' => 'lg:w-1/6 md:w-1/6 sm:w-1/2 w-w-1/2 px-3',
                'class_title' => 'title-footer text-f16 font-bold transform text-black mb-3 uppercase',
                'class_ul' => 'list-disc pl-[20px]',
                'class_li' => 'text-black mb-1',
                'class_a' => 'text-f15 text-black hover:text-red-600',
            )); ?>
        </div>

    </div>
    <div class="copy-right border-t-[1px] p-2 mt-7 bg-[#e3e3e3]">
        <p class="text-black text-center text-f15">
            {{$fcSystem['homepage_copyright']}}
        </p>
    </div>
    <style>
        footer {
            background: #f2f2f2;
        }

        footer p {
            color: #000;
        }

        footer ul li a {
            color: #000;
        }

        footer ul li {
            color: #000;
        }
    </style>
</footer>
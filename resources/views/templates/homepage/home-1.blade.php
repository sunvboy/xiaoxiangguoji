@extends('homepage.layout.home')
@section('content')
<div id="slider-home" class="owl-carousel">
    <div class="item">
        <a href=""><img src="http://tailwind.tamphat.edu.vn//theme/library/img/slider_1.webp" alt="" /></a>
    </div>
    <div class="item">
        <a href=""><img src="http://tailwind.tamphat.edu.vn//theme/library/img/slider_1.webp" alt="" /></a>
    </div>
    <div class="item">
        <a href=""><img src="http://tailwind.tamphat.edu.vn//theme/library/img/slider_1.webp" alt="" /></a>
    </div>
</div>
<section class="top-content lg:pt-10 md:pt-10 sm:pt-5 pt-5 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="row flex flex-wrap justify-between lg:-mx-2 md:-mx-2 sm:-mx-1 -mx-1">
            <div class="lg:w-1/4 md:w-1/4 sm:w-1/2 w-1/2 lg:px-2 md:px-2 sm:px-1 px-1">
                <div class="flex flex-wrap border border-gray-100 lg:p-3 md:p-3 sm:p-[8px] p-[8px] rounded-[10px] justify-center lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <div class="icon w-full md:w-[36px] pl-0 md:pl-[10px] text-center">
                        <img src="../library/img/ser_1.webp" alt="" class="w-[36px] h-[36px] mt-[3px] inline-block" />
                    </div>
                    <div class="lg:pl-[10px] md:pl-[10px] sm:pl-[0px] pl-[0px] lg:mt-0 md:mt-0 sm:mt-[10px] mt-[10px]">
                        <p class="text-blue_primary lg:text-f15 md:text-f15 sm:text-f13 text-f13">
                            Vận chuyển MIỄN PHÍ<br />
                            Trong khu vực TP.HCM
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/4 sm:w-1/2 w-1/2 lg:px-2 md:px-2 sm:px-1 px-1">
                <div class="flex flex-wrap border border-gray-100 lg:p-3 md:p-3 sm:p-[8px] p-[8px] rounded-[10px] justify-center lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <div class="icon w-full md:w-[36px] pl-0 md:pl-[10px] text-center">
                        <img src="../library/img/ser_2.webp" alt="" class="w-[36px] h-[36px] mt-[3px] inline-block" />
                    </div>
                    <div class="lg:pl-[10px] md:pl-[10px] sm:pl-[0px] pl-[0px] lg:mt-0 md:mt-0 sm:mt-[10px] mt-[10px]">
                        <p class="text-blue_primary lg:text-f15 md:text-f15 sm:text-f13 text-f13">
                            Đổi trả MIỄN PHÍ<br />
                            Trong vòng 30 NGÀY
                        </p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 md:w-1/4 sm:w-1/2 w-1/2 lg:px-2 md:px-2 sm:px-1 px-1">
                <div class="flex flex-wrap border border-gray-100 lg:p-3 md:p-3 sm:p-[8px] p-[8px] rounded-[10px] justify-center lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <div class="icon w-full md:w-[36px] pl-0 md:pl-[10px] text-center">
                        <img src="../library/img/ser_3.webp" alt="" class="w-[36px] h-[36px] mt-[3px] inline-block" />
                    </div>
                    <div class="lg:pl-[10px] md:pl-[10px] sm:pl-[0px] pl-[0px] lg:mt-0 md:mt-0 sm:mt-[10px] mt-[10px]">
                        <p class="text-blue_primary lg:text-f15 md:text-f15 sm:text-f13 text-f13">
                            Đổi trả MIỄN PHÍ<br />
                            Trong vòng 30 NGÀY
                        </p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 md:w-1/4 sm:w-1/2 w-1/2 lg:px-2 md:px-2 sm:px-1 px-1">
                <div class="flex flex-wrap border border-gray-100 lg:p-3 md:p-3 sm:p-[8px] p-[8px] rounded-[10px] justify-center lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <div class="icon w-full md:w-[36px] pl-0 md:pl-[10px] text-center">
                        <img src="../library/img/ser_4.webp" alt="" class="w-[36px] h-[36px] mt-[3px] inline-block" />
                    </div>
                    <div class="lg:pl-[10px] md:pl-[10px] sm:pl-[0px] pl-[0px] lg:mt-0 md:mt-0 sm:mt-[10px] mt-[10px]">
                        <p class="text-blue_primary lg:text-f15 md:text-f15 sm:text-f13 text-f13">
                            Đổi trả MIỄN PHÍ<br />
                            Trong vòng 30 NGÀY
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="selling-products lg:pt-14 md:pt-10 sm:pt-7 pt-7 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <h2 class="title-primary text-center text-f25 font-bold text-blue_primary pb-[25px] relative">
            #Top Bán Chạy
        </h2>
        <div class="slider-product-selling owl-carousel lg:mt-8 md:mt-5 sm:mt-5 mt-5">
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all ">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img1.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                    <div class="productcount">
                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-home lg:mt-16 md:mt-10 sm:mt-7 mt-7 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="bg-yellow-400">
            <div class="mt-5 flex flex-wrap justify-center lg:overflow-visible md:overflow-visible sm:overflow-auto overflow-auto">
                <div data-tabopen="tab1" class="tabbtn cursor-pointer lg:px-3 md:px-3 sm:px-[5px] px-[5px] py-[10px] bg-red-700 font-medium text-white lg:w-1/4 md:w-1/4 sm:w-1/3 w-1/3 text-center rounded">
                    <span class="lg:text-f16 md:text-f15 sm:text-f14 text-f14 font-bold inline-block w-full">06:00 - 12:00</span>
                    <span class="lg:text-f15 md:text-f15 sm:text-f13 text-f13 inline-block w-full capitalize">Ðang diễn ra</span>
                </div>
                <div data-tabopen="tab2" class="tabbtn cursor-pointer lg:px-3 md:px-3 sm:px-[5px] px-[5px] py-[10px] lg:w-1/4 md:w-1/4 sm:w-1/3 w-1/3 text-center bg-white">
                    <span class="text-f16 font-bold inline-block w-full">12:00 - 20:00</span>
                    <span class="text-f15 inline-block w-full capitalize">Sắp diễn ra</span>
                </div>
                <div data-tabopen="tab3" class="tabbtn cursor-pointer lg:px-3 md:px-3 sm:px-[5px] px-[5px] py-[10px] lg:w-1/4 md:w-1/4 sm:w-1/3 w-1/3 text-center bg-white">
                    <span class="text-f16 font-bold inline-block w-full">20:00 - 24:00</span>
                    <span class="text-f15 inline-block w-full capitalize">Sắp diễn ra</span>
                </div>
                <div class="lg:w-1/4 md:w-1/4 sm:w-full w-full">
                    <h4 class="text-f14 text-center my-[10px]">
                        Thời gian khuyến mãi
                    </h4>
                    <div id="countdown">
                        <ul class="flex justify-center">
                            <li>
                                <span id="days" class="inline-block w-[36px] h-[26px] bg-red-700 text-white rounded-[6px] text-center mr-[10px]"></span>
                            </li>
                            <li>
                                <span id="hours" class="inline-block w-[36px] h-[26px] bg-red-700 text-white rounded-[6px] text-center mr-[10px]"></span>
                            </li>
                            <li>
                                <span id="minutes" class="inline-block w-[36px] h-[26px] bg-red-700 text-white rounded-[6px] text-center mr-[10px]"></span>
                            </li>
                            <li>
                                <span id="seconds" class="inline-block w-[36px] h-[26px] bg-red-700 text-white rounded-[6px] text-center"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="tab1" class="tab mt-1 items-center p-4">
                <div class="content-product-home">
                    <div class="row -mx-2 flex flex-wrap justify-between">
                        <div class="lg:w-1/5 md:w-1/2 sm:w-1/2 w-1/2">
                            <div class="item bg-white p-[10px]">
                                <div class="img relative">
                                    <img src="../library/img/img2.jpg" alt="" class="w-full object-cover" />
                                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                                    <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                                    </span>
                                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                        <ul class="flex">
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                                </div>
                                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                                </h3>
                                <div class="flex flex-wrap justify-between mt-[3px]">
                                    <div class="price">
                                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                                    </div>
                                    <div class="productcount">
                                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/5 md:w-1/2 sm:w-1/2 w-1/2">
                            <div class="item bg-white p-[10px]">
                                <div class="img relative">
                                    <img src="../library/img/img2.jpg" alt="" class="w-full object-cover" />
                                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                                    <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                                    </span>
                                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                        <ul class="flex">
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                                </div>
                                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                                </h3>
                                <div class="flex flex-wrap justify-between mt-[3px]">
                                    <div class="price">
                                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                                    </div>
                                    <div class="productcount">
                                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/5 md:w-1/2 sm:w-1/2 w-1/2">
                            <div class="item bg-white p-[10px]">
                                <div class="img relative">
                                    <img src="../library/img/img2.jpg" alt="" class="w-full object-cover" />
                                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                                    <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                                    </span>
                                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                        <ul class="flex">
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                                </div>
                                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                                </h3>
                                <div class="flex flex-wrap justify-between mt-[3px]">
                                    <div class="price">
                                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                                    </div>
                                    <div class="productcount">
                                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/5 md:w-1/2 sm:w-1/2 w-1/2">
                            <div class="item bg-white p-[10px]">
                                <div class="img relative">
                                    <img src="../library/img/img2.jpg" alt="" class="w-full object-cover" />
                                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                                    <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                                    </span>
                                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                        <ul class="flex">
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                                </div>
                                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                                </h3>
                                <div class="flex flex-wrap justify-between mt-[3px]">
                                    <div class="price">
                                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                                    </div>
                                    <div class="productcount">
                                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/5 md:w-1/2 sm:w-1/2 w-1/2">
                            <div class="item bg-white p-[10px]">
                                <div class="img relative">
                                    <img src="../library/img/img2.jpg" alt="" class="w-full object-cover" />
                                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                                    <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                                    </span>
                                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                        <ul class="flex">
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                            <li class="px-[4px]">
                                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                                </div>
                                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                                </h3>
                                <div class="flex flex-wrap justify-between mt-[3px]">
                                    <div class="price">
                                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                                    </div>
                                    <div class="productcount">
                                        <span class="bg-blue_primary text-f13 inline-block px-[10px] py-[3px] text-white rounded-[15px]">Đã bán 234</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab2" class="tab mt-1 items-center px-12 hidden">
                <p>Đang cập nhật</p>
            </div>

            <div id="tab3" class="tab mt-1 items-center px-12 hidden">
                <p>Đang cập nhật</p>
            </div>
        </div>
    </div>
</section>
<section class="categoruproduct lg:mt-16 md:mt-10 sm:mt-7 mt-7 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="row flex flex-wrap justify-between -mx-3">
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 px-3">
                <div class="item relative bg-blue_primary relative shadow-sm overflow-hidden lg:mb-0 md:mb-[10px] sm:mb-[10px] mb-[10px]">
                    <img src="../library/img/img3.jpg" alt="" class="w-full object-cover transition-all" />
                    <h3 class="lg:text-f25 md:text-f20 sm:text-f18 text-f18 top-1/2 left-[40px] right-[40px] absolute p-[7px] inline-block bg-blue_primary text-white text-center">
                        <a href="">#Men's</a>
                    </h3>
                </div>
            </div>
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 px-3">
                <div class="item relative bg-blue_primary relative shadow-sm overflow-hidden lg:mb-0 md:mb-[10px] sm:mb-[10px] mb-[10px]">
                    <img src="../library/img/img3.jpg" alt="" class="w-full object-cover transition-all" />
                    <h3 class="lg:text-f25 md:text-f20 sm:text-f18 text-f18 top-1/2 left-[40px] right-[40px] absolute p-[7px] inline-block bg-blue_primary text-white text-center">
                        <a href="">#Men's</a>
                    </h3>
                </div>
            </div>
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 px-3">
                <div class="item relative bg-blue_primary relative shadow-sm overflow-hidden lg:mb-0 md:mb-[10px] sm:mb-[10px] mb-[10px]">
                    <img src="../library/img/img3.jpg" alt="" class="w-full object-cover transition-all" />
                    <h3 class="lg:text-f25 md:text-f20 sm:text-f18 text-f18 top-1/2 left-[40px] right-[40px] absolute p-[7px] inline-block bg-blue_primary text-white text-center">
                        <a href="">#Men's</a>
                    </h3>
                </div>
            </div>
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 px-3">
                <div class="item relative bg-blue_primary relative shadow-sm overflow-hidden lg:mb-0 md:mb-[10px] sm:mb-[10px] mb-[10px]">
                    <img src="../library/img/img3.jpg" alt="" class="w-full object-cover transition-all" />
                    <h3 class="lg:text-f25 md:text-f20 sm:text-f18 text-f18 top-1/2 left-[40px] right-[40px] absolute p-[7px] inline-block bg-blue_primary text-white text-center">
                        <a href="">#Men's</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-thumbnail-home lg:mt-16 md:mt-10 sm:mt-7 mt-7 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <h2 class="title-primary text-center text-f25 font-bold text-blue_primary pb-[25px] relative">
            <span class="text-black">#Thời trang </span> Xu Hướng
        </h2>
        <div class="row flex flex-wrap justify-between -mx-3 lg:mt-8 md:mt-5 sm:mt-5 mt-5">
            <div class="w-1/4 hidden md:block px-3">
                <div class="img-category">
                    <a href=""><img src="../library/img/img4.jpg" alt="" class="w-full object-cover transition-all" /></a>
                </div>
            </div>
            <div class="lg:w-3/4 md:w-3/4 sm:w-full w-full px-3">
                <div class="slider-product-selling owl-carousel">
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img relative">
                            <img src="../library/img/img5.webp" alt="" class="w-full object-cover" />
                            <span class="absolute right-2 top-2 inline-block bg-red-500 px-[7px] py-[2px] text-f13 text-white">- 24%
                            </span>
                            <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                            <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                                <ul class="flex">
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                    <li class="px-[4px]">
                                        <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="" class="icon-video absolute bottom-[10px] left-[10px] z-10 text-gray-800"><i class="fa-solid fa-circle-play"></i></a>
                        </div>
                        <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold">
                            <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                        </h3>
                        <div class="flex flex-wrap justify-between mt-[3px]">
                            <div class="price">
                                <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-product border-t-[2px] border-gray-700 mt-[20px] pt-[20px]">
                    <ul class="flex flex-wrap justify-between">
                        <li class="flex relative w-1/3">
                            <div class="icon w-[32px] mt-[7px]">
                                <img src="../library/img/icon_1_allpro.png" alt="" class="w-[32px] h-[32px] border border-gray-700 rounded-full" />
                            </div>
                            <div class="nav-icon pl-[10px]">
                                <h4 class="text-f14 font-bold text-blue_primary">
                                    Thời trang Nam
                                </h4>
                                <p class="text-gray-700 text-f13">24 sản phẩm</p>
                            </div>
                        </li>
                        <li class="flex relative w-1/3">
                            <div class="icon w-[32px] mt-[7px]">
                                <img src="../library/img/icon_1_allpro.png" alt="" class="w-[32px] h-[32px] border border-gray-700 rounded-full" />
                            </div>
                            <div class="nav-icon pl-[10px]">
                                <h4 class="text-f14 font-bold text-blue_primary">
                                    Thời trang Nam
                                </h4>
                                <p class="text-gray-700 text-f13">24 sản phẩm</p>
                            </div>
                        </li>
                        <li class="flex relative w-1/3">
                            <div class="icon w-[32px] mt-[7px]">
                                <img src="../library/img/icon_1_allpro.png" alt="" class="w-[32px] h-[32px] border border-gray-700 rounded-full" />
                            </div>
                            <div class="nav-icon pl-[10px]">
                                <h4 class="text-f14 font-bold text-blue_primary">
                                    Thời trang Nam
                                </h4>
                                <p class="text-gray-700 text-f13">24 sản phẩm</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="banner-section mb-10 lg:mt-16 md:mt-10 sm:mt-8 mt-8 wow fadeInUp">
    <a href=""><img src="../library/img/bn1.png" alt="" class="w-full object-cover transition-all" /></a>
</section>
<section class="selling-products lg:pt-6 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <h2 class="title-primary text-center text-f25 font-bold text-blue_primary pb-[25px] relative">
            <span class="text-black">#Thời trang</span> Gyms
        </h2>
        <div class="slider-product-selling owl-carousel lg:mt-8 md:mt-5 sm:mt-5 mt-5">
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img5.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img5.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img5.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img5.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="img relative">
                    <img src="../library/img/img5.jpg" alt="" class="w-full object-cover" />
                    <div class="product_overlay_action absolute w-full h-full top-0 left-0 bg-blue-900 opacity-40 transition-all"></div>
                    <div class="product-wish absolute top-1/2 left-1/2 -translate-x-2/4 -translate-y-2/4 transition-all">
                        <ul class="flex">
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon1.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon2.png" alt="" class="w-[20px]" /></a>
                            </li>
                            <li class="px-[4px]">
                                <a href=""><img src="../library/img/icon3.png" alt="" class="w-[20px]" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-f15 h-[40px] overflow-hidden mt-[10px] font-bold font-bold">
                    <a href="">Áo cotton nữ cổ tròn dáng suông in chữ Trend</a>
                </h3>
                <div class="flex flex-wrap justify-between mt-[3px]">
                    <div class="price">
                        <span class="text-red-700 text-f16 font-bold">195.000₫</span><del class="text-gray-500 uppercase pl-[10px] text-f14">280.000₫</del>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-banner lg:mt-16 md:mt-10 sm:mt-6 mt-6 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="row -mx-3 flex flex-wrap justify-between">
            <div class="lg:w-1/3 md:w-1/3 sm:w-full w-full px-3">
                <div class="image lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <a href=""><img src="../library/img/img_3banner_1.webp" alt="" /></a>
                </div>
            </div>
            <div class="lg:w-1/3 md:w-1/3 sm:w-full w-full px-3">
                <div class="image lg:mb-0 md:mb-0 sm:mb-[10px] mb-[10px]">
                    <a href=""><img src="../library/img/img_3banner_2.webp" alt="" /></a>
                </div>
            </div>
            <div class="lg:w-1/3 md:w-1/3 sm:w-full w-full px-3">
                <div class="image">
                    <a href=""><img src="../library/img/img_3banner_3.webp" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="new-home lg:mt-16 md:mt-10 sm:mt-6 mt-6 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <h2 class="title-primary text-center text-f25 font-bold text-blue_primary pb-[25px] relative">
            <span class="text-black">#Tin tức</span> Thời Trang
        </h2>
        <div class="content-new-home mt-[20px]">
            <div class="slider-new owl-carousel">
                <div class="item">
                    <div class="img">
                        <a href=""><img src="../library/img/4-kieu-trang-phuc-demin-hot-nhat.webp" alt="" class="w-full transition-all" /></a>
                    </div>
                    <div class="content-img p-[10px] w-11/12 mx-auto -mt-6 bg-white rounded-[10px] relative">
                        <h3 class="text-f15 font-bold h-[40px] overflow-hidden">
                            <a href="" class="hover:text-blue_primary">4 kiểu trang phục denim đang hot nhất hack mọi độ tuổi
                                cho các nàng</a>
                        </h3>
                        <p class="date text-center mt-[10px] mb-[5px]">
                            <span class="bg-blue_primary text-white text-f13 px-[7px] py-[2px] rounded-[10px] relative z-10">05/04/2022</span>
                        </p>
                        <p class="text-f14 h-[60px] overflow-hidden mt-1">
                            Với 4 kiểu trang phục denim này, phong cách của chị em sẽ
                            được trẻ hóa. Khoảng thời gian từ xuân sang hè là vô cùng lý
                            tưởng để diện đồ denim. Kiểu trang phục này trẻ trung, bụi
                            bặm, rất hợp với không khí tươi vui của mùa ấm áp. Đồ denim
                            thì có nhiều biến tấu, dễ khiến chị em bị hoang mang, không
                            biết nên bổ sung thêm món nào cho tủ đồ....
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <a href=""><img src="../library/img/4-kieu-trang-phuc-demin-hot-nhat.webp" alt="" class="w-full transition-all" /></a>
                    </div>
                    <div class="content-img p-[10px] w-11/12 mx-auto -mt-6 bg-white rounded-[10px] relative">
                        <h3 class="text-f15 font-bold h-[40px] overflow-hidden">
                            <a href="" class="hover:text-blue_primary">4 kiểu trang phục denim đang hot nhất hack mọi độ tuổi
                                cho các nàng</a>
                        </h3>
                        <p class="date text-center mt-[10px] mb-[5px]">
                            <span class="bg-blue_primary text-white text-f13 px-[7px] py-[2px] rounded-[10px] relative z-10">05/04/2022</span>
                        </p>
                        <p class="text-f14 h-[60px] overflow-hidden mt-1">
                            Với 4 kiểu trang phục denim này, phong cách của chị em sẽ
                            được trẻ hóa. Khoảng thời gian từ xuân sang hè là vô cùng lý
                            tưởng để diện đồ denim. Kiểu trang phục này trẻ trung, bụi
                            bặm, rất hợp với không khí tươi vui của mùa ấm áp. Đồ denim
                            thì có nhiều biến tấu, dễ khiến chị em bị hoang mang, không
                            biết nên bổ sung thêm món nào cho tủ đồ....
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <a href=""><img src="../library/img/4-kieu-trang-phuc-demin-hot-nhat.webp" alt="" class="w-full transition-all" /></a>
                    </div>
                    <div class="content-img p-[10px] w-11/12 mx-auto -mt-6 bg-white rounded-[10px] relative">
                        <h3 class="text-f15 font-bold h-[40px] overflow-hidden">
                            <a href="" class="hover:text-blue_primary">4 kiểu trang phục denim đang hot nhất hack mọi độ tuổi
                                cho các nàng</a>
                        </h3>
                        <p class="date text-center mt-[10px] mb-[5px]">
                            <span class="bg-blue_primary text-white text-f13 px-[7px] py-[2px] rounded-[10px] relative z-10">05/04/2022</span>
                        </p>
                        <p class="text-f14 h-[60px] overflow-hidden mt-1">
                            Với 4 kiểu trang phục denim này, phong cách của chị em sẽ
                            được trẻ hóa. Khoảng thời gian từ xuân sang hè là vô cùng lý
                            tưởng để diện đồ denim. Kiểu trang phục này trẻ trung, bụi
                            bặm, rất hợp với không khí tươi vui của mùa ấm áp. Đồ denim
                            thì có nhiều biến tấu, dễ khiến chị em bị hoang mang, không
                            biết nên bổ sung thêm món nào cho tủ đồ....
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <a href=""><img src="../library/img/4-kieu-trang-phuc-demin-hot-nhat.webp" alt="" class="w-full transition-all" /></a>
                    </div>
                    <div class="content-img p-[10px] w-11/12 mx-auto -mt-6 bg-white rounded-[10px] relative">
                        <h3 class="text-f15 font-bold h-[40px] overflow-hidden">
                            <a href="" class="hover:text-blue_primary">4 kiểu trang phục denim đang hot nhất hack mọi độ tuổi
                                cho các nàng</a>
                        </h3>
                        <p class="date text-center mt-[10px] mb-[5px]">
                            <span class="bg-blue_primary text-white text-f13 px-[7px] py-[2px] rounded-[10px] relative z-10">05/04/2022</span>
                        </p>
                        <p class="text-f14 h-[60px] overflow-hidden mt-1">
                            Với 4 kiểu trang phục denim này, phong cách của chị em sẽ
                            được trẻ hóa. Khoảng thời gian từ xuân sang hè là vô cùng lý
                            tưởng để diện đồ denim. Kiểu trang phục này trẻ trung, bụi
                            bặm, rất hợp với không khí tươi vui của mùa ấm áp. Đồ denim
                            thì có nhiều biến tấu, dễ khiến chị em bị hoang mang, không
                            biết nên bổ sung thêm món nào cho tủ đồ....
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <a href=""><img src="../library/img/4-kieu-trang-phuc-demin-hot-nhat.webp" alt="" class="w-full transition-all" /></a>
                    </div>
                    <div class="content-img p-[10px] w-11/12 mx-auto -mt-6 bg-white rounded-[10px] relative">
                        <h3 class="text-f15 font-bold h-[40px] overflow-hidden">
                            <a href="" class="hover:text-blue_primary">4 kiểu trang phục denim đang hot nhất hack mọi độ tuổi
                                cho các nàng</a>
                        </h3>
                        <p class="date text-center mt-[10px] mb-[5px]">
                            <span class="bg-blue_primary text-white text-f13 px-[7px] py-[2px] rounded-[10px] relative z-10">05/04/2022</span>
                        </p>
                        <p class="text-f14 h-[60px] overflow-hidden mt-1">
                            Với 4 kiểu trang phục denim này, phong cách của chị em sẽ
                            được trẻ hóa. Khoảng thời gian từ xuân sang hè là vô cùng lý
                            tưởng để diện đồ denim. Kiểu trang phục này trẻ trung, bụi
                            bặm, rất hợp với không khí tươi vui của mùa ấm áp. Đồ denim
                            thì có nhiều biến tấu, dễ khiến chị em bị hoang mang, không
                            biết nên bổ sung thêm món nào cho tủ đồ....
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="BeanInstagram-home lg:mt-16 md:mt-10 sm:mt-6 mt-6 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="slider-BeanInstagram owl-carousel">
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
            <div class="item">
                <img src="../library/img/img_brand_1.webp" alt="" class="w-full" />
            </div>
        </div>
    </div>
</section>
@endsection
@push('css')
<link rel="stylesheet" href="{{asset('frontend/css/owl.theme.default.css')}}" />
<link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}" />
<style>
    .owl-prev {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    .owl-next {
        position: absolute;

        top: 50%;

        right: 0;

        transform: translateY(-50%);
    }

    .owl-nav>div {
        background-color: rgba(51, 51, 51, 0.6);
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        color: #fff;
    }

    .product-wish ul li img {
        width: 20px !important;
        display: inline-block;
        height: auto !important;
    }

    .product-wish ul li {
        width: 30px;
        height: 30px;
        display: inline-block;
        background: #fff;
        text-align: center;
        border-radius: 50%;
        margin: 0 3px;
    }

    .slider-product-selling .item .product_overlay_action {
        visibility: hidden;
        opacity: 0;
    }

    .slider-product-selling .item:hover .product_overlay_action {
        visibility: visible;
        opacity: 0.4;
    }

    .slider-product-selling .item .product-wish {
        visibility: hidden;
        opacity: 0;
    }

    .slider-product-selling .item:hover .product-wish {
        visibility: visible;
        opacity: 1;
    }

    .content-product-home .item .product_overlay_action {
        visibility: hidden;
        opacity: 0;
    }

    .content-product-home .item:hover .product_overlay_action {
        visibility: visible;
        opacity: 0.4;
    }

    .content-product-home .item .product-wish {
        visibility: hidden;
        opacity: 0;
    }

    .content-product-home .item:hover .product-wish {
        visibility: visible;
        opacity: 1;
    }

    .categoruproduct .item::before {
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        content: "";
        background: #fff;
        position: absolute;
        -webkit-transform: skew(-10deg) rotate(-10deg) translateY(-50%);
        transform: skew(-10deg) rotate(-10deg) translateY(-50%);
        visibility: hidden;
        opacity: 0;
    }

    .categoruproduct .item:hover::before {
        visibility: visible;
        opacity: 1;
    }

    .categoruproduct .item:hover img {
        opacity: 0.3;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .categoruproduct .item h3 {
        -webkit-transform: skew(-10deg) rotate(-10deg) translateY(-50%);
        transform: skew(-10deg) rotate(-10deg) translateY(-50%);
    }

    .categoruproduct .item:hover img {
        -webkit-transform: scale(1.03);
        -ms-transform: scale(1.03);
        transform: scale(1.03);
    }

    .tab-product ul li::before {
        content: "";
        width: 16px;
        height: 16px;
        position: absolute;
        left: 12px;
        top: -29px;
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        border: 2px #014566 solid;
        border-width: 0 2px 2px 0;
        background: #fff;
    }

    .new-home .item .content-img {
        box-shadow: 0px 4px 8px -2px #7aa5bb;
    }

    .new-home .item .date {
        position: relative;
    }

    .new-home .item .date:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 1px;
        background-color: #7aa5bb;
        top: 50%;
        left: 0;
        right: 0;
        bottom: 50%;
    }

    .slider-new .owl-stage-outer {
        padding-bottom: 10px;
    }

    .BeanInstagram-home .item {
        position: relative;
    }


    img {
        -webkit-transition: all 0.7s ease;
        transition: all 0.7s ease;
    }

    .slider-product-selling .item .img:hover img {
        -webkit-transform: scale(1.03);
        -ms-transform: scale(1.03);
        transform: scale(1.03);
    }

    .slider-product-selling .item .img {
        overflow: hidden;
    }

    .product-home .item .img:hover img {
        -webkit-transform: scale(1.03);
        -ms-transform: scale(1.03);
        transform: scale(1.03);
    }

    .product-home .item .img {
        overflow: hidden;
    }

    .slider-new .item .img:hover img {
        -webkit-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }

    .slider-new .item .img img {
        height: 200px;
        object-fit: cover;
    }

    .slider-new .item .img {
        overflow: hidden;
    }

    .slider-BeanInstagram .item:hover img {
        -webkit-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }

    .slider-BeanInstagram .item {
        overflow: hidden;
    }

    .slider-product-selling .item .img img {
        height: 400px;
    }

    .product-home .item .img img {
        height: 300px;
    }

    .categoruproduct .item img {
        height: 415px;
    }

    footer .item .item-1 img {
        height: 70px;
        width: 100%;
        object-fit: cover;
    }

    .product-thumbnail-home .slider-product-selling .item .img img {
        height: 300px;
    }

    @media only screen and (max-width: 1024px) {
        header .right-header ul li span {
            display: none;
        }
    }

    @media only screen and (max-width: 736px) {
        .slider-product-selling .item .img img {
            height: 220px;
        }

        .product-home .item .img img {
            height: 190px;
        }

        .categoruproduct .item img {
            height: 215px;
        }

        .slider-new .item .img img {
            height: 150px;
        }

        .product-thumbnail-home .slider-product-selling .item .img img {
            height: 220px;
        }
    }
</style>
@endpush
@push('javascript')
<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
<script>
    $("#slider-home").owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed: 1500,
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>',
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });
    $(".slider-product-selling").owlCarousel({
        loop: true,
        margin: 20,
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>',
        ],
        nav: true,
        responsive: {
            0: {
                items: 2,
                margin: 10,
            },
            600: {
                items: 3,
                margin: 10,
            },
            1000: {
                items: 4,
            },
        },
    });
    $(".slider-new").owlCarousel({
        loop: true,
        margin: 20,
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>',
        ],
        nav: true,
        responsive: {
            0: {
                items: 2,
                margin: 10,
            },
            600: {
                items: 3,
                margin: 10,
            },
            1000: {
                items: 4,
            },
        },
    });
    $(".slider-BeanInstagram").owlCarousel({
        loop: true,
        margin: 20,
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>',
        ],
        nav: true,
        responsive: {
            0: {
                items: 2,
                margin: 10,
            },
            600: {
                items: 3,
                margin: 10,
            },
            1000: {
                items: 5,
            },
        },
    });
</script>
@endpush
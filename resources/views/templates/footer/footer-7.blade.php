<?php
$menu_footer = getMenus('menu-footer');
?>
<footer class="pt-14 wow fadeInUp mt-10">
    <div class="container mx-auto pl-3 pr-3">
        <div class="row -mx-3 flex flex-wrap justify-between">
            <div class="lg:w-1/4 md:w-1/4 sm:w-full w-full px-3">
                <div class="item">
                    <h3 class="title-footer text-f16 font-bold transform text-white mb-3">
                        THÔNG TIN CHUNG
                    </h3>
                    <div class="nav-item text-f14 text-white">
                        <p class="mb-[5px]">
                            <?php echo $fcSystem['homepage_aboutus'] ?>
                        </p>
                        <p class="mb-[5px]">
                            <strong><i class="fa-solid fa-location-dot mr-[5px]"></i>Địa chỉ: </strong>{{$fcSystem['contact_address']}}
                        </p>
                        <p class="mb-[5px]">
                            <strong><i class="fa-solid fa-phone mr-[5px]"></i>Điện thoại: </strong> {{$fcSystem['contact_hotline']}}
                        </p>
                        <p class="mb-[5px]">
                            <strong><i class="fa-solid fa-envelope mr-[5px]"></i>Email: </strong>{{$fcSystem['contact_email']}}
                        </p>
                    </div>
                </div>
            </div>
            <?php echo getHtmlMenusFooter($menu_footer, array(
                'class' => 'lg:w-1/4 md:w-1/4 sm:w-1/2 w-1/2 px-3',
                'class_title' => 'title-footer text-f16 font-bold transform text-white mb-3',
                'class_ul' => 'list-disc pl-[20px]',
                'class_li' => 'text-white mb-1',
                'class_a' => 'text-f15 text-white',
            )); ?>
        </div>
        <div class="copy-right border-t-[1px] p-2 mt-7">
            <p class="text-white text-center text-f15">
                {{$fcSystem['homepage_copyright']}}
            </p>
        </div>
    </div>
    <style>
        footer {
            background: #24272e;
        }
    </style>
</footer>
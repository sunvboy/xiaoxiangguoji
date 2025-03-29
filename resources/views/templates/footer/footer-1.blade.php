<?php
$menu_footer = getMenus('menu-footer');
?>
<footer class="bg-blue_primary pt-12 lg:mt-16 md:mt-10 sm:mt-6 mt-6 wow fadeInUp">
    <div class="container mx-auto pl-3 pr-3">
        <div class="row -mx-3 flex flex-wrap justify-between">
            <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3">
                <div class="row -mx-3 flex flex-wrap justify-between">
                    <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3">
                        <div class="item">
                            <h3 class="title-footer text-f16 font-bold transform text-white mb-3">
                                THÔNG TIN CHUNG
                            </h3>
                            <div class="nav-item text-f14 text-white">
                                <p class="mb-[5px]">
                                    <?php echo $fcSystem['homepage_aboutus'] ?>
                                </p>
                                <p class="mb-[5px]">
                                    <strong>Địa chỉ: </strong>{{$fcSystem['contact_address']}}
                                </p>
                                <p class="mb-[5px]">
                                    <strong>Điện thoại: </strong> {{$fcSystem['contact_hotline']}}
                                </p>
                                <p class="mb-[5px]">
                                    <strong>Email: </strong> {{$fcSystem['contact_email']}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                    $news = \App\Models\Article::select('id', 'title', 'slug', 'image', 'created_at')->where(['alanguage' => config('app.locale'), 'publish' => 0])->limit(3)->get();
                    ?>
                    @if(!$news->isEmpty())
                    <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3">
                        <div class="item">
                            <h3 class="title-footer text-f16 font-bold transform text-white mb-3">
                                BÀI VIẾT MỚI
                            </h3>
                            <div class="nav-item text-f14 text-white">
                                @foreach($news as $key=>$item)
                                <div class="item-1 flex flex-wrap justify-between <?php if ($key + 1 < count($news)) { ?>border-b-[1px] pb-[10px] mb-[10px]<?php } ?>">
                                    <div class="img w-1/3">
                                        <a href="{{route('routerURL',['slug' => $item->slug])}}">
                                            <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full transition-all" />
                                        </a>
                                    </div>
                                    <div class="nav-img w-2/3 pl-[10px]">
                                        <h3 class="text-f15 h-[40px] overflow-hidden">
                                            <a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a>
                                        </h3>
                                        <p class="date italic text-f13 text-white">
                                            {{$item->created_at}}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3">
                <div class="row flex flex-wrap justify-between -mx-3">
                    <?php echo getHtmlMenusFooter($menu_footer, array(
                        'class' => 'lg:w-1/3 md:w-1/3 sm:w-1/2 w-1/2 px-3 lg:mt-0 md:mt-0 sm:mt-[15px] mt-[15px]',
                        'class_title' => 'title-footer text-f16 font-bold transform text-white mb-3',
                        'class_ul' => 'list-disc pl-[20px]',
                        'class_li' => 'text-white mb-1',
                        'class_a' => 'text-f15 text-white',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="copy-right border-t-[1px] p-2 mt-7">
            <p class="text-white text-center text-f15">
                {{$fcSystem['homepage_copyright']}}
            </p>
        </div>
    </div>
</footer>
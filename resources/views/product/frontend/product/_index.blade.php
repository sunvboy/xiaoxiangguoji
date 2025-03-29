@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('',$breadcrumb)!!}
<main id="main" class="py-7 space-y-10">
    <!-- start: box 5 -->
    <div class="content-product-detail pt-[10px] md:pt-[40px]">
        <div class="container mx-auto px-4 md:px-0">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 -mx-[15px]">
                <div class="md:col-span-2 lg:col-span-3 px-[15px]">
                    @include('product.frontend.product.common.detail')
                    <div class="">
                        <div class="mt-[10px] md:mt-[35px]">
                            <ul class="ulTabProduct flex border-b border-gray-300 space-x-10">
                                <li class="text-f15 md:text-f18 text-gray-600 tab-link font-bold uppercase pb-[10px] relative cursor-pointer js_tabProduct current" data-tab="tab-1">
                                    {{trans('index.ProductInformation')}}
                                </li>
                                <li class="text-f15 md:text-f18 text-gray-600 tab-link font-bold uppercase pb-[10px] relative cursor-pointer js_tabProduct" data-tab="tab-2">
                                    Video
                                </li>
                                <li class="text-f15 md:text-f18 text-gray-600 tab-link font-bold uppercase pb-[10px] relative cursor-pointer js_tabProduct" data-tab="tab-3">
                                    {{trans('index.Comment')}}
                                </li>
                            </ul>
                        </div>
                        <div id="tab-1" class="tab-content current">
                            <div class="content-new-home mt-[20px] md:mt-[30px] box_content">
                                <?php echo $detail->content ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content hidden">
                            <div class="box_content pt-5">
                                <?php echo !empty($fields['config_colums_editor_video']) ? $fields['config_colums_editor_video'] : ''; ?>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-content hidden">
                            @include('product.frontend.product.comment.index')
                        </div>
                    </div>
                </div>
                <div class="col-span-1 px-[15px] mt-5 lg:mt-0">
                    <h2 class="titleH2 text-global text-lg uppercase hover:text-primary font-bold ">
                        <a href="javascript:void(0)" class="relative">
                            Sản phẩm ngẫu nhiên
                        </a>
                    </h2>
                    <div class="mt-5 grid grid-cols-2 md:grid-cols-1 -mx-[15px]">
                        @if(count($ishomeProduct) > 0)
                        @foreach($ishomeProduct as $key=>$item)
                        <?php echo htmlItemProduct($key, $item); ?>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: box 5 -->
    @if(count($productSame) > 0)
    <section>
        <div class="container mx-auto px-4 md:px-0">
            <h2 class="titleH2 text-global text-2xl hover:text-primary font-bold border-b border-gray-300 ">
                <a href="javascript:void(0)" class="relative">
                    {{trans('index.RelatedProducts')}}
                </a>
            </h2>
            <div class="mt-5 -mx-[15px]">
                <div class="slider-product owl-carousel">
                    @foreach ($productSame as $key=>$item)
                    <div class="item">
                        <?php echo htmlItemProduct($key, $item); ?>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    @endif
    @include('homepage.common.recently')
</main>
@endsection
@push('css')
<link rel="stylesheet" href="{{asset('frontend/css/swiper-bundle.min.css')}}" />
@endpush
@push('javascript')
<script src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script>
<script>
    const sliderThumbs = new Swiper(".slider__thumbs .swiper-container", {
        direction: "horizontal",
        slidesPerView: 5,
        spaceBetween: 10,
        hashNavigation: {
            watchState: true,
        },
        navigation: {
            nextEl: ".slider__next",
            prevEl: ".slider__prev",
        },
        freeMode: true,
        breakpoints: {
            0: {
                direction: "horizontal",
                slidesPerView: 3,
            },
            768: {
                direction: "horizontal",
                slidesPerView: 4,
            },
        },
    });
    const sliderImages = new Swiper(".slider__images .swiper-container", {
        direction: "horizontal",
        slidesPerView: 1,
        spaceBetween: 0,
        mousewheel: true,
        hashNavigation: {
            watchState: true,
        },
        navigation: {
            nextEl: ".slider__next",
            prevEl: ".slider__prev",
        },
        grabCursor: true,
        thumbs: {
            swiper: sliderThumbs,
        },
        breakpoints: {
            0: {
                direction: "horizontal",
            },
            768: {
                direction: "horizontal",
            },
        },
    });
</script>
@endpush
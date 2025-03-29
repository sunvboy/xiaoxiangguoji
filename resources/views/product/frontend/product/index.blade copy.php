@extends('homepage.layout.home')
@section('content')
<?php
$listAlbums = json_decode($detail->image_json, true);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
if (count($detail->product_versions) > 0) {
    $type = 'variable';
} else {
    $type = 'simple';
}

$version = json_decode(base64_decode($detail['version_json']), true);
$attribute_tmp = [];
$attributesID =  [];
if (!empty($version) && !empty($version[2])) {
    foreach ($version[2] as $item) {
        foreach ($item as $val) {
            $attributesID[] = $val;
        }
    }
    if (!empty($attributesID)) {
        $attribute_tmp = \App\Models\Attribute::whereIn('id', $attributesID)->select('id', 'title', 'catalogueid')->with('catalogue')->get();
    }
}
$attributes = [];
if (!empty($attribute_tmp)) {
    foreach ($attribute_tmp as $item) {
        $attributes[] = array(
            'id' => $item->id,
            'title' => $item->title,
            'titleC' => $item->catalogue->title,
        );
    }
}
$attributes = collect($attributes)->groupBy('titleC')->all();
?>
<input type="hidden" value="<?php echo $detail->id ?>" id="detailProductID">
<nav class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-blue font-bold">Trang chủ</a></li>
                @foreach($breadcrumb as $k=>$v)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                @endforeach
            </ol>
        </nav>
        <div>
            <a href="javascript:void(0)" class="tp-cart">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </a>
        </div>
    </div>
</nav>
<main class="py-0 md:py-8">
    <div class=" container mx-auto">
        <section class="<?php if (svl_ismobile() == 'is desktop') { ?>flex gap-10<?php } else { ?>grid grid-cols-1<?php } ?>  mt-4 ">
            <div class="<?php if (svl_ismobile() == 'is desktop') { ?>flex-1 w-[670px] gap-6 flex flex-col<?php } ?> order-1 lg:order-0">
                <!-- START: slide images product PC-->
                <?php if (svl_ismobile() == 'is desktop') { ?>
                    <div class="desktopSlide hidden md:block">
                        <div class="overflow-hidden p-6 flex bg-white shadow rounded-2xl ">
                            @if(!empty($listAlbums))
                            <div thumbsSlider="" class="swiper mySwiper mySwiper" style="width:80px; margin-right: 16px;height: 538px;">
                                <div class="swiper-wrapper">
                                    @foreach($listAlbums as $key=>$item)
                                    <div class="swiper-slide ">
                                        <img src="{{$item}}" alt="{{$detail->title}}" />
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 mySwiper2 flex-1 ml-4 overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach($listAlbums as $key=>$item)
                                    <div class="swiper-slide ">
                                        <img src="{{$item}}" alt="{{$detail->title}}" class="w-full object-cover h-full" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                <?php } ?>
                <!-- Swiper JS -->

                <!-- END: slide product image PC-->
                <div class="px-4 pb-6 bg-white md:shadow md:rounded-2xl">
                    <section class="section-description mt-6">
                        <div class="flex flex-wrap items-center space-x-2">
                            <h3 class="changeActiveTab uppercase font-medium cursor-pointer  tab-1 px-3 py-2 mb-2 inline-block mr-2 active" onclick="changeActiveTab(event,'tab-1')">Thông tin sản phẩm</h3>
                            <h3 class="changeActiveTab uppercase font-medium cursor-pointer  tab-2 px-3 py-2 mb-2 inline-block mr-2 " onclick="changeActiveTab(event,'tab-2')">Bảng size</h3>

                        </div>
                        <div class="content-detail-product mt-4 relative overflow-hidden tab-content">
                            <div class="space-y-2 tab" id="tab-1">
                                <?php echo $detail->content ?>
                            </div>
                            <div class="space-y-2 tab hidden" id="tab-2">
                            </div>

                        </div>

                    </section>
                    <!-- START: đánh giá sản phẩm -->
                    @include('product.frontend.product.comment.index')
                    <!-- END: đánh giá sản phẩm -->
                </div>
            </div>

            <div class="order-0 lg:order-1 box_product_detail bg-white  <?php if (svl_ismobile() == 'is desktop') { ?>shadow rounded-2xl sticky overflow-hidden right-0 bottom-0 left-0 h-full top-[20px]<?php } ?>">
                <!-- START: slide product image mobile and table -->
                <?php if (svl_ismobile() == 'is mobile' || svl_ismobile() == 'is tablet') { ?>
                    <div class="block lg:hidden">
                        <div class="overflow-hidden ">
                            @if(!empty($listAlbums))
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 flex-1 ml-4 overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach($listAlbums as $key=>$item)
                                    <div class="swiper-slide ">
                                        <img src="{{$item}}" alt="{{$detail->title}}" class="w-full object-cover h-full" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper mt-2">
                                <div class="swiper-wrapper">
                                    @foreach($listAlbums as $key=>$item)
                                    <div class="swiper-slide ">
                                        <img src="{{$item}}" alt="{{$detail->title}}" />
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            @endif
                        </div>
                    </div>

                <?php } ?>
                <!-- END-->
                <div class="flex-1 overflow-auto p-4">
                    <div class="flex flex-col space-y-4">
                        <div class="flex flex-col space-y-3">
                            <div class="flex flex-col">
                                <h1 class="font-semibold text-2xl">{{$detail->title}}</h1>
                                <div class="section-subtitle flex text-gray-20 mt-1 flex-wrap divide">
                                    <span class="mr-3 text-ui">
                                        CODE: <span class="js_product_code text-d61c1f">{{$detail->code}}</span>
                                    </span>
                                    @if($brand)
                                    <span class="mr-3 text-ui">
                                        Thương hiệu: <a href="{{route('brandURL',['slug' => $brand->slug])}}" class=" text-d61c1f">{{$brand->title}}</a>
                                    </span>
                                    @endif
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <a href="javascript:void(0)" class="text-blue-400 cursor-pointer scrollCmt">
                                                {{$comment_view['totalComment']}} đánh giá
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="text-red-600 text-2xl font-extrabold js_product_price_final">
                                        {{$price['price_final']}}
                                    </span>
                                    <div class="ml-2">
                                        <span class="line-through text-lg js_product_price_old">
                                            {{$price['price_old']}}
                                        </span>

                                        <span class="text-2xl text-red-600 ml-1 js_product_percent">
                                            @if(!empty($price['percent']))
                                            -{{$price['percent']}}
                                            @endif
                                        </span>

                                    </div>
                                </div>
                            </div>
                            @if($detail->description)
                            <div class="bg-red-50 rounded-lg px-4 py-3">
                                <?php echo $detail->description ?>
                            </div>
                            @endif
                        </div>

                    </div>
                    <div class="mt-3">
                        <!--START: product version -->
                        <?php if ($type == 'variable' && !empty($attributes)) { ?>
                            <?php $i = 0;
                            foreach ($attributes as $key => $item) {
                                $i++;
                            ?>
                                <?php if (count($item) > 0) { ?>
                                    <div class="box-variable mb-3">
                                        <div class="font-bold text-base mb-1">{{$key}}</div>
                                        <div class="flex flex-wrap space-x-2">
                                            <?php foreach ($item as $k => $val) { ?>
                                                <a href="javascript:void(0)" class="js_item_variable js_item_variable_{{$val['id']}} py-1 px-5 border 
                                                <?php if ($k == 0) { ?>checked<?php } ?> " data-id="{{$val['id']}}" data-stt="<?php echo !empty($i == count($attributes)) ? 1 : 0 ?>">
                                                    {{$val['title']}}
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php
                            } ?>
                        <?php } ?>
                        <?php if ($type == 'simple') { ?>
                            <?php
                            $hiddenAddToCart = 0;
                            $product_stock_title = '';
                            $quantityStock = '';
                            if ($detail->inventory == 1) {
                                if ($detail->inventoryPolicy == 0) {
                                    if ($detail->inventoryQuantity == 0) {
                                        $hiddenAddToCart = 1;
                                        $product_stock_title =  '<span class="product_stock">Hết hàng</span>';
                                    } else {
                                        $quantityStock = $detail->inventoryQuantity;
                                        $product_stock_title = '<span class="product_stock">' . $detail->inventoryQuantity . '</span> sản phẩm có sẵn';
                                    }
                                } else {
                                    $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                                }
                            } else {
                                $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                            }
                            ?>
                        <?php } ?>
                        <!--END: product version -->
                    </div>
                    <div class="product-details w-full py-4 ">
                        <div class="font-black mb-2">Số lượng</div>
                        <div class="flex items-center">
                            <div class="custom-number-input h-10 w-32 flex flex-row rounded-lg relative bg-transparent mt-1">
                                <button class="card-dec bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none flex items-center justify-center">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number" max="{{!empty($quantityStock)?$quantityStock:''}}" class="card-quantity outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none" name="custom-input-number" value="1"></input>
                                <button class="card-inc bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer flex items-center justify-center">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>
                            </div>
                            <div class="ml-2 text-red-600 font-bold">
                                @if($type == 'simple')
                                <?php
                                echo $product_stock_title;
                                ?>
                                @else
                                <span class="js_product_stock">sản phẩm có sẵn</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 flex items-center w-full space-x-2">
                            <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="0" data-src="" data-type="{{$type}}" class="addtocart uppercase font-black h-12 w-1/2 text-white bg-red-600 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                Thêm vào giỏ
                            </button>
                            <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="1" data-src="" data-type="{{$type}}" class="addtocart uppercase font-black h-12 w-1/2 text-white bg-black flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                mua ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-10">
            <h2 class="font-bold text-2xl mb-5">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($productSame as $key=>$item)
                <div class="">
                    <?php echo htmlItemProduct($k, $item); ?>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</main>
@endsection

@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('',$breadcrumb)!!}
<main id="main" class="py-7 space-y-10">
    <!-- start: box 5 -->
    <div class="content-product-detail pt-[10px] md:pt-[40px]">
        <div class="container mx-auto px-4 md:px-0">
            <div class="grid grid-cols-1 -mx-[15px]">
                <div class="px-[15px]">
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
@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('',$breadcrumb)!!}
<?php
$listAlbums = json_decode($detail->image_json, true);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
if (count($detail->product_versions) > 0) {
    $type = 'variable';
} else {
    $type = 'simple';
}
$version = json_decode(base64_decode($detail->version_json), true);
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
<?php if ($type == 'simple') { ?>
    <?php
    $hiddenAddToCart = 0;
    $quantityStock = '';
    $simpleStock = $detail->product_stocks->sum('value');
    if ($detail->inventory == 1) {
        if ($detail->inventoryPolicy == 0) {
            if ($simpleStock == 0) {
                $hiddenAddToCart = 1;
                $product_stock_title =  '<span class="product_stock">' . trans('index.OutOfStock') . '</span>';
            } else {
                $quantityStock = $simpleStock;
                $product_stock_title = '<span class="product_stock">' . $simpleStock . '</span> ' . trans('index.InOfStock');
            }
        } else {
            $product_stock_title = '<span class="product_stock"></span> ' . trans('index.InOfStock');
        }
    } else {
        $product_stock_title = '<span class="product_stock"></span> ' . trans('index.InOfStock');
    }
    ?>
<?php } ?>
<?php

$fields = \App\Models\ConfigPostmeta::select('meta_value')->where('meta_key', 'config_colums_json_policy')->first();
$fields = !empty($fields->meta_value) ? json_decode($fields->meta_value, TRUE) : [];
$wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
$i_class = 'fa-regular';
if (!empty($wishlist)) {
    if (in_array($detail->id, $wishlist)) {
        $i_class = 'fa-solid';
    }
}
?>
<input type="hidden" value="<?php echo $detail->id ?>" id="detailProductID">
<div id="main" class="sitemap main-product-detail">
    <div class="content-detail-product pt-0 md:pt-[20px]">
        <div class="top-detail-product">
            <div class="">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-0 md:gap-2 lg:gap-5">
                    <div class="md:col-span-7">
                        <div class="top-detail-left">
                            <div class="flex flex-wrap justify-start mx-[-1px]">
                                @if(!empty($listAlbums))
                                @foreach($listAlbums as $key=>$item)
                                <div class="w-1/2 px-[1px]">
                                    <div class="img mb-[2px]">
                                        <img src="{{$item}}" alt="{{$detail->title}}" class="w-full object-cover">
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-5 p-4 lg:p-0">
                        <div class="top-detail-right pr-4">
                            @if (!empty($detail['getTags']))
                            @foreach ($detail['getTags'] as $kt => $tag)
                            @if($kt == 0)
                            <h3 class="title-2 text-f25 font-bold"><a href="{{route('tagURL', ['slug' => $tag['slug']])}}">{{$tag['title']}}</a>
                                <a href="javascript:void(0)" data-id="{{$detail->id}}" class="js_add_wishlist mobile-dpwl" style="float: right;"><i class="{{$i_class}} fa-heart js_add_wishlist_{{$detail->id}}"></i></a>
                            </h3>
                            @endif
                            @endforeach
                            @endif
                            <div class="description mt-[10px]">
                                <p>{{$detail->title}}</p>
                            </div>
                            <p class="price text-red-600 text-f15 font-bold mt-[10px]">
                                <span class="text-f20 md:text-f30 font-bold">{{$price['price_final']}}</span>
                                <del class="text-f14 text-gray-400 font-medium ml-[5px]">{{$price['price_old']}}</del>
                            </p>
                            <div class="size-detail mt-[15px]">
                                <!--START: product version -->
                                @if ($type == 'variable' && !empty($attributes))
                                <?php $i = 0;
                                ?>
                                @foreach($attributes as $key => $item)
                                <?php $i++; ?>
                                @if(count($item) > 0)
                                <div class="box-variable mb-3">
                                    <div class="font-bold text-base mb-1">{{$key}}</div>
                                    <div class="flex flex-wrap">
                                        @foreach ($item as $k => $val)
                                        <a href="javascript:void(0)" class="tp_item_variable variable_{{$i}} tp_item_variable_{{$val['id']}} py-1 px-5 border mb-2 mr-2 @if($k == 0) checked @endif" data-id="{{$val['id']}}" data-stt="<?php echo !empty($i == count($attributes)) ? 0 : 1 ?>">
                                            {{$val['title']}}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                <!--END: product version -->
                            </div>
                            <div class="hidden custom-number-input h-10 w-32 flex flex-row rounded-lg relative bg-transparent mt-1">
                                <button class="card-dec bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none leading-[50px]">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number" class="tp_cardQuantity outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700" name="custom-input-number" value="1" />
                                <button class="card-inc bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer leading-[50px]">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>

                            </div>
                            <div class="add-to-cart mt-[15px]">

                                <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="0" data-src="" data-type="{{$type}}" class="tp_addToCart addtocart border border-black bg-black p-[10px]  w-full text-white uppercase transition-all hover:bg-white hover:text-black">Thêm vào giỏ hàng</button>

                            </div>
                            <div class="add-to-wishlist mt-[15px]">

                                <button data-id="{{$detail->id}}" class="js_add_wishlist border p-[10px]  w-full text-black uppercase transition-all">
                                    <i class="<?php echo $i_class ?> fa-heart js_add_wishlist_{{$detail->id}}"></i>
                                    Thêm vào danh sách yêu thích
                                </button>

                            </div>

                            @if(!empty($policyProduct->slides) && count($policyProduct->slides) > 0)



                            <div class="box-detail mt-[20px]">

                                <div class="grid grid-cols-2 gap-4 flex-wrap justify-start">

                                    @foreach($policyProduct->slides as $slide)

                                    <div class="">

                                        <div class="item  mb-[10px] md:mb-0 text-center border border-gray-200 p-[15px]">

                                            <div class="icon">

                                                <img src="{{asset($slide->src)}}" alt="" class="inline-block">

                                            </div>

                                            <div class="nav-icon mt-[5px]">

                                                <h3 class="title-2 text-f15">{{$slide->title}}</h3>



                                            </div>

                                        </div>

                                    </div>

                                    @endforeach

                                </div>



                            </div>

                            @endif



                            <div class="acc mt-[20px]">

                                <div class="acc__card relative border-b border-gray-200 py-[15px]">

                                    <div class="acc__title text-f15 font-bold relative active">

                                        Chi tiết sản phẩm

                                    </div>

                                    <div class="acc__panel pt-[20px]" style="display: block;">

                                        <?php echo $detail->description ?>

                                    </div>

                                </div>



                                @if(!empty($fields['content']))

                                @foreach($fields['content'] as $key=>$item)

                                @if(!empty($item))

                                <div class="acc__card relative border-b border-gray-200 py-[15px]">

                                    <div class="acc__title text-f15 font-bold">

                                        {{$fields['title'][$key]}}

                                    </div>

                                    <div class="acc__panel pt-[20px]">

                                        {!!$item!!}

                                    </div>

                                </div>

                                @endif

                                @endforeach

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <section class="product-home  pt-[20px]  md:pt-[80px] wow fadeInUp">

            <div class="">

                <div class="relative mb-[20px] md:mb-[30px]">

                    <ul class="tabs flex flex-wrap justify-center mt-[15px] md:mt-0">

                        <li class="tab current cursor-pointer inline-block py-[8px] px-[15px] border mx-[2px]" data-tab="tab-1">

                            Sản phẩm cùng loại

                        </li>

                        <li class="tab cursor-pointer inline-block py-[8px] px-[15px] border mx-[2px]" data-tab="tab-2">

                            {{$fcSystem['title_2']}}

                        </li>

                    </ul>

                </div>

                <div id="tab-1" class="tab-content current">

                    @if(!empty($productSame))

                    <div class="slider-product owl-carousel">

                        @foreach($productSame as $key=>$item)

                        <?php echo htmlItemProduct($key, $item); ?>

                        @endforeach

                    </div>

                    @endif

                </div>

                <div id="tab-2" class="tab-content">

                    @if(!empty($ishomeProduct))

                    <div class="slider-product owl-carousel">

                        @foreach($ishomeProduct as $key=>$item)

                        <?php echo htmlItemProduct($key, $item); ?>

                        @endforeach

                    </div>

                    @endif

                </div>



            </div>

        </section>

        @include('homepage.common.recently')

    </div>

</div>

@endsection

@push('javascript')

<script type="text/javascript" src="{{asset('product/rating/bootstrap-rating.min.js')}}"></script>

<script src="{{asset('frontend/library/js/common.js')}}"></script>

@endpush

@push('css')

<link rel="stylesheet" href="{{asset('frontend/library/css/products.css')}}" />

<script>
    var module = 'product';
</script>

@endpush
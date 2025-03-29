@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('',$breadcrumb)!!}
@include('product.frontend.category.data',['module' => 'category'])
<div id="main" class="sitemap pb-[50px] main-product" id="scrollTop">
    <div class="content-product py-5 md:py-[30px]">
        <div class="container mx-auto px-3">
            <h1 class="title-primary text-black text-f30 md:text-f50 font-black text-center leading-[30px] md:leading-[50px] relative wow fadeInUp">
                {{!empty($module == 'category') ? $detail->title : $title}}
            </h1>
        </div>
    </div>
    @if(!empty($module == 'category') && count($detail->children) > 0)
    <div class="border-t border-b border-gray-200 py-[15px] wow fadeInUp">
        <div class="container mx-auto px-3">
            <ul class="flex flex-wrap justify-center">
                <li class="text-f16 px-[15px] mb-[10px] md:mb-0 active">
                    <a href="{{route('routerURL',['slug' => $detail->slug])}}" class="border-b border-gray-500 uppercase">{{trans('index.allPosts')}}</a>
                </li>
                @foreach($detail->children as $item)
                <li class="text-f16 px-[15px] mb-[10px] md:mb-0">
                    <a href="{{route('routerURL',['slug' => $item->slug])}}" data-id="{{$item->id}}" class="hover:border-b hover:border-gray-500 uppercase">{{$item->title}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="content-product py-5 md:py-[30px]">
        <div class="container mx-auto px-3">
            <div class="flex justify-between md:space-x-4">
                <aside id="tp-col-filter" class="hidden lg:block w-full order-2 lg:order-1 lg:w-1/5 sticky top-[90px] left-0 bottom-0 right-0 h-full flex-shrink-0 overflow-hidden wow fadeInLeft">
                    @include('product.frontend.category.filter',['module' => $module])
                </aside>
                <div class="w-full order-1 lg:order-2 lg:w-4/5 wow fadeInRight">
                    <div class="filter-sort">
                        <div class="flex items-center justify-center ">
                            <div class="w-1/2 flex items-center ">
                                <div class="flex lg:hidden items-center space-x-1 cursor-pointer mr-2 js-handle-filter-mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                    </svg>
                                </div>
                                <h4 class="text-f16 uppercase"><span class="js_total_filter"><?php echo $data->total() ?></span> {{trans('index.Products')}}</h4>
                            </div>
                            <div class="w-1/2 flex justify-end">
                                <select name="sortBy" class="filter h-[50px] border border-gray-200 px-4">
                                    <option value="">{{trans('index.SortedBy')}}</option>
                                    <option value="id|desc">{{trans('index.Latest')}}</option>
                                    <option value="id|asc">{{trans('index.Oldest')}}</option>
                                    <option value="title|asc">{{trans('index.NameAZ')}}</option>
                                    <option value="title|desc">{{trans('index.NameZA')}}</option>
                                    <option value="price|asc">{{trans('index.PricesGoUp')}}</option>
                                    <option value="price|desc">{{trans('index.PricesGoDown')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 justify-center mt-5 -mx-[5px] md:-mx-[10px]" id="js_data_product_filter">
                        @if($data)
                        @foreach ($data as $key=>$item)
                        <?php echo htmlItemProduct($key, $item, 'px-[5px] md:px-[10px]'); ?>
                        @endforeach
                        @endif
                    </div>
                    @if(!empty($module == 'category') && !empty($detail->description))
                    <div class="content-content text-f16 leading-[24px] pt-[40px]">
                        <?php echo $detail->description ?>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('homepage.common.recently')
    @include('homepage.common.reviews')
</div>
@endsection

@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('',$breadcrumb)!!}
<div id="main" class="sitemap pb-[50px] main-product" id="scrollTop">
    <div class="content-product py-5 md:py-[30px]">
        <div class="container mx-auto px-3 space-y-5">
            <div class="rounded-xl overflow-hidden shadowC">
                <div class=" px-6 py-4 bg-white float-left w-full flex flex-col space-y-2">
                    <h1 class="text-3xl font-bold">{{$detail->title}}</h1>
                    <div>
                        <div class="py-3 float-left w-auto border-b-2 border-red-600 font-bold text-base">
                            <span class=" text-red-600">Tất cả {{$detail->title}}</span>
                            <span class="text-gray-600"><?php echo $data->total() ?></span>
                        </div>
                    </div>
                    @if(!empty($detail->description))
                    <div>
                        <?php echo $detail->description; ?>
                    </div>
                    @endif
                </div>
            </div>
            <div class="flex justify-between md:space-x-4">
                <aside id="tp-col-filter" class="hidden lg:block w-full order-2 lg:order-1 lg:w-1/5 sticky top-[90px] left-0 bottom-0 right-0 h-full flex-shrink-0 overflow-hidden wow fadeInLeft">
                    @include('product.frontend.category.filter',['module' => $module])
                </aside>
                <div class="w-full order-1 lg:order-2 lg:w-4/5 wow fadeInRight">
                    <div class="filter-sort">
                        <div class="flex items-center justify-center ">
                            <div class="w-1/2 flex items-center ">
                                <div class="flex lg:hidden items-center space-x-1 cursor-pointer mr-2 js-handle-filter-mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                    </svg>
                                </div>
                                <h4 class="text-f16 uppercase"><span class="js_total_filter"><?php echo $data->total() ?></span> {{trans('index.Products')}}</h4>
                            </div>
                            <div class="w-1/2 flex justify-end">
                                <select name="sortBy" class="filter h-[50px] border border-gray-200 px-4">
                                    <option value="">{{trans('index.SortedBy')}}</option>
                                    <option value="id|desc">{{trans('index.Latest')}}</option>
                                    <option value="id|asc">{{trans('index.Oldest')}}</option>
                                    <option value="title|asc">{{trans('index.NameAZ')}}</option>
                                    <option value="title|desc">{{trans('index.NameZA')}}</option>
                                    <option value="price|asc">{{trans('index.PricesGoUp')}}</option>
                                    <option value="price|desc">{{trans('index.PricesGoDown')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 justify-center mt-5 -mx-[5px] md:-mx-[10px]" id="js_data_product_filter">
                        @if($data)
                        @foreach ($data as $key=>$item)
                        <?php echo htmlItemProduct($key, $item, 'px-[5px] md:px-[10px]'); ?>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
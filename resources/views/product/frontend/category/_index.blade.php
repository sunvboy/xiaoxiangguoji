@extends('homepage.layout.home')
@section('content')
<nav class="relative w-full flex flex-wrap items-center justify-between py-2 bg-[#f9f9f9] text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
    <div class="container px-4 mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600 text-f13">{{trans('index.home')}}</a></li>
                @if(!$breadcrumb->isEmpty())
                @foreach($breadcrumb as $item)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="{{route('routerURL',['slug' => $item->slug])}}" class="text-gray-500 hover:text-gray-600 text-f13">{{$item->title}}</a></li>
                @endforeach
                @endif
            </ol>
        </nav>
    </div>
</nav>
<main class="py-8 ">
    <div class=" container mx-auto px-4">
        <div class="rounded-xl overflow-hidden shadowC">
            <div class=" px-6 py-4 bg-white float-left w-full flex flex-col space-y-2">
                <h1 class="text-3xl font-bold">{{$detail->title}}</h1>
                <div>
                    <div class="py-3 float-left w-auto border-b-2 border-red-600 font-bold text-base">
                        <span class=" text-red-600">Tất cả {{$detail->title}}</span>
                        <span class="text-gray-600">{{$detail->countProduct->count()}}</span>
                    </div>
                </div>
                @if(!empty($detail->description))
                <div>
                    <?php echo $detail->description; ?>
                </div>
                @endif
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:space-x-4 relative pt-6 " id="scrollTop">
            @include('product.frontend.category.filter')
            <div class="flex-1 pb-6">
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 justify-between">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input placeholder="{{trans('index.SearchPlaceholder')}}" type="text" value="" class="filter rounded-full border w-full md:w-[421px] h-11 px-8 focus:outline-none focus:ring focus:ring-red-300 focus:rounded-full hover:outline-none hover:ring hover:ring-red-300 hover:rounded-full" name="keywordFilter">
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex md:hidden items-center space-x-1 cursor-pointer js-handle-filter-mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <span>
                                {{trans('index.Filter')}}
                            </span>
                        </div>
                        <select name="sortBy" class="filter rounded-full border h-11 px-8 focus:outline-none focus:ring focus:ring-red-300 focus:rounded-full hover:outline-none hover:ring hover:ring-red-300 hover:rounded-full">
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
                <section class="p-5 bg-red-50 rounded-2xl mt-6">
                    <h3 class="font-normal text-base">
                        @if(config('app.locale') == 'vi')
                        Có <strong class="js_total_filter"><?php echo $data->total() ?></strong> sản phẩm phù hợp với tiêu chí của bạn
                        @elseif(config('app.locale') == 'en')
                        There is <strong class="js_total_filter"><?php echo $data->total() ?></strong> product that matches your criteria
                        @elseif(config('app.locale') == 'gm')
                        Es gibt <strong class="js_total_filter"><?php echo $data->total() ?></strong> Produkt, das Ihren Kriterien entspricht
                        @elseif(config('app.locale') == 'tl')
                        มี <strong class="js_total_filter"><?php echo $data->total() ?></strong> ผลิตภัณฑ์ที่ตรงกับเกณฑ์ของคุณ
                        @endif
                    </h3>
                    <div class="mt-2 t-flex-gap">
                        <div id="js_selected_attr" class="flex flex-wrap gap-4 hidden">
                        </div>
                    </div>
                </section>

                <div class="mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-3  lg:grid-cols-4 gap-4" id="js_data_product_filter">
                        @if($data)
                        @foreach ($data as $key=>$item)
                        <?php echo htmlItemProduct($key, $item); ?>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="mt-5">
                    <div class="flex justify-center js_pagination_filter">
                        {{$data->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
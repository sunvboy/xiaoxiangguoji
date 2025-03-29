<div class="overflow-auto h-full">
    <div class="flex items-center justify-between pb-2">
        <div class="flex items-center space-x-1">
            <span class="font-black text-black  text-f25 mb-[0px] lg:mb-[20px]">{{trans('index.Filter')}}</span>
        </div>
        <div class="cursor-pointer js_close_filter_mobile block lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
    <div class="acc">
        <div class="flex flex-col border-b w-full py-5 acc__card">
            <div class="flex justify-between items-center cursor-pointer acc__title">
                <h4 class="text-base font-bold uppercase">{{trans('index.PriceRange')}}</h4>
                <span class="pr-2">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </div>
            <div class="acc__panel pt-5">
                <input type="text" class="js-range-slider" name="my_range" value="" />
                <div class="mt-1">
                    <div class="flex  gap-4">
                        <div class="w-1/2">
                            <label class="">{{trans('index.Start')}} (tr)</label>
                            <input placeholder=".000" type="text" value="" class="filter border w-full h-11 px-2 focus:outline-none  hover:outline-none" name="price_start">
                        </div>
                        <div class="w-1/2">
                            <label class="">{{trans('index.End')}} (tr)</label>
                            <input placeholder=".000" type="text" value="" class="filter border w-full h-11 px-2 focus:outline-none  hover:outline-none " name="price_end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($brandFilter) && count($brandFilter) > 0)
        <div class="flex flex-col border-b w-full py-5 acc__card">
            <div class="flex justify-between items-center cursor-pointer acc__title">
                <h4 class="text-base font-bold uppercase">{{trans('index.Brands')}}</h4>
                <span class="pr-2">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </div>
            <div class="acc__panel pt-5 space-x-2">
                <div class="flex flex-wrap">
                    @if($module == 'category')
                    @foreach ($brandFilter as $item)
                    <label for="brand-{{$item->brands->id}}" class="js_brand float-left mb-2 mr-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                        <input id="brand-{{$item->brands->id}}" type="checkbox" data-title="{{$item->brands->title}}" value="{{$item->brands->id}}" class="js_input_brand filter hidden" name="brands[]">
                        <span class="">{{$item->brands->title}}</span>
                        <div class="product-filter-tick">
                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                <g>
                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                </g>
                            </svg>
                        </div>
                    </label>
                    @endforeach
                    @else
                    @foreach ($brandFilter as $item)
                    <label for="brand-{{$item->id}}" class="js_brand float-left mb-2 mr-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                        <input id="brand-{{$item->id}}" type="checkbox" data-title="{{$item->title}}" value="{{$item->id}}" class="js_input_brand filter hidden" name="brands[]">
                        <span class="">{{$item->title}}</span>
                        <div class="product-filter-tick">
                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                <g>
                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                </g>
                            </svg>
                        </div>
                    </label>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endif
        @if(!empty($attributes) && count($attributes) > 0)
        @foreach ($attributes as $key=>$item)
        @if(count($item) > 0)
        <div class="flex flex-col border-b w-full py-5 acc__card">
            <div class="flex justify-between items-center cursor-pointer acc__title">
                <h4 class="text-base uppercase font-bold">{{$key}}</h4>
                <span class="pr-2">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </div>
            <div class="acc__panel pt-5 space-x-2">
                <div class="flex flex-wrap">
                    @foreach ($item as $val)
                    <label for="attr-{{$val['id']}}" class="js_attr float-left mr-2 mb-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                        <input id="attr-{{$val['id']}}" type="checkbox" value="{{$val['id']}}" data-title="{{$val['title']}}" data-keyword="{{$val['keyword']}}" class="js_input_attr filter hidden" name="attr[]">
                        <span>{{$val['title']}}</span>
                        <div class="product-filter-tick">
                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                <g>
                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                </g>
                            </svg>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endif
        <input id="choose_attr" class="w-full hidden" type="text" name="attr">
    </div>
</div>
@include('product.frontend.category.script')
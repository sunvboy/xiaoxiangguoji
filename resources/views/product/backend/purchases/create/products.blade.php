<?php
/*
List danh sách sản phẩm
*/ ?>
<div class="mt-5 space-y-2 scrollbar px-3" style="max-height:400px">
    @if(!$products->isEmpty())
    @foreach($products as $item)
    <div class="border-b pb-2">
        @if(count($item->product_versions) > 0)
        <div class="pl-0 lg:space-y-3 text-sm lg:text-base">
            @foreach ($item->product_versions as $val)
            <?php
            $title_version = collect(json_decode($val->title_version))->join(' - ', '');
            $price = !empty($val->price_import_version) ? $val->price_import_version : (!empty($item->price_import) ? $item->price_import : 0);
            $image = File::exists(base_path($val->image_version)) ? (!empty($val->image_version) ? asset($val->image_version) : (File::exists(base_path($item->image)) ? (!empty($item->image) ? asset($item->image) : asset('images/404.png')) : asset('images/404.png'))) : asset('images/404.png');
            ?>
            <div data-unit="{{$item->unit}}" data-image="{{$image}}" data-price="{{$price}}" data-id="{{$item->id}}" data-title-version="{{$title_version}}" data-id-version="{{$val->id}}" data-type="variable" class="text-sm lg:text-base grid space-x-2 lg:space-x-0 grid-cols-4 lg:grid-cols-12 items-center cursor-pointer js_handleSelectProducts">
                <div class="lg:col-span-1">
                    <img alt="{{$item->title}}" style="height:50px;width: 50px;object-fit: cover;" class="object-cover border" src="{{$image}}">
                </div>
                <div class="lg:col-span-6 ">
                    <span class="font-semibold">{{$item->title}}</span><br>({{$title_version}})
                </div>
                <div class="lg:col-span-5 text-right">
                    <span class="text-danger font-semibold">{{number_format($price,'0',',','.')}} đ</span><br>
                    <b>Số lượng:</b> {{$val->_stock}}
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div data-unit="{{$item->unit}}" data-image="{{asset($item->image)}}" data-price="{{$item->price_import}}" data-id="{{$item->id}}" data-type="simple" class="text-sm lg:text-base grid space-x-2 lg:space-x-0 grid-cols-4 lg:grid-cols-12 items-center cursor-pointer js_handleSelectProducts">
            <div class="lg:col-span-1">
                <img alt="{{$item->title}}" style="height:50px;width: 50px;object-fit: cover;" class="object-cover border" src="{{File::exists(base_path($item->image)) ? (!empty($item->image)?asset($item->image): asset('images/404.png')) : asset('images/404.png')}}">
            </div>
            <div class="lg:col-span-6 font-semibold">
                {{$item->title}}
            </div>
            <div class="lg:col-span-5 text-right">
                <span class="text-danger font-semibold">{{number_format($item->price_import,'0',',','.')}} đ</span><br>
                <b>Số lượng: </b>{{$item->inventoryQuantity}}
            </div>
        </div>
        @endif
    </div>
    @endforeach
    @endif
</div>
<div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center paginationProducts">
    {{$products->links()}}
</div>
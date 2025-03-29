<?php
/*
List danh sách sản phẩm - modal
*/ ?>
<div class="mt-5 space-y-2 scrollbar px-3" style="max-height:600px">
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
            $array = array(
                'id' => $item->id,
                'id_version' => $val->id_version,
                'title_version' => $val->title_version,
                'type' => 'variable',
                'price' =>  $price,
                'image' =>  $image,
                'unit' =>  $item->unit,
            );
            ?>
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="checkboxItem" value="{{json_encode($array)}}">
                <div class="js_handleSelectModalProduct flex-1 text-sm lg:text-base grid space-x-2 lg:space-x-0 grid-cols-3 lg:grid-cols-12 items-center cursor-pointer ">
                    <div class="lg:col-span-1 flex items-center space-x-1">
                        <img alt="{{$item->title}}" style="height:50px;width: 50px;object-fit: cover;" class="object-cover border" src="{{$image}}">
                    </div>
                    <div class="lg:col-span-6">
                        <span class="font-semibold">{{$item->title}}</span><br>({{$title_version}})
                    </div>
                    <div class="lg:col-span-5 text-right">
                        <span class="text-danger font-semibold">{{number_format($price,'0',',','.')}} đ</span><br>
                        <b>Số lượng:</b> {{$val->_stock}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <?php
        $array = array(
            'id' => $item->id,
            'type' => 'simple',
            'price' =>  $item->price_import,
            'image' => asset($item->image),
            'unit' =>  $item->unit,
        );
        ?>
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="checkboxItem" value="{{json_encode($array)}}">
            <div class="js_handleSelectModalProduct flex-1 text-sm lg:text-base grid space-x-2 lg:space-x-0 grid-cols-3 lg:grid-cols-12 items-center cursor-pointer ">
                <div class="lg:col-span-1 flex items-center space-x-1">
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
        </div>
        @endif
    </div>
    @endforeach
    @endif
</div>
<div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center paginationModalProducts">
    {{$products->links()}}
</div>
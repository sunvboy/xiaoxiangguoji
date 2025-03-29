<div class="mt-5 space-y-2 h-[400px] scrollbar">
    @if(!$products->isEmpty())
    @foreach($products as $item)
    <?php
    $price = getPrice(array('price' => $item->price, 'price_sale' => $item->price_sale, 'price_contact' =>
    $item->price_contact));
    ?>
    <?php
    $_stock = checkStock($item, 'simple');
    ?>
    <div class="border-b pb-2">
        <div data-id="{{$item->id}}" data-type="simple" class="text-sm lg:text-base grid space-x-2 lg:space-x-0 grid-cols-4 lg:grid-cols-12 items-center @if(count($item->product_versions) == 0 && $_stock['status'] == 0) js_handle_addToCart  hover:bg-global hover:text-white cursor-pointer @else cursor-no-drop @endif">
            <div class="lg:col-span-1">
                <img alt="{{$item->title}}" class="w-[50px] h-[50px] object-cover border" src="{{asset($item->image)}}">
            </div>
            <div class="lg:col-span-6">
                {{$item->title}}
            </div>
            <div class="lg:col-span-3">
                <?php echo $_stock['title'] ?>
            </div>
            <div class="lg:col-span-2">
                {{$price['price_final']}}
            </div>

        </div>
        @if(count($item->product_versions) > 0)
        <!-- Sản phẩm biến thể -->
        <div class="pl-0 lg:pl-20 lg:space-y-3 text-sm lg:text-base">
            @foreach ($item->product_versions as $val)
            <?php
            $title_version = collect(json_decode($val->title_version))->join(' - ', '');
            $price_version = getPrice(array('price' => $val->price_version, 'price_sale' => $val->price_sale_version, 'price_contact' =>
            0));
            $_stock_version = checkStock($val);
            ?>
            <div data-id="{{$item->id}}" data-id-version="{{$val->id_version}}" data-title-version="{{$val->title_version}}" data-type="variable" class=" grid grid-cols-3 lg:grid-cols-12 space-x-2 lg:space-x-0 lg:gap-4 items-center p-3 @if($_stock_version['status'] == 0)  js_handle_addToCart hover:bg-global hover:text-white cursor-pointer @else cursor-no-drop opacity-30 @endif  ">
                <div class="lg:col-span-6">
                    {{$title_version}}
                </div>
                <div class="lg:col-span-4">
                    <?php echo $_stock_version['title'] ?>
                </div>
                <div class="lg:col-span-2">
                    {{$price_version['price_final']}}
                </div>
            </div>
            @endforeach
        </div>
        <!--END: Sản phẩm biến thể -->
        @endif
    </div>
    @endforeach
    @endif

</div>
<div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
    {{$products->links()}}
</div>
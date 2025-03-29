    @if(!empty($products) && count($products) > 0)
    <ul class="px-2 py-2 space-y-3">
        @foreach($products as $item)
        <li>
            <a href="javascript:void(0)" class="flex items-center space-x-1 itemProduct" data-title="{{$item->title}}" data-category-title="{{!empty($item->detailCategoryProduct)?$item->detailCategoryProduct->title:''}}" data-price-format="{{number_format($item->price,'0','.','.')}}" data-price="{{$item->price}}">
                <span>
                    <img src="{{!empty($item->image) ? asset($item->image) : asset('backend/images/product.svg')}}" />
                </span>
                <span class="font-bold">
                    {{$item->title}}
                    <span class="text-black">
                        {{!empty($item->price)?number_format($item->price,'0','.','.'):0}} VNĐ
                    </span>
                </span>

            </a>
        </li>
        @endforeach
    </ul>
    @else
    <div class="h-full flex justify-center items-center flex-col">
        <i class="fa-solid fa-magnifying-glass text-[50px] mb-2"></i>
        <p class="text-lg">Không tìm thấy sản phẩm.</p>
        <p>Tạo sản phẩm mới?</p>
        <div class="absolute bottom-0 left-0 w-full bg-[#eaf9fe] p-[10px]">
            <a href=""><b><i class="fa-solid fa-plus"></i> Tạo:</b> <span class="titlePrd"></span></a>
        </div>
    </div>

    @endif
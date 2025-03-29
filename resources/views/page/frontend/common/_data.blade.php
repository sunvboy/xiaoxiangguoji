<div class="my-10 md:my-[50px] text-[#bebebe] BoldC flex justify-center items-center" style="line-height: 17px;letter-spacing: .88px;">{{$count}} results</div>
@if($data)
<div class="grid @if($type == 'products') grid-cols-2 @endif md:grid-cols-4 gap-10">

    @foreach($data as $item)
    <div class=" search_item text-center">
        @if($type == 'articles')
        <a href="{{route('routerURL',['slug' => $item->slug])}}" class="">
            <img class="w-full md:h-[300px] object-cover" src="{{asset($item->image)}}" alt="{{$item->title}}">
        </a>
        @else
        <a href="{{route('routerURL',['slug' => $item->slug])}}" class="">
            <img class="w-full h-[150px] md:h-[300px] object-contain" src="{{asset($item->image)}}" alt="{{$item->title}}">
        </a>
        @endif
        <h3 class="mt-[10px] mb-[5px] clamp-3">
            <a href="{{route('routerURL',['slug' => $item->slug])}}" class="uppercase BoldC clamp-3" style="line-height: 17px;letter-spacing: 1px;">
                {{$item->title}}
            </a>
        </h3>
        <div class="clamp-3 text-[#909090] " style="letter-spacing: 1px;line-height: 20px;">
            <?php echo strip_tags($item->description) ?>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-5 md:mt-10 flex justify-center col-span-4">
    <?php echo $data->links() ?>
</div>
@endif
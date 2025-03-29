<?php
$categoryAside =  \App\Models\CategoryProduct::select('id', 'slug', 'title')
    ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'parentid' => 0])
    ->with(['children' => function ($q) {
        $q->with('countProduct');
    }])
    ->orderBy('order', 'ASC')->orderBy('id', 'desc')->get();
?>
<aside class="sidebar rounded-[5px] p-[20px] border border-gray-100 shadow-sm">
    @foreach($categoryAside as $item)
    <div class="item-sb border-b border-gray-10 pb-[20px] mb-[20px]">
        <h2 class="uppercase font-bold text-[17px]">{{$item->title}}</h2>
        <ul class="mt-4 space-y-2">
            @if(!empty($item->children))
            @foreach($item->children as $v)
            <li class="relative pb-[6px] mb-[6px] text-f15 pl-[15px]">
                <a href="{{route('routerURL',['slug' => $v->slug])}}" class="hover:text-d61c1f font-normal">
                    {{$v->title}}<span> ({{count($v->countProduct)}})</span>
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    @endforeach
</aside>
<?php
$asideCategoryArticle = Cache::remember('asideCategoryArticle', 600000, function () {
    $asideCategoryArticle = \App\Models\CategoryArticle::select('id', 'title', 'slug')
        ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])
        ->with(['posts' => function ($query) {
            $query->limit(5);
        }])
        ->first();
    return $asideCategoryArticle;
});
$categoryProduct = Cache::remember('categoryProduct', 600000, function () {
    $categoryProduct = \App\Models\CategoryProduct::select('id', 'title', 'slug')
        ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'parentid' => 0])
        ->orderBy('order', 'asc')->orderBy('id', 'desc')
        ->get();
    return $categoryProduct;
});
?>
<div class="md:col-span-3 px-[10px] space-y-10 order-1 md:order-0 mt-10 md  :mt-0">
    @if(!empty($categoryProduct) && count($categoryProduct) > 0)
    <aside class="space-y-2">
        <h2 class="relative h2aside capitalize pb-[10px] font-bold text-lg">Danh mục sản phẩm</h2>
        <ul class="ulAside">
            @foreach($categoryProduct as $item)
            <li class="relative pl-5 py-[5px]">
                <a href="{{route('routerURL',['slug' => $item->slug])}}" class="hover:text-global">{{$item->title}}</a>
            </li>
            @endforeach
        </ul>
    </aside>
    @endif
    @if(!empty($asideCategoryArticle) && count($asideCategoryArticle->posts) > 0)
    <aside class="space-y-2">
        <h2 class="relative h2aside capitalize pb-[10px] font-bold text-lg">Bài viết mới</h2>
        <ul class="ulAside">
            @foreach($asideCategoryArticle->posts as $k=>$item)
            <li class="relative pl-5 py-[5px]">
                <a href="{{route('routerURL',['slug' => $item->slug])}}" class="hover:text-global">{{$item->title}}</a>
            </li>
            @endforeach
        </ul>
    </aside>
    @endif

</div>
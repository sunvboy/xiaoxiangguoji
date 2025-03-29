<?php
$faqs = \App\Models\Faq::limit(5)->orderBy('order', 'asc')->orderby('id', 'desc')->get();
$isasideCategoryArticle =
    \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
    ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'isaside' => 1])
    ->with(['posts' => function ($query) {
        $query->limit(5)->get();
    }])
    ->first();
?>
<aside class="aside-right">
    @if(!empty($faqs))
    <div class="item-sb">
        <h3 class="title-3">CÂU HỎI MỚI NHẤT</h3>
        <div class="nav-item-sb">
            <ul>
                @foreach($faqs as $key=>$item)
                <li>
                    <a href="{{route('pageF.faqs.id',['id' => $item->id])}}"><span>{{$key+1}}</span>{{$item->title}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    @if(!empty($isasideCategoryArticle))
    @if(!empty($isasideCategoryArticle->posts))
    <div class="item-sb">
        <h3 class="title-3" style="text-transform: uppercase;">{{$isasideCategoryArticle->title}} MỚI</h3>
        <div class="nav-item-sb">
            @foreach($isasideCategoryArticle->posts as $item)
            <div class="item-3">
                <div class="img hover-zoom">
                    <a href="{{route('routerURL',['slug' => $item->slug])}}">
                        <img src="{{asset($item->image)}}" alt="{{$item->title}}">
                    </a>
                </div>
                <div class="nav-img">
                    <h3 class="title-4"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                    <p class="desc">{!!strip_tags($item->description)!!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif
    @include('homepage.common.subscribers')
</aside>
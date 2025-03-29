@extends('homepage.layout.home')
@section('content')

<main class="main-new-2 main-new-detail">

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_0'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            @foreach($breadcrumb as $k=>$v)
                            <span class="tp-breadcrumb-link-active">
                                <a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"> \ {{ $v->title}}</a>
                            </span>
                            @endforeach
                        </div>
                        <h2 class="tp-breadcrumb-title">Trang {{$catalogues->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-new-2">

        <div class="second-new-2">
            <div class="container">

                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="content-left">
                            <h1 class="title-primary">{{$detail->title}}</h1>
                            <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->created_at)->format('d/m/Y - h:i')}}</p>
                            <div class="content-content">
                                {!!$detail->description!!}
                            </div>
                            <div class="content-content">
                                {!!$detail->content!!}
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>

                            @if(!$sameArticle->isEmpty())
                            <div class="item-modul-1 bai-viet-lien-quan">
                                <div class="tp-section text-p">
                                    <h3 class="tp-section-title">Bài viết liên quan</h3>
                                </div>
                                <div class="nav-content">
                                    <div class="row">
                                        @foreach($sameArticle as $k=>$v)
                                        @if($k==0)
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item">
                                                <div class="img hover-zoom">
                                                    <a href="{{route('routerURL',['slug' => $v->slug])}}">
                                                        <img src="{{asset($v->image)}}" alt="">
                                                    </a>
                                                </div>
                                                <div class="nav-img">
                                                    <h3 class="title-3"><a href="{{route('routerURL',['slug' => $v->slug])}}">{{$v->title}}</a></h3>
                                                    <p class="desc">{!!strip_tags($v->description)!!}</p>
                                                    <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item-right">
                                                @foreach($sameArticle as $k=>$v)
                                                @if($k>0)
                                                <div class="item-2">
                                                    <div class="img hover-zoom">
                                                        <a href="{{route('routerURL',['slug' => $v->slug])}}"><img src="{{asset($v->image)}}" alt="{{$v->title}}"></a>
                                                    </div>
                                                    <div class="nav-img">
                                                        <h3 class="titl-3"><a href="{{route('routerURL',['slug' => $v->slug])}}">{{$v->title}}</a></h3>
                                                        <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y')}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        @include('article.frontend.aside')

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('javascript')

@endpush
@push('css')
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=66765bc7f75dab0019adeb9f&product=inline-share-buttons&source=platform" async="async"></script>
@endpush

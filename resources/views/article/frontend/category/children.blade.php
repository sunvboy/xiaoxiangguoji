@extends('homepage.layout.home')
@section('content')
<main class="main-new-2">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_0'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active">
                                <a href="{{url('/')}}">Trang chủ</a>
                            </span>
                            @foreach($breadcrumb as $k=>$v)
                            <span class="tp-breadcrumb-link-active">
                                <a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"> \ {{ $v->title}}</a>
                            </span>
                            @endforeach
                        </div>
                        <h2 class="tp-breadcrumb-title">Trang {{$detail->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-new-2 customer-tp-news">
        @if(!empty($data))
        <div class="top-new-2">
            <div class="container">
                <div class="row customer-tp-news-one">
                    @foreach ($data as $k => $item)
                    @if($k == 0)
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="item-large">
                            <div class="img hover-zoom">
                                <a href="{{route('routerURL',['slug' => $item->slug])}}"><img src="{{asset($item->image)}}" alt="{{$item->title}}"></a>
                                <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')}}</p>
                            </div>
                            <div class="nav-img">

                                <h3 class="title-3"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                                <p class="desc">
                                    {{strip_tags($item->description)}}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        @foreach ($data as $k => $item)
                        @if($k == 1 || $k == 2)
                        <div class=" item-small">
                            <div class="img hover-zoom">
                                <a href="{{route('routerURL',['slug' => $item->slug])}}"><img src="{{asset($item->image)}}" alt="{{$item->title}}"></a>
                                <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')}}</p>
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="second-new-2 customer-tp-news-two">
            <div class="container">
                <div class="border-t">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="content-left">
                                @if(!empty($detail->children))
                                @foreach($detail->children as $key=>$item)
                                @if(!empty($item->posts6))
                                <div class="item-modul-1 customer-tp-news-two-items">
                                    <div class="tp-section text-p">
                                        <h3 class="tp-section-title"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                                    </div>
                                    <div class="nav-content">
                                        <div class="row">
                                            @foreach($item->posts6 as $k=>$v)
                                            @if($k==0)
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="item">
                                                    <div class="img hover-zoom">
                                                        <a href="{{route('routerURL',['slug' => $v->slug])}}">
                                                            <img src="{{asset($v->image)}}" alt="{{$v->title}}">
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
                                                    @foreach($item->posts6 as $k=>$v)
                                                    @if($k > 0)
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
                                @endforeach
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
    </div>


</main>
@endsection
@push('javascript')
@endpush

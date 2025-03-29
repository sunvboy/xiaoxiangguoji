@extends('homepage.layout.home')
@section('content')
<main class="main-new-2" style="margin-bottom: 50px;">
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
    <div class="">
        <div class="second-new-2">
            <div class="container">
                <div class="border-t">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="content-left">
                                @if(!empty($data))
                                <div class="item-modul-1">
                                    <div class="nav-content" style="margin-top: 0px;">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="item-right">
                                                    @foreach($data as $k=>$item)
                                                    <div class="item-2">
                                                        <div class="img hover-zoom">
                                                            <a href="{{route('routerURL',['slug' => $item->slug])}}"><img src="{{asset($item->image)}}" alt="{{$item->title}}" style="height: auto;"></a>
                                                        </div>
                                                        <div class="nav-img">
                                                            <h3 class="titl-3" style="height: auto;"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                                                            <p class="date"><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')}}</p>
                                                            <div>
                                                                {{strip_tags($item->description)}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-center">
                                                {{$data->links()}}
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
    </div>
</main>
@endsection
@push('javascript')
@endpush
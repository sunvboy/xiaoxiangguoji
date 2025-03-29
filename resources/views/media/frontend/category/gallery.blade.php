@extends('homepage.layout.home')
@section('content')
<main class="main-new-2 main-video">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_1'])}}">
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
                        <h2 class="tp-breadcrumb-title">{{$detail->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content-video">
        <div class="container">
            @if(!empty($detail->children) && count($detail->children) > 0)
            @foreach($detail->children as $item)
            <div class="item-video">
                <div class="tp-section text-p">
                    <h3 class="tp-section-title"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                </div>
                <div class="row">
                    @foreach($item->posts6 as $k=>$v)
                    <div class="col-md-4 col-sm-6 col-6">
                        <div class="item">
                            <div class="img">
                                <a href="{{route('routerURL',['slug' => $v->slug])}}">
                                    <img src="{{$v->image}}" alt="{{$v->title}}">
                                </a>
                            </div>
                            <h4 class="title-4"> <a href="{{route('routerURL',['slug' => $v->slug])}}">{{$v->title}}</a></h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            @if(!empty($data))
            <div class="item-video">
                <div class="row">
                    @foreach($data as $k=>$v)
                    <div class="col-md-4 col-sm-6 col-6">
                        <div class="item">
                            <div class="img">
                                <a href="{{route('routerURL',['slug' => $v->slug])}}">
                                    <img src="{{$v->image}}" alt="{{$v->title}}">
                                </a>
                            </div>
                            <h4 class="title-4"> <a href="{{route('routerURL',['slug' => $v->slug])}}">{{$v->title}}</a></h4>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12 d-flex justify-content-center">
                        {{$data->links()}}

                    </div>
                </div>
            </div>
            @endif
            @endif
        </div>
    </section>
</main>

@endsection
@push('css')
<style>
    .main-video .content-video .item .img::before {
        display: none;
    }
</style>
@endpush
@push('javascript')
<link rel="stylesheet" href="{{asset('frontend/ncare/assets/css/fancybox.css')}}">
<script src="{{asset('frontend/ncare/assets/js/fancybox.umd.js')}}">
</script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>

@endpush
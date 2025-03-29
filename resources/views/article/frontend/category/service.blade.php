@extends('homepage.layout.home')
@section('content')
<main>

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_4'])}}">
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

    <!-- services-area-start -->
    <section class="services-area tp-services-2-wrap pt-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-40">
                        <span><img src="{{asset('frontend/ncare/assets/img/shape/section-shape-1.svg')}}" alt="{{$detail->title}}"></span>
                        <h5 class="tp-section-subtitle">{{$detail->title}}</h5>
                        <h3 class="tp-section-title">{{strip_tags($detail->description)}}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($data))
                @foreach ($data as $k => $item)
                <div class="col-lg-4 col-md-6">
                    <div class="tp-services-2 mb-30">
                        <div class="tp-services-2-thumb p-relative">
                            <img src="{{asset($item->image)}}" alt="{{$item->title}}">
                            <div class="tp-services-2-icon">
                                <span><i class="flaticon-disabled"></i></span>
                            </div>
                        </div>
                        <div class="tp-services-2-content">
                            <h4 class="tp-services-2-title"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h4>
                            <div class="tp-services-2-list mb-35">
                                <div class="tp-services-2-list-item d-flex">
                                    <!-- <span><img src="{{asset('frontend/ncare/assets/img/icon/services-2-icon-1.svg')}}" alt="{{$item->title}}"></span> -->
                                    <p>{{strip_tags($item->description)}}</p>
                                </div>
                            </div>
                            <div class="tp-services-2-btn">
                                <a href="{{route('routerURL',['slug' => $item->slug])}}">Xem chi tiết<span><i class="fa-sharp fa-solid fa-plus"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- services-area-end -->


</main>

@endsection
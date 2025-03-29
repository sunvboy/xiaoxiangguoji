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
            <?php
            $image_json = json_decode($detail->image_json, TRUE);
            ?>
            @if(!empty($image_json))
            <div class="item-video">
                <div class="row">
                    @foreach($image_json as $k=>$v)
                    <div class="col-md-4 col-sm-6 col-6">
                        <div class="item">
                            <div class="img">
                                <a data-fancybox="gallery" href="{{asset($v)}}">
                                    <img src="{{$v}}" alt="{{$detail->title}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
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
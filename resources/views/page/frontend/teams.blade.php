@extends('homepage.layout.home')
@section('content')
<main>

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_3'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span> \ {{$page->title}}</span>
                        </div>
                        <h2 class="tp-breadcrumb-title">{{$page->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- team-area-start -->
    <section class="team-area mt-105 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-45">
                        <span><img src="assets/img/shape/section-shape-1.svg" alt=""></span>
                        <h5 class="tp-section-subtitle">{{$page->title}}</h5>
                        <h3 class="tp-section-title">{{strip_tags($page->description)}}</h3>
                    </div>
                </div>
            </div>
            <div class="form-search">
                <div class="item">
                    <h4 class="title-4">Tìm kiếm bác sỹ</h4>
                </div>
                <div class="item">
                    <input type="text" placeholder="Họ tên bác sỹ">
                </div>
                <div class="item">
                    <select name="" id="">
                        <option value="">Chức danh</option>
                    </select>
                </div>
                <div class="item">
                    <select name="" id="">
                        <option value="">Chuyên khoa</option>
                    </select>
                </div>
                <div class="item">
                    <select name="" id="">
                        <option value="">Học vị</option>
                    </select>
                </div>
                <div class="item">
                    <button>Tìm kiếm</button>
                </div>
            </div>
            <div class="row">
                @if(!empty($data))
                @foreach($data as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="tp-team-item text-center mb-40">
                        <div class="tp-team-thumb">
                            <img src="{{asset($item->image)}}" alt="{{$item->name}}">
                        </div>
                        <div class="tp-team-social">
                            <span><i class="fa-sharp fa-solid fa-plus"></i></span>
                            <div class="tp-team-social-wrap">
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>
                        <div class="tp-team-content">
                            <h4 class="tp-team-title"><a href="{{route('router.team',['id' => $item->id])}}">{{$item->name}}</a></h4>
                            <span>{{$item->job}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-12 d-flex justify-content-center">
                    {{$data->links()}}
                </div>
                @endif

            </div>
        </div>
    </section>
    <!-- team-area-end -->

</main>
@endsection
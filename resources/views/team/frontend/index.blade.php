@extends('homepage.layout.home')
@section('content')
<main class="main-new-2 main-expert-details">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_3'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="{{url('/')}}">Trang chủ</a></span>
                            <span class="tp-breadcrumb-link-active"><a href="{{route('pageF.teams')}}"> \ Đội ngũ bác sỹ</a></span>
                            <span> \ {{$detail->name}}</span>
                        </div>
                        <h2 class="tp-breadcrumb-title">Đội ngũ bác sỹ</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content-expert-details">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-12">
                    <div class="content-expert-left">
                        <img src="{{asset($detail->image)}}" alt="{{$detail->name}}">
                        <h3 class="title-name">{{$detail->name}}</h3>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-12">
                    <div class="content-expert-right">
                        <h3 class="title-4">{{$detail->name}}</h3>
                        <ul>
                            <!-- <li>
                                Khoa Thận
                            </li> -->
                            <li>{{$detail->job}}</li>
                        </ul>
                        <!-- <h4 class="title-5">Kinh nghiệm</h4> -->
                        <div class="item-item" style="margin-top: 20px;">
                            <div class="item">
                                <div class="left">
                                    <span><img src="{{asset('frontend/ncare/assets/img/icon/icon-time.svg')}}" alt="Quá trình đào tạo - công tác">Quá trình đào tạo - công tác</span>
                                </div>
                                <div class="right">
                                    {!!$detail->dao_tao!!}
                                </div>
                            </div>
                            <div class="item">
                                <div class="left">
                                    <span><img src="{{asset('frontend/ncare/assets/img/icon/icon-diploma.svg')}}" alt="Thế mạnh, kinh nghiệm công tác">Thế mạnh, kinh nghiệm công tác</span>
                                </div>
                                <div class="right">
                                    {!!$detail->the_manh!!}

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





</main>
@endsection
@extends('homepage.layout.home')
@section('content')
@if($slideHome)
@if($slideHome->slides)
<!-- Carousel Start -->
<div class="container-fluid px-0 mb-5">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($slideHome->slides as $key=>$slide)
            <div class="carousel-item @if($key == 0) active @endif">
                <img class="w-100" src="{{asset($slide->src)}}" alt="{{$slide->title}}">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-7 text-start">
                                <h1 class="display-1 text-white mb-4 animated slideInRight">{{$slide->title}}</h1>
                                <a href="javascript:void(0)" class="btn btn-primary rounded-pill py-3 px-5 animated slideInRight">了解更多</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">上一页</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">下一页</span>
        </button>
    </div>
</div>
<!-- Carousel End -->
@endif
@endif


@if($features)
@if($features->slides)
<!-- Features Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 feature-row">
            @foreach($features->slides as $slide)
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="feature-item border h-100 p-5">
                    <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                        <img class="img-fluid" src="{{asset($slide->src)}}" alt="{{$slide->title}}">
                    </div>
                    <h5 class="mb-3">{{$slide->title}}</h5>
                    <p class="mb-0">{{$slide->description}}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Features End -->
@endif
@endif

<?php
$config_colums_input_AboutTitle = $fields['config_colums_input_AboutTitle'];
$config_colums_editor_AboutDescription = $fields['config_colums_editor_AboutDescription'];
$config_colums_input_AboutImage = $fields['config_colums_input_AboutImage'];
$config_colums_json_AboutItems = !empty($fields['config_colums_json_AboutItems']) ? json_decode($fields['config_colums_json_AboutItems'], TRUE) : [];
?>
@if(!empty($config_colums_input_AboutTitle))
<!-- About Start -->
<div class="container-xxl about my-5" style=" background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)),url(<?php echo !empty($config_colums_input_AboutImage) ? asset($config_colums_input_AboutImage) : ''; ?>) left center no-repeat;">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-6">
                <div class="h-100 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                    <button type="button" class="btn-play d-none" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                        <span></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-6 pt-lg-5 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white rounded-top p-5 mt-lg-5">
                    <p class="fs-5 fw-medium text-primary">{{$config_colums_input_AboutTitle}}</p>
                    <div>
                        {!!!empty($config_colums_editor_AboutDescription)?$config_colums_editor_AboutDescription:''!!}
                    </div>
                    @if(!empty($config_colums_json_AboutItems) && !empty($config_colums_json_AboutItems['title']))
                    <div class="row g-5 pt-2 mb-5">
                        @foreach($config_colums_json_AboutItems['title'] as $key=>$val)
                        <div class="col-sm-6">
                            <img class="img-fluid mb-4" src="{{!empty($config_colums_json_AboutItems['image'][$key]) ? asset($config_colums_json_AboutItems['image'][$key]) : ''}}" alt="{{$val}}">
                            <h5 class="mb-3">{{$val}}</h5>
                            <span>{{!empty($config_colums_json_AboutItems['description'][$key]) ? $config_colums_json_AboutItems['description'][$key] : ''}}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="javascript:void(0)">了解更多</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
@endif

<?php /*<!-- Video Modal Start -->
<div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">YouTube视频</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 16:9 aspect ratio -->
                <div class="ratio ratio-16x9">
                    <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                        allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Modal End -->*/ ?>

@if(!empty($services) && !empty($services->posts))
<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary">{{$services->title}}</p>
            <h1 class="display-5 mb-5">{{strip_tags($services->description)}}</h1>
        </div>
        <div class="row g-4">
            @foreach($services->posts as $key=>$item)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{$key+2}}s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-5">
                        <div class="btn-square bg-light rounded-circle mx-auto mb-4"
                            style="width: 64px; height: 64px;">
                            <img class="img-fluid" src="{{$item->image}}" alt="{{$item->title}}">
                        </div>
                        <h5 class="mb-3">{{$item->title}}</h5>
                        <p class="mb-0">{{strip_tags($item->description)}}</p>
                    </div>
                    <div class="service-btn rounded-0 rounded-bottom">
                        <a class="text-primary fw-medium" href="{{route('routerURL',['slug' => $item->slug])}}">了解更多<i
                                class="bi bi-chevron-double-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Service End -->
@endif


@if(!empty($projects) && !empty($projects->posts))

<!-- Project Start -->
<div class="container-xxl pt-5">
    <div class="container">
        <div class="text-center text-md-start pb-5 pb-md-0 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary">{{$projects->title}}</p>
            <h1 class="display-5 mb-5">{{strip_tags($projects->description)}}</h1>
        </div>
        <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
            @foreach($projects->posts as $key=>$item)
            <div class="project-item mb-5">
                <div class="position-relative">
                    <img class="img-fluid" src="{{$item->image}}" alt="{{$item->title}}">
                    <?php /*  <div class="project-overlay">
                        <a class="btn btn-lg-square btn-light rounded-circle m-1" href="img/project-1.jpg"
                            data-lightbox="project"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle m-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>*/ ?>
                </div>
                <div class="p-4">
                    <a class="d-block h5" href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a>
                    <span>{{strip_tags($item->description)}}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Project End -->
@endif

<!-- Quote Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="fs-5 fw-medium text-primary">{{$fcSystem['title_0']}}</p>
                <h1 class="display-5 mb-4">{{$fcSystem['title_1']}}</h1>
                <div class="mb-4">
                    {{$fcSystem['title_2']}}
                </div>
                <a class="d-inline-flex align-items-center rounded overflow-hidden border border-primary" href="">
                    <span class="btn-lg-square bg-primary" style="width: 55px; height: 55px;">
                        <i class="fa fa-phone-alt text-white"></i>
                    </span>
                    <span class="fs-5 fw-medium mx-4"> {{$fcSystem['contact_hotline']}}</span>
                </a>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <h2 class="mb-4">{{$fcSystem['title_3']}}</h2>
                <form action="" class="form-subscribe">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="alert alert-success" style="display:none"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="fullname" id="name" placeholder="您的姓名"
                                    required>
                                <label for="name">您的姓名</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="mail" placeholder="您的电子邮件"
                                    required>
                                <label for="mail">您的电子邮件</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="phone" id="mobile" placeholder="您的手机"
                                    required>
                                <label for="mobile">您的手机</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="service" name="service">
                                    @if(!empty($serviceLists) && !empty($serviceLists->posts))
                                    @foreach($serviceLists->posts as $item)
                                    <option selected value="{{$item->title}}">{{$item->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="service">选择服务</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="留下您的消息" id="message" name="message"
                                    style="height: 130px"></textarea>
                                <label for="message">消息</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary w-100 py-3 btn-submit" type="submit">立即提交</button>
                            <button class="btn btn-primary w-100 py-3 btn-loading" type="button"
                                style="display: none;">加载中...</button>
                        </div>
                    </div>
                </form>
                <!-- end: box 9-->
            </div>
        </div>
    </div>
</div>
<!-- Quote Start -->


@if(!empty($teams) && !empty($teams->posts))
<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary">{{$teams->title}}</p>
            <h1 class="display-5 mb-5">{{strip_tags($teams->description)}}</h1>
        </div>
        <div class="row g-4">
            @foreach($teams->posts as $key=>$item)
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.{{$key+2}}s">
                <div class="team-item rounded overflow-hidden pb-4">
                    <img class="img-fluid mb-4" src="{{$item->image}}" alt="{{$item->title}}">
                    <h5>{{$item->title}}</h5>
                    <span class="text-primary">{{strip_tags($item->description)}}</span>
                    <?php /*<ul class="team-social">
                        <li><a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>*/ ?>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Team End -->
@endif

@if(!empty($testimonials) && !empty($testimonials->posts))
<!-- Testimonial Start -->
<div class="container-xxl pt-5">
    <div class="container">
        <div class="text-center text-md-start pb-5 pb-md-0 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary">{{$testimonials->title}}</p>
            <h1 class="display-5 mb-5">{{strip_tags($testimonials->description)}}</h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            @foreach($testimonials->posts as $key=>$item)
            <div class="testimonial-item rounded p-4 p-lg-5 mb-5">
                <img class="mb-4" src="{{$item->image}}" alt="{{$item->title}}">
                <p class="mb-4">{{strip_tags($item->description)}}</p>
                <h5>{{$item->title}}</h5>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Testimonial End -->
@endif
@endsection


@push('javascript')
@endpush
@push('css')

@endpush
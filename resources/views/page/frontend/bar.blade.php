@extends('homepage.layout.home')
@section('content')
<div id="content" class="site-content">
    <div class="bg-cover position-relative site-banner" style="background-image: url({{asset($page->image)}});"></div>
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul id="breadcrumb" class="breadcrumb justify-content-center">
                <li class="breadcrumb-item home"><a href="/" title="">Home</a></li>
                <li class="breadcrumb-item active">Bar &amp; Restaurant</li>
            </ul>
        </div>
    </nav>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <section class="pb-4">
                <div class="position-relative">
                    <div class="ripped-border-top-grey"></div>
                    <div class="box-title-details text-center pt-8 pb-5">
                        <div class="container">
                            <h1 class="title-h3 mb-0">{{$page->title}}</h1>
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 mt-4">
                                    {!!$page->description!!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-4 mb-2"><a class="btn btn-outline-dark d-block m-w-full" href="{{asset($fcSystem['pdf_3'])}}" target="_blank">Food Menu<i class="fal fa-arrow-right ml-2"></i></a></div>
                                    <div class="col-12 col-md-4 mb-2"><a class="btn btn-outline-dark d-block m-w-full" href="{{asset($fcSystem['pdf_4'])}}" target="_blank">Drink Menu<i class="fal fa-arrow-right ml-2"></i></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4 mb-5">
                            <div class="col-12 col-md-8">
                                <div class="row justify-content-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </main>
    </div>
</div>
@endsection
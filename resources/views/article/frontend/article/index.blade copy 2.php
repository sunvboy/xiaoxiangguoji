@extends('homepage.layout.home')
@section('content')
<div id="main" class="sitemap main-new-category pb-[20px] md:pb-[70px]">
    <section class="banner-child py-[50px] md:py-[100px] relative" style="background: url('{{!empty($catalogues->banner) ? (!empty(File::exists(base_path($catalogues->banner)))?asset($catalogues->banner):asset($fcSystem['banner_1'])) : asset($fcSystem['banner_1'])}}')">
        <h2 class="text-f25 md:text-f35 font-bold text-white relative z-10 text-center">
            {{ $catalogues->title}}
        </h2>
        <div class="breadcrumb py-[10px] relative z-10 mt-[5px]">
            <div class="container mx-auto px-3">
                <ul class="flex flex-wrap justify-center">
                    <li class=" text-white active"><a href="{{url('/')}}" class=" text-color_second">{{$fcSystem['title_12']}}</a></li>
                    @foreach($breadcrumb as $k=>$v)
                    <li><span class="text-gray-500 mx-2">/</span></li>
                    <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <div class="content-new-detail pt-[20px] md:pt-[60px]">
        <div class="container mx-auto px-3">
            <div class="flex flex-wrap justify-between mx-[-15px]">
                <div class="w-full md:w-3/4 px-[15px]">
                    <div class="blog-single-post" style="box-shadow: 0px 8px 32px 0px rgba(0, 0, 0, 0.12)">
                        <div class="content-content p-[15px] md:p-[40px]">
                            <div class="title-title-post mb-[10px]">
                                <h1 class="title-1 bold-1 text-f20 md:text-f30 leading-[25px] md:leading-[36px]">
                                    {{$detail->title}}
                                </h1>
                                <p class="date text-gray-600 mt-[10px]">
                                    {{$fcSystem['title_13']}}: {{$detail->created_at}}
                                </p>
                            </div>
                            <div class="box_content">
                                <?php echo $detail->content ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/4 px-[15px]">
                    @include('article.frontend.aside')
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .box_content img {
        margin: 10px auto;
        max-width: 100%;
        height: auto !important;
    }
</style>

@endsection
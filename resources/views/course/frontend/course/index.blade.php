@extends('homepage.layout.home')
@section('content')
<?php
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
?>
<div id="main" class="sitemap main-course-detail pb-[20px] md:pb-[70px]">
    <section class="banner-child py-[50px] md:py-[100px] relative" style="background: url('{{!empty($detail->banner) ? (!empty(File::exists(base_path($detail->banner)))?asset($detail->banner):asset($fcSystem['banner_1'])) : asset($fcSystem['banner_1'])}}')">
        <h2 class="text-f25 md:text-f35 font-bold text-white relative z-10 text-center">
            {{$detailCatalogue->title}}
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
    <div class="content-course-detail pt-[20px] md:pt-[60px]">
        <div class="container mx-auto px-3">
            <div class="flex flex-wrap justify-start mx-[-15px]">
                <div class="w-full md:w-3/4 px-[15px]">
                    <div class="content-course">
                        <h1 class="bold-1 text-f25">
                            {{$detail->title}}
                        </h1>
                        <p class="number-book text-gray-500 pt-[10px]">
                            <i class="fa-solid fa-book mr-[5px]"></i>{{!empty($detail->course_lessons) ? count($detail->course_lessons) : 0}} Lessons
                        </p>
                        <div class="new-home-section mt-[20px]">
                            <ul class="tabs flex flex-wrap justify-start mb-[20px]">
                                <li class="tab-link bold-1 current uppercase text-white text-f16" data-tab="tab-1">
                                    {{$fcSystem['title_36']}}
                                </li>
                                <li class="tab-link bold-1 uppercase text-white text-f16" data-tab="tab-2">
                                    {{$fcSystem['title_37']}}
                                </li>
                            </ul>

                            <div id="tab-1" class="tab-content current mt-[20px]">
                                <div class="box_content pt-[10px]">
                                    {!!$detail->description!!}
                                </div>
                            </div>
                            <div id="tab-2" class="tab-content mt-[20px]">
                                <div class="acc">
                                    @if(!empty($detail->course_chapters) && count($detail->course_chapters) > 0)
                                    <?php $i = 0; ?>
                                    @foreach($detail->course_chapters as $item)
                                    <?php $i++; ?>
                                    <div class="acc__card border-b border-gray-200 pb-[15px] mb-[15px]">
                                        <div class="acc__title bold-1 ">{{$item->title}}</div>
                                        <div class="acc__panel mt-[10px]">
                                            @if(count($item->course_lessons) > 0)
                                            <ul>
                                                @foreach($item->course_lessons as $k=>$val)
                                                <li class="pb-[10px]">
                                                    <?php /*<a class="transition-all hover:text-color_primary" data-fancybox="gallery" href="https://www.youtube.com/watch?v=GafKSu6igt0&ab_channel=GhibliMusic">
                                                        <span class="video-link-icon"><i class="fa-solid fa-circle-play mr-[10px]"></i>Introduction to Python and Programming Basics</span>
                                                    </a>*/ ?>
                                                    <a class="transition-all hover:text-color_primary" data-fancybox="gallery" href="{{$val->link}}">
                                                        <span class="video-link-icon"><i class="fa-solid fa-circle-play mr-[10px]"></i>{{$val->title}}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/4 px-[15px]">
                    <aside class="sidebar-course">
                        <div class="item-aside mb-[15px] md:mb-[25px]">
                            <div class="img relative">
                                <img src="{{asset($detail->image)}}" alt="{{$detail->title}}" class="w-full">
                                @if(!empty($fields['config_colums_input_video']))
                                <a data-fancybox="gallery" href="{{$fields['config_colums_input_video']}}">
                                    <span class="video-btn p-absolute">
                                        <i class="fa-solid fa-play"></i>
                                    </span>
                                </a>
                                <div class="overlay"></div>
                                @endif
                            </div>
                            <p class="price text-f28 bold-1 text-red-700 my-[10px]">{{$price['price_final']}}</p>
                            @if(!empty($fields['config_colums_input_policy']))
                            <p class="text-gray-700 text-center pt-[10px]">{{$fields['config_colums_input_policy']}}</p>
                            @endif
                            <ul class="pt-[20px]">
                                @if(!empty($fields['config_colums_input_duration']))
                                <li class="pb-[10px]">
                                    <span><i class="fa-solid fa-clock mr-[4px]"></i> {{$fcSystem['title_38']}}:</span> <span class="float-right">{{$fields['config_colums_input_duration']}}</span>
                                </li>
                                @endif
                                @if(!empty($fields['config_colums_input_TotalEnrolled']))
                                <li class="pb-[10px]">
                                    <span><i class="fa-solid fa-user mr-[4px]"></i> {{$fcSystem['title_39']}}:</span> <span class="float-right">{{$fields['config_colums_input_TotalEnrolled']}}</span>
                                </li>
                                @endif
                                @if(!empty($fields['config_colums_input_CourseLabel']))
                                <li class="pb-[10px]">
                                    <span><i class="fa-solid fa-signal mr-[4px]"></i> {{$fcSystem['title_40']}}:</span> <span class="float-right">{{$fields['config_colums_input_CourseLabel']}}</span>
                                </li>
                                @endif
                                @if(!empty($fields['config_colums_input_Certificate']))
                                <li class="pb-[10px]">
                                    <span><i class="fa-solid fa-clock mr-[4px]"></i> {{$fcSystem['title_41']}}:</span> <span class="float-right">{{$fields['config_colums_input_Certificate']}}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @include('homepage.common.subscribers',['title' => $fcSystem['title_42'],'course_id' => $detail->id])
                        @include('homepage.common.courseCategory',['class' => 'item-aside mb-[15px] md:mb-[25px] border border-gray-100 rounded-[10px] p-[15px]'])
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script src="{{asset('frontend/js/jquery.fancybox.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('frontend/css/jquery.fancybox.min.css')}}">

@endpush
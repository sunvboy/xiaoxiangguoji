@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($page->title)!!}
<div id="main" class="sitemap  main-review-custom">
    <div class="container mx-auto px-4 py-[30px] md:py-[50px]">
        <h2 class="font-black text-black text-f30 md:text-f44 leading-[32px] md:leading-[46px] mb-5 wow fadeInUp delay01">
            {!!$fcSystem['title_9']!!}
        </h2>
        <p class="desc-1 text-f16 leading-[25px] wow fadeInUp delay02">
            {!!$fcSystem['title_10']!!}
        </p>
        <div class="content-review-custom mt-[50px]  ">
            <h3 class="text-f18 wow fadeInUp delay03 flex items-center space-x-2">
                <span class="flex">
                    <?php for ($i = 1; $i <= $ratings / $data->total(); $i++) { ?>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                <path d="M10 2.5L12.1832 7.34711L17.5 7.91118L13.5325 11.4709L14.6353 16.6667L10 14.0196L5.36474 16.6667L6.4675 11.4709L2.5 7.91118L7.81679 7.34711L10 2.5Z" stroke="#FFD52E" fill="#FFD52E"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99996 1.66675L12.4257 7.09013L18.3333 7.72127L13.925 11.7042L15.1502 17.5177L9.99996 14.5559L4.84968 17.5177L6.07496 11.7042L1.66663 7.72127L7.57418 7.09013L9.99996 1.66675ZM9.99996 3.57863L8.10348 7.81865L3.48494 8.31207L6.93138 11.426L5.97345 15.9709L9.99996 13.6554L14.0265 15.9709L13.0685 11.426L16.515 8.31207L11.8964 7.81865L9.99996 3.57863Z" fill="#FFD52E"></path>
                            </svg>
                        </span>
                    <?php } ?>
                </span>
                <span>{{trans('index.countCmt',['count' => $data->total()])}}</span>
            </h3>
            @if(count($data) > 0)
            <div class="flex flex-wrap justify-between mx-[-10px] wow fadeInUp delay04">
                @foreach($data as $key=>$item)
                <?php $listImageCmt = json_decode($item->images, TRUE); ?>
                <div class="w-full md:w-1/2 px-[10px]">
                    <div class="item border-t border-gray-200 pt-5 mt-5">
                        <div class="flex flex-wrap justify-between mx-[-10px] mt-[10px]">
                            <div class="w-1/4 px-[10px]">
                                <div class="img hover-zoom">
                                    @if(!empty($item->product))
                                    <img src="{{asset($item->product->image)}}" alt="{{$item->product->title}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="w-3/4 px-[10px]">
                                <div class="flex flex-wrap justify-between mx-[-10px] mb-[10px]">
                                    <div class="w-1/2 px-[10px]">
                                        <div class="flex">
                                            <?php for ($i = 1; $i <= $item->rating; $i++) { ?>
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                        <path d="M10 2.5L12.1832 7.34711L17.5 7.91118L13.5325 11.4709L14.6353 16.6667L10 14.0196L5.36474 16.6667L6.4675 11.4709L2.5 7.91118L7.81679 7.34711L10 2.5Z" stroke="#FFD52E" fill="#FFD52E"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99996 1.66675L12.4257 7.09013L18.3333 7.72127L13.925 11.7042L15.1502 17.5177L9.99996 14.5559L4.84968 17.5177L6.07496 11.7042L1.66663 7.72127L7.57418 7.09013L9.99996 1.66675ZM9.99996 3.57863L8.10348 7.81865L3.48494 8.31207L6.93138 11.426L5.97345 15.9709L9.99996 13.6554L14.0265 15.9709L13.0685 11.426L16.515 8.31207L11.8964 7.81865L9.99996 3.57863Z" fill="#FFD52E"></path>
                                                    </svg>
                                                </span>
                                            <?php } ?>
                                            <?php for ($i = 1; $i <= 5 - $item->rating; $i++) { ?>
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                        <path d="M10 2.5L12.1832 7.34711L17.5 7.91118L13.5325 11.4709L14.6353 16.6667L10 14.0196L5.36474 16.6667L6.4675 11.4709L2.5 7.91118L7.81679 7.34711L10 2.5Z" stroke="#dddddd" fill="#dddddd"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99996 1.66675L12.4257 7.09013L18.3333 7.72127L13.925 11.7042L15.1502 17.5177L9.99996 14.5559L4.84968 17.5177L6.07496 11.7042L1.66663 7.72127L7.57418 7.09013L9.99996 1.66675ZM9.99996 3.57863L8.10348 7.81865L3.48494 8.31207L6.93138 11.426L5.97345 15.9709L9.99996 13.6554L14.0265 15.9709L13.0685 11.426L16.515 8.31207L11.8964 7.81865L9.99996 3.57863Z" fill="#dddddd"></path>
                                                    </svg>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="w-1/2 px-[10px]">
                                        <p class="date text-gray-600 text-f14 text-right">
                                            {{$item->created_at}}
                                        </p>
                                    </div>
                                </div>
                                <h3 class="text-f15 font-bold text-gray-600">
                                    @if(!empty($item->product))
                                    <a href="{{route('routerURL',['slug' => $item->product->slug])}}" class="text-blue-600 hover:text-red transition-all">
                                        {{!empty($item->product->title)?$item->product->title:''}}
                                    </a>
                                    @endif
                                </h3>
                                <div class="desc text-f15 text-gray-500 mt-[10px]">
                                    {!!$item->message!!}
                                </div>
                                <div class="text-f15 mt-[10px] text-gray-600">
                                    {{$item->fullname}}
                                    @if(!empty($item->checkOrder))
                                    <span class="text-green-500 ml-[10px]">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        {{trans('index.VerifiedBuyer')}}
                                    </span>
                                    @endif
                                </div>
                                @if(!empty($listImageCmt))
                                <div class="mt-[10px] flex flex-wrap">
                                    @foreach($listImageCmt as $image)
                                    <div class="px-1 mb-2 ">
                                        <img src="{{asset($image)}}" alt="{{$item->fullname}}" class="w-[120px] h-[120px] object-cover shadow" />
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-5 wow fadeInUp delay05">
                {{$data->links()}}
            </div>
            @endif
        </div>
    </div>
    @include('homepage.common.wholesale')
</div>
@endsection
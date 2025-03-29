<?php
$list_images_cmt = [];
foreach ($comment_view['listComment'] as $v) {
    if (!empty($v->images)) {
        $tmp_images_cmt = json_decode($v->images, TRUE);
        if (!empty($tmp_images_cmt)) {
            foreach ($tmp_images_cmt as $v) {
                $list_images_cmt[] = $v;
            }
        }
    }
}
?>
<?php

$arrayRate5 = $arrayRate4 = $arrayRate3 = $arrayRate2 = $arrayRate1 = 0;
$arrayRate5PT = $arrayRate4PT = $arrayRate3PT = $arrayRate2PT = $arrayRate1PT = 0;
if (isset($comment_view) && is_array($comment_view) && count($comment_view)) {
    $averagePoint = round($comment_view['averagePoint']);
    $totalComment = $comment_view['totalComment'];
    $arrayRate5 = $comment_view['arrayRate'][5];
    if ($arrayRate5 > 0) {
        $arrayRate5PT = ($arrayRate5 / $totalComment) * 100;
    }
    $arrayRate4 = $comment_view['arrayRate'][4];
    if ($arrayRate4 > 0) {
        $arrayRate4PT = ($arrayRate4 / $totalComment) * 100;
    }
    $arrayRate3 = $comment_view['arrayRate'][3];
    if ($arrayRate3 > 0) {
        $arrayRate3PT = ($arrayRate3 / $totalComment) * 100;
    }
    $arrayRate2 = $comment_view['arrayRate'][2];
    if ($arrayRate2 > 0) {
        $arrayRate2PT = ($arrayRate2 / $totalComment) * 100;
    }
    $arrayRate1 = $comment_view['arrayRate'][1];
    if ($arrayRate1 > 0) {
        $arrayRate1PT = ($arrayRate1 / $totalComment) * 100;
    }
}
?>
<div id="section-rating-comment" class="flex flex-col bg-white rounded-lg mt-10">
    <div class="flex items-center space-x-2 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
        </svg>
        <h3 class="m-0 text-[19px] font-bold"><a href="javascript:void(0)">{{trans('index.danhgiavanhanxet')}}</a></h3>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12 md:col-span-5">
            <div class="flex items-center space-x-2">
                <div class="text-5xl font-bold whitespace-nowrap">{{$comment_view['averagePoint']}}</div>
                <div class="">
                    <div class="relative flex averagePoint">
                        <input type="hidden" class="rating-disabled" value="{{$comment_view['averagePoint']}}" disabled="disabled" />
                    </div>
                    <div>
                        {{$comment_view['totalComment']}} {{trans('index.nhanxet')}}
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="5" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">
                        <div class="bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate5PT ?>%;">
                        </div>
                    </div>
                    <div class=""><?php echo $arrayRate5 ?></div>
                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="4" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">
                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate4PT ?>%;">
                        </div>
                    </div>
                    <div class=""><?php echo $arrayRate4 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="3" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate3PT ?>%;">
                        </div>

                    </div>
                    <div class=""><?php echo $arrayRate3 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="2" disabled="disabled" />

                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate2PT ?>%;">
                        </div>

                    </div>
                    <div class=""><?php echo $arrayRate2 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">

                        <input type="hidden" class="rating-disabled" value="1" disabled="disabled" />

                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate1PT ?>%;">
                        </div>

                    </div>
                    <div class=""><?php echo $arrayRate1 ?></div>

                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-7 mt-5 md:mt-0">
            @if(empty($comment_view['totalComment']))
            <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span class="block text-[19px] font-bold">{{trans('index.chuadanhgiavanhanxet')}}</span>
                <span class="block text-[14px]">
                    {{trans('index.nenmuahay')}}
                </span>
            </div>
            @endif
            @if(!empty($list_images_cmt))
            <div class="">
                <h2 class="text-lg font-medium mb-2">{{trans('index.tatcahinhanh')}}(<?php echo !empty($list_images_cmt) ? count($list_images_cmt) : 0 ?>)</h2>

                <div class="grid grid-cols-6 space-x-2">
                    @foreach($list_images_cmt as $kimage=>$image)
                    @if($kimage <= 4) <div class=" object-cover cursor-pointer border border-slate-100 mb-2 review_images_item">
                        <a href="<?php echo $image ?>" data-fancybox="images" rel="group1">
                            <img src="<?php echo $image ?>" alt="ảnh cmt" class="object-cover h-[60px] mx-auto rounded-sm">
                        </a>
                </div>
                @endif
                @if($kimage == 5)
                <div class="flex-auto h-[60px] object-cover cursor-pointer bg-cover relative rounded review_images_item">
                    <a href="<?php echo $image ?>" data-fancybox="images" rel="group1">
                        <img src="<?php echo $image ?>" alt="ảnh cmt" class="object-cover h-[60px]">
                        @if(count($list_images_cmt) > 6)
                        <span class="absolute rounded top-1/2 left-1/2 w-full text-center text-white h-full font-bold" style="transform: translate(-50%,-50%);background-color: rgba(36, 36, 36, 0.7);line-height: 60px;">+<?php echo count($list_images_cmt) - 6 ?>
                        </span>
                        @endif
                    </a>
                </div>
                @endif
                @endforeach


                @foreach($list_images_cmt as $kimage=>$image)
                @if($kimage > 4)
                <a href="<?php echo $image ?>" data-fancybox="images" rel="group1" class="hidden">
                    <img src="<?php echo $image ?>" alt="ảnh cmt" class="object-cover h-[60px]">
                </a>
                @endif
                @endforeach
            </div>
        </div>
        @endif
        <div class="flex justify-center">
            <button onclick="modalHandler(true)" class="mt-4 flex items-center justify-center bg-red-600 h-12 rounded-md px-6 text-white font-semibold w-auto ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                {{trans('index.Comment')}}
            </button>
            <?php /*@if(!empty(Auth::guard('customer')->user()))

            @else
            <button type="button" onclick="handleLogin()" class="mt-4 flex items-center justify-center bg-red-600 h-12 rounded-md px-6 text-white font-semibold w-auto ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                {{trans('index.Comment')}}
            </button>
            @endif*/ ?>
        </div>
    </div>
</div>

@if(!empty($list_images_cmt))
<!-- START: filter comment -->
<div class="col-span-12 mt-5">
    <div class="flex items-center">
        <div class="flex-shrink-0 mr-4 font-normal ">{{trans('index.locxemtheo')}}</div>
        <div class="flex flex-wrap flex-grow space-x-2">
            <div class="filter_item mb-2 md:mb-0 h-8 font-medium  leading-5 px-3 py-[6px] rounded-full text-[#38383d] bg-[#f5f5fa] cursor-pointer flex items-center">
                <div data-sort="id" class="filter_text flex items-center">
                    <span class="filter_check w-[18px] h-[18px] mr-[5px] hidden"><img src="{{url('images/check.png')}}"></span>
                    <span>{{trans('index.Latest')}}</span>
                </div>
            </div>
            <div class="filter_item mb-2 md:mb-0 h-8 font-medium  leading-5 px-3 py-[6px] rounded-full text-[#38383d] bg-[#f5f5fa] cursor-pointer flex items-center">
                <div data-sort="gallery" class="filter_text flex items-center">
                    <span class="filter_check w-[18px] h-[18px] mr-[5px] hidden"><img src="{{url('images/check.png')}}"></span>
                    <span>{{trans('index.cohinhanh')}}</span>
                </div>
            </div>
            <div class="filter_item mb-2 md:mb-0 h-8 font-medium  leading-5 px-3 py-[6px] rounded-full text-[#38383d] bg-[#f5f5fa] cursor-pointer flex items-center">
                <span class="filter_check w-[18px] h-[18px] mr-[5px] hidden"><img src="{{url('images/check.png')}}"></span>
                <span data-sort="payment" class="filter_text">{{trans('index.VerifiedBuyer')}}</span>
            </div>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <div class="filter_item mb-2 md:mb-0 h-8 font-medium  leading-5 px-3 py-[6px] rounded-full text-[#38383d] bg-[#f5f5fa] cursor-pointer flex items-center">
                    <div data-sort="{{$i}}" class="filter_text flex items-center">
                        <span class="filter_check w-[18px] h-[18px] mr-[5px] hidden"><img src="{{asset('images/check.png')}}"></span>
                        <span>{{$i}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="ml-1">
                            <path d="M10 2.5L12.1832 7.34711L17.5 7.91118L13.5325 11.4709L14.6353 16.6667L10 14.0196L5.36474 16.6667L6.4675 11.4709L2.5 7.91118L7.81679 7.34711L10 2.5Z" stroke="#FFD52E" fill="#FFD52E"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99996 1.66675L12.4257 7.09013L18.3333 7.72127L13.925 11.7042L15.1502 17.5177L9.99996 14.5559L4.84968 17.5177L6.07496 11.7042L1.66663 7.72127L7.57418 7.09013L9.99996 1.66675ZM9.99996 3.57863L8.10348 7.81865L3.48494 8.31207L6.93138 11.426L5.97345 15.9709L9.99996 13.6554L14.0265 15.9709L13.0685 11.426L16.515 8.31207L11.8964 7.81865L9.99996 3.57863Z" fill="#FFD52E"></path>
                        </svg>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- END: filter comment -->
@endif
<!-- START: comment item -->
<div class="col-span-12 mt-7">
    <div id="getListComment">
        @include('product.frontend.product.comment.data')
    </div>
</div>
<!-- END: comment item -->
<div class="py-12 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 " id="modal" style="background:#0000007a;display: none;z-index: 99999999;">
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 !max-w-3xl">
        <div class="relative py-8 px-5  bg-white shadow-md rounded border border-gray-400">

            <h2 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4 text-lg pr-0 md:pr-[50px]">{{$detail->title}}</h2>
            <div class="modal-body relative pt-[15px] border-t border-[#e5e5e5]">
                <form id="form-comment">
                    <div class="write-review__heading text-lg leading-6 font-medium text-center mb-3">{{trans('index.vuilongdanhgia')}}</div>
                    <div class="write-review__stars text-center">
                        <input type="hidden" class="rating-disabled" value="5" name="rating" />
                        <input type="hidden" value="" name="images">
                    </div>
                    <div class="write-review__info flex-1 flex items-end justify-between mt-3">
                        <input value="" type="text" name="fullname" placeholder="{{trans('index.Fullname')}}" class="w-[49%] h-9 leading-9 cursor-pointer rounded flex justify-center items-center outline-none focus:outline-none hover:outline-none border border-[#eeeeee] px-4 py-[6px] " required>
                        <input value="" type="text" name="phone" placeholder="{{trans('index.Phone')}}" class="w-[49%] h-9 leading-9 cursor-pointer rounded flex justify-center items-center outline-none focus:outline-none hover:outline-none border border-[#eeeeee] px-4 py-[6px] ">
                    </div>
                    <textarea rows="8" placeholder="{{trans('index.sharettsp')}}" class="border border-[#eeeeee] p-4 rounded resize-none w-full outline-none focus:outline-none hover:outline-none my-4" name="message" required></textarea>
                    <div class="error_comment">
                        <div class="alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" style="display: none" role="alert">
                            <div class="flex items-center">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold js_text_success"></p>
                                </div>
                            </div>
                        </div>
                        <div class="alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert" style="display: none">
                            <strong class="font-bold">ERROR!</strong>
                            <span class="block sm:inline js_text_danger"></span>
                        </div>
                    </div>
                    <div class="write-review__images text-left mb-3 " style="display: none;">
                    </div>
                    <div class="flex-1 flex items-end justify-between m-0 ">
                        <input class="write-review__file absolute h-0 w-0 invisible opacity-0 block" type="file" multiple="" style="clip: rect(0px, 0px, 0px, 0px);">
                        <input type="hidden" value="{{$detail->id}}" name="module_id">
                        <button type="button" class="write-review__button write-review__button--image w-1/2 py-3 leading-9 cursor-pointer rounded flex items-center justify-center text-blue-500 border-blue-500 border" style="background: #fff">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="ml-1">{{trans('index.themanh')}}</span>
                        </button>
                        <button type="submit" class="write-review__button write-review__button--submit w-1/2 bg-red-600 ml-4  py-3 leading-9 cursor-pointer rounded flex items-center justify-center text-white border-red-600 border"><span>{{trans('index.guidanhgia')}}</span>
                        </button>
                    </div>
                </form>
            </div>
            <button style="background: #fff;padding: 0px;" class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>
</div>

</div>
@push('css')
<link href="{{asset('product/rating/bootstrap-rating.css')}}" rel="stylesheet">
<style>
    .write-review__button--image {
        line-height: 19px;
    }

    .js_btn_reply {
        padding-top: 5px;
        padding-bottom: 5px;
    }
</style>
@endpush
@push('javascript')
<script type="text/javascript" src="{{asset('product/rating/bootstrap-rating.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer">
<script>
    $('a[rel="group1"]').fancybox({
        thumbs: {
            autoStart: true
        },
        buttons: [
            'zoom',
            'close'
        ]
    });
</script>
@endpush
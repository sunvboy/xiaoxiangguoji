@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($page->title)!!}
<div id="main" class="sitemap pb-[50px] main-agent-registration">
    <section class="subscribe-section pb-[30px] relative">
        <img src="{{asset($page->image)}}" alt="{{$page->title}}" class="w-full h-[300px] md:h-[600px] object-cover">
        <div class="container mx-auto px-3 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-2/5">
                    <div class="shadow p-[20px] lg:p-[50px] bg-white text-center">
                        <h4 class="text-f15 uppercase mb-[10px] font-bold">
                            {{$fcSystem['agency_1']}}
                        </h4>
                        <h3 class="text-f20 ld:text-f30 font-black mb-[10px] lg:mb-[15px] lg:mt-[17px]">
                            {{$fcSystem['agency_2']}}
                        </h3>
                        <p class="text-f16 ld:text-f18 leading-[26px]">
                            {{$fcSystem['agency_3']}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="content-agent-registration py-[30px] wow fadeInUp">
        <div class="container mx-auto px-3">
            <div class="flex flex-wrap justify-center">
                <div class="w-full md:w-1/2">
                    <h1 class="font-black text-black text-f20  lg:text-f40 leading-[30px] lg:leading-[52px]">
                        {{$fcSystem['agency_4']}}
                    </h1>
                    <div class="content-content mt-[5px] md:mt-[20px]">
                        {!!$fcSystem['agency_5']!!}
                    </div>
                    <form action="" id="file-question" class="validate form-subscribe-register">
                        <div class="custom-imformation pt-[30px]">
                            <h2 class="text-f30 font-bold mb-[20px]">
                                {{$fcSystem['agency_6']}}
                            </h2>
                            @csrf
                            @include('homepage.common.alert')
                            <div class="grid grid-cols-1 md:grid-cols-2 ">
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold"> {{$fcSystem['agency_7']}} *</label>
                                    <input type="text" name="firstName" class="validate[required] px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300 w-full h-[40px] border border-gray-200 text-f15" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_8']}} *</label>
                                    <input type="text" name="lastName" class="validate[required] px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300 w-full h-[40px] border border-gray-200 text-f15" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">Email *</label>
                                    <input type="text" name="email" class="validate[required] px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300 w-full h-[40px] border border-gray-200 text-f15" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">{{$fcSystem['agency_9']}} *</label>
                                    <select name="account" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300">
                                        <option value="Có">{{trans('index.Yes')}}</option>
                                        <option value="Không">{{trans('index.No')}}</option>
                                    </select>
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">{{$fcSystem['agency_10']}}</label>
                                    <input type="text" name="associated" class="w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_11']}} *</label>
                                    <input type="text" name="company" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_12']}} *</label>
                                    <input type="text" name="terms" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_13']}}</label>
                                    <input type="text" name="apply" class="w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">Website</label>
                                    <input type="text" name="website" class="w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                            </div>
                        </div>
                        <div class="custom-imformation pt-[30px]">
                            <h2 class="text-f30 font-bold mb-[20px]">{{$fcSystem['agency_14']}}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">{{$fcSystem['agency_15']}}</label>
                                    <textarea name="business" id="" cols="30" rows="10" class="w-full h-[100px] border border-gray-200 text-f15 p-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300"></textarea>
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">{{$fcSystem['agency_16']}} *</label>
                                    <input type="text" name="address1" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <label class="font-semibold">{{$fcSystem['agency_17']}}</label>
                                    <input type="text" name="address2" class="w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_18']}} *</label>
                                    <input type="text" name="city" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_19']}} *</label>
                                    <input type="text" name="code" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300" />
                                </div>
                                <div class="px-[5px] mb-3 space-y-2">
                                    <label class="font-semibold">{{$fcSystem['agency_20']}} *</label>
                                    <select name="country" class="validate[required] w-full h-[40px] border border-gray-200 text-f15 px-4 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300">
                                        @foreach(config('country') as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2 flex flex-col">
                                    <label class="font-semibold">{{$fcSystem['agency_21']}}</label>
                                    <input type="file" class="" name="file" id="upLoadFile">
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2 flex items-center font-semibold">
                                    <input type="checkbox" name="accept" value="1" class="validate[required] mr-[5px] w-4 h-4" />
                                    {{$fcSystem['agency_22']}}
                                </div>
                                <div class="px-[5px] mb-3 space-y-2 md:col-span-2">
                                    <button class="w-full py-2 bg-global text-center rounded-[5px] text-white font-bold border hover:bg-red-800 hover:text-white transition-all">
                                        {{$fcSystem['agency_23']}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('homepage.common.wholesale')
    @include('homepage.common.faqs')
    @if($slideFooter)
    @if($slideFooter->slides)
    <!-- SECTION DOWNLOAD + SLIDE -->
    <section class="download-slide course-home overflow-hidden py-[30px] wow fadeInUp">
        <div class="container mx-auto">
            <div class="wp-slide-ls slider-course">
                <div class="btn-slide btn-left-slide" id="navigation-left">
                    <div class="img-btn-left w-[50px] h-[50px] leading-[50px] text-center text-white bg-black">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                </div>
                <div class="btn-slide btn-right-slide w-[50px] h-[50px] leading-[50px] text-center text-white bg-black" id="navigation-right">
                    <div class="img-btn-right">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
                <div class="swiper-container slide-ls" id="slider-ls">
                    <div class="swiper-wrapper">
                        @foreach($slideFooter->slides as $slide)
                        <div class="swiper-slide">
                            <div class="item">
                                <div class="img">
                                    <a href="{{url($slide->link)}}"><img src="{{asset($slide->src)}}" alt="{{$slide->title}}" /></a>
                                </div>
                                <h3 class="title-2 text-f15 mt-[20px]">
                                    <a href="{{url($slide->link)}}" class="font-medium">{{$slide->title}}</a>
                                </h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </section>
    @endif
    @endif
</div>

@endsection
@push('css')
<style type="text/css">
    input[type=file]::-webkit-file-upload-button {
        -webkit-margin-start: -1rem;
        -webkit-margin-end: 1rem;
        background: #1f2937;
        border: 0;
        color: #fff;
        cursor: pointer;
        font-size: .875rem;
        font-weight: 500;
        margin-inline-end: 1rem;
        margin-inline-start: -1rem;
        padding: .625rem 1rem .625rem 2rem
    }

    input[type=file]::file-selector-button {
        -webkit-margin-start: -1rem;
        -webkit-margin-end: 1rem;
        background: #1f2937;
        border: 0;
        color: #fff;
        cursor: pointer;
        font-size: .875rem;
        font-weight: 500;
        margin-inline-end: 1rem;
        margin-inline-start: -1rem;
        padding: .625rem 1rem .625rem 2rem
    }

    input[type=file]::-webkit-file-upload-button:hover {
        background: #374151
    }

    input[type=file]::file-selector-button:hover {
        background: #374151
    }

    .dark input[type=file]::-webkit-file-upload-button {
        background: #4b5563;
        color: #fff
    }

    .dark input[type=file]::file-selector-button {
        background: #4b5563;
        color: #fff
    }

    .dark input[type=file]::-webkit-file-upload-button:hover {
        background: #6b7280
    }

    .dark input[type=file]::file-selector-button:hover {
        background: #6b7280
    }
</style>
@endpush
@push('javascript')
<script>
    $(document).ready(function() {
        $(".validate").validationEngine();
    });
</script>
<link rel="stylesheet" href="library/validationEngine/validationEngine.jquery.css">
@if (config('app.locale') == 'vi')
<script src="library/validationEngine/jquery.validationEngine-vi.js" charset="utf-8"></script>
@else
<script src="library/validationEngine/jquery.validationEngine-en.js" charset="utf-8"></script>
@endif

<script src="library/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript">
    $('#file-question').submit(function(e) {
        e.preventDefault();
        var formData = new FormData();
        var file_data = $('input[type="file"]')[0].files; // for multiple files
        for (var i = 0; i < file_data.length; i++) {
            formData.append("file", file_data[i]);
        }
        var other_data = $('#file-question').serializeArray();
        $.each(other_data, function(key, input) {
            formData.append(input.name, input.value);
        });
        $.ajax({
            type: 'POST',
            url: "<?php echo route('contactFrontend.agency') ?>",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.lds-show').removeClass('hidden');
            },
            complete: function() {
                $('.lds-show').addClass('hidden');
            },
            success: (data) => {
                if (data.status == 200) {
                    $("#file-question .print-error-msg").css('display', 'none');
                    $("#file-question .print-success-msg").css('display', 'block');
                    $("#file-question .print-success-msg span").html('<?php echo $fcSystem['message_5'] ?>');
                    toastr.success('<?php echo $fcSystem['message_5'] ?>', 'Success!')
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                } else {
                    $("#file-question .print-error-msg").css('display', 'block');
                    $("#file-question .print-success-msg").css('display', 'none');
                    $("#file-question .print-error-msg span").html(data.error);
                }
                $('html, body').animate({
                    scrollTop: $("#file-question").offset().top - 100
                }, 200);
            },
            error: function(response) {
                $("#file-question .print-error-msg").css('display', 'block');
                $("#file-question .print-success-msg").css('display', 'none');
                $("#file-question .print-error-msg span").html(response.responseJSON.message);
                $('html, body').animate({
                    scrollTop: $("#file-question").offset().top - 100
                }, 200);
            }
        });
    });
</script>
@include('homepage.common.loading')
@endpush
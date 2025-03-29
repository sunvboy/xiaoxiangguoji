@extends('homepage.layout.home')
@section('content')
<section class=" bg-[#399EEA]">
    <div class="container px-4">
        <div class="flex items-center h-[120px] justify-between">
            <ul class="flex wow fadeInLeft">
                <li><a href="" class="text-white text-[25px] font-bold">Trang chủ</a></li>
                <li><a href="" class="text-white text-[25px] font-bold">&nbsp;/&nbsp;{{$detail->title}}</a></li>
            </ul>
            <div>
                <ul class="flex space-x-[18px] wow fadeInRight">
                    <li><a href="" class="text-[#399EEA] font-bold rounded-full px-[39px] bg-[#C2E5FF] h-[55px] flex items-center justify-center">Lorem ipsum</a></li>
                    <li><a href="" class="text-[#399EEA] font-bold rounded-full px-[39px] bg-white h-[55px] flex items-center justify-center">Lorem ipsum</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<main class="mt-[60px] pb-[75px]">
    <div class="container px-4">
        <h1 class="wow fadeInDown text-[56px] SFProDisplay font-bold text-[#333] leading-normal text-center max-w-[950px] mx-auto">Trang tin tức cung cấp những kiến thức bổ ích về tiếng Nhật</h1>
        <div class="wow fadeInDown mt-10">
            <form class="relative w-[690px] mx-auto">
                <input class="SFProDisplay w-full h-[64px] rounded-full text-[#707EAE] pl-6" style="border: 2px solid rgba(112, 126, 174, 0.20);" placeholder="Bạn đang tìm kiếm thông tin gì?">
                <button class="absolute top-1/2 right-5 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#707EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20.9999 21L16.6499 16.65" stroke="#707EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </form>

        </div>
        <div class="mt-10 wow fadeInDown">
            <ul class="flex space-x-8 justify-center listChildCategory">
                <li><a href="" class="SFProDisplay flex px-6 py-3 rounded-[32px] border border-XANHCHNH text-XANHCHNH font-medium text-[20px] leading-7 active">Học tiếng Nhật</a></li>
                <li><a href="" class="SFProDisplay flex px-6 py-3 rounded-[32px] border border-XANHCHNH text-XANHCHNH font-medium text-[20px] leading-7">Kiến thức JLPT</a></li>
                <li><a href="" class="SFProDisplay flex px-6 py-3 rounded-[32px] border border-XANHCHNH text-XANHCHNH font-medium text-[20px] leading-7">Du học Nhật Bản</a></li>
            </ul>

        </div>
        @if(!empty($data))
        <div class="mt-10">
            @foreach ($data as $k => $item)
            @if($k==0)
            <div class="wow fadeInDown grid grid-cols-3 gap-[30px]">
                <div class="col-span-2">
                    <a href="{{route('routerURL', ['slug' => $item->slug])}}">
                        <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full h-[340px] object-cover rounded-[10px]" />
                    </a>
                </div>
                <div class="col-span-1 space-y-[17px]">
                    <h3><a href="{{route('routerURL',['slug' => $item->slug])}}" class="SFProDisplay text-[#333] text-[30px] font-bold leading-normal">{{$item->title}}</a></h3>
                    <div class="clamp clamp5 SFProDisplay">
                        {{strip_tags($item->description)}}
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="<?php echo asset('frontend/img/time.svg') ?>" alt="" />
                            <span class="text-sm SFProDisplay text-[#333]">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')}}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="<?php echo asset('frontend/img/viewed.svg') ?>" alt="" />
                            <span class="text-sm SFProDisplay text-[#333]">{{strip_tags($item->viewed)}} lượt xem</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

            <div class="wow fadeInDown grid grid-cols-3 gap-[30px] mt-[30px]">
                @foreach ($data as $k => $item)
                @if($k>0)
                <div class="space-y-[15px]">
                    <a href="{{route('routerURL',['slug' => $item->slug])}}">
                        <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full h-[198px] object-cover rounded-[10px]" />
                    </a>
                    <h3><a href="{{route('routerURL',['slug' => $item->slug])}}" class="SFProDisplay text-[#333] text-[24px] font-bold leading-normal">{{$item->title}}</a></h3>
                    <div class="clamp clamp3 SFProDisplay min-h-[72px]">
                        {{strip_tags($item->description)}}

                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="<?php echo asset('frontend/img/time.svg') ?>" alt="date" />
                            <span class="text-sm SFProDisplay text-[#333]">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')}}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="<?php echo asset('frontend/img/viewed.svg') ?>" alt="viewed" />
                            <span class="text-sm SFProDisplay text-[#333]">{{strip_tags($item->viewed)}} lượt xem</span>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div class="mt-10">
            <?php echo $data->links() ?>
        </div>
        @endif
        <div class="mt-[100px]">
            <div class="flex space-x-[50px]">
                <div class="w-[600px] p-6 rounded-[10px] wow fadeInLeft" style="box-shadow: 0px 7px 20px 0px rgba(0, 0, 0, 0.07);">
                    <div class="flex space-x-6 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17.9081 5.46363L18.6172 4.58173C19.589 3.37628 19.392 1.61508 18.176 0.649684L18.1313 0.613156C16.9179 -0.352244 15.1451 -0.156554 14.1733 1.0515L13.4668 1.93079L17.9081 5.46363Z" fill="#272727" />
                            <path d="M13.5929 12.8767C13.6166 13.0907 13.7243 13.2942 13.9055 13.4403C14.2706 13.7299 14.8037 13.6725 15.0953 13.3099L19.9673 7.25641C20.2641 6.8885 20.1984 6.34839 19.8176 6.06137C19.4499 5.78479 18.922 5.86307 18.633 6.22054L18.1577 6.81023L17.3435 6.16313L17.3461 6.16053L12.9074 2.625L1.55078 16.728L5.99206 20.2609L16.2903 7.47558L17.1045 8.12268L13.7742 12.2583C13.6271 12.4383 13.5693 12.6628 13.5929 12.8767Z" fill="#272727" />
                            <path d="M5.25392 20.9133L1.07001 17.5837C1.00172 17.816 0.967577 18.0195 0.967577 18.0195L0.00892694 22.5806C-0.0593604 22.9094 0.276824 23.1781 0.584117 23.0372L4.8547 21.1063C4.85208 21.1063 5.04118 21.028 5.25392 20.9133Z" fill="#272727" />
                            <path d="M23.3913 21.7302C23.3545 21.7302 23.3204 21.7328 23.2836 21.738L16.8305 22.5677C16.4996 22.6095 16.2685 22.2494 16.447 21.9676C16.5442 21.8189 16.6388 21.6676 16.7333 21.5163C16.9828 21.1145 16.6493 20.5796 16.187 20.5796C16.1555 20.5796 16.124 20.5822 16.0898 20.5874L7.63275 21.8502L6.62158 22.0015L3.86384 22.4138C3.5513 22.4608 3.34118 22.7243 3.36745 23.04C3.37795 23.1809 3.43573 23.3139 3.52766 23.4131C3.63534 23.5305 3.78505 23.5957 3.94789 23.5957C3.9794 23.5957 4.01092 23.5931 4.04506 23.5879L14.1253 22.0825C14.4694 22.0303 14.7057 22.4164 14.5035 22.6982C14.4378 22.7869 14.3722 22.8782 14.3065 22.9669C14.1253 23.2122 14.1673 23.6218 14.3774 23.8332C14.4851 23.9427 14.6217 24.0001 14.7661 24.0001C14.7819 24.0001 14.8003 24.0001 14.816 23.9975H14.8186H14.8213L23.5226 22.8965H23.5253H23.5279C23.6776 22.873 23.8089 22.7869 23.8956 22.6538C23.9902 22.5077 24.0243 22.3277 23.9823 22.1659C23.9139 21.9024 23.6828 21.7302 23.3913 21.7302Z" fill="#272727" />
                        </svg>
                        <span class="text-[20px] font-semibold SFProDisplay">ĐĂNG KÝ NHẬN TIN</span>
                    </div>
                    <div class="mt-6">
                        <form>
                            <div class="space-y-2">
                                <input class="rounded-[8px] bg-white border-[1.5px] border-[#E7E8F2] w-full px-4 py-[10px] text-sm outline-none focus:outline-none hover:outline-none" placeholder="Nhập họ và tên">
                                <input class="rounded-[8px] bg-white border-[1.5px] border-[#E7E8F2] w-full px-4 py-[10px] text-sm outline-none focus:outline-none hover:outline-none" placeholder="Email">
                                <input class="rounded-[8px] bg-white border-[1.5px] border-[#E7E8F2] w-full px-4 py-[10px] text-sm outline-none focus:outline-none hover:outline-none" placeholder="Số điện thoại">
                                <div class="flex justify-center">
                                    <button style="padding: 12px 60px;" class=" bg-[#399EEA] border-[1.5px] border-[#399EEA] rounded-full text-sm text-white font-bold outline-none focus:outline-none hover:outline-none">Gửi</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="flex-1">
                    <div class="h-full rounded-[10px] bg-[#F2F2F2] py-7 px-[44px] flex flex-col justify-between">
                        <div class="flex space-x-6 items-center">
                            <span class="w-[56px] h-[56px] rounded-full bg-[#399EEA]"></span>
                            <span class="text-[25px] SFProDisplay leading-7">Lorem ipsum dolor</span>
                        </div>
                        <div class="flex space-x-[30px]">
                            <a href="" class="flex space-x-5 items-center bg-[#E5E5E5] p-[5px]">
                                <img src="{{asset('frontend/img/fb.svg')}}" alt="icon fb" />
                                <span class="text-[#399EEA] font-bold text-sm SFProDisplay">Thích trang</span>
                            </a>
                            <a href="" class="flex space-x-5 items-center bg-[#E5E5E5] py-[5px] px-3">
                                <img src="{{asset('frontend/img/share.svg')}}" alt="icon fb" />
                                <span class="text-[#399EEA] font-bold text-sm SFProDisplay">Chia sẻ</span>
                            </a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</main>
<style>
    header {
        position: relative !important;
    }
</style>
@endsection
@push('javascript')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v19.0&appId=2586825361606351" nonce="D7NC7yyZ"></script>
@endpush
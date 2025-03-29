@extends('homepage.layout.home')
@section('content')
<main class="">
    <section class="relative">
        <img src="<?php echo asset($detail->image) ?>" alt="{{$detail->title}}" class="w-full h-[170px] md:h-auto object-cover">
        <div class="absolute w-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 md:space-y-3 text-center">
            <h1 class="w-full text-2xl md:text-f40 font-bold text-white uppercase">{{$detail->title}}</h1>
            <nav class="bg-grey-light w-full" aria-label="breadcrumb">
                <ol class="flex justify-center">
                    <li><a href="{{url('')}}" class="text-white hover:text-[#a82cb9]">Trang chủ</a></li>
                    @foreach($breadcrumb as $k=>$v)
                    <li><span class="text-gray-500 mx-2">/</span></li>
                    <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-white hover:text-[#a82cb9]">{{ $v->title}}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </section>
    <section class="py-[50px] wow fadeInLeft">
        <div class="container px-4 md:px-0">
            <div class="space-y-5">
                <ul class="flex flex-wrap space-x-0 md:space-x-3 space-y-3 md:space-y-0 justify-center">
                    <li class="">
                        <a href="" class="onyx_item_banner_more flex justify-center items-center text-white text-lg" style=" background: url(<?php echo asset('frontend/images/bg-download-vanban.png') ?>)">
                            Bảng giá dịch vụ
                        </a>
                    </li>
                    <li>
                        <a href="" class="onyx_item_banner_more flex justify-center items-center text-black text-lg" style=" background: url(<?php echo asset('frontend/images/bg-download-vanban-none.png') ?>)">
                            Bản khai tên miền
                        </a>
                    </li>
                    <li>
                        <a href="" class="onyx_item_banner_more flex justify-center items-center text-black text-lg" style=" background: url(<?php echo asset('frontend/images/bg-download-vanban-none.png') ?>)">
                            Tài liệu tham khảo
                        </a>
                    </li>
                </ul>
                <div>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-gradient-to-r from-[#73225f] via-[#ed004d] to-[#ffce00]">
                                    <th scope="col" class="py-3 px-6 text-white font-bold">
                                        STT
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-white font-bold">
                                        Tên tài liệu
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-white font-bold">
                                        Dung lượng
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-white font-bold">
                                        Định dạng
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-white font-bold">
                                        Tải về
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 11; $i++) { ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6">
                                            {{$i}}
                                        </td>
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Apple MacBook Pro 17"
                                        </th>

                                        <td class="py-4 px-6">
                                            Laptop
                                        </td>
                                        <td class="py-4 px-6">
                                            $2999
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </section>
</main>
<style>
    .onyx_item_banner_more {
        width: 238px;
        height: 50px;
        background-size: 100% 100%
    }

    thead tr th:last-child {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    thead tr th:first-child {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }
</style>
@endsection
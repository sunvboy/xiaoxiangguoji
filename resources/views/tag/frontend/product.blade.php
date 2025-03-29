@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb('Tag: '.$detail->title)!!}
<main class="">
    <h1 class="title-primary text-center text-f28 uppercase font-bold">
        {{'Tag: '.$detail->title}}
    </h1>
    <div class="py-5 grid md:grid-cols-12">
        <div class="md:col-span-3 bg-[#F3F3F3]">
            <div class="p-5 md:p-[50px]">
                <nav class="list-type">
                    <h4 class="text-f18 border-b border-global pb-[5px] BoldC text-[#333333] uppercase font-bold" style="letter-spacing: 2px;line-height: 29px;">TAGS</h4>
                    <ul class="js_ul_ct flex flex-wrap mt-5">
                        <li class="active">
                            <a href="{{route('tagURL',['slug'=>$detail->slug])}}" class="text-base hover:bg-global hover:text-white border float-left mr-2 mb-2 px-2 py-1" style="letter-spacing: 2px;line-height: 29px;">#{{$detail->title}}</a>
                        </li>
                        @if(!$listTags->isEmpty())
                        @foreach($listTags as $item)
                        <li class="">
                            <a href="{{route('tagURL',['slug'=>$item->slug])}}" class="text-base hover:bg-global hover:text-white border float-left mr-2 mb-2 px-2 py-1" style="letter-spacing: 2px;line-height: 29px;">#{{$item->title}}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

        <div class="md:col-span-9 px-4 md:px-8">
            @if(!empty($detail->description))
            <div class="text-base mb-5" style="letter-spacing: 1px;">
                <?php echo $detail->description ?>
            </div>
            @endif
            @if($data)
            <div class="flex flex-wrap justify-start mx-[-5px] md:mx-[-2px]" id="js_data_product_filter">

                @foreach($data as $key=>$item)
                <div class="w-1/2 md:w-1/3 px-[5px] md:px-[2px]">
                    <?php echo htmlItemProduct($key, $item->products, 'item item-product mb-[15px] md:mb-[30px]') ?>
                </div>
                @endforeach
            </div>
            <div class="my-10 flex justify-center">
                <?php echo $data->links() ?>
            </div>
            @endif
        </div>
    </div>
</main>

@endsection

@push('css')
<style>
    .js_ul_ct li.active a {
        font-weight: bold;
    }

    .js_ul_ct li {
        margin-bottom: 5px;
    }
</style>

@endpush
@extends('dashboard.layout.dashboard')

@section('title')
<title>Cấu hình</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => 'javascript:void(0)',
    ],
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">

    <div class="box p-6 mt-7 flex flex-col items-center" style="padding:24px">

        <div class="grid grid-cols-12 gap-6 w-full ">
            @foreach (config('generals') as $key=>$item)
            @if(in_array($item['module'], $dropdown))
            @if(!empty($item['permission']))
            @can($item['permission'])
            <a href="{{route($item['href'])}}" class="col-span-3 px-4 py-3 flex" style="background-color: #F2F9FF">
                <div class="" style="width: 32px;">
                    <?php echo $item['svg'] ?>
                </div>
                <div class="flex-1 ml-2 ">
                    <h6 class="font-bold">{{$item['name']}}</h6>
                    <div class="mt-1">
                        {{$item['description']}}
                    </div>
                </div>
            </a>
            @endcan
            @else
            <a href="{{route($item['href'])}}" class="col-span-3 px-4 py-3 flex" style="background-color: #F2F9FF">
                <div class="" style="width: 32px;">
                    <?php echo $item['svg'] ?>
                </div>
                <div class="flex-1 ml-2 ">
                    <h6 class="font-bold">{{$item['name']}}</h6>
                    <div class="mt-1">
                        {{$item['description']}}
                    </div>
                </div>
            </a>
            @endif
            @endif
            @endforeach


        </div>

    </div>
</div>
@endsection
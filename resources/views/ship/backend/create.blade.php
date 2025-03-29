@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới vận chuyển</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Danh sách vận chuyển",
        "src" => route('ships.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới vận chuyển
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('ships.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <ul class="nav nav-link-tabs flex-wrap" role="tablist">
                <li id="example-homepage-tab" class="nav-item" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-homepage" type="button" role="tab" aria-controls="example-tab-homepage" aria-selected="true">Thông tin chung</button>
                </li>
            </ul>
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div class="tab-content">
                    <div id="example-tab-homepage" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-homepage-tab">
                        <div>
                            <label class="form-label text-base font-semibold">Tiêu đề</label>
                            <?php echo Form::text('title', '', ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-5">
                            <label class="form-label text-base font-semibold">API URL</label>
                            <?php echo Form::text('URL_API', '', ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-5">
                            <label class="form-label text-base font-semibold">TOKEN API</label>
                            <?php echo Form::text('TOKEN_API', '', ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="text-right mt-5">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>

                    </div>

                </div>

            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@endsection
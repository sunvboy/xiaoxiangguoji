@extends('dashboard.layout.dashboard')
@section('title')
<title>Cập nhập</title>
@endsection
<!--START: breadcrumb -->
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Cấu hình thanh toán",
        "src" => route('orders.config'),
    ],
    [
        "title" => "Cập nhập",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
<!--END: breadcrumb -->
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('orders.configUpdate',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <ul class="nav nav-link-tabs flex-wrap" role="tablist">
                <li id="example-homepage-tab" class="nav-item" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-homepage" type="button" role="tab" aria-controls="example-tab-homepage" aria-selected="true">Thông tin chung</button>
                </li>
                <li id="example-config-tab" class="nav-item" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-config" type="button" role="tab" aria-controls="example-tab-config" aria-selected="true">
                        @if($detail->id == 3)
                        Cấu hình VNPAY
                        @elseif($detail->id == 4)
                        Cấu hình MOMO
                        @endif
                    </button>
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
                            <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full', 'required']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Mô tả</label>
                            <div class="mt-2">
                                <?php echo Form::textarea('description', $detail->description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                            </div>
                        </div>

                    </div>
                    <div id="example-tab-config" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-config-tab">
                        <?php
                        $jsonConfig = json_decode($detail->config, TRUE);
                        ?>

                        @if($detail->id == 3)
                        <div>
                            <label class="form-label text-base font-semibold">TmnCode</label>
                            <?php echo Form::text('config[TmnCode]', !empty($jsonConfig['TmnCode']) ? $jsonConfig['TmnCode'] : '', ['class' => 'form-control w-full', '']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">HashSecret</label>
                            <?php echo Form::text('config[HashSecret]', !empty($jsonConfig['HashSecret']) ?  $jsonConfig['HashSecret'] : '', ['class' => 'form-control w-full', '']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Url</label>
                            <?php echo Form::text('config[Url]', !empty($jsonConfig['Url']) ? $jsonConfig['Url'] : '', ['class' => 'form-control w-full', '']); ?>
                        </div>
                        @elseif($detail->id == 4)
                        <div>
                            <label class="form-label text-base font-semibold">endpoint</label>
                            <?php echo Form::text('config[endpoint]', !empty($jsonConfig['endpoint']) ? $jsonConfig['endpoint'] : '', ['class' => 'form-control w-full', 'required']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">partnerCode</label>
                            <?php echo Form::text('config[partnerCode]', !empty($jsonConfig['partnerCode']) ? $jsonConfig['partnerCode'] : '', ['class' => 'form-control w-full', 'required']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">accessKey</label>
                            <?php echo Form::text('config[accessKey]', !empty($jsonConfig['accessKey']) ? $jsonConfig['accessKey'] : '', ['class' => 'form-control w-full', 'required']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">secretKey</label>
                            <?php echo Form::text('config[secretKey]', !empty($jsonConfig['secretKey']) ? $jsonConfig['secretKey'] : '', ['class' => 'form-control w-full', 'required']); ?>
                        </div>
                        @endif

                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                    </div>
                </div>

            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>

@endsection
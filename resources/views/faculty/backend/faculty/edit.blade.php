@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập các phòng,khoa</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các phòng,khoa",
        "src" => route('faculties.index'),
    ],
    [
        "title" => "Cập nhập",
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
            Cập nhập các phòng,khoa
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('faculties.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
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
                        @include('faculty.backend.faculty.form',['action' => 'update'])
                    </div>
                </div>

            </div>
            <!-- END: Album Ảnh -->
            <div class=" box p-5 mt-3">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            @include('polylang.edit')
            <div class="box p-5 pt-3">
                <div>
                    <label class="form-label text-base font-semibold">Chọn nhóm</label>
                    <?php echo Form::select('faculty_category_id', $htmlCatalogue, !empty(old('faculty_category_id')) ? old('faculty_category_id') : (!empty($detail->faculty_category_id) ? $detail->faculty_category_id : ''), ['class' => 'tom-select-custom tom-select w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
            </div>
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@endsection
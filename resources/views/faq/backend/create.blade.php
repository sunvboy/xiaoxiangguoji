@extends('dashboard.layout.dashboard')

@section('title')

<title>{{!empty($action == 'create') ? 'Thêm mới câu hỏi thường gặp' : 'Cập nhập câu hỏi thường gặp'}}</title>

@endsection

@section('breadcrumb')

<?php

if ($action == 'create') {

    $array = array(

        [

            "title" => "Danh sách câu hỏi thường gặp",

            "src" => route('faqs.index'),

        ],

        [

            "title" => "Thêm mới",

            "src" => 'javascript:void(0)',

        ]

    );
} else {

    $array = array(

        [

            "title" => "Danh sách câu hỏi thường gặp",

            "src" => route('faqs.index'),

        ],

        [

            "title" => "Cập nhập",

            "src" => 'javascript:void(0)',

        ]

    );
}



echo breadcrumb_backend($array);

?>

@endsection

@section('content')

<div class="content">

    <div class=" flex items-center mt-8">

        <h1 class="text-lg font-medium mr-auto">

            {{!empty($action == 'create') ? 'Thêm mới câu hỏi thường gặp' : 'Cập nhập câu hỏi thường gặp'}}

        </h1>

    </div>

    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{!empty($action == 'create') ? route('faqs.store') : route('faqs.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">

        <div class=" col-span-12 lg:col-span-12">

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

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="form-label text-base font-semibold">Tiêu đề</label>
                                <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail) ? $detail->title : ''), ['class' => 'form-control w-full']); ?>
                            </div>
                            <div>
                                <label class="form-label text-base font-semibold">Danh mục</label>
                                <?php echo Form::select('catalogue_id', $categories, !empty(old('catalogue_id')) ? old('catalogue_id') : (!empty($detail) ? $detail->catalogue_id : ''), ['class' => 'tom-select tom-select-custom w-full layout', 'data-placeholder' => "Select your favorite actors"]); ?>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="form-label text-base font-semibold">Họ và tên người hỏi</label>
                            <?php echo Form::text('name', !empty(old('name')) ? old('name') : (!empty($detail) ? $detail->name : ''), ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-5">

                            <label class="form-label text-base font-semibold">Nội dung</label>

                            <?php echo Form::textarea('content', !empty(old('content')) ? old('content') : (!empty($detail) ? $detail->content : ''), ['id' => 'ckContent', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>

                        </div>
                        <div class="mt-5">
                            <label class="form-label text-base font-semibold">Trả lời</label>

                            <?php echo Form::textarea('reply', !empty(old('reply')) ? old('reply') : (!empty($detail) ? $detail->reply : ''), ['id' => 'ckContent1', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>

                        </div>
                        <div class="text-right mt-5">

                            <button type="submit" class="btn btn-primary">Lưu</button>

                        </div>

                    </div>



                </div>



            </div>

        </div>



    </form>

</div>

@endsection
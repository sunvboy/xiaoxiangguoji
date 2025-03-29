@extends('dashboard.layout.dashboard')

@section('title')

<title>{{!empty($action == 'create') ? 'Thêm mới đội ngũ bác sỹ' : 'Cập nhập đội ngũ bác sỹ'}}</title>

@endsection

@section('breadcrumb')

<?php

if ($action == 'create') {

    $array = array(

        [

            "title" => "Danh sách đội ngũ bác sỹ",

            "src" => route('teams.index'),

        ],

        [

            "title" => "Thêm mới",

            "src" => 'javascript:void(0)',

        ]

    );
} else {

    $array = array(

        [

            "title" => "Danh sách đội ngũ bác sỹ",

            "src" => route('teams.index'),

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

            {{!empty($action == 'create') ? 'Thêm mới đội ngũ bác sỹ' : 'Cập nhập đội ngũ bác sỹ'}}

        </h1>

    </div>

    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{!empty($action == 'create') ? route('teams.store') : route('teams.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">

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

                            <label class="form-label text-base font-semibold">Họ và tên</label>

                            <?php echo Form::text('name', !empty(old('name')) ? old('name') : (!empty($detail) ? $detail->name : ''), ['class' => 'form-control w-full']); ?>

                        </div>

                        <div class="mt-5">

                            <label class="form-label text-base font-semibold">Chức vụ</label>

                            <?php echo Form::text('job', !empty(old('job')) ? old('job') : (!empty($detail) ? $detail->job : ''), ['class' => 'form-control w-full']); ?>

                        </div>
                        <div class="mt-5">

                            <label class="form-label text-base font-semibold">Quá trình đào tạo - công tác</label>

                            <?php echo Form::textarea('dao_tao', !empty(old('dao_tao')) ? old('dao_tao') : (!empty($detail) ? $detail->dao_tao : ''), ['id' => 'ckDescription', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>

                        </div>
                        <div class="mt-5">

                            <label class="form-label text-base font-semibold">Thế mạnh, kinh nghiệm công tác</label>
                            <?php echo Form::textarea('the_manh', !empty(old('the_manh')) ? old('the_manh') : (!empty($detail) ? $detail->the_manh : ''), ['id' => 'ckDescription2', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>


                        </div>
                        <div class="text-right mt-5">

                            <button type="submit" class="btn btn-primary">Lưu</button>

                        </div>

                    </div>



                </div>



            </div>

        </div>

        <div class=" col-span-12 lg:col-span-4">

            @include('components.image',['action' => $action,'name' => 'image','title'=> 'Ảnh đại diện'])

        </div>

    </form>

</div>

@endsection
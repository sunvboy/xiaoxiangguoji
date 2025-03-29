@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới chi nhánh</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Danh sách chi nhánh",
        "src" => route('addresses.index'),
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
            Thêm mới chi nhánh
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('addresses.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8 mt-3">
            <!-- BEGIN: Form Layout -->
            <div class="box p-5 ">
                @include('components.alert-error')
                @csrf
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Tên chi nhánh</label>
                        <?php echo Form::text('title', '', ['class' => 'form-control']); ?>
                    </div>
                    <div class="col-span-3 hidden">
                        <label class="form-label text-base font-semibold">Email</label>
                        <div class="">
                            <?php echo Form::text('email', '', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Số điện thoại</label>
                        <div class="">
                            <?php echo Form::text('hotline', '', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Địa chỉ</label>
                        <div class="">
                            <?php echo Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Số 33 ngõ 629 Kim Mã']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Iframe google map</label>
                        <div class="">
                            <?php echo Form::textarea('iframe', '', ['class' => 'form-control', 'placeholder' => '']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Link chỉ đường</label>
                        <div class="">
                            <?php echo Form::text('link', '', ['class' => 'form-control', 'placeholder' => '']); ?>
                        </div>
                    </div>
                    <div class="col-span-3 md:col-span-1">
                        <label class="form-label text-base font-semibold">Tỉnh/Thành phố</label>
                        <div class="">
                            <?php echo Form::select('cityid', $listCity, '', ['class' => 'form-control tom-select tom-select-custom', 'id' => 'cityID']); ?>
                        </div>
                    </div>
                    <div class="col-span-3 md:col-span-1">
                        <label class="form-label text-base font-semibold">Quận/Huyện</label>
                        <div class="">
                            <?php echo Form::select('districtid', $listDistrict, '', ['class' => 'form-control', 'id' => 'districtID', 'placeholder' => 'Quận/Huyện']); ?>
                        </div>
                    </div>
                    <div class="col-span-3 md:col-span-1">
                        <label class="form-label text-base font-semibold">Phường/Xã</label>
                        <div class="">
                            <?php echo Form::select('wardid', $listWard, '', ['class' => 'form-control', 'id' => 'wardID', 'placeholder' => 'Phường/Xã']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label class="form-label text-base font-semibold">Thời gian làm việc</label>
                        <div class="">
                            <?php echo Form::text('time', '', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-span-3">
                        @include('components.dropzone',['action' => 'create'])
                    </div>
                    <div class="text-right mt-5 col-span-3">
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class="col-span-12 lg:col-span-4">
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@endsection
@include('address.backend.script')
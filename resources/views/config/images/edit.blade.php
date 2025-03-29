@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới </title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Danh sách ",
        "src" => route('config_images.index'),
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
            Thêm mới
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('config_images.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class="col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Module</label>
                    <input type="text" class="form-control" value="<?php echo $detail->module ?>" disabled>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Thumbnail</label>
                    <?php
                    $data = json_decode($detail->data, TRUE);
                    ?>
                    <div class=" box p-5">
                        <div class="mt-3 grid grid-cols-5 items-center gap-6">
                            <label class="form-label text-base font-semibold col-span-1">Small</label>
                            <?php echo Form::text('data[type][]', !empty($data) ? (!empty($data['type'][0]) ? $data['type'][0] : '') : '', ['class' => 'form-control hidden', 'required']); ?>
                            <?php echo Form::text('data[with][]', !empty($data) ? (!empty($data['with'][0]) ? $data['with'][0] : '') : '', ['class' => 'form-control', 'required']); ?>
                            <?php echo Form::text('data[height][]', !empty($data) ? (!empty($data['height'][0]) ? $data['height'][0] : '') : '', ['class' => 'form-control', 'required']); ?>
                        </div>
                        <div class="mt-3 grid grid-cols-5 items-center gap-6">
                            <label class="form-label text-base font-semibold col-span-1">Medium</label>
                            <?php echo Form::text('data[type][]', !empty($data) ? (!empty($data['type'][1]) ? $data['type'][1] : '') : '', ['class' => 'form-control hidden', 'required']); ?>

                            <?php echo Form::text('data[with][]', !empty($data) ? (!empty($data['with'][1]) ? $data['with'][1] : '') : '', ['class' => 'form-control', 'required']); ?>
                            <?php echo Form::text('data[height][]', !empty($data) ? (!empty($data['height'][1]) ? $data['height'][1] : '') : '', ['class' => 'form-control', 'required']); ?>
                        </div>
                        <div class="mt-3 grid grid-cols-5 items-center gap-6">
                            <label class="form-label text-base font-semibold col-span-1">Large</label>
                            <?php echo Form::text('data[type][]', !empty($data) ? (!empty($data['type'][2]) ? $data['type'][2] : '') : '', ['class' => 'form-control hidden', 'required']); ?>
                            <?php echo Form::text('data[with][]', !empty($data) ? (!empty($data['with'][2]) ? $data['with'][2] : '') : '', ['class' => 'form-control', 'required']); ?>
                            <?php echo Form::text('data[height][]', !empty($data) ? (!empty($data['height'][2]) ? $data['height'][2] : '') : '', ['class' => 'form-control', 'required']); ?>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary btn-submit">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>

    </form>
</div>
@endsection
@push('javascript')

@endpush
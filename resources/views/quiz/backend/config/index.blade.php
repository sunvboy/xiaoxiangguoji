@extends('dashboard.layout.dashboard')
@section('title')
<title>Cấu hình đề thi</title>
@endsection
<!--START: breadcrumb -->
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình đề thi",
        "src" => route('quiz_configs.index'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
<!--END: breadcrumb -->
@section('content')
<div class="content">
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('quiz_configs.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class="col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div class="tab-content">
                    <div id="example-tab-homepage" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-homepage-tab">
                        <div>
                            <label class="form-label text-base font-semibold">Số câu trắc nghiệm</label>
                            <?php echo Form::text('experience', $detail->experience, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Số câu nói</label>
                            <?php echo Form::text('speak', $detail->speak, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Số câu tự luận</label>
                            <?php echo Form::text('essay', $detail->essay, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Số điểm câu trắc nghiệm</label>
                            <?php echo Form::text('mark_experience', $detail->mark_experience, ['class' => 'form-control w-full']); ?>
                        </div>
                        <div class="text-right mt-5">
                            <button type="submit" class="btn btn-primary w-24">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </form>
</div>
@endsection
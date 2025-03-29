@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới nguy cơ bệnh</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách nguy cơ bệnh",
        "src" => route('quizzes.index'),
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
            Thêm mới nguy cơ bệnh
        </h1>
    </div>
    <?php /*<div class="box p-5  mt-3">
        <form class="space-y-2" role="form" action="{{route('quizzes.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label class="form-label text-base font-semibold">Import file word</label>
            <div>
                <input type="file" name="file" id="file">
            </div>
            <div>
                <button id="upload" class="btn btn-success text-white" type="submit">Xác nhận</button>
            </div>
        </form>
    </div>*/ ?>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('quizzes.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">

            <div class="box p-5">
                @include('components.alert-error')
                @csrf

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full title']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Đường dẫn</label>
                    <div class="input-group">
                        <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                        </div>
                        <?php echo Form::text('slug', '', ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                    </div>
                </div>
                <div class="mt-3 hidden">
                    <label class="form-label text-base font-semibold">Kết quả</label>
                    <?php echo Form::textarea('description', '', ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Miễn trừ trách nhiệm</label>
                    <?php echo Form::textarea('mien_tru', '', ['id' => 'ckMienTru', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Video</label>
                    <?php echo Form::textarea('video', '', ['class' => 'form-control']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Sản phẩm</label>
                    <?php echo Form::select('products[]', $products, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Tin tức</label>
                    <?php echo Form::select('articles[]', $articles, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
                <div class="grid grid-cols-2 gap-4 hidden">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Cấp bậc</label>
                        <?php echo Form::select('customer_levels[]', $customer_levels, old('customer_levels'), ['class' => 'form-control w-full tom-select tom-select-custom', 'placeholder' => '', 'multiple']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Lớp học</label>
                        <?php echo Form::select('customer_catalogue_id[]', $category, old('customer_catalogue_id'), ['class' => 'form-control w-full tom-select tom-select-custom', 'placeholder' => '', 'multiple']); ?>
                    </div>

                </div>
                <div class="grid grid-cols-2 gap-4 hidden">

                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Thời gian làm bài(phút)</label>
                        <?php echo Form::text('time', old('time'), ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Điều kiện qua (% đúng)</label>
                        <?php echo Form::text('prerequisites', old('prerequisites'), ['class' => 'form-control w-full']); ?>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-3 hidden">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Câu hỏi trắc nghiệm</label>
                        <?php echo Form::text('count_experience', !empty(old('count_experience')) ? old('count_experience') : (!empty($config->experience) ? $config->experience : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Câu hỏi tự luận</label>
                        <?php echo Form::text('count_essay', !empty(old('count_essay')) ? old('count_essay') : (!empty($config->essay) ? $config->essay : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 hidden">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Câu hỏi nói</label>
                        <?php echo Form::text('count_speak',  !empty(old('  ')) ? old('count_speak') : (!empty($config->speak) ? $config->speak : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Điểm trắc nghiệm</label>
                        <?php echo Form::text('score', !empty(old('score')) ? old('score') : (!empty($config->mark_experience) ? $config->mark_experience : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                </div>
            </div>
            <div class="box p-5 mt-5">
                <div id="faq-accordion-1" class="accordion mt-3">
                    <div class="accordion-item flex space-x-5 font-bold text-danger items-center">
                        <div style="width: 2%;">
                            <input class="form-check-input" type="checkbox" value="" id="checkbox-all-quiz">
                        </div>
                        <div style="width: 10%;" class="text-center">
                            Vị trí
                        </div>
                        <div class="flex-1 flex justify-between items-center">
                            <span>Câu hỏi</span>
                            <div class="flex items-center space-x-2">

                                <button type="button" class="btn btn-success btn-sm text-white btnStoreQuiz <?php if (!empty($experienceData) && count($experienceData) > 0) { ?>disabled<?php } ?>">Tạo đề</button>

                                <a href="javascript:void(0)" class="btn btn-danger btn-sm disabled" id="ajax-delete-quiz">Xóa những mục đã chọn</a>
                            </div>

                        </div>
                    </div>
                    <div id="load-quiz" class="mt-3">
                        @include('quiz.backend.quiz.data')
                    </div>
                </div>
                <hr class="my-2" style="margin: 20px 0px;">
                <div class="relative">
                    <div>
                        <label class="form-label text-base font-semibold">
                            <div class="flex items-center space-x-3">
                                <span> Chọn câu hỏi</span>
                                <ul class="flex items-center space-x-2">
                                    <li class="flex items-center space-x-1">
                                        <span style="float: left;width: 10px;height: 10px;background-color: #ea580c;"></span>
                                        <span style="color:#ea580c">Trắc nghiệm</span>
                                    </li>
                                    <li class="flex items-center space-x-1 hidden">
                                        <span style="float: left;width: 1sss0px;height: 10px;background-color: #4f46e5;"></span>
                                        <span style="color:#4f46e5">Tự luận</span>
                                    </li>
                                    <li class="flex items-center space-x-1 hidden">
                                        <span style="float: left;width: 10px;height: 10px;background-color:#059669;"></span>
                                        <span style="color:#059669">Nói</span>
                                    </li>
                                </ul>

                            </div>
                        </label>
                        <?php echo Form::text('question', '', ['class' => 'form-control w-full']); ?>
                    </div>
                    <ul class="absolute w-full top-full left-0 shadow-sm p-2 bg-white space-y-1 ulDropdown hidden" style="top:100%;z-index: 99999;">
                    </ul>
                </div>
            </div>
            <div class=" box p-5 mt-3">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
        <div class=" col-span-12 lg:col-span-4" style="margin-top: -12px;">
            <div class="box p-5 pt-3 hidden">
                <div>
                    <label class="form-label text-base font-semibold">Chọn danh mục chính</label>
                    <?php echo Form::select('catalogue_id', $htmlCatalogue, old('catalogue_id'), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                    <?php echo Form::select('catalogue[]', $htmlCatalogue, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
            </div>
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            <div class="box p-5 pt-3 mt-3">
                <div>
                    <label class="form-label text-base font-semibold">Nguy cơ thấp</label>
                    <?php echo Form::text('thap_title', '', ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nguy cơ thấp - Mô tả</label>
                    <?php echo Form::textarea('thap_description', '', ['class' => 'form-control']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nguy cơ thấp - Lời khuyên từ chuyên gia</label>
                    <?php echo Form::textarea('thap_content', '', ['id' => 'ckDescriptionT2', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
            </div>
            <div class="box p-5 pt-3 mt-3">
                <div>
                    <label class="form-label text-base font-semibold">Nguy cơ cao</label>
                    <?php echo Form::text('cao_title', '', ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nguy cơ thấp - Mô tả</label>
                    <?php echo Form::textarea('cao_description', '', ['class' => 'form-control']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nguy cơ thấp - Lời khuyên từ chuyên gia</label>
                    <?php echo Form::textarea('cao_content', '', ['id' => 'ckDescriptionC2', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                </div>
            </div>
            @include('components.publish')
        </div>
    </form>
</div>
@endsection
@push('javascript')

@include('quiz.backend.quiz.script')
@endpush
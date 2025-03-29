
<?php $__env->startSection('title'); ?>
<title>Thêm mới đề thi</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách đề thi",
        "src" => route('quizzes.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới đề thi
        </h1>
    </div>
    <div class="box p-5  mt-3">
        <form class="space-y-2" role="form" action="<?php echo e(route('quizzes.import')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <label class="form-label text-base font-semibold">Import file word</label>
            <div>
                <input type="file" name="file" id="file">
            </div>
            <div>
                <button id="upload" class="btn btn-success text-white" type="submit">Xác nhận</button>
            </div>
        </form>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('quizzes.store')); ?>" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">

            <div class="box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>

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
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Cấp bậc</label>
                        <?php echo Form::select('customer_levels[]', $customer_levels, old('customer_levels'), ['class' => 'form-control w-full tom-select tom-select-custom', 'placeholder' => '', 'multiple']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Lớp học</label>
                        <?php echo Form::select('customer_catalogue_id[]', $category, old('customer_catalogue_id'), ['class' => 'form-control w-full tom-select tom-select-custom', 'placeholder' => '', 'multiple']); ?>
                    </div>

                </div>
                <div class="grid grid-cols-2 gap-4">

                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Thời gian làm bài(phút)</label>
                        <?php echo Form::text('time', old('time'), ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Điều kiện qua (% đúng)</label>
                        <?php echo Form::text('prerequisites', old('prerequisites'), ['class' => 'form-control w-full']); ?>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Câu hỏi trắc nghiệm</label>
                        <?php echo Form::text('count_experience', !empty(old('count_experience')) ? old('count_experience') : (!empty($config->experience) ? $config->experience : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Câu hỏi tự luận</label>
                        <?php echo Form::text('count_essay', !empty(old('count_essay')) ? old('count_essay') : (!empty($config->essay) ? $config->essay : 0), ['class' => 'form-control w-full']); ?>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
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
                        <?php echo $__env->make('quiz.backend.quiz.data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                    <li class="flex items-center space-x-1">
                                        <span style="float: left;width: 1sss0px;height: 10px;background-color: #4f46e5;"></span>
                                        <span style="color:#4f46e5">Tự luận</span>
                                    </li>
                                    <li class="flex items-center space-x-1">
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
                <?php echo $__env->make('components.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
        <div class=" col-span-12 lg:col-span-4">
            <div class=" box p-5 pt-3">
                <div>
                    <label class="form-label text-base font-semibold">Chọn danh mục chính</label>
                    <?php echo Form::select('catalogue_id', $htmlCatalogue, old('catalogue_id'), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                    <?php echo Form::select('catalogue[]', $htmlCatalogue, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Select your favorite actors"]); ?>
                </div>
            </div>
            <?php echo $__env->make('components.publish', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php echo $__env->make('quiz.backend.quiz.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/quiz/create.blade.php ENDPATH**/ ?>
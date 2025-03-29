
<?php $__env->startSection('title'); ?>
<title>Cấu hình đề thi</title>
<?php $__env->stopSection(); ?>
<!--START: breadcrumb -->
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Cấu hình đề thi",
        "src" => route('quiz_configs.index'),
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<!--END: breadcrumb -->
<?php $__env->startSection('content'); ?>
<div class="content">
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('quiz_configs.update',['id' => $detail->id])); ?>" method="post" enctype="multipart/form-data">
        <div class="col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/config/index.blade.php ENDPATH**/ ?>
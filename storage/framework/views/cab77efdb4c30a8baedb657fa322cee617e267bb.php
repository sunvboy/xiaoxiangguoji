<?php $__env->startSection('title'); ?>

<title><?php echo e(!empty($action == 'create') ? 'Thêm mới nhóm câu hỏi thường gặp' : 'Cập nhập nhóm câu hỏi thường gặp'); ?></title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>

<?php

if ($action == 'create') {

    $array = array(

        [

            "title" => "Danh sách nhóm câu hỏi thường gặp",

            "src" => route('faq_categories.index'),

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

            "src" => route('faq_categories.index'),

        ],

        [

            "title" => "Cập nhập",

            "src" => 'javascript:void(0)',

        ]

    );
}



echo breadcrumb_backend($array);

?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <div class=" flex items-center mt-8">

        <h1 class="text-lg font-medium mr-auto">

            <?php echo e(!empty($action == 'create') ? 'Thêm mới câu hỏi thường gặp' : 'Cập nhập câu hỏi thường gặp'); ?>


        </h1>

    </div>

    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(!empty($action == 'create') ? route('faq_categories.store') : route('faq_categories.update',['id' => $detail->id])); ?>" method="post" enctype="multipart/form-data">

        <div class=" col-span-12 lg:col-span-12">

            <ul class="nav nav-link-tabs flex-wrap" role="tablist">

                <li id="example-homepage-tab" class="nav-item" role="presentation">

                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-homepage" type="button" role="tab" aria-controls="example-tab-homepage" aria-selected="true">Thông tin chung</button>

                </li>



            </ul>

            <!-- BEGIN: Form Layout -->

            <div class=" box p-5">

                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo csrf_field(); ?>

                <div class="tab-content">

                    <div id="example-tab-homepage" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-homepage-tab">

                        <div>

                            <label class="form-label text-base font-semibold">Tiêu đề</label>

                            <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail) ? $detail->title : ''), ['class' => 'form-control w-full title']); ?>

                        </div>
                        <div class="mt-3">
                            <label class="form-label text-base font-semibold">Đường dẫn</label>
                            <div class="input-group">
                                <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                                </div>
                                <?php echo Form::text('slug', !empty(old('slug')) ? old('slug') : (!empty($detail) ? $detail->slug : ''), ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                            </div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/faq/backend/category/create.blade.php ENDPATH**/ ?>
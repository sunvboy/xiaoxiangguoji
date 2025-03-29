<?php $__env->startSection('content'); ?>
<main class="main-new-2 main-info">

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_5'])); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span> \ <?php echo e($page->title); ?></span>
                        </div>
                        <h2 class="tp-breadcrumb-title"><?php echo e($page->title); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-info">


        <div class="container">

            <div class="tabbed_area">
                <ul class="tabs">
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('thu-ngo')); ?>" title="topics" class="tab">Thư ngỏ</a></li>
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('lich-su-hinh-thanh')); ?>" title="archives" class="tab">lịch sử hình thành</a></li>
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('tam-nhin-su-menh-loi-the-canh-tranh')); ?>" title="pages" class="tab">Tầm nhìn - Sứ mệnh - Lợi thế cạnh tranh</a></li>
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('co-cau-to-chuc')); ?>" title="cocau" class="tab">Cơ cấu tổ chức</a></li>
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('ky-thuat-chuyen-mon')); ?>" title="kythuat" class="tab">Kỹ thuật chuyên môn</a></li>
                    <li><a href="javascript:void(0)" data-href="<?php echo e(url('co-so-vat-chat')); ?>" title="coso" class="tab">Cơ sở vật chất </a></li>
                </ul>
                <div id="topics" class="content" data-href="<?php echo e(url('thu-ngo')); ?>">
                    <?php echo !empty($fields['config_colums_editor_tn']) ? $fields['config_colums_editor_tn']:''; ?>

                </div>
                <div id="archives" class="content" data-href="<?php echo e(url('lich-su-hinh-thanh')); ?>">
                    <div class="timeline" style="background: url(<?php echo asset($fcSystem['banner_9'])?>)">
                        <?php
                            $lists = !empty($fields['config_colums_json_lsht']) ? json_decode($fields['config_colums_json_lsht']): [];

                        ?>
                        <?php if(!empty($lists->title)): ?>
                        <?php $__currentLoopData = $lists->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="container-1 <?php if($key%2==0): ?>left <?php else: ?> right  <?php endif; ?>">
                                <div class="date"><?php echo e(!empty($lists->year[$key]) ? $lists->year[$key] : ''); ?></div>
                                <img class="icon" src="<?php echo e(!empty($lists->icon[$key]) ? asset($lists->icon[$key]) : ''); ?>" alt="icon" style="object-fit: contain;">
                                <div class="content">
                                <h2><?php echo e($item); ?></h2>
                                <p>
                                    <?php echo e(!empty($lists->content[$key]) ? $lists->content[$key] : ''); ?>

                                </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>


                   </div>
                </div>
                <div id="pages" class="content" data-href="<?php echo e(url('tam-nhin-su-menh-loi-the-canh-tranh')); ?>">
                    <?php echo !empty($fields['config_colums_editor_tamnhin']) ? $fields['config_colums_editor_tamnhin']:''; ?>

                </div>
                <div id="cocau" class="content" data-href="<?php echo e(url('co-cau-to-chuc')); ?>">
                    <?php echo !empty($fields['config_colums_editor_cocau']) ? $fields['config_colums_editor_cocau']:''; ?>

                </div>
                <div id="kythuat" class="content" data-href="<?php echo e(url('ky-thuat-chuyen-mon')); ?>">
                    <?php echo !empty($fields['config_colums_editor_kythuat']) ? $fields['config_colums_editor_kythuat']:''; ?>

                </div>
                <div id="coso" class="content" data-href="<?php echo e(url('co-so-vat-chat')); ?>">
                    <?php echo !empty($fields['config_colums_editor_coso']) ? $fields['config_colums_editor_coso']:''; ?>

                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.tabs li a').filter(function() {
        return $(this).attr('data-href') === aurl;
    }).addClass('active');
    $('.content').filter(function() {
        return $(this).attr('data-href') === aurl;
    }).addClass('active');
</script>
<script>
    $(document).ready(function() {
        $("a.tab").click(function() {
            $(".active").removeClass("active");
            $(this).addClass("active");
            $(".content").hide();
            var x = $(this).attr("title");
            $("#" + x).show();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('javascript'); ?>
<style>
    .content.active{
        display: block !important;
    }
    #topics,
    #archives,
    #pages,
    #cocau,
    #kythuat,
    #coso {
        display: none;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/page/frontend/aboutus.blade.php ENDPATH**/ ?>
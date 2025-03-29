<?php $__env->startSection('content'); ?>
<div id="main" class="sitemap main-info pb-[20px] md:pb-[70px]">
    <section class="banner-child py-[50px] md:py-[100px] relative" style="background: url('<?php echo e(!empty($page->image) ? (!empty(File::exists(base_path($page->image)))?asset($page->image):asset($fcSystem['banner_1'])) : asset($fcSystem['banner_1'])); ?>')">
        <h1 class="text-f25 md:text-f35 font-bold text-white relative z-10 text-center">
            <?php echo e($page->title); ?>

        </h1>
        <div class="breadcrumb py-[10px] relative z-10 mt-[5px]">
            <div class="container mx-auto px-3">
                <ul class="flex flex-wrap justify-center">
                    <li class="pr-[5px] text-white active">
                        <a href="<?php echo e(url('/')); ?>" class="text-color_second"><?php echo e($fcSystem['title_12']); ?></a> /
                    </li>
                    <li class="text-white"> <?php echo e($page->title); ?></li>
                </ul>
            </div>
        </div>
    </section>
    <div class="content-new-detail pt-[20px] md:pt-[60px]">
        <div class="container mx-auto px-3">
            <div class="flex flex-wrap justify-between mx-[-15px]">
                <div class="w-full md:w-3/4 px-[15px]">
                    <div class="blog-single-post" style="box-shadow: 0px 8px 32px 0px rgba(0, 0, 0, 0.12)">

                        <div class="content-content p-[15px] md:p-[40px]">
                            <div class="title-title-post mb-[10px]">
                                <h1 class="title-1 bold-1 text-f20 md:text-f30 leading-[25px] md:leading-[36px]">
                                    <?php echo e($page->title); ?>

                                </h1>
                            </div>
                            <div class="box_content">
                                <?php echo $page->description; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/4 px-[15px]">
                    <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/page/frontend/aboutus.blade.php ENDPATH**/ ?>
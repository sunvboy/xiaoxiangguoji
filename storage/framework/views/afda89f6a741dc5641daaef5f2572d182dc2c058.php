<?php $__env->startSection('content'); ?>
<main class="main-new-2 main-QA">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_6'])); ?>">
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
    <div class="content-QA">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <aside class="aside-left">
                        <?php $menu_faqs = getMenus('menu-hoi-dap'); ?>
                        <?php if(!empty($menu_faqs->menu_items) && count($menu_faqs->menu_items) > 0): ?>
                        <?php $__currentLoopData = $menu_faqs->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($item->children) && count($item->children) > 0): ?>
                        <?php if($key == 0): ?>
                        <div class="item-sb">
                            <h3 class="title-3" style="text-transform: uppercase;"><?php echo e($item->title); ?></h3>
                            <div class="nav-item-sb">
                                <ul>
                                    <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url($child->slug)); ?>"><i class="fa-solid fa-angle-right"></i><?php echo e($child->title); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="item-sb" style="margin-top: 50px;">
                            <h3 class="title-3" style="text-transform: uppercase;"><?php echo e($item->title); ?></h3>
                            <div class="nav-item-sb">
                                <ul>
                                    <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url($child->slug)); ?>"><i class="fa-solid fa-angle-right"></i><?php echo e($child->title); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="content-qa-center">
                        <h2 class="title-2">Hỏi đáp chuyên gia</h2>
                        <div class="content-content-item">
                            <?php if(!empty($data)): ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="icon">
                                    <i class="fa-solid fa-circle-question"></i>
                                </div>
                                <div class="title-top">
                                    <span class="name-title"><?php echo e($item->name); ?></span>
                                    <?php if(!empty($item->faq_categories)): ?>
                                    <span class="category"><?php echo e($item->faq_categories->title); ?></span>
                                    <?php endif; ?>
                                    <span class="date">Đã hỏi: Ngày <?php echo e($item->created_at); ?></span>
                                </div>
                                <h4 class="title-4"><a href="<?php echo e(route('pageF.faqs.id',['id'=>$item->id])); ?>"><?php echo e($item->title); ?></a></h4>
                                <p class="desc"><?php echo $item->content; ?></p>
                                <div class="item-bottom">
                                    <span class="conment"><i class="fa-solid fa-comment-dots"></i>0 bình luận</span>
                                    <span class="view"> <i class="fa-solid fa-eye"></i><?php echo e($item->viewed); ?> lượt xem</span>
                                    <span class="view-question"><a href="<?php echo e(route('pageF.faqs.id',['id'=>$item->id])); ?>"><i class="fa-solid fa-check"></i>Xem câu trả lời</a></span>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <?php echo e($data->links()); ?>

                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-12">
                    <?php echo $__env->make('article.frontend.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/page/frontend/faqs.blade.php ENDPATH**/ ?>
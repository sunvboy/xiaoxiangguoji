<?php $__env->startSection('content'); ?>
<?php if($slideHome): ?>
<?php if($slideHome->slides): ?>
<!-- Carousel Start -->
<div class="container-fluid px-0 mb-5">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $__currentLoopData = $slideHome->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel-item <?php if($key == 0): ?> active <?php endif; ?>">
                <img class="w-100" src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-7 text-start">
                                <h1 class="display-1 text-white mb-4 animated slideInRight"><?php echo e($slide->title); ?></h1>
                                <a href="javascript:void(0)" class="btn btn-primary rounded-pill py-3 px-5 animated slideInRight">了解更多</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">上一页</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">下一页</span>
        </button>
    </div>
</div>
<!-- Carousel End -->
<?php endif; ?>
<?php endif; ?>


<?php if($features): ?>
<?php if($features->slides): ?>
<!-- Features Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 feature-row">
            <?php $__currentLoopData = $features->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="feature-item border h-100 p-5">
                    <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                        <img class="img-fluid" src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>">
                    </div>
                    <h5 class="mb-3"><?php echo e($slide->title); ?></h5>
                    <p class="mb-0"><?php echo e($slide->description); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</div>
<!-- Features End -->
<?php endif; ?>
<?php endif; ?>

<?php
$config_colums_input_AboutTitle = $fields['config_colums_input_AboutTitle'];
$config_colums_editor_AboutDescription = $fields['config_colums_editor_AboutDescription'];
$config_colums_input_AboutImage = $fields['config_colums_input_AboutImage'];
$config_colums_json_AboutItems = !empty($fields['config_colums_json_AboutItems']) ? json_decode($fields['config_colums_json_AboutItems'], TRUE) : [];
?>
<?php if(!empty($config_colums_input_AboutTitle)): ?>
<!-- About Start -->
<div class="container-xxl about my-5" style=" background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)),url(<?php echo !empty($config_colums_input_AboutImage) ? asset($config_colums_input_AboutImage) : ''; ?>) left center no-repeat;">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-6">
                <div class="h-100 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                    <button type="button" class="btn-play d-none" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                        <span></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-6 pt-lg-5 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white rounded-top p-5 mt-lg-5">
                    <p class="fs-5 fw-medium text-primary"><?php echo e($config_colums_input_AboutTitle); ?></p>
                    <div>
                        <?php echo !empty($config_colums_editor_AboutDescription)?$config_colums_editor_AboutDescription:''; ?>

                    </div>
                    <?php if(!empty($config_colums_json_AboutItems) && !empty($config_colums_json_AboutItems['title'])): ?>
                    <div class="row g-5 pt-2 mb-5">
                        <?php $__currentLoopData = $config_colums_json_AboutItems['title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-6">
                            <img class="img-fluid mb-4" src="<?php echo e(!empty($config_colums_json_AboutItems['image'][$key]) ? asset($config_colums_json_AboutItems['image'][$key]) : ''); ?>" alt="<?php echo e($val); ?>">
                            <h5 class="mb-3"><?php echo e($val); ?></h5>
                            <span><?php echo e(!empty($config_colums_json_AboutItems['description'][$key]) ? $config_colums_json_AboutItems['description'][$key] : ''); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="javascript:void(0)">了解更多</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
<?php endif; ?>

<?php /*<!-- Video Modal Start -->
<div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">YouTube视频</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 16:9 aspect ratio -->
                <div class="ratio ratio-16x9">
                    <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                        allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Modal End -->*/ ?>

<?php if(!empty($services) && !empty($services->posts)): ?>
<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary"><?php echo e($services->title); ?></p>
            <h1 class="display-5 mb-5"><?php echo e(strip_tags($services->description)); ?></h1>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $services->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo e($key+2); ?>s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-5">
                        <div class="btn-square bg-light rounded-circle mx-auto mb-4"
                            style="width: 64px; height: 64px;">
                            <img class="img-fluid" src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>">
                        </div>
                        <h5 class="mb-3"><?php echo e($item->title); ?></h5>
                        <p class="mb-0"><?php echo e(strip_tags($item->description)); ?></p>
                    </div>
                    <div class="service-btn rounded-0 rounded-bottom">
                        <a class="text-primary fw-medium" href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">了解更多<i
                                class="bi bi-chevron-double-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<!-- Service End -->
<?php endif; ?>


<?php if(!empty($projects) && !empty($projects->posts)): ?>

<!-- Project Start -->
<div class="container-xxl pt-5">
    <div class="container">
        <div class="text-center text-md-start pb-5 pb-md-0 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary"><?php echo e($projects->title); ?></p>
            <h1 class="display-5 mb-5"><?php echo e(strip_tags($projects->description)); ?></h1>
        </div>
        <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
            <?php $__currentLoopData = $projects->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="project-item mb-5">
                <div class="position-relative">
                    <img class="img-fluid" src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>">
                    <?php /*  <div class="project-overlay">
                        <a class="btn btn-lg-square btn-light rounded-circle m-1" href="img/project-1.jpg"
                            data-lightbox="project"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle m-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>*/ ?>
                </div>
                <div class="p-4">
                    <a class="d-block h5" href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a>
                    <span><?php echo e(strip_tags($item->description)); ?></span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<!-- Project End -->
<?php endif; ?>

<!-- Quote Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="fs-5 fw-medium text-primary"><?php echo e($fcSystem['title_0']); ?></p>
                <h1 class="display-5 mb-4"><?php echo e($fcSystem['title_1']); ?></h1>
                <div class="mb-4">
                    <?php echo e($fcSystem['title_2']); ?>

                </div>
                <a class="d-inline-flex align-items-center rounded overflow-hidden border border-primary" href="">
                    <span class="btn-lg-square bg-primary" style="width: 55px; height: 55px;">
                        <i class="fa fa-phone-alt text-white"></i>
                    </span>
                    <span class="fs-5 fw-medium mx-4"> <?php echo e($fcSystem['contact_hotline']); ?></span>
                </a>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <h2 class="mb-4"><?php echo e($fcSystem['title_3']); ?></h2>
                <form action="" class="form-subscribe">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="alert alert-success" style="display:none"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="fullname" id="name" placeholder="您的姓名"
                                    required>
                                <label for="name">您的姓名</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="mail" placeholder="您的电子邮件"
                                    required>
                                <label for="mail">您的电子邮件</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="phone" id="mobile" placeholder="您的手机"
                                    required>
                                <label for="mobile">您的手机</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="service" name="service">
                                    <?php if(!empty($serviceLists) && !empty($serviceLists->posts)): ?>
                                    <?php $__currentLoopData = $serviceLists->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option selected value="<?php echo e($item->title); ?>"><?php echo e($item->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <label for="service">选择服务</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="留下您的消息" id="message" name="message"
                                    style="height: 130px"></textarea>
                                <label for="message">消息</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary w-100 py-3 btn-submit" type="submit">立即提交</button>
                            <button class="btn btn-primary w-100 py-3 btn-loading" type="button"
                                style="display: none;">加载中...</button>
                        </div>
                    </div>
                </form>
                <!-- end: box 9-->
            </div>
        </div>
    </div>
</div>
<!-- Quote Start -->


<?php if(!empty($teams) && !empty($teams->posts)): ?>
<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary"><?php echo e($teams->title); ?></p>
            <h1 class="display-5 mb-5"><?php echo e(strip_tags($teams->description)); ?></h1>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $teams->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo e($key+2); ?>s">
                <div class="team-item rounded overflow-hidden pb-4">
                    <img class="img-fluid mb-4" src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>">
                    <h5><?php echo e($item->title); ?></h5>
                    <span class="text-primary"><?php echo e(strip_tags($item->description)); ?></span>
                    <?php /*<ul class="team-social">
                        <li><a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a></li>
                        <li><a class="btn btn-square" href=""><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>*/ ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</div>
<!-- Team End -->
<?php endif; ?>

<?php if(!empty($testimonials) && !empty($testimonials->posts)): ?>
<!-- Testimonial Start -->
<div class="container-xxl pt-5">
    <div class="container">
        <div class="text-center text-md-start pb-5 pb-md-0 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 500px;">
            <p class="fs-5 fw-medium text-primary"><?php echo e($testimonials->title); ?></p>
            <h1 class="display-5 mb-5"><?php echo e(strip_tags($testimonials->description)); ?></h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <?php $__currentLoopData = $testimonials->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="testimonial-item rounded p-4 p-lg-5 mb-5">
                <img class="mb-4" src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>">
                <p class="mb-4"><?php echo e(strip_tags($item->description)); ?></p>
                <h5><?php echo e($item->title); ?></h5>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<!-- Testimonial End -->
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('javascript'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/home/index.blade.php ENDPATH**/ ?>
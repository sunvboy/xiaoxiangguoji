<?php $__env->startSection('content'); ?>
<main>
    <?php if($slideHome): ?>
    <?php if($slideHome->slides): ?>
    <!-- slider-area-start -->
    <section class="slider-area">
        <div class="swiper-container tp-slider-3-active">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $slideHome->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide tp-slider-3-item">
                    <a href="<?php echo e(url($slide->link)); ?>">
                        <img src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>">
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tp-slider-btn-3-arrow">
                <div class="tp-slider-btn-3-prev mb-25">
                    <span><i class="fa-solid fa-arrow-left"></i></span>
                </div>
                <div class="tp-slider-btn-3-next">
                    <span><i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </div>
        </div>
    </section>
    <!-- slider-area-end -->
    <?php endif; ?>
    <?php endif; ?>

    <?php $menu_home = getMenus('menu-trang-chu'); ?>
    <?php if(!empty($menu_home->menu_items) && count($menu_home->menu_items) > 0): ?>
    <section class="services-area theme-bg-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-services-wrap">
                        <?php $__currentLoopData = $menu_home->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="tp-services-item-box mb-30">
                                <div class="tp-services-item-box-icon">
                                    <span><img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>" style="width:40px;height: 40px;" /></span>
                                </div>
                                <h4 class="tp-services-item-box-title"><a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?></a></h4>
                                <div class="tp-services-item-box-content">
                                    <a href="<?php echo e(url($item->slug)); ?>" class="services-link-btn">Xem thêm <i class="fa-regular fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($ishomeCategoryArticle)): ?>
    <?php if(!empty($ishomeCategoryArticle->posts)): ?>
    <!-- services-area-start -->
    <section class="services-area tp-services-3 pt-50 theme-bg-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-40">
                        <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="dịch vụ"></span>
                        <h5 class="tp-section-subtitle"><?php echo e($ishomeCategoryArticle->title); ?></h5>
                        <h3 class="tp-section-title"><?php echo strip_tags($ishomeCategoryArticle->description); ?></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $ishomeCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6 col-md-6">
                    <div class="tp-services-3-item">
                        <div class="tp-services-3-thumb p-relative">
                            <div class="fix p-relative">
                                <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                <div class="tp-services-3-content">
                                    <div class="tp-services-3-icon">
                                        <span><i class="flaticon-wheel-chair"></i></span>
                                    </div>
                                    <h4 class="tp-services-3-title"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h4>
                                    <!--  <p>Dịch vụ Khám, chữa bệnh theo yêu cầu</p> -->
                                    <a class="tp-services-btn" href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem chi tiết <i class="fa-regular fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                            <div class="tp-services-3-info">
                                <div class="tp-services-3-info-icon">
                                    <span><i class="flaticon-wheel-chair"></i></span>
                                </div>
                                <h4 class="tp-services-3-info-title"><?php echo e($item->title); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="tp-services-3-shape-1">
            <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/services-3-shape-1.png')); ?>" alt="dịch vụ">
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    <!-- services-area-end -->
    <?php
    $fieldAboutUs = [];
    if (!empty($aboutUs->fields) && count($aboutUs->fields) > 0) {
        foreach ($aboutUs->fields as $item) {
            $fieldAboutUs[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
        }
    }

    ?>
    <!-- about-area-start -->
    <section class="about-area tp-about-3 mt-50 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="tp-about-2-wrap mb-50">
                        <?php if(!empty($fieldAboutUs['config_colums_json_images'])): ?>
                        <?php $__currentLoopData = $fieldAboutUs['config_colums_json_images']->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php /* @if($key>0)
                        <div class="tp-about-2-thumb">
                            <img src="{{asset($item)}}" alt="">
                        </div>
                        @else
                        <div class="tp-about-2-thumb-2">
                            <img src="{{asset($item)}}" alt="">
                        </div>
                        @endif*/ ?>
                        <?php if($key==0): ?>
                        <div class="">
                            <img src="<?php echo e(asset($item)); ?>" alt="">
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(!empty($fieldAboutUs['config_colums_json_people'])): ?>
                        <?php $__currentLoopData = $fieldAboutUs['config_colums_json_people']->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key==0): ?>
                        <div class="tp-about-3-counter">
                            <h5 class="tp-about-3-counter-count">
                                <span data-purecounter-duration="1" data-purecounter-end="<?php echo e($fieldAboutUs['config_colums_json_people']->count[$key]); ?>" class="purecounter"></span><?php echo e($fieldAboutUs['config_colums_json_people']->unit[$key]); ?>

                            </h5>
                            <p><?php echo e($item); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tp-about-2-wrapper mt-25 mb-50">
                        <div class="tp-section text-p mb-35">
                            <h5 class="tp-section-subtitle"><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="" style="margin-right: 10px;"><?php echo e($aboutUs->title); ?></h5>
                            <h3 class="tp-section-title pb-30"><?php echo e($fcSystem['homepage_company']); ?></h3>
                            <div>
                                <?php echo $aboutUs->description; ?>

                            </div>
                        </div>
                        <?php if(!empty($fieldAboutUs['config_colums_json_items'])): ?>
                        <div class="tp-about-list mb-30">
                            <ul>
                                <?php $__currentLoopData = $fieldAboutUs['config_colums_json_items']->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="fa-solid fa-circle-check"></i> <?php echo e($item); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <div class="tp-about-3-info d-flex align-items-center">
                            <div class="tp-about-3-info-icon">
                                <span><i class="fa-light fa-hand-holding-heart"></i></span>
                            </div>
                            <div class="tp-about-3-info-text">
                                <span>Giải đáp các thắc mắc của khách hàng về các dịch vụ của Bệnh viện</span>
                            </div>
                        </div>
                        <div class="tp-about-btn mb-20">
                            <a class="tp-btn" href="<?php echo e(route('pageF.aboutVI')); ?>">Xem thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->
    <?php /*@if(!empty($fields['config_colums_json_why']))
    <!-- services-area-start -->
    <section class="services-area tp-services-3-wrap theme-bg pt-50 pb-50 mt-100">
        <div class="container">
            <div class="tp-section fs-48 mb-30 text-center">
                <span><img src="{{asset('frontend/ncare/assets/img/shape/section-shape-1.svg')}}" alt="shape"></span>
                <h5 class="tp-section-subtitle">{{$fcSystem['homepage_company']}}</h5>
                <h3 class="tp-section-title">Các chuyên khoa chính</h3>
            </div>
            <div class="row row-cols-5">
                @foreach($fields['config_colums_json_why']->title as $key=>$item)
                <div class="col">
                    <div class="tp-services-3-item-2 mb-30">
                        <div class="tp-services-3-item-2-icon">
                            <span><img src="{{!empty($fields['config_colums_json_why']->image) ? $fields['config_colums_json_why']->image[$key] :''}}" alt="{{$item}}" /></span>
                        </div>
                        <div class="tp-services-3-item-2-content">
                            <h4 class="tp-services-3-item-2-title"><a href="javascript:void(0)">{{$item}}</a></h4>
                            <p>{{!empty($fields['config_colums_json_why']->content) ? $fields['config_colums_json_why']->content[$key] :''}}</p>
                        </div>
                        <div class="tp-services-3-item-2-shape">
                            <div class="tp-services-3-item-2-shape-1">
                                <img src="{{asset('frontend/ncare/assets/img/shape/services-3-shape-2.png')}}" alt="shape">
                            </div>
                            <div class="tp-services-3-item-2-shape-2">
                                <img src="{{asset('frontend/ncare/assets/img/shape/services-3-shape-3.png')}}" alt="shape">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tp-services-3-shape">
            <div class="tp-services-3-shape-2">
                <img src="{{asset('frontend/ncare/assets/img/shape/services-3-shape-4.png')}}" alt="shape">
            </div>
            <div class="tp-services-3-shape-3">
                <img src="{{asset('frontend/ncare/assets/img/shape/services-3-shape-5.png')}}" alt="shape">
            </div>
        </div>
    </section>
    @endif*/ ?>
    <?php if(!empty($isHotCategoryArticle)): ?>
    <!-- services-area-start -->
    <section class="services-area tp-services-3-wrap theme-bg pt-50 pb-50 mt-100">
        <div class="container">
            <div class="tp-section fs-48 mb-30 text-center">
                <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="shape"></span>
                <h5 class="tp-section-subtitle"><?php echo e($fcSystem['homepage_company']); ?></h5>
                <h3 class="tp-section-title">Các chuyên khoa chính</h3>
            </div>
            <div class="swiper-container tp-event-ck-active">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $isHotCategoryArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                        <div class="tp-services-3-item-2 mb-30">
                            <div class="tp-services-3-item-2-icon">
                                <span><img src="<?php echo e(asset($item->banner)); ?>" alt="<?php echo e($item->title); ?>" /></span>
                            </div>
                            <div class="tp-services-3-item-2-content">
                                <h4 class="tp-services-3-item-2-title"><a href="javascript:void(0)"><?php echo e($item->title); ?></a></h4>
                                <p><?php echo e(strip_tags($item->description)); ?></p>
                            </div>
                            <div class="tp-services-3-item-2-shape">
                                <div class="tp-services-3-item-2-shape-1">
                                    <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/services-3-shape-2.png')); ?>" alt="shape">
                                </div>
                                <div class="tp-services-3-item-2-shape-2">
                                    <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/services-3-shape-3.png')); ?>" alt="shape">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="tp-services-3-shape">
            <div class="tp-services-3-shape-2">
                <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/services-3-shape-4.png')); ?>" alt="shape">
            </div>
            <div class="tp-services-3-shape-3">
                <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/services-3-shape-5.png')); ?>" alt="shape">
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- services-area-end -->

    <?php if(!empty($fields['config_colums_json_qt'])): ?>
    <?php if(!empty($fields['config_colums_json_qt']->title[0])): ?>
    <!-- processing-area-start -->
    <section class="processing-area tp-process-3 pt-50 fix">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="tp-processing-2-wrapper">
                        <div class="tp-section mb-35">
                            <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="shape"></span>
                            <h5 class="tp-section-subtitle"><?php echo e(!empty($fields['config_colums_json_qt']->title[0])?$fields['config_colums_json_qt']->title[0]:''); ?></h5>
                            <h3 class="tp-section-title pb-30"><?php echo e(!empty($fields['config_colums_json_qt']->sub[0])?$fields['config_colums_json_qt']->sub[0]:''); ?></h3>
                            <p>
                                <?php echo e(!empty($fields['config_colums_json_qt']->description[0])?$fields['config_colums_json_qt']->description[0]:''); ?>

                            </p>
                        </div>
                        <?php if(!empty($fields['config_colums_json_qt2'])): ?>
                        <?php if(!empty($fields['config_colums_json_qt2']->title)): ?>
                        <div class="">
                            <div class="row">
                                <?php $__currentLoopData = $fields['config_colums_json_qt2']->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-6">
                                    <div class="tp-processing-2-count-item">
                                        <?php /*<div class="tp-processing-2-count-number">
                                            <span>{{$key+1}}</span>
                                        </div>
                                        <div class="tp-processing-2-count-icon">
                                            <span><img src="{{!empty($fields['config_colums_json_qt2']->image[$key])?asset($fields['config_colums_json_qt2']->image[$key]):''}}" alt="{{$item}}"></span>
                                        </div>
                                        <div class="tp-processing-2-count-content">
                                            <h5 class="tp-processing-2-count-title"><a href="javascript:void(0)">{{$item}}</a></h5>
                                        </div>*/?>
                                        <img src="<?php echo e(!empty($fields['config_colums_json_qt2']->image[$key])?asset($fields['config_colums_json_qt2']->image[$key]):''); ?>" alt="<?php echo e($item); ?>" style="object-fit: contain">
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 align-items-end">
                    <div class="tp-processing-2-thumb">
                        <img src="<?php echo e(!empty($fields['config_colums_json_qt']->image[0])?asset($fields['config_colums_json_qt']->image[0]):''); ?>" alt="<?php echo e(!empty($fields['config_colums_json_qt']->title[0])?$fields['config_colums_json_qt']->title[0]:''); ?>">
                        <div class="tp-process-3-shape-1">
                            <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/processing-3-shape-1.png')); ?>" alt="shape">
                        </div>
                        <div class="tp-process-3-shape-2">
                            <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/processing-3-shape-2.png')); ?>" alt="shape">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- processing-area-end -->
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty($fields['config_colums_json_contact'])): ?>
    <?php if(!empty($fields['config_colums_json_contact']->title[0])): ?>
    <!-- cta-area-start -->
    <section class="cta-area tp-cta-3-bg" data-background="<?php echo e(!empty($fields['config_colums_json_contact']->background[0])?asset($fields['config_colums_json_contact']->background[0]):asset('frontend/ncare/assets/img/bg/cta-3-bg-1.jpg')); ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-cta-2-wrapper text-center">
                        <div class="tp-section mb-20">
                            <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="<?php echo e($fields['config_colums_json_contact']->title[0]); ?>"></span>
                            <h5 class="tp-section-subtitle"><?php echo e($fields['config_colums_json_contact']->title[0]); ?></h5>
                            <h3 class="tp-section-title"><?php echo e(!empty($fields['config_colums_json_contact']->description[0])?$fields['config_colums_json_contact']->description[0]:''); ?></h3>
                        </div>
                        <div class="tp-cta-2-btn">
                            <a class="tp-btn" href="<?php echo e(route('pageF.contact')); ?>">Liên hệ ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp-cta-3-shape">
            <div class="tp-cta-3-shape-1">
                <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/cta-3-shape-1.png')); ?>" alt="shape">
            </div>
            <div class="tp-cta-3-shape-2">
                <img src="<?php echo e(asset('frontend/ncare/assets/img/shape/cta-3-shape-2.png')); ?>" alt="shape">
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    <!-- cta-area-end -->
    <?php if(!empty($faqs)): ?>
    <!-- faq-area-start -->
    <section class="faq-area mt-120 mb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-45">
                        <span><img src="assets/img/shape/section-shape-1.svg" alt=""></span>
                        <h5 class="tp-section-subtitle">Hỏi đáp</h5>
                        <h3 class="tp-section-title">Câu hỏi thường gặp </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="tp-faq-accordion tp-faq-3">
                        <div class="accordion" id="accordionExample">
                            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key<=3): ?> <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($item->id); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($item->id); ?>">
                                        <?php echo e($item->title); ?>

                                        <span class="accordion-btn"></span>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo e($item->id); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php echo $item->content; ?>

                                    </div>
                                </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tp-faq-accordion tp-faq-3">
                    <div class="accordion" id="accordionExample-2">
                        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key>3): ?> <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($item->id); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($item->id); ?>">
                                    <?php echo e($item->title); ?>

                                    <span class="accordion-btn"></span>
                                </button>
                            </h2>
                            <div id="collapse<?php echo e($item->id); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample-2">
                                <div class="accordion-body">
                                    <?php echo $item->content; ?>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
            <div class="tp-about-btn mt-20" style="text-align: center;">
                <a class="tp-btn" href="hoi-dap">Xem đầy đủ câu hỏi</a>
            </div>

        </div>
        </div>
    </section>
    <!-- faq-area-end -->
    <?php endif; ?>


    <?php if(!empty($fields['config_colums_json_counter'])): ?>
    <?php if(!empty($fields['config_colums_json_counter']->title)): ?>
    <!-- counter-area-start -->
    <section class="counter-area">
        <div class="container">
            <div class="tp-counter-3-bg" data-background="<?php echo e(asset('frontend/ncare/assets/img/bg/counter-3-bg-1.jpg')); ?>">
                <div class="row">
                    <?php $__currentLoopData = $fields['config_colums_json_counter']->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="tp-counter-3-item">
                            <h5 class="tp-counter-3-count"><span data-purecounter-duration="1" data-purecounter-end="<?php echo e(!empty($fields['config_colums_json_counter']->count[$key])?$fields['config_colums_json_counter']->count[$key]:''); ?>" class="purecounter"></span><?php echo e(!empty($fields['config_colums_json_counter']->unit[$key])?$fields['config_colums_json_counter']->unit[$key]:''); ?></h5>
                            <p><?php echo e($item); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    <!-- counter-area-end -->
    <?php if(!empty($isasideCategoryArticle)): ?>
    <?php if(!empty($isasideCategoryArticle->posts)): ?>
    <!-- event-area-start -->
    <section class="event-area tp-event-3-bg tp-event-2-bg" data-background="<?php echo e(asset('frontend/ncare/assets/img/bg/event-2-bg-1.jpg')); ?>">
        <div class="fix">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-6">
                        <div class="tp-section mb-30">
                            <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="<?php echo e($isasideCategoryArticle->title); ?>"></span>
                            <h5 class="tp-section-subtitle"><?php echo e($isasideCategoryArticle->title); ?></h5>
                            <h3 class="tp-section-title"><?php echo e($isasideCategoryArticle->title); ?> nổi bật.</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tp-event-2-arrow d-flex align-items-center justify-content-lg-end mb-60">
                            <div class="tp-event-2-button-prev">
                                <span><i class="fa-solid fa-arrow-left"></i></span>
                            </div>
                            <div class="tp-event-2-button-next ml-30">
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper-container tp-event-3-active">
                            <div class="swiper-wrapper">
                                <?php $__currentLoopData = $isasideCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <div class="tp-event-2">
                                        <div class="tp-event-2-thumb">
                                            <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                            <div class="tp-event-2-date">
                                                <span><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d')); ?></span>
                                                <p>Tháng <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('m')); ?></p>
                                            </div>
                                        </div>
                                        <div class="tp-event-2-content">
                                            <div class="tp-event-2-info d-flex align-items-center">
                                                <div class="tp-event-2-info-item">
                                                    <p><span><i class="fa-solid fa-clock"></i></span> <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('g:i A')); ?></p>
                                                </div>
                                                <div class="tp-event-2-info-item">
                                                    <p><span><i class="fa-solid fa-location-dot"></i></span> TP. Hà Nội</p>
                                                </div>
                                            </div>
                                            <h4 class="tp-event-2-title"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                                    <?php echo e($item->title); ?>

                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty($teams)): ?>
    <section class="team-area mt-105 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-45">
                        <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="Đội ngũ bác sỹ"></span>
                        <h5 class="tp-section-subtitle"><?php echo e($fcSystem['title_9']); ?></h5>
                        <h3 class="tp-section-title"><?php echo e($fcSystem['title_8']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="tp-team-item text-center mb-40">
                        <div class="tp-team-thumb">
                            <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>">
                        </div>
                        <div class="tp-team-social">
                            <span><i class="fa-sharp fa-solid fa-plus"></i></span>
                            <div class="tp-team-social-wrap">
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>
                        <div class="tp-team-content">
                            <h4 class="tp-team-title"><a href="<?php echo e(route('router.team',['id' => $item->id])); ?>"><?php echo e($item->name); ?></a></h4>
                            <span><?php echo e($item->job); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-12 d-flex justify-content-center">
                    <a class="tp-btn" href="<?php echo e(route('pageF.teams')); ?>">Xem tất cả</a>
                </div>
            </div>
        </div>
    </section>
    <!-- team-area-end -->
    <?php endif; ?>


    <?php if(!empty($highlightCategoryArticle)): ?>
    <?php if(!empty($highlightCategoryArticle->posts)): ?>
    <!-- blog-area-start -->
    <section class="blog-area tp-blog-3-wrap">
        <div class="tp-blog-3-bg"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="tp-section mb-40">
                        <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="<?php echo e($highlightCategoryArticle->title); ?>"></span>
                        <h5 class="tp-section-subtitle"><?php echo e(strip_tags($highlightCategoryArticle->description)); ?></h5>
                        <h3 class="tp-section-title"><?php echo e($highlightCategoryArticle->title); ?> mới nhất</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tp-blog-3-all mt-30 text-lg-end">
                        <a class="tp-btn" href="<?php echo e(route('routerURL',['slug' => $highlightCategoryArticle->slug])); ?>">Xem tất cả</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $highlightCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key==0): ?>
                <div class="col-xl-6 col-lg-5">
                    <div class="tp-blog-3-item tp-blog-3-item-big mb-40" data-background="<?php echo asset($item->image) ?>">
                        <div class="tp-blog-3-content">
                            <div class="tp-blog-3-meta">
                                <span><i class="fa-light fa-calendar-days"></i> <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d')); ?> tháng <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('m Y')); ?></span>
                                <span><i class="fa-sharp fa-regular fa-eye"></i> <?php echo e($item->viewed); ?> lượt xem</span>
                            </div>
                            <h4 class="tp-blog-3-title">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?> </a>
                            </h4>
                            <p>
                                <?php echo strip_tags($item->description); ?>

                            </p>
                            <div class="tp-blog-3-btn">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem thêm <span><img src="<?php echo e(asset('frontend/ncare/assets/img/icon/blog-3-arrow.svg')); ?>" alt="<?php echo e($item->title); ?>"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="col-xl-6 col-lg-7">
                    <?php $__currentLoopData = $highlightCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key>0): ?>
                    <div class="tp-blog-3-item-2 mb-20 d-flex align-items-center">
                        <div class="tp-blog-3-item-2-thumb">
                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo asset($item->image) ?>" alt="blog-item"></a>
                        </div>
                        <div class="tp-blog-3-item-2-content">
                            <div class="tp-blog-3-meta">
                                <span><i class="fa-light fa-calendar-days"></i> <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d')); ?> tháng <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('m Y')); ?></span>
                                <span><i class="fa-sharp fa-regular fa-eye"></i> <?php echo e($item->viewed); ?> lượt xem</span>
                            </div>
                            <h4 class="tp-blog-3-title">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo strip_tags($item->title); ?>

                                </a>
                            </h4>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->
    <?php endif; ?>
    <?php endif; ?>



    <?php if(!empty($isfooterCategoryArticle)): ?>
    <?php if(!empty($isfooterCategoryArticle->posts)): ?>
    <section class="blog-area pt-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-section text-center mb-45">
                        <span><img src="<?php echo e(asset('frontend/ncare/assets/img/shape/section-shape-1.svg')); ?>" alt="<?php echo e($isfooterCategoryArticle->title); ?>"></span>
                        <h5 class="tp-section-subtitle"><?php echo e(strip_tags($isfooterCategoryArticle->description)); ?></h5>
                        <h3 class="tp-section-title"><?php echo e($isfooterCategoryArticle->title); ?></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $isfooterCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="tp-blog-2 mb-40">
                        <div class="tp-blog-2-thumb">
                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>"></a>
                            <div class="tp-blog-2-date">
                                <span><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d')); ?></span>
                                <p>Tháng <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('m')); ?></p>
                            </div>
                            <div class="tp-blog-2-info d-flex align-items-center">
                                <div class="tp-blog-2-info-item mr-20">
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slugC])); ?>"><span><i class="fa-solid fa-tags"></i> <?php echo e($item->titleC); ?></span></a>
                                </div>
                                <div class="tp-blog-2-info-item">
                                    <span><i class="fa-regular fa-eye"></i> <?php echo e($item->viewed); ?> lượt xem</span>
                                </div>
                            </div>
                        </div>
                        <div class="tp-blog-2-content">
                            <h3 class="tp-blog-2-title"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                            <p class="desc"><?php echo strip_tags($item->description); ?></p>

                            <div class="tp-blog-2-btn">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">Xem thêm <span><i class="fa-regular fa-angle-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>





    <?php if(!empty($images)): ?>
    <?php
    $image_json = json_decode($images->image_json, TRUE);
    ?>
    <section class="instagram-area tp-instagram-bg mt-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-instagram-content mb-50">
                        <div class="tp-section text-center fs-48">
                            <h3 class="tp-section-title"><?php echo e($images->title); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-instagram-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-instagram-border">
                            <div class="tp-instagram-wrapper">
                                <div class="tp-instagram-2-active swiper-container">
                                    <div class="swiper-wrapper">
                                        <?php if(!empty($image_json)): ?>
                                        <?php $__currentLoopData = $image_json; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <div class="tp-instagram-item">
                                                <div class="tp-instagram-thumb">
                                                    <img src="<?php echo e(asset($item)); ?>" alt="instagram-thumb" style="height: 201px;">
                                                    <div class="tp-instagram-icon">
                                                        <a class="popup-image" href="<?php echo e(asset($item)); ?>"><span><img src="<?php echo e(asset('frontend/ncare/assets/img/icon/instagram.svg')); ?>" alt="instagram-svg"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>



    <?php if(!empty($partner->slides) && count($partner->slides) > 0): ?>
    <!-- social-media-area-start -->
    <div class="social-media-area mt-55 fix">
        <div class="container-fluid">
            <div class="tp-social-media-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper-container tp-social-active tp-social-media-wrapper">
                            <div class="swiper-wrapper">
                                <?php $__currentLoopData = $partner->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide tp-social-media-item">
                                    <a href="<?php echo e(url($slide->link)); ?>" target="_blank">
                                        <img src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e(strip_tags($slide->title)); ?>">
                                    </a>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- social-media-area-end -->
    <?php endif; ?>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
    <script src="<?php echo e(asset('frontend/ncare/assets/js/purecounter.js')); ?>"></script>
    <script>
        new PureCounter();
        new PureCounter({
            filesizing: true,
            selector: ".filesizecount",
            pulse: 2,
        });
    </script>
    <script>
        var slider = new Swiper(".tp-event-3-active", {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4500,
            },
            // Navigation arrows
            navigation: {
                nextEl: ".tp-event-2-button-next",
                prevEl: ".tp-event-2-button-prev",
            },
            autoplay: {
                delay: 4500,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
        var slider = new Swiper(".tp-instagram-2-active", {
            slidesPerView: 5,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000,
            },
            autoplay: {
                delay: 4500,
            },
            breakpoints: {
                1600: {
                    slidesPerView: 5,
                },
                1400: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
        var slider = new Swiper(".tp-slider-3-active", {
            slidesPerView: 1,
            loop: true,
            effect: "fade",
            autoplay: {
                delay: 4500,
            },
            // Navigation arrows
            navigation: {
                nextEl: ".tp-slider-btn-3-next",
                prevEl: ".tp-slider-btn-3-prev",
            },
            autoplay: {
                delay: 4500,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
        var slider = new Swiper('.tp-event-ck-active', {
            slidesPerView: 5,
            spaceBetween:30,
            loop: true,
            autoplay: {
                delay: 4500,
            },
            // Navigation arrows

            autoplay: {
                delay: 4500,
            },
            breakpoints: {
                '1200': {
                    slidesPerView: 5,
                },
                '992': {
                    slidesPerView: 3,
                },
                '768': {
                    slidesPerView: 2,
                },
                '576': {
                    slidesPerView: 1,
                },
                '0': {
                    slidesPerView: 1,
                },
            },
        });
        var slider = new Swiper(".tp-social-active", {
            slidesPerView: 6,
            loop: true,
            dots: true,
            autoplay: {
                delay: 4000,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 6,
                },
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .tp-processing-2-thumb{
            position: relative;
            height: 100%;
        }
        .tp-processing-2-thumb > img{
            position: absolute;
            bottom: 0px;
            right: 0px;
        }
        @media (max-width: 767px) {

            .tp-processing-2-thumb > img{
                position: unset;

            }
        }
    </style>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/homepage/home/index.blade.php ENDPATH**/ ?>
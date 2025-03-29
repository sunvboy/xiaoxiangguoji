<?php $__env->startSection('content'); ?>
<div class="ps-home ps-home--1">
    <!-- START: SLIDER -->
    <div class="main-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-9 col-12">
                    <div class="slider-main owl-carousel">
                        <?php if($slideHome): ?>
                        <?php if($slideHome->slides): ?>
                        <?php $__currentLoopData = $slideHome->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <a href="<?php echo e(url($slide->link)); ?>">
                                <img src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>" />
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- <div class="banner-home">
                        <a href="">
                            <img src="upload/images/banner/bn-1.jpg" alt="">
                        </a>
                    </div> -->
                </div>
                <div class="col-md-3 col-sm-3 col-12">
                    <div class="ads-right-1">
                        <?php if($slideHomeRight): ?>
                        <?php if($slideHomeRight->slides): ?>
                        <?php $__currentLoopData = $slideHomeRight->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <a href="<?php echo e(url($slide->link)); ?>">
                                <img src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>" />
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: SLIDER -->
    <!-- START: DANH MỤC SẢN PHẨM -->
    <?php if(!empty($ishomeCategoryProduct)): ?>
    <section class="category-modul-home wow fadeInUp">
        <div class="container">
            <div class="section-title-2 cat">
                <h2 class="ps-section__title title title split-in-fade">Danh mục sản phẩm</h2>
            </div>
            <div class="slider-category-1 owl-carousel">
                <?php $__currentLoopData = $ishomeCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="icon">
                        <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>" class="icon-1">
                            <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>">
                        </a>
                        <!-- <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>"></a> -->
                    </div>
                    <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- END: DANH MỤC SẢN PHẨM -->
    <div class="ps-home__content">
        <?php if($fcSystem['homepage_sale'] == 1): ?>
        <?php if(!empty($isHomeProduct)): ?>
        <!-- START: GIỜ VANG DEAL SỐC -->
        <div class="Feature-product-sale wow fadeInUp">
            <section class="ps-section--latest-sale ps-section--latest-sale-new">
                <div class="container">
                    <div class="bg-sale">
                        <img src="<?php echo e($fcSystem['banner_4']); ?>" alt="GIỜ VANG DEAL SỐC">
                        <div class="ps-countdown">
                            <div class="ps-countdown__content">
                                <div class="ps-countdown__block ps-countdown__days">
                                    <div class="ps-countdown__ref">Ngày</div>
                                    <div class="ps-countdown__number"><span class="first-1st">0</span><span class="firsdayst" id="days">0</span></div>
                                </div>
                                <div class="ps-countdown__block ps-countdown__hours">
                                    <div class="ps-countdown__ref">Giờ</div>
                                    <div class="ps-countdown__number"><span class="last" id="hours">0</span></div>
                                </div>
                                <div class="ps-countdown__block ps-countdown__minutes">
                                    <div class="ps-countdown__ref">Phút</div>
                                    <div class="ps-countdown__number"><span class="last" id="minutes">0</span></div>
                                </div>
                                <div class="ps-countdown__block ps-countdown__seconds">
                                    <div class="ps-countdown__ref">Giây </div>
                                    <div class="ps-countdown__number"><span class="last" id="seconds">0</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-product-latest ">
                        <div class="ps-section__carousel">
                            <div class="owl-carousel slider-product-sale-2">
                                <?php $__currentLoopData = $isHomeProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo htmlItemProduct2($key, $item) ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END: GIỜ VANG DEAL SỐC -->
        <?php endif; ?>
        <?php endif; ?>

        <!-- START: SẢN PHẨM BÁN CHẠY -->
        <?php if(!empty($highlightCategoryProduct)): ?>
        <section class="ps-section--sellers category wow fadeInUp">
            <div class="container">
                <div class="section-title-2 cat">
                    <h2 class="ps-section__title title title split-in-fade"> Top Sản phẩm bán chạy DCL</h2>
                </div>
                <div class="ps-section__tab cat">
                    <ul class="nav nav-tabs" id="bestsellerTab" role="tablist">
                        <?php $__currentLoopData = $highlightCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item" role="presentation"><a class="nav-link <?php if($key == 0): ?> active <?php endif; ?>" id="blood-tab-<?php echo e($item->id); ?>" data-toggle="tab" href="#blood-<?php echo e($item->id); ?>" role="tab" aria-controls="blood" aria-selected="true"><?php echo e($item->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="tab-content" id="bestsellerTabContent">
                        <?php $__currentLoopData = $highlightCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($item->posts)): ?>
                        <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="blood-<?php echo e($item->id); ?>" role="tabpanel" aria-labelledby="blood-tab-<?php echo e($item->id); ?>">
                            <div class="slider-product-only owl-carousel">
                                <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ps-section__product">
                                    <?php echo htmlItemProduct($k,$val); ?>

                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- END: SẢN PHẨM BÁN CHẠY -->
        <!-- START: SẢN PHẨM CHỈ CÓ TẠI ĐẠI CÁT LỘC-->
        <?php if(!empty($isasideCategoryProduct)): ?>
        <?php if(!empty($isasideCategoryProduct->posts)): ?>
        <section class="ps-section--featured wow fadeInUp">
            <div class="container">
                <div class="section-title-2">
                    <h2 class=" ps-section__title title title split-in-fade"> <?php echo e($isasideCategoryProduct->title); ?></h2>
                </div>
                <div class="ps-section__content">
                    <div class="slider-product-only owl-carousel">
                        <?php $__currentLoopData = $isasideCategoryProduct->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ps-section__product">
                            <?php echo htmlItemProduct($key,$item); ?>

                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="ps-shop__more"><a href="<?php echo e(route('routerURL',['slug' => $isasideCategoryProduct->slug])); ?>">Show all</a></div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php endif; ?>
        <!-- END: SẢN PHẨM CHỈ CÓ TẠI ĐẠI CÁT LỘC-->
        <!-- START: Kiểm tra sức khỏe-->
        <section class="ps-banner--round wow fadeInUp">
            <div class="bg-ktr">
                <img src="frontend/img/bg-ktr.png" alt="Kiểm tra sức khỏe">
            </div>
            <div class="container">
                <div class="ps-banner">
                    <div class="ps-banner__block">
                        <div class="ps-banner__content">
                            <h2 class="ps-banner__title">Kiểm tra<span> sức khỏe</span> </h2>
                            <p class="desc"><?php echo e($fcSystem['title_5']); ?></p>
                            <div class="ps-banner__btn-group">
                                <div class="owl-carousel slider-health-check">
                                    <?php if(!empty($quizzes)): ?>
                                    <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('routerURL',['slug' => $slide->slug])); ?>" class="ps-banner__btn">
                                        <div class="icon">
                                            <img src="<?php echo e(asset($slide->image)); ?>" alt="<?php echo e($slide->title); ?>">
                                        </div>
                                        <div class="text">
                                            <h3 class="title-3"><?php echo $slide->title; ?></h3>
                                        </div>
                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="link-link">
                                <a href="<?php echo e($fcSystem['title_6']); ?>">Bắt đầu</a>
                            </div>
                        </div>
                        <div class="ps-banner__thumnail">
                            <img class="ps-banner__image" src="frontend/img/img-ktr.png">
                            <!-- <img class="ps-banner__image" src="<?php echo e($fcSystem['title_7']); ?>" alt="<?php echo e($fcSystem['title_4']); ?>"> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Kiểm tra sức khỏe-->
        <!-- START:  SẢN PHẨM THEO ĐỐI TƯỢNG-->
        <?php if(!empty($isfooterCategoryProduct)): ?>
        <section class="Modul-product-2 wow fadeInUp">
            <div class="container">
                <div class="ps-section__tab cat">
                    <div class="title-title-2">
                        <h2 class="title-primary">
                            Sản phẩm theo đối tượng
                        </h2>
                    </div>
                    <ul class="nav nav-tabs ">
                        <?php $__currentLoopData = $isfooterCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if($key == 0): ?> active <?php endif; ?>" data-toggle="tab" href="#modul-tab-<?php echo e($item->id); ?>" role="tab"><?php echo e($item->title); ?></a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="tab-content" id="bestsellerTabContent">
                        <?php $__currentLoopData = $isfooterCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($item->posts)): ?>
                        <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="modul-tab-<?php echo e($item->id); ?>">
                            <div class="content-product-2">
                                <div class="slider-product-2 owl-carousel">
                                    <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo htmlItemProduct2($k,$val); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="view_all text-center">
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"> Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- END:  SẢN PHẨM THEO ĐỐI TƯỢNG -->
        <!-- START: SẢN PHẨM MỚI -->
        <div class="modul-product-new-home wow fadeInUp">
            <?php if(!empty($isnewCategoryProduct)): ?>
            <div class="container">
                <section class="ps-section--sellers">
                    <div class="bg-img">
                        <img src="<?php echo e($fcSystem['banner_6']); ?>" alt="Sản phẩm mới">
                    </div>
                    <div class="section-title-2">
                        <h2 class=" ps-section__title title title split-in-fade">Sản phẩm mới</h2>
                    </div>
                    <div class="ps-section__tab">
                        <div class="top-section__tab">
                            <ul class="nav nav-tabs" id="bestsellerTab" role="tablist">
                                <?php $__currentLoopData = $isnewCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item" role="presentation"><a class="nav-link <?php if($key == 0): ?> active <?php endif; ?>" data-toggle="tab" href="#blood1-tab-<?php echo e($item->id); ?>" role="tab" aria-controls="blood" aria-selected="true"><?php echo e($item->title); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="tab-content" id="bestsellerTabContent">
                            <?php $__currentLoopData = $isnewCategoryProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($item->posts)): ?>
                            <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="blood1-tab-<?php echo e($item->id); ?>" role="tabpanel">
                                <div class="slider-product-only owl-carousel">
                                    <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
                                    $i_class = 'fa-heart-o';
                                    if (!empty($wishlist)) {
                                        if (in_array($val['id'], $wishlist)) {
                                            $i_class = 'fa-heart';
                                        }
                                    }
                                    $html = '';
                                    $price = getPrice(array('price' => $val['price'], 'price_sale' => $val['price_sale'], 'price_contact' =>
                                    $val['price_contact']));
                                    $route = route('routerURL', ['slug' => $val['slug']]);
                                    if (!empty($val['image_json'])) {
                                        $listAlbums = json_decode($val['image_json'], true);
                                        if (count($listAlbums) < 2) {
                                            $listAlbums = [$val['image'], $val['image']];
                                        }
                                    } else {
                                        $listAlbums = [$val['image'], $val['image']];
                                    }
                                    $html .= ' <div class="item-product-2">
                                                <div class="img">';
                                    if (!empty($price['percent'])) {
                                        $html .= '<span class="smart">-
                                                        ' . $price['percent'] . '
                                                    </span>';
                                    }
                                    ?>
                                    <div class="ps-section__product">
                                        <div class="ps-product ps-product--standard">
                                            <div class="ps-product__thumbnail">
                                                <?php /*<span class="icon-wish js_add_wishlist cursor-pointer" data-id="15">
                                                    <svg class="icon fa-regular js_add_wishlist_15" xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                                        <path d="M1.2002 5.8C1.2002 4.11984 1.2002 3.27976 1.52718 2.63803C1.8148 2.07354 2.27374 1.6146 2.83822 1.32698C3.47996 1 4.32004 1 6.0002 1H10.4002C12.0804 1 12.9204 1 13.5622 1.32698C14.1267 1.6146 14.5856 2.07354 14.8732 2.63803C15.2002 3.27976 15.2002 4.11984 15.2002 5.8V19L8.2002 15L1.2002 19V5.8Z" stroke="#00AB6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>*/ ?>
                                                <a class="ps-product__image" href="<?php echo $route ?>">
                                                    <figure>

                                                        <img src="<?php echo asset($val['image']) ?>" alt="<?php echo $val['title'] ?>">
                                                    </figure>
                                                </a>
                                                <div class="heart-cart">
                                                    <a href="javascript:void(0)" class="heart js_add_wishlist" data-id="<?php echo $val['id'] ?>">
                                                        <i class="fa <?php echo $i_class ?> js_add_wishlist_<?php echo $val['id']; ?>"></i>
                                                    </a>
                                                    <a href="<?php echo $route ?>" class="cart"><i class="icon-cart-empty"></i></a>
                                                </div>
                                            </div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a href="<?php echo $route ?>"><?php echo $val['title'] ?></a></h5>
                                                <div class="ps-product__meta">
                                                    <span class="ps-product__price sale"><?php echo $price['price_final'] ?></span>
                                                    <span class="ps-product__del"><?php echo $price['price_old'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="add-to-cart" style="cursor: pointer;" onclick="location.href='<?php echo $route ?>'">Mua hàng</button>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </section>
            </div>
            <?php endif; ?>
            <!-- END: SẢN PHẨM MỚI -->
        </div>
        <!-- START: ĐẶT THUỐC THEO TOA DỄ DÀNG TẠI ĐẠI CÁT LỘC -->
        <?php if($orderHome): ?>
        <?php if($orderHome->slides): ?>
        <section class="rs-progress-3 wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-2">
                            <span><a href="<?php echo e($fcSystem['social_facebook']); ?>" target="_blank">Chát ngay&nbsp;</a> hoặc gọi Hotline <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"> &nbsp;<?php echo e($fcSystem['contact_hotline']); ?></a></span>
                            <h2 class="title split-in-fade"><?php echo e($fcSystem['title_10']); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="bg-step">
                    <img src="<?php echo e($fcSystem['banner_5']); ?>" alt="Đặt thuốc theo toa dễ dàng tại <?php echo e($fcSystem['homepage_brandname']); ?>">
                </div>
                <div class="row">
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $orderHome->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $i++; ?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="rs-progress-3__item  <?php if($i%2 == 0): ?> item-2 <?php endif; ?>">
                            <div class="rs-progress-3__content">
                                <?php /*h4 class="title-4">Bước 1</h4>*/ ?>
                                <h3 class="title-3"><?php echo e($item->title); ?></h3>
                                <p class="desc"><?php echo e($item->description); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php /*<div class="rs-shape-1">
                <img class="gsap-move right-200 start-91" src="img/project-shape-1.png" alt="">
            </div>
            <div class="rs-shape-2">
                <img class="gsap-move down-200 start-91" src="img/project-shape-2.png" alt="">
            </div>*/ ?>
        </section>
        <?php endif; ?>
        <?php endif; ?>
        <!-- END: ĐẶT THUỐC THEO TOA DỄ DÀNG TẠI ĐẠI CÁT LỘC -->
        <!-- START: SỰ KIỆN. TIN TỨC -->
        <section class="Modul-new-home health-corner wow fadeInUp">
            <div class="container">
                <div class="row">
                    <?php if(!empty($highlightCategoryArticle)): ?>
                    <?php if(!empty($highlightCategoryArticle->posts)): ?>
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="title-title-2">
                            <h2 class="title-primary">
                                <span class="icon">
                                    <img src="frontend/img/icon-sk.png" alt="">
                                </span> <?php echo e($highlightCategoryArticle->title); ?>

                            </h2>
                        </div>
                        <div class="row">
                            <?php $__currentLoopData = $highlightCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key == 0): ?>
                            <div class="col-md-6 col-xs-6 col-12">
                                <div class="item-large">
                                    <div class="img  hover-zoom">
                                        <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                            <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                        </a>
                                    </div>
                                    <div class="nav-img">
                                        <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                        <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i>Ngày đăng: <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></div>
                                        <div class="desc">
                                            <?php echo e(strip_tags($item->description)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-xs-6 col-12">
                                <div class="item-small">
                                    <?php $__currentLoopData = $highlightCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key > 0): ?>
                                    <div class="item">
                                        <div class="img hover-zoom">
                                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                                <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                            </a>
                                        </div>
                                        <div class="nav-img">
                                            <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                            <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i>Ngày đăng: <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="view_all text-center">
                            <a href="<?php echo e(route('routerURL',['slug' => $highlightCategoryArticle->slug])); ?>"> Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(!empty($ishomeCategoryArticle)): ?>
                    <?php if(!empty($ishomeCategoryArticle->posts)): ?>
                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="title-title-2">
                            <h2 class="title-primary">
                                <img src="frontend/img/icon-tt.png" alt=""> <?php echo e($ishomeCategoryArticle->title); ?>

                            </h2>
                        </div>
                        <div class="item-small">
                            <?php $__currentLoopData = $ishomeCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="img hover-zoom">
                                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                        <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                                    </a>
                                </div>
                                <div class="nav-img">
                                    <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                                    <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i>Ngày đăng: <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y')); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="view_all text-center">
                            <a href="<?php echo e(route('routerURL',['slug' => $ishomeCategoryArticle->slug])); ?>"> Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!-- END: SỰ KIỆN. TIN TỨC -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<style>
    .ps-footer--5 .ps-footer--top {
        background: #fff !important;
    }
</style>
<script>
    (function() {
        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;
        //I'm adding this section so I don't have to keep updating this pen every year :-)
        //remove this if you don't need it
        let today = new Date(),
            dd = String(today.getDate()).padStart(2, "0"),
            mm = String(today.getMonth() + 1).padStart(2, "0"),
            yyyy = today.getFullYear(),
            nextYear = yyyy,
            dayMonth = "06/30/",
            birthday = dayMonth + yyyy;
        today = mm + "/" + dd + "/" + yyyy;
        if (today > birthday) {
            birthday = dayMonth + nextYear;
        }
        //end
        const countDown = new Date(birthday).getTime(),
            x = setInterval(function() {
                const now = new Date().getTime(),
                    distance = countDown - now;
                document.getElementById("days").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)).toString().padStart(2, '0'),
                    document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)).toString().padStart(2, '0'),
                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second).toString().padStart(2, '0');
                //do something later when date is reached
                if (distance < 0) {
                    document.getElementById("headline").innerText = "It's my birthday!";
                    document.getElementById("countdown").style.display = "none";
                    document.getElementById("content").style.display = "block";
                    clearInterval(x);
                }
                //seconds
            }, 0)
    }());
</script>

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/homepage/home/index.blade.php ENDPATH**/ ?>
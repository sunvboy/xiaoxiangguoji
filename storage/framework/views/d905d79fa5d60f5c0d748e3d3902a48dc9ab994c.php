  <?php $menu_header = getMenus('menu-header'); ?>
  <div class="back-to-top-wrapper">
      <button id="back_to_top" type="button" class="back-to-top-btn">
          <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
      </button>
  </div>
  <!-- back to top end -->
  <!-- header area start -->
  <header>
      <div class="tp-header-area tp-header-3">
          <div class="tp-header-border">
              <div class="tp-header-top theme-bg d-none d-lg-block">
                  <div class="container">
                      <div class="row">
                          <div class="col-xl-6 col-lg-7">
                              <div class="tp-header-top-content">
                                  <p><b><?php echo e($fcSystem['homepage_company']); ?></b><span> - <i><?php echo e($fcSystem['homepage_slogan']); ?> </i></span></p>
                              </div>
                          </div>
                          <div class="col-xl-6 col-lg-5">
                              <div class="tp-header-top-social text-md-end">
                                  <span>Liên kết:</span>
                                  <?php if(!empty($fcSystem['social_facebook'])): ?>
                                  <a href="<?php echo e($fcSystem['social_facebook']); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                  <?php endif; ?>
                                  <?php if(!empty($fcSystem['social_youtube'])): ?>
                                      <a href="<?php echo e($fcSystem['social_youtube']); ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                  <?php endif; ?>
                                  <?php if(!empty($fcSystem['social_twitter'])): ?>
                                  <a href="<?php echo e($fcSystem['social_twitter']); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                  <?php endif; ?>
                                  <?php if(!empty($fcSystem['social_vimeo'])): ?>
                                  <a href="<?php echo e($fcSystem['social_vimeo']); ?>" target="_blank"><i class="fa-brands fa-vimeo-v"></i></a>
                                  <?php endif; ?>
                                  <?php if(!empty($fcSystem['social_pinterest'])): ?>
                                  <a href="<?php echo e($fcSystem['social_pinterest']); ?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
                                  <?php endif; ?>


                                  <div class="language-top">
                                    <div class="click-language"><img src="frontend/ncare/assets/img/ic-1.png" alt=""></div>
                                    <div class="nav-language">
                                        <a href=""><img src="frontend/ncare/assets/img/ic-1.png" alt=""></a>
                                        <a href=""><img src="frontend/ncare/assets/img/ic-3.png" alt=""></a>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tp-header-exgency theme-bg">
              <div class="container">
                  <div class="row align-items-center">
                      <div class="col-xl-2 col-6">
                          <div class="tp-header-logo">
                              <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($fcSystem['homepage_logo'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>"></a>
                          </div>
                      </div>
                      <div class="col-xl-8 d-none d-xl-block">
                          <div class="tp-header-exgency-wrap d-flex align-items-center ml-70">
                              <div class="tp-header-exgency-item d-flex align-items-center mr-70">
                                  <div class="tp-header-exgency-icon">
                                      <span><i class="fa-sharp fa-solid fa-clock"></i></span>
                                  </div>
                                  <div class="tp-header-exgency-content">
                                      <h5 class="tp-header-exgency-title"><?php echo e($fcSystem['contact_time']); ?>:</h5>
                                      <span><?php echo $fcSystem['contact_time_2']; ?></span>
                                  </div>
                              </div>
                              <div class="tp-header-exgency-item d-flex align-items-center">
                                  <div class="tp-header-exgency-icon">
                                      <span><i class="fa-sharp fa-solid fa-envelope"></i></span>
                                  </div>
                                  <div class="tp-header-exgency-content">
                                      <h5 class="tp-header-exgency-title">Email:</h5>
                                      <a href="mailto:<?php echo e($fcSystem['contact_email']); ?>"><span class="__cf_email__"><?php echo e($fcSystem['contact_email']); ?></span></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-2 col-6">
                          <div class="tp-header-exgency-call d-none d-xl-block">
                              <div class="tp-header-exgency-item d-flex align-items-center justify-content-lg-end">
                                  <div class="tp-header-exgency-icon">
                                      <span><i class="flaticon-phone-call"></i></span>
                                  </div>
                                  <div class="tp-header-exgency-content">
                                      <h5 class="tp-header-exgency-title">Hotline:</h5>
                                      <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"><?php echo e($fcSystem['contact_hotline']); ?></a>
                                  </div>
                              </div>
                          </div>
                          <div class="offcanvas-btn text-end d-xl-none ml-30">
                              <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tp-header-bottom d-none d-xl-block">
              <div class="container">
                  <div class="tp-header-bottom-main">
                      <div class="row align-items-center">
                          <div class="col-xl-12 col-lg-8 col-md-9 col-4">
                              <div class="tp-header-2-main d-flex align-items-center justify-content-xl-between justify-content-end">
                                  <div class="main-menu d-none d-xl-block">
                                      <nav id="mobile-menu" class="tp-main-menu-content">
                                          <ul>
                                              <?php if(!empty($menu_header->menu_items) && count($menu_header->menu_items) > 0): ?>
                                              <?php $__currentLoopData = $menu_header->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <li <?php if(!empty($item->children) && count($item->children) > 0): ?> class="has-dropdown" <?php endif; ?>>
                                                  <a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?>

                                                      <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                                      <i class="fa-solid fa-angle-down"></i>
                                                      <?php endif; ?>
                                                  </a>
                                                  <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                                  <ul class="tp-submenu">
                                                      <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      <li class="nav-item">
                                                          <a href="<?php echo e(url($child->slug)); ?>"><?php echo e($child->title); ?>

                                                              <?php if(!empty($child->children) && count($child->children) > 0): ?>
                                                                  <i class="fa-solid fa-angle-right" style="position: absolute;right: 15px;top: 5px;"></i>
                                                              <?php endif; ?>
                                                          </a>

                                                          <?php if(!empty($child->children) && count($child->children) > 0): ?>
                                                              <ul class="tp-submenu">
                                                                  <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                      <li class="nav-item">
                                                                          <a href="<?php echo e(url($child2->slug)); ?>"><?php echo e($child2->title); ?></a>
                                                                      </li>
                                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              </ul>
                                                          <?php endif; ?>

                                                      </li>

                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </ul>
                                                  <?php endif; ?>
                                              </li>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php endif; ?>
                                          </ul>
                                      </nav>
                                  </div>
                                  <div class="d-none d-md-block">
                                      <form method="GET" action="<?php echo e(route('categoryArticle.search')); ?>">
                                          <div class="tp-header-3-search">
                                              <div class="tp-header-3-search-input">
                                                  <input type="text" name="keyword" placeholder="Tìm kiếm">
                                              </div>
                                              <div class="tp-header-3-search-btn">
                                                  <button><i class="fa-light fa-magnifying-glass"></i></button>
                                              </div>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </header>
  <!-- header area end -->
  <!-- header-sticky-area -->
  <div id="header-sticky" class="tp-header-sticky theme-bg-2">
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="tp-header-bottom ">
                      <div class="row align-items-center">
                          <div class="col-xl-2 col-lg-4 col-md-3 col-8">
                              <div class="logo">
                                  <a href="<?php echo e(url('/')); ?>">
                                      <img data-width="115" src="<?php echo e(asset($fcSystem['homepage_logo_mobile'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>">
                                  </a>
                              </div>
                          </div>
                          <div class="col-xl-10 col-lg-8 col-md-9 col-4">
                              <div class="tp-header-2-main d-flex align-items-center justify-content-xl-between justify-content-end">
                                  <div class="main-menu d-none d-xl-block">
                                      <nav class="tp-main-menu-content">
                                          <ul>
                                              <?php if(!empty($menu_header->menu_items) && count($menu_header->menu_items) > 0): ?>
                                              <?php $__currentLoopData = $menu_header->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <li <?php if(!empty($item->children) && count($item->children) > 0): ?> class="has-dropdown" <?php endif; ?>>
                                                  <a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?>

                                                      <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                                      <i class="fa-solid fa-angle-down"></i>
                                                      <?php endif; ?>
                                                  </a>
                                                  <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                                  <ul class="tp-submenu">
                                                      <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      <li class="nav-item"><a href="<?php echo e(url($child->slug)); ?>"><?php echo e($child->title); ?></a>

                                                          <?php if(!empty($child->children) && count($child->children) > 0): ?>
                                                              <ul class="tp-submenu">
                                                                  <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                      <li class="nav-item"><a href="<?php echo e(url($child2->slug)); ?>"><?php echo e($child2->title); ?></a></li>
                                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              </ul>
                                                          <?php endif; ?>
                                                      </li>
                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </ul>
                                                  <?php endif; ?>
                                              </li>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php endif; ?>
                                          </ul>


                                      </nav>
                                  </div>
                                  <div class="d-none d-md-block">
                                      <div class="tp-header-right d-flex align-items-center justify-content-end">
                                          <div class="tp-header-search">
                                              <button class="tp-header-search-btn tp-search-open-btn" type="submit">
                                                  <i class="fa-light fa-magnifying-glass"></i>
                                              </button>
                                          </div>
                                          <div class="tp-header-call d-flex align-items-center">
                                              <div class="tp-header-call-icon">
                                                  <span><img src="<?php echo e(asset('frontend/ncare/assets/img/icon/phone-3.svg')); ?>" alt="icon phone"></span>
                                              </div>
                                              <div class="tp-header-call-content">
                                                  <span>Điện thoại:</span>
                                                  <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"><?php echo e($fcSystem['contact_hotline']); ?></a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="offcanvas-btn d-xl-none ml-30">
                                      <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- heafer-sticky-area-end -->
  <!-- offcanvas area start -->
  <div class="offcanvas__area">
      <div class="offcanvas__wrapper">
          <div class="offcanvas__close">
              <button class="offcanvas__close-btn offcanvas-close-btn">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
              </button>
          </div>
          <div class="offcanvas__content">
              <div class="offcanvas__top mb-70 d-flex justify-content-between align-items-center">
                  <div class="offcanvas__logo logo">
                      <a href="<?php echo e(url('/')); ?>">
                          <img src="<?php echo e(asset($fcSystem['homepage_logo_mobile'])); ?>" alt="logo">
                      </a>
                  </div>
              </div>
              <div class="tp-main-menu-mobile"></div>
              <div class="offcanvas__btn">
                  <a href="<?php echo e(route('pageF.order')); ?>" class="tp-btn">Đặt lịch khám <i class="fa-regular fa-chevron-right"></i></a>
              </div>
              <div class="side-info-contact">
                  <span><?php echo e($fcSystem['contact_hotline']); ?></span>
                  <p><?php echo e($fcSystem['contact_address']); ?></p>
              </div>
              <div class="side-info-social">
                  <?php if(!empty($fcSystem['social_facebook'])): ?>
                  <a href="<?php echo e($fcSystem['social_facebook']); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                  <?php endif; ?>
                      <?php if(!empty($fcSystem['social_youtube'])): ?>
                          <a href="<?php echo e($fcSystem['social_youtube']); ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                      <?php endif; ?>
                  <?php if(!empty($fcSystem['social_twitter'])): ?>
                  <a href="<?php echo e($fcSystem['social_twitter']); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                  <?php endif; ?>
                  <?php if(!empty($fcSystem['social_vimeo'])): ?>
                  <a href="<?php echo e($fcSystem['social_vimeo']); ?>" target="_blank"><i class="fa-brands fa-vimeo-v"></i></a>
                  <?php endif; ?>
                  <?php if(!empty($fcSystem['social_pinterest'])): ?>
                  <a href="<?php echo e($fcSystem['social_pinterest']); ?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
                  <?php endif; ?>
              </div>
          </div>
      </div>
  </div>
  <div class="body-overlay"></div>
  <!-- offcanvas area end -->
  <!-- header-search -->
  <!-- <div class="tpsearchbar tp-sidebar-area tp-search-area">
      <button class="tpsearchbar__close"><i class="fa-sharp fa-regular fa-xmark"></i></button>
      <div class="search-wrap text-center">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-lg-6 col-md-10 pt-100 pb-100">
                      <h2 class="tpsearchbar__title">What Are You Looking For?</h2>
                      <div class="tpsearchbar__form">
                          <form action="#">
                              <input type="text" name="search" placeholder="Search Product...">
                              <button class="tpsearchbar__search-btn"><i class="fa-regular fa-magnifying-glass"></i></button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="search-body-overlay"></div> -->
  <!-- header-search-end -->
<?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/homepage/common/header.blade.php ENDPATH**/ ?>
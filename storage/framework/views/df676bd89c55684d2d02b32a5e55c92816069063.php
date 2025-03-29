 <!-- Spinner Start -->
 <div id="spinner"
     class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
     <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
 </div>
 <!-- Spinner End -->


 <!-- Topbar Start -->
 <div class="container-fluid bg-primary text-white d-none d-lg-flex">
     <div class="container py-3">
         <div class="d-flex align-items-center">
             <a href="" class="brand-logo">
                 <h2 class="text-white fw-bold m-0"><?php echo e($fcSystem['homepage_company']); ?>

                 </h2>
             </a>
             <div class="ms-auto d-flex align-items-center">
                 <small class="ms-4"><i class="fa fa-map-marker-alt me-3"></i><?php echo e($fcSystem['contact_address']); ?></small>
                 <?php if($fcSystem['contact_email']): ?>
                 <small class="ms-4"><i class="fa fa-envelope me-3"></i><?php echo e($fcSystem['contact_email']); ?></small>
                 <?php endif; ?>
                 <small class="ms-4"><i class="fa fa-phone-alt me-3"></i><?php echo e($fcSystem['contact_hotline']); ?></small>
             </div>
         </div>
     </div>
 </div>
 <!-- Topbar End -->

 <?php $menu_footer = getMenus('menu-footer'); ?>
 <!-- Navbar Start -->
 <div class="container-fluid bg-white sticky-top">
     <div class="container">
         <nav class="navbar navbar-expand-lg bg-white navbar-light p-lg-0">
             <a href="" class="navbar-brand d-lg-none brand-logo">
                 <h1 class="fw-bold m-0"><?php echo e($fcSystem['homepage_company']); ?></h1>
             </a>
             <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                 data-bs-target="#navbarCollapse">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarCollapse">
                 <div class="navbar-nav">
                     <?php if(!empty($menu_footer)): ?>
                     <?php if(count($menu_footer->menu_items) > 0): ?>
                     <?php $__currentLoopData = $menu_footer->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <a href="<?php echo e(!empty($item->children->count() > 0)?'javascript:void(0)':url($item->slug)); ?>" class="nav-item nav-link"><?php echo e($item->title); ?></a>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php endif; ?>
                     <?php endif; ?>
                 </div>
                 <div class="ms-auto d-none d-lg-block">
                     <a href="<?php echo e(route('homepage.search')); ?>" class="btn btn-primary rounded-pill py-2 px-3">查询运单号</a>
                 </div>
             </div>
         </nav>
     </div>
 </div>
 <!-- Navbar End --><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/header.blade.php ENDPATH**/ ?>
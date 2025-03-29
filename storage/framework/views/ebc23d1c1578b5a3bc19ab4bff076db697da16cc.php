 <!-- Footer Start -->
 <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
     <div class="container py-5">
         <div class="row g-5">
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4"><?php echo e($fcSystem['homepage_company']); ?></h4>
                 <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><?php echo e($fcSystem['contact_address']); ?></p>
                 <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><?php echo e($fcSystem['contact_hotline']); ?></p>
                 <?php if($fcSystem['contact_email']): ?>
                 <p class="mb-2"><i class="fa fa-envelope me-3"></i><?php echo e($fcSystem['contact_email']); ?>

                     <?php endif; ?>
                 </p>
                 <div class="d-flex pt-3">

                     <a class="btn btn-square btn-light rounded-circle me-2" href="<?php echo e($fcSystem['social_twitter']); ?>" target="_blank"><i
                             class="fab fa-twitter"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="<?php echo e($fcSystem['social_facebook']); ?>" target="_blank"><i
                             class="fab fa-facebook-f"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="<?php echo e($fcSystem['social_youtube']); ?>" target="_blank"><i
                             class="fab fa-youtube"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="<?php echo e($fcSystem['social_linkedin']); ?>" target="_blank"><i
                             class="fab fa-linkedin-in"></i></a>
                 </div>
             </div>
             <?php $menu_footer = getMenus('menu-footer'); ?>
             <?php if(!empty($menu_footer)): ?>
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">快速链接</h4>
                 <?php if(count($menu_footer->menu_items) > 0): ?>
                 <?php $__currentLoopData = $menu_footer->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <a class="btn btn-link" href="<?php echo e(!empty($item->children->count() > 0)?'javascript:void(0)':url($item->slug)); ?>"> <?php echo e($item->title); ?></a>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>
             </div>
             <?php endif; ?>
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">营业时间</h4>
                 <?php echo $fcSystem['contact_time']; ?>

             </div>
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">订阅新闻</h4>
                 <p>获取最新的更新和优惠信息。</p>
                 <div class="position-relative w-100">
                     <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="您的电子邮件">
                     <button type="button"
                         class="btn btn-light py-2 position-absolute top-0 end-0 mt-2 me-2">注册</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Footer End -->


 <!-- Back to Top -->
 <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top" id="scrollUp"><i class="bi bi-arrow-up"></i></a>

 <script src="<?php echo e(asset('frontend/js/wow.min.js')); ?>"></script>
 <script src="<?php echo e(asset('frontend/js/easing.min.js')); ?>"></script>
 <script src="<?php echo e(asset('frontend/js/waypoints.min.js')); ?>"></script>
 <script src="<?php echo e(asset('frontend/js/owl.carousel.min.js')); ?>"></script>
 <script src="<?php echo e(asset('frontend/js/lightbox.min.js')); ?>"></script>
 <!-- Template Javascript -->
 <script src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $(".btn-submit").click(function(e) {
             $(".btn-submit").hide();
             $(".btn-loading").show();
             e.preventDefault();
             $.ajax({
                 url: "<?php echo route('contactFrontend.subcribers') ?>",
                 type: 'POST',
                 data: {
                     _token: $(".form-subscribe input[name='_token']").val(),
                     fullname: $(".form-subscribe input[name='fullname']").val(),
                     email: $(".form-subscribe input[name='email']").val(),
                     phone: $(".form-subscribe input[name='phone']").val(),
                     message: $(".form-subscribe textarea[name='message']").val(),
                     service: $(".form-subscribe select[name='service']").val(),
                 },
                 success: function(data) {
                     if (data.status == 200) {
                         $(".form-subscribe .alert.alert-danger").css('display', 'none');
                         $(".form-subscribe .alert.alert-success").css('display', 'block');
                         $(".form-subscribe .alert.alert-success").html("表单提交成功！");
                         $(".form-subscribe")[0].reset();
                         setTimeout(function() {
                             $(".form-subscribe .alert.alert-success").css('display', 'none');
                         }, 2000);
                     } else {
                         $(".form-subscribe .alert.alert-danger").css('display', 'block');
                         $(".form-subscribe .alert.alert-success").css('display', 'none');
                         $(".form-subscribe .alert.alert-danger").html(data.error);
                     }
                 },
                 complete: function() {
                     $(".btn-loading").hide();
                     $(".btn-submit").show();
                 }
             });
         });
     });
 </script><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/footer.blade.php ENDPATH**/ ?>
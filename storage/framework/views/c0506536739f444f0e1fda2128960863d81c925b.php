<footer>
   <div class="footr-area theme-bg pt-65">
      <div class="footer-top">
         <div class="container">
            <div class="row row-1">
               <div class="col-lg-9 col-md-9">
                  <div class="row">
                      <div class="col-md-6">

                          <div class="tp-footer-widget tp-footer-2-col-1 mb-65">
                              <div class="tp-footer-widget-content">
                                  <h4 class="tp-footer-widget-title mb-40"><?php echo e($fcSystem['homepage_company']); ?></h4>
                                  <div class="tp-footer-widget-content-list">
                                      <div class="tp-footer-widget-content-list-item d-flex align-items-start mb-10">
                                          <i class="fa-solid fa-location-dot"></i> <a target="_blank" href=""><?php echo e($fcSystem['contact_address']); ?></a>
                                      </div>
                                      <div class="tp-footer-widget-content-list-item d-flex align-items-start mb-10">
                                          <i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo e($fcSystem['contact_email']); ?>"><span class="__cf_email__"><?php echo e($fcSystem['contact_email']); ?></span></a>
                                      </div>
                                      <div class="tp-footer-widget-content-list-item d-flex align-items-start">
                                          <i class="fa-solid fa-globe"></i> <a href="<?php echo e(url('/')); ?>"><span><?php echo e($fcSystem['contact_website']); ?></span></a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="tp-footer-widget tp-footer-2-col-4 mb-65">
                              <h4 class="tp-footer-widget-title mb-40"><?php echo e($fcSystem['title_2']); ?></h4>
                              <div class="tp-footer-widget-newsletter">

                                  <div class="tp-footer-widget-newsletter-content">
                                      <p>Giờ mở cửa</p>
                                      <span><?php echo e($fcSystem['contact_time']); ?></span>
                                      <span><?php echo $fcSystem['contact_time_2']; ?></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-12">
                          <div class="row">
                              <?php
                              $menu_footer = getMenus('menu-footer');
                              ?>
                              <?php if(!empty($menu_footer->menu_items) && count($menu_footer->menu_items) > 0): ?>
                                  <?php $__currentLoopData = $menu_footer->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <div class="col-lg-4 col-md-6 col-sm-6">
                                          <div class="tp-footer-widget mb-65">
                                              <h4 class="tp-footer-widget-title mb-30"><?php echo e($item->title); ?></h4>
                                              <div class="tp-footer-widget-link">
                                                  <ul>
                                                      <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                                          <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                              <li><a href="<?php echo e(url($child->slug)); ?>"><?php echo e($child->title); ?></a></li>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      <?php endif; ?>
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>




                          </div>
                      </div>
                  </div>
               </div>
                <div class="col-md-3 main-book">
                    <h4 class="tp-footer-widget-title mb-40">ĐĂNG KÝ TƯ VẤN</h4>
                    <div class="form-right" style="padding: 0px">
                        <form action="" class="form-subscribe-footer">
                            <?php echo csrf_field(); ?>
                            <div class="alert alert-danger print-error-msg " style="display: none">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline"></span>
                            </div>
                            <div class="alert alert-success print-success-msg" style="display: none">
                                <span class="font-bold"></span>
                            </div>
                            <input type="text" placeholder="Họ và tên" name="fullname">
                            <input type="text" placeholder="Số điện thoại" name="phone">
                            <input type="text" placeholder="Email" name="email">
                            <div class="btn" style="margin: 0px;padding: 0px">
                                <button class="btn-submit-footer" style="display: flex;justify-content: center;align-items: center;">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
             <div class="row row-2">

                 <div class="col-lg-4 col-md-4 col-xs-6">
                     <div class="tp-footer-widget mb-65">
                         <h4 class="tp-footer-widget-title mb-40">Facebook</h4>
                         <div class="tp-footer">
                             <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo e($fcSystem['social_facebook']); ?>&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=343876996017079" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                         </div>

                     </div>
                 </div>
                 <div class="col-lg-4 col-md-4 col-xs-6">
                     <div class="tp-footer-widget mb-65">
                         <h4 class="tp-footer-widget-title mb-40">Map</h4>
                         <div class="tp-footer">
                             <?php echo $fcSystem['contact_map']; ?>

                         </div>

                     </div>
                 </div>
                 <?php
                 $payment = \App\Models\CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'payment'])->with('slides')->first();
                 ?>
                 <div class="col-lg-4 col-md-4 col-xs-6">
                     <div class="tp-footer-widget mb-65">
                         <h4 class="tp-footer-widget-title mb-40">Phương thức thanh toán</h4>
                         <div class="tp-footer">
                             <div class="mt-3 d-flex flex-wrap gap-2">
                                 <?php if($payment): ?>
                                     <?php if($payment->slides): ?>
                                         <?php $__currentLoopData = $payment->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img alt="pay-icon" src="<?php echo e(asset($slide->src)); ?>" style="color: transparent;">
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     <?php endif; ?>
                                 <?php endif; ?>
                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
         <div class="tp-footer-bottom">
            <div class="container">
               <div class="tp-footer-bottom-wrap">
                  <div class="row align-items-center">
                     <div class="col-lg-4 col-md-4">
                        <div class="tp-footer-copyright text-center text-md-start">
                           <p><span>© <?php echo date('Y') ?></span><a target="_blank" href="javascript:void(0)">Copyright.</a><?php echo e($fcSystem['homepage_company']); ?> </p>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4">
                        <div class="tp-footer-social text-center">
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
                     <div class="col-lg-4 col-md-4">
                        <div class="tp-footer-terms text-center text-md-end">
                           <a href="javascript:void(0)">Điều khoản sử dụng</a>
                           <a href="javascript:void(0)">Chính sách bảo mật</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</footer>
<script src="<?php echo e(asset('frontend/ncare/assets/js/vendor/jquery.js')); ?>"></script>

<script src="<?php echo e(asset('frontend/ncare/assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/ncare/assets/js/meanmenu.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/ncare/assets/js/swiper-bundle.js')); ?>"></script>





<script src="<?php echo e(asset('frontend/ncare/assets/js/wow.js')); ?>"></script>



<script src="<?php echo e(asset('frontend/ncare/assets/js/main.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-submit-footer").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo route('contactFrontend.subcribers') ?>",
                type: 'POST',
                data: {
                    _token: $(".form-subscribe-footer input[name='_token']").val(),
                    fullname: $(".form-subscribe-footer input[name='fullname']").val(),
                    email: $(".form-subscribe-footer input[name='email']").val(),
                    phone: $(".form-subscribe-footer input[name='phone']").val(),
                    message: $(".form-subscribe-footer textarea[name='message']").val(),
                },
                success: function(data) {
                    if (data.status == 200) {
                        $(".form-subscribe-footer .print-error-msg").css('display', 'none');
                        $(".form-subscribe-footer .print-success-msg").css('display', 'block');
                        $(".form-subscribe-footer .print-success-msg span").html("<?php echo $fcSystem['message_1'] ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        $(".form-subscribe-footer .print-error-msg").css('display', 'block');
                        $(".form-subscribe-footer .print-success-msg").css('display', 'none');
                        $(".form-subscribe-footer .print-error-msg span").html(data.error);
                    }
                }
            });
        });
    });
</script>
<?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/homepage/common/footer.blade.php ENDPATH**/ ?>
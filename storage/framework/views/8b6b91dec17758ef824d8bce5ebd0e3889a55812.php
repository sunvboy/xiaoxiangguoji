  
  <?php $__env->startSection('content'); ?>
      <main>
          <!-- breadcrumb-area-start -->
          <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="<?php echo e(asset($fcSystem['banner_8'])); ?>">
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
          <!-- contact-area-start -->
          <section class="contact-area pt-110 pb-60">
              <div class="container">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="tp-contact-wrapper mb-60">
                              <div class="tp-contact-inner">
                                  <h4 class="tp-contact-inner-title"><?php echo e($page->title); ?></h4>
                                  <p>Hãy liên hệ với chúng tôi để được giải đáp nhanh nhất</p>
                              </div>
                              <div class="tp-contact-wrap">
                                  <div class="row">
                                      <div class="col-xl-4 col-lg-6 col-md-6">
                                          <div class="tp-contact-item">
                                              <span>Liên hệ</span>
                                              <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"><?php echo e($fcSystem['contact_hotline']); ?></a>
                                          </div>
                                          <div class="tp-contact-item">
                                              <span>Địa chỉ:</span>
                                              <a href="javascript:void(0)"><?php echo e($fcSystem['contact_address']); ?></a>
                                          </div>
                                      </div>
                                      <div class="col-xl-8 col-lg-6 col-md-6">
                                          <div class="tp-contact-item ml-15">
                                              <span>Email</span>
                                              <a href="mailto:<?php echo e($fcSystem['contact_address']); ?>"><span class="__cf_email__"><?php echo e($fcSystem['contact_email']); ?></span></a>
                                          </div>
                                          <div class="tp-contact-item tp-contact-social ml-15">
                                              <span>Follow</span>
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
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="tp-contact-form mb-60">
                              <div class="tp-contact-form-content">
                                  <h4 class="tp-contact-form-title">Thông tin liên hệ</h4>
                              </div>
                              <div class="tp-contact-form-wrap">
                                  <form action="#" id="form-submit-contact">
                                      <?php echo csrf_field(); ?>
                                      <div class="alert alert-danger print-error-msg " style="display: none">
                                          <strong class="font-bold">ERROR!</strong>
                                          <span class="block sm:inline"></span>
                                      </div>
                                      <div class="alert alert-success print-success-msg" style="display: none">
                                          <span class="font-bold"></span>
                                      </div>
                                      <div class="tp-contact-form-input mb-45">
                                          <span> <i class="fa-light fa-user"></i></span>
                                          <input type="text" placeholder="Tên*" name="fullname">
                                      </div>
                                      <div class="tp-contact-form-input mb-45">
                                          <span><i class="fa-sharp fa-light fa-envelope"></i></span>
                                          <input type="email" placeholder="Email*" name="email">
                                      </div>
                                      <div class="tp-contact-form-input mb-45">
                                          <span><i class="fa-sharp fa-light fa-phone"></i></span>
                                          <input type="text" placeholder="Số điện thoại*" name="phone">
                                      </div>
                                      <div class="tp-contact-form-input mb-45">
                                          <span><i class="fa-light fa-pen-to-square"></i></span>
                                          <textarea name="message" placeholder="Nội dung"></textarea>
                                      </div>
                                      <div class="tp-contact-form-submit">
                                          <button class="tp-btn btn-submit-contact"><i class="fa-light fa-paper-plane"></i> Gửi</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          <!-- contact-area-end -->
          <!-- map-area-start -->
          <div class="map-area">
              <div class="tp-map-wrap">
                  <?php echo $fcSystem['contact_map']; ?>

              </div>
          </div>
          <!-- map-area-enmd -->
      </main>
  <?php $__env->stopSection(); ?>
  <?php $__env->startPush('javascript'); ?>
  <script type="text/javascript">
      $(document).ready(function() {
          $(".btn-submit-contact").click(function(e) {
              e.preventDefault();
              var _token = $("#form-submit-contact input[name='_token']").val();
              var fullname = $("#form-submit-contact input[name='fullname']").val();
              var email = $("#form-submit-contact input[name='email']").val();
              var phone = $("#form-submit-contact input[name='phone']").val();
              var message = $("#form-submit-contact textarea[name='message']").val();
              $.ajax({
                  url: "<?php echo route('contactFrontend.store') ?>",
                  type: 'POST',
                  data: {
                      _token: _token,
                      fullname: fullname,
                      phone: phone,
                      email: email,
                      message: message
                  },
                  success: function(data) {
                      if (data.status == 200) {
                          $("#form-submit-contact .print-error-msg").css('display', 'none');
                          $("#form-submit-contact .print-success-msg").css('display', 'block');
                          $("#form-submit-contact .print-success-msg span").html("<?php echo $fcSystem['message_2'] ?>");
                          setTimeout(function() {
                              location.reload();
                          }, 3000);
                      } else {
                          $("#form-submit-contact .print-error-msg").css('display', 'block');
                          $("#form-submit-contact .print-success-msg").css('display', 'none');
                          $("#form-submit-contact .print-error-msg span").html(data.error);
                      }
                  }
              });
          });
      });
  </script>
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/contact/frontend/index.blade.php ENDPATH**/ ?>
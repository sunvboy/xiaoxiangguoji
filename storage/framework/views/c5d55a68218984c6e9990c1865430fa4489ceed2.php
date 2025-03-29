  
  <?php $__env->startSection('content'); ?>
  <div id="main" class="sitemap main-contact pb-[50px]">
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
                      <li class="text-white"><?php echo e($page->title); ?></li>
                  </ul>
              </div>
          </div>
      </section>
      <div class="container mx-auto px-3">

          <div class="contact-btottom  shadow-md mt-[20px] md:mt-[50px] border border-gray-100">
              <div class="flex flex-wrap justify-between">
                  <div class="w-full md:w-1/3 ">
                      <div class="bg-color_primary p-[10px] md:p-[25px] h-full">
                          <h2 class="title-primary uppercase text-green text-f20 md:text-f23 text-white font-bold leading-[30px] md:leading-[40px] relative pb-[5px] mb-[20px]">
                              <?php echo e($fcSystem['title_18']); ?>

                          </h2>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold mb-[5px] text-white">
                                  <i class="fa-solid fa-phone text-f14 mr-[5px] text-Orangefc5"></i><?php echo e($fcSystem['title_21']); ?>

                              </h4>
                              <p class="text-white">
                                  <?php echo e($fcSystem['contact_hotline']); ?>

                              </p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold mb-[5px] text-white">
                                  <i class="fa-solid fa-envelope text-f14 mr-[5px] text-Orangefc5"></i>EMAIL
                              </h4>
                              <p class="text-white"><?php echo e($fcSystem['contact_email']); ?></p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold mb-[5px] text-white">
                                  <i class="fa-solid fa-location-dot text-f14 mr-[5px] text-Orangefc5"></i><?php echo e($fcSystem['title_20']); ?>

                              </h4>
                              <p class="text-white">
                                  <?php echo e($fcSystem['contact_address']); ?>

                              </p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold mb-[5px] text-white">
                                  <i class="fa-regular fa-clock text-f14 mr-[5px] text-Orangefc5"></i><?php echo e($fcSystem['title_19']); ?>

                              </h4>
                              <p class="text-white">
                                  <?php echo e($fcSystem['contact_time']); ?>

                              </p>
                          </div>
                          <div class="border-t border-gray-200 pt-5 mt-5">
                              <ul class="flex flex-wrap justify-center">
                                  <li class="mr-[10px]">
                                      <a href="" class="w-[35px] h-[35px] leading-[35px] text-center bg-color_second text-white border border-color_second hover:bg-white hover:text-color_second inline-block rounded-full mx-[2p transition-all"><i class="fa-brands fa-facebook"></i></a>
                                  </li>
                                  <li class="mr-[10px]">
                                      <a href="" class="w-[35px] h-[35px] leading-[35px] text-center bg-color_second text-white border border-color_second hover:bg-white hover:text-color_second inline-block rounded-full mx-[2p transition-all"><i class="fa-brands fa-twitter"></i></a>
                                  </li>
                                  <li class="mr-[10px]">
                                      <a href="" class="w-[35px] h-[35px] leading-[35px] text-center bg-color_second text-white border border-color_second hover:bg-white hover:text-color_second inline-block rounded-full mx-[2p transition-all"><i class="fa-brands fa-instagram"></i></a>
                                  </li>
                                  <li class="mr-[10px]">
                                      <a href="" class="w-[35px] h-[35px] leading-[35px] text-center bg-color_second text-white border border-color_second hover:bg-white hover:text-color_second inline-block rounded-full mx-[2p transition-all"><i class="fa-brands fa-youtube"></i></a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <div class="w-full md:w-2/3  mt-[15px] md:mt-0">
                      <div class="py-[15px] md:py-[30px] px-[15px] md:px-[50px]">
                          <h2 class="title-primary uppercase text-green text-f20 md:text-f23  font-bold leading-[30px] md:leading-[40px] relative pb-[5px] mb-[20px]">
                              <?php echo e($fcSystem['title_22']); ?>

                          </h2>
                          <form action="" id="form-submit-contact">
                              <?php echo csrf_field(); ?>
                              <?php echo $__env->make('homepage.common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                              <div class="flex flex-wrap justify-between -mx-3">
                                  <div class="w-full md:w-1/2 px-3">
                                      <input type="text" name="fullname" class="w-full h-[45px] border border-gray-300 mb-[10px] md:mb-[15px] rounded-sm text-f15 bg-white" placeholder="<?php echo e($fcSystem['title_24']); ?>">
                                  </div>
                                  <div class="w-full md:w-1/2 px-3">
                                      <input type="text" name="email" class="w-full h-[45px] border border-gray-300 mb-[10px] md:mb-[15px] rounded-sm text-f15 bg-white" placeholder="<?php echo e($fcSystem['title_25']); ?>">
                                  </div>
                                  <div class="w-full md:w-1/2 px-3">
                                      <input type="text" name="subject" class="w-full h-[45px] border border-gray-300 mb-[10px] md:mb-[15px] rounded-sm text-f15 bg-white" placeholder="<?php echo e($fcSystem['title_26']); ?>">
                                  </div>
                                  <div class="w-full md:w-1/2 px-3">
                                      <input type="text" name="phone" class="w-full h-[45px] border border-gray-300 mb-[10px] md:mb-[15px] rounded-sm text-f15 bg-white" placeholder="<?php echo e($fcSystem['title_27']); ?>">
                                  </div>
                              </div>
                              <textarea name="message" id="" cols="30" rows="10" class="w-full p-3 h-[120px] border border-gray-300  bg-white rounded-sm text-f15" placeholder="<?php echo e($fcSystem['title_28']); ?>..."></textarea>
                              <button type="submit" class="btn-submit-contact write-review__button write-review__button--submit bg-color_primary border border-color_primary hover:bg-white hover:text-color_primary transition-all text-white h-[45px] mt-[15px] text-f15 rounded-[5px] uppercase w-24">
                                  <span><?php echo e($fcSystem['title_23']); ?> </span>
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
          <div class="map pt-[30px] md:pt-[50px]">
              <?php echo $fcSystem['contact_map']; ?>

          </div>
      </div>
  </div>
  <?php $__env->stopSection(); ?>
  <?php $__env->startPush('javascript'); ?>
  <script type="text/javascript">
      $(document).ready(function() {
          $(".btn-submit-contact").click(function(e) {
              e.preventDefault();
              var _token = $("#form-submit-contact input[name='_token']").val();
              var fullname = $("#form-submit-contact input[name='fullname']").val();
              var subject = $("#form-submit-contact input[name='subject']").val();
              var email = $("#form-submit-contact input[name='email']").val();
              var phone = $("#form-submit-contact input[name='phone']").val();
              var message = $("#form-submit-contact textarea[name='message']").val();
              $.ajax({
                  url: "<?php echo route('contactFrontend.store') ?>",
                  type: 'POST',
                  data: {
                      _token: _token,
                      fullname: fullname,
                      subject: subject,
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
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/contact/frontend/index.blade.php ENDPATH**/ ?>
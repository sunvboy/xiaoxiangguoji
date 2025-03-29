 <!-- Footer Start -->
 <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
     <div class="container py-5">
         <div class="row g-5">
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">{{$fcSystem['homepage_company']}}</h4>
                 <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{$fcSystem['contact_address']}}</p>
                 <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{$fcSystem['contact_hotline']}}</p>
                 @if($fcSystem['contact_email'])
                 <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{$fcSystem['contact_email']}}
                     @endif
                 </p>
                 <div class="d-flex pt-3">

                     <a class="btn btn-square btn-light rounded-circle me-2" href="{{$fcSystem['social_twitter']}}" target="_blank"><i
                             class="fab fa-twitter"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="{{$fcSystem['social_facebook']}}" target="_blank"><i
                             class="fab fa-facebook-f"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="{{$fcSystem['social_youtube']}}" target="_blank"><i
                             class="fab fa-youtube"></i></a>
                     <a class="btn btn-square btn-light rounded-circle me-2" href="{{$fcSystem['social_linkedin']}}" target="_blank"><i
                             class="fab fa-linkedin-in"></i></a>
                 </div>
             </div>
             <?php $menu_footer = getMenus('menu-footer'); ?>
             @if(!empty($menu_footer))
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">快速链接</h4>
                 @if(count($menu_footer->menu_items) > 0)
                 @foreach($menu_footer->menu_items as $item)
                 <a class="btn btn-link" href="{{!empty($item->children->count() > 0)?'javascript:void(0)':url($item->slug)}}"> {{$item->title}}</a>
                 @endforeach
                 @endif
             </div>
             @endif
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-4">营业时间</h4>
                 {!!$fcSystem['contact_time']!!}
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

 <script src="{{asset('frontend/js/wow.min.js')}}"></script>
 <script src="{{asset('frontend/js/easing.min.js')}}"></script>
 <script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
 <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
 <script src="{{asset('frontend/js/lightbox.min.js')}}"></script>
 <!-- Template Javascript -->
 <script src="{{asset('frontend/js/main.js')}}"></script>
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
 </script>
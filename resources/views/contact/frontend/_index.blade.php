  @extends('homepage.layout.home')
  @section('content')
  {!!htmlBreadcrumb($page->title)!!}

  <main class="pt-3">
      <div class="container px-4">
          <h1 class="text-2xl my-8 font-bold">{{$page->title}}</h1>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
              <div class="wow fadeInUp delay01">
                  <img src="{{asset('frontend/images/contact_icon_1.svg')}}" alt="{{$page->title}}" class="lazy mx-auto w-10 mb-4">
                  <div class="font-medium text-f15 text-center">
                      {{$fcSystem['contact_address']}}
                  </div>
              </div>
              <div class="wow fadeInUp delay02">
                  <img src="{{asset('frontend/images/contact_icon_2.svg')}}" alt="{{$page->title}}" class="lazy mx-auto w-10 mb-4">
                  <div class="font-medium text-f15 text-center" style="word-break: break-all;">
                      <a href="tel:{{$fcSystem['contact_hotline']}}">{{$fcSystem['contact_hotline']}}</a>
                  </div>
              </div>
              <div class="wow fadeInUp delay03">
                  <img src="{{asset('frontend/images/contact_icon_3.svg')}}" alt="{{$page->title}}" class="lazy mx-auto w-10 mb-4">
                  <div class="font-medium text-f15 text-center" style="word-break: break-all;">
                      <a href="mailto:{{$fcSystem['contact_email']}}">{{$fcSystem['contact_email']}}</a>
                  </div>
              </div>
              <div class="wow fadeInUp delay04">
                  <img src="{{asset('frontend/images/contact_icon_4.svg')}}" alt="{{$page->title}}" class="lazy mx-auto w-10 mb-4">
                  <div class="font-medium text-f15 text-center" style="word-break: break-all;">
                      <?php echo $fcSystem['contact_time'] ?>
                  </div>
              </div>

          </div>
          <div class="my-8">
              <div class="grid md:grid-cols-2 gap-8">
                  <div class="bg-[#f4f6f8] rounded-2xl p-6 wow fadeInLeft">
                      <h3 class="font-bold text-lg">
                          {{trans('index.Questions')}}
                      </h3>
                      <p class="text-f14 mb-[10px]">
                          {{trans('index.information')}}
                      </p>
                      <form id="form-submit-contact">
                          @csrf
                          @include('homepage.common.alert')
                          <div class="mt-2">
                              <label class="font-bold text-f14">{{trans('index.Fullname')}}<span class="text-f13 text-red-600">*</span></label>
                              <input type="text" class="  border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="fullname" aria-describedby="emailHelp" placeholder="{{trans('index.Fullname')}}">
                          </div>
                          <div class="mt-2">
                              <label class="font-bold text-f14">Email<span class="text-f13 text-red-600">*</span></label>
                              <input type="email" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="email" placeholder="Email">
                          </div>
                          <div class="mt-2">

                              <label class="font-bold text-f14">{{trans('index.Phone')}}<span class="text-f13 text-red-600">*</span></label>
                              <input type="text" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="phone" placeholder="{{trans('index.Phone')}}">
                          </div>
                          <div class="mt-2">
                              <label class="font-bold text-f14">{{trans('index.Address')}}</label>
                              <input type="text" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="address" placeholder="{{trans('index.Address')}}">
                          </div>
                          <div class="mt-2">
                              <label class="font-bold text-f14">{{trans('index.Message')}}<span class="text-f13 text-red-600">*</span></label>
                              <textarea rows="6" class="border w-full px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="message" placeholder="{{trans('index.Message')}}"></textarea>
                          </div>
                          <button type="submit" class="btn-submit-contact py-4 px-1 md:px-8 rounded-lg block bg-global  text-white transition-all leading-none text-f15 font-bold"> {{trans('index.SendContactInformation')}}</button>
                      </form>
                  </div>
                  <div class="wow fadeInRight">
                      <?php echo $fcSystem['contact_map'] ?>
                  </div>
              </div>
          </div>
      </div>
  </main>
  <style>
      iframe {
          height: 100%
      }
  </style>
  @endsection
  @push('javascript')
  <script type="text/javascript">
      $(document).ready(function() {
          $(".btn-submit-contact").click(function(e) {
              e.preventDefault();
              var _token = $("#form-submit-contact input[name='_token']").val();
              var fullname = $("#form-submit-contact input[name='fullname']").val();
              var phone = $("#form-submit-contact input[name='phone']").val();
              var email = $("#form-submit-contact input[name='email']").val();
              var address = $("#form-submit-contact input[name='address']").val();
              var message = $("#form-submit-contact textarea[name='message']").val();
              $.ajax({
                  url: "<?php echo route('contactFrontend.store') ?>",
                  type: 'POST',
                  data: {
                      _token: _token,
                      fullname: fullname,
                      phone: phone,
                      email: email,
                      address: address,
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
  @endpush
  @extends('homepage.layout.home')
  @section('content')
  <section class="banner-child relative">
      <div class="img">
          <a href="javascript:void(0)"><img src="{{!empty($page->image) ? (!empty(File::exists(base_path($page->image)))?asset($page->image):asset($fcSystem['banner_0'])) : asset($fcSystem['banner_0'])}}" alt="{{$page->title}}" class="w-full" /></a>
      </div>
      <div class="text-center overlay-banner absolute w-full left-0 top-1/2" style="transform: translateY(-50%)">
          <div class="container mx-auto px-3">
              <div class="breadcrumb">
                  <ul class="flex flex-wrap justify-center">
                      <li class="pr-[5px] text-white"><a href="{{!empty(config('app.locale') == 'vi') ? url('/') : url('/en')}}">{{trans('index.home')}}</a> /</li>
                      <li class="text-white">{{$page->title}}</li>
                  </ul>
              </div>
              <h1 class="text-f25 md:text-f35 font-bold text-white relative z-10 my-[10px] md:my-[25px]">
                  {{$page->title}}
              </h1>
              <div class="desc text-f16 text-white">{!!$page->description!!}</div>
          </div>
      </div>
  </section>

  <div id="main" class="sitemap main-contact py-[20px] md:py-[50px]">

      <div class="container mx-auto px-3">
          <div class="contact-btottom  bg-white p-[10px] ">

              <div class="flex flex-wrap justify-between -mx-3">
                  <div class="w-full md:w-1/2 px-3 mt-4 md:mt-0">
                      <h3 class="font-bold text-f20 mb-[10px] md:mb-[20px]">
                          {{trans('index.addressCompany')}}
                      </h3>
                      <div class="">
                          <div class="mb-[20px]">
                              <h4 class="text-f15">
                                  <span class="w-[30px] h-[30px] text-center inline-block leading-[30px] bg-gray-300 rounded-full mr-[10px]"><i class="fa-solid fa-location-dot"></i></span>
                                  {{$fcSystem['contact_address']}}
                              </h4>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15">
                                  <span class="w-[30px] h-[30px] text-center inline-block leading-[30px] bg-gray-300 rounded-full mr-[10px]"><i class="fa-solid fa-phone-volume"></i></span>
                                  {{$fcSystem['contact_hotline']}}
                              </h4>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15">
                                  <span class="w-[30px] h-[30px] text-center inline-block leading-[30px] bg-gray-300 rounded-full mr-[10px]"><i class="fa-solid fa-envelope"></i></span>
                                  {{$fcSystem['contact_email']}}
                              </h4>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15">
                                  <span class="w-[30px] h-[30px] text-center inline-block leading-[30px] bg-gray-300 rounded-full mr-[10px]"><i class="fa-regular fa-clock"></i></span>
                                  {{$fcSystem['contact_time']}}
                              </h4>
                          </div>
                      </div>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                      <div class="content-bt">
                          <h3 class="font-bold text-f20 mb-[10px] md:mb-[20px]">
                              {{trans('index.sendQuestion')}}
                          </h3>
                          <form id="form-submit-contact">
                              @csrf
                              @include('homepage.common.alert')
                              <div class="">
                                  <div class="mb-[10px]">
                                      <input name="fullname" type="text" class="outline-none focus:outline-none hover:outline-none w-full h-[40px] border-b border-gray-200 rounded-sm text-f15" placeholder="{{trans('index.Fullname')}}*">
                                  </div>
                                  <div class="flex flex-wrap justify-between mx-[-10px]">
                                      <div class="w-full md:w-1/2 px-[10px] mb-4 md:mb-0">
                                          <input name="email" type="text" class="outline-none focus:outline-none hover:outline-none w-full h-[40px] border-b border-gray-200 rounded-sm text-f15" placeholder="Email">
                                      </div>
                                      <div class="w-full md:w-1/2 px-[10px]">
                                          <input name="phone" type="text" class="outline-none focus:outline-none hover:outline-none w-full h-[40px] border-b border-gray-200 rounded-sm text-f15" placeholder="{{trans('index.Phone')}}*">
                                      </div>
                                  </div>
                                  <div class="mt-[10px]">
                                      <textarea name="message" id="" cols="30" rows="10" class="outline-none focus:outline-none hover:outline-none w-full h-[100px] border-b border-gray-200 rounded-sm text-f15" placeholder="{{trans('index.Message')}}"></textarea>
                                      <button type="submit" class="btn-submit-contact py-4 px-1 md:px-8 rounded-lg block bg-global  text-white transition-all leading-none text-f15 font-bold"> {{trans('index.SendContactInformation')}}</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="map mt-[20px] md:mt-[40px]">
                  <?php echo $fcSystem['contact_map'] ?>
              </div>

          </div>
      </div>
  </div>
  @endsection
  @push('javascript')
  <script type="text/javascript">
      $(document).ready(function() {
          $(".btn-submit-contact").click(function(e) {
              e.preventDefault();
              var _token = $("#form-submit-contact input[name='_token']").val();
              var fullname = $("#form-submit-contact input[name='fullname']").val();
              var phone = $("#form-submit-contact input[name='phone']").val();
              var email = $("#form-submit-contact input[name='email']").val();
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
  @endpush
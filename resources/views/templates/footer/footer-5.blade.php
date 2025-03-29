  <?php
    $menu_footer = getMenus('menu-footer');
    ?>
  <footer class="pt-7 md:pt-12  wow fadeInUp">
      <div class="container mx-auto pl-3 pr-3">
          <div class="row -mx-3 flex flex-wrap justify-between">
              <div class="lg:w-2/5 md:w-2/5 sm:w-full w-full px-3">
                  <div class="item">
                      <h3 class="title-footer text-f16 font-bold transform text-white mb-3">
                          Chúng tôi là ai ?
                      </h3>
                      <div class="nav-item text-f14 text-white">
                          <p class="mb-[5px]">
                              <?php echo $fcSystem['homepage_aboutus'] ?>
                          </p>
                          <p class="mb-[5px]">
                              <strong><i class="fa-solid fa-location-dot mr-[5px]"></i>Địa chỉ: </strong>{{$fcSystem['contact_address']}}
                          </p>
                          <p class="mb-[5px]">
                              <strong><i class="fa-solid fa-phone mr-[5px]"></i>Điện thoại:</strong>{{$fcSystem['contact_hotline']}}

                          </p>
                          <p class="mb-[5px]">
                              <strong><i class="fa-solid fa-envelope mr-[5px]"></i>Email:</strong>{{$fcSystem['contact_email']}}
                          </p>
                      </div>
                      <div class="social-footer mt-[15px]">
                          <h3 class="title-footer text-f16 font-bold  text-white mb-3">
                              Mạng xã hội
                          </h3>
                          <ul class="flex flex-wrap">
                              <li><a href="{{$fcSystem['social_facebook']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-facebook-f"></i></a></li>
                              <li><a href="{{$fcSystem['social_instagram']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-instagram"></i></a></li>
                              <li><a href="{{$fcSystem['social_google_plus']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-google"></i></a></li>
                              <li><a href="{{$fcSystem['social_youtube']}}" target="_blank" class="inline-block w-[30px] h-[30px] text-center leading-[30px] mr-[5px] border rounded-full hover:text-red-600"><i class="fa-brands fa-youtube"></i></a></li>
                          </ul>
                      </div>

                  </div>
              </div>
              <?php echo getHtmlMenusFooter($menu_footer, array(
                    'class' => 'lg:w-1/5 md:w-1/5 sm:w-1/2 w-1/2 px-3',
                    'class_title' => 'title-footer text-f16 font-bold transform text-white mb-3',
                    'class_ul' => 'list-disc pl-[20px]',
                    'class_li' => 'text-white mb-1',
                    'class_a' => 'text-f15 text-white hover:text-red-600',
                )); ?>

          </div>
          <div class="copy-right border-t-[1px] p-2 mt-7 border-gray-300">
              <p class="text-white text-center text-f15">
                  {{$fcSystem['homepage_copyright']}}
              </p>
          </div>
      </div>
      <style>
          footer {
              background: #24272e;
          }

          footer p {
              color: #8b8e96;
          }

          footer ul li a {
              color: #8b8e96;
          }

          footer ul li {
              color: #8b8e96;
          }
      </style>
  </footer>
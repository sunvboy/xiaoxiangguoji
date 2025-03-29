  <?php /*
  Thêm chiết khấu
  */ ?>
  <div class="flex justify-between p-4">
      <div class="font-bold flex-1 text-right">
          <div class="flex text-danger font-bold justify-end items-center space-x-1 relative">
              <div class="dropdown inline-block" data-tw-placement="bottom">
                  <a href="javascript:void(0)" class="dropdown-toggle flex items-center space-x-1" aria-expanded="false" data-tw-toggle="dropdown">
                      <span>Chiết khấu</span>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                      </svg>
                  </a>
                  <div class="dropdown-menu border bg-white p-3 space-y-2">
                      <div class="flex space-x-2" style="width: 250px;">
                          <a href="javascript:void(0)" class="btn btn-default w-1/2 js_typeDiscountTP active" data-type="money">Giá trị</a>
                          <a href="javascript:void(0)" class="btn btn-default w-1/2 js_typeDiscountTP" data-type="percent">%</a>
                      </div>
                      <div class="flex shadow-sm justify-between" style="width: 250px;">
                          <input type="number" class="form-control w-2/3 int js_valueDiscountTP" data-type="money">
                          <a href="javascript:void(0)" class="btn btn-primary w-1/3 btn-sm js_addDiscount">Áp dụng</a>
                      </div>
                  </div>
              </div>

          </div>
      </div>
      <div class="js_priceDiscount text-right w-32">0</div>
  </div>
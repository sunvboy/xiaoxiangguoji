  @if(!empty($productTwos) && count($productTwos) > 0)
  <div class="flex justify-between p-3 hideClickShowOne" style="background-color: #fafafa;<?php if (!empty($check) &&  $check == 'hide') { ?>display: none;<?php } ?>">
      <div class="w-1/2">
          <p class="text-base text-black font-bold">Thiết Lập Hàng Loạt</p>
          <p style="color:#999">đã chọn <span class="text-black font-bold countProductTwo">0</span> sản phẩm</p>
      </div>
      <div class="w-1/2 flex justify-end items-center space-x-2">
          <a href="javascript:void(0)" class="btn btn-secondary flex-auto hover:bg-primary ajax-delete-all-product-two">Xóa</a>
      </div>
  </div>
  <div class="space-y-2 mt-5">
      <div class="grid grid-cols-12 items-center font-bold gap-2 p-2" style="background-color: #f6f6f6;">
          <div class="hideClickShowOne" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?>">
              <input type="checkbox" id="checkbox-all-two">
          </div>
          <div class="col-span-5">Sản Phẩm</div>
          <div class="col-span-2">Giá Bán Hiện Tại</div>
          <div class="col-span-2">Giá Mua kèm</div>
          <div class="col-span-1 text-center">Kho hàng</div>
          <div class="col-span-1 hideClickShowOne" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?>">Hành động</div>
      </div>
      <div class="space-y-2">
          @foreach($productTwos as $v)
          <div class="space-y-2 itemProductTwo">
              <?php $getPrice = getPrice(array('price' => $v->price, 'price_sale' => $v->price_sale, 'price_contact' => $v->price_contact)); ?>
              <?php $stock = checkStockItemProduct($v); ?>
              <div class="grid grid-cols-12 items-center gap-2 p-2" style="background-color: #f6f6f6;">
                  <div class="hideClickShowOne" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?>">
                      <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item-two">
                  </div>
                  <div class="col-span-5 whitespace-nowrap flex space-x-2 items-center">
                      <div class="w-10 h-10 image-fit zoom-in">
                          <img alt="" class="tooltip rounded-full" src="{{asset($v->image)}}">
                      </div>
                      <div>
                          <p class="font-bold text-base"><?php echo $v->title; ?></p>
                      </div>
                  </div>
                  <div class="col-span-2"></div>
                  <div class="col-span-2"></div>
                  <div></div>
                  <div class="text-center hideClickShowOne" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?>">
                      <a href="javascript:void(0)" class="handleRemoveItemProductTwo" data-id="<?php echo $v->id; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-5 h-5 mx-auto text-danger">
                              <polyline points="3 6 5 6 21 6"></polyline>
                              <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                              <line x1="10" y1="11" x2="10" y2="17"></line>
                              <line x1="14" y1="11" x2="14" y2="17"></line>
                          </svg>
                      </a>
                  </div>
              </div>
              @if(count($v->product_versions) > 0)
              @foreach($v->product_versions as $val)
              <?php
                $classVersion = '';
                $_stock = 0;
                $getPriceV = getPrice(array('price' => $val->price_version, 'price_sale' => $val->price_sale_version));
                if ($val['_stock_status'] == 1 && $val['_outstock_status']  == 0 && $val['_stock'] == 0) {
                    $classVersion = 'disabled';
                } elseif ($val['_outstock_status']  == 1 && $val['_stock'] == 0) {
                    $_stock = 'Sản phẩm có sẵn';
                } else {
                    $_stock = $val['_stock'];
                }
                $rowid = md5($v->id . $val->title_version);
                ?>
              <div class="grid grid-cols-12 items-center gap-2 {{$classVersion}}">
                  <div class="">
                  </div>
                  <div class="col-span-5 whitespace-nowrap flex space-x-2">
                      <?php echo collect(json_decode($val->title_version, TRUE))->join(' / '); ?>
                  </div>
                  <div class="col-span-2"><?php echo $getPriceV['price_final'] ?> <del><?php echo $getPriceV['price_old'] ?></del></div>
                  <div class="col-span-2"><input type="text" class="form-control int inputPrice" value="{{!empty($priceDeals)?(!empty($priceDeals[$rowid]) ? $priceDeals[$rowid]['price'] : 0):0}}" rowid="{{$rowid}}"></div>
                  <div class="text-center col-span-2">
                      {{ $_stock}}
                  </div>
                  <div>

                  </div>
              </div>
              @endforeach
              @else
              <?php
                $classVersion = '';
                $rowid = md5($v->id);
                if ($v['inventory'] == 1 && $v['inventoryPolicy'] == 0 && $v['inventoryQuantity'] == 0) {
                    $classVersion = 'disabled';
                }
                ?>
              <div class="grid grid-cols-12 items-center gap-2 {{$classVersion}}">
                  <div class="">
                  </div>
                  <div class="col-span-5 whitespace-nowrap flex space-x-2">
                      --
                  </div>
                  <div class="col-span-2"><?php echo $getPrice['price_final'] ?> <del><?php echo $getPrice['price_old'] ?></del></div>
                  <div class="col-span-2"><input type="text" class="form-control int inputPrice" value="{{!empty($priceDeals)?(!empty($priceDeals[$rowid]) ? $priceDeals[$rowid]['price'] : 0):0}}" rowid="{{$rowid}}"></div>
                  <div class="text-center col-span-2">
                      @if($stock['stock'] == 0 && empty($stock['disabled']))
                      <span>Sản phẩm có sẵn</span>
                      @else
                      {{$stock['stock']}}
                      @endif
                  </div>
                  <div></div>
              </div>
              @endif
          </div>
          @endforeach
      </div>
  </div>

  @endif
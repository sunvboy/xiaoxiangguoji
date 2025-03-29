  @if(!empty($productOnes) && count($productOnes) > 0)
  <div class="flex justify-between p-3 hideClickShowTwo" style="background-color: #fafafa;<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?> <?php if (!empty($action) && $action == 'update') { ?>display: none;<?php } ?>">
      <div class="w-1/2">
          <p class="text-base text-black font-bold">Thiết Lập Hàng Loạt</p>
          <p style="color:#999">đã chọn <span class="text-black font-bold countProductOne">0</span> sản phẩm</p>
      </div>
      <div class="w-1/2 flex justify-end items-center space-x-2">
          <a href="javascript:void(0)" class="btn btn-secondary flex-auto hover:bg-primary ajax-delete-all-product-one">Xóa</a>
      </div>
  </div>
  <table class="table tableProductOne">
      <thead>
          <tr>
              <th class="hideClickShowTwo" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?> <?php if (!empty($action) && $action == 'update') { ?>display: none;<?php } ?>">
                  <input type="checkbox" id="checkbox-all-one">
              </th>
              <th>Sản Phẩm</th>
              <th>Giá</th>
              <th>Kho hàng</th>
              <th class="hideClickShowTwo" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?> <?php if (!empty($action) && $action == 'update') { ?>display: none;<?php } ?>">Hành động</th>
          </tr>
      </thead>
      <tbody>
          @foreach($productOnes as $v)
          <?php $getPrice = getPrice(array('price' => $v->price, 'price_sale' => $v->price_sale, 'price_contact' => $v->price_contact)); ?>
          <?php $stock = checkStockItemProduct($v); ?>
          <tr class="{{$stock['disabled']}}">
              <td class="hideClickShowTwo" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?> <?php if (!empty($action) && $action == 'update') { ?>display: none;<?php } ?>">
                  <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item-one {{$stock['disabled']}}">
              </td>
              <td class="whitespace-nowrap flex space-x-2">
                  <div class="w-10 h-10 image-fit zoom-in">
                      <img alt="" class="tooltip rounded-full" src="{{asset($v->image)}}">
                  </div>
                  <div>
                      <p class="font-bold text-base"><?php echo $v->title; ?></p>
                      <p>Mã sản phẩm: <?php echo $v->code; ?></p>
                  </div>
              </td>
              <td><?php echo $getPrice['price_final'] ?> <del><?php echo $getPrice['price_old'] ?></del></td>
              <td>
                  @if($stock['stock'] == 0 && empty($stock['disabled']))
                  <span>Sản phẩm có sẵn</span>
                  @else
                  {{$stock['stock']}}
                  @endif
              </td>
              <td class="text-center hideClickShowTwo" style="<?php if (!empty($check) && $check == 'hide') { ?>display: none;<?php } ?> <?php if (!empty($action) && $action == 'update') { ?>display: none;<?php } ?>">
                  <a href="javascript:void(0)" class="handleRemoveItemProductOne" data-id="<?php echo $v->id; ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-5 h-5 mx-auto text-danger">
                          <polyline points="3 6 5 6 21 6"></polyline>
                          <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                          <line x1="10" y1="11" x2="10" y2="17"></line>
                          <line x1="14" y1="11" x2="14" y2="17"></line>
                      </svg>
                  </a>

              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
  <div class="mt-5 pb-5 flex justify-center items-center paginationProductOne">
      {{$productOnes->links()}}
  </div>
  @endif
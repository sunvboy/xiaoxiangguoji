  <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black mt-5">
      <thead class="text-xs ">
          <tr class="bg-primary text-white">
              <th scope="col" class="p-2" style="width: 10px;">
                  <i class="fa-solid fa-gear text-lg"></i>
              </th>
              <th scope="col" class="p-2">
                  Sản phẩm
              </th>
              <th scope="col" class="p-2">
                  Phân loại
              </th>
              <th scope="col" class="p-2 tdDeal">
                  Duy trì
              </th>
              <th scope="col" class="p-2">
                  Giá
              </th>
              <th scope="col" class="p-2">
                  Số lượng
              </th>
              <th scope="col" class="p-2">
                  Thuế
              </th>
              <th scope="col" class="p-2">
                  Thành tiền (VNĐ)
              </th>
          </tr>
      </thead>
      <tbody id="listProduct">
          <?php

            if ($action == 'create') {
                $deal_invoice_relationships = (!empty($detail) && count($detail->deal_relationships) > 0) ? $detail->deal_relationships : [];
            } else {
                $deal_invoice_relationships = (!empty($detail) && count($detail->deal_invoice_relationships) > 0) ? $detail->deal_invoice_relationships : [];
            }
            $price_1 = $price_2 = $price_3 = 0;
            ?>
          @if(!empty($deal_invoice_relationships))
          @foreach($deal_invoice_relationships as $item)
          <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd">
              <td class="p-2">
                  <a href="javascript:void(0)" class="handleRemoveItemProductInvoices"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                      </svg>
                  </a>
              </td>
              <td class="p-2">
                  <span>{{$item->title}}</span>
                  <input name="invoices_title[]" class="hidden" value="{{$item->title}}">
              </td>
              <td>
                  <span>{{$item->phan_loai}}</span>
                  <input value="{{$item->phan_loai}}" class="hidden" name="invoices_phan_loai[]">
              </td>
              <td class="p-2">
                  <span>{{$item->duy_tri}}</span>
                  <input value="{{$item->duy_tri}}" class="hidden" name="invoices_duy_tri[]">
              </td>
              <td class="p-2">
                  <input name="invoices_price[]" class="form-control w-full" value="{{$item->price}}">
              </td>
              <td class="p-2">
                  <span>{{$item->quantity}}</span>
                  <input name="invoices_quantity[]" class="hidden" value="{{$item->quantity}}">
              </td>
              <td class="p-2 flex space-x-1 items-center">
                  <select class="form-control" name="invoices_tax[]">
                      @foreach(config('tamphat')['tax'] as $ktax=>$tax)
                      <option value="{{$ktax}}" @if($item->tax == $ktax) selected @endif>{{$tax}}</option>
                      @endforeach
                  </select>
                  <input name="invoices_tax_price[]" class="border-0 flex-1 bg-transparent w-[50px] outline-none hover:outline-none focus:outline-none" value="{{$item->tax_price}}">
              </td>
              <td class="p-2">
                  <span class="invoices_price_total">{{number_format(($item->price*$item->quantity)+$item->tax_price,'0',',','.')}}</span>
                  <input name="invoices_price_total[]" class="hidden" value="{{($item->price*$item->quantity)+$item->tax_price}}">
              </td>
          </tr>
          <?php
            $price_1 += $item->price * $item->quantity;
            $price_2 += $item->tax_price;
            $price_3 += ($item->price * $item->quantity) + $item->tax_price;
            ?>
          @if($action == 'update')
          <input type="hidden" name="deal_invoice_relationships_id[]" value="{{!empty($formInvoices->deal_invoice_relationships)?$item->id:''}}">
          @endif
          @endforeach
          @endif
      </tbody>
      <tfoot>
          <tr>
              <td class="p-2 text-right" colspan="5">Tổng số tiền: </td>
              <td class="p-2 text-right invoices_price_1" colspan="5">{{number_format($price_1,'0',',','.')}} đ</td>
          <tr>
              <td class="p-2 text-right" colspan="5">Tổng thuế: </td>
              <td class="p-2 text-right invoices_price_2" colspan="5">{{number_format($price_2,'0',',','.')}} đ</td>
          </tr>
          <tr>
              <td class="p-2 text-right font-bold text-red-600" colspan="5">Tổng số tiền: </td>
              <td class="p-2 text-right font-bold text-red-600 invoices_price_3" colspan="5">{{number_format($price_3,'0',',','.')}} đ</td>
          </tr>
      </tfoot>
  </table>

  <input type="hidden" name="invoices_price_1" value="{{$price_1}}">
  <input type="hidden" name="invoices_price_2" value="{{$price_2}}">
  <input type="hidden" name="invoices_price_3" value="{{$price_3}}">
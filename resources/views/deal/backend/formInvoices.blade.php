<div class="relative p-4 w-full max-w-screen-lg max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                @if($action == 'create')
                Tạo mới hóa đơn
                @else
                Cập nhập hóa đơn
                @endif
            </h3>
            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
            <form class="space-y-4" action="#" id="formSubmitDealInvoices" autocomplete="off">
                <ul class="p-0 m-0 space-y-1">
                    <li class="flex flex-col text-[15px] space-y-[2px]">
                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Danh mục*</span></span>
                        <?php echo Form::select('catalogue_idI', $category_products, !empty($formInvoices) ? $formInvoices->catalogue_id : '', ['class' => 'tom-select tom-select-field-categoryI w-full', 'placeholder' => "Chọn danh mục", 'required']); ?>
                    </li>
                    <li class="flex flex-col text-[15px] space-y-[2px]">
                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tiêu đề hóa đơn*</span></span>
                        <?php echo Form::text('idI', !empty($formInvoices) ? $formInvoices->id : '', ['class' => 'hidden', 'placeholder' => '']); ?>
                        <?php echo Form::text('actionI', $action, ['class' => 'hidden', 'placeholder' => '']); ?>
                        <?php echo Form::text('titleI', !empty($formInvoices) ? $formInvoices->title : '', ['class' => 'form-control', 'placeholder' => '', 'required']); ?>
                    </li>
                    <?php /*<li class="flex flex-col text-[15px] space-y-[2px]">
                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Số tiền*</span></span>
                        <?php echo Form::text('priceI', !empty($formInvoices) ? number_format($formInvoices->price, '0', ',', '.') : '', ['class' => 'form-control int', 'placeholder' => '', 'required']); ?>
                    </li>
                    <li class="flex flex-col text-[15px] space-y-[2px]">
                        <span class="bg-white font-semibold flex-1"><span>Thuế</span></span>
                        <div class="flex items-center space-x-1">
                            <?php echo Form::select('status_tax', config('tamphat')['tax'], !empty($formInvoices) ? $formInvoices->status_tax : '', ['class' => 'form-control flex-1', 'placeholder' => "Chọn thuế"]); ?>
                            <span class="flex-1 htmlPriceTax">{{!empty($formInvoices) ? (!empty($formInvoices->tax) ? number_format($formInvoices->tax,'0',',','.').' VND' : '') : ''}}</span>
                        </div>
                    </li>
                    <li class="flex flex-col text-[15px] space-y-[2px]">
                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Số tiền thanh toán*</span></span>
                        <?php echo Form::text('priceTotal', !empty($formInvoices) ? number_format($formInvoices->price + $formInvoices->tax, '0', ',', '.') : '', ['class' => 'form-control int', 'placeholder' => '', 'disabled']); ?>
                    </li>*/ ?>

                    <li class="flex text-[15px] gap-4">
                        <div class="w-1/3">
                            <span class="bg-white font-semibold flex-1"><span class="text-red-600">Người chịu trách nhiệm*</span></span>
                            <?php echo Form::select('user_idI', $users, !empty($formInvoices) ? $formInvoices->user_id : '', ['class' => 'tom-select tom-select-field-support-invoices w-full', 'placeholder' => "Chịu trách nghiệm", 'required']); ?>
                        </div>
                        <div class="w-1/3">
                            <span class="bg-white font-semibold flex-1">Trạng thái</span>
                            <?php echo Form::select('statusI', ['0' => 'Chưa thanh toán', '1' => 'Đã thanh toán'], !empty($formInvoices) ? $formInvoices->status : 1, ['class' => 'form-control']); ?>
                        </div>
                        <div class="w-1/3">
                            <span class="bg-white font-semibold flex-1">Ngày thanh toán</span>
                            <?php echo Form::text('date_endI',  !empty($formInvoices) ? (!empty($formInvoices->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $formInvoices->date_end)->format('d/m/Y') : '') : $source_date_start, ['class' => 'form-control', 'placeholder' => '']); ?>
                        </div>
                    </li>
                    <li class="flex text-[15px] gap-4">
                        <div class="w-1/2 hidden">
                            <span class="bg-white font-semibold flex-1 ">Ngày kết thúc</span>
                            <?php echo Form::text('source_date_endI',  !empty($formInvoices) ? (!empty($formInvoices->source_date_end) ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $formInvoices->source_date_end)->format('d/m/Y') : '') : $source_date_end, ['class' => 'form-control', 'placeholder' => '']); ?>
                        </div>
                    </li>
                    <li class="flex text-[15px] gap-4">
                        <div class="w-1/2">
                            <span class="bg-white font-semibold flex-1">Nội dung thanh toán</span>
                            <?php echo Form::textarea('commentI', !empty($formInvoices) ? $formInvoices->comment : '', ['class' => 'form-control', 'placeholder' => '', 'rows' => '5']); ?>
                        </div>
                        <div class="w-1/2">
                            <span class="bg-white font-semibold flex-1">Ghi chú</span>
                            <?php echo Form::textarea('noteI', !empty($formInvoices) ? $formInvoices->note : '', ['class' => 'form-control', 'rows' => '5']); ?>
                        </div>
                    </li>



                </ul>
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
                        $deal_invoice_relationships = (!empty($formInvoices) && count($formInvoices->deal_invoice_relationships) > 0) ? $formInvoices->deal_invoice_relationships : (!empty($detail) ? $detail->deal_relationships : []);
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
                                <input name="invoices_quantity[]" class="form-control" value="{{$item->quantity}}">
                            </td>
                            <td class="p-2 flex space-x-1 items-center">
                                <select class="form-control" name="invoices_tax[]">
                                    @foreach(config('tamphat')['tax'] as $ktax=>$tax)
                                    <option value="{{$ktax}}" @if($item->tax == $ktax) selected @endif>{{$tax}}</option>
                                    @endforeach
                                </select>
                                <input name="invoices_tax_price[]" class="border-0 flex-1 bg-transparent w-[50px] outline-none hover:outline-none focus:outline-none" value="{{number_format($item->tax_price,'0',',','.')}}">
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
                @if($action == 'create')

                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Thêm mới</button>
                @else
                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cập nhập</button>
                @endif
            </form>
        </div>
    </div>
</div>
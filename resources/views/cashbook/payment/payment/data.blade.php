   <div class=" overflow-auto lg:overflow-visible">
       <table class="table table-report -mt-2">
           <thead>
               <tr>
                   <th style="width:40px;text-align: center;">
                       <input type="checkbox" id="checkbox-all">
                   </th>
                   <th class="whitespace-nowrap">STT</th>
                   <th class="whitespace-nowrap">Mã phiếu</th>
                   <th class="whitespace-nowrap">Loại phiếu</th>
                   <th class="whitespace-nowrap">Trạng thái</th>
                   <th class="whitespace-nowrap">Số tiền chi</th>
                   <th class="whitespace-nowrap">Nhóm người nhận</th>
                   <th class="whitespace-nowrap">Chứng từ gốc</th>
                   <th class="whitespace-nowrap text-left">Tên người nhận</th>
                   <th class="whitespace-nowrap text-left">Ngày tạo</th>
                   <th class="whitespace-nowrap text-center">#</th>
               </tr>
           </thead>
           <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
               @foreach($data as $v)
               <?php
                $checked = 0;
                if ($v->group_id == 11) {
                    $checked = 1;
                }
                if ($v->module == 'product_purchases') {
                    $checked = 1;
                }
                if ($v->status == 'cancelled') {
                    $checked = 1;
                }
                ?>
               <tr class="odd " id="post-<?php echo $v->id; ?>">
                   <td>
                       <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item" data-check="{{$checked}}">
                   </td>
                   <td>
                       {{$data->firstItem()+$loop->index}}
                   </td>
                   <td>
                       <a class="text-primary font-bold" href="{{ route('payment_vouchers.edit',['id'=>$v->id]) }}">
                           {{$v->code}}
                       </a>
                   </td>
                   <td>
                       <span class="text-primary">{{!empty($v->payment_groups) ? $v->payment_groups->title:''}}</span>
                   </td>
                   <td>
                       <span class="{{$status['class'][$v->status]}}">
                           {{$status['method'][$v->status]}}
                       </span>
                   </td>
                   <td>
                       {{number_format($v->price,'0',',','.')}}đ
                   </td>
                   <td class="w-40">
                       {{!empty($table[$v->module])?$table[$v->module]:''}}
                   </td>
                   <td>
                       @if($v->module == 'product_purchases')
                       <a href="" class="font-bold text-danger">{{!empty($v->product_purchases) ? $v->product_purchases->code:''}}</a>
                       @endif
                   </td>

                   <td>
                       @if($v->module == 'users')
                       {{!empty($v->users) ? $v->users->name:''}}
                       @elseif($v->module == 'customers')
                       {{!empty($v->customers) ? $v->customers->name:''}}
                       @elseif($v->module == 'product_purchases')
                       {{!empty($v->product_purchases->suppliers) ? $v->product_purchases->suppliers->title:''}}
                       @endif
                   </td>
                   <td>
                       {{$v->created_at}}
                   </td>
                   <td class="table-report__action w-56 ">
                       <div class="flex justify-center items-center">
                           @can('payment_vouchers_edit')
                           <a class="flex items-center mr-3" href="{{ route('payment_vouchers.edit',['id'=>$v->id]) }}">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1">
                                   <polyline points="9 11 12 14 22 4"></polyline>
                                   <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                               </svg> Edit
                           </a>
                           @endcan
                       </div>
                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
   </div>
   <!-- END: Data List -->
   <!-- BEGIN: Pagination -->
   <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
       {{$data->links()}}
   </div>
   <!-- END: Pagination -->
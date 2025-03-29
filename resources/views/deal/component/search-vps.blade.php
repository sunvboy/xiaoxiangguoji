 <form class="flex space-y-1 space-x-1" autocomplete="off">
     <input type="text" name="sorts_vps" value="" class="hidden">
     <?php echo Form::select('product_vps', $products, request()->get('product'), ['class' => 'tom-select tom-select-field-product-vps w-full', 'placeholder' => "Chọn sản phẩm"]); ?>
     <?php echo Form::select('status_vps', config('tamphat')['status'], request()->get('status'), ['class' => 'tom-select tom-select-field-status-vps w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
     <input type="text" name="date_end_vps" class="form-control h-10" placeholder="Ngày thanh toán" value="<?php echo request()->get('date_end') ?>" />
     <input type="text" name="source_date_start_vps" class="form-control h-10" placeholder="Ngày bắt đầu HĐ" value="<?php echo request()->get('source_date_start') ?>" />
     <input type="text" name="source_date_end_vps" class="form-control h-10" placeholder="Ngày kết thúc HĐ" value="<?php echo request()->get('source_date_end') ?>" />
     <input type="text" name="keyword_vps" class="form-control h-10" placeholder="Nhập thông tin hồ sơ" value="<?php echo request()->get('keyword') ?>" />
     <div class="flex space-x-2 justify-center">
         <button type="submit" class="btn-search-submit-vps text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-3 py-2.5 text-center flex items-center space-x-1">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
             </svg>
         </button>
     </div>
 </form>
 @push('javascript')
 <script>
     new TomSelect(".tom-select-field-product-vps", {
         plugins: [{
             remove_button: {
                 title: 'Remove this item',
             },

         }],
         persist: false,
         create: true,
         sortField: {
             field: "text",
             direction: "asc"
         }
     });
     new TomSelect(".tom-select-field-status-vps", {
         plugins: {
             remove_button: {
                 title: 'Remove this item',
             }
         },
         persist: false,
         create: true,
         sortField: {
             field: "text",
             direction: "asc"
         }
     });
 </script>
 <script type="text/javascript">
     $(function() {
         $('input[name="date_end"]').datetimepicker({
             format: 'd/m/Y',
         });
         $('input[name="source_date_start"]').datetimepicker({
             format: 'd/m/Y',
         });
         $('input[name="source_date_end"]').datetimepicker({
             format: 'd/m/Y',
         });
     });
 </script>
 @endpush
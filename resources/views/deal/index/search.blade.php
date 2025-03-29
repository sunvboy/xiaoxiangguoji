 <form class="flex space-y-1 space-x-1" autocomplete="off">
     @if($active == 'website')
     <?php echo Form::select('catalogue_id', $category_products, request()->get('catalogue_id'), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục"]); ?>
     @endif
     <?php echo Form::select('product', $products, request()->get('product'), ['class' => 'tom-select tom-select-field-product w-full', 'placeholder' => "Chọn sản phẩm"]); ?>
     <?php echo Form::select('status', config('tamphat')['status'], request()->get('status'), ['class' => 'tom-select tom-select-field-status w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
     <?php /*echo Form::select('type', config('tamphat')['type'], request()->get('type'), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); */ ?>
     <input type="text" name="date_end" class="form-control h-10" placeholder="Ngày thanh toán" value="<?php echo request()->get('date_end') ?>" />
     <input type="text" name="source_date_start" class="form-control h-10" placeholder="Ngày kí HĐ" value="<?php echo request()->get('source_date_start') ?>" />
     <input type="text" name="source_date_end" class="form-control h-10" placeholder="Ngày kết thúc HĐ" value="<?php echo request()->get('source_date_end') ?>" />
     <input type="text" name="keyword" class="form-control h-10" placeholder="Nhập thông tin hồ sơ" value="<?php echo request()->get('keyword') ?>" />
     <div class="flex space-x-2 justify-center">
         <button type="submit" class="text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-3 py-2.5 text-center flex items-center space-x-1">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
             </svg>
         </button>
     </div>
 </form>
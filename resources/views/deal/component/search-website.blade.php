 <?php
    $category_products = collect($category_products)->filter(function ($item, $key) {
        return $key !== 1 && $key !== 21199;
    })->toArray();
    ?>
 <form class="flex space-y-1 space-x-1" autocomplete="off">
     <input type="text" name="sorts_website" value="" class="hidden">
     <?php echo Form::select('catalogue_id_website', $category_products, request()->get('catalogue_id'), ['class' => 'tom-select tom-select-field-category-website w-full', 'placeholder' => "Chọn danh mục"]); ?>
     <select class="tom-select tom-select-field-search-child-website w-full" name="catalogue_child_id_website">
         <option selected="selected" value="">Chọn phân loại</option>
         @if(!empty($category_products_child))
         @foreach($category_products_child as $item)
         <option value="{{$item}}">{{$item}}</option>
         @endforeach
         @endif
     </select>
     <?php echo Form::select('product_website', $products, request()->get('product'), ['class' => 'tom-select tom-select-field-product-website w-full', 'placeholder' => "Chọn sản phẩm"]); ?>
     <?php echo Form::select('status_website', config('tamphat')['status_web'], request()->get('status'), ['class' => 'tom-select tom-select-field-status-website w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
     <?php /*echo Form::select('type', config('tamphat')['type'], request()->get('type'), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); */ ?>
     <input type="text" name="date_end_website" class="form-control h-10" placeholder="Ngày thanh toán" value="<?php echo request()->get('date_end') ?>" />
     <input type="text" name="source_date_start_website" class="form-control h-10" placeholder="Ngày bắt đầu HĐ" value="<?php echo request()->get('source_date_start') ?>" />
     <input type="text" name="source_date_end_website" class="form-control h-10" placeholder="Ngày kết thúc HĐ" value="<?php echo request()->get('source_date_end') ?>" />
     <input type="text" name="keyword_website" class="form-control h-10" placeholder="Nhập thông tin hồ sơ" value="<?php echo request()->get('keyword') ?>" />
     <div class="flex space-x-2 justify-center">
         <button type="submit" class="btn-search-submit-website text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-3 py-2.5 text-center flex items-center space-x-1">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
             </svg>
         </button>
     </div>
 </form>
 @push('javascript')
 <script>
     new TomSelect(".tom-select-field-search-child-website", {
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
     new TomSelect(".tom-select-field-status-website", {
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
     new TomSelect(".tom-select-field-product-website", {
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
     new TomSelect(".tom-select-field-category-website", {
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
 </script>
 @endpush
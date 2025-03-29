 <form class="flex space-y-1 space-x-1" autocomplete="off">
     <input type="text" name="sorts" value="" class="hidden">
     <?php echo Form::select('customer_id', [], request()->get('customer_id'), ['class' => 'tom-select tom-select-field-customer w-full', 'placeholder' => "Công ty"]); ?>
     @if($active == 'website')
     <?php echo Form::select('catalogue_id', $category_products, request()->get('catalogue_id'), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục"]); ?>
     <select class="tom-select tom-select-field-search-child w-full" name="catalogue_child_id">
         <option selected="selected" value="">Chọn phân loại</option>
         @if(!empty($category_products_child))
         @foreach($category_products_child as $item)
         <option value="{{$item}}">{{$item}}</option>
         @endforeach
         @endif
     </select>
     @elseif($active == 'maintain')
     <?php
        $tags = \App\Models\CategoryProduct::select('title')->where('parentid', 1)->get();
        ?>
     <select class="tom-select tom-select-field-search-child w-full" name="catalogue_child_id">
         <option selected="selected" value="">Chọn duy trì</option>
         @if(!empty($tags))
         @foreach($tags as $item)
         <option value="{{$item->title}}">{{$item->title}}</option>
         @endforeach
         @endif
     </select>
     @endif

     <?php echo Form::select('product', $products, request()->get('product'), ['class' => 'tom-select tom-select-field-product w-full', 'placeholder' => "Chọn sản phẩm"]); ?>

     @if($active == 'website')
     <?php echo Form::select('status', config('tamphat')['status_web'], request()->get('status'), ['class' => 'tom-select tom-select-field-status w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
     @else
     <?php echo Form::select('status', config('tamphat')['status'], request()->get('status'), ['class' => 'tom-select tom-select-field-status w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
     @endif
     <?php /*echo Form::select('type', config('tamphat')['type'], request()->get('type'), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); */ ?>
     <input type="text" name="date_end" class="form-control h-10" placeholder="Ngày thanh toán" value="<?php echo request()->get('date_end') ?>" />
     <input type="text" name="source_date_start" class="form-control h-10" placeholder="Ngày bắt đầu HĐ" value="<?php echo request()->get('source_date_start') ?>" />
     <input type="text" name="source_date_end" class="form-control h-10" placeholder="Ngày kết thúc HĐ" value="<?php echo request()->get('source_date_end') ?>" />
     <input type="text" name="keyword" class="form-control h-10" placeholder="Khách hàng,email,số điện thoại" value="<?php echo request()->get('keyword') ?>" />
     <input type="text" name="keywordID" class="form-control h-10" placeholder="ID,Tiêu đề,Thông tin nguồn" value="<?php echo request()->get('keywordID') ?>" />
     <input type="text" name="keywordDomain" class="form-control h-10" placeholder="Tên miền" value="<?php echo request()->get('keywordDomain') ?>" />
     <div class="flex space-x-2 justify-center">
         <button type="submit" class="btn-search-submit text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-3 py-2.5 text-center flex items-center space-x-1">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
             </svg>
         </button>
     </div>
 </form>
 @push('javascript')
 <script>
     <?php if ($active == 'website') { ?>
         new TomSelect(".tom-select-field-category", {
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

     <?php } ?>
     <?php if ($active != 'vps') { ?>
         new TomSelect(".tom-select-field-search-child", {
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
     <?php } ?>

     new TomSelect(".tom-select-field-product", {
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
     new TomSelect('.tom-select-field-customer', {
         valueField: 'id',
         labelField: 'name',
         searchField: ['name'],
         // fetch remote data
         load: function(query, callback) {
             var self = this;
             if (self.loading > 1) {
                 callback();
                 return;
             }
             var url = '<?php echo route('deals.ajax.customerAutocomplete') ?>?keyword=' + encodeURIComponent(query);
             fetch(url)
                 .then(response => response.json())
                 .then(json => {
                     console.log(json.data)
                     callback(json.data);
                     self.settings.load = null;
                 }).catch(() => {
                     callback();
                 });
         },
         // custom rendering function for options
         render: {
             option: function(item, escape) {
                 return `<div class="py-2 ">
							${ escape(item.name) }
						</div>`;
             }
         },
     });
     new TomSelect(".tom-select-field-status", {
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
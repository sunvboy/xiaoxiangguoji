 <form class="w-full mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px] pb-10" action="{{!empty($action == 'create') ? route('products.store') : route('products.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
     <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
     <div class="p-[10px] pb-0">
         @include('components.alert-error')
         @csrf
         <div class="grid grid-cols-12 gap-[30px]">
             <div class="col-span-8">
                 <ul class="p-0 m-0 space-y-5">
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Tiêu đề<span class="text-red-600">*</span></span>
                         <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : ''), ['class' => 'form-control title', 'placeholder' => 'Tiêu đề']); ?>
                     </li>
                     <li class="flex space-x-1">
                         <div class="flex flex-col space-y-1 w-2/3">
                             <span class="form-label">Giá</span>
                             <?php echo Form::text('price', !empty(old('price')) ? old('price') : (!empty($detail->price) ? number_format($detail->price, '0', ',', '.') : ''), ['class' => 'form-control int', 'placeholder' => 'Giá']); ?>
                         </div>
                         <div class="flex flex-col space-y-1 flex-1">
                             <span class="form-label">Đơn vị</span>
                             <?php echo Form::select('unit', config('tamphat')['units'], !empty(old('unit')) ? old('unit') : (!empty($detail->unit) ? $detail->unit : ''), ['class' => 'form-control', 'data-placeholder' => "Tìm kiếm danh mục..."]); ?>
                         </div>
                     </li>
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Mô tả</span>
                         <?php echo Form::textarea('description', !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : ''), ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                     </li>
                 </ul>
             </div>
             <div class="col-span-4 space-y-5">
                 <div class="space-y-1">
                     <label class="form-label text-base font-semibold">Chọn danh mục</label>
                     <?php echo Form::select('catalogueid', $catalogues, !empty(old('catalogueid')) ? old('catalogueid') : (!empty($detail->catalogue_id) ? $detail->catalogue_id : ''), ['class' => 'tom-select tom-select-field-catalogue-id w-full', 'data-placeholder' => "Tìm kiếm danh mục..."]); ?>
                 </div>

                 <?php
                    $catalogue = !empty(old('catalogue')) ? old('catalogue') : (!empty($detail->catalogue) ? json_decode($detail->catalogue, TRUE) : '');
                    if (!empty($catalogue)) {
                        $valueToRemove =  !empty(old('catalogueid')) ? old('catalogueid') : (!empty($detail->catalogue_id) ? $detail->catalogue_id : '');
                        $catalogue = array_filter($catalogue, function ($item) use ($valueToRemove) {
                            return $item !== $valueToRemove;
                        });
                    }

                    ?>
                 <div class="mt-3">
                     <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                     <?php echo Form::select('catalogue[]', $catalogues, !empty($catalogue) ? $catalogue : '', ['multiple', 'class' => 'tom-select tom-select-field-category w-full']); ?>
                 </div>
                 <div class="space-y-1 hidden">
                     <label class="form-label text-base font-semibold">Chọn phân loại</label>
                     <?php echo Form::select('brand_id', $brands, !empty(old('brand_id')) ? old('brand_id') : (!empty($detail->brand_id) ? $detail->brand_id : ''), ['class' => 'form-control', 'data-placeholder' => "Tìm kiếm danh mục..."]); ?>
                 </div>
                 @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
             </div>
             <div class="col-span-12 flex justify-center">
                 <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                     <span>{{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}</span>
                 </button>
             </div>
         </div>
     </div>
 </form>
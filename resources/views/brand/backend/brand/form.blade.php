 <form class="w-full mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px] h-screen overflow-hidden" action="{{!empty($action == 'create') ? route('brands.store') : route('brands.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
     <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
     <div class="p-[10px] pb-0">
         @include('components.alert-error')
         @csrf
         <div class="grid grid-cols-12 gap-[30px]">
             <div class="col-span-8">
                 <ul class="p-0 m-0 space-y-5">
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Tiêu đề<span class="text-red-600">*</span></span>
                         <?php echo Form::text('title', !empty($detail->title) ? $detail->title : (!empty(old('title')) ? old('title') : ''), ['class' => 'form-control title', 'placeholder' => 'Tiêu đề']); ?>
                     </li>
                     <li class="flex flex-col space-y-1 hidden">
                         <span class="form-label">Đường dẫn<span class="text-red-600">*</span></span>
                         <?php echo Form::text('slug', !empty($detail->slug) ? $detail->slug : (!empty(old('slug')) ? old('slug') : ''), ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                     </li>
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Mô tả</span>
                         <?php echo Form::textarea('description', !empty($detail->description) ? $detail->description : (!empty(old('description')) ? old('description') : ''), ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                     </li>
                 </ul>
             </div>
             <div class="col-span-4 space-y-5">
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
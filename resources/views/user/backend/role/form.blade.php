 <form class="w-full mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px] h-screen overflow-hidden" action="{{!empty($action == 'create') ? route('roles.store') : route('roles.update',['id' => $detailRole->id])}}" method="post" enctype="multipart/form-data">
     <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
     <div class="p-[10px] pb-0">
         @include('components.alert-error')
         @csrf
         <div class="grid grid-cols-12 gap-[30px]">
             <div class="col-span-12 space-y-5">
                 <ul class="p-0 m-0 space-y-5">
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Tên nhóm thành viên<span class="text-red-600">*</span></span>
                         <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detailRole->title) ? $detailRole->title : ''), ['class' => 'form-control title', 'placeholder' => 'Tiêu đề']); ?>
                     </li>
                     <li class="flex flex-col space-y-1">
                         <span class="form-label">Mô tả</span>
                         <?php echo Form::text('description', !empty(old('description')) ? old('description') : (!empty($detailRole->description) ? $detailRole->description : ''), ['class' => 'form-control w-full ']); ?>
                     </li>
                 </ul>
                 @foreach($permissions as $k=>$v)
                 <div class="grid grid-cols-12">
                     <div class="col-span-12 md:col-span-4">
                         <label class="form-label text-base font-semibold">{{config('permissions.modules')[$v->title]}}</label>
                     </div>
                     @foreach($v->permissionsChildren as $val)
                     @if($val->title != 'Copy hình ảnh' && $val->title != 'Di chuyển hình ảnh')
                     <div class="col-span-12 xl:col-span-2">
                         <label for="check{{$val->id}}" class="flex space-x-1 items-center">
                             <input {{!empty($permissionChecked)?($permissionChecked->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="inputChild w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                             <span>{{!empty(config('permissions.actions')[$val->title])?config('permissions.actions')[$val->title]:$val->title}}</span>
                         </label>
                     </div>
                     @endif
                     @endforeach
                 </div>
                 @endforeach
                 <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                     <span>{{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}</span>
                 </button>
             </div>


         </div>
     </div>
 </form>
<form class="w-[75%] mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px]" action="{{!empty($action == 'create') ? route('users.store') : route('users.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
    <div class="p-[10px] pb-0">
        @include('components.alert-error')
        @csrf
        <ul class="p-0 m-0 ">
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Tên thành viên<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <?php echo Form::text('name', !empty($detail->name) ? $detail->name : (!empty(old('name')) ? old('name') : ''), ['class' => 'form-control', 'placeholder' => 'Tên công ty']); ?>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Email<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <?php echo Form::text('email', !empty($detail->email) ? $detail->email : (!empty(old('email')) ? old('email') : ''), ['class' => 'form-control', 'placeholder' => 'Tên công ty']); ?>
                </div>
            </li>

            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Số điện thoại</span>
                <div class="w-[80%]">
                    <?php echo Form::text('phone', !empty($detail->phone) ? $detail->phone : (!empty(old('phone')) ? old('phone') : ''), ['class' => 'form-control', 'placeholder' => 'Địa chỉ']); ?>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Địa chỉ</span>
                <div class="w-[80%]">
                    <?php echo Form::text('address', !empty($detail->address) ? $detail->address : (!empty(old('address')) ? old('address') : ''), ['class' => 'form-control', 'placeholder' => 'Địa chỉ']); ?>
                </div>
            </li>
            @if($action == 'create')
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Mật khẩu</span>
                <div class="w-[80%]">
                    <input type="password" name="password" class="form-control" placeholder="" value="">
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Nhập lại mật khẩu</span>
                <div class="w-[80%]">
                    <input type="password" name="confirm_password" class="form-control" placeholder="" value="">
                </div>
            </li>
            @endif

            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Chọn nhóm thành viên<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <select class="form-control" data-placeholder="Search..." name="role_id[]" tabindex="-1">
                        @foreach($roles as $k=>$v)
                        <option value="{{$v->id}}" {{!empty($role_user)?($role_user->contains('role_id',$v->id) ? 'selected' : '') :''}}>
                            {{$v->title}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                @include('user.backend.user.image',['action' => $action])

            </li>
            <li class="p-[10px] w-full flex justify-center">
                <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <span>{{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}</span>
                </button>
            </li>
        </ul>
    </div>
</form>
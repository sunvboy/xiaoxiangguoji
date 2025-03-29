<form class="w-[75%] mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px]" action="{{!empty($action == 'create') ? route('customers.store') : route('customers.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
    <div class="p-[10px] pb-0">
        @include('components.alert-error')
        @csrf
        <ul class="p-0 m-0 ">
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Tên công ty<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <?php echo Form::text('name', !empty($detail->name) ? $detail->name : (!empty(old('name')) ? old('name') : ''), ['class' => 'form-control', 'placeholder' => 'Tên công ty']); ?>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Loại hình công ty<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <?php echo Form::select('catalogue_id', $category, !empty($detail->catalogue_id) ? $detail->catalogue_id : (!empty(old('catalogue_id')) ? old('catalogue_id') : ''), ['class' => 'form-control', 'placeholder' => 'Chọn loại hình công ty']); ?>
                </div>
            </li>
            <?php
            $hotline = !empty($detail->hotline) ? explode(',', $detail->hotline) : (!empty(old('hotline')) ? old('hotline') : []);
            $website = !empty($detail->website) ? explode(',', $detail->website) : (!empty(old('website')) ? old('website') : []);
            $email = !empty($detail->email) ? explode(',', $detail->email) : (!empty(old('email')) ? old('email') : []);
            ?>
            <li class="text-[15px] p-[10px]">
                <div class="flex space-x-[10px]">
                    <span class="bg-white font-semibold flex-1">Điện thoại</span>
                    <div class="w-[80%]">
                        <div class="space-y-1" id="htmlHotline">
                            @if(!empty($hotline) && count($hotline) > 0)
                            @foreach($hotline as $item)
                            @if(!empty($item))
                            <div class="flex space-x-3">
                                <?php echo Form::text('hotline[]', $item, ['class' => 'form-control', 'placeholder' => 'Điện thoại']); ?>
                                <button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                            @endforeach
                            @else
                            <div class="flex space-x-3">
                                <?php echo Form::text('hotline[]', '', ['class' => 'form-control', 'placeholder' => 'Điện thoại']); ?>
                                <button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <a href="javascript:void(0)" class="js_addHotline w-full text-[#80868e] cursor-pointer mt-2 float-left">
                            <i class="fa-solid fa-plus"></i>
                            Thêm
                        </a>
                    </div>
                </div>
            </li>
            <li class="text-[15px] p-[10px]">
                <div class="flex space-x-[10px]">
                    <span class="bg-white font-semibold flex-1">Website</span>
                    <div class="w-[80%]">
                        <div class="space-y-1" id="htmlWebsite">
                            @if(!empty($website))
                            @foreach($website as $item)
                            @if(!empty($item))
                            <div class="flex space-x-3">
                                <?php echo Form::text('website[]', $item, ['class' => 'form-control', 'placeholder' => 'Website']); ?>
                                <button type="button" class="js_removeWebsite text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                            @endforeach
                            @else
                            <div class="flex space-x-3">
                                <?php echo Form::text('website[]', '', ['class' => 'form-control', 'placeholder' => 'Website']); ?>
                                <button type="button" class="js_removeWebsite text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <a href="javascript:void(0)" class="js_addWebsite w-full text-[#80868e] cursor-pointer mt-2 float-left">
                            <i class="fa-solid fa-plus"></i>
                            Thêm
                        </a>
                    </div>
                </div>
            </li>
            <li class="text-[15px] p-[10px]">
                <div class="flex space-x-[10px]">
                    <span class="bg-white font-semibold flex-1">Email</span>
                    <div class="w-[80%]">
                        <div class="space-y-1" id="htmlEmail">
                            @if(!empty($email))
                            @foreach($email as $item)
                            @if(!empty($item))
                            <div class="flex space-x-3">
                                <?php echo Form::text('email[]', $item, ['class' => 'form-control', 'placeholder' => 'Email']); ?>
                                <button type="button" class="js_removeEmail text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                            @endforeach
                            @else
                            <div class="flex space-x-3">
                                <?php echo Form::text('email[]', '', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
                                <button type="button" class="js_removeEmail text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <a href="javascript:void(0)" class="js_addEmail w-full text-[#80868e] cursor-pointer mt-2 float-left">
                            <i class="fa-solid fa-plus"></i>
                            Thêm
                        </a>
                    </div>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Địa chỉ</span>
                <div class="w-[80%]">
                    <?php echo Form::text('address', !empty($detail->address) ? $detail->address : (!empty(old('address')) ? old('address') : ''), ['class' => 'form-control', 'placeholder' => 'Địa chỉ']); ?>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Ghi chú</span>
                <div class="w-[80%]">
                    <?php echo Form::textarea('note', !empty($detail->note) ? $detail->note : (!empty(old('note')) ? old('note') : ''), ['class' => 'form-control', 'placeholder' => 'Ghi chú']); ?>
                </div>
            </li>
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                @include('components.dropzone',['action' => $action])
            </li>
            <li class="p-[10px] w-full flex justify-center">
                <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <span>{{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}</span>
                </button>
            </li>
        </ul>
    </div>
</form>
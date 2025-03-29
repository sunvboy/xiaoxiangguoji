<form class="w-[75%] mx-auto bg-white shadow-lg rounded-bl-[10px] rounded-br-[10px]" action="{{!empty($action == 'create') ? route('customer_categories.store') : route('customer_categories.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin chi tiết</h3>
    <div class="p-[10px] pb-0">
        @include('components.alert-error')
        @csrf
        <ul class="p-0 m-0 ">
            <li class="flex text-[15px] items-center p-[10px] space-x-[10px]">
                <span class="bg-white font-semibold flex-1">Tiêu đề<span class="text-red-600">*</span></span>
                <div class="w-[80%]">
                    <?php echo Form::text('title', !empty($detail->title) ? $detail->title : (!empty(old('title')) ? old('title') : ''), ['class' => 'form-control', 'placeholder' => 'Tiêu đề']); ?>
                </div>
            </li>
            <li class="p-[10px] w-full flex justify-center">
                <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <span>{{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}</span>
                </button>
            </li>
        </ul>
    </div>
</form>
@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới phiếu chi</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách phiếu chi",
        "src" => route('payment_vouchers.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Thêm mới phiếu chi
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('payment_vouchers.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class="box p-5 grid grid-cols-2 gap-2">
                <div class="col-span-2">
                    @include('components.alert-error')
                </div>
                @csrf
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Nhóm người nhận<span style="color:red">*</span></label>
                    <?php echo Form::select('module', $table, !empty(old('module')) ? old('module') : (!empty($detail->module) ? $detail->module : ''), ['class' => 'form-control w-full', 'required']); ?>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Tên người nhận</label>
                    <select class="form-control" data-placeholder="Tìm kiếm..." name="module_id">
                        <option value="0">Chọn khách hàng</option>
                        @if(!empty($data))
                        @foreach($data as $item)
                        <?php
                        $selected = !empty(old('module_id')) ? old('module_id') : (!empty($detail->module_id) ? $detail->module_id : '');
                        ?>
                        <option value="{{$item->id}}" {{!empty($selected == $item->id)?'selected':''}}>{{$item->title}} <?php if (!empty($item->phone)) { ?>- {{$item->phone}} <?php } ?></option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Loại phiếu chi</label>
                    <?php echo Form::select('group_id', $categories, !empty(old('group_id')) ? old('group_id') : (!empty($detail->group_id) ? $detail->group_id : ''), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm loại phiếu chi"]); ?>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Mã phiếu<span style="color:red">*</span></label>
                    <?php echo Form::text('code', !empty(old('code')) ? old('code') : (!empty($detail->code) ? $detail->code : CodeRender('payment_vouchers')), ['class' => 'form-control w-full']); ?>
                </div>


            </div>
            <div class="box mt-3">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Giá trị ghi nhận
                    </h2>
                </div>
                <div class="p-5 grid grid-cols-2 gap-2">
                    <div class="col-span-2 md:col-span-1">
                        <label class="form-label text-base font-semibold">Giá trị<span style="color:red">*</span></label>
                        <?php echo Form::text('price', !empty(old('price')) ? old('price') : (!empty($detail->price) ? number_format($detail->price, '0', ',', '.') : ''), ['class' => 'form-control w-full int', 'placeholder' => '', 'autocomplete' => 'off', 'required']); ?>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="form-label text-base font-semibold">Hình thức thanh toán<span style="color:red">*</span></label>
                        <?php echo Form::select('type', config('payment.method'), !empty(old('type')) ? old('type') : (!empty($detail->type) ? $detail->type : ''), ['class' => 'form-control w-full', 'autocomplete' => 'off', 'required']); ?>
                    </div>
                    <div class="col-span-2">
                        <label class="form-label text-base font-semibold">Tham chiếu</label>
                        <?php echo Form::text('reference', !empty(old('reference')) ? old('reference') : (!empty($detail->reference) ? $detail->reference : ''), ['class' => 'form-control w-full', 'autocomplete' => 'off']); ?>
                    </div>
                    <div class="col-span-2 flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox" id="checkbox-checked" value="1" name="checked" {{!empty(old('checked')) ? 'checked' : (!empty($detail->checked) ? 'checked' : '')}}>

                        <label class="form-label text-base font-semibold" for="checkbox-checked" style="margin-bottom: 0px;">Hạch toán kết quả kinh doanh</label>
                    </div>
                    <div class="col-span-2 hidden md:flex justify-end">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </div>

            <!-- END: Form Layout -->
        </div>
        <div class="col-span-12 lg:col-span-4">
            <div class="box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin khác
                    </h2>
                </div>
                <div class="p-5">
                    <div class="">
                        <label class="form-label text-base font-semibold">Chi nhánh</label>
                        <select class="tom-select tom-select-custom w-full tomselected" data-placeholder="Tìm kiếm chi nhánh..." name="address_id" id="tomselect-1" tabindex="-1" hidden="hidden">
                            <?php if (in_array('addresses', $dropdown)) { ?>
                                @if(!empty($address))
                                @foreach($address as $item)
                                <option value="{{$item->id}}" @if($item->active ==1) selected @endif>{{$item->title}}</option>
                                @endforeach
                                @endif
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Mô tả</label>
                        <?php echo Form::textarea('description', !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : ''), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                    </div>
                    <div class="mt-3 flex md:hidden text-right">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <style>
        @media (min-width: 767px) {
            .md\:hidden {
                display: none;
            }
        }
    </style>
</div>
@endsection
@push('javascript')
<script>
    $(document).on('change', 'select[name="module"]', function(e) {
        $.ajax({
            url: "<?php echo route('payment_vouchers.getModule') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                table: $(this).val(),
            },
            success: function(data) {
                $('select[name="module_id"]').html(data.html);
            }
        });
    })
</script>
@endpush
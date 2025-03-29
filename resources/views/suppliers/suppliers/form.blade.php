<?php
$route = $title = '';
if ($action == 'create') {
    $route = route('suppliers.store');
    $title = 'Thêm mới';
} else {
    $route = route('suppliers.update', ['id' => $detail->id]);
    $title = 'Cập nhập';
}

?>
<form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{$route}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class=" col-span-12 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="box p-5 grid grid-cols-2 gap-2">
            <div class="col-span-2">
                @include('components.alert-error')
            </div>
            @csrf
            <div class="col-span-2">
                <label class="form-label text-base font-semibold">Tên nhà cung cấp<span style="color:red">*</span></label>
                <?php echo Form::text('title', !empty(old('title')) ? old('title') : (!empty($detail->title) ? $detail->title : ''), ['class' => 'form-control w-full']); ?>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="form-label text-base font-semibold">Mã nhà cung cấp</label>
                <?php echo Form::text('code', !empty(old('code')) ? old('code') : (!empty($detail->code) ? $detail->code : ''), ['class' => 'form-control w-full']); ?>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="form-label text-base font-semibold">Nhóm nhà cung cấp</label>
                <?php echo Form::select('category_id', $categories, !empty(old('category_id')) ? old('category_id') : (!empty($detail->category_id) ? $detail->category_id : ''), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm nhóm nhà cung cấp...", 'required']); ?>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="form-label text-base font-semibold">Số điện thoại</label>
                <?php echo Form::text('phone', !empty(old('phone')) ? old('phone') : (!empty($detail->phone) ? $detail->phone : ''), ['class' => 'form-control w-full']); ?>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="form-label text-base font-semibold">Email</label>
                <?php echo Form::text('email', !empty(old('email')) ? old('email') : (!empty($detail->email) ? $detail->email : ''), ['class' => 'form-control w-full']); ?>
            </div>

        </div>
        <div class="box mt-3">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Thông tin địa chỉ
                </h2>
            </div>
            <div class="p-5 grid grid-cols-3 gap-2">
                <div class="col-span-3">
                    <label class="form-label text-base font-semibold">Nhãn</label>
                    <?php echo Form::text('label', !empty(old('label')) ? old('label') : (!empty($detail->label) ? $detail->label : ''), ['class' => 'form-control w-full', 'placeholder' => 'Ví dụ: Nơi thanh toán, nơi giao hàng', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-span-3">
                    <label class="form-label text-base font-semibold">Địa chỉ<span style="color:red">*</span></label>
                    <?php echo Form::text('address', !empty(old('address')) ? old('address') : (!empty($detail->address) ? $detail->address : ''), ['class' => 'form-control w-full', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <label class="form-label text-base font-semibold">Tỉnh/Thành phố</label>
                    <?php echo Form::select('city_id', $listCity, !empty(old('city_id')) ? old('city_id') : (!empty($detail->city_id) ? $detail->city_id : ''), ['class' => 'form-control ', 'id' => 'cityID']); ?>

                </div>
                <div class="col-span-3 md:col-span-1">
                    <label class="form-label text-base font-semibold">Quận/Huyện</label>
                    <?php echo Form::select('district_id', $listDistrict, !empty(old('district_id')) ? old('district_id') : (!empty($detail->district_id) ? $detail->district_id : ''), ['class' => 'form-control', 'id' => 'districtID', 'placeholder' => 'Quận/Huyện']); ?>

                </div>
                <div class="col-span-3 md:col-span-1">
                    <label class="form-label text-base font-semibold">Phường/Xã</label>
                    <?php echo Form::select('ward_id', $listWard, !empty(old('ward_id')) ? old('ward_id') : (!empty($detail->ward_id) ? $detail->ward_id : ''), ['class' => 'form-control ', 'id' => 'wardID', 'placeholder' => 'Phường/Xã']); ?>
                </div>
            </div>
        </div>
        <div class="box mt-3">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Thông tin bổ sung
                </h2>
            </div>
            <div class="p-5 grid grid-cols-2 gap-2">
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Số fax</label>
                    <?php echo Form::text('fax', !empty(old('fax')) ? old('fax') : (!empty($detail->fax) ? $detail->fax : ''), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Mã số thuế</label>
                    <?php echo Form::text('taxNumber', !empty(old('taxNumber')) ? old('taxNumber') : (!empty($detail->taxNumber) ? $detail->taxNumber : ''), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Website</label>
                    <?php echo Form::text('website', !empty(old('website')) ? old('website') : (!empty($detail->website) ? $detail->website : ''), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="form-label text-base font-semibold">Công nợ</label>
                    <?php echo Form::text('debt', !empty(old('debt')) ?  number_format(old('debt'), '0', ',', '.') : (!empty($detail->debt) ? number_format($detail->debt, '0', ',', '.') : ''), ['class' => 'form-control w-full int ', 'placeholder' => '']); ?>
                </div>
                <div class="col-span-2 text-right hidden md:flex">
                    <button type="submit" class="btn btn-primary">{{$title}}</button>
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
                <div>
                    <label class="form-label text-base font-semibold">Nhân viên phụ trách</label>
                    <?php echo Form::select('user_id', $listUsers, !empty(old('user_id')) ? old('user_id') : (!empty($detail->user_id) ? $detail->user_id : ''), ['class' => 'form-control ']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <?php echo Form::textarea('description', !empty(old('description')) ? old('description') : (!empty($detail->description) ? $detail->description : ''), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Hình thức thanh toán</label>
                    <?php echo Form::select('payment', $payments, !empty(old('payment')) ? old('payment') : (!empty($detail->payment) ? $detail->payment : ''), ['class' => 'form-control ']); ?>
                </div>
                <div class="mt-3 flex md:hidden text-right">
                    <button type="submit" class="btn btn-primary">{{$title}}</button>
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
@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới sản phẩm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách sản phẩm",
        "src" => route('products.index'),
    ],
    [
        "title" => "Thêm mới sản phẩm",
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
            Thêm mới sản phẩm
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            @include('product.backend.product.common.tab')
            @include('components.alert-error')
            @csrf
            <div class="tab-content">
                <div id="example-tab-homepage" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-homepage-tab">
                    <!-- START: thông tin sản phẩm -->
                    @include('product.backend.product.common._detail',['action' => 'create'])
                    <!-- START: thông tin sản phẩm -->
                    <!-- START: lọc sản phẩm -->
                    <div class="<?php if (!in_array('attributes', $dropdown)) { ?>hidden<?php } ?>">
                    </div>
                    <!-- END: lọc sản phẩm -->
                </div>
                <div id="example-tab-contact" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-contact-tab">
                    @include('components.field.index', ['module' => $module])
                </div>
                <div id="example-tab-attr" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-attr-tab">
                    @include('product.backend.product.common.stock',['action' => 'create'])
                    @include('product.backend.product.common.attribute',['action' => 'create'])
                </div>
                <?php /*<div id="example-tab-stock" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-stock-tab">
                    @include('product.backend.product.common.stock',['action' => 'create'])
                </div>*/ ?>
            </div>
            <!-- start: SEO -->
            <div class=" box p-5 mt-3">
                @include('components.seo')
            </div>
            <div class="mt-3">
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Thêm mới</button>
                </div>
            </div>
            <!-- end: SEO -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            <div class=" box p-5 pt-3 mt-3">
                <div>
                    <label class="form-label text-base font-semibold">Chọn danh mục chính</label>
                    <?php echo Form::select('catalogueid', $catalogues, old('catalogueid'), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm danh mục...", 'required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                    <?php echo Form::select('catalogue[]', $catalogues, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm danh mục..."]); ?>
                </div>
                <!-- START: Thương hiệu -->
                <div class="mt-3 <?php if (!in_array('brands', $dropdown)) { ?>hidden<?php } ?>">
                    <label class="form-label text-base font-semibold">Thương hiệu</label>
                    <?php echo Form::select('brand_id', $brands, null, ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm thương hiệu..."]); ?>
                </div>
                <!-- END: Thương hiệu -->
                <!-- START: tags -->
                @include('components.tag',['module' => $module])
                <!-- END: tags -->
            </div>
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@include('product.backend.product.common.script',['action' => 'create'])
<style>
    .dz-preview {
        border-radius: 10px;
        -webkit-box-shadow: -8px -4px 57px -34px rgb(66 68 90);
        -moz-box-shadow: -8px -4px 57px -34px rgba(66, 68, 90, 1);
        box-shadow: -8px -4px 57px -34px rgb(66 68 90);
    }
</style>
@endsection
@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách sản phẩm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách sản phẩm",
        "src" => route('products.index'),
    ],
    [
        "title" => "Danh sách",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class="text-lg font-medium mt-10">
        Danh sách sản phẩm
    </h1>
    <div class=" grid grid-cols-12 gap-2 justify-between mt-5 mb-5">
        <form class="grid grid-cols-12 gap-6 mt-5 hidden" role="form" action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-5">
                <label class="form-label text-base font-semibold">Select file</label>
                <div>
                    <div class="flex w-full items-center justify-start bg-grey-lighter">
                        <label class="w-64 flex flex-col items-center p-2  bg-white text-blue rounded-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                            <span class="mt-2 text-base leading-normal">Select a file</span>
                            <input type='file' class="hidden" id="file" name="file" accept=".xlsx,.xls" />
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="text-white space-x-1 flex items-center bg-primary font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                <i class="fa-solid fa-file-excel"></i>
                <span>Import</span>
            </button>
        </form>
        @can('products_create')
        <div class="col-span-12 flex justify-end space-x-2">
            <a class="full-search btn btn-danger " href="javascript:void(0);">Tìm kiếm nâng cao</a>
            <a href="{{route('products.create')}}" class="btn btn-primary shadow-md">Thêm mới</a>
            <a href="{{route('products.export')}}" class="btn btn-primary shadow-md hidden">Export excel</a>
        </div>
        @endcan
        @can('products_destroy')
        @if(empty($catalogue))
        <select class="form-control ajax-delete-all-product mr10 col-span-2 " data-title="Lưu ý: Khi bạn xóa danh sách sản phẩm, toàn bộ sản phẩm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!">
            <option>Hành động</option>
            <option value="">Xóa</option>
        </select>
        @endif
        @endcan
        @if(isset($configIs))
        <div class="col-span-2">
            <select class="form-control mr10 filter" name="type">
                <option value="" selected>Chọn hiển thị</option>
                @foreach($configIs as $key=>$value)
                <option value="{{$value->type}}" <?php if (!empty(request()->get('type')) && request()->get('type') == $value->module) { ?>selected<?php } ?>>{{$value->title}}
                </option>
                @endforeach
            </select>
        </div>
        @endif
        @if(isset($catalogues))
        <div class="col-span-4">
            <?php echo Form::select('catalogue_id', $catalogues, request()->get('catalogue_id'), ['class' => 'form-control tom-select tom-select-custom filter catalogue_id ', 'data-placeholder' => "Select your favorite actors"]); ?>
        </div>
        @endif
        <input type="search" name="keyword" class="keyword form-control filter col-span-4" placeholder="Tên sản phẩm, mã sản phẩm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
    </div>
    <!-- START: tìm kiếm -->
    <div class="mb10 row filter-more grid grid-cols-12 gap-6 justify-between mt-5 hidden">
        <div class="col-span-4">
            <label class="form-label text-base font-semibold">Nhập khoảng giá</label>
            <div class="sm:grid grid-cols-2 gap-2">
                <div class="input-group">
                    <div class="input-group-text">Từ</div>
                    <input type="text" class="form-control int filter h-10" name="start_price" value="">
                </div>
                <div class="input-group">
                    <div class="input-group-text">Đến</div>
                    <input type="text" class="form-control int filter h-10" name="end_price" value="">
                </div>
            </div>
        </div>
        <div class="col-span-4 hidden  <?php if (!in_array('tags', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Tags</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm tag..." data-header="Tags" multiple="multiple" name="tags[]" tabindex="-1" hidden="hidden">
                @if(isset($tags))
                @foreach($tags as $k=>$tag)
                <option value="{{$tag->id}}">
                    {{$tag->title}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-span-8 <?php if (!in_array('brands', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Thương hiệu</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm thương hiệu..." data-header="Thương hiệu" multiple="multiple" name="brands[]" tabindex="-1" hidden="hidden">
                @if(isset($brands))
                @foreach($brands as $k=>$brand)
                <option value="{{$brand->id}}">
                    {{$brand->title}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-span-12" id="selected_attr"></div>
        <div class="col-span-12">
            <div id="choose_attr">
                <label class="form-label text-base font-semibold">Thuộc tính</label>
                <input type="text" class="hidden filter" name="attr" value="">
                <ul class="list_attr_catalogue bg-white p-3" style="display: none">
                </ul>
            </div>
        </div>
    </div>
    <!-- END: tìm kiếm -->
    <div class="grid grid-cols-12 gap-6 ">
        <div id="data_product" class="col-span-12 overflow-auto lg:overflow-visible">
            @include('product.backend.product.index.data')
        </div>
    </div>
</div>
@endsection
@push('javascript')
@include('product.backend.product.index.script')
@endpush

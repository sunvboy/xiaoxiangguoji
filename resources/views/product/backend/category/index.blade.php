@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh mục sản phẩm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh mục sản phẩm",
        "src" => route('category_products.index'),
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
    <h1 class=" text-lg font-medium mt-10">
        Danh mục sản phẩm
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module,'configIs' => $configIs])
            @can('category_products_create')
            <a href="{{route('category_products.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>

                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">VỊ TRÍ</th>
                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>
                        <th class="whitespace-nowrap">HIỂN THỊ</th>
                        @include('components.table.is_thead')
                        <th class="whitespace-nowrap">Sản phẩm mới</th>
                        <th class="whitespace-nowrap">Header</th>
                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">

                        <td>
                            <!-- {{$data->firstItem()+$loop->index}} -->
                            <?php echo $v->id; ?>
                        </td>
                        <td>
                            <a href="{{route('products.index',['catalogue_id'=>$v->id])}}" class="flex" style="width: 280px;">
                                <?php echo str_repeat('|----', (($v->level > 0) ? ($v->level - 1) : 0)) . $v->title; ?>
                                ({{!empty($v->countProduct)?count($v->countProduct):0}})</a><br>
                        </td>
                        @include('components.order',['module' => $module])
                        <td>
                            {{$v->user->name}}
                        </td>
                        <td>
                            @if($v->created_at)
                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                            @endif
                        </td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>

                        @include('components.table.is_tbody')
                        <td class="w-40">
                            <div class="form-check form-switch">
                                <input <?php echo ($v->isnew == 1) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox" data-module="{{$module}}" data-id="<?php echo $v->id; ?>" data-title="isnew" id="isnew-<?php echo $v->id; ?>">
                            </div>
                        </td>
                        <td class="w-40">
                            <div class="form-check form-switch">
                                <input <?php echo ($v->isHeader == 1) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox" data-module="{{$module}}" data-id="<?php echo $v->id; ?>" data-title="isHeader" id="isHeader-<?php echo $v->id; ?>">
                            </div>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a href="{{route('routerURL',['slug' => $v->slug])}}" class="text-danger italic mr-3" target="_blank">Xem trước</a>

                                @can('category_products_edit')
                                <a class="flex items-center mr-3" href="{{ route('category_products.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                @endcan
                                @can('category_products_destroy')
                                <a class="flex items-center text-danger <?php echo !empty($v->countProduct->count() == 0) ? 'ajax-delete' : '' ?> <?php echo ($v->rgt - $v->lft > 1) ? 'disabled' : ''; ?>
                                    <?php echo !empty($v->countProduct->count() == 0) ? '' : 'disabled' ?>" href="javascript:void(0);" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa danh mục, danh mục sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            {{$data->links()}}
        </div>
        <!-- END: Pagination -->
    </div>
</div>
@endsection
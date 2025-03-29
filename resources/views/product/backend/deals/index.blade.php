@extends('dashboard.layout.dashboard')
@section('title')
<title>Sản phẩm mua kèm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Sản phẩm mua kèm",
        "src" => route('product_deals.index'),
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
        Sản phẩm mua kèm
    </h1>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <div class="flex space-x-2 ">
                <select class="flex-auto form-control ajax-delete-all mr10 w-36" style="height:42px" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
                    <option>Hành động</option>
                    <option value="">Xóa</option>
                </select>
            </div>
            @can('product_deals_create')
            <a href="{{route('product_deals.create')}}" class="btn btn-primary shadow-md" style="height: 42px;">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        @can('product_deals_destroy')
                        <th class="text-center" style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        @endcan
                        <th class="text-center">STT</th>
                        <th>Sản phẩm chính</th>
                        <th>Sản phẩm mua kèm</th>
                        <th>NGƯỜI TẠO</th>
                        <th>NGÀY TẠO</th>
                        <th class="hidden">HIỂN THỊ</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        @can('product_deals_destroy')
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        @endcan
                        <td class="text-left">
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td class="font-bold text-primary">
                            {{$v->product->title}}
                        </td>
                        <td>
                            <div class="space-y-3">
                                @if(!empty($v->product_deal_items))
                                <?php
                                $products = collect($v->product_deal_items)->groupBy('product_id')->all();
                                ?>
                                @foreach($products as $key=>$item)
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in mr-2">
                                        <img class=" rounded-full" src="{{$item[0]['image']}}" alt="{{$item[0]['title']}}">
                                    </div>
                                    <div class="flex-1">
                                        {{$item[0]['title']}}
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </td>
                        <td>
                            {{$v->user->name}}
                        </td>
                        <td>
                            @if($v->created_at)
                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                            @endif
                        </td>
                        <td class="w-40 hidden">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('product_deals_edit')
                                <a class="flex items-center mr-3" href="{{ route('product_deals.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                @endcan
                                @can('product_deals_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:void(0);" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa deal, deal sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách tags</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách tags",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách tags
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module,'configIs' => $configIs])
            @can('tags_create')
            <a href="{{route('tags.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">VỊ TRÍ</th>
                        <th class="whitespace-nowrap">MODULE</th>
                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>

                        <th class="whitespace-nowrap">HIỂN THỊ</th>
                        @include('components.table.is_thead')
                        <?php /* if (in_array('articles', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Bài viết nổi bật</th>
                        <?php }?>
                        <?php if (in_array('products', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Sản phẩm nổi bật</th>
                        <?php }?>
                        <?php if (in_array('tours', $dropdown)) { ?>

                        <th class="whitespace-nowrap">Tour nổi bật</th>
                        <?php }*/ ?>

                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <a href="{{route('tagURL',['slug' => $v->slug])}}" target="_blank"><?php echo $v->title; ?></a>
                        </td>

                        @include('components.order',['module' => $module])
                        <td>
                            <?php echo $v->module; ?>
                        </td>
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
                        <?php /* if (in_array('articles', $dropdown)) { ?>
                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isArticle','id' =>
                            $v->id])
                        </td>
                        <?php }?>
                        <?php if (in_array('products', $dropdown)) { ?>

                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isProduct','id' =>
                            $v->id])
                        </td>
                        <?php }?>
                        <?php if (in_array('tours', $dropdown)) { ?>

                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'isTour','id' =>
                            $v->id])
                        </td>
                        <?php }*/ ?>

                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('tags_edit')
                                <a class="flex items-center mr-3" href="{{ route('tags.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @endcan
                                @can('tags_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
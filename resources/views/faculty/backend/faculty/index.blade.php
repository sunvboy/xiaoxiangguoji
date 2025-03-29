@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách khóa học</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách khóa học",
        "src" => route('faculties.index'),
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
        Danh sách khóa học
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module,'htmlOption' => $htmlOption])
            @can('faculties_create')
            <a href="{{route('faculties.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        @can('faculties_destroy')
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        @endcan
                        <th>STT</th>
                        <th>TIÊU ĐỀ</th>
                        <th>VỊ TRÍ</th>
                        <th>DANH MỤC</th>
                        <th>NGƯỜI TẠO</th>
                        <th>HIỂN THỊ</th>
                        <th>Trang chủ</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        @can('faculties_destroy')
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        @endcan
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in mr-2">
                                    <img class=" rounded-full" src="{{File::exists(base_path($v->image)) ? getImageUrl($module,$v->image,'small') : asset('images/404.png')}}">
                                </div>
                                <div class="flex-1">
                                    <a href="{{route('routerURL',['slug' => $v->slug])}}" target="_blank" class=" text-primary font-medium"><?php echo $v->title; ?></a>
                                </div>
                            </div>
                        </td>
                        @include('components.order',['module' => $module])
                        <td class="whitespace-nowrap">
                            {{$v->faculty_categories->title}}
                        </td>
                        <td class="text-center">
                            {{$v->user->name}}
                        </td>
                        <td class="hidden">
                            @if($v->created_at)
                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                            @endif
                        </td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td class="w-40">
                            <div class="form-check form-switch">
                                <input <?php echo ($v->ishome == 1) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox" data-module="{{$module}}" data-id="<?php echo $v->id; ?>" data-title="ishome" id="ishome-<?php echo $v->id; ?>">
                            </div>
                        </td>
                        <td class="table-report__action w-56 ">
                            <div class="flex justify-center items-center">
                                @can('faculties_edit')
                                <a class="flex items-center mr-3" href="{{ route('faculties.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @endcan
                                @can('faculties_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa khóa học, khóa học sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
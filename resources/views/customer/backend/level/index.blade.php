@extends('dashboard.layout.dashboard')
@section('title')
<title>Cấp bậc thành viên</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấp bậc thành viên",
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
            Cấp bậc thành viên
        </h1>
    </div>
    @if(empty($detail))
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('customer_levels.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>
    @else
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('customer_levels.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Cập nhập</button>
                </div>
            </div>
        </div>
    </form>

    @endif


    <div class=" col-span-12 lg:col-span-12">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="text-center">Tiêu đề</th>
                    <th>Vị trí</th>
                    <th>Ngày tạo</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $v)
                <tr class="odd " id="post-<?php echo $v->id; ?>">
                    <td class="whitespace-nowrap text-left">
                        {{$v->title}}
                    </td>
                    @include('components.order',['module' => $module])
                    <td class="whitespace-nowrap">
                        {{$v->created_at}}
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="{{ route('customer_levels.index',['id'=>$v->id]) }}">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                Edit
                            </a>
                            <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
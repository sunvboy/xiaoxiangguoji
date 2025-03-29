@extends('dashboard.layout.dashboard')
@section('title')
<title>Cấu hình đơn hàng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Cấu hình đơn hàng",
        "src" => route('orders.config'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Cấu hình đơn hàng
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap text-center">ID</th>
                        <th class="whitespace-nowrap">Tiêu đề</th>
                        <th class="whitespace-nowrap">Vị trí</th>
                        <th class="whitespace-nowrap">Hiển thị</th>
                        <th class="whitespace-nowrap ">#</th>
                    </tr>
                </thead>
                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$v->id}}
                        </td>
                        <td>
                            {{$v->title}}
                        </td>
                        @include('components.order',['module' => 'order_configs'])
                        <td>
                            @include('components.publishTable',['module' => 'order_configs','title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td class="">
                            @can('orders_edit')
                            <a class="flex items-center mr-3" href="{{ route('orders.configEdit',['id'=>$v->id]) }}">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                Edit
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
</div>
@endsection
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
    <div class="grid grid-cols-12 gap-6 ">
        <div id="data_product" class="col-span-12 overflow-auto lg:overflow-visible">
            <!-- BEGIN: Data List -->
            <div class="">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th style="width:300px;">Tiêu đề</th>
                        </tr>
                    </thead>
                    <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($data as $v)
                        <tr class="odd " id="post-<?php echo $v->id; ?>">
                            <td>
                                <?php echo $v->name; ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
                {{$data->links()}}
            </div>
            <!-- END: Pagination -->
        </div>
    </div>
</div>
@endsection
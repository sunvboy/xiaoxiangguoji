@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách trả hàng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách trả hàng",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class="mt-10 space-y-3 box p-5">
        <div class="flex justify-between ">
            <h1 class=" text-lg font-medium ">
                Danh sách trả hàng
            </h1>

        </div>
        <div class="">
            <form action="" class="" id="search" style="margin-bottom: 0px;">
                <div class="grid grid-cols-12 gap-2 flex-wrap">
                    @if(!empty($listUsers))
                    <div class="flex-auto col-span-2">
                        <?php echo Form::select('user_id', $listUsers, request()->get('user_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    @endif
                    @if(!empty($listAddress))
                    <div class="flex-auto col-span-2">
                        <?php echo Form::select('address_id', $listAddress, request()->get('address_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    @endif
                    @if(!empty($listSuppliers))
                    <div class="flex-auto col-span-2">
                        <?php echo Form::select('suppliers_id', $listSuppliers, request()->get('suppliers_id'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
                    </div>
                    @endif
                    <div class="flex-auto col-span-2">
                        <?php echo Form::text('date', request()->get('date'), ['class' => 'form-control', 'style' => 'height:42px']); ?>
                    </div>
                    <div class="flex col-span-4 justify-between gap-2">
                        <input type="search" name="keyword" class="keyword form-control" placeholder="Tìm kiếm theo mã đơn nhập hàng, tên, email, số điện thoại nhà cung cấp ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
                        <button class="btn btn-primary">
                            <i data-lucide="search"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-3">

        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <!-- <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th> -->
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Mã đơn</th>
                        <th class="whitespace-nowrap">Tên nhà cung cấp</th>
                        <th class="whitespace-nowrap">Chi nhánh</th>
                        <th class="whitespace-nowrap">Số lượng hoàn</th>
                        <th class="whitespace-nowrap">Tổng tiền hoàn</th>
                        <th class="whitespace-nowrap">Nhân viên tạo</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                        <th class="whitespace-nowrap text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <!-- <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td> -->
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <a target="_blank" href="{{route('product_purchases.show',['id'=>$v->product_purchases_id])}}" class="text-danger font-bold">{{$v->code}}</a>
                        </td>
                        <td>
                            {{$v->suppliers}}
                        </td>
                        <td>
                            {{$v->address_title}}
                        </td>
                        <td>
                            {{$v->quantity}}
                        </td>
                        <td class="font-bold">
                            {{number_format($v->price_total,'0',',','.')}}
                        </td>
                        <td>
                            {{$v->name}}
                        </td>
                        <td>
                            {{$v->created_at}}
                        </td>
                        <td>
                            <a class="flex items-center text-danger" href="{{route('product_purchases.return_show',['id'=>$v->id])}}">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Xem chi tiết
                            </a>
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
@push('javascript')
<script type="text/javascript" src="{{asset('library/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('library/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/daterangepicker/daterangepicker.css')}}" />
<script type="text/javascript">
    $(function() {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " to "
            }
        });
    });
</script>
@endpush
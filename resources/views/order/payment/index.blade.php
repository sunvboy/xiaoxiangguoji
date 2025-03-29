@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách đơn hàng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đơn hàng",
        "src" => route('orders.index'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách đơn hàng
    </h1>

    <form action="" class="grid grid-cols-12 gap-1 space-x-2  mt-5" id="search" style="margin-bottom: 0px;">
        <div class="col-span-3">
            <?php echo Form::text('date', request()->get('date'), ['class' => 'form-control',  'autocomplete' => 'off']); ?>
        </div>
        <div class="col-span-3 flex">
            <button class="btn btn-primary btn-sm">
                <i data-lucide="search"></i>
            </button>
        </div>
    </form>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>

                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Cổng thanh toán</th>
                        <th class="whitespace-nowrap">Thông tin</th>
                        <th class="whitespace-nowrap">Thông tin giao dịch</th>
                        <th class="whitespace-nowrap">Số tiền thanh toán</th>
                        <th class="whitespace-nowrap">Trạng thái</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                    </tr>
                </thead>

                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                    <?php $jsonData = json_decode($v->json, TRUE); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            {{$v->type}}
                        </td>
                        <td>
                            <a href="{{route('orders.edit',['id'=>$v->order_id])}}">
                                <p class="text-danger font-bold"><b>CODE:</b> #<?php echo $v->getOrder->code; ?></p>
                                <p><?php echo $v->getOrder->fullname; ?></p>
                                <p><?php echo $v->getOrder->phone; ?></p>
                            </a>
                        </td>
                        <td style="box-shadow: 0px 0px 0px transparent !important;">
                            Mã giao dịch ghi nhận tại hệ thống đối tác: <b>{{$v->transId}}</b><br>
                            @if($v->type == 'VNPAY')
                            Mã Ngân hàng thanh toán: <b>{{$jsonData['vnp_BankCode']}}</b><br>
                            Mã giao dịch tại Ngân hàng: <b>{{$jsonData['vnp_BankTranNo']}}</b><br>
                            Loại tài khoản/thẻ khách hàng sử dụng: <b>{{$jsonData['vnp_CardType']}}</b><br>
                            @else
                            Loại tài khoản/thẻ khách hàng sử dụng: <b>{{$jsonData['payType']}}</b><br>
                            @endif
                        </td>
                        <td>
                            @if($v->type == 'VNPAY')
                            {{number_format($jsonData['vnp_Amount']/100)}}
                            @else
                            {{number_format($jsonData['amount'])}}
                            @endif
                        </td>
                        <td>
                            <?php echo $status[$v->status] ?>
                        </td>
                        <td>
                            {{$v->created_at}}
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
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">
<script>
    $(document).on('change', '.tom-select-custom', function() {
        var id = $(this).attr('data-id');
        var status = $(this).val();
        var classA = 'wait';
        $.ajax({
            type: 'POST',
            url: "{{route('orders.ajaxUploadStatus')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status: status
            },
            success: function(data) {

                if (status == 'wait') {
                    classA = 'wait';
                } else if (status == 'pending') {
                    classA = 'pending';
                } else if (status == 'transported') {
                    classA = 'transported';
                } else if (status == 'completed') {
                    classA = 'completed';
                } else if (status == 'canceled') {
                    classA = 'canceled';
                }
                console.log(classA);
                $('.text-center-' + id).attr('class', 'text-center-' + id +
                    ' text-center text-center-a mb-3 ' + classA);

                toastr.success('Cập nhập đơn hàng thành công', 'Thông báo!')
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error('Cập nhập đơn hàng không thành công', 'Error!')
            },
        });

    });
</script>
<style>
    .table_product td,
    .table_product th {
        vertical-align: middle;
        border: 1px solid #e5e5e5 !important;
        border-bottom-color: rgb(229, 229, 229);
        border-bottom-style: solid;
        border-bottom-width: 1px;
        box-shadow: 0px 0px 0px transparent !important;
    }

    table td,
    table th {
        width: inherit;
    }
</style>
<style>
    .pending .ts-input {
        background: #f8dda7;
        color: #94660c;
    }

    .completed .ts-input {
        background: #c6e1c6;
        color: #5b841b;
    }

    .transported .ts-input {
        background: #8f8c8c;
        color: #e5e5e5;
    }

    .canceled .ts-input {
        background: red;
        color: #fff;
    }
</style>
@endpush
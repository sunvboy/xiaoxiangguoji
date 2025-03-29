@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách đặt thuốc online</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đặt thuốc online",
        "src" => route('order_onlines.index'),
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
    <form action="" class="grid grid-cols-12 gap-2 mt-5" id="search" style="margin-bottom: 0px;">
        @can('order_onlines_destroy')
        <div class="col-span-2">
            <select class="form-control ajax-delete-all  h-10" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
                <option>Hành động</option>
                <option value="">Xóa</option>
            </select>
        </div>
        @endcan

        <div class="col-span-6 ">
            <input type="search" name="keyword" class="keyword form-control filter w-full h-10" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">

        </div>
        <div class="col-span-2 flex items-center space-x-2 justify-end">
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
                        @can('order_onlines_destroy')
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        @endcan

                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Thông tin</th>
                        <th class="whitespace-nowrap">Sản phẩm</th>
                        <th class="whitespace-nowrap">Nội dung</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                        <th class="whitespace-nowrap">Trạng thái</th>
                        <th class="whitespace-nowrap text-center">#</th>
                    </tr>
                </thead>

                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                        <?php
                        if ($v->status == 'wait') {
                            $class = 'btn-secondary';
                        } else if ($v->status == 'pending') {
                            $class = 'btn-pending';
                        } else if ($v->status == 'transported') {
                            $class = 'btn-warning';
                        } else if ($v->status == 'completed') {
                            $class = 'btn-success';
                        } else if ($v->status == 'canceled') {
                            $class = 'btn-danger';
                        } else  {
                            $class = 'bg-primary text-white';
                        }
                        ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        @can('order_onlines_destroy')
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        @endcan
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <p><?php echo $v->name; ?></p>
                            <p><?php echo $v->phone; ?></p>
                        </td>
                        <td style="box-shadow: 0px 0px 0px transparent !important;">
                            <?php $cart = json_decode($v->products, TRUE); ?>
                            <table class="table_product">
                                <tbody>
                                    <?php $total = 0 ?>
                                    @if($cart)
                                    @foreach( $cart as $k=>$item)
                                    <tr>
                                        <td><span class="text-danger font-bold">{{$item['title']}}</span></td>
                                        <td><strong>SL:</strong> {{$item['quantity']}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <div style="max-width: 200px;">
                                {{$v->message}}
                            </div>
                        </td>
                        <td>
                            {{$v->created_at}}
                        </td>
                        <td>
                                <div class="text-center text-center-{{$v->id}} mb-3 ">
                                    <select class="form-control tom-select tom-select-custom {{$class}} js_change_select_status" data-id="{{$v->id}}">
                                        @foreach(config('cart.status') as $l=>$val)
                                            <option value="{{$l}}" <?php if ($v->status == $l) { ?>selected<?php } ?>>
                                                {{$val}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        </td>

                        <td class="">
                            <div class="flex justify-center items-center">
                                @can('order_onlines_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa đơn hàng, đơn hàng sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript">
    $(function() {
        $('input[name="date_start"]').datetimepicker({
            format: 'Y-m-d',
        });
        $('input[name="date_end"]').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">

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
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">
<script>
    $(document).on('change', '.js_change_select_status', function() {
        var id = $(this).attr('data-id');
        var status = $(this).val();
        var classA = 'wait';
        $.ajax({
            type: 'POST',
            url: "{{route('order_onlines.ajaxUploadStatus')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status: status
            },
            success: function(data) {
                if (status == 'wait') {
                    classA = 'btn-secondary';
                } else if (status == 'pending') {
                    classA = 'btn-pending';
                } else if (status == 'transported') {
                    classA = 'btn-warning';
                } else if (status == 'completed') {
                    classA = 'btn-success';
                } else if (status == 'canceled') {
                    classA = 'btn-danger';
                }else{
                    classA = 'btn-primary';
                }
                console.log(classA);
                $('.text-center-' + id).attr('class', 'text-center-' + id + ' text-center text-center-a mb-3 ' + classA);
                toastr.success('Cập nhập đơn hàng thành công', 'Thông báo!')
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error('Cập nhập đơn hàng không thành công', 'Error!')
            },
        });

    });
</script>
@endpush

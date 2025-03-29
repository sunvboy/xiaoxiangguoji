@extends('homepage.layout.home')
@section('content')

<div class="ps-page--product ps-page--product1 page-infomation page-infomation-2 pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="url('/')">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void(0)">Đặt thuốc online</a></li>

        </ul>
        <div class="content-infomation">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    @include('customer/frontend/auth/common/sidebar')
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="">
                        <div class="content-tab-information">
                            <table style="margin-top: 0px;">
                                <tbody>
                                    <tr>
                                        <td>STT</td>
                                        <td>Thông tin</td>
                                        <td>Sản phẩm</td>
                                        <td>Ngày đặt</td>
                                    </tr>
                                    @if(!empty($data))
                                    @foreach($data as $item)
                                    <?php $cart = json_decode($item->products, TRUE); ?>
                                    <tr>
                                        <td> {{$data->firstItem()+$loop->index}}</td>
                                        <td>
                                            <p style="margin-bottom: 0px;">Họ và tên: {{$item->name}}</p>
                                            <p style="margin-bottom: 0px;">Số điện thoại: {{$item->phone}}</p>
                                            <p style="margin-bottom: 0px;">Ghi chú: {{!empty($item->message)?$item->message:'-'}}</p>
                                        </td>
                                        <td>
                                            @if($cart)
                                            @foreach($cart as $k=>$val)
                                            <div>
                                                <span style="color:#333369;    text-decoration: underline;">{{$val['title']}}</span> x {{$val['quantity']}}
                                            </div>
                                            @endforeach
                                            @endif

                                        </td>
                                        <td>{{$item->created_at}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="ps-pagination">
                                @include('homepage.common.pagination', ['paginator' => $data, 'interval' => 2])
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>




</div>



@endsection
@push('javascript')
<script type="text/javascript" src="{{asset('library/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('library/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/daterangepicker/daterangepicker.css')}}">
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
<link href="{{asset('library/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('library/sweetalert/sweetalert.min.js')}}"></script>
<style>
    /* .menu_order.active {
        border-bottom: 1px solid red;
        color: red;
        font-weight: bold;
    } */
</style>
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.menu_order').filter(function() {
        return $(this).prop('href') === aurl;
    }).parent().addClass('active');
    $(".menu_item_auth:eq(3)").addClass('active');
</script>
@endpush
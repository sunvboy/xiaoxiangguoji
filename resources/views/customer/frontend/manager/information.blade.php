@extends('homepage.layout.home')
@section('content')
<div class="ps-page--product ps-page--product1 page-infomation pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active"><a href="{{route('customer.updateInformation')}}">{{$seo['meta_title']}}</a></li>

        </ul>
        <div class="content-infomation">

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    @include('customer/frontend/auth/common/sidebar')
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="content-information-1  bg-white">
                        <h2 class="title-2">{{$seo['meta_title']}}</h2>
                        <div class="img">
                            <img src="{{asset('frontend/img/avatar-profile.svg')}}" alt="">
                        </div>
                        <div class="form">

                            <div class="nav-form">
                                <ul>
                                    <li>
                                        <span class="span-1">Họ và tên:</span>
                                        <span class="span-2">{{$detail->name}}</span>
                                    </li>
                                    <li>
                                        <span class="span-1">Số điện thoại:</span>
                                        <span class="span-2">{{$detail->phone}}</span>
                                    </li>
                                    <li>
                                        <span class="span-1">Email:</span>
                                        <span class="span-2">{{$detail->email}}</span>
                                    </li>
                                    <li>
                                        <span class="span-1">Ngày sinh:</span>
                                        <span class="span-2">{{!empty($detail->birthday) ? \Carbon\Carbon::createFromFormat('Y-m-d', $detail->birthday)->format('d/m/Y') : ''}}</span>
                                    </li>
                                    <li>
                                        <span class="span-1">Địa chỉ:</span>
                                        <span class="span-2">{{$detail->address}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="change-information change-information-1">
                            <button>Thay đổi thông tin</button>
                        </div>
                        <form id="form-information" class="content-change-information">
                            @csrf
                            <div>
                                <div class="alert alert-danger" style="display: none;">

                                </div>
                                <div class="alert alert-success" style="display: none;">

                                </div>
                            </div>
                            <div class="item-child">
                                <label for="">Họ và tên</label>
                                <input type="text" name="name" value="{{$detail->name}}">
                            </div>
                            <div class="item-child">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" value="{{$detail->phone}}">
                            </div>
                            <div class="item-child">
                                <label for="">Email</label>
                                <input type="text" name="email" value="{{$detail->email}}" disabled>
                            </div>
                            <div class="item-child">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="address" value="{{$detail->address}}">
                            </div>
                            <div class="item-sex">
                                <label for="">Giới tính</label>
                                <ul>
                                    <li>
                                        <input type="radio" name="gender" value="male" @if($detail->gender == 'male') checked @endif>Nam
                                    </li>
                                    <li>
                                        <input type="radio" name="gender" value="female" @if($detail->gender == 'female') checked @endif>Nữ
                                    </li>
                                </ul>
                            </div>
                            <div class="item-child">
                                <label for="">Ngày sinh</label>
                                <input type="date" name="birthday" value="{{$detail->birthday}}">
                            </div>
                            <div class="change-information">
                                <button type="submit" class="js_submit_information">Cập nhật thông tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script>
    $(document).ready(function() {
        $(".js_submit_information").click(function(e) {
            e.preventDefault();
            var _token = $("#form-information input[name='_token']").val();
            var name = $("#form-information input[name='name']").val();
            var phone = $("#form-information input[name='phone']").val();
            var address = $("#form-information input[name='address']").val();
            var gender = $("#form-information input[name='gender']").val();
            var birthday = $("#form-information input[name='birthday']").val();
            $.ajax({
                url: "<?php echo route('customer.updateInformation') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    name: name,
                    phone: phone,
                    address: address,
                    birthday: birthday,
                    gender: gender,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-information .alert-danger").css('display', 'none');
                        $("#form-information .alert-success").css('display', 'block');
                        $("#form-information .alert-success").html("<?php echo trans('index.InformationSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-information .alert-danger").css('display', 'block');
                        $("#form-information .alert-success").css('display', 'none');
                        $("#form-information .alert-danger").html(data.error);
                    }
                }
            });
        });
    });
</script>

@endpush
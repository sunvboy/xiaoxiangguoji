@extends('homepage.layout.home')
@section('content')
<div class="ps-page--product ps-page--product1 pb-120 bg-gray">
    <div id="main" class="wrapper main-login main-register">
        <div class="container">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
                <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">{{$seo['meta_title']}}</a></li>
            </ul>
            <div class="content-main-login">
                <h3 class="title-1">{{$seo['meta_title']}}</h3>
                <div class="login-left  bg-white">
                    <form action="{{route('customer.login-store')}}" method="POST" id="form-auth">
                        <div>
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                        </div>
                        <div class="item">
                            <label for="">Số điện thoại hoặc email</label>
                            <input type="text" name="phone" placeholder="Số điện thoại hoặc email" value="{{old('phone')}}" required>

                        </div>
                        <div class="item">
                            <label for="">Mật khẩu</label>
                            <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                        </div>
                        <div class="item">
                            <a href="{{route('customer.reset-password')}}" class="d-flex justify-content-end" style="color:#022da4">Quên mật khẩu?</a>
                        </div>
                        <div class="btn-login" style="margin-top: 0px;">
                            <button type="submit" class="btn-submit-contact">Đăng Nhập</button>
                        </div>
                        <div class="item" style="padding-top: 20px;">
                            Bạn chưa có tài khoản? <a href="{{route('customer.register')}}" style="color:#022da4">Đăng ký ngay</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>

@endsection
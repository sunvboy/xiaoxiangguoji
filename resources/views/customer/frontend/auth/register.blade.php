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
                    <form action="{{route('customer.register-store')}}" method="POST" id="form-auth">
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
                            <label for="">Họ và tên</label>
                            <input type="text" name="name" placeholder="Họ và tên" value="{{old('name')}}" required>

                        </div>
                        <div class="item">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}" required>
                        </div>
                        <div class="item">
                            <label for="">Email</label>
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}" required>
                        </div>
                        <div class="item">
                            <label for="">Địa chỉ</label>
                            <input type="text" name="address" placeholder="Địa chỉ" value="{{old('address')}}">
                        </div>
                        <div class="item">
                            <label for="">Mật khẩu</label>
                            <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                        </div>
                        <div class="item">
                            <label for="">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu của bạn" required>
                        </div>
                        <p class="note"><input type="checkbox" required>{{strip_tags($page->description)}}</p>
                        <div class="btn-login">
                            <button type="submit" class="btn-submit-contact">Đăng Ký</button>
                        </div>
                        <div class="item" style="padding-top: 20px;">
                            Bạn chưa đã tài khoản? <a href="{{route('customer.login')}}" style="color:#022da4">Đăng nhập ngay</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>
@endsection
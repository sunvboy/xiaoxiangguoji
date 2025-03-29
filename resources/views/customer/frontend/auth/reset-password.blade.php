@extends('homepage.layout.home')
@section('content')
<div class="ps-page--product ps-page--product1 pb-120 bg-gray">
    <div id="main" class="wrapper main-login main-register">
        <div class="container">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
                <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">Quên mật khẩu</a></li>
            </ul>
            <div class="content-main-login">
                <h3 class="title-1">Quên mật khẩu</h3>
                <div class="login-left  bg-white">
                    <form action="" method="POST" id="form-auth">
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
                            <label for="">Hãy nhập số điện Email của bạn vào bên dưới để bắt đầu quá trình khôi phục mật khẩu.</label>
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}" required>
                        </div>


                        <div class="btn-login" style="margin-top: 0px;">
                            <button id="submit-auth" type="submit" class="btn-submit-contact">{{trans('index.ForgotPasswordSend')}}</button>
                            <button id="submit-auth-loading" type="button" class="btn-submit-contact">Loading...</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script>
    $(function() {
        $('#submit-auth-loading').hide();
        $("#form-auth").submit(function(event) {
            $('#submit-auth').hide();
            $('#submit-auth-loading').show();
        });
    })
</script>
@endpush
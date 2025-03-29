@extends('homepage.layout.home')
@section('content')

{!!htmlBreadcrumb(trans('index.LoginAccount'))!!}
<main class="py-8">
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-center">
            <div class="w-[580px] max-w-full bg-[#f4f6f8] p-6 rounded-xl">
                <div class="flex border-b border-[#eee]">
                    <div class="w-1/2 text-center">
                        <a href="{{route('customer.login')}}" class="font-bold uppercase h-[50px] leading-[50px] border-b  float-left w-full border-primary">{{trans('index.Login')}}</a>
                    </div>
                    <div class="w-1/2 text-center border-l border[#eee] ">
                        <a href="{{route('customer.register')}}" class="font-semibold uppercase h-[50px] leading-[50px] float-left w-full ">{{trans('index.Register')}}</a>
                    </div>
                </div>
                <div class="text-center py-[10px] text-f14 ">
                    <?php /*{{trans('index.PleaseEmailPassword')}} {{$fcSystem['homepage_brandname']}}*/ ?>
                </div>
                <form action="{{route('customer.login-store')}}" method="POST" id="form-auth">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative mt-2" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">
                            {{session('success')}}
                        </span>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-2" role="alert">
                        <strong class="font-bold">ERROR!</strong>
                        <span class="block sm:inline">
                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </span>
                    </div>
                    @endif
                    <div class="mt-2 space-y-2">
                        <label class="font-bold text-f14">{{trans('index.Phone')}}<span class="text-f13 text-red-600">*</span></label>
                        <input type="text" class="border w-full h-11 px-3 focus:outline-none hover:outline-none rounded-lg" name="phone" value="{{old('phone')}}" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="mt-5 space-y-2">
                        <label class="font-bold text-f14">{{trans('index.Password')}}<span class="text-f13 text-red-600">*</span></label>
                        <input type="password" class="border w-full h-11 px-3 focus:outline-none hover:outline-none rounded-lg" name="password" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="flex mt-5 justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" name="remember" type="checkbox" value="1" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                            </div>
                            <label for="remember" class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.rememberLogin')}}</label>
                        </div>
                        <a href="{{route('customer.reset-password')}}" class="text-blue-700 font-bold" title="{{trans('index.ForgotPassword')}}?">{{trans('index.ForgotPassword')}}?</a>
                    </div>
                    <div class="mt-5 flex justify-center">
                        <button type="submit" class="btn-submit-contact py-4 px-1 md:px-8 rounded-lg block bg-primary  text-white transition-all leading-none text-f15 font-bold"> {{trans('index.Login')}}</button>
                    </div>
                    <div class="mt-5 ">
                        @if (config('app.locale') == 'vi')
                        <p class="text-f16 text-center leading-6">
                            <span>Bạn chưa có tài khoản?</span>
                            Nhấn vào đây để <a href="{{route('customer.register')}}" class="text-blue-700 underline">đăng ký</a><br>
                        </p>
                        @else
                        <p class="text-f16 text-center leading-6">
                            <span>New customer?</span>
                            <a href="{{route('customer.register')}}" class="text-blue-700 underline">Create an account</a><br>Create wholesale account
                        </p>
                        @endif
                    </div>
                    <?php /*<div class="mt-5 text-f13 flex justify-center leading-4"><?php echo $page->description ?></div>
                    <div class="flex justify-center mt-3">
                        <span class="rounded-full border border-gray-300 px-3 py-1 text-f12">hoặc đăng nhập qua</span>
                    </div>
                    @include('customer.frontend.auth.common.social')*/ ?>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
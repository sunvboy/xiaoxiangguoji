@extends('homepage.layout.home')
@section('content')

{!!htmlBreadcrumb(trans('index.ForgotPassword'))!!}
<main class="py-8">
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-center">
            <div class="w-[580px] max-w-full bg-[#f4f6f8] p-6 rounded-xl">
                <div class="flex border-b border-[#eee]">
                    <div class="w-1/2 text-center">
                        <a href="{{route('customer.login')}}" class="font-semibold uppercase h-[50px] leading-[50px] float-left w-full">{{trans('index.Login')}}</a>
                    </div>
                    <div class="w-1/2 text-center border-l border[#eee]">
                        <a href="{{route('customer.register')}}" class="font-semibold uppercase h-[50px] leading-[50px] float-left w-full ">{{trans('index.Register')}}</a>
                    </div>
                </div>
                <div class="text-center py-[10px] text-f14">
                    {{trans('index.ForgotPasswordInfo')}}
                </div>
                <form action="" method="POST" id="form-auth">
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
                        <label class="font-bold text-f14">Email<span class="text-f13 text-red-600">*</span></label>
                        <input type="text" class="  border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  rounded-lg" name="email" aria-describedby="emailHelp" placeholder="Email">
                    </div>
                    <div class="mt-5 flex justify-center">
                        <button id="submit-auth" type="submit" class="btn-submit-contact py-4 px-1 md:px-8 rounded-lg block bg-global  text-white transition-all leading-none text-f15 font-bold">{{trans('index.ForgotPasswordSend')}}</button>
                        <button id="submit-auth-loading" type="button" class="btn-submit-contact py-4 px-1 md:px-8 rounded-lg block bg-global  text-white transition-all leading-none text-f15 font-bold">Loading...</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</main>
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
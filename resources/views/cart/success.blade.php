@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($page->title)!!}
<div class="py-9 bg-[#edf0f3]">
    <div class="container">
        <div class="max-w-[448px] mx-auto flex flex-col justify-center">
            <div>
                <img src="{{asset($fcSystem['cart_0'])}}" alt="Đặt hàng thành côn" class="mx-auto" style="margin-bottom: 20px">
            </div>
            <div class="p-4 bg-[#fff] rounded-2xl flex flex-col justify-center items-center space-y-5">
                <h3 class="text-[#022da4] font-bold text-[20px]  mb-0">Đặt hàng thành công</h3>
                <div class="text-[16px] text-center">
                    <?php echo $fcSystem['cart_1']?>
                </div>
                <a href="{{url('/')}}" class="ps-btn ps-btn--warning flex w-auto">Về trang chủ</a>

            </div>

        </div>
    </div>
</div>

@endsection

@push('css')
<link href="{{asset('frontend/css/app.css')}}" rel="stylesheet" async>

<style>
    .breadcrumb {
        margin-bottom: 0px !important;
    }
</style>
@endpush
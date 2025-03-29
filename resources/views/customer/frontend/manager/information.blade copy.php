@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb(trans('index.AccountInformation'))!!}
<main class="pb-20">
    <div class="container px-4 mx-auto">
        <div class="mt-4 flex flex-col md:flex-row items-start md:space-x-4">
            @include('customer/frontend/auth/common/sidebar')
            <div class="flex-1 w-full md:w-auto order-1 md:order-2">
                <div class="overflow-x-hidden shadowC rounded-xl">
                    <div class="md:p-6 bg-white ">
                        <h1 class="text-black font-bold text-xl">{{trans('index.AccountInformation')}}</h1>
                        <div class="relative py-3">
                            <ul class="ul-tab flex items-center gap-5">
                                <li class="py-2 tab-profile active"><a href="javascript:void(0)" onclick="tabCustomer('profile')">{{trans('index.AccountInformation')}}</a></li>
                                <li class="py-2 tab-change-password"><a href="javascript:void(0)" onclick="tabCustomer('change-password')">{{trans('index.Password')}}</a></li>
                            </ul>
                        </div>
                        <div id="tab-profile" class="tab-box active">
                            <form id="form-information">
                                @csrf
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">
                                    <strong class="font-bold">ERROR!</strong>
                                    <span class="block sm:inline"></span>
                                </div>
                                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">
                                    <div class="flex items-center mb-">
                                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4 mt-4">
                                    <div class="col-span-2">
                                        <span class="font-bold text-xs mb-1 block">Email</span>
                                        <input autocomplete="off" disabled="" inputmode="text" type="text" value="{{$detail->email}}" class="w-full border border-gray-300 rounded-md cursor-not-allowed px-4 h-12 bg-gray-200">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">Lớp học<span class="text-f13 text-red-600">*</span></span>
                                        <select disabled class="w-full border border-gray-300 rounded-md cursor-not-allowed px-4 h-12" name="catalogue_id">
                                            @if(!empty($category))
                                            @foreach($category as $key=>$item)
                                            <option value="{{$key}}" @if($detail->catalogue_id == $key) selected @endif>{{$item}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">Cấp Bậc<span class="text-f13 text-red-600">*</span></span>
                                        <?php echo Form::select('level', $customer_levels, $detail->level, ['class' => 'w-full border border-gray-300 rounded-md  px-4 h-12', 'placeholder' => '']); ?>

                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.Fullname')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="text" name="name" value="{{$detail->name}}" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">Trường học</span>
                                        <input autocomplete="off" type="text" name="school" value="{{$detail->school}}" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.Phone')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="text" name="phone" value="{{$detail->phone}}" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">Giới tính</span>
                                        <select class="w-full border border-gray-300 rounded-md cursor-not-allowed px-4 h-12" name="gender">
                                            <option value="male" @if($detail->gender == 'male') selected @endif>Nam</option>
                                            <option value="female" @if($detail->gender == 'female') selected @endif>Nữ</option>
                                        </select>
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">Ngày sinh</span>
                                        <input autocomplete="off" type="text" name="birthday" value="{{$detail->birthday}}" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.Address')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="text" name="address" value="{{$detail->address}}" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2  gap-4 mt-6">
                                    <button class="js_submit_information font-bold h-12 w-full text-white bg-global flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px]">
                                        {{trans('index.SaveChanges')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="tab-change-password" class="tab-box hidden">
                            <form id="form-password">
                                @csrf
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">
                                    <strong class="font-bold">ERROR!</strong>
                                    <span class="block sm:inline"></span>
                                </div>
                                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">
                                    <div class="flex items-center mb-">
                                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.CurrentPassword')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="password" name="current_password" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.ANewPassword')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="password" name="old_password" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs mb-1 block">{{trans('index.ConfirmNewPassword')}}<span class="text-f13 text-red-600">*</span></span>
                                        <input autocomplete="off" type="password" name="new_password" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-6">
                                    <button class="js_submit_password font-bold h-12 w-full text-white bg-global flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px]">
                                        {{trans('index.SaveChanges')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script type="text/javascript">
    $(function() {

        $('input[name="birthday"]').datetimepicker({

            format: 'Y-m-d',

        });


    });
</script>
<script>
    function tabCustomer(e) {
        $('.ul-tab li').removeClass('active');
        $('.ul-tab li.tab-' + e).removeClass('hidden').addClass('active');
        $('.tab-box').removeClass('active').addClass('hidden');
        $('#tab-' + e).addClass('active').removeClass('hidden');
    }
</script>
<style type="text/css">
    .ul-tab .active {
        color: rgba(0, 101, 238, 1);
        border-bottom: 2px solid rgba(0, 101, 238, 1);
        font-weight: 700
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".js_submit_information").click(function(e) {
            e.preventDefault();
            var _token = $("#form-information input[name='_token']").val();
            var name = $("#form-information input[name='name']").val();
            var phone = $("#form-information input[name='phone']").val();
            var address = $("#form-information input[name='address']").val();
            var catalogue_id = $("#form-information select[name='catalogue_id']").val();
            var level = $("#form-information select[name='level']").val();
            var gender = $("#form-information select[name='gender']").val();
            var birthday = $("#form-information input[name='birthday']").val();
            var school = $("#form-information input[name='school']").val();
            $.ajax({
                url: "<?php echo route('customer.updateInformation') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    name: name,
                    phone: phone,
                    address: address,
                    catalogue_id: catalogue_id,
                    birthday: birthday,
                    gender: gender,
                    level: level,
                    school: school,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-information .print-error-msg").css('display', 'none');
                        $("#form-information .print-success-msg").css('display', 'block');
                        $("#form-information .print-success-msg span").html("<?php echo trans('index.InformationSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-information .print-error-msg").css('display', 'block');
                        $("#form-information .print-success-msg").css('display', 'none');
                        $("#form-information .print-error-msg span").html(data.error);
                    }
                }
            });
        });
    });
    $(document).ready(function() {
        $(".js_submit_password").click(function(e) {
            e.preventDefault();
            var _token = $("#form-password input[name='_token']").val();
            var current_password = $("#form-password input[name='current_password']").val();
            var old_password = $("#form-password input[name='old_password']").val();
            var new_password = $("#form-password input[name='new_password']").val();
            $.ajax({
                url: "<?php echo route('customer.storeChangePassword') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    current_password: current_password,
                    old_password: old_password,
                    new_password: new_password,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-password .print-error-msg").css('display', 'none');
                        $("#form-password .print-success-msg").css('display', 'block');
                        $("#form-password .print-success-msg span").html("<?php echo trans('index.PasswordSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-password .print-error-msg").css('display', 'block');
                        $("#form-password .print-success-msg").css('display', 'none');
                        $("#form-password .print-error-msg span").html(data.error);
                    }
                }
            });
        });
    });
</script>
@endpush
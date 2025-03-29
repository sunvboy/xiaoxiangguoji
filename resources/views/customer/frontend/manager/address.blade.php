@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb(trans('index.ContactInformation'))!!}
<main>
    <div class="container px-4 mx-auto">
        <div class="mt-4 flex flex-col md:flex-row items-start md:space-x-4">
            @include('customer/frontend/auth/common/sidebar')
            <div class="flex-1 overflow-x-hidden shadowC rounded-xl w-full md:w-auto order-1 md:order-2">
                <div class="md:p-6 bg-white">
                    <h1 class="text-black font-bold text-xl">{{trans('index.ContactInformation')}}</h1>
                    @if(!$data->isEmpty())
                    <div>
                        <div class="mt-4">
                            <button class="flex font-extrabold text-red-500 text-h3 items-center" onclick="showModalAddress()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="ml-2">{{trans('index.AddNewAddress')}}</span>
                            </button>
                        </div>
                        <ul class="flex flex-col space-y-3 mt-4">
                            @foreach($data as $item)
                            <li>
                                <div class="section-address-item p-4 bg-white rounded-xl border border-gray-40">
                                    <div class="flex items-center justify-between">
                                        <span class="text-body text-black font-bold break-all">
                                            {{$item->name}}, {{$item->phone}}
                                        </span>
                                        <div>
                                            <button class="text-ui text-blue-500 font-bold ml-2 js_handle_edit" data-id="{{$item->id}}"> {{trans('index.Edit')}} </button>
                                            <button class="text-ui text-red-500 font-bold ml-2 js_handle_delete" data-id="{{$item->id}}"> {{trans('index.Delete')}} </button>
                                        </div>
                                    </div>
                                    <div class="mt-1 text-body font-normal">
                                        <span class="text-black">
                                            {{$item->address}} - {{$item->ward_name->name}} - {{$item->district_name->name}} - {{$item->city_name->name}}
                                        </span>
                                    </div>
                                    @if(!empty($item->publish))
                                    <div class="mt-1 text-xs">
                                        <span class="inline-block py-1 px-2 bg-blue-500 text-white rounded">
                                            {{trans('index.DefaultAddress')}}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                    <div>
                        <section class="pt-8 flex flex-col items-center">
                            <div class="max-w-screen-mobile">
                                <div class="flex flex-col items-center space-y-3">
                                    <button class="bg-gray-100 rounded-full flex items-center justify-center w-[50px] h-[50px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-global" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                    </button>
                                    <span class="block text-body font-bold">{{trans('index.NoAddress')}}</span>
                                    <span class="text-sm">
                                        {{trans('index.PleaseAddAddress')}}
                                    </span>
                                </div>
                                <button class="font-bold h-12 w-full text-white bg-global flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px] mt-5" onclick="showModalAddress()">
                                    {{trans('index.AddNewAddress')}}
                                </button>
                            </div>
                        </section>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@push('javascript')
<link href="{{asset('library/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('library/sweetalert/sweetalert.min.js')}}"></script>
<!-- Main modal -->
<div id="createAddress-modal" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full  flex justify-center items-center " style="background: #808080cc">
    <div class="relative p-4 h-full md:h-auto w-[790px]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" onclick="showModalAddress()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form id="form-addAddress" class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" action="">
                <h3 class="text-black font-bold text-xl">{{trans('index.AddressInformation')}}</h3>
                @csrf
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg text-sm" style="display: none">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline"></span>
                </div>
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg text-sm" style="display: none">
                    <div class="flex items-center">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold"></span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.Fullname')}}</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.Phone')}}</label>
                        <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="cityID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.City')}}</label>

                        <?php
                        echo Form::select('city_id', $listCity, !empty(old('city_id')) ? old('city_id') : '', ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'city']);
                        ?>
                    </div>
                    <div>
                        <label for="districtID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.District')}}
                        </label>
                        <?php
                        echo Form::select('district_id', [], old('district_id'), ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'district', 'placeholder' => 'Quận/Huyện']);
                        ?>
                    </div>
                    <div>
                        <label for="wardID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.Ward')}}</label>
                        <?php
                        echo Form::select('ward_id', [], old('ward_id'), ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'ward', 'placeholder' => 'Phường/Xã']);
                        ?>
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{trans('index.DeliveryAddress')}}
                        </label>
                        <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Ví dụ: 1205 E1, Gold Park, 122, Phố Trung Kính">
                    </div>
                </div>
                <div class="flex items-center w-full mb-12">
                    <label for="toogleA" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input id="toogleA" type="checkbox" class="sr-only" name="publish" value="1" />
                            <!-- line -->
                            <div class="w-10 h-[24px] bg-gray-400 rounded-full shadow-inner"></div>
                            <!-- dot -->
                            <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 top-0 transition"></div>
                        </div>
                        <!-- label -->
                        <div class="ml-3 text-gray-700 text-sm">
                            {{trans('index.SetDefaultAddress')}}
                        </div>
                    </label>
                </div>
                <button type="submit" class="js_submit_address text-white bg-global hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-global dark:hover:bg-rose-600 dark:focus:ring-blue-800">
                    {{trans('index.AddNewAddress')}}</button>
            </form>
        </div>
    </div>
</div>
<div id="editAddress-modal" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full  flex justify-center items-center " style="background: #808080cc">
    <div class="relative p-4 h-full md:h-auto w-[790px]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" onclick="showModalAddressEdit()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div id="loadHTMlAddress">

            </div>
        </div>
    </div>
</div>
<style>
    input:checked~.dot {
        transform: translateX(100%);
        background-color: rgb(29 78 216 / 1);
    }
</style>
<script>
    function showModalAddress() {
        $('#createAddress-modal').toggleClass('hidden')
    }

    function showModalAddressEdit() {
        $('#editAddress-modal').toggleClass('hidden')
    }
    var cityid = '<?php echo !empty(old('city_id')) ? old('city_id') : '' ?>';
    var districtid = '<?php echo !empty(old('district_id')) ? old('district_id') : '' ?>';
    var wardid = '<?php echo !empty(old('ward_id')) ? old('ward_id') : '' ?>';
    $(document).ready(function() {
        $(".js_submit_address").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo route('customer.storeAddress') ?>",
                type: 'POST',
                data: {
                    _token: $("#form-addAddress input[name='_token']").val(),
                    name: $("#form-addAddress input[name='name']").val(),
                    phone: $("#form-addAddress input[name='phone']").val(),
                    address: $("#form-addAddress input[name='address']").val(),
                    city_id: $("#form-addAddress select[name='city_id']").val(),
                    district_id: $("#form-addAddress select[name='district_id']").val(),
                    ward_id: $("#form-addAddress select[name='ward_id']").val(),
                    publish: $("#form-addAddress input[name='publish']").val(),
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-addAddress .print-error-msg").css('display', 'none');
                        $("#form-addAddress .print-success-msg").css('display', 'block');
                        $("#form-addAddress .print-success-msg span").html("<?php echo trans('index.AddAddressSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-addAddress .print-error-msg").css('display', 'block');
                        $("#form-addAddress .print-success-msg").css('display', 'none');
                        $("#form-addAddress .print-error-msg span").html(data.error);
                    }
                }
            });
        });
        $('.js_handle_edit').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.post("<?php echo route('customer.showAddress') ?>", {
                    id: id,
                    "_token": $('meta[name="csrf-token"]').attr("content")
                },
                function(data) {
                    $('#loadHTMlAddress').html(data.html);
                    showModalAddressEdit();
                }
            );

        })
        $(document).on('submit', '#form-updateAddress', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    name: $("#form-updateAddress input[name='name']").val(),
                    phone: $("#form-updateAddress input[name='phone']").val(),
                    address: $("#form-updateAddress input[name='address']").val(),
                    city_id: $("#form-updateAddress select[name='city_id']").val(),
                    district_id: $("#form-updateAddress select[name='district_id']").val(),
                    ward_id: $("#form-updateAddress select[name='ward_id']").val(),
                    publish: $("#form-updateAddress input[name='publish']").val(),
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-updateAddress .print-error-msg").css('display', 'none');
                        $("#form-updateAddress .print-success-msg").css('display', 'block');
                        $("#form-updateAddress .print-success-msg span").html("<?php echo trans('index.UpdateAddressSuccess') ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $("#form-updateAddress .print-error-msg").css('display', 'block');
                        $("#form-updateAddress .print-success-msg").css('display', 'none');
                        $("#form-updateAddress .print-error-msg span").html(data.error);
                    }
                }
            });
        });
    });
    $('#toogleA').change(function() {
        var chk = $("#toogleA")
        var IsChecked = chk[0].checked
        if (IsChecked) {
            chk.attr('checked', 'checked')
        } else {
            chk.removeAttr('checked')
        }
        chk.attr('value', IsChecked)
    });
    $(document).on('change', '#toogleAEdit', function() {
        var chk = $("#toogleAEdit")
        var IsChecked = chk[0].checked
        if (IsChecked) {
            chk.attr('checked', 'checked')
        } else {
            chk.removeAttr('checked')
        }
        chk.attr('value', IsChecked)
    });
    $(document).on('change', '#cityEdit', function(e, data) {
        let _this = $(this);
        let param = {
            'id': _this.val(),
            'type': 'city',
            'trigger_district': (typeof(data) != 'undefined') ? true : false,
            'text': 'Chọn Quận/Huyện',
            'select': 'districtid'
        }
        getLocationEdit(param, '#districtEdit');
    });
    $(document).on('change', '#districtEdit', function(e, data) {
        let _this = $(this);
        var id = _this.val();
        if (id == null) {
            id = districtid;
        }
        let param = {
            'id': id,
            'type': 'district',
            'trigger_ward': (typeof(data) != 'undefined') ? true : false,
            'text': 'Chọn Phường/Xã',
            'select': 'wardid'
        }
        getLocationEdit(param, '#wardEdit');
    });
    if (typeof(cityid) != 'undefined' && cityid != '') {
        $('#cityEdit').val(cityid).trigger('change', [{
            'trigger': true
        }]);
    }
    if (typeof(districtid) != 'undefined' && districtid != '') {
        $('#districtEdit').val(districtid).trigger('change', [{
            'trigger': true
        }]);
    }

    function getLocationEdit(param, object) {
        if (districtid == '' || param.trigger_district == false) districtid = 0;
        if (wardid == '' || param.trigger_ward == false) wardid = 0;
        let formURL = BASE_URL_AJAX + 'gio-hang/get-location';
        $.post(formURL, {
                param: param,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                console.log(json.html);
                if (param.select == 'districtid') {
                    if (param.trigger_district == true) {
                        $(object).html(json.html).val(districtid);
                    } else {
                        $(object).html(json.html).val(districtid);
                    }
                } else if (param.select == 'wardid') {
                    $(object).html(json.html).val(wardid);
                }
            });
    }
    $(document).on('click', '.js_handle_delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
    })
    $(document).on("click", ".js_handle_delete", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "<?php echo trans('index.AreYouSure') ?>",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo trans('index.Perform') ?>",
                cancelButtonText: "<?php echo trans('index.Cancel') ?>",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = "<?php echo route('customer.deleteAddress') ?>";
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status === 200) {
                                swal({
                                    title: "<?php echo trans('index.DeleteSuccessfully') ?>",
                                    text: "<?php echo trans('index.DeleteSuccessfullyInfo') ?>",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "<?php echo trans('index.DeleteSuccessfullyInfo2') ?>",
                                    text: "<?php echo trans('index.DeleteSuccessfullyInfo3') ?>",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(jqXhr, json, errorThrown) {
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = "";
                            $.each(errors["errors"], function(index, value) {
                                errorsHtml += value + "/ ";
                            });
                            console.log(errorsHtml)
                        },
                    });
                } else {
                    swal({
                        title: "<?php echo trans('index.Cancel') ?>",
                        text: "<?php echo trans('index.CancelInfo') ?>",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            }
        );
    });
</script>
@include('homepage.common.loading')
@endpush
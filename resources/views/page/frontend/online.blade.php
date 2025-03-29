@extends('homepage.layout.home')
@section('content')
<div class="ps-page--product ps-page--product1 page-order-medicine pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void(0)">{{$page->title}}</a></li>

        </ul>
        <div class="ps-page__content">
            <h1 class="title-pr">{{$page->title}}</h1>
            <div class="content-order-medicine">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="order-medicine-left">
                            <div class="item-form">
                                <h3 class="title-3">Thông tin liên hệ</h3>
                                <div id="form-submit-contact">
                                    <div class="alert alert-danger" style="display: none;">
                                    </div>
                                    <div class="alert alert-success" style="display: none;">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Họ và tên" required name="nameOnline">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Số điện thoại" required name="phoneOnline">
                                    </div>
                                </div>
                                <textarea name="messageOnline" id="" cols="30" rows="10" placeholder="Ghi chú, không bắt buộc" required></textarea>
                            </div>
                            <div class="item-1">
                                <div class="box-1">
                                    <h4 class="title-4">Thêm ảnh nếu có đơn thuốc (không bắt buộc)</h4>
                                    <p class="desc">Giúp dược sỹ tư vấn chính xác nhất</p>
                                </div>
                                <div class="span-cong span-cong-1">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 24px;height: 24px;">
                                        <path d="M11.8834 3.00673L12 3C12.5128 3 12.9355 3.38604 12.9933 3.88338L13 4V11H20C20.5128 11 20.9355 11.386 20.9933 11.8834L21 12C21 12.5128 20.614 12.9355 20.1166 12.9933L20 13H13V20C13 20.5128 12.614 20.9355 12.1166 20.9933L12 21C11.4872 21 11.0645 20.614 11.0067 20.1166L11 20V13H4C3.48716 13 3.06449 12.614 3.00673 12.1166L3 12C3 11.4872 3.38604 11.0645 3.88338 11.0067L4 11H11V4C11 3.48716 11.386 3.06449 11.8834 3.00673L12 3L11.8834 3.00673Z" fill="currentColor"></path>
                                    </svg>
                                </div>
                                <div class="box-2">
                                    <h4 class="title-4">Ảnh chụp đơn thuốc</h4>
                                    <div class="form-upload" style="padding: 0px;border: 0px;">
                                        <!--START: dropzone upload image -->
                                        <div class="dropzone dz-clickable" id="myDropzone">
                                            <div class="dz-message" data-dz-message="">
                                                <div class="text-lg font-medium">Thêm tối đa 5 ảnh</div>
                                                <div class="text-slate-500">mỗi ảnh dưới 5MB (định dạng jpg, jpeg, png)</div>
                                            </div>
                                        </div>
                                        <!-- end: dropzone upload image -->
                                    </div>
                                </div>
                            </div>
                            <div style="border-radius: 10px;background: #fff;">
                                <div class="item-1" style="margin-bottom: 0px;">
                                    <h4 class="title-4">Thêm thuốc cần tư vấn (không bắt buộc)</h4>
                                    <p class="desc">Nhập theo tên thuốc hoặc sản phẩm</p>
                                    <div class="span-cong span-cong-2 modal-toggle-2">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 24px;height: 24px;">
                                            <path d="M11.8834 3.00673L12 3C12.5128 3 12.9355 3.38604 12.9933 3.88338L13 4V11H20C20.5128 11 20.9355 11.386 20.9933 11.8834L21 12C21 12.5128 20.614 12.9355 20.1166 12.9933L20 13H13V20C13 20.5128 12.614 20.9355 12.1166 20.9933L12 21C11.4872 21 11.0645 20.614 11.0067 20.1166L11 20V13H4C3.48716 13 3.06449 12.614 3.00673 12.1166L3 12C3 11.4872 3.38604 11.0645 3.88338 11.0067L4 11H11V4C11 3.48716 11.386 3.06449 11.8834 3.00673L12 3L11.8834 3.00673Z" fill="currentColor"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="list-product">
                                </div>
                            </div>
                            <div class="item">
                                <button type="button" class="js_submit">Gửi yêu cầu</button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="order-medicine-right">

                            <?php
                            $quytrinh = explode("\r\n", $fcSystem['title_8']);
                            ?>
                            @if(!empty($quytrinh))
                            <div class="item">
                                <h3 class="title-3">Quy trình tư vấn tại {{$fcSystem['homepage_brandname']}}</h3>
                                <div class="list-list">
                                    <ul>
                                        @foreach($quytrinh as $key=>$item)
                                        <li><span>{{$key+1}}</span>{{$item}}</li>
                                        @endforeach
                                    </ul>
                                    @if(!empty( $fcSystem['title_9']))
                                    <div class="note">
                                        <h4 class="title-4">Lưu ý:</h4>
                                        <div>
                                            {!! $fcSystem['title_9']!!}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="item">
                                <h5 class="title-5 modal-toggle">
                                    <a class="javascript:void(0)"><i class="fa fa-film" aria-hidden="true"></i>Xem lại Đơn thuốc của tôi</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- List products -->
<?php
$products =
    \App\Models\Product::select('id', 'title', 'slug', 'image')
    ->where(['alanguage' => config('app.locale'), 'publish' => 0])->orderBy('order', 'asc')->orderBy('id', 'desc')->limit(20)->get();
?>
<div class="modal-2">
    <div class="modal-overlay modal-toggle-2"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <button class="modal-close modal-toggle-2">
                <svg style="width: 24px;height: 24px;" class="h-6 w-6" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.21263 4.3871L4.29582 4.29289C4.65631 3.93241 5.22354 3.90468 5.61583 4.2097L5.71004 4.29289L12.0029 10.585L18.2958 4.29289C18.6863 3.90237 19.3195 3.90237 19.71 4.29289C20.1006 4.68342 20.1006 5.31658 19.71 5.70711L13.4179 12L19.71 18.2929C20.0705 18.6534 20.0982 19.2206 19.7932 19.6129L19.71 19.7071C19.3496 20.0676 18.7823 20.0953 18.39 19.7903L18.2958 19.7071L12.0029 13.415L5.71004 19.7071C5.31951 20.0976 4.68635 20.0976 4.29582 19.7071C3.9053 19.3166 3.9053 18.6834 4.29582 18.2929L10.5879 12L4.29582 5.70711C3.93534 5.34662 3.90761 4.77939 4.21263 4.3871L4.29582 4.29289L4.21263 4.3871Z" fill="currentColor"></path>
                </svg>
            </button>
            <h2 class="modal-heading">Tìm thuốc/sản phẩm cần tư vấn</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <div class="form">
                    <form action="">
                        <input type="text" name="keyProduct" placeholder="Bạn có thể tìm kiếm theo tên sản phẩm, tên thuốc, dược chất, dược liệu.">
                        <button type="button" class="btnSubmit">
                            <svg style="width: 16px;height: 16px;" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.9414 1.93125C5.98269 1.93125 1.94336 5.97057 1.94336 10.9293C1.94336 15.888 5.98269 19.9352 10.9414 19.9352C13.0594 19.9352 15.0074 19.193 16.5469 17.9606L20.2949 21.7066C20.4841 21.888 20.7367 21.988 20.9987 21.9853C21.2607 21.9826 21.5112 21.8775 21.6966 21.6923C21.882 21.5072 21.9875 21.2569 21.9906 20.9949C21.9936 20.7329 21.8939 20.4801 21.7129 20.2907L17.9648 16.5427C19.1983 15.0008 19.9414 13.0498 19.9414 10.9293C19.9414 5.97057 15.9001 1.93125 10.9414 1.93125ZM10.9414 3.93128C14.8192 3.93128 17.9395 7.05148 17.9395 10.9293C17.9395 14.8071 14.8192 17.9352 10.9414 17.9352C7.06357 17.9352 3.94336 14.8071 3.94336 10.9293C3.94336 7.05148 7.06357 3.93128 10.9414 3.93128Z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="product-add">
                    <div class="product-add-list">
                        @if(!empty($products))
                        @foreach($products as $item)
                        <div class="item">
                            <div class="img">
                                <img src="{{asset($item->image)}}" alt="{{$item->title}}">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">{{$item->title}}</h3>
                            </div>
                            <div class="add">
                                <button class="js_handleAddProduct" data-id="{{$item->id}}" data-image="{{asset($item->image)}}" data-title="{{$item->title}}">Thêm</button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="let-completed ">
                        <button class="js_hideModal modal-toggle-2">Hoàn tất</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END: List products -->

<!-- Đăng nhập -->
<div class="modal-1">
    <div class="modal-overlay modal-toggle"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <button class="modal-close modal-toggle"><i class="fa fa-times" aria-hidden="true"></i></button>
            <h2 class="modal-heading">Đăng nhập</h2>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                <?php /*<div class="top-login">
                    <ul>
                        <li>
                            <a href=""><i class="fa fa-google-plus" aria-hidden="true"></i>Đăng nhập bằng Google</a>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-facebook" aria-hidden="true"></i>Đăng nhập bằng Facebook</a>
                        </li>
                    </ul>

                </div>
                <div class="order">
                    <span>Hoặc</span>
                </div>*/ ?>
                <div class="form">
                    <form action="" id="form-header-login-2">
                        @csrf
                        <div class="alert alert-success print-success-msg" style="display: none;">
                        </div>
                        <div class="alert alert-danger print-error-msg" style="display: none;">
                        </div>
                        <div class="item">
                            <label for="">Email/SĐT cá nhân</label>
                            <input type="text" name="phone2" placeholder="Email/SĐT">
                        </div>
                        <div class="item">
                            <label for="">Mật khẩu đăng nhập</label>
                            <input type="password" name="password2" placeholder="Mật khẩu">
                        </div>
                        <div class="note">
                            <ul>
                                <li class="li-check">
                                    <a href="javascript:void(0)"><input type="checkbox">Ghi nhớ mật khẩu</a>
                                </li>
                                <li class="li-2">
                                    <a href="{{route('customer.reset-password')}}" target="_blank">Quên mật khẩu?</a>
                                </li>
                            </ul>
                        </div>
                        <button type="submit" class="js_submit_login_2">Đăng nhập</button>
                        <p class="note-2">Bạn chưa có tài khoản? <a href="{{route('customer.register')}}" target="_blank">Đăng ký ngay</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END: Đăng nhập -->

@endsection

@push('javascript')
<script>
    $(document).ready(function() {
        $(".js_submit_login_2").click(function(e) {
            e.preventDefault();
            var _token = $("#form-header-login-2 input[name='_token']").val();
            var phone = $("#form-header-login-2 input[name='phone2']").val();
            var password = $("#form-header-login-2 input[name='password2']").val();
            $.ajax({
                url: "<?php echo route('customer.login-ajax') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    phone: phone,
                    password: password,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#form-header-login-2 .print-error-msg").css('display', 'none');
                        $("#form-header-login-2 .print-success-msg").css('display', 'block');
                        $("#form-header-login-2 .print-success-msg").html("Đăng nhập thành công");
                        $(".modal-1").toggleClass("is-visible");
                    } else {
                        $("#form-header-login-2 .print-error-msg").css('display', 'block');
                        $("#form-header-login-2 .print-success-msg").css('display', 'none');
                        $("#form-header-login-2 .print-error-msg").html(data.error);
                    }
                }
            });
        });
    });
</script>
<script src="{{asset('library/dropzone/dropzone.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('library/dropzone/dropzone.min.css')}}" type="text/css" />
<!-- sortable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script>
    $(function() {
        $("#myDropzone").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#myDropzone',
            distance: 20,
            tolerance: 'pointer'
        });
    })
</script>
<!-- end sortable -->
<script>
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = ".jpeg,.jpg,.png";
    var fileList = new Array;
    var i = 0;
    var callForDzReset = false;
    $("#myDropzone").dropzone({
        url: "{{route('dropzone_upload_frontend')}}",
        addRemoveLinks: true,
        maxFiles: 5,
        acceptedFiles: 'image/*',
        maxFilesize: 5,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + '-' + file.name;
        },
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        init: function() {
            myDropzone = this;
            /*thêm path image khi upload thành công */
            this.on("success", function(file, serverFileName) {
                $(file.previewTemplate).find('.dz-remove').attr('data-path', serverFileName);
                $(file.previewTemplate).find('.dz-image').append('<input type="hidden" name="album[]" value="' + serverFileName + '">')
                file.serverFn = serverFileName;
                fileList[i] = {
                    serverFileName
                };
                i++;
            });
            /*END: thêm path image khi upload thành công*/
        },
        removedfile: function(file) {
            if ($('.dz-preview').length === 1) {
                $('.dz-message').removeClass('hidden');
            } else {
                $('.dz-message').addClass('hidden');
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
    });
</script>
<script>
    $(document).on('click', '.btnSubmit', function() {
        let keyword = $('input[name="keyProduct"]').val();
        let ajaxUrl = '<?php echo route('homepage.search.autocompleteOnline') ?>';
        $.get(ajaxUrl, {
                keyword: keyword,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('.product-add-list').html(data.html)
            });
        return false;
    });
    /*$(document).on('change paste keyup', 'input[name="keyProduct"]', function() {
        let keyword = $(this).val();
        time = setTimeout(function() {
            let ajaxUrl = '<?php echo route('homepage.search.autocompleteOnline') ?>';
            $.get(ajaxUrl, {
                    keyword: keyword,
                    "_token": $('meta[name="csrf-token"]').attr("content")
                },
                function(data) {
                    $('.product-add-list').html(data.html)
                });
        }, 1000);
        return false;
    }); */
</script>
<script>
    $(document).on('click', '.js_handleAddProduct', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id')
        var title = $(this).attr('data-title')
        var image = $(this).attr('data-image')
        var html = ''
        html += '<div class="item-product">'
        html += '<div class="item-product-left">'
        html += '<img class="" src="' + image + '" alt="' + title + '">'
        html += '</div>'
        html += '<div class="item-product-right">'
        html += '<span style="width: 412px;max-width:100%">' + title + '</span>'
        html += '<div class="form-input-quantity">'
        html += '<button class="js_minus">'
        html += '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
        html += '<path d="M3.75 12H20.25" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>'
        html += '</svg>'
        html += '</button>'
        html += '<input style="display:none" value="' + id + '" name="product_id[]">'
        html += '<input style="display:none" value="' + title + '" name="product_title[]">'
        html += '<input style="display:none" value="' + image + '" name="product_image[]">'
        html += '<input class="" value="1" name="product_quantity[]">'
        html += '<button class="js_plus">'
        html += '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">'
        html += '<path d="M11.8834 3.00673L12 3C12.5128 3 12.9355 3.38604 12.9933 3.88338L13 4V11H20C20.5128 11 20.9355 11.386 20.9933 11.8834L21 12C21 12.5128 20.614 12.9355 20.1166 12.9933L20 13H13V20C13 20.5128 12.614 20.9355 12.1166 20.9933L12 21C11.4872 21 11.0645 20.614 11.0067 20.1166L11 20V13H4C3.48716 13 3.06449 12.614 3.00673 12.1166L3 12C3 11.4872 3.38604 11.0645 3.88338 11.0067L4 11H11V4C11 3.48716 11.386 3.06449 11.8834 3.00673L12 3L11.8834 3.00673Z" fill="currentColor"></path>'
        html += '</svg>'
        html += '</button>'
        html += '</div>'
        html += '<div>'
        html += '<a href="javascript:void(0)" class="js_handleRemoveProduct">'
        html += '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-text-tertiary">'
        html += '<path d="M2.91602 7.03125L4.16144 22.0657C4.25069 23.1499 5.17422 24 6.26256 24H17.7378C18.8261 24 19.7497 23.1499 19.8389 22.0657L21.0843 7.03125H2.91602ZM8.48387 21.1875C8.11581 21.1875 7.80616 20.9012 7.78281 20.5283L7.07969 9.18455C7.05564 8.79661 7.3502 8.46291 7.73748 8.43886C8.13916 8.41069 8.45847 8.70872 8.48317 9.09666L9.1863 20.4404C9.21119 20.8421 8.89333 21.1875 8.48387 21.1875ZM12.7033 20.4844C12.7033 20.873 12.3888 21.1875 12.0002 21.1875C11.6115 21.1875 11.297 20.873 11.297 20.4844V9.14062C11.297 8.75198 11.6115 8.4375 12.0002 8.4375C12.3888 8.4375 12.7033 8.75198 12.7033 9.14062V20.4844ZM16.9206 9.18459L16.2175 20.5283C16.1944 20.8974 15.8867 21.205 15.4718 21.1861C15.0845 21.1621 14.79 20.8284 14.814 20.4405L15.5171 9.0967C15.5412 8.70877 15.8811 8.42653 16.2628 8.43891C16.6501 8.46295 16.9447 8.79666 16.9206 9.18459Z" fill="currentColor"></path>'
        html += '<path d="M21.1406 2.8125H16.9219V2.10938C16.9219 0.946219 15.9757 0 14.8125 0H9.1875C8.02434 0 7.07812 0.946219 7.07812 2.10938V2.8125H2.85938C2.0827 2.8125 1.45312 3.44208 1.45312 4.21875C1.45312 4.99533 2.0827 5.625 2.85938 5.625C9.32653 5.625 14.6737 5.625 21.1406 5.625C21.9173 5.625 22.5469 4.99533 22.5469 4.21875C22.5469 3.44208 21.9173 2.8125 21.1406 2.8125ZM15.5156 2.8125H8.48438V2.10938C8.48438 1.72144 8.79956 1.40625 9.1875 1.40625H14.8125C15.2004 1.40625 15.5156 1.72144 15.5156 2.10938V2.8125Z" fill="currentColor"></path>'
        html += '</svg>'
        html += '</a>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        $('.list-product').append(html)
    })
    $(document).on('click', '.js_handleRemoveProduct', function(e) {
        e.preventDefault();
        $(this).parent().parent().parent().remove()
    })
    $(document).on("click", ".js_plus", function(e) {
        e.preventDefault();
        let _this = $(this).parent().find('input[name="product_quantity[]"]');
        var quantity = parseInt(_this.val());
        quantity += 1;
        _this.val(quantity);
    });
    /*giảm giỏ hàng item => view giỏ hàng*/
    $(document).on("click", ".js_minus", function(e) {
        e.preventDefault();
        let _this = $(this).parent().find('input[name="product_quantity[]"]');
        var quantity = parseInt(_this.val());
        if (quantity <= 1) {
            quantity = 1;
        } else {
            quantity -= 1;
        }
        _this.val(quantity);
    });
</script>
<script>
    $(document).on('click', '.js_submit', function(e) {
        var product_id = [];
        var product_title = [];
        var product_image = [];
        var product_quantity = [];
        var album = [];
        $('input[name="product_id[]"]').each(function() {
            product_id.push($(this).val());
        })
        $('input[name="product_title[]"]').each(function() {
            product_title.push($(this).val());
        })
        $('input[name="product_image[]"]').each(function() {
            product_image.push($(this).val());
        })
        $('input[name="product_quantity[]"]').each(function() {
            product_quantity.push($(this).val());
        })
        $('input[name="album[]"]').each(function() {
            album.push($(this).val());
        })
        var name = $('input[name="nameOnline"]').val()
        var phone = $('input[name="phoneOnline"]').val()
        var message = $('textarea[name="messageOnline"]').val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('pageF.onlineStore')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                //hóa đơn
                name: name,
                phone: phone,
                message: message,
                album: album,
                product_id: product_id,
                product_title: product_title,
                product_quantity: product_quantity,

            },
            success: function(data) {
                if (data.status == 200) {
                    $("#form-submit-contact .alert-danger").css('display', 'none');
                    $("#form-submit-contact .alert-success").css('display', 'block');
                    $("#form-submit-contact .alert-success").html("<?php echo $fcSystem['message_3'] ?>");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    $("#form-submit-contact .alert-danger").css('display', 'block');
                    $("#form-submit-contact .alert-success").css('display', 'none');
                    $("#form-submit-contact .alert-danger").html(data.error);
                }
            },
            complete: function(e) {

            }
        });
    })
</script>
<style>
    .dropzone {
        min-height: 150px;
        border: 2px dashed rgb(226, 232, 240, 0.6);
        background: white;
        padding: 0px;
    }

    .dz-image img {
        height: 120px;
        width: 120px;
        object-fit: cover;
    }
</style>
@endpush
@push('css')
<style>
    .modal-2 .product-add .let-completed {
        margin-top: 30px;
    }

    .product-add-list {
        height: 300px;
        overflow-x: hidden;
    }

    .product-add-list::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #c1d0f6;
    }

    .product-add-list::-webkit-scrollbar {
        width: 6px;
        background-color: #c1d0f6;
    }

    .product-add-list::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #022da4;
    }

    .modal-content .btnSubmit {
        background: #c1d0f6 !important;
        width: 36px;
        height: 36px;
        border-radius: 100%;
        position: absolute;
        right: 4px !important;
        top: 50% !important;
        transform: translateY(-50%);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #1250dc;
    }

    .modal-2 .modal-content .form input[type=text] {
        background: #edf0f3 !important;
        border: 0px !important;
    }

    .modal-2 .product-add .item .add {
        display: flex;
        justify-content: end;
        flex: 1;
        padding-right: 15px;
    }

    .modal-2 .product-add .item .img,
    .modal-2 .product-add .item .img img {
        width: 58px !important;
        height: 58px;
    }

    .modal-2 .modal-header {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: none;
        border: 0px;
        padding: 16px;
    }

    .modal-2 .modal-body {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .modal-2 .modal-content,
    .modal-2 .modal-body {
        padding-top: 0px;
    }



    .btnSubmit {
        cursor: pointer;
    }

    .item-product {
        display: flex;
        justify-items: center;
        align-items: center;
        gap: 30px;
        padding: 10px 20px;
        border-bottom: 1px solid #e4e6eb;
    }

    .item-product:last-child {
        border-bottom: 0px;
    }

    .item-product-left {
        width: 60px;
        height: 60px;
        border: 1px solid #e4e6eb;
        padding: 2px;
        border-radius: 8px;
    }

    .item-product-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .item-product-right input {
        max-width: 40px;
        padding: 6px 3px;
        border-radius: 0;
        border: 1px solid #e4e8ed;
        border-right: 0;
        border-left: 0;
        background-color: #fff;
        outline: none;
        font-weight: 500;
        height: 32px;
        font-size: 14px;
        line-height: 20px;
        text-align: center;
        color: #020b27;
    }

    .form-input-quantity {
        display: flex;
        align-items: center;
    }

    .form-input-quantity button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 32px;
        background: #fff;
        border: 1px solid #e4e8ed;
        box-sizing: border-box;
        outline: none;
        color: #020b27;
        cursor: pointer;
    }

    .form-input-quantity button:first-child {
        border-radius: 34px 0 0 34px;
    }

    .form-input-quantity button:last-child {
        border-radius: 0 34px 34px 0;
    }

    .w-4\.5 {
        width: 20px;
    }

    .h-4\.5 {
        width: 20px;
    }

    .text-text-tertiary {
        color: #657384;
    }
</style>
@endpush

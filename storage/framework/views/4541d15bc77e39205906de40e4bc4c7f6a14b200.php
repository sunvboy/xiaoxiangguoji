
<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-order-medicine pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void(0)"><?php echo e($page->title); ?></a></li>

        </ul>
        <div class="ps-page__content">
            <h1 class="title-pr"><?php echo e($page->title); ?></h1>
            <div class="content-order-medicine">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="order-medicine-left">
                            <div class="item-form">
                                <h3 class="title-3">Thông tin liên hệ</h3>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Họ và tên">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <textarea name="" id="" cols="30" rows="10" placeholder="Ghi chú, không bắt buộc"></textarea>
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
                                    <div class="form-upload">
                                        <label for="file-upload-1"><i class="fa fa-camera" aria-hidden="true"></i>Thêm tối đa 5 ảnh, mỗi ảnh dưới 5MB (định dạng jpg, jpeg, png)
                                            <input type="file" id="file-upload-1" class="file-upload">
                                            <span id="filename-1" class="filename">
                                                <img src="file1.jpg" alt="">
                                            </span>
                                        </label>

                                    </div>
                                </div>


                            </div>
                            <div class="item-1">
                                <h4 class="title-4">Thêm thuốc cần tư vấn (không bắt buộc)</h4>
                                <p class="desc">Nhập theo tên thuốc hoặc sản phẩm</p>
                                <div class="span-cong span-cong-2 modal-toggle-2">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 24px;height: 24px;">
                                        <path d="M11.8834 3.00673L12 3C12.5128 3 12.9355 3.38604 12.9933 3.88338L13 4V11H20C20.5128 11 20.9355 11.386 20.9933 11.8834L21 12C21 12.5128 20.614 12.9355 20.1166 12.9933L20 13H13V20C13 20.5128 12.614 20.9355 12.1166 20.9933L12 21C11.4872 21 11.0645 20.614 11.0067 20.1166L11 20V13H4C3.48716 13 3.06449 12.614 3.00673 12.1166L3 12C3 11.4872 3.38604 11.0645 3.88338 11.0067L4 11H11V4C11 3.48716 11.386 3.06449 11.8834 3.00673L12 3L11.8834 3.00673Z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="order-medicine-right">
                            <div class="item">
                                <button>Gửi yêu cầu</button>
                            </div>
                            <div class="item">
                                <h3 class="title-3">Quy trình tư vấn tại Đại Cát Lộc</h3>
                                <div class="list-list">
                                    <ul>
                                        <li><span>1</span>Quý khách vui lòng điền thông tin liên hệ, cung cấp ảnh đơn thuốc hoặc tên sản phẩm cần tư vấn (nếu có).</li>
                                        <li><span>2</span>Dược sĩ chuyên môn của nhà thuốc sẽ gọi lại tư vấn miễn phí cho quý khách.</li>
                                        <li><span>3</span>Quý khách có thể tới các Nhà thuốc Đại Cát Lộc gần nhất để được hỗ trợ mua hàng trực tiếp.</li>
                                    </ul>
                                    <div class="note">
                                        <h4 class="title-4">Lưu ý:</h4>
                                        <p>- Nếu mua thuốc kê đơn, vui lòng mang theo đơn thuốc.</p>
                                        <p>- Dược sĩ vẫn sẽ chủ động tư vấn cho quý khách kể cả trong trường hợp không có đơn thuốc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <h5 class="title-5 modal-toggle"><a class=""><i class="fa fa-film" aria-hidden="true"></i>Xem lại Đơn thuốc của tôi</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






        </div>
    </div>


</div>
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
                        <input type="text">
                        <button class="btnSubmit">
                            <svg style="width: 16px;height: 16px;" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.9414 1.93125C5.98269 1.93125 1.94336 5.97057 1.94336 10.9293C1.94336 15.888 5.98269 19.9352 10.9414 19.9352C13.0594 19.9352 15.0074 19.193 16.5469 17.9606L20.2949 21.7066C20.4841 21.888 20.7367 21.988 20.9987 21.9853C21.2607 21.9826 21.5112 21.8775 21.6966 21.6923C21.882 21.5072 21.9875 21.2569 21.9906 20.9949C21.9936 20.7329 21.8939 20.4801 21.7129 20.2907L17.9648 16.5427C19.1983 15.0008 19.9414 13.0498 19.9414 10.9293C19.9414 5.97057 15.9001 1.93125 10.9414 1.93125ZM10.9414 3.93128C14.8192 3.93128 17.9395 7.05148 17.9395 10.9293C17.9395 14.8071 14.8192 17.9352 10.9414 17.9352C7.06357 17.9352 3.94336 14.8071 3.94336 10.9293C3.94336 7.05148 7.06357 3.93128 10.9414 3.93128Z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="product-add">
                    <div class="product-add-list">
                        <div class=" item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                        <div class="item">
                            <div class="img">
                                <img src="img/sp-8.png" alt="">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">Viên uống Mind Energy Jpanwell hỗ trợ cải thiện trí nhớ, bổ não (60 viên)</h3>
                            </div>
                            <div class="add">
                                <button>Thêm</button>
                            </div>
                        </div>
                    </div>
                    <div class="let-completed ">
                        <button>Hoàn tất</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-1">
    <div class="modal-overlay modal-toggle"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <button class="modal-close modal-toggle"><i class="fa fa-times" aria-hidden="true"></i></button>
            <h2 class="modal-heading">Đăng nhập</h2>
        </div>

        <div class="modal-body">
            <div class="modal-content">
                <div class="top-login">
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
                </div>
                <div class="form">
                    <form action="">
                        <div class="item">
                            <label for="">Email/SĐT cá nhân</label>
                            <input type="text">
                        </div>
                        <div class="item">
                            <label for="">Mật khẩu đăng nhập</label>
                            <input type="password">
                        </div>
                        <div class="note">
                            <ul>
                                <li class="li-check">
                                    <a href=""><input type="checkbox">Ghi nhớ mật khẩu</a>
                                </li>
                                <li class="li-2">
                                    <a href="">Quên mật khẩu?</a>
                                </li>
                            </ul>
                        </div>
                        <button>Đăng nhập</button>
                        <p class="note-2">Bạn chưa có tài khoản? <a href="">Đăng ký ngay</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-2 .product-add .let-completed {
        margin-top: 30px;
    }

    .product-add-list {
        max-height: 300px;
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
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/page/frontend/online.blade.php ENDPATH**/ ?>
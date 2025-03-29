<?php

use App\Http\Controllers\address\frontend\AddressController;
use App\Http\Controllers\article\frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\comment\frontend\CommentController;
use App\Http\Controllers\contact\frontend\ContactController;
use App\Http\Controllers\customer\frontend\CustomerController;
use App\Http\Controllers\homepage\HomeController;
use App\Http\Controllers\order\frontend\OrderController;
use App\Http\Controllers\cart\CartController;
use App\Http\Controllers\brand\frontend\BrandController;
use App\Http\Controllers\course\frontend\CourseCategoryController;
use App\Http\Controllers\customer\frontend\AddressController as FrontendAddressController;
use App\Http\Controllers\customer\frontend\ManagerController;
use App\Http\Controllers\customer\frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\faculty\frontend\FacultiesController;
use App\Http\Controllers\faq\frontend\FaqController;
use App\Http\Controllers\homepage\ImageController;
use App\Http\Controllers\notification\frontend\NotificationController;
use App\Http\Controllers\orderOnline\frontend\OrderOnlineController;
use App\Http\Controllers\page\frontend\PageController;
use App\Http\Controllers\product\frontend\CategoryController;
use App\Http\Controllers\product\frontend\AjaxController;
use App\Http\Controllers\quiz\frontend\QuizController;
use App\Http\Controllers\ship\frontend\ShipController;
use App\Http\Controllers\tag\frontend\TagController;
use App\Http\Controllers\team\frontend\TeamController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'locale'], function () {

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return redirect()->route('homepage.index')->with('success', "Xóa cache thành công");
    })->name('homepage.clearCache');
    Route::get('/clear-config', function () {
        Artisan::call('config:cache');
        return '<h1><a href="/">Clear Config cleared</a></h1>';
    });
    Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
    Route::get('/tim-kiem', [HomeController::class, 'search'])->name('homepage.search');

    Route::get('/wishlist', [HomeController::class, 'wishlist_index'])->name('homepage.wishlist_index');
    Route::post('/wishlist', [HomeController::class, 'wishlist'])->name('homepage.wishlist');
    Route::get('/gioi-thieu', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/thu-ngo', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/lich-su-hinh-thanh', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/tam-nhin-su-menh-loi-the-canh-tranh', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/co-cau-to-chuc', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/ky-thuat-chuyen-mon', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
    Route::get('/co-so-vat-chat', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');


    Route::get('/about-us', [PageController::class, 'aboutUs'])->name('pageF.aboutEN');
    Route::get('/contact', [ContactController::class, 'index'])->name('pageF.contact');
    Route::get('/lien-he', [ContactController::class, 'index']);
    Route::get('/products', [CategoryController::class, 'products']);
    Route::get('/san-pham', [CategoryController::class, 'products']);
    Route::get('/dat-lich-kham', [PageController::class, 'order'])->name('pageF.order');
    Route::get('/lich-kham-benh', [PageController::class, 'examination'])->name('pageF.examination');
    Route::get('/hoi-dap', [PageController::class, 'faqs'])->name('pageF.faqs');
    Route::get('/hoi-dap/{id}', [FaqController::class, 'index'])->name('pageF.faqs.id');
    Route::get('/danh-muc-hoi-dap/{slug}', [FaqController::class, 'category'])->name('pageF.faqs.category');
    Route::get('/doi-ngu-bac-sy', [PageController::class, 'teams'])->name('pageF.teams');
    Route::get('/doi-ngu-bac-sy/{id}', [TeamController::class, 'index'])->name('router.team');

    // Route::get('/kiem-tra-suc-khoe', [PageController::class, 'test']);
    // Route::get('/danh-muc-benh', [PageController::class, 'category'])->name('category.index');
    // Route::get('/danh-muc-benh/{id}', [PageController::class, 'categoryChild'])->name('category.categoryChild');
    // Route::post('/danh-muc-benh/co-the-nguoi', [PageController::class, 'cothenguoi'])->name('category.cothenguoi');
    // Route::post('/danh-muc-benh/benh-chuyen-khoa', [PageController::class, 'benhchuyenkhoa'])->name('category.benhchuyenkhoa');
    // Route::get('/dat-thuoc-online', [PageController::class, 'online'])->name('pageF.online');
    // Route::post('/dat-thuoc-online', [PageController::class, 'onlineStore'])->name('pageF.onlineStore');
    // Route::get('/he-thong-nha-thuoc', [PageController::class, 'address'])->name('pageF.address');
    // Route::post('/he-thong-nha-thuoc/detail', [PageController::class, 'addressDetail'])->name('pageF.addressDetail');
    // Route::post('/he-thong-nha-thuoc/addressGetLocation', [PageController::class, 'addressGetLocation'])->name('pageF.addressGetLocation');

    Route::post('/lien-he', [ContactController::class, 'store'])->name('contactFrontend.store');
    Route::post('/subcribers', [ContactController::class, 'subcribers'])->name('contactFrontend.subcribers');
    Route::get('/tim-kiem-bai-viet', [FrontendCategoryController::class, 'search'])->name('categoryArticle.search');
    //ajax pagination category article
    Route::get('/search/autocomplete', [CategoryController::class, 'autocomplete'])->name('homepage.search.autocomplete');
    Route::get('/search/autocomplete/online', [CategoryController::class, 'autocompleteOnline'])->name('homepage.search.autocompleteOnline');

    Route::post('/ajax-pagination-category-article', [FrontendCategoryController::class, 'ajaxPagination'])->name('categoryArticle.ajaxPagination');
    //giỏ hàng - ajax
    Route::group(['prefix' => 'gio-hang'], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('/thanh-toan', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('/thanh-toan-validate', [CartController::class, 'validateFormCopyCart'])->name('cart.checkoutValidateFormCopyCart');
        Route::get('/thanh-toan-thanh-cong/{id}', [CartController::class, 'success'])->name('cart.success');
        Route::post('/get-location', [CartController::class, 'getLocation'])->name('cart.getLocation');
        Route::post('/get-shipping', [ShipController::class, 'getPriceShip'])->name('cart.getPriceShip');
        Route::post('/change-shipping', [ShipController::class, 'changePriceShip'])->name('cart.changePriceShip');
    });
    Route::group(['prefix' => 'ajax/cart'], function () {
        //product quick view
        Route::post('/add-to-cart', [CartController::class, 'addToCart']);
        Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.updateCart');
        Route::post('/remove-cart', [CartController::class, 'removeCart'])->name('cart.removeCart');
        Route::post('/add-coupon', [CartController::class, 'addCoupon']);
        Route::post('/delete-coupon', [CartController::class, 'deleteCoupon']);
        Route::post('/get-address', [AddressController::class, 'getAddressFrontend'])->name('cart.getAddressFrontend');
        Route::post('/add-to-cart-deals', [CartController::class, 'addToCartDeals'])->name('cart.addToCartDeals');
    });
    //login customer
    Route::group(['middleware' => ['guest:customer']], function () {
        Route::group(['prefix' => 'thanh-vien'], function () {
            Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');
            Route::post('/login-ajax', [CustomerController::class, 'loginAjax'])->name('customer.login-ajax');
            Route::post('/login', [CustomerController::class, 'store'])->name('customer.login-store');
            Route::get('/register', [CustomerController::class, 'register'])->name('customer.register');
            Route::post('/register', [CustomerController::class, 'register_store'])->name('customer.register-store');
            //login social
            Route::get('/login/redirect/{provider}', [CustomerController::class, 'redirect'])->name('customer.redirect');
            Route::get('/login/callback/{provider}', [CustomerController::class, 'callback'])->name('customer.callback');
            Route::get('/reset-password', [CustomerController::class, 'reset_password'])->name('customer.reset-password');
            Route::post('/reset-password', [CustomerController::class, 'reset_password_store'])->name('customer.reset-password-store');
            Route::get('/reset-password-new', [CustomerController::class, 'reset_password_new'])->name('customer.reset-password-new');
        });
    });
    //order
    Route::group(['prefix' => 'order'], function () {
        Route::post('/', [OrderController::class, 'order'])->name('cart.order');
        //thanh toán momo
        Route::get('/momo-result', [OrderController::class, 'momo_result'])->name('cart.MOMOResult');
        Route::get('/momo-ipn', [OrderController::class, 'momo_ipn'])->name('cart.MOMOIPN');
        //thanh toán vnpay
        Route::get('/vnpay-result', [OrderController::class, 'vnpay_result'])->name('cart.VNPAYResult');
    });
    //bài thi
    Route::group(['prefix' => 'bai-thi'], function () {
        Route::get('/', [QuizController::class, 'index'])->name('quizzes.frontend.index');
        Route::get('/{slug}', [QuizController::class, 'quiz'])->name('quizzes.frontend.quiz');
        Route::post('/submit/{id}', [QuizController::class, 'quizSubmit'])->name('quizzes.frontend.quizSubmit');
        Route::get('/{slug}/{id}', [QuizController::class, 'quizSuccess'])->name('quizzes.frontend.quizSuccess');
        // Route::get('/ket-qua/{slug}/{id}', [QuizController::class, 'quizSuccess'])->name('quizzes.frontend.quizSuccess');
    });
    Route::group(['middleware' => ['auth:customer']], function () {
        Route::group(['prefix' => 'thanh-vien'], function () {
            Route::get('/dat-thuoc-online', [OrderOnlineController::class, 'index'])->name('customer.orderOnline');
            Route::get('/thong-tin-tai-khoan', [ManagerController::class, 'dashboard'])->name('customer.dashboard');
            Route::post('/update/thong-tin-tai-khoan', [ManagerController::class, 'updateInformation'])->name('customer.updateInformation');
            Route::post('/doi-mat-khau', [ManagerController::class, 'storeChangePassword'])->name('customer.storeChangePassword');

            Route::group(['prefix' => 'dap-an'], function () {
                Route::get('/{slug}/{id}', [QuizController::class, 'answer'])->name('quizzes.frontend.answer');
            });
            //end
            //Thông tin liên hệ & Sổ địa chỉ
            Route::group(['prefix' => 'thong-tin-lien-he'], function () {
                Route::get('/', [FrontendAddressController::class, 'index'])->name('customer.address');
                Route::post('/store', [FrontendAddressController::class, 'store'])->name('customer.storeAddress');
                Route::post('/show', [FrontendAddressController::class, 'show'])->name('customer.showAddress');
                Route::post('/update/{id}', [FrontendAddressController::class, 'update'])->name('customer.updateAddress');
                Route::post('/delete', [FrontendAddressController::class, 'delete'])->name('customer.deleteAddress');
            });
            //end
            Route::group(['prefix' => 'quan-ly-don-hang'], function () {
                Route::get('/', [FrontendOrderController::class, 'index'])->name('customer.orders');
                Route::get('/{id}', [FrontendOrderController::class, 'detail'])->name('customer.detailOrder');
                Route::get('edit/{id}', [FrontendOrderController::class, 'edit'])->name('customer.editOrder');
                Route::post('update/{id}', [FrontendOrderController::class, 'update'])->name('customer.updateOrder');
                Route::get('copy/{id}', [FrontendOrderController::class, 'copy'])->name('customer.copyOrder');
                Route::post('delete', [FrontendOrderController::class, 'delete'])->name('customer.deleteOrder');
                Route::post('ajax-list-product', [FrontendOrderController::class, 'ajaxListProduct'])->name('customer.ajaxListProduct');
                Route::post('add-to-cart-copy-order', [FrontendOrderController::class, 'addToCartCopyOrder'])->name('customer.addToCartCopyOrder');
                Route::post('update-cart-copy-order', [FrontendOrderController::class, 'updateCartCopyOrder'])->name('customer.updateCartCopyOrder');
                Route::post('validate-for-copy-cart', [FrontendOrderController::class, 'validateFormCopyCart'])->name('customer.validateFormCopyCart');
                Route::post('submit-copy-cart', [FrontendOrderController::class, 'submitCopyCart'])->name('customer.submitCopyCart');
                Route::post('return-order-create', [FrontendOrderController::class, 'returnOrder'])->name('customer.returnOrder');
                Route::post('return-order-store', [FrontendOrderController::class, 'returnOrderSubmit'])->name('customer.returnOrderSubmit');
            });
            Route::group(['prefix' => 'thong-bao'], function () {
                Route::get('/', [NotificationController::class, 'index'])->name('notification.frontend.index');
                Route::post('/', [NotificationController::class, 'indexPost'])->name('notification.ajax.index');
            });
            Route::get('/coupons', [ManagerController::class, 'coupons'])->name('customer.coupons');
            Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
        });
    });
    //upload image frontend
    Route::post('/image/store', [ImageController::class, 'store'])->name('image.store');
    //comment
    Route::group(['prefix' => 'comment'], function () {
        Route::group(['prefix' => '/articles'], function () {
            Route::post('/post-comment', [CommentController::class, 'postArticle'])->name('commentFrontend.postArticle');
        });
        Route::group(['prefix' => '/products'], function () {
            Route::post('/post-comment', [CommentController::class, 'postProduct'])->name('commentFrontend.postProduct');
        });
        Route::post('/get-list-comment', [CommentController::class, 'getListComment'])->name('commentFrontend.listCmt');
        Route::post('/reply-comment', [CommentController::class, 'replyComment'])->name('commentFrontend.replyCmt');
        Route::post('/upload-images-comment', [CommentController::class, 'uploadImagesComment'])->name('commentFrontend.uploadImagesCmt');
    });
    //tags
    Route::group(['prefix' => 'co-cau-to-chuc'], function () {
        Route::get('/{slug}', [FacultiesController::class, 'index'])->where(['slug' => '.+'])->name('FacultiesURL');
    });
    //tags
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/{slug}', [TagController::class, 'index'])->where(['slug' => '.+'])->name('tagURL');
    });
    //thuong hiệu
    Route::group(['prefix' => 'thuong-hieu'], function () {
        Route::get('/{slug}', [BrandController::class, 'index'])->where(['slug' => '.+'])->name('brandURL');
    });
    //hệ thống cửa hàng
    Route::group(['prefix' => '/he-thong-cua-hang'], function () {
        Route::get('/', [AddressController::class, 'index'])->name('addressFrontend.index');
        Route::post('/getLocationstore', [AddressController::class, 'getLocationFrontend'])->name('addressFrontend.getLocation');
    });
    Route::post('ajax/courses/courses-filter', [CourseCategoryController::class, 'filter'])->name('courses.filter');
    Route::post('ajax/product/product-filter', [CategoryController::class, 'product_filter'])->name('productF.filter');
    Route::post('ajax/product/product-version', [AjaxController::class, 'product_version'])->name('productF.version');
});
//dropzone
Route::group(['prefix' => '/dropzone'], function () {
    Route::post('/dropzone-upload', [HomeController::class, 'dropzone_upload'])->name('dropzone_upload_frontend');
});
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('{slug}')->where(['slug' => '.+'])->name('routerURL');

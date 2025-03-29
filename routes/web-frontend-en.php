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
use App\Http\Controllers\customer\frontend\AddressController as FrontendAddressController;
use App\Http\Controllers\customer\frontend\ManagerController;
use App\Http\Controllers\customer\frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\homepage\ImageController;
use App\Http\Controllers\page\frontend\PageController;
use App\Http\Controllers\product\frontend\CategoryController;
use App\Http\Controllers\product\frontend\AjaxController;
use App\Http\Controllers\ship\frontend\ShipController;
use App\Http\Controllers\tag\frontend\TagController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

$segments = request()->segments();
$first = reset($segments);
if (in_array($first, config('app.alt_langs'))) {
    Config::set('app.locale_prefix', Request::segment(1));
}
Route::group(['middleware' => 'locale'], function () {
    Route::group(['prefix' => config('app.locale_prefix')], function () {
        Route::get('/clear-cache', function () {
            Artisan::call('cache:clear');
            return redirect()->route('homepage.index')->with('success', "Xóa cache thành công");
        })->name('homepage.clearCache');
        Route::get('/clear-config', function () {
            Artisan::call('config:cache');
            return '<h1><a href="/">Clear Config cleared</a></h1>';
        });
        Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
        Route::get('/gioi-thieu', [PageController::class, 'aboutUs'])->name('pageF.aboutVI');
        Route::get('/about-us', [PageController::class, 'aboutUs'])->name('pageF.aboutEN');
        Route::get('/agency', [PageController::class, 'agency']);
        Route::get('/dang-ky-dai-ly', [PageController::class, 'agency']);
        Route::get('/reviews', [PageController::class, 'reviews']);
        Route::get('/contact', [ContactController::class, 'index']);
        Route::get('/lien-he', [ContactController::class, 'index']);
        Route::get('/products', [CategoryController::class, 'products']);
        Route::get('/san-pham', [CategoryController::class, 'products']);
        Route::post('/lien-he', [ContactController::class, 'store'])->name('contactFrontend.store');
        Route::post('/subcribers', [ContactController::class, 'subcribers'])->name('contactFrontend.subcribers');
        Route::post('/dang-ky-dai-ly-form', [ContactController::class, 'agency'])->name('contactFrontend.agency');
        Route::get('/tim-kiem', [CategoryController::class, 'search'])->name('homepage.search');
        //ajax pagination category article
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
        Route::group(['middleware' => ['auth:customer']], function () {

            Route::group(['prefix' => 'thanh-vien'], function () {
                Route::get('/thong-tin-tai-khoan', [ManagerController::class, 'dashboard'])->name('customer.dashboard');
                Route::post('/update/thong-tin-tai-khoan', [ManagerController::class, 'updateInformation'])->name('customer.updateInformation');
                Route::post('/doi-mat-khau', [ManagerController::class, 'storeChangePassword'])->name('customer.storeChangePassword');

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
        Route::post('ajax/product/product-filter', [AjaxController::class, 'product_filter'])->name('productF.filter');
        Route::post('ajax/product/product-version', [AjaxController::class, 'product_version'])->name('productF.version');
    });
});
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/en/{slug}')->where(['slug' => '.+'])->name('routerURL');

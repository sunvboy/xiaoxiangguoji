<?php

use App\Http\Controllers\address\backend\AddressController;
//article module
use App\Http\Controllers\article\backend\ArticleController;
use App\Http\Controllers\article\backend\CategoryController as BackendCategoryController;
//product module
use App\Http\Controllers\product\backend\CategoryController;
use App\Http\Controllers\product\backend\ProductController;
//attribute module
use App\Http\Controllers\attribute\backend\CategoryController as AttributeCategoryController;
use App\Http\Controllers\attribute\backend\AttributeController as AttributeController;
//brand module
use App\Http\Controllers\brand\backend\BrandController;
use App\Http\Controllers\cashbook\PaymentGroupsController;
use App\Http\Controllers\cashbook\PaymentVouchersController;
use App\Http\Controllers\cashbook\ReceiptGroupsController;
use App\Http\Controllers\cashbook\ReceiptVouchersController;
//mã giảm giá module
use App\Http\Controllers\coupon\CounponController;
//Order, đặt hàng module
use App\Http\Controllers\order\backend\OrderController;

//comment module
use App\Http\Controllers\comment\backend\CommentController;
//media module
use App\Http\Controllers\media\backend\CategoryController as MediaBackendCategoryController;
use App\Http\Controllers\media\backend\MediaController;
//menu module
use App\Http\Controllers\menu\backend\MenuController;
//slide module
use App\Http\Controllers\slide\backend\SlideController;
///tag module
use App\Http\Controllers\tag\backend\TagController;
//khách hàng module
use App\Http\Controllers\customer\backend\CustomerController;
//user ADMIN
use App\Http\Controllers\user\backend\AuthController;
use App\Http\Controllers\user\backend\PermissionController;
use App\Http\Controllers\user\backend\ResetPasswordController;
use App\Http\Controllers\user\backend\RolesController;
use App\Http\Controllers\user\backend\UsersController;

//contact module
use App\Http\Controllers\contact\backend\ContactController;
//page module
use App\Http\Controllers\page\backend\PageController;

//global admin => module
use App\Http\Controllers\components\ComponentsController;
use App\Http\Controllers\components\PolyLangController;
use App\Http\Controllers\config\ConfigColumController;
use App\Http\Controllers\config\ConfigEmailController;
use App\Http\Controllers\config\ConfigImageController;
use App\Http\Controllers\config\ConfigIsController;
use App\Http\Controllers\course\backend\CourseCategoryController;
use App\Http\Controllers\course\backend\CourseController;
use App\Http\Controllers\customer\backend\CustomerCategoryController;
use App\Http\Controllers\customer\backend\CustomerLevelController;
use App\Http\Controllers\customer\backend\CustomerLogsController;
use App\Http\Controllers\customer\backend\CustomerSocialController;
use App\Http\Controllers\customer\backend\OrderController as BackendOrderController;
use App\Http\Controllers\dashboard\AjaxController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\faculty\backend\FacultiesController;
use App\Http\Controllers\faculty\backend\FacultyCategoriesController;
use App\Http\Controllers\faq\backend\FaqCategoryController;
use App\Http\Controllers\faq\backend\FaqController;
use App\Http\Controllers\general\GeneralController;
use App\Http\Controllers\order\backend\OrderLogsController;
use App\Http\Controllers\orderOnline\backend\OrderOnlineController;
use App\Http\Controllers\product\backend\AjaxProductController;
use App\Http\Controllers\product\backend\ProductDealController;
use App\Http\Controllers\product\backend\ProductPurchaseController;
use App\Http\Controllers\product\backend\ProductTmpController;
use App\Http\Controllers\quiz\backend\QuestionController;
use App\Http\Controllers\quiz\backend\QuestionOptionUsersController;
use App\Http\Controllers\quiz\backend\QuizCategoryController;
use App\Http\Controllers\quiz\backend\QuizConfigController;
use App\Http\Controllers\quiz\backend\QuizController;
use App\Http\Controllers\ship\backend\ShipController;
use App\Http\Controllers\suppliers\SuppliersCategoryController;
use App\Http\Controllers\suppliers\SuppliersController;
use App\Http\Controllers\tax\TaxController;
use App\Http\Controllers\team\backend\TeamController;
use App\Http\Controllers\website\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => env('APP_ADMIN'), 'middleware' => ['guest:web']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'store'])->name('admin.login-store');
    Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('admin.reset-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('admin.reset-password-store');
    Route::get('/reset-password-new', [ResetPasswordController::class, 'reset_password_new'])->name('admin.reset-password-new');
});

Route::group(['middleware' => 'locale'], function () {
    Route::group(['prefix' => env('APP_ADMIN'), 'middleware' => ['auth:web']], function () {

        Route::group(['prefix' => '/dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::post('/search/order', [DashboardController::class, 'searchOrder'])->name('admin.searchOrder');
            Route::post('/search/order-status', [DashboardController::class, 'searchOrderStatus'])->name('admin.searchOrderStatus');
            Route::post('/search/order-payment-item', [DashboardController::class, 'searchOrderProduct'])->name('admin.searchOrderProduct');
        });
        //configure
        Route::group(['prefix' => '/config-is'], function () {
            Route::get('/index', [ConfigIsController::class, 'index'])->name('configIs.index');
            Route::get('/create', [ConfigIsController::class, 'create'])->name('configIs.create');
            Route::post('/store', [ConfigIsController::class, 'store'])->name('configIs.store');
            Route::get('/edit/{id}', [ConfigIsController::class, 'edit'])->name('configIs.edit');
            Route::post('/update/{id}', [ConfigIsController::class, 'update'])->name('configIs.update');
            Route::get('/destroy/{id}', [ConfigIsController::class, 'destroy'])->name('configIs.destroy');
        });
        Route::group(['prefix' => '/config-colums'], function () {
            Route::get('/index', [ConfigColumController::class, 'index'])->name('config_colums.index');
            Route::get('/create', [ConfigColumController::class, 'create'])->name('config_colums.create');
            Route::post('/store', [ConfigColumController::class, 'store'])->name('config_colums.store');
            Route::get('/edit/{id}', [ConfigColumController::class, 'edit'])->name('config_colums.edit');
            Route::post('/update/{id}', [ConfigColumController::class, 'update'])->name('config_colums.update');
            Route::post('/destroy', [ConfigColumController::class, 'destroy'])->name('config_colums.destroy');
            Route::post('/ajax/delete-all', [ConfigColumController::class, 'deleteAll'])->name('config_colums.delete_all');
        });
        Route::group(['prefix' => '/config-emails'], function () {
            Route::get('/index', [ConfigEmailController::class, 'index'])->name('config_emails.index')->middleware('can:generals_index');
            Route::get('/create', [ConfigEmailController::class, 'create'])->name('config_emails.create')->middleware('can:generals_index');
            Route::post('/store', [ConfigEmailController::class, 'store'])->name('config_emails.store')->middleware('can:generals_index');
            Route::get('/edit/{id}', [ConfigEmailController::class, 'edit'])->name('config_emails.edit')->middleware('can:generals_index');
            Route::post('/update/{id}', [ConfigEmailController::class, 'update'])->name('config_emails.update')->middleware('can:generals_index');
        });
        Route::group(['prefix' => '/config-images'], function () {
            Route::get('/index', [ConfigImageController::class, 'index'])->name('config_images.index')->middleware('can:generals_index');
            Route::get('/create', [ConfigImageController::class, 'create'])->name('config_images.create')->middleware('can:generals_index');
            Route::post('/store', [ConfigImageController::class, 'store'])->name('config_images.store')->middleware('can:generals_index');
            Route::get('/edit/{id}', [ConfigImageController::class, 'edit'])->name('config_images.edit')->middleware('can:generals_index');
            Route::post('/update/{id}', [ConfigImageController::class, 'update'])->name('config_images.update')->middleware('can:generals_index');
        });
        //ajax
        Route::group(['prefix' => '/ajax'], function () {
            Route::post('/select2', [AjaxController::class, 'select2']);
            Route::post('/ajax-create', [AjaxController::class, 'ajax_create'])->name('ajax-create');
            Route::post('/ajax-delete', [AjaxController::class, 'ajax_delete']);
            Route::post('/ajax-delete-all', [AjaxController::class, 'ajax_delete_all']);
            Route::post('/ajax-order', [AjaxController::class, 'ajax_order']);
            Route::post('/publish-ajax', [AjaxController::class, 'ajax_publish']);
            Route::post('/get-select2', [AjaxController::class, 'get_select2']);
            Route::post('/pre-select2', [AjaxController::class, 'pre_select2']);
        });

        //cấu hình hệ thống
        Route::group(['prefix' => '/generals'], function () {
            Route::get('/', [GeneralController::class, 'index'])->name('generals.index');
            Route::get('/index', [GeneralController::class, 'general'])->name('generals.general')->middleware('can:generals_index');
            Route::post('/store', [GeneralController::class, 'store'])->name('generals.store')->middleware('can:generals_index');
        });

        //permission
        Route::group(['prefix' => '/permissions'], function () {
            Route::get('/index', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
        });
        //nhóm thành viên
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/index', [RolesController::class, 'index'])->name('roles.index')->middleware('can:roles_index');
            Route::get('/create', [RolesController::class, 'create'])->name('roles.create')->middleware('can:roles_create');
            Route::post('/store', [RolesController::class, 'store'])->name('roles.store')->middleware('can:roles_create');
            Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit')->middleware('can:roles_edit');
            Route::post('/update/{id}', [RolesController::class, 'update'])->name('roles.update')->middleware('can:roles_edit');
            Route::get('/destroy/{id}', [RolesController::class, 'destroy'])->name('roles.destroy')->middleware('can:roles_destroy');
        });
        //Thành viên quản trị
        Route::group(['prefix' => '/users'], function () {
            Route::get('/index', [UsersController::class, 'index'])->name('users.index')->middleware('can:users_index');
            Route::get('/create', [UsersController::class, 'create'])->name('users.create')->middleware('can:users_create');
            Route::post('/store', [UsersController::class, 'store'])->name('users.store')->middleware('can:users_create');
            Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit')->middleware('can:users_edit');
            Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update')->middleware('can:users_edit');
            Route::get('/destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('can:roles_destroy');
            Route::get('/reset-password', [UsersController::class, 'reset_password'])->name('users.reset-password')->middleware('can:users_edit');
            //auth
            Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
            Route::get('/my-profile', [AuthController::class, 'profile'])->name('admin.profile');
            Route::post('/my-profile/{id}', [AuthController::class, 'profile_store'])->name('admin.profile-store');
            Route::get('/my-password', [AuthController::class, 'profile_password'])->name('admin.profile-password');
            Route::post('/my-password/{id}', [AuthController::class, 'profile_password_store'])->name('admin.profile-password-store');
        });
        //slide
        Route::group(['prefix' => '/slides'], function () {
            Route::get('/index', [SlideController::class, 'index'])->name('slides.index')->middleware('can:slides_index');
            Route::post('/store', [SlideController::class, 'store'])->name('slides.store')->middleware('can:slides_index');
            Route::post('/category_store', [SlideController::class, 'category_store'])->name('slides.category_store')->middleware('can:slides_index');
            Route::post('/category_update', [SlideController::class, 'category_update'])->name('slides.category_update')->middleware('can:slides_index');
            Route::post('/update', [SlideController::class, 'update'])->name('slides.update')->middleware('can:slides_index');
        });
        //danh mục attribute
        Route::group(['prefix' => '/category-attributes'], function () {
            Route::get('/index', [AttributeCategoryController::class, 'index'])->name('category_attributes.index')->middleware('can:category_attributes_index');
            Route::get('/create', [AttributeCategoryController::class, 'create'])->name('category_attributes.create')->middleware('can:category_attributes_create');
            Route::post('/store', [AttributeCategoryController::class, 'store'])->name('category_attributes.store')->middleware('can:category_attributes_create');
            Route::get('/edit/{id}', [AttributeCategoryController::class, 'edit'])->name('category_attributes.edit')->middleware('can:category_attributes_edit');
            Route::post('/update/{id}', [AttributeCategoryController::class, 'update'])->name('category_attributes.update')->middleware('can:category_attributes_edit');
            Route::get('/destroy/{id}', [AttributeCategoryController::class, 'destroy'])->name('category_attributes.destroy')->middleware('can:category_attributes_destroy');
        });
        //danh sách attribute
        Route::group(['prefix' => '/attributes'], function () {
            Route::get('/index', [AttributeController::class, 'index'])->name('attributes.index')->middleware('can:attributes_index');
            Route::get('/create', [AttributeController::class, 'create'])->name('attributes.create')->middleware('can:attributes_create');
            Route::post('/store', [AttributeController::class, 'store'])->name('attributes.store')->middleware('can:attributes_create');
            Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit')->middleware('can:attributes_edit');
            Route::post('/update/{id}', [AttributeController::class, 'update'])->name('attributes.update')->middleware('can:attributes_edit');
            Route::get('/destroy/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy')->middleware('can:attributes_destroy');
            Route::post('/select2', [AttributeController::class, 'select2']);
        });
        //danh mục sản phẩm
        Route::group(['prefix' => '/category-products'], function () {
            Route::get('/index', [CategoryController::class, 'index'])->name('category_products.index')->middleware('can:category_products_index');
            Route::get('/create', [CategoryController::class, 'create'])->name('category_products.create')->middleware('can:category_products_create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category_products.store')->middleware('can:category_products_create');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category_products.edit')->middleware('can:category_products_edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category_products.update')->middleware('can:category_products_edit');
            Route::get('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category_products.destroy')->middleware('can:category_products_destroy');
        });
        //sản phẩm
        Route::group(['prefix' => '/products'], function () {
            Route::post('/import', [ProductController::class, 'import'])->name('products.import')->middleware('can:products_index');
            Route::get('/index', [ProductController::class, 'index'])->name('products.index')->middleware('can:products_index');

            Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware('can:products_create');
            Route::post('/store', [ProductController::class, 'store'])->name('products.store')->middleware('can:products_create');
            Route::get('/copy/{id}', [ProductController::class, 'copy'])->name('products.copy')->middleware('can:products_create');

            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:products_edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('can:products_edit');
            Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:products_destroy');
            Route::post('/delete', [ProductController::class, 'delete'])->name('products.delete')->middleware('can:products_destroy');
            Route::post('/delete-all', [ProductController::class, 'delete_all'])->name('products.deleteAll')->middleware('can:products_destroy');



            Route::group(['prefix' => '/ajax'], function () {
                Route::post('/get-attrid', [ProductController::class, 'get_attrid']);
                Route::get('/list-product', [ProductController::class, 'listproduct']);
                Route::post('/address-stock', [AjaxProductController::class, 'addressStock']);
                Route::post('/product-stock-histories', [AjaxProductController::class, 'productStockHistories']);
            });
            Route::get('/excel/export-products', [ProductController::class, 'exportProducts'])->name('products.export');
        });
        //tag
        Route::group(['prefix' => '/tags'], function () {
            Route::get('/index', [TagController::class, 'index'])->name('tags.index')->middleware('can:tags_index');
            Route::get('/create', [TagController::class, 'create'])->name('tags.create')->middleware('can:tags_create');
            Route::post('/store', [TagController::class, 'store'])->name('tags.store');
            Route::get('/edit/{id}', [TagController::class, 'edit'])->name('tags.edit')->middleware('can:tags_edit');
            Route::post('/update/{id}', [TagController::class, 'update'])->name('tags.update')->middleware('can:tags_edit');
            Route::get('/destroy/{id}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('can:tags_destroy');
        });
        Route::group(['prefix' => '/brands'], function () {
            Route::get('/index', [BrandController::class, 'index'])->name('brands.index')->middleware('can:brands_index');
            Route::get('/create', [BrandController::class, 'create'])->name('brands.create')->middleware('can:brands_create');
            Route::post('/store', [BrandController::class, 'store'])->name('brands.store')->middleware('can:brands_create');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit')->middleware('can:brands_edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brands.update')->middleware('can:brands_edit');
            Route::get('/destroy/{id}', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('can:brands_destroy');
        });
        Route::group(['prefix' => '/coupons'], function () {
            Route::get('/index', [CounponController::class, 'index'])->name('coupons.index')->middleware('can:coupons_index');
            Route::get('/create', [CounponController::class, 'create'])->name('coupons.create')->middleware('can:coupons_create');
            Route::post('/store', [CounponController::class, 'store'])->name('coupons.store')->middleware('can:coupons_create');
            Route::get('/edit/{id}', [CounponController::class, 'edit'])->name('coupons.edit')->middleware('can:coupons_edit');
            Route::post('/update/{id}', [CounponController::class, 'update'])->name('coupons.update')->middleware('can:coupons_edit');
            Route::get('/destroy/{id}', [CounponController::class, 'destroy'])->name('coupons.destroy')->middleware('can:coupons_destroy');
        });
        Route::group(['prefix' => '/ships'], function () {
            Route::get('/index', [ShipController::class, 'index'])->name('ships.index')->middleware('can:ships_index');
            Route::get('/province', [ShipController::class, 'province'])->name('ships.index_province')->middleware('can:ships_index');
            Route::post('/update-one-province', [ShipController::class, 'update_one_province'])->middleware('can:ships_edit');
            Route::post('/update-all-province', [ShipController::class, 'update_all_province'])->middleware('can:ships_edit');
            Route::get('/create', [ShipController::class, 'create'])->name('ships.create')->middleware('can:ships_create');
            Route::post('/store', [ShipController::class, 'store'])->name('ships.store')->middleware('can:ships_create');
            Route::get('/edit/{id}', [ShipController::class, 'edit'])->name('ships.edit')->middleware('can:ships_edit');
            Route::post('/update/{id}', [ShipController::class, 'update'])->name('ships.update')->middleware('can:ships_edit');
            Route::get('/destroy/{id}', [ShipController::class, 'destroy'])->name('ships.destroy')->middleware('can:ships_destroy');
        });

        //danh mục article
        Route::group(['prefix' => '/category-articles'], function () {
            Route::get('/index', [BackendCategoryController::class, 'index'])->name('category_articles.index')->middleware('can:category_articles_index');
            Route::get('/create', [BackendCategoryController::class, 'create'])->name('category_articles.create')->middleware('can:category_articles_create');
            Route::post('/store', [BackendCategoryController::class, 'store'])->name('category_articles.store')->middleware('can:category_articles_create');
            Route::get('/edit/{id}', [BackendCategoryController::class, 'edit'])->name('category_articles.edit')->middleware('can:category_articles_edit');
            Route::post('/update/{id}', [BackendCategoryController::class, 'update'])->name('category_articles.update')->middleware('can:category_articles_edit');
            Route::get('/destroy/{id}', [BackendCategoryController::class, 'destroy'])->name('category_articles.destroy')->middleware('can:category_articles_destroy');
        });
        //danh sách article
        Route::group(['prefix' => '/articles'], function () {
            Route::get('/index', [ArticleController::class, 'index'])->name('articles.index')->middleware('can:articles_index');
            Route::get('/create', [ArticleController::class, 'create'])->name('articles.create')->middleware('can:articles_create');
            Route::post('/store', [ArticleController::class, 'store'])->name('articles.store');
            Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('articles.edit')->middleware('can:articles_edit');
            Route::post('/update/{id}', [ArticleController::class, 'update'])->name('articles.update')->middleware('can:articles_edit');
            Route::get('/destroy/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy')->middleware('can:articles_destroy');
            Route::post('/select2', [ArticleController::class, 'select2']);
        });
        //danh mục media
        Route::group(['prefix' => '/category-media'], function () {
            Route::get('/index', [MediaBackendCategoryController::class, 'index'])->name('category_media.index')->middleware('can:category_media_index');
            Route::get('/create', [MediaBackendCategoryController::class, 'create'])->name('category_media.create')->middleware('can:category_media_create');
            Route::post('/store', [MediaBackendCategoryController::class, 'store'])->name('category_media.store');
            Route::get('/edit/{id}', [MediaBackendCategoryController::class, 'edit'])->name('category_media.edit')->middleware('can:category_media_edit');
            Route::post('/update/{id}', [MediaBackendCategoryController::class, 'update'])->name('category_media.update')->middleware('can:category_media_edit');
            Route::get('/destroy/{id}', [MediaBackendCategoryController::class, 'destroy'])->name('category_media.destroy')->middleware('can:category_media_destroy');
        });

        //danh sách media
        Route::group(['prefix' => '/media'], function () {
            Route::get('/index', [MediaController::class, 'index'])->name('media.index')->middleware('can:media_index');
            Route::get('/create', [MediaController::class, 'create'])->name('media.create')->middleware('can:media_create');
            Route::post('/store', [MediaController::class, 'store'])->name('media.store');
            Route::get('/edit/{id}', [MediaController::class, 'edit'])->name('media.edit')->middleware('can:media_edit');
            Route::post('/update/{id}', [MediaController::class, 'update'])->name('media.update')->middleware('can:media_edit');
            Route::get('/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy')->middleware('can:media_destroy');
            Route::post('/get-select-type', [MediaController::class, 'get_select_type']);
        });
        //liên hệ
        Route::group(['prefix' => '/contacts'], function () {
            Route::get('/index', [ContactController::class, 'index'])->name('contacts.index')->middleware('can:contacts_index');
            Route::post('/index', [ContactController::class, 'store'])->name('contacts.index_store')->middleware('can:contacts_index');
        });
        Route::group(['prefix' => '/subscribers'], function () {
            Route::get('/index', [ContactController::class, 'subscribers'])->name('subscribers.index');
        });
        Route::group(['prefix' => '/books'], function () {
            Route::get('/index', [ContactController::class, 'books'])->name('books.index');
        });
        //menu
        Route::group(['prefix' => '/menus'], function () {
            Route::get('/index', [MenuController::class, 'index'])->name('menus.index')->middleware('can:menus_index');
            Route::get('/create', [MenuController::class, 'create'])->name('menus.create')->middleware('can:menus_create');
            Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menus.edit')->middleware('can:menus_edit');
            Route::post('/update/{id}', [MenuController::class, 'update'])->name('menus.update');
            //nút "thêm vào menu"
            Route::get('/add-menu-item', [MenuController::class, 'addMenuItem'])->name('addMenuItem')->middleware('can:menus_create');
            //nút Liên kết tự tạo => "thêm vào menu"
            Route::get('/add-custom-link', [MenuController::class, 'addCustomLink'])->name('addCustomLink')->middleware('can:menus_create');
            //nút Lưu menu item
            Route::post('/update-menu-item/{id}', [MenuController::class, 'updateMenuItem'])->name('update-menu-item')->middleware('can:menus_edit');
            //nút Xóa menu item
            Route::get('/delete-menu-item/{id}/{menus_id}', [MenuController::class, 'deleteMenuItem'])->name('delete-menu-item')->middleware('can:menus_edit');
            //nút LƯU MENU khi kéo thả
            Route::post('/update-menu', [MenuController::class, 'updateMenu'])->name('update-menu')->middleware('can:menus_edit');
            //nút XÓA MENU
            Route::get('/delete-menu/{id}', [MenuController::class, 'destroy'])->name('delete-menu')->middleware('can:menus_destroy');
        });
        //address
        Route::group(['prefix' => '/addresses'], function () {
            Route::get('/index', [AddressController::class, 'index'])->name('addresses.index')->middleware('can:addresses_index');
            Route::get('/create', [AddressController::class, 'create'])->name('addresses.create')->middleware('can:addresses_create');
            Route::post('/create', [AddressController::class, 'store'])->name('addresses.store')->middleware('can:addresses_create');
            Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('addresses.edit')->middleware('can:addresses_edit');
            Route::post('/update/{id}', [AddressController::class, 'update'])->name('addresses.update')->middleware('can:addresses_edit');
            Route::get('/destroy', [AddressController::class, 'destroy'])->name('addresses.destroy')->middleware('can:addresses_destroy');
            Route::post('/getLocation', [AddressController::class, 'getLocation'])->name('addresses.getLocation');
            Route::post('/active', [AddressController::class, 'active'])->name('addresses.active');
        });
        Route::group(['prefix' => '/pages'], function () {
            Route::get('index', [PageController::class, 'index'])->name('pages.index')->middleware('can:pages_index');
            Route::get('create', [PageController::class, 'create'])->name('pages.create')->middleware('can:pages_create');
            Route::post('create', [PageController::class, 'store'])->name('pages.store')->middleware('can:pages_create');
            Route::get('edit/{id}', [PageController::class, 'edit'])->name('pages.edit')->middleware('can:pages_edit');
            Route::post('update/{id}', [PageController::class, 'update'])->name('pages.update')->middleware('can:pages_edit');
            Route::get('destroy', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('can:pages_destroy');
        });
        //order
        Route::group(['prefix' => '/orders'], function () {
            Route::get('index', [OrderController::class, 'index'])->name('orders.index')->middleware('can:orders_index');
            Route::get('edit/{id}', [OrderController::class, 'edit'])->name('orders.edit')->middleware('can:orders_edit');
            Route::post('update/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware('can:orders_edit');
            Route::get('destroy', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('can:orders_destroy');
            Route::post('ajax/ajax-upload-status', [OrderController::class, 'ajaxUploadStatus'])->name('orders.ajaxUploadStatus');
            Route::get('export', [OrderController::class, 'export'])->name('orders.export');
        });
        //order logs
        Route::group(['prefix' => '/order-logs'], function () {
            Route::get('index', [OrderLogsController::class, 'index'])->name('orderLogs.index')->middleware('can:order_logs_index');
        });
        //quản lý lịch sử thanh toán online VNPAY,MOMO...
        Route::get('orders-payment/index', [OrderController::class, 'payment'])->name('orders.payment')->middleware('can:orders_payment_index');
        //cấu hình đơn hàng
        Route::group(['prefix' => '/orders-config'], function () {
            Route::get('index', [OrderController::class, 'configOrder'])->name('orders.config')->middleware('can:order_configs_index');
            Route::get('edit/{id}', [OrderController::class, 'configOrderEdit'])->name('orders.configEdit')->middleware('can:order_configs_index');
            Route::post('update/{id}', [OrderController::class, 'configOrderUpdate'])->name('orders.configUpdate')->middleware('can:order_configs_index');
        });
        //hoàn hàng
        Route::group(['prefix' => '/orders-returns'], function () {
            Route::get('index', [OrderController::class, 'returns'])->name('orders.returns')->middleware('can:orders_index');
            Route::post('returns-edit', [OrderController::class, 'returnsEdit'])->name('orders.returnsEdit')->middleware('can:orders_index');
            Route::post('returns-update', [OrderController::class, 'returnsUpdate'])->name('orders.returnsUpdate')->middleware('can:orders_index');
        });

        //comments
        Route::group(['prefix' => '/comments'], function () {
            Route::get('index/products', [CommentController::class, 'index'])->name('comments.index')->middleware('can:comments_index');
            Route::get('index/articles', [CommentController::class, 'indexArticles'])->name('comments_articles.index')->middleware('can:comments_index');
            Route::get('edit/{id}', [CommentController::class, 'edit'])->name('comments.edit')->middleware('can:comments_edit');
            Route::post('update/{id}', [CommentController::class, 'update'])->name('comments.update')->middleware('can:comments_edit');
            Route::get('destroy', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('can:comments_destroy');
        });
        //customer category
        Route::group(['prefix' => '/customer-categories'], function () {
            Route::get('index', [CustomerCategoryController::class, 'index'])->name('customer_categories.index')->middleware('can:customers_index');
            Route::get('create', [CustomerCategoryController::class, 'create'])->name('customer_categories.create')->middleware('can:customers_create');
            Route::post('store', [CustomerCategoryController::class, 'store'])->name('customer_categories.store')->middleware('can:customers_create');
            Route::get('edit/{id}', [CustomerCategoryController::class, 'edit'])->name('customer_categories.edit')->middleware('can:customers_edit');
            Route::post('update/{id}', [CustomerCategoryController::class, 'update'])->name('customer_categories.update')->middleware('can:customers_edit');
            Route::get('destroy', [CustomerCategoryController::class, 'destroy'])->name('customer_categories.destroy')->middleware('can:customers_destroy');
        });
        //customer
        Route::group(['prefix' => '/customers'], function () {
            Route::get('index', [CustomerController::class, 'index'])->name('customers.index')->middleware('can:customers_index');
            Route::get('create', [CustomerController::class, 'create'])->name('customers.create')->middleware('can:customers_create');
            Route::post('store', [CustomerController::class, 'store'])->name('customers.store')->middleware('can:customers_create');
            Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('can:customers_edit');
            Route::post('update/{id}', [CustomerController::class, 'update'])->name('customers.update')->middleware('can:customers_edit');
            Route::get('destroy', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('can:customers_destroy');
            Route::get('/excel/export-customer', [CustomerController::class, 'exportCustomer'])->name('customers.export');
            //order
            Route::get('orders/{id}', [BackendOrderController::class, 'orders'])->name('customers.orders')->middleware('can:orders_index');
            Route::get('orders-create/{id}/{orderID}', [BackendOrderController::class, 'create'])->name('customers.orderCreate')->middleware('can:orders_index');
            Route::get('orders-success/{id}/{orderID}', [BackendOrderController::class, 'successOrder'])->name('customers.orderSuccess')->middleware('can:orders_index');
            Route::post('ajax-list-product', [BackendOrderController::class, 'ajaxListProduct'])->name('customers.ajaxListProduct');
            Route::post('add-to-cart-copy-order', [BackendOrderController::class, 'addToCart'])->name('customers.addToCartCopyOrder');
            Route::post('update-cart-copy-order', [BackendOrderController::class, 'updateCart'])->name('customers.updateCartCopyOrder');
            Route::post('submit-copy-order', [BackendOrderController::class, 'submit'])->name('customers.submitCopyCart');
            //lấy danh sách tỉnh thành phố,... phí ship
            Route::post('/get-location', [BackendOrderController::class, 'getLocation'])->name('customers.getLocationAdmin');
            Route::post('/get-shipping', [BackendOrderController::class, 'getFeeShip'])->name('customers.getPriceShipAdmin');
        });
        Route::group(['prefix' => '/customer-levels'], function () {
            Route::get('index', [CustomerLevelController::class, 'index'])->name('customer_levels.index')->middleware('can:customer_levels_index');
            Route::post('store', [CustomerLevelController::class, 'store'])->name('customer_levels.store')->middleware('can:customer_levels_index');
            Route::post('/update/{id}', [CustomerLevelController::class, 'update'])->name('customer_levels.update')->middleware('can:customer_levels_index');
        });
        //customer social
        Route::group(['prefix' => '/customer-socials'], function () {
            Route::get('/index', [CustomerSocialController::class, 'index'])->name('customer_socials.index')->middleware('can:customer_socials_edit');
            Route::post('/update/{id}', [CustomerSocialController::class, 'update'])->name('customer_socials.update')->middleware('can:customer_socials_edit');
        });
        Route::group(['prefix' => '/customer-logs'], function () {
            Route::get('index', [CustomerLogsController::class, 'index'])->name('customer_logs.index')->middleware('can:customer_logs_index');
        });
        //dropzone
        Route::group(['prefix' => '/dropzone'], function () {
            Route::post('/dropzone-upload', [ComponentsController::class, 'dropzone_upload'])->name('dropzone_upload');
            Route::post('/dropzone-delete', [ComponentsController::class, 'dropzone_delete'])->name('dropzone_delete');
        });
        //website
        Route::group(['prefix' => '/websites'], function () {
            Route::get('index', [WebsiteController::class, 'index'])->name('websites.index')->middleware('can:websites_index');
            Route::post('folder', [WebsiteController::class, 'folder'])->name('websites.folder')->middleware('can:websites_index');
            Route::get('create', [WebsiteController::class, 'create'])->name('websites.create')->middleware('can:websites_create');
            Route::post('store', [WebsiteController::class, 'store'])->name('websites.store')->middleware('can:websites_create');
            Route::get('edit/{id}', [WebsiteController::class, 'edit'])->name('websites.edit')->middleware('can:websites_edit');
            Route::post('update/{id}', [WebsiteController::class, 'update'])->name('websites.update')->middleware('can:websites_edit');
            Route::post('publish', [WebsiteController::class, 'publish'])->name('websites.publish')->middleware('can:websites_edit');
        });
        //taxes
        Route::group(['prefix' => '/taxes'], function () {
            Route::get('index', [TaxController::class, 'index'])->name('taxes.index')->middleware('can:taxes_index');
            Route::post('create', [TaxController::class, 'create'])->name('taxes.create')->middleware('can:taxes_create');
            Route::post('edit', [TaxController::class, 'edit'])->name('taxes.edit')->middleware('can:taxes_edit');
            Route::post('update', [TaxController::class, 'update'])->name('taxes.update')->middleware('can:taxes_edit');
            Route::post('config', [TaxController::class, 'config'])->name('taxes.config')->middleware('can:taxes_edit');
        });
        //nhà cung cấp
        Route::group(['prefix' => '/suppliers'], function () {
            Route::get('index', [SuppliersController::class, 'index'])->name('suppliers.index')->middleware('can:suppliers_index');
            Route::get('create', [SuppliersController::class, 'create'])->name('suppliers.create')->middleware('can:suppliers_create');
            Route::post('store', [SuppliersController::class, 'store'])->name('suppliers.store')->middleware('can:suppliers_create');
            Route::get('edit/{id}', [SuppliersController::class, 'edit'])->name('suppliers.edit')->middleware('can:suppliers_edit');
            Route::post('update/{id}', [SuppliersController::class, 'update'])->name('suppliers.update')->middleware('can:suppliers_edit');
            Route::get('export', [SuppliersController::class, 'export'])->name('suppliers.export')->middleware('can:suppliers_index');
            Route::post('import', [SuppliersController::class, 'import'])->name('suppliers.import')->middleware('can:suppliers_create');
        });
        Route::group(['prefix' => '/suppliers-categories'], function () {
            Route::get('index', [SuppliersCategoryController::class, 'index'])->name('suppliers_categories.index')->middleware('can:suppliers_categories_index');
            Route::post('store', [SuppliersCategoryController::class, 'store'])->name('suppliers_categories.store')->middleware('can:suppliers_categories_create');
            Route::post('edit', [SuppliersCategoryController::class, 'edit'])->name('suppliers_categories.edit')->middleware('can:suppliers_categories_edit');
            Route::post('update', [SuppliersCategoryController::class, 'update'])->name('suppliers_categories.update')->middleware('can:suppliers_categories_edit');
        });
        //Sản phẩm - Nhập hàng
        Route::group(['prefix' => '/product-purchases'], function () {
            Route::get('show/{id}', [ProductPurchaseController::class, 'show'])->name('product_purchases.show')->middleware('can:product_purchases_index');
            Route::get('index', [ProductPurchaseController::class, 'index'])->name('product_purchases.index')->middleware('can:product_purchases_index');
            Route::get('create', [ProductPurchaseController::class, 'create'])->name('product_purchases.create')->middleware('can:product_purchases_create');
            Route::post('store', [ProductPurchaseController::class, 'store'])->name('product_purchases.store')->middleware('can:product_purchases_create');
            Route::get('edit/{id}', [ProductPurchaseController::class, 'edit'])->name('product_purchases.edit')->middleware('can:product_purchases_edit');
            Route::post('update/{id}', [ProductPurchaseController::class, 'update'])->name('product_purchases.update')->middleware('can:product_purchases_edit');
            Route::get('export', [ProductPurchaseController::class, 'export'])->name('product_purchases.export')->middleware('can:product_purchases_index');
            Route::post('import', [ProductPurchaseController::class, 'import'])->name('product_purchases.import')->middleware('can:product_purchases_create');
            Route::post('ajaxListSuppliers', [ProductPurchaseController::class, 'ajaxListSuppliers'])->name('product_purchases.ajaxListSuppliers');
            Route::post('ajaxListProducts', [ProductPurchaseController::class, 'ajaxListProducts'])->name('product_purchases.ajaxListProducts');
            Route::post('addToCartPurchases', [ProductPurchaseController::class, 'addToCartPurchases'])->name('product_purchases.addToCartPurchases');
            Route::post('ajaxAddToCartModalPopup', [ProductPurchaseController::class, 'ajaxAddToCartModalPopup'])->name('product_purchases.ajaxAddToCartModalPopup');
            Route::post('ajaxUpdateCartPurchases', [ProductPurchaseController::class, 'ajaxUpdateCartPurchases'])->name('product_purchases.ajaxUpdateCartPurchases');
            Route::post('addDiscount', [ProductPurchaseController::class, 'addDiscount'])->name('product_purchases.addDiscount');
            Route::post('ajaxSaveSessionSurcharge', [ProductPurchaseController::class, 'ajaxSaveSessionSurcharge'])->name('product_purchases.ajaxSaveSessionSurcharge');
            Route::post('validateForm', [ProductPurchaseController::class, 'validateForm'])->name('product_purchases.validateForm');
            Route::post('store-financials', [ProductPurchaseController::class, 'storeFinancials'])->name('product_purchases.storeFinancials');
            Route::post('store-stocks', [ProductPurchaseController::class, 'storeStocks'])->name('product_purchases.storeStocks');
            //trả hàng
            Route::group(['prefix' => '/returns'], function () {
                Route::get('/', [ProductPurchaseController::class, 'return_index'])->name('product_purchases.return_index')->middleware('can:product_purchases_index');
                Route::get('show/{id}', [ProductPurchaseController::class, 'return_show'])->name('product_purchases.return_show')->middleware('can:product_purchases_index');
                Route::get('create/{id}', [ProductPurchaseController::class, 'return_create'])->name('product_purchases.return_create')->middleware('can:product_purchases_create');
                Route::post('store/{id}', [ProductPurchaseController::class, 'return_store'])->name('product_purchases.return_store');
            });
        });

        //sổ quỹ - phiếu chi
        Route::group(['prefix' => '/payment-groups'], function () {
            Route::get('index', [PaymentGroupsController::class, 'index'])->name('payment_groups.index')->middleware('can:payment_vouchers_index');
            Route::post('store', [PaymentGroupsController::class, 'store'])->name('payment_groups.store')->middleware('can:payment_vouchers_create');
            Route::post('edit', [PaymentGroupsController::class, 'edit'])->name('payment_groups.edit')->middleware('can:payment_vouchers_edit');
            Route::post('update', [PaymentGroupsController::class, 'update'])->name('payment_groups.update')->middleware('can:payment_vouchers_edit');
        });
        Route::group(['prefix' => '/payment-vouchers'], function () {
            Route::get('index', [PaymentVouchersController::class, 'index'])->name('payment_vouchers.index')->middleware('can:payment_vouchers_index');
            Route::get('create', [PaymentVouchersController::class, 'create'])->name('payment_vouchers.create')->middleware('can:payment_vouchers_create');
            Route::post('store', [PaymentVouchersController::class, 'store'])->name('payment_vouchers.store')->middleware('can:payment_vouchers_create');
            Route::get('edit/{id}', [PaymentVouchersController::class, 'edit'])->name('payment_vouchers.edit')->middleware('can:payment_vouchers_edit');
            Route::post('update/{id}', [PaymentVouchersController::class, 'update'])->name('payment_vouchers.update')->middleware('can:payment_vouchers_edit');
            Route::post('get-module', [PaymentVouchersController::class, 'getModule'])->name('payment_vouchers.getModule')->middleware('can:payment_vouchers_index');
            Route::post('ajax-search', [PaymentVouchersController::class, 'ajaxSearch'])->name('payment_vouchers.ajaxSearch')->middleware('can:payment_vouchers_index');
            Route::post('ajax-delete', [PaymentVouchersController::class, 'ajaxDelete'])->name('payment_vouchers.ajaxDelete')->middleware('can:payment_vouchers_destroy');
        });
        //sổ quỹ - phiếu thu
        Route::group(['prefix' => '/receipt-groups'], function () {
            Route::get('index', [ReceiptGroupsController::class, 'index'])->name('receipt_groups.index')->middleware('can:receipt_vouchers_index');
            Route::post('store', [ReceiptGroupsController::class, 'store'])->name('receipt_groups.store')->middleware('can:receipt_vouchers_create');
            Route::post('edit', [ReceiptGroupsController::class, 'edit'])->name('receipt_groups.edit')->middleware('can:receipt_vouchers_edit');
            Route::post('update', [ReceiptGroupsController::class, 'update'])->name('receipt_groups.update')->middleware('can:receipt_vouchers_edit');
        });
        Route::group(['prefix' => '/receipt-vouchers'], function () {
            Route::get('index', [ReceiptVouchersController::class, 'index'])->name('receipt_vouchers.index')->middleware('can:receipt_vouchers_index');
            Route::get('create', [ReceiptVouchersController::class, 'create'])->name('receipt_vouchers.create')->middleware('can:receipt_vouchers_create');
            Route::post('store', [ReceiptVouchersController::class, 'store'])->name('receipt_vouchers.store')->middleware('can:receipt_vouchers_create');
            Route::get('edit/{id}', [ReceiptVouchersController::class, 'edit'])->name('receipt_vouchers.edit')->middleware('can:receipt_vouchers_edit');
            Route::post('update/{id}', [ReceiptVouchersController::class, 'update'])->name('receipt_vouchers.update')->middleware('can:receipt_vouchers_edit');
            Route::post('get-module', [ReceiptVouchersController::class, 'getModule'])->name('receipt_vouchers.getModule')->middleware('can:receipt_vouchers_index');
            Route::post('ajax-search', [ReceiptVouchersController::class, 'ajaxSearch'])->name('receipt_vouchers.ajaxSearch')->middleware('can:receipt_vouchers_index');
            Route::post('ajax-delete', [ReceiptVouchersController::class, 'ajaxDelete'])->name('receipt_vouchers.ajaxDelete')->middleware('can:receipt_vouchers_destroy');
        });
        //Sản phẩm mua kèm
        Route::group(['prefix' => '/product-deals'], function () {
            Route::get('index', [ProductDealController::class, 'index'])->name('product_deals.index')->middleware('can:product_deals_index');
            Route::get('create', [ProductDealController::class, 'create'])->name('product_deals.create')->middleware('can:product_deals_create');
            Route::post('store', [ProductDealController::class, 'store'])->name('product_deals.store')->middleware('can:product_deals_create');
            Route::get('edit/{id}', [ProductDealController::class, 'edit'])->name('product_deals.edit')->middleware('can:product_deals_edit');
            Route::post('update/{id}', [ProductDealController::class, 'update'])->name('product_deals.update')->middleware('can:product_deals_edit');
            //ajax
            Route::group(['prefix' => '/product-deals'], function () {
                Route::post('pagination', [ProductDealController::class, 'pagination'])->name('product_deals.pagination')->middleware('can:product_deals_index');
                Route::post('save-product-one', [ProductDealController::class, 'saveProductOne'])->name('product_deals.saveProductOne')->middleware('can:product_deals_create');
                Route::post('save-product-two', [ProductDealController::class, 'saveProductTwo'])->name('product_deals.saveProductTwo')->middleware('can:product_deals_create');
                Route::post('changePrice', [ProductDealController::class, 'changePrice'])->name('product_deals.changePrice')->middleware('can:product_deals_create');
            });
        });
        //crawler
        Route::group(['prefix' => '/crawler'], function () {
            Route::get('index', [ProductTmpController::class, 'index'])->name('product_tmps.index');
            Route::get('create', [ProductTmpController::class, 'create'])->name('product_tmps.create');
            Route::get('crawler', [ProductTmpController::class, 'crawler'])->name('product_tmps.crawler');
            Route::get('crawler-version', [ProductTmpController::class, 'crawler_version'])->name('product_tmps.crawler_version');
            Route::get('crawler-stock', [ProductTmpController::class, 'crawler_stock'])->name('product_tmps.crawler_stock');
            Route::get('crawler-image', [ProductTmpController::class, 'crawler_image'])->name('product_tmps.crawler_image');
        });
        //polylang
        Route::get('/search/autocomplete', [PolyLangController::class, 'autocomplete'])->name('search.autocomplete');
        //quiz
        Route::group(['prefix' => '/quiz-categories'], function () {
            Route::get('index', [QuizCategoryController::class, 'index'])->name('quiz_categories.index')->middleware('can:quiz_categories_index');
            Route::get('create', [QuizCategoryController::class, 'create'])->name('quiz_categories.create')->middleware('can:quiz_categories_create');
            Route::post('store', [QuizCategoryController::class, 'store'])->name('quiz_categories.store')->middleware('can:quiz_categories_create');
            Route::get('edit/{id}', [QuizCategoryController::class, 'edit'])->name('quiz_categories.edit')->middleware('can:quiz_categories_edit');
            Route::post('update/{id}', [QuizCategoryController::class, 'update'])->name('quiz_categories.update')->middleware('can:quiz_categories_edit');
        });
        Route::group(['prefix' => '/quizzes'], function () {
            Route::get('index', [QuizController::class, 'index'])->name('quizzes.index')->middleware('can:quizzes_index');
            Route::get('create', [QuizController::class, 'create'])->name('quizzes.create')->middleware('can:quizzes_create');
            Route::post('store', [QuizController::class, 'store'])->name('quizzes.store')->middleware('can:quizzes_create');
            Route::get('edit/{id}', [QuizController::class, 'edit'])->name('quizzes.edit')->middleware('can:quizzes_edit');
            Route::post('update/{id}', [QuizController::class, 'update'])->name('quizzes.update')->middleware('can:quizzes_edit');
            Route::post('store-quiz', [QuizController::class, 'storeQuiz'])->name('quizzes.storeQuiz')->middleware('can:quizzes_edit');
            Route::post('add', [QuizController::class, 'add'])->name('quizzes.add')->middleware('can:quizzes_edit');
            Route::post('order', [QuizController::class, 'order'])->name('quizzes.order')->middleware('can:quizzes_edit');
            Route::post('quizzes-ajax-delete', [QuizController::class, 'delete'])->name('quizzes.ajax.delete')->middleware('can:quizzes_edit');
            Route::post('quizzes-ajax-delete-all', [QuizController::class, 'deleteAll'])->name('quizzes.ajax.deleteAll')->middleware('can:quizzes_edit');
            Route::post('import', [QuizController::class, 'import'])->name('quizzes.import')->middleware('can:quizzes_create');
        });
        Route::group(['prefix' => '/questions'], function () {
            Route::get('index', [QuestionController::class, 'index'])->name('questions.index')->middleware('can:questions_index');
            Route::get('create', [QuestionController::class, 'create'])->name('questions.create')->middleware('can:questions_create');
            Route::post('store', [QuestionController::class, 'store'])->name('questions.store')->middleware('can:questions_create');
            Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('questions.edit')->middleware('can:questions_edit');
            Route::post('update/{id}', [QuestionController::class, 'update'])->name('questions.update')->middleware('can:questions_edit');
            Route::post('autocomplete', [QuestionController::class, 'autocomplete'])->name('questions.autocomplete');
            Route::post('rewrite/create', [QuestionController::class, 'createRewrite'])->name('questions.createRewrite');
            Route::post('rewrite/update', [QuestionController::class, 'updateRewrite'])->name('questions.updateRewrite');
            Route::post('rewrite/delete', [QuestionController::class, 'deleteRewrite'])->name('questions.deleteRewrite');
        });

        Route::group(['prefix' => '/question-option-users'], function () {
            Route::get('index', [QuestionOptionUsersController::class, 'index'])->name('question_option_users.index')->middleware('can:question_option_users_index');
            Route::get('edit/{id}', [QuestionOptionUsersController::class, 'edit'])->name('question_option_users.edit')->middleware('can:question_option_users_edit');
            Route::post('update/{id}', [QuestionOptionUsersController::class, 'update'])->name('question_option_users.update')->middleware('can:question_option_users_edit');
            Route::get('/excel', [QuestionOptionUsersController::class, 'export'])->name('question_option_users.export');
        });
        Route::group(['prefix' => '/quiz-configs'], function () {
            Route::get('index', [QuizConfigController::class, 'index'])->name('quiz_configs.index')->middleware('can:quiz_configs_index');
            Route::get('create', [QuizConfigController::class, 'create'])->name('quiz_configs.create')->middleware('can:quiz_configs_create');
            Route::post('store', [QuizConfigController::class, 'store'])->name('quiz_configs.store')->middleware('can:quiz_configs_create');
            Route::get('edit/{id}', [QuizConfigController::class, 'edit'])->name('quiz_configs.edit')->middleware('can:quiz_configs_edit');
            Route::post('update/{id}', [QuizConfigController::class, 'update'])->name('quiz_configs.update')->middleware('can:quiz_configs_edit');
        });
        Route::group(['prefix' => '/course-categories'], function () {
            Route::get('index', [CourseCategoryController::class, 'index'])->name('course_categories.index')->middleware('can:course_categories_index');
            Route::get('create', [CourseCategoryController::class, 'create'])->name('course_categories.create')->middleware('can:course_categories_create');
            Route::post('store', [CourseCategoryController::class, 'store'])->name('course_categories.store')->middleware('can:course_categories_create');
            Route::get('edit/{id}', [CourseCategoryController::class, 'edit'])->name('course_categories.edit')->middleware('can:course_categories_edit');
            Route::post('update/{id}', [CourseCategoryController::class, 'update'])->name('course_categories.update')->middleware('can:course_categories_edit');
        });
        Route::group(['prefix' => '/courses'], function () {
            Route::get('index', [CourseController::class, 'index'])->name('courses.index')->middleware('can:courses_index');
            Route::get('create', [CourseController::class, 'create'])->name('courses.create')->middleware('can:courses_create');
            Route::post('store', [CourseController::class, 'store'])->name('courses.store')->middleware('can:courses_create');
            Route::get('edit/{id}', [CourseController::class, 'edit'])->name('courses.edit')->middleware('can:courses_edit');
            Route::post('update/{id}', [CourseController::class, 'update'])->name('courses.update')->middleware('can:courses_edit');
        });
        Route::group(['prefix' => '/order-online'], function () {
            Route::get('index', [OrderOnlineController::class, 'index'])->name('order_onlines.index')->middleware('can:order_onlines_index');
            Route::post('index', [OrderOnlineController::class, 'ajaxUploadStatus'])->name('order_onlines.ajaxUploadStatus')->middleware('can:order_onlines_index');
        });
        Route::group(['prefix' => '/faqs'], function () {
            Route::get('index', [FaqController::class, 'index'])->name('faqs.index')->middleware('can:faqs_index');
            Route::get('create', [FaqController::class, 'create'])->name('faqs.create')->middleware('can:faqs_create');
            Route::post('store', [FaqController::class, 'store'])->name('faqs.store')->middleware('can:faqs_create');
            Route::get('edit/{id}', [FaqController::class, 'edit'])->name('faqs.edit')->middleware('can:faqs_edit');
            Route::post('update/{id}', [FaqController::class, 'update'])->name('faqs.update')->middleware('can:faqs_edit');
        });
        Route::group(['prefix' => '/faq-categories'], function () {
            Route::get('index', [FaqCategoryController::class, 'index'])->name('faq_categories.index')->middleware('can:faqs_index');
            Route::get('create', [FaqCategoryController::class, 'create'])->name('faq_categories.create')->middleware('can:faqs_create');
            Route::post('store', [FaqCategoryController::class, 'store'])->name('faq_categories.store')->middleware('can:faqs_create');
            Route::get('edit/{id}', [FaqCategoryController::class, 'edit'])->name('faq_categories.edit')->middleware('can:faqs_edit');
            Route::post('update/{id}', [FaqCategoryController::class, 'update'])->name('faq_categories.update')->middleware('can:faqs_edit');
        });
        Route::group(['prefix' => '/teams'], function () {
            Route::get('index', [TeamController::class, 'index'])->name('teams.index')->middleware('can:teams_index');
            Route::get('create', [TeamController::class, 'create'])->name('teams.create')->middleware('can:teams_create');
            Route::post('store', [TeamController::class, 'store'])->name('teams.store')->middleware('can:teams_create');
            Route::get('edit/{id}', [TeamController::class, 'edit'])->name('teams.edit')->middleware('can:teams_edit');
            Route::post('update/{id}', [TeamController::class, 'update'])->name('teams.update')->middleware('can:teams_edit');
        });
        Route::group(['prefix' => '/faculty-categories'], function () {
            Route::get('index', [FacultyCategoriesController::class, 'index'])->name('faculty_categories.index')->middleware('can:faculty_categories_index');
            Route::get('create', [FacultyCategoriesController::class, 'create'])->name('faculty_categories.create')->middleware('can:faculty_categories_create');
            Route::post('store', [FacultyCategoriesController::class, 'store'])->name('faculty_categories.store')->middleware('can:faculty_categories_create');
            Route::get('edit/{id}', [FacultyCategoriesController::class, 'edit'])->name('faculty_categories.edit')->middleware('can:faculty_categories_edit');
            Route::post('update/{id}', [FacultyCategoriesController::class, 'update'])->name('faculty_categories.update')->middleware('can:faculty_categories_edit');
        });
        Route::group(['prefix' => '/faculties'], function () {
            Route::get('index', [FacultiesController::class, 'index'])->name('faculties.index')->middleware('can:faculties_index');
            Route::get('create', [FacultiesController::class, 'create'])->name('faculties.create')->middleware('can:faculties_create');
            Route::post('store', [FacultiesController::class, 'store'])->name('faculties.store')->middleware('can:faculties_create');
            Route::get('edit/{id}', [FacultiesController::class, 'edit'])->name('faculties.edit')->middleware('can:faculties_edit');
            Route::post('update/{id}', [FacultiesController::class, 'update'])->name('faculties.update')->middleware('can:faculties_edit');
        });
    });
    Route::get('/language/{language}', [ComponentsController::class, 'language'])->name('components.language');
});

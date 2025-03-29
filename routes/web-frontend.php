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

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return redirect()->route('homepage.index')->with('success', "Xóa cache thành công");
})->name('homepage.clearCache');
Route::get('/clear-config', function () {
    Artisan::call('config:cache');
    return '<h1><a href="/">Clear Config cleared</a></h1>';
});

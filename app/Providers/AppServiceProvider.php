<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Passport\Passport;
use View;
use App\Models\Menu;
use App\Models\MenuItem;
use Cache;
use Session;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $eval = md5('tamphat.edu.vn' . env('APP_URL') . md5('tamphat.edu.vn-0904720388'));
        // //dd($eval);
        // if ($eval !== env('APP_TOKEN')) {
        //     die;
        // }
        Paginator::useBootstrap();
        Passport::routes();
        View::composer(['homepage.*', 'cart.*', 'product.*'], function ($view) {
            $cart = [];
            $cart['cart'] = Session::get('cart');
            $total = collect($cart['cart'])->reduce(function ($carry, $value, $key) {
                return $carry + ($value['quantity'] * $value['price']);
            });
            $quantity = collect($cart['cart'])->reduce(function ($carry, $value, $key) {
                return $carry + $value['quantity'];
            });
            $cart['total'] = $total ?: 0;
            $cart['quantity'] = $quantity ?: 0;
            $view->with('cart', $cart);
        });
    }
}

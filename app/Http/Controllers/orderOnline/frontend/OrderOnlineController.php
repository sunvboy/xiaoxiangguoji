<?php

namespace App\Http\Controllers\orderOnline\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\OrderOnline;
use Illuminate\Http\Request;
use Auth;

class OrderOnlineController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request)
    {
        $id = Auth::guard('customer')->user()->id;
        $data =  OrderOnline::where('customer_id', $id)->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('name', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = "Đặt thuốc online";
        $seo['canonical'] = route('customer.orderOnline');

        return view('orderOnline.frontend.index', compact('seo', 'data', 'fcSystem'));
    }
}

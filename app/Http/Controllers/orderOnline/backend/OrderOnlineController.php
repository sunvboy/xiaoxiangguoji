<?php

namespace App\Http\Controllers\orderOnline\backend;

use App\Http\Controllers\Controller;
use App\Models\OrderOnline;
use Illuminate\Http\Request;

class OrderOnlineController extends Controller
{
    protected $table = 'order_onlines';
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $data =  OrderOnline::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('name', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $module = $this->table;
        return view('orderOnline.backend.index', compact('module', 'data'));
    }
    public function ajaxUploadStatus(Request $request)
    {
        $id = $request->id;
        OrderOnline::find($id)->update(['status' => $request->status]);
        $detail = OrderOnline::find($id);
    }
}

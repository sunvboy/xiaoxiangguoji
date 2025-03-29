<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerLog;
use Illuminate\Http\Request;

class CustomerLogsController extends Controller
{
    protected $table = 'customer_logs';
    public function index(Request $request)
    {
        $module = $this->table;
        $data = CustomerLog::orderBy('id', 'desc')->with('user');
        if (is($request->date)) {
            $date =  explode(' to ', $request->date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->date)) {
            $data->appends(['date' => $request->date]);
        }
        return view('customer.logs.index', compact('module', 'data'));
    }
}

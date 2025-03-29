<?php

namespace App\Http\Controllers\notification\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request)
    {
        $fcSystem = $this->system->fcSystem();
        $data = Notification::with(['QuestionOptionUser' => function ($q) {
            $q->with('quizzes');
        }])->where(['customer_id' => Auth::guard('customer')->user()->id])->orderBy('id', 'desc')->paginate(20);
        $seo['meta_title'] = "Danh sách thông báo";
        return view('notification.frontend.index', compact('seo', 'data', 'fcSystem'));
    }
    public function indexPost(Request $request)
    {
        $customer_id = $request->customer_id;
        $notifications = Notification::with(['QuestionOptionUser' => function ($q) {
            $q->with('quizzes');
        }])->where(['customer_id' => $customer_id])->orderBy('id', 'desc')->limit(10)->get();
        if (svl_ismobile() == 'is mobile') {
            return response()->json([
                'html' => view('homepage.mobile.notifications', compact('notifications'))->render(),
            ]);
        } else {
            return response()->json([
                'html' => view('homepage.common.notifications', compact('notifications'))->render(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\contact\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Components\System;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index()
    {
        //page: Contact

        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'contact'])->select('meta_title', 'meta_description', 'image', 'title', 'description')->first();
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('contact.frontend.index', compact('fcSystem', 'seo', 'page'));
    }
    public function store(Request $request)
    {
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => ['required', new PhoneNumber],
                // 'message' => 'required',
            ], [
                'fullname.required' => 'Trường Họ và tên là trường bắt buộc.',
                'email.required' => 'Email là trường bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'phone.required' => 'Số điện thoại không được để trống.',
                // 'phone.regex'        => 'Số điện thoại không hợp lệ.',
                // 'phone.numeric' => 'Số điện thoại không đúng định dạng.',
                // 'message.required' => 'Nội dung là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required',
            ]);
        }
        if ($validator->passes()) {
            $id = Contact::insertGetId([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->subject,
                'message' => $request->message,
                'type' => 'contact',
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '500']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function subcribers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => ['required'],
        ], [
            'fullname.required' => '姓名是必填项。',
            'email.required' => '电子邮件是必填项。',
            'email.email' => '电子邮件格式不正确。',
            'phone.required' => '电话号码不能为空。',
        ]);
        $message = '';
        if (!empty($request->service)) {
            $message .= '<div><b class="text-danger font-bold">课程: </b> ' . $request->service . '</div><br>';
        }
        if (!empty($request->message)) {
            $message .= '<div><b class="text-danger font-bold">其他信息: </b> ' . $request->message . '</div><br>';
        }

        if ($validator->passes()) {
            $id = Contact::insertGetId([
                'name' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => !empty($request->address) ? $request->address : "",
                'message' => $message,
                'type' => 'email',
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 500]);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}

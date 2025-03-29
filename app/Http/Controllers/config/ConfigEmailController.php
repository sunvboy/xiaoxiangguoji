<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use App\Models\ConfigEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfigEmailController extends Controller
{
    protected $module = 'config_emails';
    public function index()
    {
        $module  = $this->module;
        // $data = ConfigEmail::orderBy('id', 'desc')->get();
        $detail  = ConfigEmail::find(1);
        return view('config.email.edit', compact('module', 'detail'));
    }
    public function create()
    {
        $module  = $this->module;
        return view('config.email.create', compact('module'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $_data = [
            'title' => $request->title,
            'data' => !empty($request->email) ? json_encode($request->email) : '',
            'created_at' => Carbon::now(),
        ];
        $id = ConfigEmail::insertGetId($_data);
        if ($id > 0) {
            return redirect()->route('config_emails.index')->with('success', "Thêm mới thành công");
        }
    }

    public function edit($id)
    {
        $detail  = ConfigEmail::find($id);
        if (!isset($detail)) {
            return redirect()->route('config_emails.index')->with('error', "Không tồn tại");
        }
        $module = $this->module;
        return view('config.email.edit', compact('module', 'detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $_data = [
            'title' => $request->title,
            'data' => !empty($request->email) ? json_encode($request->email) : '',
            'updated_at' => Carbon::now(),
        ];
        $check = ConfigEmail::find($id)->update($_data);
        if ($check) {
            return redirect()->route('config_emails.index')->with('success', "Cập nhập thành công");
        }
    }


    public function destroy($id)
    {
    }
}

<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerSocial;
use Illuminate\Http\Request;

class CustomerSocialController extends Controller
{
    protected $module = 'customer_socials';
    public function index()
    {
        $module = $this->module;
        $detail = CustomerSocial::find(1);

        return view('customer.backend.social.index', compact('detail', 'module'));
    }
    public function update(Request $request, $id)
    {
        CustomerSocial::where('id', $id)->update([
            'config' => json_encode($request->config)
        ]);
        return redirect()->route('customer_socials.index')->with('success', 'Cập nhập thành công');
    }
}

<?php

namespace App\Http\Controllers\address\backend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\VNCity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\View;

class AddressController extends Controller
{
    protected $table = 'addresses';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Address::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('address.backend.index', compact('data'));
    }
    public function create()
    {
        $listCity = dropdown(\App\Models\VNCity::orderBy('id', 'asc')->get(), 'Tỉnh/Thành Phố', 'id', 'name');
        $listDistrict = dropdown(\App\Models\VNDistrict::where('ProvinceID', old('cityid'))->orderBy('name', 'asc')->get(), 'Quận/Huyện', 'id', 'name');
        $listWard = dropdown(\App\Models\VNWard::where('DistrictID', old('districtid'))->orderBy('name', 'asc')->get(), 'Phường/Xã', 'id', 'name');
        // foreach($data->LtsItem as $k=>$value) {
        //     DB::table('vn_city')->insert(['id' => $value->ID,'name' => $value->Title]);
        // }
        //$getCity = DB::table('vn_ward')->where('name','Chưa rõ')->delete();
        // foreach($getCity as $k=>$v){
        //     $curl = curl_init();
        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => 'https://thongtindoanhnghiep.co/api/district/'.$v->id.'/ward',
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'GET',
        //     ));
        //     $response = curl_exec($curl);
        //     curl_close($curl);
        //     $data = json_decode($response);
        //     foreach($data as $k=>$value) {
        //         DB::table('vn_ward')->insert(['id' => $value->ID,'name' => $value->Title,'districtid' => $value->QuanHuyenID]);
        //     }
        // }
        //die;
        return view('address.backend.create', compact('listCity', 'listDistrict', 'listWard'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
            'cityid' => 'required|gt:0',
            'districtid' => 'required|gt:0',
            // 'wardid' => 'required|gt:0',
        ], [
            'title.required' => 'Tên cửa hàng là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'cityid.required' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'cityid.gt' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'districtid.required' => 'Quận/Huyện là trường bắt buộc.',
            'districtid.gt' => 'Quận/Huyện là trường bắt buộc.',
            'wardid.required' => 'Phường/Xã là trường bắt buộc.',
            // 'wardid.gt' => 'Phường/Xã là trường bắt buộc.',
        ]);
        //api lấy tọa độ
        /*$data = curl_api('https://maps.googleapis.com/maps/api/geocode/json?address=' . slug($request->address) . '&key=AIzaSyBPYwKdcUYplwZuW9gSMfSB7naz42TcUE0');
        if (!empty($data->error_message)) {
            return redirect()->route('addresses.index')->with('error', $data->error_message);
        } else {
            if (!empty($data)) {
                $lat = $data->results[0]->geometry->location->lat;
                $long = $data->results[0]->geometry->location->lng;
            }
            $image_url = uploadImage($request->file('image'), $this->table);
            $id = Address::insertGetId([
                'title' => $request->title,
                'image' => $image_url,
                'email' => $request->email,
                'hotline' => $request->hotline,
                'address' => $request->address,
                'cityid' => $request->cityid,
                'districtid' => $request->districtid,
                'wardid' => $request->wardid,
                'time' => $request->time,
                'lat' => $lat,
                'long' => $long,
                'publish' => $request->publish,
                'userid_created' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
            if ($id > 0) {
                return redirect()->route('addresses.index')->with('success', "Thêm mới của hàng thành công");
            } else {
                return redirect()->route('addresses.index')->with('error', "Thêm mới của hàng không thành công");
            }
        } */
        $image_url = uploadImage($request->file('image'), $this->table);
        $id = Address::insertGetId([
            'title' => $request->title,
            'image' => !empty($image_url) ? $image_url : $request->image_old,
            'email' => $request->email,
            'hotline' => $request->hotline,
            'address' => $request->address,
            'cityid' => $request->cityid,
            'districtid' => $request->districtid,
            'wardid' => $request->wardid,
            'time' => $request->time,
            'link' => $request->link,
            'iframe' => $request->iframe,
            'image_json' => !empty($request->album) ? json_encode($request->album) : null,
            // 'lat' => $lat,
            // 'long' => $long,
            'publish' => $request->publish,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'alanguage' => config('app.locale'),
        ]);
        if ($id > 0) {
            return redirect()->route('addresses.index')->with('success', "Thêm mới của hàng thành công");
        } else {
            return redirect()->route('addresses.index')->with('error', "Thêm mới của hàng không thành công");
        }
    }
    public function edit($id)
    {
        $detail  = Address::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('addresses.index')->with('error', "Cửa hàng không tồn tại");
        }
        $listCity = dropdown(\App\Models\VNCity::orderBy('id', 'asc')->get(), 'Tỉnh/Thành Phố', 'id', 'name');
        $listDistrict = dropdown(\App\Models\VNDistrict::where('ProvinceID', !empty(old('city_id')) ? old('city_id') : (!empty($detail->cityid) ? $detail->cityid : ''))->orderBy('name', 'asc')->get(), 'Quận/Huyện', 'id', 'name');
        $listWard = dropdown(\App\Models\VNWard::where('DistrictID', !empty(old('district_id')) ? old('district_id') : (!empty($detail->districtid) ? $detail->districtid : ''))->orderBy('name', 'asc')->get(), 'Phường/Xã', 'id', 'name');
        return view('address.backend.edit', compact('detail', 'listCity', 'listDistrict', 'listWard'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
            'cityid' => 'required|gt:0',
            'districtid' => 'required|gt:0',
            // 'wardid' => 'required|gt:0',
        ], [
            'title.required' => 'Tên cửa hàng là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'cityid.required' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'cityid.gt' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'districtid.required' => 'Quận/Huyện là trường bắt buộc.',
            'districtid.gt' => 'Quận/Huyện là trường bắt buộc.',
            'wardid.required' => 'Phường/Xã là trường bắt buộc.',
            // 'wardid.gt' => 'Phường/Xã là trường bắt buộc.',
        ]);
        //api lấy tọa độ
        // $data = curl_api('https://maps.googleapis.com/maps/api/geocode/json?address='.slug($request->address).'&key=AIzaSyBPYwKdcUYplwZuW9gSMfSB7naz42TcUE0');
        // if(!empty($data->error_message)){
        //     return redirect()->route('address.index')->with('error',$data->error_message);
        // }else{
        //     if(!empty($data)){
        //         $lat = $data->results[0]->geometry->location->lat;
        //         $long = $data->results[0]->geometry->location->lng;
        //     }
        // }
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        Address::find($id)->update([
            'title' => $request->title,
            'image' => $image_url,
            'email' => $request->email,
            'hotline' => $request->hotline,
            'address' => $request->address,
            'cityid' => $request->cityid,
            'districtid' => $request->districtid,
            'wardid' => $request->wardid,
            'time' => $request->time,
            'publish' => $request->publish,
            'link' => $request->link,
            'iframe' => $request->iframe,
            'image_json' => !empty($request->album) ? json_encode($request->album) : null,
            'userid_updated' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('addresses.index')->with('success', "Cập nhập cửa hàng thành công");
    }
    public function getLocation(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $text = '';
        if ($type == 'district') {
            $text = 'Chọn Quận/Huyện';
            $getData = \App\Models\VNDistrict::where('ProvinceID', $id)->orderBy('id', 'asc')->get();
        } else {
            $text = 'Chọn Phường/Xã';
            $getData = \App\Models\VNWard::where('DistrictID', $id)->orderBy('id', 'asc')->get();
        }
        $temp = '';
        $temp .= '<option value="0">' . $text . '</option>';
        if (isset($getData)) {
            foreach ($getData as  $val) {
                $temp .= '<option value="' . $val->id . '">' . $val->name . '</option>';
            }
        }
        echo json_encode(array(
            'html' => $temp,
        ));
        die();
    }
    public function active(Request $request)
    {
        $id = (int) $request->param['id'];
        DB::table('addresses')->update(array('active' => 0));
        $object = Address::where('id', $id)->first();
        $_update['active'] = (($object->active == 1) ? 0 : 1);
        DB::table('addresses')->where('id', $id)->update($_update);
        return response()->json([
            'code' => 200,
        ], 200);
    }
}

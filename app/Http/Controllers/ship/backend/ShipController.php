<?php

namespace App\Http\Controllers\ship\backend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class ShipController extends Controller
{
    protected $table = 'ships';
    public function index(Request $request)
    {
        $data =  Ship::orderBy('id', 'DESC');
        if (env('APP_ENV') != "local") {
            $data = $data->where('id', '!=', 1)->where('id', '!=', 2);
        }
        $data = $data->get();
        $module = $this->table;
        return view('ship.backend.index', compact('data', 'module'));
    }
    public function create()
    {
        $module = $this->table;
        return view('ship.backend.create', compact('module'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tags',
            'URL_API' => 'required',
            'TOKEN_API' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề tag đã tồn tại.',
            'URL_API.required' => 'API URL là trường bắt buộc.',
            'TOKEN_API.required' => 'TOKEN API là trường bắt buộc.',

        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('ships.index')->with('success', "Thêm mới hãng vận chuyển thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Ship::find($id);
        if (!isset($detail)) {
            return redirect()->route('ships.index')->with('error', "Hãng vận chuyển không tồn tại");
        }
        return view('ship.backend.edit', compact('module', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:ships,title,' . $id . ',id',
            'URL_API' => 'required',
            'TOKEN_API' => 'required',

        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề tag đã tồn tại.',
            'URL_API.required' => 'API URL là trường bắt buộc.',
            'TOKEN_API.required' => 'TOKEN API là trường bắt buộc.',
        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('ships.index')->with('success', "Cập nhập hãng vận chuyển thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        $_data = [
            'title' => $request['title'],
            'URL_API' => $request['URL_API'],
            'TOKEN_API' => $request['TOKEN_API'],
            'image' => $image_url,
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Ship::insertGetId($_data);
        } else {
            Ship::find($id)->update($_data);
        }
    }
    public function province(Request $request)
    {
        $module = $this->table;
        $data =  \App\Models\VNCity::orderBy('id', 'asc')->get();
        return view('ship.backend.indexProvince', compact('data', 'module'));
    }
    public function update_one_province(Request $request)
    {
        \App\Models\VNCity::where('id', '=', $request->id)->update(['price' => $request->price]);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function update_all_province(Request $request)
    {
        $ids = $request->list;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                \App\Models\VNCity::where('id', '=', $id)->update(['price' => $request->price]);
            }
        }
        return response()->json([
            'code' => 200,
        ], 200);
    }
}

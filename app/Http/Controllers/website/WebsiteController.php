<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Image;

class WebsiteController extends Controller
{
    protected $type;
    public function __construct()
    {
        $this->module = 'websites';
        $this->type = array(
            '' => "Chọn loại giao diện",
            'header' => "Header",
            'footer' => "Footer",
            'homepage' => "Trang chủ",
            'article' => "Bài viết",
            'article-category' => "Danh mục bài viết",
            'product' => "Sản phẩm",
            'product-category' => "Danh mục sản phẩm",
        );
    }
    public function index()
    {
        $module =  $this->module;
        $data = Website::orderBy('id', 'asc')->get()->groupBy('keyword');
        $type =  $this->type;
        return view('website.index', compact('module', 'data', 'type'));
    }


    public function create()
    {
        $module =  $this->module;
        $data =  $this->type;
        // $headers = File::allFiles(resource_path('views/templates/header'));
        // $footers = File::allFiles(resource_path('views/templates/footer'));
        // $data = array(
        //     'header' => $headers,
        //     'footers' => $footers,
        // );
        return view('website.create', compact('module', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'keyword' => 'required',
            // 'template' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            // 'keyword.required' => 'Loại giao diện là trường bắt buộc.',
            // 'template.required' => 'Chọn file là trường bắt buộc.',
            // 'template.gt' => 'Chọn file là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = $this->uploadImageWebsite($request->file('image'), $request->keyword);
        } else {
            $image_url = '';
        }
        Website::create([
            'title' => $request->title,
            'keyword' => !empty($request->keyword) ? $request->keyword : '',
            'template' => $request->template,
            'image' => $image_url,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('websites.index', ['type' => $request->type])->with('success', 'Thêm mới thành công');
    }




    public function edit($id)
    {
        $module =  $this->module;
        $data =  $this->type;
        $detail =  Website::find($id);
        $folders = File::allFiles(resource_path('views/templates/' . $detail->keyword));
        $temp = [];
        if (isset($folders)) {
            foreach ($folders as  $val) {
                $filename = explode('.', $val->getFilenameWithoutExtension());
                if ($filename[0] != 'header-mobile') {
                    $temp[$val->getFilename()] = $filename[0];
                }
            }
        }
        return view('website.edit', compact('module', 'data', 'detail', 'temp'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'keyword' => 'required',
            // 'template' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            // 'keyword.required' => 'Loại giao diện là trường bắt buộc.',
            // 'template.required' => 'Chọn file là trường bắt buộc.',
            // 'template.gt' => 'Chọn file là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = $this->uploadImageWebsite($request->file('image'), $request->keyword);
        } else {
            $image_url = $request->image_old;
        }
        Website::find($id)->update([
            'title' => $request->title,
            'keyword' => $request->keyword,
            'template' => $request->template,
            'image' => $image_url,
            'userid_updated' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('websites.index')->with('success', 'Cập nhập giao diện thành công');
    }
    function uploadImageWebsite($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            $name_gen = hexdec(uniqid()) . '.webp';
            $base_path = base_path('upload/website/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 666, true);
            }
            // Image::make($image)->insert(url('frontend/images/logo.webp'))->encode('webp', 100)->save($base_path.'/'.$name_gen);
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/website/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
    public function folder(Request $request)
    {
        $folders = File::allFiles(resource_path('views/templates/' . $request->folder));
        $temp = '';
        $temp = $temp . '<option value="">Chọn file</option>';
        if (isset($folders)) {
            foreach ($folders as  $val) {
                $filename = explode('.', $val->getFilenameWithoutExtension());
                if ($filename[0] != 'header-mobile') {
                    $temp = $temp . '<option value="' . $val->getFilename() . '">' . $filename[0] . '</option>';
                }
            }
        }
        echo json_encode(array(
            'html' => $temp,
        ));
        die();
    }
    public function publish(Request $request)
    {
        $id = (int) $request->param['id'];
        DB::table($this->module)->where('keyword', $request->param['keyword'])->update(array('publish' => 0));
        $object = Website::where('id', $id)->first();
        $templatefile = file_get_contents(resource_path('views/templates/' . $object->keyword . '/' . $object->template));
        if ($object->keyword == 'header') {
            file_put_contents(resource_path('views/homepage/common/header.blade.php'), $templatefile);
        } else if ($object->keyword == 'footer') {
            file_put_contents(resource_path('views/homepage/common/footer.blade.php'), $templatefile);
        }
        $_update['publish'] = (($object->publish == 0) ? 1 : 0);
        DB::table($this->module)->where('id', $id)->update($_update);
        return response()->json([
            'code' => 200,
        ], 200);
    }
}

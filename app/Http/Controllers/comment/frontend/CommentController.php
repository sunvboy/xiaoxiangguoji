<?php

namespace App\Http\Controllers\comment\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Components\Comment as CommentHelper;
use Validator;

class CommentController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new CommentHelper();
    }
    //list comment 
    public function getListComment(Request $request)
    {
        $sort = $request->sort;
        $module = !empty($request->module) ? $request->module : 'products';
        $comment_view =  $this->comment->comment(array('id' => $request->module_id, 'sort' => $sort), $module);
        if ($module == 'articles') {
            return view('article.frontend.article.comment._data', compact('comment_view', 'sort'))->render();
        } else {
            return view('product.frontend.product.comment.data', compact('comment_view', 'sort'))->render();
        }
    }
    //postCmt products
    public function postProduct(Request $request)
    {
        $module_id = Product::find($request->module_id);
        if (empty($module_id)) {
            echo 500;
            die();
        }
        $request->validate([
            'fullname' => 'required',
            'message' => 'required',
        ]);
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        if ($request->images) {
            $images = explode('-+-', $request->images);
        }
        $id = Comment::insertGetId([
            'module_id' => $module_id->id,
            'customerid' => $customerid,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'message' => $request->message,
            'images' => !empty($images) ? json_encode($images) : '',
            'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
            'publish' => 1,
            'module' => 'products',
            'type' => 'customer'
        ]);
        if ($id > 0) {
            echo 200;
        } else {
            echo 500;
        }
        die();
    }
    //post comment Article
    public function postArticle(Request $request)
    {
        $module_id = \App\Models\Article::findOrFail($request->module_id);
        if (empty($module_id)) {
            return response()->json(['error' => 'ERROR!']);
        }
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ], [
                'fullname.required' => 'Trường Họ và tên là trường bắt buộc.',
                'email.required' => 'Email là trường bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'message.required' => 'Nội dung là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);
        }
        if ($validator->passes()) {
            $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
            if ($request->images) {
                $images = explode('-+-', $request->images);
            }
            if (!empty($request->file('avatar'))) {
                $image_url = uploadImageFrontend($request->file('avatar'), 'comment/avatar');
            }
            $id = Comment::insertGetId([
                'module_id' => $module_id->id,
                'customerid' => $customerid,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'message' => $request->message,
                'avatar' => !empty($image_url) ? $image_url : '',
                'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
                'created_at' => Carbon::now(),
                'publish' => 1,
                'module' => 'articles',
                'type' => 'customer'
            ]);
            if ($id > 0) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['error' => 'ERROR']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function replyComment(Request $request)
    {
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ], [
                'fullname.required' => 'Trường Họ và tên là trường bắt buộc.',
                'email.required' => 'Email là trường bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'message.required' => 'Nội dung là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);
        }
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        /*
        if (!empty($request->file('avatar'))) {
            $image_url = uploadImageFrontend($request->file('avatar'), 'comment/avatar');
        }
        */
        if ($validator->passes()) {
            $id = Comment::insertGetId([
                'customerid' => $customerid,
                'fullname' => $request->fullname,
                'email' => !empty($request->email) ? $request->email : '',
                'phone' => '',
                'message' => $request->message,
                // 'avatar' => $image_url,
                'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
                'created_at' => Carbon::now(),
                'publish' => 1,
                'type' => 'customer'
            ]);
            if ($id > 0) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '500']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function uploadImagesComment(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        if ($request->delete) {
            if (file_exists(base_path() . $request->file)) {
                unlink(base_path() . $request->file);
            }
        } else {
            $request->validate([
                'file.*' => 'mimes:jpeg,jpg,png,gif,webp'
            ]);
            if ($request->hasfile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(base_path() . '/upload/comment/', $name);
                    $imgData[] = $name;
                }
                $image_return  = trim('/upload/comment/' . $name);
                echo json_encode(array(
                    'html' => '<div class="write-review__image inline-block w-12 h-12 bg-cover bg-no-repeat bg-center mr-4 rounded relative overflow-hidden cursor-pointer">
                    <img src="' . $image_return . '" alt="upload images">
                    <div class="js_delete_image_cmt w-[21px] h-[21px] bg-white rounded-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 leading-[21px] text-lg hidden text-center" data-file="' . $image_return . '">×</div>
                </div>',
                ));
                die();
            }
        }
    }
}

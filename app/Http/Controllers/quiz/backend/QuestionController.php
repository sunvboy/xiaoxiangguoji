<?php

namespace App\Http\Controllers\quiz\backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Validator;
use Session;
use App\Components\DocxConversion;
use Illuminate\Support\Collection;
use PharIo\Manifest\Email;
use PhpOffice\PhpWord\IOFactory;

class QuestionController extends Controller
{
    protected $table = 'questions';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }

    public function index(Request $request)
    {
        $data =  Question::where('deleted_at', null)->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('quiz.backend.question.index', compact('data'));
    }
    public function create()
    {
        return view('quiz.backend.question.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            // 'title' => 'required',
        ], [
            'code.required' => 'CODE là trường bắt buộc.',
            'type.required' => 'TYPE là trường bắt buộc.',
            // 'title.required' => 'Nội dung câu hỏi là trường bắt buộc.',
        ]);
        $validator->validate();
        $_data = [
            'code' => $request->code,
            // 'file' => $request->file,
            'type' => $request->type,
            // 'title' =>  $request->title,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        $id = Question::insertGetId($_data);
        if (!empty($id)) {
            /* if ($request->type == 1) {
                $isTrue = $request->isTrueValue;
                if (!empty($isTrue)) {
                    $isTrue = explode(',', $isTrue);
                }
                if (!empty($request->options)) {
                    $i = 0;
                    foreach ($request->options as $key => $item) {
                        $i++;
                        $order = '';
                        switch ($key) {
                            case 'a':
                                $order = "A";
                                break;
                            case 'b':
                                $order = "B";
                                break;
                            case 'c':
                                $order = "C";
                                break;
                            case 'd':
                                $order = "D";
                                break;
                            default:
                                break;
                        }
                        if (!empty($item)) {
                            foreach ($item as $key => $val) {
                                QuestionOption::create([
                                    'order' => $key,
                                    'characters' => $order,
                                    'description' => !empty($request->description) ?  $request->description[$key] : "",
                                    'title' => $val,
                                    'isTrue' => !empty($isTrue) ? $isTrue[$key] : "",
                                    'question_id' => $id,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }
                    }
                }
            } */
            return redirect()->route('questions.edit', ['id' => $id])->with('success', "Thêm mới câu hỏi thành công");
        }
    }
    public function edit($id)
    {
        $detail  = Question::with('question_options')->find($id);
        if (!isset($detail)) {
            return redirect()->route('quizzes.index')->with('error', "Câu hỏi không tồn tại");
        }
        return view('quiz.backend.question.edit', compact('detail'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'type' => 'required',
            'title' => 'required',
        ], [
            // 'type.required' => 'TYPE là trường bắt buộc.',
            'title.required' => 'Nội dung câu hỏi là trường bắt buộc.',
        ]);
        $validator->validate();
        $file = '';
        if ($request->type == 3) {
            $file = $request->file;
        }
        $_data = [
            'file' => $file,
            // 'type' => $request->type,
            'title' =>  $request->title,
            'updated_at' => Carbon::now(),
        ];
        Question::where('id', $id)->update($_data);
        //xóa QuestionOption
        if ($request->type == 1 || $request->type == 5) {
            // QuestionOption::where('question_id', $id)->delete();
            if (!empty($request->options)) {
                $isTrue = $request->isTrueValue;
                if (!empty($isTrue)) {
                    $isTrue = explode(',', $isTrue);
                }
                $i = 0;
                foreach ($request->options as $keyC => $item) {
                    $i++;
                    $order = '';
                    switch ($keyC) {
                        case 'a':
                            $order = "A";
                            break;
                        case 'b':
                            $order = "B";
                            break;
                        case 'c':
                            $order = "C";
                            break;
                        case 'd':
                            $order = "D";
                            break;
                        default:
                            break;
                    }
                    if (!empty($item)) {
                        foreach ($item as $key => $val) {
                            if (!empty($request->ids[$keyC][$key])) {
                                QuestionOption::where('id', $request->ids[$keyC][$key])->update([
                                    'order' => $key,
                                    'description' => !empty($request->description) ?  $request->description[$key] : "",
                                    'characters' => $order,
                                    'title' => $val,
                                    'isTrue' => !empty($isTrue) ? $isTrue[$key] : "",
                                    'question_id' => $id,
                                    'created_at' => Carbon::now(),
                                ]);
                            } else {
                                QuestionOption::create([
                                    'order' => $key,
                                    'description' => !empty($request->description) ?  $request->description[$key] : "",
                                    'characters' => $order,
                                    'title' => $val,
                                    'isTrue' => !empty($isTrue) ? $isTrue[$key] : "",
                                    'question_id' => $id,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('questions.index')->with('success', "Cập nhập câu hỏi thành công");
    }
    public function autocomplete(Request $request)
    {
        $experience = Session::get('experience');
        $keyword = $request->keyword;
        $data =  Question::select('id', 'title', 'code', 'type')->whereNotIn('id', !empty($experience) ? $experience : [])->where('deleted_at', null)->orderBy('id', 'DESC');
        if (is($request->keyword)) {
            $keyword = $request->keyword;
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('code', 'like', '%' . $keyword . '%')
                    ->orWhere('title', 'like', '%' . $keyword . '%');
            });
        }
        $data =  $data->paginate(env('APP_paginate'));
        return view('quiz.backend.question.autocomplete', compact('data'))->render();
    }
    public function createRewrite(Request $request)
    {
        $question_id = $request->question_id;
        $count = QuestionOption::where('question_id', $question_id)->count();
        $value = $request->value;
        if (strpos($value, "{INPUT}")  === false) {
            $description = 'title';
        } else {
            $description = 'input';
        }
        $create =  QuestionOption::create([
            'order' =>  $count + 1,
            'title' =>  $value,
            'description' =>  $description,
            'question_id' => $question_id,
            'created_at' => Carbon::now(),
        ]);
        if (!empty($create)) {
            $html = '';
            if ($create->description == 'title') {
                $html .= '<h3 class="font-bold rewrite_title_' . $create->id . ' rewrite_title">' . $create->title . '</h3>';
            } else {
                $html .= ' <div class="flex items-center text-danger font-bold  rewrite_input_' . $create->id . ' rewrite_input" data-text="' . $create->title . '">';
                $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $create->title);
                $html .= $str;
                $html .= '</div>';
            }
            return response()->json(['status' => 200, 'message' => 'Thêm mới thành công', 'html' => $html, 'detail' => $create]);
        } else {
            return response()->json(['status' => 400, 'message' => 'Thêm mới không thành công']);
        }
    }
    public function updateRewrite(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        if (strpos($value, "{INPUT}")  === false) {
            $description = 'title';
        } else {
            $description = 'input';
        }
        QuestionOption::where('id', $id)->update([
            'title' => $value,
            'description' => $description,
        ]);
        $html = '';
        $detail = QuestionOption::find($id);
        if ($detail->description == 'title') {
            $html .= '<h3 class="font-bold rewrite_title_' . $detail->id . ' rewrite_title">' . $detail->title . '</h3>';
        } else {
            $html .= ' <div class="flex items-center text-danger font-bold  rewrite_input_' . $detail->id . ' rewrite_input" data-text="' . $detail->title . '">';
            $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $detail->title);
            $html .= $str;
            $html .= '</div>';
        }
        return response()->json(['status' => 200, 'message' => 'Cập nhập thành công', 'html' => $html, 'type' => $description]);
    }
    public function deleteRewrite(Request $request)
    {
        $id = $request->id;
        QuestionOption::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'Xóa thành công']);
    }
}

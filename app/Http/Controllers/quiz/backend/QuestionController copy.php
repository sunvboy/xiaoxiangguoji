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
use PhpOffice\PhpWord\IOFactory;

class QuestionController extends Controller
{
    protected $table = 'questions';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    function getIsTrue($value = '')
    {
        $isTrue = '';
        if (trim(substr($value, 0, 3)) == 'A.*') {
            $isTrue = "A";
        } else if (trim(substr($value, 0, 3)) == 'B.*') {
            $isTrue = "B";
        } else if (trim(substr($value, 0, 3)) == 'C.*') {
            $isTrue = "C";
        } else if (trim(substr($value, 0, 3)) == 'D.*') {
            $isTrue = "D";
        }
        return  $isTrue;
    }
    public function index(Request $request)
    {
        $docObj = new DocxConversion(base_path('upload/customer/thuvienhoclieu.com-20-De-Tieng-Anh-on-thi-vao-10-nam-23-24.docx'));
        //$docObj = new DocxConversion("test.docx");
        //$docObj = new DocxConversion("test.xlsx");
        //$docObj = new DocxConversion("test.pptx");
        $docText = $docObj->convertToText();
        $docTextExplode =  explode("\r\n", $docText);
        $questions = [];
        $i = 0;
        if (!empty($docTextExplode)) {
            foreach ($docTextExplode as $key => $item) {
                if (!empty($item)) {
                    if ($item == 'END') {
                        $i++;
                    }
                    if ($item != 'END') {
                        $questions[$i][] = $item;
                    }
                }
            }
        }
        $data = [];
        if (!empty($questions)) {
            foreach ($questions as $key => $item) {
                $data[$item[0]] = collect($item)->filter(function ($value) use ($item) {
                    return $value != $item[0];
                })->toArray();
            }
        }
        if (!empty($data)) {
            $j = 0;
            foreach ($data as $key => $item) {
                $collection = collect($item)->filter(function ($item) {
                    return false !== stripos($item, 'A.');
                })->toArray();
                if (!empty($collection)) {
                    foreach ($collection as $index => $value) {
                        if (!empty($item[$index - 1])) {
                            $before = $item[$index - 1];
                            if (false !==  stripos($before, 'D. ')) {
                                $data[$key][] = [
                                    '0' => [
                                        'title' => trim(substr($value, 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'A',
                                        'isTrue' => '',
                                        'question_id' => ''
                                    ],
                                    '1' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'B',
                                        'isTrue' => '',
                                        'question_id' => ''
                                    ],
                                    '2' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'C',
                                        'isTrue' => '',
                                        'question_id' => ''
                                    ],
                                    '3' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'D',
                                        'isTrue' => '',
                                        'question_id' => ''
                                    ],
                                ];
                            } else {
                                $data[$key][$index - 1] = 'remove';
                                $isTrue = '';
                                if (trim(substr($value, 0, 3)) == 'A.*') {
                                    $isTrue = "A";
                                    break;
                                } else if (trim(substr($item[++$index], 0, 3)) == 'B.*') {
                                    $isTrue = "B";
                                    break;
                                } else if (trim(substr($item[++$index], 0, 3)) == 'C.*') {
                                    $isTrue = "C";
                                    break;
                                } else if (trim(substr($item[++$index], 0, 3)) == 'D.*') {
                                    $isTrue = "D";
                                    break;
                                }
                                $data[$key][$before] = [
                                    // '0' => trim(substr($value, 3)) . $index,
                                    // '1' => trim(substr($item[++$index], 3)) . $index,
                                    // '2' => trim(substr($item[++$index], 3)) . $index,
                                    // '3' => trim(substr($item[++$index], 3)) . $index,

                                    '0' => [
                                        'title' => trim(substr($value, 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'A',
                                        'isTrue' => '',
                                        'question_id' => $isTrue
                                    ],
                                    '1' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'B',
                                        'isTrue' => '',
                                        'question_id' => $isTrue
                                    ],
                                    '2' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'C',
                                        'isTrue' => '',
                                        'question_id' => $isTrue
                                    ],
                                    '3' => [
                                        'title' => trim(substr($item[++$index], 3)) . $index,
                                        'order' => 0,
                                        'characters' => 'D',
                                        'isTrue' => '',
                                        'question_id' => $isTrue
                                    ],
                                ];
                            }
                        } else {
                            $data[$key][] = [
                                '0' => [
                                    'title' => trim(substr($value, 3)) . $index,
                                    'order' => 0,
                                    'characters' => 'A',
                                    'isTrue' => '',
                                    'question_id' => ''
                                ],
                                '1' => [
                                    'title' => trim(substr($item[++$index], 3)) . $index,
                                    'order' => 0,
                                    'characters' => 'B',
                                    'isTrue' => '',
                                    'question_id' => ''
                                ],
                                '2' => [
                                    'title' => trim(substr($item[++$index], 3)) . $index,
                                    'order' => 0,
                                    'characters' => 'C',
                                    'isTrue' => '',
                                    'question_id' => ''
                                ],
                                '3' => [
                                    'title' => trim(substr($item[++$index], 3)) . $index,
                                    'order' => 0,
                                    'characters' => 'D',
                                    'isTrue' => '',
                                    'question_id' => ''
                                ],
                            ];
                        }
                    }
                }
            }
        }
        $datas = [];
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (!empty($item)) {
                    foreach ($item as $k => $val) {
                        if (gettype($val) == 'string') {
                            if ($val != 'remove' && stripos($val, 'A.') === false &&  stripos($val, 'B.') === false && stripos($val, 'C.') === false && stripos($val, 'D.') === false) {
                                $datas[$key][] = $val;
                            }
                        } else {
                            $datas[$key][$k] = $val;
                        }
                    }
                }
            }
        }
        dd($datas);
        die;
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
            'title' => 'required',
        ], [
            'code.required' => 'CODE là trường bắt buộc.',
            'type.required' => 'TYPE là trường bắt buộc.',
            'title.required' => 'Nội dung câu hỏi là trường bắt buộc.',
        ]);
        $validator->validate();
        $_data = [
            'code' => $request->code,
            'file' => $request->file,
            'type' => $request->type,
            'title' =>  $request->title,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        $id = Question::insertGetId($_data);
        if (!empty($id)) {
            if ($request->type == 1) {
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
            }
            return redirect()->route('questions.index')->with('success', "Thêm mới câu hỏi thành công");
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
            'type' => 'required',
            'title' => 'required',
        ], [
            'type.required' => 'TYPE là trường bắt buộc.',
            'title.required' => 'Nội dung câu hỏi là trường bắt buộc.',
        ]);
        $validator->validate();
        $file = '';
        if ($request->type == 3) {
            $file = $request->file;
        }
        $_data = [
            'file' => $file,
            'type' => $request->type,
            'title' =>  $request->title,
            'updated_at' => Carbon::now(),
        ];
        Question::where('id', $id)->update($_data);
        //xóa QuestionOption
        if ($request->type == 1) {
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
}

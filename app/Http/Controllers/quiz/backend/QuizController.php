<?php

namespace App\Http\Controllers\quiz\backend;

use App\Components\Helper;
use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\CustomerCategory;
use App\Models\CustomerLevel;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\QuizConfig;
use App\Models\QuizCustomerCategory;
use App\Models\QuizQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Validator;
use Session;
use App\Components\DocxConversion;
use App\Models\Article;
use App\Models\Product;
use App\Models\QuestionOption;

class QuizController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $table = 'quizzes';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'quiz_categories'));
        $this->Helper = new Helper();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        // $this->uploadData('1698400933_thuvienhoclieu.com-20-De-Tieng-Anh-on-thi-vao-10-nam-23-24.docx');
        Session::forget('experience');
        Session::forget('orderQuiz');
        Session::forget('score');
        $data =  Quiz::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('quiz.backend.quiz.index', compact('data'));
    }

    public function create()
    {
        $config =  QuizConfig::first();
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        // Session::forget('experience');
        // Session::forget('orderQuiz');
        /* $QuizConfig =  QuizConfig::first();
        $experience = Question::where(['type' => 1, 'deleted_at' => null])->with(['question_options'])->limit($QuizConfig->experience)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $essay = Question::where(['type' => 2, 'deleted_at' => null])->with(['question_options'])->limit($QuizConfig->essay)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $speak = Question::where(['type' => 3, 'deleted_at' => null])->with(['question_options'])->limit($QuizConfig->speak)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $data = [];
        //trắc nghiệm
        if (!empty($experience)) {
            foreach ($experience as $item) {
                $data[] = $item;
            }
        }
        //tự luận
        if (!empty($essay)) {
            foreach ($essay as $item) {
                $data[] = $item;
            }
        }
        //nói
        if (!empty($speak)) {
            foreach ($speak as $item) {
                $data[] = $item;
            }
        }
        $session = Session::get('experience');
        if (empty($session)) {
            Session::put('experience', $data);
            Session::save();
            $questions = Question::whereIn('id', $data)->with(['question_options'])->orderBy('type', 'asc')->get();
        } else {
            $questions = Question::whereIn('id', $session)->with(['question_options'])->orderBy('type', 'asc')->get();
        }
        //lấy session order
        $experienceData = [];
        //nếu tồn session order
        if (empty(Session::get('orderQuiz'))) {
            $orderQuiz = [];
            if (!empty($questions)) {
                foreach ($questions as $key => $item) {
                    $orderQuiz[$item->id] = $key + 1;
                }
            }
            Session::put('orderQuiz', $orderQuiz);
            Session::save();
        }
        $orderQuizSeeion = Session::get('orderQuiz');
        if (!empty($orderQuizSeeion)) {
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
         */
        //lấy session order
        $experienceData = [];
        $session = Session::get('experience');
        $score = Session::get('score');
        if (!empty($session)) {
            $questions = Question::whereIn('id', $session)->with(['question_options'])->orderBy('type', 'asc')->get();
        }
        //nếu tồn session order
        $orderQuizSeeion = Session::get('orderQuiz');
        if (!empty($orderQuizSeeion)) {
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        $category = dropdown(CustomerCategory::orderBy('title', 'asc')->get(), 'Chọn lớp học', 'id', 'title');
        $customer_levels = dropdown(CustomerLevel::orderBy('order', 'asc')->get(), 'Chọn cấp bậc', 'title', 'title');
        $products = dropdown(Product::get(), 'Chọn sản phẩm', 'id', 'title');
        $articles = dropdown(Article::get(), 'Chọn tin tức', 'id', 'title');
        return view('quiz.backend.quiz.create', compact('htmlCatalogue', 'category', 'experienceData', 'config', 'customer_levels', 'score', 'products', 'articles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            // 'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            // 'catalogue_id.gt' => 'Danh mục là trường bắt buộc.',
        ]);
        $validator->validate();
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'quizzes');
        } else {
            $image_url = $request->image_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
        ];
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('quizzes.index')->with('success', "Thêm mới câu hỏi thành công");
    }

    public function edit($id)
    {
        $detail  = Quiz::with(['quiz_questions' => function ($questions) {
            $questions->orderBy('order', 'asc')->with(['questions' => function ($options) {
                $options->with(['question_options']);
            }]);
        }])->find($id);
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        if (!isset($detail)) {
            return redirect()->route('quizzes.index')->with('error', "Câu hỏi không tồn tại");
        }
        $session = Session::get('experience');
        if (empty($session)) {
            $experience = $detail->quiz_questions->pluck('question_id')->toArray();
            Session::put('experience', $experience);
            Session::save();
            $questions = Question::whereIn('id', $experience)->with(['question_options'])->orderBy('type', 'asc')->get();
        } else {
            $questions = Question::whereIn('id', $session)->with(['question_options'])->orderBy('type', 'asc')->get();
        }
        //lấy session order
        $experienceData = [];
        //nếu tồn session order
        if (empty(Session::get('orderQuiz'))) {
            $orderQuiz = [];
            if (!empty($detail->quiz_questions)) {
                foreach ($detail->quiz_questions as $item) {
                    $orderQuiz[$item->question_id] = $item->order;
                }
            }
            Session::put('orderQuiz', $orderQuiz);
            Session::save();
        }
        $orderQuizSeeion = Session::get('orderQuiz');
        if (!empty($orderQuizSeeion)) {
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        $getCatalogue = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        $category = dropdown(CustomerCategory::orderBy('title', 'asc')->get(), 'Chọn lớp học', 'id', 'title');
        $customer_levels = dropdown(CustomerLevel::orderBy('order', 'asc')->get(), 'Chọn cấp bậc', 'title', 'title');
        $products = dropdown(Product::get(), 'Chọn sản phẩm', 'id', 'title');
        $articles = dropdown(Article::get(), 'Chọn tin tức', 'id', 'title');
        return view('quiz.backend.quiz.edit', compact('detail', 'htmlCatalogue', 'getCatalogue', 'experienceData', 'category', 'customer_levels', 'products', 'articles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            // 'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            // 'catalogue_id.gt' => 'Danh mục là trường bắt buộc.',
        ]);
        $validator->validate();
        //upload image,banner...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'quizzes');
        } else {
            $image_url = $request->image_old;
        }

        $arrayImg = [
            'image_url' => $image_url,
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('quizzes.index')->with('success', "Cập nhập câu hỏi thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $arrayImg = [])
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        //danh mục phụ
        // $catalogue = $request['catalogue'];
        // $tmp_catalogue[] = (int)$request['catalogue_id'];
        // if (isset($catalogue)) {
        //     foreach ($catalogue as $v) {
        //         if ($v != 0 && $v != $request['catalogue_id']) {
        //             $tmp_catalogue[] = (int)$v;
        //         }
        //     }
        // }
        //lấy danh mục cha (nếu có)
        // $detail = QuizCategory::select('id', 'title', 'slug', 'lft')->where('id', $request['catalogue_id'])->first();
        // $breadcrumb = QuizCategory::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        // if ($breadcrumb->count() > 0) {
        //     foreach ($breadcrumb as $v) {
        //         $tmp_catalogue[] = $v->id;
        //     }
        // }
        // $tmp_catalogue = array_unique($tmp_catalogue);
        //end
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'image' =>  $arrayImg['image_url'],
            'description' => $request['description'],
            // 'score' => !empty($request['score']) ? $request['score'] : null,
            // 'count_experience' => $request['count_experience'],
            // 'count_essay' => $request['count_essay'],
            // 'count_speak' => $request['count_speak'],
            // 'mark_experience' => $request['mark_experience'],
            // 'catalogue_id' => $request['catalogue_id'],
            // 'time' => $request['time'],
            // 'prerequisites' => $request['prerequisites'],
            // 'customer_levels' => json_encode($request['customer_levels']),
            // 'customer_category' => json_encode($request['customer_catalogue_id']),
            // 'catalogue' => json_encode($tmp_catalogue),
            'meta_title' =>  $request['meta_title'],
            'meta_description' =>  $request['meta_description'],
            'publish' =>  $request['publish'],
            'mien_tru' =>  $request['mien_tru'],
            'video' =>  $request['video'],
            'thap_title' =>  $request['thap_title'],
            'thap_description' =>  $request['thap_description'],
            'thap_content' =>  $request['thap_content'],
            'cao_title' =>  $request['cao_title'],
            'cao_description' =>  $request['cao_description'],
            'cao_content' =>  $request['cao_content'],
            'products' =>  !empty($request['products']) ? json_encode($request['products']) : null,
            'articles' =>   !empty($request['articles']) ? json_encode($request['articles']) : null,
            $time => Carbon::now(),
            'user_id' => Auth::user()->id
        ];
        if ($action == 'create') {
            $id = Quiz::insertGetId($_data);
        } else {
            Quiz::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa catalogue_relationship
                // DB::table('catalogues_relationships')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa bảng quiz_questions
                QuizQuestion::where('quiz_id', $id)->delete();
                // QuizCustomerCategory::where('quiz_id', $id)->delete();
            }
            //thêm vào bảng quiz_questions
            $quizQuestions = $request['ids'];
            $_quiz_questions = [];
            if (!empty($quizQuestions)) {
                foreach ($quizQuestions as $key => $item) {
                    $_quiz_questions[] = [
                        'quiz_id' => $id,
                        'question_id' => $key,
                        'order' => $item,
                        'created_at' => Carbon::now(),
                    ];
                }
                QuizQuestion::insert($_quiz_questions);
            }
            //thêm vào bảng quiz_customer_category
            // $customer_catalogue_id = [];
            // if (!empty($request['customer_catalogue_id'])) {
            //     foreach ($request['customer_catalogue_id'] as $item) {
            //         $customer_catalogue_id[] = [
            //             'quiz_id' => $id,
            //             'customer_category_id' => $item,
            //             'created_at' => Carbon::now(),
            //         ];
            //     }
            //     QuizCustomerCategory::insert($customer_catalogue_id);
            // }
            //thêm vào bảng catalogue_relationship
            // $this->Helper->catalogue_relation_ship($id, $request['catalogue_id'], $tmp_catalogue, $this->table);
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
        }
        Session::forget('experience');
        Session::forget('orderQuiz');
    }
    public function order(Request $request)
    {
        $orderQuiz = Session::get('orderQuiz');
        $orderQuiz[$request->id] = (int)$request->order;
        Session::put('orderQuiz', $orderQuiz);
        Session::save();
        $orderQuizSeeion = Session::get('orderQuiz');
        $experience = Session::get('experience');
        $experienceData = [];
        if (!empty($orderQuizSeeion)) {
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            $questions = Question::whereIn('id', $experience)->with(['question_options'])->get();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        return view('quiz.backend.quiz.data', compact('experienceData'))->render();
    }
    public function delete(Request $request)
    {
        $experience = Session::get('experience');
        $experience = collect($experience)->filter(function ($value) use ($request) {
            return $value != $request->id;
        })->toArray();
        $orderQuiz = Session::get('orderQuiz');
        $orderQuiz = collect($orderQuiz)->filter(function ($value, int $key) use ($request) {
            return $key != $request->id;
        })->toArray();
        Session::put('experience', $experience);
        Session::save();
        Session::put('orderQuiz', $orderQuiz);
        Session::save();
        // data
        $orderQuizSeeion = Session::get('orderQuiz');
        $experience = Session::get('experience');
        $questions = Question::whereIn('id', $experience)->with(['question_options'])->get();
        if (!empty($orderQuizSeeion)) {
            $experienceData = [];
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
            $experienceData =  collect($experienceData)->sortBy('order');
        } else {
            $experienceData = $questions;
        }
        return response()->json([
            'html' => view('quiz.backend.quiz.data', compact('experienceData'))->render(),
            'experience' => !empty($experience) ? 1 : 0
        ]);
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $ids = explode(',', $ids);
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $experience = Session::get('experience');
                $orderQuiz = Session::get('orderQuiz');
                $experience = collect($experience)->filter(function ($value) use ($id) {
                    return $value != $id;
                })->toArray();
                $orderQuiz = collect($orderQuiz)->filter(function ($value, int $key) use ($id) {
                    return $key != $id;
                })->toArray();
                Session::put('experience', $experience);
                Session::save();
                Session::put('orderQuiz', $orderQuiz);
                Session::save();
            }
        }
        // data
        $orderQuizSeeion = Session::get('orderQuiz');
        $experience = Session::get('experience');
        $questions = Question::whereIn('id', $experience)->with(['question_options'])->get();
        if (!empty($orderQuizSeeion)) {
            $experienceData = [];
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
            $experienceData =  collect($experienceData)->sortBy('order');
        } else {
            $experienceData = $questions;
        }
        return response()->json([
            'html' => view('quiz.backend.quiz.data', compact('experienceData'))->render(),
            'experience' => !empty($experience) ? 1 : 0
        ]);
    }
    public function add(Request $request)
    {
        $id = $request->id;
        $experience = Session::get('experience');
        $experience = collect($experience)->push($id)->toArray();
        $orderQuiz = Session::get('orderQuiz');
        if (!empty(Session::get('orderQuiz'))) {
            $orderQuiz = collect($orderQuiz)->put((int)$id, count(Session::get('orderQuiz')) + 1)->toArray();
        } else {
            $orderQuiz = collect($orderQuiz)->put((int)$id, 1)->toArray();
        }
        Session::put('experience', $experience);
        Session::save();
        Session::put('orderQuiz', $orderQuiz);
        Session::save();
        // data
        $orderQuizSeeion = Session::get('orderQuiz');
        $experience = Session::get('experience');
        $questions = Question::whereIn('id', $experience)->with(['question_options'])->get();
        if (!empty($orderQuizSeeion)) {
            $experienceData = [];
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
            $experienceData =  collect($experienceData)->sortBy('order');
        } else {
            $experienceData = $questions;
        }
        return response()->json([
            'html' => view('quiz.backend.quiz.data', compact('experienceData'))->render(),
            'experience' => !empty($experience) ? 1 : 0
        ]);
    }
    public function storeQuiz(Request $request)
    {
        $count_experience = $request->count_experience;
        $count_essay = $request->count_essay;
        $count_speak = $request->count_speak;
        $mark_experience = $request->mark_experience;
        $experience = Question::where(['type' => 1, 'deleted_at' => null])->with(['question_options'])->limit($count_experience)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $essay = Question::where(['type' => 2, 'deleted_at' => null])->with(['question_options'])->limit($count_essay)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $speak = Question::where(['type' => 3, 'deleted_at' => null])->with(['question_options'])->limit($count_speak)->inRandomOrder()->orderBy('id', 'asc')->get()->pluck('id');
        $data = [];
        //trắc nghiệm
        if (!empty($experience)) {
            foreach ($experience as $item) {
                $data[] = $item;
            }
        }
        //tự luận
        if (!empty($essay)) {
            foreach ($essay as $item) {
                $data[] = $item;
            }
        }
        //nói
        if (!empty($speak)) {
            foreach ($speak as $item) {
                $data[] = $item;
            }
        }
        $orderQuiz = [];
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                $orderQuiz[$item] = $key + 1;
            }
        }
        Session::put('orderQuiz', $orderQuiz);
        Session::save();
        //lấy session order
        $experienceData = [];
        Session::put('experience', $data);
        Session::save();
        $questions = Question::whereIn('id', $data)->with(['question_options'])->orderBy('type', 'asc')->get();
        //nếu tồn session order
        $orderQuizSeeion = Session::get('orderQuiz');
        if (!empty($orderQuizSeeion)) {
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        return response()->json([
            'html' => view('quiz.backend.quiz.data', compact('experienceData'))->render(),
        ]);
    }
    public function import(Request $request)
    {
        $file = $request->file;
        if (!empty($file)) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('upload/questions'), $fileName);
        }
        $this->uploadData($fileName);
        $experienceData = [];
        $score = Session::get('score');
        $session = Session::get('experience');
        if (!empty($session)) {
            $questions = Question::whereIn('id', $session)->with(['question_options'])->orderBy('type', 'asc')->get();
        }
        //nếu tồn session order
        $orderQuizSeeion = Session::get('orderQuiz');
        if (!empty($orderQuizSeeion)) {
            $orderQuiz = collect($orderQuizSeeion)->toArray();
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuizSeeion[$item->id]) ? (int)$orderQuizSeeion[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        return response()->json([
            'html' => view('quiz.backend.quiz.data', compact('experienceData'))->render(),
            'score' => $score
        ]);
    }
    public function uploadData($file)
    {
        $score = 0;
        $experience = [];
        $docObj = new DocxConversion(base_path('upload/questions/' . $file));
        //$docObj = new DocxConversion("test.docx");
        //$docObj = new DocxConversion("test.xlsx");
        //$docObj = new DocxConversion("test.pptx");
        $docText = $docObj->convertToText();
        $docTextExplode =  explode("\r\n", $docText);
        $questions = [];
        $i = 0;
        if (!empty($docTextExplode)) {
            foreach ($docTextExplode as $key => $item) {
                if ($key > 0) {
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
                    return substr(trim($item), 0, 2) === 'A.';
                })->toArray();
                if (!empty($collection)) {
                    $i = 0;
                    foreach ($collection as $index => $value) {
                        $i++;
                        if (!empty($item[$index - 1])) {
                            $before = $item[$index - 1];
                            if (substr(trim($before), 0, 2) === 'D.') {
                                $_create = [
                                    '0' => [
                                        'title' => trim(substr($value, 3)),
                                        'titleOld' => $value,
                                        'order' => $i,
                                        'characters' => 'A',
                                    ],
                                    '1' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'B',
                                    ],
                                    '2' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'C',
                                    ],
                                    '3' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'D',
                                    ],
                                ];
                                $isTrue = collect($_create)->filter(function ($value) {
                                    return substr(trim($value['titleOld']), 0, 3) == 'A.*' || substr(trim($value['titleOld']), 0, 3) == 'B.*'  || substr(trim($value['titleOld']), 0, 3) == 'C.*' || substr(trim($value['titleOld']), 0, 3) == 'D.*';
                                })->first();
                                if (!empty($_create)) {
                                    foreach ($_create as $c => $v) {
                                        $_create[$c] = [
                                            'title' => $v['title'],
                                            'titleOld' => $v['titleOld'],
                                            'order' => $v['order'],
                                            'characters' => $v['characters'],
                                            'isTrue' => $isTrue['characters'],
                                        ];
                                    }
                                }
                                $data[$key][] = $_create;
                            } else {
                                $data[$key][$index - 1] = 'remove';
                                $_create = [
                                    '0' => [
                                        'title' => trim(substr($value, 3)),
                                        'titleOld' => $value,
                                        'order' => $i,
                                        'characters' => 'A',
                                    ],
                                    '1' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'B',
                                    ],
                                    '2' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'C',
                                    ],
                                    '3' => [
                                        'title' => trim(substr($item[++$index], 3)),
                                        'titleOld' => $item[$index],
                                        'order' => $i,
                                        'characters' => 'D',
                                    ],
                                ];
                                $isTrue = collect($_create)->filter(function ($value) {
                                    return substr(trim($value['titleOld']), 0, 3) == 'A.*' || substr(trim($value['titleOld']), 0, 3) == 'B.*'  || substr(trim($value['titleOld']), 0, 3) == 'C.*' || substr(trim($value['titleOld']), 0, 3) == 'D.*';
                                })->first();
                                if (!empty($_create)) {
                                    foreach ($_create as $c => $v) {
                                        $_create[$c] = [
                                            'title' => $v['title'],
                                            'titleOld' => $v['titleOld'],
                                            'order' => $v['order'],
                                            'characters' => $v['characters'],
                                            'isTrue' => $isTrue['characters'],
                                        ];
                                    }
                                }
                                $data[$key][$before] = $_create;
                            }
                        } else {
                            $_create = [
                                '0' => [
                                    'title' => trim(substr($value, 3)),
                                    'titleOld' => $value,
                                    'order' => $i,
                                    'characters' => 'A',
                                ],
                                '1' => [
                                    'title' => trim(substr($item[++$index], 3)),
                                    'titleOld' => $item[$index],
                                    'order' => $i,
                                    'characters' => 'B',
                                ],
                                '2' => [
                                    'title' => trim(substr($item[++$index], 3)),
                                    'titleOld' => $item[$index],
                                    'order' => $i,
                                    'characters' => 'C',
                                ],
                                '3' => [
                                    'title' => trim(substr($item[++$index], 3)),
                                    'titleOld' => $item[$index],
                                    'order' => $i,
                                    'characters' => 'D',
                                ],
                            ];
                            $isTrue = collect($_create)->filter(function ($value) {
                                return substr(trim($value['titleOld']), 0, 3) == 'A.*' || substr(trim($value['titleOld']), 0, 3) == 'B.*'  || substr(trim($value['titleOld']), 0, 3) == 'C.*' || substr(trim($value['titleOld']), 0, 3) == 'D.*';
                            })->first();
                            if (!empty($_create)) {
                                foreach ($_create as $c => $v) {
                                    $_create[$c] = [
                                        'title' => $v['title'],
                                        'titleOld' => $v['titleOld'],
                                        'order' => $v['order'],
                                        'characters' => $v['characters'],
                                        'isTrue' => $isTrue['characters'],
                                    ];
                                }
                            }
                            $data[$key][] = $_create;
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
                        if (!empty($val)) {
                            if (gettype($val) == 'string') {
                                if ($val != ' ' && $val != 'remove' && substr(trim($val), 0, 2) != 'A.' &&  substr(trim($val), 0, 2) != 'B.' && substr(trim($val), 0, 2) != 'C.' && substr(trim($val), 0, 2) != 'D.') {
                                    $datas[$key][$k] = $val;
                                }
                            } else {
                                $datas[$key][$k] = $val;
                            }
                        }
                    }
                }
            }
        }
        $dataNews = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $item) {
                if (!empty($item)) {
                    $countArray = 0;
                    foreach ($item as $k => $val) {
                        if (gettype($val) == 'array') {
                            $countArray = $countArray + 1;
                        }
                    }
                    if ($countArray == count($item)) {
                        $dataNews['experience'][$key] = $item;
                    } elseif ($countArray == 0) {
                        $dataNews['essay'][$key] = $item;
                    } else {
                        $dataNews['read'][$key] = $item;
                    }
                }
            }
        }
        if (!empty($dataNews)) {
            foreach ($dataNews as $key => $item) {
                if ($key == 'experience') {
                    //kiểu trắc nghiệm
                    if (!empty($item)) {
                        foreach ($item as $kval => $val) {
                            $code = CodeRender('questions');
                            $_data = [
                                'code' => $code,
                                'type' => 1,
                                'title' =>  $kval,
                                'user_id' => Auth::user()->id,
                                'created_at' => Carbon::now(),
                            ];
                            $id = Question::insertGetId($_data);
                            if (!empty($id)) {
                                $experience[] = $id;
                                if (!empty($val)) {
                                    foreach ($val as $kval2 => $val2) {
                                        $score = $score + 1;
                                        if (!empty($val2)) {
                                            foreach ($val2 as $kval3 => $val3) {
                                                if (!empty($val3)) {
                                                    if (substr($val3['title'], 0, 1) === '*') {
                                                        $title = substr($val3['title'], 1);
                                                    } else {
                                                        $title = $val3['title'];
                                                    }
                                                    QuestionOption::create([
                                                        'order' => $val3['order'],
                                                        'characters' => $val3['characters'],
                                                        'description' => !empty(gettype($kval2) != 'integer') ? $kval2 : '',
                                                        'title' =>  trim($title),
                                                        'isTrue' =>  $val3['isTrue'],
                                                        'question_id' => $id,
                                                        'created_at' => Carbon::now(),
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else if ($key == 'essay') {
                    //kiểu điền từ
                    if (!empty($item)) {
                        foreach ($item as $kval => $val) {
                            $code = CodeRender('questions');
                            $_data = [
                                'code' => $code,
                                'type' => 4,
                                'title' =>  $kval,
                                'user_id' => Auth::user()->id,
                                'created_at' => Carbon::now(),
                            ];
                            $id = Question::insertGetId($_data);
                            if (!empty($id)) {
                                $experience[] = $id;
                                if (!empty($val)) {
                                    foreach ($val as $kval2 => $val2) {
                                        if (!empty($val2)) {
                                            if (strpos($val2, "{INPUT}")  === false) {
                                                $description = 'title';
                                            } else {
                                                $description = 'input';
                                            }
                                            QuestionOption::create([
                                                'order' =>  $kval2,
                                                'title' =>  $val2,
                                                'description' =>  $description,
                                                'question_id' => $id,
                                                'created_at' => Carbon::now(),
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else if ($key == 'read') {
                    //kiểu điền từ và trắc nghiệm
                    if (!empty($item)) {
                        foreach ($item as $kval => $val) {
                            $code = CodeRender('questions');
                            $_data = [
                                'code' => $code,
                                'type' => 5,
                                'title' =>  $kval,
                                'user_id' => Auth::user()->id,
                                'created_at' => Carbon::now(),
                            ];
                            $id = Question::insertGetId($_data);
                            if (!empty($id)) {
                                $experience[] = $id;
                                if (!empty($val)) {
                                    foreach ($val as $kval2 => $val2) {
                                        if (gettype($val2) == 'string') {
                                            if (!empty($val2)) {
                                                if (strpos($val2, "{INPUT}")  === false) {
                                                    $description = 'title';
                                                } else {
                                                    $description = 'input';
                                                }
                                                QuestionOption::create([
                                                    'order' =>  $kval2,
                                                    'title' =>  $val2,
                                                    'description' =>  $description,
                                                    'question_id' => $id,
                                                    'created_at' => Carbon::now(),
                                                ]);
                                            }
                                        } else {
                                            $score = $score + 1;
                                            if (!empty($val2)) {
                                                foreach ($val2 as $kval3 => $val3) {
                                                    if (!empty($val3)) {
                                                        if (substr($val3['title'], 0, 1) === '*') {
                                                            $title = substr($val3['title'], 1);
                                                        } else {
                                                            $title = $val3['title'];
                                                        }
                                                        QuestionOption::create([
                                                            'order' => $val3['order'],
                                                            'characters' => $val3['characters'],
                                                            'description' => !empty(gettype($kval2) != 'integer') ? $kval2 : "",
                                                            'title' =>  trim($title),
                                                            'isTrue' =>  $val3['isTrue'],
                                                            'question_id' => $id,
                                                            'created_at' => Carbon::now(),
                                                        ]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $orderQuiz = [];
        if (!empty($experience)) {
            foreach ($experience as $key => $item) {
                $orderQuiz[$item] = $key + 1;
            }
        }
        Session::put('score', $score);
        Session::put('orderQuiz', $orderQuiz);
        //lấy session order
        Session::put('experience', $experience);
        Session::save();
    }
}

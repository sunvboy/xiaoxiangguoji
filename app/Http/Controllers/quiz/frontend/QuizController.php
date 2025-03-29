<?php

namespace App\Http\Controllers\quiz\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionOptionUser;
use App\Models\Quiz;
use App\Models\QuizCustomerCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request)
    {
        $customer_catalogue_id = Auth::guard('customer')->user()->catalogue_id;
        $data =  Quiz::select('quizzes.id', 'quizzes.title', 'quizzes.slug', 'quizzes.customer_category', 'quizzes.customer_levels')->where(['quizzes.publish' => 0])
            ->where('quiz_customer_categories.customer_category_id', $customer_catalogue_id)
            ->with(['question_option_users' => function ($q) {
                $q->where(['customer_id' => Auth::guard('customer')->user()->id, 'type' => 'first'])->orderBy('id', 'asc');
            }])->join('quiz_customer_categories', 'quiz_customer_categories.quiz_id', '=', 'quizzes.id');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('quizzes.title', 'like', '%' . $keyword . '%');
        }
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('quizzes.created_at', '>=', $date_start . ' 00:00:00')->where('quizzes.created_at', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('quizzes.created_at', '>=', $date_end . ' 00:00:00')->where('quizzes.created_at', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('quizzes.created_at', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('quizzes.created_at', '>=', $date_start . ' 00:00:00')->where('quizzes.created_at', '<=', $date_end . ' 23:59:59');
            }
        }
        $data = $data->orderBy('quizzes.id', 'desc')->paginate(20);
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = "Danh sách bài thi";
        return view('quiz.frontend.quiz.index', compact('seo', 'data', 'fcSystem'));
    }
    public function quiz($slug = '')
    {
        $detail = Quiz::where('slug', $slug)->with(['quiz_questions'])->first();
        if (!isset($detail)) {
            return redirect()->route('quizzes.frontend.index');
        }
        $orderQuiz = [];
        if (!empty($detail->quiz_questions)) {
            foreach ($detail->quiz_questions as $item) {
                $orderQuiz[$item->question_id] = $item->order;
            }
        }
        $experience = $detail->quiz_questions->pluck('question_id')->toArray();
        $questions = Question::whereIn('id', $experience)->with(['question_options'])->orderBy('type', 'asc')->get();
        $experienceData = [];
        if (!empty($orderQuiz)) {
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuiz[$item->id]) ? (int)$orderQuiz[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        return view('quiz.frontend.quiz.quiz', compact('seo', 'fcSystem', 'detail', 'experienceData'));
    }
    public function quizSubmit(Request $request, $id)
    {
        // $words = $request->words;
        $quiz = $request->quiz;
        // $essays = $request->essays;
        // $files = $request->files;
        // $timer = $request->valueTimer;
        // $pause = $request->valuePause;
        $detail = Quiz::where('id', $id)->with(['quiz_questions'])->first();
        if (!isset($detail)) {
            return redirect()->route('quizzes.frontend.index');
        }
        // $filesPath = [];
        // if (!empty($files)) {
        //     foreach ($files as $item) {
        //         foreach ($item as $key => $file) {
        //             $fileName = time() . '_' . $file->getClientOriginalName();
        //             $file->move(base_path('upload/customer'), $fileName);
        //             $filesPath[$key] = $fileName;
        //         }
        //     }
        // }
        // $check = QuestionOptionUser::where(['customer_id' => Auth::guard('customer')->user()->id, 'quiz_id' => $detail->id])->first();
        $id = QuestionOptionUser::insertGetId([
            'quiz_id' => $detail->id,
            'question_options' => json_encode($quiz),
            // 'words' => json_encode($words),
            // 'essays' => json_encode($essays),
            // 'files' => !empty($filesPath) ? json_encode($filesPath) : '',
            // 'timer' => $timer,
            // 'pause' => $pause,
            'created_at' => Carbon::now(),
            'customer_id' => !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : null,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            // 'status' => 'wait',
            // 'type' => empty($check) ? 'first' : '',
        ]);
        if (!empty($id)) {
            return redirect()->route('quizzes.frontend.quizSuccess', ['slug' => $detail->slug, 'id' => $id]);
        }
        // $orderQuiz = [];
        // if (!empty($detail->quiz_questions)) {
        //     foreach ($detail->quiz_questions as $item) {
        //         $orderQuiz[$item->question_id] = $item->order;
        //     }
        // }
        // $experience = $detail->quiz_questions->pluck('question_id')->toArray();
        // $questions = Question::whereIn('id', $experience)->with(['question_options'])->orderBy('type', 'asc')->get();
        // $experienceData = [];
        // if (!empty($orderQuiz)) {
        //     if (!empty($questions)) {
        //         foreach ($questions as $item) {
        //             $experienceData[] = collect($item)->put('order', !empty($orderQuiz[$item->id]) ? (int)$orderQuiz[$item->id] : 0)->all();
        //         }
        //     }
        // }
        // $experienceData =  collect($experienceData)->sortBy('order');
        // if (!empty($experienceData)) {
        //     foreach ($experienceData as $key => $item) {
        //         if ($item['type'] == 1) {
        //             if (!empty($item['question_options']) && count($item['question_options']) > 0) {
        //                 foreach ($item['question_options'] as $k => $v) {
        //                     if (!empty($quiz[$item['id']])) {
        //                         if (in_array($v['id'], $quiz[$item['id']])) {
        //                             $item['question_options'][$k] = collect($v)->put('selected', true)->toArray();
        //                         } else {
        //                             $item['question_options'][$k] = collect($v)->put('selected', false)->toArray();
        //                         }
        //                     }
        //                 }
        //             }
        //         } else if ($item['type'] == 2) {
        //         } else if ($item['type'] == 3) {
        //         }
        //     }
        // }
        // dd($experienceData);
        // $true = 0;
        // if (!empty(array_keys($quiz))) {
        //     $questions = Question::whereIn('id', array_keys($quiz))->orderBy('type', 'asc')->get();
        //     if (!empty($questions)) {
        //         foreach ($questions as $key => $item) {
        //             $question_options = QuestionOption::whereIn('id', $quiz[$item->id])->get();
        //             $filtered = $question_options->filter(function ($value, int $key) {
        //                 return $value->characters == $value->isTrue;
        //             });
        //             $true = $true + $filtered->count();
        //         }
        //     }
        // }

    }
    public function quizSuccess($slug = '', $id)
    {
        $fcSystem = $this->system->fcSystem();
        $detail = Quiz::where('slug', $slug)->with(['quiz_questions'])->first();
        if (!isset($detail)) {
            return redirect()->route('quizzes.frontend.index');
        }
        //lấy số lần làm lại
        $success = QuestionOptionUser::where('quiz_id', $detail->id)->find($id);
        if (!isset($success)) {
            return redirect()->route('quizzes.frontend.index');
        }
        // $NumberOfReworks = QuestionOptionUser::where(['customer_id' => Auth::guard('customer')->user()->id, 'quiz_id' => $detail->id])->get()->count();
        $seo['meta_title'] = "Kết quả - " . $detail->title;
        return view('quiz.frontend.quiz.success', compact('seo', 'fcSystem', 'detail', 'success'));
    }
    public function answer(Request $request, $slug = '', $id)
    {
        //cập nhập đã đọc thông báo
        if (!empty($request->notifications)) {
            Notification::where('id', $request->notifications)->update([
                'view' => 1,
                'updated_at' => Carbon::now()
            ]);
        }
        $fcSystem = $this->system->fcSystem();
        $detail = Quiz::where('slug', $slug)->with(['quiz_questions'])->first();
        if (!isset($detail)) {
            return redirect()->route('quizzes.frontend.index');
        }
        $success = QuestionOptionUser::find($id);
        if (!isset($success)) {
            return redirect()->route('quizzes.frontend.index');
        }
        $orderQuiz = [];
        if (!empty($detail->quiz_questions)) {
            foreach ($detail->quiz_questions as $item) {
                $orderQuiz[$item->question_id] = $item->order;
            }
        }
        $experience = $detail->quiz_questions->pluck('question_id')->toArray();
        $questions = Question::whereIn('id', $experience)->with(['question_options'])->orderBy('type', 'asc')->get();
        $experienceData = [];
        if (!empty($orderQuiz)) {
            if (!empty($questions)) {
                foreach ($questions as $item) {
                    $experienceData[] = collect($item)->put('order', !empty($orderQuiz[$item->id]) ? (int)$orderQuiz[$item->id] : 0)->all();
                }
            }
        }
        $experienceData =  collect($experienceData)->sortBy('order');
        $seo['meta_title'] = "Đáp án - " . $detail->title;
        return view('quiz.frontend.quiz.answer', compact('seo', 'fcSystem', 'detail', 'success', 'experienceData'));
    }
}

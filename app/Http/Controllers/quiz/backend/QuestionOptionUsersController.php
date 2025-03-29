<?php

namespace App\Http\Controllers\quiz\backend;

use App\Components\System;
use App\Events\NotificationProcessed;
use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Notification;
use App\Models\Question;
use App\Models\QuestionOptionUser;
use App\Models\QuestionOptionUsersHistory;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerQuizExport;

class QuestionOptionUsersController extends Controller
{
    protected $table = 'question_option_users';
    protected $system;

    public function __construct()
    {
        View::share(['module' => $this->table]);
        $this->system = new System();
    }
    public function index(Request $request)
    {
        $customers = dropdown(Customer::get(), 'Chọn thành viên', 'id', 'name');
        $customer_categories = dropdown(CustomerCategory::get(), 'Chọn lớp học', 'id', 'title');
        $quizzes = dropdown(Quiz::select('id', 'title')->get(), 'Chọn đề thi', 'id', 'title');
        $data =  QuestionOptionUser::select('question_option_users.*', 'customers.name', 'customer_categories.title as customer_categories_title', 'quizzes.title as quizzes_title')
            ->join('customers', 'customers.id', '=', 'question_option_users.customer_id')
            ->join('customer_categories', 'customer_categories.id', '=', 'customers.catalogue_id')
            ->join('quizzes', 'quizzes.id', '=', 'question_option_users.quiz_id');
        $keyword = $request->keyword;
        $customer_id = $request->customer_id;
        $customer_categories_id = $request->customer_categories_id;
        $quiz_id = $request->quiz_id;
        if (!empty($keyword)) {
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('quizzes.title', 'like', '%' . $keyword . '%');
            });
        }
        if (!empty($customer_id)) {
            $data = $data->where(function ($query) use ($customer_id) {
                $query->where('question_option_users.customer_id', $customer_id);
            });
        }
        if (!empty($customer_categories_id)) {
            $data = $data->where(function ($query) use ($customer_categories_id) {
                $query->where('customer_categories.id', $customer_categories_id);
            });
        }
        if (!empty($quiz_id)) {
            $data = $data->where(function ($query) use ($quiz_id) {
                $query->where('quizzes.id', $quiz_id);
            });
        }
        $data =  $data->where('type', 'first')->orderBy('id', 'desc');
        $data =  $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        if (is($request->customer_id)) {
            $data->appends(['customer_id' => $request->customer_id]);
        }
        if (is($request->customer_categories_id)) {
            $data->appends(['customer_categories_id' => $request->customer_categories_id]);
        }
        if (is($request->quiz_id)) {
            $data->appends(['quiz_id' => $request->quiz_id]);
        }
        return view('quiz.backend.customer.index', compact('data', 'customers', 'customer_categories', 'quizzes'));
    }
    public function edit($id)
    {
        $detail =  QuestionOptionUser::find($id);
        if (!isset($detail)) {
            return redirect()->route('question_option_users.index')->with('error', "Bài thi không tồn tại");
        }
        $Quiz = Quiz::where('id', $detail->quiz_id)->with(['quiz_questions'])->first();
        $orderQuiz = [];
        if (!empty($Quiz->quiz_questions)) {
            foreach ($Quiz->quiz_questions as $item) {
                $orderQuiz[$item->question_id] = $item->order;
            }
        }
        $experience = $Quiz->quiz_questions->pluck('question_id')->toArray();
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
        return view('quiz.backend.customer.edit', compact('detail', 'experienceData', 'Quiz'));
    }
    public function update(Request $request, $id)
    {

        $detail =  QuestionOptionUser::find($id);
        $score_experience = !empty($request->score_experience) ? $request->score_experience : 0;
        $score_essay = !empty($request->score_essay) ? $request->score_essay : 0;
        $score_speak = !empty($request->score_speak) ? $request->score_speak : 0;
        $_update = [
            'experience_note' => json_encode($request->experience),
            'essay_note' => json_encode($request->essay),
            'speak_note' => json_encode($request->speak),
            'status' => 'success',
            'score_experience' => $score_experience,
            'score_essay' => $score_essay,
            'score_speak' => $score_speak,
            'score_total' => (float)$score_experience + (float)$score_essay + (float)$score_speak,
        ];
        QuestionOptionUser::where(['id' => $id])->update($_update);
        //lấy tổng điểm
        $totalScore = QuestionOptionUser::get()->sum('score_total');
        Customer::where('id', $detail->customer_id)->update([
            'score' => $totalScore
        ]);
        //lưu lịch sử chỉnh sửa
        QuestionOptionUsersHistory::insertGetId([
            'experience_note' => json_encode($request->experience),
            'essay_note' => json_encode($request->essay),
            'speak_note' => json_encode($request->speak),
            'score_experience' => $score_experience,
            'score_essay' => $score_essay,
            'score_speak' => $score_speak,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        //check notification
        $checkNotification =  Notification::where([
            'customer_id' => $detail->customer_id,
            'question_option_user_id' => $id,
        ])->first();
        $fcSystem = $this->system->fcSystem();
        if (empty($checkNotification)) {
            Notification::insertGetId([
                'customer_id' => $detail->customer_id,
                'question_option_user_id' => $id,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'message' => $fcSystem['title_0'] . " " . $detail->quizzes->title,
                'view' => 0,
            ]);
        } else {
            Notification::where('id', $checkNotification->id)->update([
                'view' => 0, 'message' => $fcSystem['title_0'] . " " . $detail->quizzes->title,
            ]);
        }
        //gửi thông báo cho người dùng
        event(new Notifications($detail->customer_id, $fcSystem['title_0'] . " " . $detail->quizzes->title));
        return redirect()->route('question_option_users.edit', ['id' => $id])->with('success', "Chấm bài thi thành công");
    }
    public function export()
    {
        return Excel::download(new CustomerQuizExport, 'danh-sach-thanh-vien.xlsx');
    }
}

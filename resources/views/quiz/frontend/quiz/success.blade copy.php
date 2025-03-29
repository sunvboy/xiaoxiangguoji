   @extends('homepage.layout.home')
   @section('content')
   <?php
    $count = 0;
    $orderQuiz = [];
    if (!empty($detail->quiz_questions)) {
        foreach ($detail->quiz_questions as $item) {
            $orderQuiz[$item->question_id] = $item->order;
        }
    }
    $experience = $detail->quiz_questions->pluck('question_id')->toArray();
    $questions = \App\Models\Question::whereIn('id', $experience)->with(['question_options'])->orderBy('type', 'asc')->get();
    $experienceData = [];
    if (!empty($orderQuiz)) {
        if (!empty($questions)) {
            foreach ($questions as $item) {
                $experienceData[] = collect($item)->put('order', !empty($orderQuiz[$item->id]) ? (int)$orderQuiz[$item->id] : 0)->all();
            }
        }
    }
    $experienceData =  collect($experienceData)->sortBy('order');
    if (!empty($experienceData)) {
        foreach ($experienceData as $key => $exp) {
            if ($exp['type'] == 1) {
                $data = collect($exp['question_options'])->groupBy('order');
                if (!empty($data) && count($data) > 0) {
                    foreach ($data as $key => $item) {
                        if (!empty($item) && count($item) > 0) {
                            $count = $count + 1;
                        }
                    }
                }
            }
            if ($exp['type'] == 5) {
                $question_options = collect($exp['question_options']);
                $booleans = $question_options->where('characters', '!=', null)->all();
                $booleans = collect($booleans)->groupBy('order');
                if (!empty($booleans) && count($booleans) > 0) {
                    foreach ($booleans as $key => $item) {
                        if (!empty($booleans) && count($item) > 0) {
                            $count = $count + 1;
                        }
                    }
                }
            }
        }
    }
    if (!empty($success->question_options)) {
        $questionOptionsSuccess = json_decode($success->question_options, TRUE);
        $true = 0;
        if (!empty($questionOptionsSuccess) && !empty(array_keys($questionOptionsSuccess))) {
            $questionsData = \App\Models\Question::whereIn('id', array_keys($questionOptionsSuccess))->orderBy('type', 'asc')->get();
            if (!empty($questionsData)) {
                foreach ($questionsData as $key => $item) {
                    $question_options = \App\Models\QuestionOption::whereIn('id', $questionOptionsSuccess[$item->id])->get();
                    $filtered = $question_options->filter(function ($value, int $key) {
                        return $value->characters == $value->isTrue;
                    });
                    $true = $true + $filtered->count();
                }
            }
        }
        if (!empty($true) || !empty($count)) {
            $pass = ($true / $count) * 100;
            $passCheck = true;
            if ((int)$pass < (int)$detail->prerequisites) {
                $passCheck = false;
            }
        }
    }
    $timer = '';
    $time = (int)$detail->time * 60 - (int)$success->timer;
    $hours = ((int)$time / 3600) % 24;
    $minutes = ((int) $time / 60) % 60;
    $seconds = $time % 60;
    if ($hours > 0) {
        $timer = ($hours < 10 ? "0" . $hours : $hours) . 'h' . ($minutes < 10 ? "0" . $minutes : $minutes) . 'm' .  ($seconds < 10 ? "0" . $seconds : $seconds)  . 's';
    } else {
        $timer = ($minutes < 10 ? "0" . $minutes : $minutes) . 'm' . ($seconds < 10 ? "0" . $seconds : $seconds) . "s";
    }
    ?>
   <div id="main" class="sitemap main-Test-submit pb-[20px] md:pb-[70px]">
       <div class="breadcrumb py-[10px] bg-gray-100">
           <div class="container mx-auto px-3">
               <ul class="flex flex-wrap">
                   <li class="pr-[5px]"><a href="{{url('/')}}">Trang chủ</a> /</li>
                   <li class="pr-[5px]"><a href="{{route('quizzes.frontend.index')}}">Danh sách bài thi</a> /</li>
                   <li class="pr-[5px]">Kết quả: {{$detail->title}}</li>
               </ul>
           </div>
       </div>
       <div class="content-Test-submit pt-[20px] md:pt-[50px]">
           <div class="container mx-auto px-3">
               <div class="flex flex-wrap justify-start mx-[-15px]">
                   <div class="px-[15px] w-full grid grid-cols-1 md:grid-cols-2 gap-8">
                       <div class="item">
                           <h2 class="uppercase text-f20 bold-1">Thông tin chung</h2>
                           <table class="w-full mt-[20px] flex-1 md:h-full">
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Tông số câu hỏi:</span> {{$count}} câu
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Điều kiện qua (% đúng)</span>
                                       60%
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Thời gian làm bài:</span> {{$detail->time}} phút
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Số lần làm lại :</span> {{$NumberOfReworks}}
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <a href="{{route('quizzes.frontend.answer',['slug' => $detail->slug,'id' => $success->id])}}" class="inline-block transition-all py-[8px] rounded-[5px] px-[25px] bg-color_primary text-white border border-color_primary hover:bg-white hover:text-color_primary bold-1 uppercase mr-[10px]">
                                           Xem đáp án
                                       </a>
                                       <a href="{{route('quizzes.frontend.quiz',['slug' => $detail->slug])}}" class="inline-block transition-all py-[8px] rounded-[5px] px-[25px] bg-color_second border border-color_second hover:bg-color_primary hover:border-color_primary hover:text-white bold-1 uppercase">
                                           làm lại<i></i>
                                       </a>
                                   </td>
                               </tr>
                           </table>
                       </div>
                       <div class="item">
                           <h2 class="uppercase text-f20 bold-1">kết quả</h2>
                           <table class="w-full mt-[20px] flex-1 md:h-full">
                               <tr class="text-center">
                                   <td class="border border-gray-200 p-[10px] space-y-2">
                                       <p class="text-center font-bold">Tiến độ học</p>
                                       @if(!empty($passCheck))
                                       <img src="{{asset('frontend/img/icon-smile.png')}}" alt="" style="width: 60px;" class="inline-block">
                                       <p class="pt-[12px]">Chúc mừng bạn đã vượt qua bài thi này!</p>
                                       @else
                                       <img src="{{asset('frontend/img/icon-un-smile.png')}}" alt="" style="width: 60px;" class="inline-block">
                                       <p class="pt-[12px]">Bạn chưa vượt qua bài thi này!</p>
                                       @endif
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Số câu đúng</span>{{$true}}/{{$count}} ({{(int)$pass}}%)
                                   </td>
                               </tr>

                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Thời gian làm bài</span>{{$timer}}
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Số lần tạm dừng</span>{{$success->pause}}
                                   </td>
                               </tr>
                               <tr>
                                   <td class="border border-gray-200 p-[10px] text-center">
                                       <span class="bold-1 pr-[15px]">Ngày </span> {{$success->created_at}}
                                   </td>
                               </tr>

                           </table>
                       </div>

                   </div>

               </div>
           </div>
       </div>
   </div>
   @endsection
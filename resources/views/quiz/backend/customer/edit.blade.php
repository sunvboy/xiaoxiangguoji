@extends('dashboard.layout.dashboard')
@section('title')
<title>Chấm điểm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách bài đã thi",
        "src" => route('question_option_users.index'),
    ],
    [
        "title" => "Chấm điểm bài thi",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<?php
$experience_note = json_decode($detail->experience_note, TRUE);
$essay_note = json_decode($detail->essay_note, TRUE);
$speak_note = json_decode($detail->speak_note, TRUE);

$words = json_decode($detail->words, TRUE);
$questionOptionsSuccess = json_decode($detail->question_options, TRUE);
$essays = json_decode($detail->essays, TRUE);
$files = json_decode($detail->files, TRUE);
$timer = '';
$time = (int)$Quiz->time * 60 - (int)$detail->timer;
$hours = ((int)$time / 3600) % 24;
$minutes = ((int) $time / 60) % 60;
$seconds = $time % 60;
if ($hours > 0) {
    $timer = ($hours < 10 ? "0" . $hours : $hours) . 'h' . ($minutes < 10 ? "0" . $minutes : $minutes) . 'm' .  ($seconds < 10 ? "0" . $seconds : $seconds)  . 's';
} else {
    $timer = ($minutes < 10 ? "0" . $minutes : $minutes) . 'm' . ($seconds < 10 ? "0" . $seconds : $seconds) . "s";
}
$true = 0;
$count = 0;
$score = 0;
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
// if (!empty($true) || !empty($count)) {
//     $pass = ($true / $count) * 100;
// }
if (!empty($Quiz->score) && !empty($true)) {
    $score = $Quiz->score * $true;
}

?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Chấm điểm bài thi
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('question_option_users.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class="col-span-12">
            <div class="box p-5 space-y-5">
                @include('components.alert-error')
                @csrf
                <?php $i = 0;
                $count = 0; ?>
                @if(!empty($experienceData))
                @foreach($experienceData as $exp)
                <?php $count += collect($exp['question_options'])->groupBy('order')->count() ?>
                <div class="accordion-item flex space-x-5">
                    <div class="flex-1">
                        <div class="accordion-header mb-2">
                            <button class="accordion-button text-left text-lg font-bold" type="button">
                                {!!$exp['title']!!}
                            </button>
                        </div>
                        <div class="space-y-2">
                            @if($exp['type'] == 1)
                            <?php
                            $data = collect($exp['question_options'])->groupBy('order');
                            if (!empty($data) && count($data) > 0) {
                                foreach ($data as $key => $item) {
                                    if (!empty($item) && count($item) > 0) {
                                        $i++;
                            ?>
                                        <div class="preview box p-5">
                                            <div>
                                                <div class="mt-2">
                                                    <span class="font-bold">{{ $i}}.</span> {!! !empty($item) ? $item[0]['description'] : ""!!}
                                                </div>
                                            </div>
                                            @foreach ($item as $k => $v)
                                            <?php
                                            $order = '';
                                            switch ($v['characters']) {
                                                case 'A':
                                                    $order = "a";
                                                    break;
                                                case 'B':
                                                    $order = "b";
                                                    break;
                                                case 'C':
                                                    $order = "c";
                                                    break;
                                                case 'D':
                                                    $order = "d";
                                                    break;
                                                default:
                                                    break;
                                            }

                                            $class = '';
                                            if (!empty($questionOptionsSuccess[$exp['id']][$key])) {
                                                if ($questionOptionsSuccess[$exp['id']][$key] == $v['id']) {
                                                    if ($v['characters'] == $v['isTrue']) {
                                                        $class = 'bg-success text-white';
                                                    } else {
                                                        $class = 'bg-danger text-white';
                                                    }
                                                }
                                                if ($questionOptionsSuccess[$exp['id']][$key] != $v['id'] && $v['characters'] == $v['isTrue']) {
                                                    $class = 'bg-success text-white';
                                                }
                                            }
                                            ?>
                                            <div class="input-group mt-2 ">
                                                <label class="cursor-pointer p-2 space-x-2 flex flex-wrap" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',{{$v['id']}},{{$i}})">
                                                    <input disabled <?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>checked<?php } ?> type="radio">
                                                    <span class="<?php echo $class ?> flex flex-wrap">
                                                        {{$v['characters']}}.&nbsp;{!!$v['title']!!}
                                                    </span>
                                                </label>
                                            </div>
                                            @endforeach
                                            <div class="mt-3">
                                                <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                                <?php echo Form::text('experience[' . $v['id'] . ']', !empty($experience_note) ? $experience_note[$v['id']] : "", ['class' => 'form-control w-full']); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            @elseif($exp['type'] == 2)
                            <div class="border w-full p-3 focus:outline-none" rows="10" placeholder="Nhập câu trả lời" disabled>
                                <?php echo strip_tags($essays[$exp['id']]) ?>
                            </div>
                            <div class="mt-3">
                                <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                <?php echo Form::textarea('essay[' . $exp['id'] . ']', !empty($essay_note) ? $essay_note[$exp['id']] : "", ['class' => 'form-control w-full']); ?>
                            </div>
                            @elseif($exp['type'] == 3)
                            <div class="">
                                <audio id="song{!!$exp['id']!!}" class="w-full max-w-md mx-auto hidden song" controls>
                                    <source src="{{asset($exp['file'])}}" type="audio/mpeg">
                                </audio>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="PlayAudio(<?php echo $exp['id'] ?>)" class="p-2 rounded-lg hover:bg-slate-800 bg-primary text-white flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                        </svg>
                                        <span> Play</span>
                                    </button>
                                    <button type="button" onclick="PlayPause()" class="p-2 rounded-lg hover:bg-slate-800 bg-primary text-white flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Pause</span>
                                    </button>
                                </div>
                            </div>
                            <div>
                                @if(!empty($files[$exp['id']]))
                                <div for="file" class="p-2 flex items-center space-x-2 uploadFile cursor-not-allowed w-full h-[45px] border border-gray-200 mb-[15px] leading-[45px] pl-[10px] bg-white">
                                    <div>
                                        <span class="filename filename-{{$exp['id']}}"> <?php echo !empty($files[$exp['id']]) ? $files[$exp['id']] : '' ?></span>
                                        <audio id="songDA{!!$exp['id']!!}" class="w-full max-w-md mx-auto hidden songDA" controls>
                                            <source src="<?php echo !empty($files[$exp['id']]) ? asset('upload/customer/' . $files[$exp['id']]) : '' ?>" type="audio/mpeg">
                                        </audio>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="PlayAudioDA(<?php echo $exp['id'] ?>)" class="p-2 rounded-lg hover:bg-slate-800 bg-danger text-white flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                            </svg>
                                            <span> Play</span>
                                        </button>
                                        <button type="button" onclick="PlayPauseDA()" class="p-2 rounded-lg hover:bg-slate-800 bg-danger text-white flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Pause</span>
                                        </button>
                                    </div>
                                </div>


                                @else
                                <label class="p-2 w-full h-[45px] border border-gray-200 mb-[15px] inline-block leading-[45px] pl-[10px] ">
                                    <span class="filename filename-{{$exp['id']}}">Chưa hoàn thành </span>
                                </label>
                                @endif
                                <div class="mt-3">
                                    <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                    <?php echo Form::textarea('speak[' . $exp['id'] . ']', !empty($speak_note) ? $speak_note[$exp['id']] : "", ['class' => 'form-control w-full']); ?>
                                </div>
                            </div>
                            @elseif($exp['type'] == 4)
                            <div class="space-y-5 box p-5">
                                @if(!empty($exp['question_options']))
                                @foreach($exp['question_options'] as $k=>$v)
                                <div class="flex justify-between space-x-5">
                                    <div class="flex-1">
                                        @if($v['description'] == 'title')
                                        <h3 class="font-bold">{{$v['title']}}</h3>
                                        @else
                                        <?php $i++; ?>
                                        <div class="flex items-center flex-wrap">
                                            <?php
                                            $str = str_replace("{INPUT}", "<input name='words[" . $v['id'] . "]'  value='" . $words[$v['id']] . "' type='text' class='flex-1 font-bold text-danger ml-2 border-0 border-b outline-none focus:outline-none hover:outline-none' >", $v['title']);
                                            ?>
                                            <span class="font-bold"><?php echo $i ?>.</span> {!!$str!!}
                                        </div>
                                        <div class="mt-3">
                                            <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                            <?php echo Form::text('experience[' . $v['id'] . ']', !empty($experience_note) ? $experience_note[$v['id']] : "", ['class' => 'form-control w-full']); ?>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @elseif($exp['type'] == 5)
                            <div class="">
                                <?php
                                $question_options = collect($exp['question_options']);
                                $reads = $question_options->where('characters', null)->all();
                                $booleans = $question_options->where('characters', '!=', null)->all();
                                $booleans = collect($booleans)->groupBy('order');
                                ?>
                                <div class="read_list space-y-5">
                                    @if(!empty($reads))
                                    @foreach($reads as $k=>$v)
                                    <div class="flex justify-between space-x-5">
                                        <div class="flex-1">
                                            @if($v['description'] == 'title')
                                            <h3 class="font-bold">{{$v['title']}}</h3>
                                            @else
                                            <?php $i++; ?>
                                            <div class="flex items-center flex-wrap">
                                                <?php
                                                $str = str_replace("{INPUT}", "<input name='words[" . $v['id'] . "]'  value='" . $words[$v['id']] . "' type='text' class='flex-1 font-bold text-danger ml-2 border-0 border-b outline-none focus:outline-none hover:outline-none' >", $v['title']);
                                                ?>
                                                <span class="font-bold"><?php echo $i ?>.</span> {!!$str!!}
                                            </div>
                                            <div class="mt-3">
                                                <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                                <?php echo Form::text('experience[' . $v['id'] . ']', !empty($experience_note) ? $experience_note[$v['id']] : "", ['class' => 'form-control w-full']); ?>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="mt-3 space-y-3">
                                    <?php
                                    if (!empty($booleans) && count($booleans) > 0) {
                                        foreach ($booleans as $key => $item) {
                                            if (!empty($item) && count($item) > 0) {
                                                $i++;
                                    ?>
                                                <div class="preview box p-5">
                                                    <div>
                                                        <div class="mt-2">
                                                            <span class="font-bold">{{ $i}}.</span> {!! !empty($item) ? $item[0]['description'] : ""!!}
                                                        </div>
                                                    </div>
                                                    @foreach ($item as $k => $v)
                                                    <?php
                                                    $order = '';
                                                    switch ($v['characters']) {
                                                        case 'A':
                                                            $order = "a";
                                                            break;
                                                        case 'B':
                                                            $order = "b";
                                                            break;
                                                        case 'C':
                                                            $order = "c";
                                                            break;
                                                        case 'D':
                                                            $order = "d";
                                                            break;
                                                        default:
                                                            break;
                                                    }

                                                    $class = '';
                                                    if (!empty($questionOptionsSuccess[$exp['id']][$key])) {
                                                        if ($questionOptionsSuccess[$exp['id']][$key] == $v['id']) {
                                                            if ($v['characters'] == $v['isTrue']) {
                                                                $class = 'bg-success text-white';
                                                            } else {
                                                                $class = 'bg-danger text-white';
                                                            }
                                                        }
                                                        if ($questionOptionsSuccess[$exp['id']][$key] != $v['id'] && $v['characters'] == $v['isTrue']) {
                                                            $class = 'bg-success text-white';
                                                        }
                                                    }
                                                    ?>
                                                    <div class="input-group mt-2 ">
                                                        <label class="cursor-pointer flex flex-wrap p-2 space-x-2" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',{{$v['id']}},{{$i}})">
                                                            <input disabled <?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>checked<?php } ?> type="radio">
                                                            <span class="<?php echo $class ?> flex flex-wrap">
                                                                {{$v['characters']}}.&nbsp;{!!$v['title']!!}
                                                            </span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    <div class="mt-3">
                                                        <label class="font-bold text-danger" style="font-style: italic;">Ghi chú*</label>
                                                        <?php echo Form::text('experience[' . $v['id'] . ']', !empty($experience_note) ? $experience_note[$v['id']] : "", ['class' => 'form-control w-full']); ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
            <div class="box p-5 space-y-5 mt-3">
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Thời gian làm bài</label>
                    <?php echo Form::text('timer', $timer, ['class' => 'form-control w-full', 'disabled']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số lần tạm dừng</label>
                    <?php echo Form::text('pause', $detail->pause, ['class' => 'form-control w-full', 'disabled']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số câu đúng</label>
                    <?php echo Form::text('count_true', $true, ['class' => 'form-control w-full', 'disabled']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Điểm trắc nghiệm</label>
                    <?php echo Form::text('score_experience', !empty($detail->score_experience) ? $detail->score_experience : $score, ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Điểm bài tự luận</label>
                    <?php echo Form::text('score_essay', !empty($detail->score_essay) ? $detail->score_essay : '', ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Điểm bài nói</label>
                    <?php echo Form::text('score_speak', !empty($detail->score_speak) ? $detail->score_speak : '', ['class' => 'form-control w-full']); ?>
                </div>
                <button class="mt-3 btn btn-danger" type="submit">
                    Cập nhập
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
@push('javascript')
<script>
    function PlayAudio(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
        document.getElementById('song' + id).play()
    }

    function PlayPause(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
    }

    function PlayAudioDA(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
        document.getElementById('songDA' + id).play()
    }

    function PlayPauseDA(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
    }
</script>
@endpush
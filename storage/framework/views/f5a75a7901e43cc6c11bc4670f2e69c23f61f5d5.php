   
   <?php $__env->startSection('content'); ?>
   <?php
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
    $questionOptionsSuccess = json_decode($success->question_options, TRUE);
    $words = json_decode($success->words, TRUE);
    $essays = json_decode($success->essays, TRUE);
    $files = json_decode($success->files, TRUE);
    $experience_note = json_decode($success->experience_note, TRUE);
    $essay_note = json_decode($success->essay_note, TRUE);
    $speak_note = json_decode($success->speak_note, TRUE);
    ?>
   <div class="sitemap main-Test pb-[20px] md:pb-[70px]">
       <?php echo csrf_field(); ?>
       <div class="breadcrumb py-[10px] bg-gray-100">
           <div class="container mx-auto px-3">
               <ul class="flex flex-wrap">
                   <li class="pr-[5px]"><a href="<?php echo e(url('/')); ?>">Trang chủ</a> /</li>
                   <li class="pr-[5px]"><a href="<?php echo e(route('quizzes.frontend.index')); ?>">Danh sách bài thi</a> /</li>
                   <li class="pr-[5px]">Đáp án <?php echo e($detail->title); ?></li>
               </ul>
           </div>
       </div>
       <div class="content-Test pt-[20px] md:pt-[60px]">
           <div class="container mx-auto px-3">
               <div class="flex flex-wrap justify-start mx-[-15px]">
                   <div class="px-[15px] content-left" style="width: calc(100% - 300px);">
                       <?php $i = 0;
                        $count = 0; ?>
                       <?php if(!empty($experienceData)): ?>
                       <?php $__currentLoopData = $experienceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <?php $count += collect($exp['question_options'])->groupBy('order')->count() ?>
                       <div class="item-large mb-[30px]">
                           <?php /*@if($exp['type'] == 1)
                           @if(collect($exp['question_options'])->groupBy('order')->count() > 1)
                           <h3 class="title-2 text-color_primary font-bold">Câu {{$i+1}} - {{$count}}</h3>
                           @else
                           <h3 class="title-2 text-color_primary font-bold">Câu {{$i+1}} </h3>
                           @endif
                           @else
                           <h3 class="title-2 text-color_primary font-bold">Câu {{++$i}} </h3>
                           @endif*/ ?>

                           <div class="border border-gray-200 shadow p-[15px] md:p-[25px]">
                               <div class="item mb-[20px]">
                                   <?php if($exp['type'] == 2): ?>
                                   <?php $i++; ?>
                                   <div class="">
                                       <?php echo $i ?>. <?php echo $exp['title']; ?>

                                   </div>
                                   <?php elseif($exp['type'] == 3): ?>
                                   <?php $i++; ?>
                                   <div class="">
                                       <?php echo $i ?>.
                                       <audio id="song<?php echo $exp['id']; ?>" class="w-full max-w-md mx-auto hidden song" controls>
                                           <source src="<?php echo e(asset($exp['file'])); ?>" type="audio/mpeg">
                                       </audio>
                                       <div class="mt-4 flex space-x-2">
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
                                           <?php /*<button type="button" onclick="document.getElementById('song').volume += 0.1" class="px-2 rounded-lg hover:bg-slate-800 bg-red-600">Vol +</button>
                                           <button type="button" onclick="document.getElementById('song').volume -= 0.1" class="px-2 rounded-lg hover:bg-slate-800 bg-red-600">Vol -</button>*/ ?>
                                       </div>
                                   </div>
                                   <?php else: ?>
                                   <h4 class="title-4 bold-1 bg-gray-100 p-[15px] mt-[10px]"> <?php echo $exp['title']; ?></h4>
                                   <?php endif; ?>
                               </div>
                               <?php if($exp['type'] == 1): ?>
                               <?php
                                $data = collect($exp['question_options'])->groupBy('order');
                                if (!empty($data) && count($data) > 0) {
                                    foreach ($data as $key => $item) {
                                        if (!empty($item) && count($item) > 0) {
                                            $i++;
                                ?>
                                           <div class="item mb-[20px]" id="question-1-<?php echo e($i); ?>">
                                               <?php if(collect($exp['question_options'])->groupBy('order')->count() > 1): ?>
                                               <div class="title-4 bold-1 p-[15px] mt-[10px] flex pl-0">
                                                   <span class="bold-1"><?php echo e($i); ?>.</span>
                                                   <div><?php echo !empty($item) ? $item[0]['description'] : ""; ?></div>
                                               </div>
                                               <?php endif; ?>
                                               <ul class="mt-[10px]">
                                                   <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                $class = 'bg-green-600 text-white';
                                                            } else {
                                                                $class = 'bg-red-600 text-white';
                                                            }
                                                        }
                                                        if ($questionOptionsSuccess[$exp['id']][$key] != $v['id'] && $v['characters'] == $v['isTrue']) {
                                                            $class = 'bg-green-600 text-white';
                                                        }
                                                    }
                                                    ?>
                                                   <li class="mb-[10px] flex items-center ">
                                                       <label class="cursor-pointer flex flex-wrap" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',<?php echo e($v['id']); ?>,<?php echo e($i); ?>)">
                                                           <input disabled <?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>checked<?php } ?> type="radio" class="float-left mr-[10px] w-5 h-5 handleQuestion-<?php echo $v['question_id'] . '-' . $key ?> handleQuestionOption-<?php echo $v['id']  ?>" data-question-id="<?php echo e($v['question_id']); ?>" data-question-option-id="<?php echo e($v['id']); ?>" name="quiz[<?php echo e($v['question_id']); ?>][<?php echo e($key); ?>]" value="<?php echo e($v['id']); ?>">
                                                           <span class="<?php echo $class ?>">
                                                               <?php echo e($v['characters']); ?>. <?php echo $v['title']; ?>

                                                           </span>
                                                       </label>
                                                   </li>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                               </ul>
                                           </div>
                                           <?php if(!empty($experience_note) && !empty($experience_note[$v['id']])): ?>
                                           <div class="mt-3">
                                               <div style="font-style: italic;" class="text-red-600">
                                                   <span class="font-bold  ">Ghi chú*: </span><?php echo e($experience_note[$v['id']]); ?>

                                               </div>
                                           </div>
                                           <?php endif; ?>
                                       <?php } ?>
                                   <?php } ?>
                               <?php } ?>
                               <?php elseif($exp['type'] == 2): ?>
                               <div class="border w-full p-3 focus:outline-none" rows="10" placeholder="Nhập câu trả lời" disabled>
                                   <?php echo strip_tags($essays[$exp['id']]) ?>
                                   <?php if(!empty($essay_note) && !empty($essay_note[$exp['id']])): ?>
                                   <div class="mt-3">
                                       <div style="font-style: italic;" class="text-red-600">
                                           <span class="font-bold  ">Ghi chú*: </span><?php echo e($essay_note[$exp['id']]); ?>

                                       </div>
                                   </div>
                                   <?php endif; ?>
                               </div>
                               <?php elseif($exp['type'] == 3): ?>
                               <div class="flex flex-col relative">
                                   <?php if(!empty($files[$exp['id']])): ?>
                                   <label for="file" class="uploadFile cursor-not-allowed w-full h-[45px] border border-gray-200 mb-[15px] inline-block leading-[45px] pl-[10px] bg-white">
                                       <i class="fas fa-paperclip fa-md mr-2"></i>
                                       <span class="filename filename-<?php echo e($exp['id']); ?>"> <?php echo !empty($files[$exp['id']]) ? $files[$exp['id']] : '' ?></span>
                                   </label>
                                   <?php else: ?>
                                   <label class="w-full h-[45px] border border-gray-200 mb-[15px] inline-block leading-[45px] pl-[10px] bg-red-600 text-white">
                                       <span class="filename filename-<?php echo e($exp['id']); ?>">Chưa hoàn thành </span>
                                   </label>
                                   <?php endif; ?>
                                   <?php if(!empty($speak_note) && !empty($speak_note[$exp['id']])): ?>
                                   <div>
                                       <div style="font-style: italic;" class="text-red-600">
                                           <span class="font-bold  ">Ghi chú*: </span><?php echo e($speak_note[$exp['id']]); ?>

                                       </div>
                                   </div>
                                   <?php endif; ?>
                               </div>
                               <?php elseif($exp['type'] == 4): ?>
                               <div class="space-y-5">
                                   <?php if(!empty($exp['question_options'])): ?>
                                   <?php $__currentLoopData = $exp['question_options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <div class="flex justify-between space-x-5">
                                       <div class="flex-1">
                                           <?php if($v['description'] == 'title'): ?>
                                           <h3 class="font-bold"><?php echo e($v['title']); ?></h3>
                                           <?php else: ?>
                                           <?php $i++; ?>
                                           <div class="flex items-center flex-wrap">
                                               <?php
                                                $str = str_replace("{INPUT}", "<input name='words[" . $v['id'] . "]'  value='" . $words[$v['id']] . "' type='text' class='flex-1 font-bold text-red-600 ml-2 border-0 border-b outline-none focus:outline-none hover:outline-none' >", $v['title']);
                                                ?>
                                               <?php echo $i ?>. <?php echo $str; ?>

                                           </div>
                                           <?php if(!empty($experience_note) && !empty($experience_note[$v['id']])): ?>
                                           <div class="mt-3">
                                               <div style="font-style: italic;" class="text-red-600">
                                                   <span class="font-bold  ">Ghi chú*: </span><?php echo e($experience_note[$v['id']]); ?>

                                               </div>
                                           </div>
                                           <?php endif; ?>
                                           <?php endif; ?>
                                       </div>
                                   </div>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   <?php endif; ?>
                               </div>
                               <?php elseif($exp['type'] == 5): ?>
                               <div class="">
                                   <?php
                                    $question_options = collect($exp['question_options']);
                                    $reads = $question_options->where('characters', null)->all();
                                    $booleans = $question_options->where('characters', '!=', null)->all();
                                    $booleans = collect($booleans)->groupBy('order');
                                    ?>
                                   <div class="read_list space-y-5">
                                       <?php if(!empty($reads)): ?>
                                       <?php $__currentLoopData = $reads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <div class="flex justify-between space-x-5">
                                           <div class="flex-1">
                                               <?php if($v['description'] == 'title'): ?>
                                               <h3 class="font-bold "><?php echo e($v['title']); ?></h3>
                                               <?php elseif($v['description'] == 'input'): ?>
                                               <?php $i++ ?>
                                               <div class="flex items-center flex-wrap">
                                                   <?php
                                                    $str = str_replace("{INPUT}", "<input name='words[" . $v['id'] . "]' value='" . $words[$v['id']] . "' type='text' class='flex-1 font-bold text-red-600 ml-2 border-0 border-b outline-none focus:outline-none hover:outline-none' >", $v['title']);
                                                    ?>
                                                   <?php echo $i ?>. <?php echo $str; ?>

                                               </div>
                                               <?php if(!empty($experience_note) && !empty($experience_note[$v['id']])): ?>
                                               <div class="mt-3">
                                                   <div style="font-style: italic;" class="text-red-600">
                                                       <span class="font-bold  ">Ghi chú*: </span><?php echo e($experience_note[$v['id']]); ?>

                                                   </div>
                                               </div>
                                               <?php endif; ?>
                                               <?php endif; ?>
                                           </div>
                                       </div>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                   </div>
                                   <div class="mt-3 space-y-3">
                                       <?php
                                        if (!empty($booleans) && count($booleans) > 0) {
                                            foreach ($booleans as $key => $item) {
                                                if (!empty($item) && count($item) > 0) {
                                                    $i++;
                                        ?>
                                                   <div class="item mb-[20px]" id="question-1-<?php echo e($i); ?>">
                                                       <div class="title-4 bold-1 p-[15px] mt-[10px] flex pl-0">
                                                           <span class="bold-1"><?php echo e($i); ?>. <?php echo e($item[0]['description']); ?></span>
                                                       </div>
                                                       <ul class="mt-[10px]">
                                                           <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                        $class = 'bg-green-600 text-white';
                                                                    } else {
                                                                        $class = 'bg-red-600 text-white';
                                                                    }
                                                                }
                                                                if ($questionOptionsSuccess[$exp['id']][$key] != $v['id'] && $v['characters'] == $v['isTrue']) {
                                                                    $class = 'bg-green-600 text-white';
                                                                }
                                                            }
                                                            ?>
                                                           <li class="mb-[10px] flex items-center ">
                                                               <label class="cursor-pointer flex flex-wrap" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',<?php echo e($v['id']); ?>,<?php echo e($i); ?>)">
                                                                   <input disabled <?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>checked<?php } ?> type="radio" class="float-left mr-[10px] w-5 h-5 handleQuestion-<?php echo $v['question_id'] . '-' . $key ?> handleQuestionOption-<?php echo $v['id']  ?>" data-question-id="<?php echo e($v['question_id']); ?>" data-question-option-id="<?php echo e($v['id']); ?>" name="quiz[<?php echo e($v['question_id']); ?>][<?php echo e($key); ?>]" value="<?php echo e($v['id']); ?>">
                                                                   <span class="<?php echo $class ?>">
                                                                       <?php echo e($v['characters']); ?>. <?php echo $v['title']; ?>

                                                                   </span>
                                                               </label>
                                                           </li>
                                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                       </ul>
                                                   </div>
                                                   <?php if(!empty($experience_note) && !empty($experience_note[$v['id']])): ?>
                                                   <div class="mt-3">
                                                       <div style="font-style: italic;" class="text-red-600">
                                                           <span class="font-bold  ">Ghi chú*: </span><?php echo e($experience_note[$v['id']]); ?>

                                                       </div>
                                                   </div>
                                                   <?php endif; ?>
                                               <?php } ?>
                                           <?php } ?>
                                       <?php } ?>
                                   </div>
                               </div>
                               <?php endif; ?>
                           </div>
                       </div>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       <?php endif; ?>
                   </div>
                   <div class=" px-[15px] content-right" style="width: 300px;">
                       <div class="hidden md:block relative">
                           <aside class="sidebar-test ">
                               <div class="sidebar-test-1">
                                   <h3 class="flex items-center py-[5px] px-[10px] border border-b-0">
                                       <img src="<?php echo e(asset('frontend/img/hourglass.gif')); ?>" alt="" class="w-[35px] inline-block float-left mr-[5px]">
                                       <span id="timer"><?php echo $timer ?></span>
                                   </h3>
                                   <div class="scroll border-r" id="style-2" style="overflow: hidden auto;position: relative;zoom: 1;height: 100%;">
                                       <div class="text-center bg-color_primary flex">
                                           <div class="text-white p-[5px] w-1/5">TT</div>
                                           <div class="text-white p-[5px] countQuestionOptionA w-1/5">0</div>
                                           <div class="text-white p-[5px] countQuestionOptionB w-1/5">0</div>
                                           <div class="text-white p-[5px] countQuestionOptionC w-1/5">0</div>
                                           <div class="text-white p-[5px] countQuestionOptionD w-1/5">0</div>
                                       </div>
                                       <?php $i = 0;
                                        $count = 0; ?>
                                       <?php if(!empty($experienceData)): ?>
                                       <?php $__currentLoopData = $experienceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($exp['type'] == 1): ?>
                                       <?php
                                        $data = collect($exp['question_options'])->groupBy('order');
                                        if (!empty($data) && count($data) > 0) {
                                            foreach ($data as $key => $item) {
                                                if (!empty($item) && count($item) > 0) {
                                                    $i++;
                                        ?>
                                                   <div class="text-center flex w-full border-l border-b" id="scrollable-item-<?php echo e($i); ?>">
                                                       <div class="text-f18 p-[5px] w-1/5"><?php echo e($i); ?></div>
                                                       <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                $class = 'bg-red-600 text-white border-red-600';
                                                            }
                                                        }

                                                        ?>
                                                       <div class="p-[5px] w-1/5" id="question-<?php echo e($v['question_id']); ?>-<?php echo e($key); ?>">
                                                           <button type="button" href="javascript:void(0)" onclick="handleQuestionRight('<?php echo $v['question_id'] . '-' . $key ?>',<?php echo e($v['id']); ?>,<?php echo e($i); ?>)" class="<?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>active<?php } ?> <?php if (!empty($v['characters'] == $v['isTrue'])) { ?>bg-green-600 text-white border-green-600<?php } ?> <?php echo $class ?> w-[32px] h-[32px] border border-gray-700 rounded-full question-<?php echo e($v['question_id']); ?>-<?php echo e($key); ?> question-option-<?php echo e($v['id']); ?> btnCharacters " data-characters="<?php echo e($v['characters']); ?>"><?php echo e($v['characters']); ?></button>
                                                       </div>
                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   </div>
                                               <?php } ?>
                                           <?php } ?>
                                       <?php } ?>
                                       <?php elseif($exp['type'] == 2): ?>
                                       <?php $i++; ?>
                                       <?php elseif($exp['type'] == 3): ?>
                                       <?php $i++; ?>
                                       <?php elseif($exp['type'] == 4): ?>
                                       <?php if(!empty($exp['question_options'])): ?>
                                       <?php $__currentLoopData = $exp['question_options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($v['description'] == 'input'): ?>
                                       <?php $i++; ?>
                                       <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                       <?php elseif($exp['type'] == 5): ?>
                                       <div class="">
                                           <?php
                                            $question_options = collect($exp['question_options']);
                                            $reads = $question_options->where('characters', null)->all();
                                            $booleans = $question_options->where('characters', '!=', null)->all();
                                            $booleans = collect($booleans)->groupBy('order');
                                            ?>
                                           <div>
                                               <?php if(!empty($reads)): ?>
                                               <?php $__currentLoopData = $reads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <?php if($v['description'] == 'input'): ?>
                                               <?php $i++ ?>
                                               <?php endif; ?>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                               <?php endif; ?>
                                           </div>
                                           <?php
                                            if (!empty($booleans) && count($booleans) > 0) {
                                                foreach ($booleans as $key => $item) {
                                                    if (!empty($item) && count($item) > 0) {
                                                        $i++;
                                            ?>
                                                       <div class="text-center flex w-full border-l border-b" id="scrollable-item-<?php echo e($i); ?>">
                                                           <div class="text-f18 p-[5px] w-1/5"><?php echo e($i); ?></div>
                                                           <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                    $class = 'bg-red-600 text-white border-red-600';
                                                                }
                                                            }

                                                            ?>
                                                           <div class="p-[5px] w-1/5" id="question-<?php echo e($v['question_id']); ?>-<?php echo e($key); ?>">
                                                               <button type="button" href="javascript:void(0)" onclick="handleQuestionRight('<?php echo $v['question_id'] . '-' . $key ?>',<?php echo e($v['id']); ?>,<?php echo e($i); ?>)" class="<?php if (!empty($questionOptionsSuccess[$exp['id']][$key]) && $questionOptionsSuccess[$exp['id']][$key] == $v['id']) { ?>active<?php } ?> <?php if (!empty($v['characters'] == $v['isTrue'])) { ?>bg-green-600 text-white border-green-600<?php } ?> <?php echo $class ?> w-[32px] h-[32px] border border-gray-700 rounded-full question-<?php echo e($v['question_id']); ?>-<?php echo e($key); ?> question-option-<?php echo e($v['id']); ?> btnCharacters " data-characters="<?php echo e($v['characters']); ?>"><?php echo e($v['characters']); ?></button>
                                                           </div>
                                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                       </div>
                                                   <?php } ?>
                                               <?php } ?>
                                           <?php } ?>
                                       </div>
                                       <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                   </div>
                               </div>
                           </aside>
                       </div>
                   </div>
               </div>
           </div>
       </div>

   </div>
   <?php $__env->stopSection(); ?>
   <?php $__env->startPush('javascript'); ?>
   <style>
       .sidebar-test-1 {
           width: 100%;
           height: calc(100% - 10px);
           border-bottom: 0px;
           padding-bottom: 35px;
       }
   </style>

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
   </script>
   <script>
       $.fn.scrollDivToElement = function(childSel) {
           if (!this.length) return this;
           return this.each(function() {
               let parentEl = $(this);
               let childEl = parentEl.find(childSel);
               if (childEl.length > 0) {
                   parentEl.scrollTop(
                       parentEl.scrollTop() - parentEl.offset().top + childEl.offset().top - (parentEl.outerHeight() / 2) + (childEl.outerHeight() / 2)
                   );
               }
           });
       };

       function countCharacters() {
           $('.countQuestionOptionA').html($('.btnCharacters[data-characters="A"].active').length)
           $('.countQuestionOptionB').html($('.btnCharacters[data-characters="B"].active').length)
           $('.countQuestionOptionC').html($('.btnCharacters[data-characters="C"].active').length)
           $('.countQuestionOptionD').html($('.btnCharacters[data-characters="D"].active').length)
       }
       countCharacters();

       function handleQuestionRight(question_id, question_option_id, i) {
           $('html, body').animate({
               scrollTop: $('#question-1-' + i).offset().top - 50
           }, 300);
       }
       $(document).ready(function($) {
           localStorage.removeItem('valuePause')
           localStorage.removeItem('timer')
           localStorage.removeItem('pause')

           if ($(window).width() > 768) {
               onResize($(window).scrollTop());

               function onResize(scrollTop) {
                   if (scrollTop >= 100) {
                       $('.sidebar-test').addClass('scrolled')
                   } else {
                       $('.sidebar-test').removeClass('scrolled')
                   }
               }
           }

       });
   </script>
   <?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/frontend/quiz/answer.blade.php ENDPATH**/ ?>
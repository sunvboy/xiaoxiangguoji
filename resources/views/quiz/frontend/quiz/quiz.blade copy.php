   @extends('homepage.layout.home')
   @section('content')
   <form id="main" method="POST" action="{{route('quizzes.frontend.quizSubmit',['id' => $detail->id])}}" class="sitemap main-Test pb-[20px] md:pb-[70px]" enctype="multipart/form-data">
       @csrf
       <div class="breadcrumb py-[10px] bg-gray-100">
           <div class="container mx-auto px-3">
               <ul class="flex flex-wrap">
                   <li class="pr-[5px]"><a href="{{url('/')}}">Trang chủ</a> /</li>
                   <li class="pr-[5px]"><a href="{{route('quizzes.frontend.index')}}">Danh sách bài thi</a> /</li>
                   <li class="pr-[5px]">{{$detail->title}}</li>
               </ul>
           </div>
       </div>
       <div class="content-Test pt-[20px] md:pt-[60px]">
           <div class="container mx-auto px-3">
               <div class="flex flex-wrap justify-start mx-[-15px]">
                   <div class="px-[15px] content-left" style="width: calc(100% - 300px);">
                       <?php $i = 0;
                        $count = 0; ?>
                       @if(!empty($experienceData))
                       @foreach($experienceData as $key=>$exp)
                       <?php $count += collect($exp['question_options'])->groupBy('order')->count() ?>
                       <div class="item-large mb-[30px]">
                           @if($exp['type'] == 1)
                           @if(collect($exp['question_options'])->groupBy('order')->count() > 1)
                           <h3 class="title-2 text-color_primary font-bold">Câu {{$i+1}} - {{$count}}</h3>
                           @else
                           <h3 class="title-2 text-color_primary font-bold">Câu {{$i+1}} </h3>
                           @endif
                           @else
                           <h3 class="title-2 text-color_primary font-bold">Câu {{++$i}} </h3>

                           @endif
                           <div class="border border-gray-200 shadow p-[15px] md:p-[25px] mt-[20px]">
                               <div class="item mb-[20px]">
                                   <h4 class="title-4 bold-1 bg-gray-100 p-[15px] mt-[10px]"> {!!$exp['title']!!}</h4>
                                   @if($exp['type'] == 3)
                                   <div class="">
                                       <audio id="song{!!$exp['id']!!}" class="w-full max-w-md mx-auto hidden song" controls>
                                           <source src="{{asset($exp['file'])}}" type="audio/mpeg">
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
                                   @endif
                               </div>
                               @if($exp['type'] == 1)
                               <?php
                                $data = collect($exp['question_options'])->groupBy('order');
                                if (!empty($data) && count($data) > 0) {
                                    foreach ($data as $key => $item) {
                                        if (!empty($item) && count($item) > 0) {
                                            $i++;
                                ?>
                                           <div class="item mb-[20px]" id="question-1-{{$i}}">
                                               @if(collect($exp['question_options'])->groupBy('order')->count() > 1)
                                               <div class="title-4 bold-1 p-[15px] mt-[10px] flex pl-0">
                                                   <span class="bold-1">{{ $i}}.</span>
                                                   <div>{!! !empty($item) ? $item[0]['description'] : ""!!}</div>
                                               </div>
                                               @endif
                                               <ul class="mt-[10px]">
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
                                                    ?>
                                                   <li class="mb-[10px] flex items-center">
                                                       <label class="cursor-pointer" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',{{$v['id']}},{{$i}})">
                                                           <input type="radio" class="float-left mr-[10px] w-5 h-5 handleQuestion-<?php echo $v['question_id'] . '-' . $key ?> handleQuestionOption-<?php echo $v['id']  ?>" data-question-id="{{$v['question_id']}}" data-question-option-id="{{$v['id']}}" name="quiz[{{$v['question_id']}}][{{$key}}]" value="{{$v['id']}}">
                                                           {{$v['characters']}}. {{$v['title']}}
                                                       </label>
                                                   </li>
                                                   @endforeach
                                               </ul>
                                           </div>
                                       <?php } ?>
                                   <?php } ?>
                               <?php } ?>
                               @elseif($exp['type'] == 2)
                               <textarea name="essays[{!!$exp['id']!!}]" class="border w-full p-3 focus:outline-none" rows="10" placeholder="Nhập câu trả lời"></textarea>
                               @elseif($exp['type'] == 3)
                               <div class="flex flex-col relative">
                                   <label for="file" class="uploadFile cursor-pointer w-full h-[45px] border border-gray-200 mb-[15px] inline-block leading-[45px] pl-[10px] bg-white">
                                       <i class="fas fa-paperclip fa-md mr-2"></i>
                                       <span class="filename filename-{{$exp['id']}}">Upload file</span>
                                       <input type="file" id="file" name="files[{!!$exp['id']!!}]" class="inputfile form-control" name="file" data-id="{{$exp['id']}}">
                                   </label>
                               </div>
                               @elseif($exp['type'] == 4)
                               <div class="space-y-5">
                                   @if(!empty($exp['question_options']))
                                   @foreach($exp['question_options'] as $k=>$v)
                                   <div class="flex justify-between space-x-5">
                                       <div class="flex-1">
                                           @if($v['description'] == 'title')
                                           <h3 class="font-bold">{{$v['title']}}</h3>
                                           @else
                                           <?php $i++; ?>
                                           <div class="flex items-center text-danger font-bold flex-wrap">
                                               <?php
                                                $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v['title']);
                                                ?>
                                               <?php echo $i ?>. {!!$str!!}
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
                                    $exp = collect($exp['question_options']);
                                    $reads = $exp->where('characters', null)->all();
                                    $booleans = $exp->where('characters', '!=', null)->all();
                                    $booleans = collect($booleans)->groupBy('order');
                                    ?>
                                   <div class="read_list space-y-5">
                                       @if(!empty($reads))
                                       @foreach($reads as $k=>$v)
                                       <div class="flex justify-between space-x-5">
                                           <div class="flex-1">
                                               @if($v['description'] == 'title')
                                               <h3 class="font-bold ">{{$v['title']}}</h3>
                                               @elseif($v['description'] == 'input')
                                               <?php $i++ ?>
                                               <div class="flex items-center text-danger font-bold flex-wrap">
                                                   <?php
                                                    $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v['title']);
                                                    ?>
                                                   <?php echo $i ?>. {!!$str!!}
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
                                                   <div class="item mb-[20px]" id="question-1-{{$i}}">
                                                       <div class="title-4 bold-1 p-[15px] mt-[10px] flex pl-0">
                                                           <span class="bold-1">{{ $i}}.</span>
                                                           <div>{!! !empty($item) ? $item[0]['description'] : ""!!}</div>
                                                       </div>
                                                       <ul class="mt-[10px]">
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
                                                            ?>
                                                           <li class="mb-[10px] flex items-center">
                                                               <label class="cursor-pointer" onClick="handleQuestionOption('<?php echo $v['question_id'] . '-' . $key ?>',{{$v['id']}},{{$i}})">
                                                                   <input type="radio" class="float-left mr-[10px] w-5 h-5 handleQuestion-<?php echo $v['question_id'] . '-' . $key ?> handleQuestionOption-<?php echo $v['id']  ?>" data-question-id="{{$v['question_id']}}" data-question-option-id="{{$v['id']}}" name="quiz[{{$v['question_id']}}][{{$key}}]" value="{{$v['id']}}">
                                                                   {{$v['characters']}}. {{$v['title']}}
                                                               </label>
                                                           </li>
                                                           @endforeach
                                                       </ul>
                                                   </div>
                                               <?php } ?>
                                           <?php } ?>
                                       <?php } ?>
                                   </div>
                               </div>
                               @endif
                           </div>
                       </div>
                       @endforeach
                       @endif
                   </div>
                   <div class=" px-[15px] content-right" style="width: 300px;">
                       <div class="hidden md:block relative">
                           <aside class="sidebar-test ">
                               <div class="sidebar-test-1">
                                   <h3 class="flex items-center py-[5px] px-[10px] border border-b-0">
                                       <img src="{{asset('frontend/img/hourglass.gif')}}" alt="" class="w-[35px] inline-block float-left mr-[5px]">
                                       <span id="timer"></span>
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
                                       @if(!empty($experienceData))
                                       @foreach($experienceData as $key=>$exp)
                                       @if($exp['type'] == 1)
                                       <?php
                                        $data = collect($exp['question_options'])->groupBy('order');
                                        if (!empty($data) && count($data) > 0) {
                                            foreach ($data as $key => $item) {
                                                if (!empty($item) && count($item) > 0) {
                                                    $i++;
                                        ?>
                                                   <div class="text-center flex w-full border-l border-b" id="scrollable-item-{{$i}}">
                                                       <div class="text-f18 p-[5px] w-1/5">{{$i}}</div>
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
                                                        ?>
                                                       <div class="p-[5px] w-1/5" id="question-{{$v['question_id']}}-{{$key}}">
                                                           <button type="button" href="javascript:void(0)" onclick="handleQuestionRight('<?php echo $v['question_id'] . '-' . $key ?>',{{$v['id']}},{{$i}})" class="w-[32px] h-[32px] border border-gray-700 rounded-full question-{{$v['question_id']}}-{{$key}} question-option-{{$v['id']}} btnCharacters" data-characters="{{$v['characters']}}">{{$v['characters']}}</button>
                                                       </div>
                                                       @endforeach
                                                   </div>
                                               <?php } ?>
                                           <?php } ?>
                                       <?php } ?>
                                       @endif
                                       @endforeach
                                       @endif
                                   </div>
                               </div>
                               <div class="flex mt-2">
                                   <input type="hidden" name="valueTimer" class="">
                                   <input type="hidden" name="valuePause" class="">
                                   <button class="w-1/2 inline-block transition-all py-[10px] px-[25px] bg-color_primary text-white border border-color_primary hover:bg-white hover:text-color_primary bold-1 uppercase mr-[10px]" id="btnSubmit">Nộp bài</button>
                                   <button type="button" class="w-1/2 inline-block transition-all py-[10px] px-[25px] bg-color_second border border-color_second hover:bg-color_primary hover:border-primary hover:text-white bold-1 uppercase" id="btnPause" onclick="handlePause()">Tạm dừng</button>
                                   <button type="button" class="w-1/2 inline-block transition-all py-[10px] px-[25px] bg-green-600 border border-green-600 hover:bg-color_primary hover:border-primary hover:text-white bold-1 uppercase hidden" id="btnContinue" onclick="handleContinue()">Tiếp tục</button>
                               </div>
                           </aside>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50  w-full overflow-x-hidden hidden overflow-y-auto md:inset-0 h-screen max-h-full" style="background: #000000a6;z-index: 9999999;">
           <div class="relative w-full max-w-lg max-h-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
               <!-- Modal content -->
               <div class="relative bg-white shadow dark:bg-gray-700 rounded-lg">
                   <div class="p-6 text-center">
                       <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                       </svg>
                       <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Đã hết thời gian làm bài</h3>
                       <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                           Nộp bài
                       </button>
                   </div>
               </div>
           </div>
       </div>
   </form>
   @endsection
   @push('javascript')

   <script>
       /* var c = localStorage.getItem('timer')
       if (!c) {
           c = <?php echo $detail->time * 60 ?>;
       } */
       c = <?php echo $detail->time * 60 ?>;
       var currentQuestion = 0;
       var viewingAns = 0;
       var correctAnswers = 0;
       var quizOver = false;
       var iSelectedAnswer = [];
       var t;
       timedCount()
       /*var d = localStorage.getItem('valuePause')
       if (!d) {
           d = 0;
       } */
       d = 0;
       $('input[name="valuePause"]').val(d)

       function handlePause() {
           d = parseInt(d) + 1
           $('input[name="valuePause"]').val(d)
           localStorage.setItem('valuePause', d)
           localStorage.setItem('pause', true)
           $('#btnContinue').removeClass('hidden')
           $('#btnPause').addClass('hidden')
       }

       function handleContinue() {
           localStorage.removeItem('pause')
           $('#btnContinue').addClass('hidden')
           $('#btnPause').removeClass('hidden')
           timedCount()
       }

       function timedCount() {
           var pause = localStorage.getItem('pause')
           if (pause) {
               return false
           }
           var hours = parseInt(c / 3600) % 24;
           var minutes = parseInt(c / 60) % 60;
           var seconds = c % 60;
           if (hours > 0) {
               var result = (hours < 10 ? "0" + hours : hours) + "h" + (minutes < 10 ? "0" + minutes : minutes) + "m" + (seconds < 10 ? "0" + seconds : seconds) + "s";
           } else {
               var result = (minutes < 10 ? "0" + minutes : minutes) + "m" + (seconds < 10 ? "0" + seconds : seconds) + "s";

           }
           $('#timer').html(result);
           localStorage.setItem('timer', c)
           if (c == 0) {
               $('body').css('overflow', 'hidden');
               $('#defaultModal').removeClass('hidden')
               $('#btnContinue').addClass('hidden')
               $('#btnPause').addClass('hidden')
               $('#btnSubmit').removeClass('w-1/2').addClass('w-full')
               return false;
           }
           c = c - 1;
           $('input[name="valueTimer"]').val(c)
           t = setTimeout(function() {
               timedCount()
           }, 1000);
       }
       $(document).ready(function() {
           //    var pause = localStorage.getItem('pause')
           //    var timer = localStorage.getItem('timer')
           //    var hours = parseInt(timer / 3600) % 24;
           //    var minutes = parseInt(timer / 60) % 60;
           //    var seconds = timer % 60;
           //    if (hours > 0) {
           //        var result = (hours < 10 ? "0" + hours : hours) + "h" + (minutes < 10 ? "0" + minutes : minutes) + "m" + (seconds < 10 ? "0" + seconds : seconds) + "s";
           //    } else {
           //        var result = (minutes < 10 ? "0" + minutes : minutes) + "m" + (seconds < 10 ? "0" + seconds : seconds) + "s";
           //    }
           //    $('#timer').html(result);
           //    if (pause) {
           //        $('#btnPause').addClass('hidden')
           //        $('#btnContinue').removeClass('hidden')
           //    }
       });
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

       function handleQuestionOption(question_id, question_option_id, i) {
           $('.question-' + question_id).removeClass('bg-primary text-white border-primary active')
           $('.question-option-' + question_option_id).addClass('bg-primary text-white border-primary active')
           //prevent the page from jumping down to our section.
           //    $('.scroll').animate({
           //        scrollTop: $('#scrollable-item-' + i).offset().top
           //    }, 0);
           countCharacters()
       }

       function handleQuestionRight(question_id, question_option_id, i) {
           $('.question-' + question_id).removeClass('bg-primary text-white border-primary active')
           $('.question-option-' + question_option_id).addClass('bg-primary text-white border-primary active')
           $('.handleQuestion-' + question_id).prop('checked', false);
           $('.handleQuestionOption-' + question_option_id).prop('checked', true);
           $('html, body').animate({
               scrollTop: $('#question-1-' + i).offset().top - 50
           }, 300);
           countCharacters()
       }
   </script>
   <script>
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
       $('input[type="file"]').change(function(e) {
           var id = $(this).attr('data-id');
           var fileName = e.target.files[0].name;
           $('.filename-' + id).html(fileName)
       });
   </script>
   @endpush
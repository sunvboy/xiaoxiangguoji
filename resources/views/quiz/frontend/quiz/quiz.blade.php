   @extends('homepage.layout.home')
   @section('content')
   <div class="ps-page--product ps-page--product1 page-check pb-120 bg-gray" id="ps-page--product">
       <div class="container">
           <ul class="ps-breadcrumb">
               <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
               <li class="ps-breadcrumb__item active"><a href="{{route('routerURL',['slug' => $detail->slug])}}">{!!$detail->title!!}</a></li>
           </ul>
           <form method="POST" action="{{route('quizzes.frontend.quizSubmit',['id' => $detail->id])}}" enctype="multipart/form-data">
               @csrf
               <div class="ps-page__content">
                   <h1 class="title-pr">{!!$detail->title!!} của Quý khách</h1>
                   <div class="content-box-check" id="list">
                       <h4 class="title-4"><a href="javascript:void(0)" class="js_prevQuizzes"><i class="fa fa-angle-left" aria-hidden="true"></i>Trước</a>Câu <span class="js_numberActive"></span>/<?php echo count($experienceData) ?></h4>
                       <div class="progress">
                           <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                           </div>
                       </div>
                       <div id="listQuizzes">
                           @if(!empty($experienceData))
                           @foreach($experienceData as $key=>$item)
                           <div id="quizzes-{{$key+1}}" data-number="{{$key+1}}" class="quizzes d-none active">
                               <h3 class="title-3">Câu {{$key+1}}: {!!strip_tags($item['title'])!!}</h3>
                               <div class="box-box">
                                   @if(!empty($item['question_options']))
                                   @foreach($item['question_options'] as $val)
                                   @if(!empty($val['title']))
                                   <div class="item">
                                       <label for="question_id_{{$val['id']}}" style="cursor: pointer;display: flex; align-items: center;">
                                           <input type="radio" id="question_id_{{$val['id']}}" name="quiz[{{$val['question_id']}}]" value="{{$val['id']}}"> {!!$val['title']!!}
                                       </label>
                                   </div>
                                   @endif
                                   @endforeach
                                   @endif
                               </div>
                           </div>
                           @endforeach
                           @endif
                       </div>
                       <div class="letgo">
                           <a href="javascript:void(0)" class="js_nextQuizzes">Tiếp tục</a>
                       </div>
                   </div>
                   <!-- START: Đăng ký nhận kết quả -->
                   <div class="content-box-check" id="form">
                       <h4 class="title-4">Đăng ký thông tin để nhận kết quả</h4>
                       <div class="box-box">
                           <div class="item">
                               <ul>
                                   <li>
                                       <label>
                                           <input type="radio" name="sex" value="Anh" checked>Anh
                                       </label>
                                   </li>
                                   <li>
                                       <label>
                                           <input type="radio" name="sex" value="Chị">Chị
                                       </label>
                                   </li>
                               </ul>
                           </div>
                           <input type="text" placeholder="Họ và tên" name="name" required>
                           <input type="text" placeholder="Số điện thoại" name="phone" required>
                           <input type="text" placeholder="Email" name="email">

                           <div class="letgo">
                               <button type="submit">Nhận kết quả</button>
                               <a href="javascript:void(0)" class="reply">Trả lời lại</a>
                           </div>
                       </div>

                   </div>
                   <!-- END: Đăng ký nhận kết quả -->
               </div>
           </form>
       </div>
   </div>

   @endsection
   @push('javascript')
   <style>
       .page-check .content-box-check .letgo button {
           display: inline-block;
           width: 100%;
           background: #333369;
           height: 44px;
           text-align: center;
           line-height: 44px;
           color: #fff;
           text-transform: uppercase;
           font-size: 16px;
           border-radius: 25px;
           margin-top: 10px;
           border: 1px solid #333369;
       }

       .quizzes.active {
           display: block !important;
       }

       .box-box p {
           margin-bottom: 0px !important;
       }
   </style>
   <script>
       document.addEventListener('DOMContentLoaded', (event) => {
           let currentQuiz = 1;
           const totalQuizzes = <?php echo count($experienceData) ?>;

           function updateProgressBar() {
               const progressPercentage = (currentQuiz / totalQuizzes) * 100;
               $('.progress-bar').css('width', progressPercentage + '%')
           }
           $(document).on('click', '.reply', function(e) {
               $('#form').css('display', 'none')
               $('#list').css('display', 'block')
           })


           function showQuiz(number) {
               if (number == 1) {
                   $('.js_prevQuizzes').css('display', 'none')
               } else {
                   $('.js_prevQuizzes').css('display', 'block')
               }
               $('.js_numberActive').html(number)
               if (number == totalQuizzes) {
                   $('#form').css('display', 'block')
                   $('#list').css('display', 'none')
               } else {
                   $('#form').css('display', 'none')
                   $('#list').css('display', 'block')
               }
               for (let i = 1; i <= totalQuizzes; i++) {
                   const quiz = document.getElementById(`quizzes-${i}`);
                   if (i === number) {
                       quiz.classList.remove('d-none');
                       quiz.classList.add('active');
                   } else {
                       quiz.classList.add('d-none');
                       quiz.classList.remove('active');
                   }
               }
               updateProgressBar();
           }

           document.querySelector('.js_nextQuizzes').addEventListener('click', (e) => {
               e.preventDefault();
               if (currentQuiz < totalQuizzes) {
                   currentQuiz++;
                   showQuiz(currentQuiz);
               }
           });
           document.querySelector('.js_prevQuizzes').addEventListener('click', (e) => {
               e.preventDefault();
               if (currentQuiz > 1) {
                   currentQuiz--;
                   showQuiz(currentQuiz);
               }
           });
           showQuiz(currentQuiz);
       });
   </script>
   @endpush
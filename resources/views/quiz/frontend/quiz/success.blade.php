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
    $true = $pass = 0;
    if (!empty($success->question_options)) {
        $questionOptionsSuccess = json_decode($success->question_options, TRUE);
        if (!empty($questionOptionsSuccess) && !empty(array_keys($questionOptionsSuccess))) {
            $questionsData = \App\Models\Question::whereIn('id', array_keys($questionOptionsSuccess))->orderBy('type', 'asc')->get();

            if (!empty($questionsData)) {
                foreach ($questionsData as $key => $item) {
                    $question_options = \App\Models\QuestionOption::where('id', $questionOptionsSuccess[$item->id])->get();
                    $filtered = $question_options->filter(function ($value, int $key) {
                        return $value->characters == $value->isTrue;
                    });
                    $true = $true + $filtered->count();
                }
            }
        }
        if (!empty($true)) {
            $pass = ($true / count($questionOptionsSuccess)) * 100;
        }
    }
    $products = !empty($detail->products) ? json_decode($detail->products) : [];
    $products = \App\Models\Product::select('id', 'title', 'image', 'price', 'price_sale', 'price_contact', 'slug')->whereIn('id', $products)->get();
    $articles = !empty($detail->articles) ? json_decode($detail->articles) : [];
    $articles = \App\Models\Article::select('id', 'title', 'image', 'description', 'slug', 'catalogue_id')->with('catalogues')->whereIn('id', $articles)->get();
    ?>
   <div class="ps-page--product ps-page--product1 page-check page-check-register bg-gray">
       <div class="container">
           <ul class="ps-breadcrumb">
               <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
               <li class="ps-breadcrumb__item active"><a href="{{route('routerURL',['slug' => $detail->slug])}}">{!!$detail->title!!}</a></li>
           </ul>
           <div class="ps-page__content">
               <h1 class="title-pr">{!!$detail->title!!} của Quý khách</h1>
               @if($pass < 20) <div class="content-check-register">
                   <h3 class="title-3">Kết quả: <span>{{$detail->thap_title}}</span></h3>
                   <div class="desc" style="margin-bottom: 20px;">{!!$detail->thap_description!!}</div>
                   <?php /*  <div class="img-check">
                       <img src="img/alzheimer-low.png" alt="">
                   </div>*/ ?>
                   <h4 class="title-4"><?php /*<img src="{{asset('frontend/img/hotline.png')}}" alt="Lời khuyên từ chuyên gia">*/ ?> <span> Lời khuyên từ chuyên gia</span></h4>
                   <div class="list-list">
                       {!!$detail->thap_content!!}
                   </div>
           </div>
           @else
           <div class="content-check-register">
               <h3 class="title-3">Kết quả: <span style="color:red">{{$detail->cao_title}}</span></h3>
               <div class="desc" style="margin-bottom: 20px;">{!!$detail->cao_description!!}</div>
               <?php /*  <div class="img-check">
                       <img src="img/alzheimer-low.png" alt="">
                   </div>*/ ?>
               <h4 class="title-4"><?php /*<img src="{{asset('frontend/img/hotline.png')}}" alt="Lời khuyên từ chuyên gia">*/ ?> <span> Lời khuyên từ chuyên gia</span></h4>
               <div class="list-list">
                   {!!$detail->cao_content!!}
               </div>
           </div>

           @endif

           @if(!empty($products))
           <section class="ps-section--featured">
               <div class="container">
                   <div class="section-title-2">
                       <h2 class=" ps-section__title title title split-in-fade"><i class="fa fa-plus-circle" aria-hidden="true"></i>SẢN PHẨM GỢI Ý</h2>
                   </div>
                   <div class="ps-section__content">
                       <div class="slider-product-only owl-carousel">
                           @foreach($products as $key=>$item)
                           <div class="ps-section__product">
                               {!!htmlItemProduct($key,$item)!!}
                           </div>
                           @endforeach
                       </div>
                       <?php /*<div class="ps-shop__more"><a href="#">Show all</a></div>*/ ?>
                   </div>
               </div>
           </section>
           @endif
           @if(!empty($detail->mien_tru))
           <div class="exemption-hardship">
               <h3 class="title-2"><i class="fa fa-blind" aria-hidden="true"></i>Miễn trừ trách nhiệm</h3>
               <div>
                   {!!$detail->mien_tru!!}
               </div>
           </div>
           @endif
           @if(!empty($detail->video))
           <div class="video">
               {!!$detail->video!!}
           </div>
           @endif
           @if(!empty($articles))
           <section class="health-corner bg-white">
               <div class="section-title-2">
                   <h2 class=" ps-section__title title title split-in-fade"><i class="fa fa-plus-circle" aria-hidden="true"></i>TIN TỨC</h2>
               </div>
               <div class="row">
                   @foreach($articles as $key=>$item)
                   @if(!empty($key==0))
                   <div class="col-md-7 col-xs-7 col-xs-12">
                       <div class="item-large">
                           <div class="img hover-zoom">
                               <a href="{{route('routerURL',['slug' => $item->slug])}}">
                                   <img src="{{asset($item->image)}}" alt="{{$item->title}}" style="border-radius: 16px;">
                               </a>
                           </div>
                           @if(!empty($item->catalogues))
                           <p class="category-link"><a href="">{{$item->catalogues->title}}</a></p>
                           @endif
                           <h3 class="title-3"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                       </div>
                   </div>
                   @endif
                   @endforeach

                   <div class="col-md-5 col-xs-5 col-xs-12">
                       @foreach($articles as $key=>$item)
                       @if(!empty($key>0))
                       <div class="item-small">
                           <div class="item">
                               <div class="img hover-zoom">
                                   <a href="{{route('routerURL',['slug' => $item->slug])}}">
                                       <img src="{{asset($item->image)}}" alt="{{$item->title}}" style="border-radius: 16px;">
                                   </a>
                               </div>
                               <div class="nav-img">
                                   @if(!empty($item->catalogues))
                                   <p class="category-link"><a href="">{{$item->catalogues->title}}</a></p>
                                   @endif
                                   <h3 class="title-3"><a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a></h3>
                               </div>
                           </div>
                       </div>
                       @endif
                       @endforeach
                   </div>
               </div>
           </section>
           @endif
       </div>
   </div>
   </div>
   @endsection
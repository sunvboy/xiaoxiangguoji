   
   <?php $__env->startSection('content'); ?>
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
               <li class="ps-breadcrumb__item"><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
               <li class="ps-breadcrumb__item active"><a href="<?php echo e(route('routerURL',['slug' => $detail->slug])); ?>"><?php echo $detail->title; ?></a></li>
           </ul>
           <div class="ps-page__content">
               <h1 class="title-pr"><?php echo $detail->title; ?> của Quý khách</h1>
               <?php if($pass < 20): ?> <div class="content-check-register">
                   <h3 class="title-3">Kết quả: <span><?php echo e($detail->thap_title); ?></span></h3>
                   <div class="desc" style="margin-bottom: 20px;"><?php echo $detail->thap_description; ?></div>
                   <?php /*  <div class="img-check">
                       <img src="img/alzheimer-low.png" alt="">
                   </div>*/ ?>
                   <h4 class="title-4"><?php /*<img src="{{asset('frontend/img/hotline.png')}}" alt="Lời khuyên từ chuyên gia">*/ ?> <span> Lời khuyên từ chuyên gia</span></h4>
                   <div class="list-list">
                       <?php echo $detail->thap_content; ?>

                   </div>
           </div>
           <?php else: ?>
           <div class="content-check-register">
               <h3 class="title-3">Kết quả: <span style="color:red"><?php echo e($detail->cao_title); ?></span></h3>
               <div class="desc" style="margin-bottom: 20px;"><?php echo $detail->cao_description; ?></div>
               <?php /*  <div class="img-check">
                       <img src="img/alzheimer-low.png" alt="">
                   </div>*/ ?>
               <h4 class="title-4"><?php /*<img src="{{asset('frontend/img/hotline.png')}}" alt="Lời khuyên từ chuyên gia">*/ ?> <span> Lời khuyên từ chuyên gia</span></h4>
               <div class="list-list">
                   <?php echo $detail->cao_content; ?>

               </div>
           </div>

           <?php endif; ?>

           <?php if(!empty($products)): ?>
           <section class="ps-section--featured">
               <div class="container">
                   <div class="section-title-2">
                       <h2 class=" ps-section__title title title split-in-fade"><i class="fa fa-plus-circle" aria-hidden="true"></i>SẢN PHẨM GỢI Ý</h2>
                   </div>
                   <div class="ps-section__content">
                       <div class="slider-product-only owl-carousel">
                           <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="ps-section__product">
                               <?php echo htmlItemProduct($key,$item); ?>

                           </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       </div>
                       <?php /*<div class="ps-shop__more"><a href="#">Show all</a></div>*/ ?>
                   </div>
               </div>
           </section>
           <?php endif; ?>
           <?php if(!empty($detail->mien_tru)): ?>
           <div class="exemption-hardship">
               <h3 class="title-2"><i class="fa fa-blind" aria-hidden="true"></i>Miễn trừ trách nhiệm</h3>
               <div>
                   <?php echo $detail->mien_tru; ?>

               </div>
           </div>
           <?php endif; ?>
           <?php if(!empty($detail->video)): ?>
           <div class="video">
               <?php echo $detail->video; ?>

           </div>
           <?php endif; ?>
           <?php if(!empty($articles)): ?>
           <section class="health-corner bg-white">
               <div class="section-title-2">
                   <h2 class=" ps-section__title title title split-in-fade"><i class="fa fa-plus-circle" aria-hidden="true"></i>TIN TỨC</h2>
               </div>
               <div class="row">
                   <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <?php if(!empty($key==0)): ?>
                   <div class="col-md-7 col-xs-7 col-xs-12">
                       <div class="item-large">
                           <div class="img hover-zoom">
                               <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                   <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>" style="border-radius: 16px;">
                               </a>
                           </div>
                           <?php if(!empty($item->catalogues)): ?>
                           <p class="category-link"><a href=""><?php echo e($item->catalogues->title); ?></a></p>
                           <?php endif; ?>
                           <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                       </div>
                   </div>
                   <?php endif; ?>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                   <div class="col-md-5 col-xs-5 col-xs-12">
                       <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <?php if(!empty($key>0)): ?>
                       <div class="item-small">
                           <div class="item">
                               <div class="img hover-zoom">
                                   <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                                       <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>" style="border-radius: 16px;">
                                   </a>
                               </div>
                               <div class="nav-img">
                                   <?php if(!empty($item->catalogues)): ?>
                                   <p class="category-link"><a href=""><?php echo e($item->catalogues->title); ?></a></p>
                                   <?php endif; ?>
                                   <h3 class="title-3"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                               </div>
                           </div>
                       </div>
                       <?php endif; ?>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </div>
               </div>
           </section>
           <?php endif; ?>
       </div>
   </div>
   </div>
   <?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/quiz/frontend/quiz/success.blade.php ENDPATH**/ ?>
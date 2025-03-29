 <aside class="sidebar mt-[20px] md:mt-0">
     <div class="item-aside mb-[15px] md:mb-[25px]">
         <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
             {{$fcSystem['title_14']}}
         </h3>
         <div class="form">
             <form action="{{route('homepage.search')}}" class="relative">
                 <input type="text" name="keyword" placeholder="{{$fcSystem['title_14']}}" class="px-4 w-full h-[40px] border border-gray-200" />
                 <button type="submit" class="absolute top-[10px] right-[10px] text-gray-700">
                     <i class="fa-solid fa-magnifying-glass"></i>
                 </button>
             </form>
         </div>
     </div>
     <?php
        $articles = \App\Models\Article::select('id', 'title', 'slug', 'image')->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])->limit(5)->get();
        $courses = \App\Models\Course::select('id', 'title', 'slug', 'image')->where(['alanguage' => config('app.locale'), 'publish' => 0])->limit(5)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();

        ?>
     @include('homepage.common.courseCategory')
     @if(!empty($articles) && count($articles) > 0)
     <div class="item-aside mb-[15px] md:mb-[25px]">
         <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
             {{$fcSystem['title_16']}}
         </h3>
         <div class="nav-post">
             @foreach($articles as $item)
             <article class="item-post mb-[10px] md:mb-[15px] border-b border-gray-300 pb-[10px] md:pb-[15px]">
                 <div class="flex flex-wrap justify-between mx-[-7px]">
                     <div class="w-1/3 px-[7px]">
                         <div class="img hover-zoom">
                             <a href="{{$item->slug}}"><img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full object-cover h-[70px]" /></a>
                         </div>
                     </div>
                     <div class="nav-img w-2/3 px-[7px]">
                         <h3 class="title-4 bold-1 h-[46px] overflow-hidden leading-[23px]">
                             <a href="{{$item->slug}}" class="hover:text-color_primary transition-all">{{$item->title}}</a>
                         </h3>
                         <p class="date text-f15 text-gray-700 mt-[5px]">
                             {{$item->created_at}}
                         </p>
                     </div>
                 </div>
             </article>
             @endforeach
         </div>
     </div>
     @endif
     @if(!empty($courses) && count($courses) > 0)
     <div class="item-aside mb-[15px] md:mb-[25px]">
         <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
             {{$fcSystem['title_17']}}
         </h3>
         <div class="nav-post">
             @foreach($courses as $item)
             <article class="item-post mb-[10px] md:mb-[15px] border-b border-gray-300 pb-[10px] md:pb-[15px]">
                 <div class="flex flex-wrap justify-between mx-[-7px]">
                     <div class="w-1/3 px-[7px]">
                         <div class="img hover-zoom">
                             <a href="{{$item->slug}}"><img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full object-cover h-[70px]" /></a>
                         </div>
                     </div>
                     <div class="nav-img w-2/3 px-[7px]">
                         <h3 class="title-4 bold-1 h-[46px] overflow-hidden leading-[23px]">
                             <a href="{{$item->slug}}" class="hover:text-color_primary transition-all">{{$item->title}}</a>
                         </h3>
                         <p class="date text-f15 text-gray-700 mt-[5px]">
                             {{$item->created_at}}
                         </p>
                     </div>
                 </div>
             </article>
             @endforeach
         </div>
     </div>
     @endif
     <div class="item-aside mb-[15px] md:mb-[25px]">
         <a href="{{$fcSystem['banner_3']}}"><img src="{{asset($fcSystem['banner_2'])}}" alt="banner" class="w-full"></a>
     </div>

     @include('homepage.common.subscribers')
 </aside>
<?php
$courseCategory = \App\Models\CourseCategory::where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])->get();
?>
@if(!empty($courseCategory) && count($courseCategory) > 0)
<div class="{{!empty($class) ? $class : 'item-aside mb-[15px] md:mb-[25px]';}}">
    <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
        {{$fcSystem['title_15']}}
    </h3>
    <ul>
        @foreach($courseCategory as $item)
        <li class="mb-[10px] transition-all hover:pl-[15px]">
            <a href="{{$item->slug}}" class="hover:text-color_primary transition-all"><i class="fa-solid fa-right-long mr-[10px]"></i>{{$item->title}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif
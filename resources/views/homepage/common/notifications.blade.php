<a href="{{route('notification.frontend.index')}}" class="text-white text-f23 inline-block relative w-[30px]">
    <i class="fa-solid fa-bell mr-[5px]"></i>
    @if(count($notifications) > 0)
    <span class="bg-red-700 text-f12 w-[23px] h-[23px] rounded-full inline-block text-center top-[-10px] right-[-3px] leading-[23px] absolute">
        @if(count($notifications) > 9)
        9+
        @else
        {{count($notifications)}}
        @endif
    </span>
    @endif
</a>
@if(!empty($notifications) && count($notifications) > 0)
<div class="sub-bell absolute right-0  bg-white rounded-md shadow-lg overflow-hidden z-20" style="width:20rem;">
    <div class="py-2">
        @foreach($notifications as $item)

        <a <?php if (!empty($item->QuestionOptionUser)) { ?> href="{{route('quizzes.frontend.answer',['slug' => $item->QuestionOptionUser->quizzes->slug,'id' => $item->question_option_user_id,'notifications' => $item->id])}}" <?php } ?> class="flex flex-col px-4 py-3 border-b hover:bg-gray-100 @if($item->view == 1) bg-white @else bg-gray-200 @endif">
            <p class="text-gray-600 text-sm">
                <span class="font-bold">{{$item->message}}</span>
            </p>
            <div class="text-xs text-blue-600 dark:text-blue-500">{{$item->created_at}}</div>
        </a>
        @endforeach
    </div>
    <a href="{{route('notification.frontend.index')}}" class="block bg-primary text-white text-center font-bold py-2">Xem tất cả</a>
</div>
@endif
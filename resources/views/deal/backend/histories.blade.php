 @if($action == 'update')
 @if(!empty($history))
 <ol class="relative border-l border-gray-200 dark:border-gray-700 space-y-2">
     @foreach($history as $item)
     <li class="ml-4">
         <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-[6px] border border-white dark:border-gray-900 dark:bg-gray-700"></div>
         <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{$item->created_at}}</time>
         <p class="text-sm font-normal text-black dark:text-gray-400">{!!$item->note!!}</p>
     </li>
     @endforeach
 </ol>
 @endif
 @endif
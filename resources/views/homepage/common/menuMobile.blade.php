 <nav class="nav-drill flex-col">
     <ul class="nav-items nav-level-1">
         @if($menu_header)
         @if(count($menu_header->menu_items) > 0)
         @foreach($menu_header->menu_items as $item)

         <li class="nav-item @if($item->children->count() > 0) nav-expand @endif">
             <a class="nav-link  @if($item->children->count() > 0) nav-expand-link @endif" href="{{!empty($item->children->count() > 0)?'javascript:void(0)':url($item->slug)}}">
                 {{$item->title}}
             </a>
             @if($item->children->count() > 0)
             <ul class="nav-items nav-expand-content">
                 @foreach($item->children as $item2)
                 <li class="nav-item">
                     <a class="nav-link" href="{{url($item2->slug)}}">
                         {{$item2->title}}
                     </a>
                 </li>
                 @endforeach
             </ul>
             @endif
         </li>
         @endforeach
         @endif
         @endif
     </ul>
 </nav>
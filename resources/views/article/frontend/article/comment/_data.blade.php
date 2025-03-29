@if(!empty($comment_view['listComment']))
<div class="space-y-10">
    @foreach($comment_view['listComment'] as $item)
    <div class="flex space-x-4">
        <div class="w-[70px]">
            @if(!empty($item->avatar))
            <img src="{{asset($item->avatar)}}" alt="{{$item->fullname}}" style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
            @else
            <img src="https://ui-avatars.com/api/?name={{$item->fullname}}" alt="{{$item->fullname}}" style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
            @endif
        </div>
        <div class="flex-1 space-y-1">
            <div>
                <div class="font-medium">
                    {{$item->fullname}}
                </div>
                <i class="text-sm">{{Carbon\Carbon::parse($item->created_at)->isoFormat('MMM')}}
                    {{Carbon\Carbon::parse($item->created_at)->isoFormat('DD')}},
                    {{Carbon\Carbon::parse($item->created_at)->isoFormat('YYYY')}}
                </i>
            </div>
            <div>{{$item->message}}</div>
            <a href="javascript:void(0)" class="handleReply text-red-600 mt-2" data-id="{{$item->id}}" data-name="{{$item->fullname}}"><i class="fas fa-reply"></i> <?php echo trans('index.Reply') ?></a>
            <div class="reply-comment">
            </div>
        </div>
    </div>
    @if($item->child)
    @foreach($item->child as $kc=>$val)
    <div class="flex space-x-2 ml-[86px]">
        <div class="w-[70px]">
            @if(!empty($val->avatar))
            <img src="{{asset($val->avatar)}}" alt="{{$val->fullname}}" style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
            @else
            <img src="https://ui-avatars.com/api/?name={{$val->fullname}}" alt="{{$val->fullname}}" style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
            @endif
        </div>
        <div class="flex-1 space-y-1">
            <div class="name">
                <div>
                    <label class="font-medium">{{$val->fullname}}</label>
                    @if($val->type == "QTV")
                    <span style="color:red;font-weight:bold">ADMIN</span>
                    @endif
                </div>
                <i class="text-sm">{{Carbon\Carbon::parse($item->created_at)->isoFormat('MMM')}}
                    {{Carbon\Carbon::parse($item->created_at)->isoFormat('DD')}},
                    {{Carbon\Carbon::parse($item->created_at)->isoFormat('YYYY')}}</i>
            </div>
            <div>{{$val->message}}</div>
        </div>
    </div>
    @endforeach
    @endif
    @endforeach
</div>
<div class="dataTables_paginate paging_bootstrap pull-right paginate_cmt">
    {{$comment_view['listComment']->links()}}
</div>
@endif
@if(!empty($data) && count($data) > 0)
<div class="scrollBar">
    @foreach($data as $item)
    <?php
    if ($item->type == 1) {
        $color = "#ea580c";
    } else if ($item->type == 2) {
        $color = "#4f46e5";
    } else if ($item->type == 3) {
        $color = "#059669";
    } else if ($item->type == 4) {
        $color = "#059669";
    } else if ($item->type == 5) {
        $color = "#059669";
    }

    ?>
    <div class="border-b py-2">
        <a class="font-bold js_handleAddAutocomplete" href="javascript:void(0)" data-id="{!!$item->id!!}"><span class="font-bold" style="color: {{$color}}">{{$item->code}}</span><br> {!!$item->title!!}</a>
    </div>
    @endforeach
</div>
<div class="col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
    {{$data->links()}}
</div>
@endif
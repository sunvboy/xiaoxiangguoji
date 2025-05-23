@if(!empty($experienceData))
<?php
$i = 0;
?>
@foreach($experienceData as $exp)

<div class="accordion-item flex space-x-5">
    <div style="width: 2%;">
        <input class="form-check-input checkbox-item-quiz" type="checkbox" value="{{$exp['id']}}">
    </div>
    <div style="width: 10%;" class="flex flex-col space-y-2">
        <input type="text" name="ids[{{$exp['id']}}]" value="{{!empty($exp['order']) ? $exp['order'] : 0}}" data-id="{{$exp['id']}}" class="form-control order-quiz">
        <button type="button" class="btn btn-danger w-full delete-quiz" data-id="{{$exp['id']}}">Xóa</button>
    </div>
    <div class="flex-1">
        <div class="accordion-header mb-2">
            <button class="accordion-button" type="button">
                {!!$exp['title']!!}
            </button>
        </div>
        <div class="space-y-2">
            @if($exp['type'] == 1)
            <?php
            $data = collect($exp['question_options'])->groupBy('order');
            if (!empty($data) && count($data) > 0) {
                foreach ($data as $key => $item) {
                    if (!empty($item) && count($item) > 0) {
                        $i++;
            ?>
                        <div class="preview box p-5">
                            <div>
                                <div class="mt-2">
                                    <?php echo $i ?>. {!! !empty($item) ? $item[0]['description'] : ""!!}
                                </div>
                            </div>
                            @foreach ($item as $k => $v)
                            <?php
                            $order = '';
                            switch ($v['characters']) {
                                case 'A':
                                    $order = "a";
                                    break;
                                case 'B':
                                    $order = "b";
                                    break;
                                case 'C':
                                    $order = "c";
                                    break;
                                case 'D':
                                    $order = "d";
                                    break;
                                default:
                                    break;
                            }
                            $style = '';
                            if ($v['characters'] == $v['isTrue']) {
                                $style = 'background: green;color:white';
                            }
                            ?>
                            <div class="input-group mt-2">
                                <div class="input-group-text" style="<?php echo $style; ?>">
                                    <label class="flex items-center space-x-1">
                                        <span>{{$v['characters']}}</span>
                                    </label>
                                </div>
                                <div class="form-control w-full flex items-center pl-5">
                                    {!!$v['title']!!}
                                </div>
                            </div>
                            @endforeach

                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            @elseif($exp['type'] == 3)
            <?php $i++; ?>
            <div class="">
                <audio id="song{!!$exp['id']!!}" class="w-full max-w-md mx-auto hidden song" controls>
                    <source src="{{asset($exp['file'])}}" type="audio/mpeg">
                </audio>
                <div class="mt-4 flex space-x-2">
                    <button type="button" onclick="PlayAudio(<?php echo $exp['id'] ?>)" class="p-2 rounded-lg hover:bg-slate-800 bg-primary text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                        </svg>
                        <span> Play</span>
                    </button>
                    <button type="button" onclick="PlayPause()" class="p-2 rounded-lg hover:bg-slate-800 bg-primary text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pause</span>
                    </button>
                    <?php /*<button type="button" onclick="document.getElementById('song').volume += 0.1" class="px-2 rounded-lg hover:bg-slate-800 bg-red-600">Vol +</button>
                                           <button type="button" onclick="document.getElementById('song').volume -= 0.1" class="px-2 rounded-lg hover:bg-slate-800 bg-red-600">Vol -</button>*/ ?>
                </div>
            </div>
            @elseif($exp['type'] == 4)
            <div class="space-y-5">
                @if(!empty($exp['question_options']))
                @foreach($exp['question_options'] as $k=>$v)
                <div class="flex justify-between space-x-5">
                    <div class="flex-1">
                        @if($v['description'] == 'title')
                        <h3 class="font-bold">{{$v['title']}}</h3>
                        @else
                        <?php $i++; ?>
                        <div class="flex items-center text-danger font-bold flex-wrap">
                            <?php
                            $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v['title']);
                            ?>
                            <?php echo $i ?>. {!!$str!!}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @elseif($exp['type'] == 5)
            <div class="">
                <?php
                $question_options = collect($exp['question_options']);
                $reads = $question_options->where('characters', null)->all();
                $booleans = $question_options->where('characters', '!=', null)->all();
                $booleans = collect($booleans)->groupBy('order');
                ?>
                <div class="read_list space-y-5">
                    @if(!empty($reads))

                    @foreach($reads as $k=>$v)
                    <div class="flex justify-between space-x-5">
                        <div class="flex-1">
                            @if($v['description'] == 'title')
                            <h3 class="font-bold ">{{$v['title']}}</h3>
                            @elseif($v['description'] == 'input')
                            <?php $i++ ?>
                            <div class="flex items-center text-danger font-bold flex-wrap">
                                <?php
                                $str = str_replace("{INPUT}", "<input type='text' class='flex-1 ml-2 border-0 border-b' disabled>", $v['title']);
                                ?>
                                <?php echo $i ?>. {!!$str!!}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="mt-3 space-y-3">
                    <?php
                    if (!empty($booleans) && count($booleans) > 0) {
                        foreach ($booleans as $key => $item) {
                            if (!empty($item) && count($item) > 0) {
                    ?>
                                <?php $i++ ?>

                                <div class="preview box p-5">
                                    <div>
                                        <div class="mt-2">
                                            <?php echo $i ?>. {!! !empty($item) ? $item[0]['description'] : ""!!}
                                        </div>
                                    </div>
                                    @foreach ($item as $k => $v)
                                    <?php
                                    $order = '';
                                    switch ($v['characters']) {
                                        case 'A':
                                            $order = "a";
                                            break;
                                        case 'B':
                                            $order = "b";
                                            break;
                                        case 'C':
                                            $order = "c";
                                            break;
                                        case 'D':
                                            $order = "d";
                                            break;
                                        default:
                                            break;
                                    }
                                    $style = '';
                                    if ($v['characters'] == $v['isTrue']) {
                                        $style = 'background: green;color:white';
                                    }
                                    ?>
                                    <div class="input-group mt-2">
                                        <div class="input-group-text" style="<?php echo $style; ?>">
                                            <label class="flex items-center space-x-1">
                                                <span>{{$v['characters']}}</span>
                                            </label>
                                        </div>
                                        <div class="form-control w-full flex items-center pl-5">
                                            {!!$v['title']!!}
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@endif
@foreach($data1 as $v)
<tr @if($v->type == 0) style="opacity: 0.5" @endif class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd" id="post-<?php echo $v->id; ?>">
    @can('deals_destroy')
    <td class="p-2">
        <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
    </td>
    @endcan
    <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{$v->id}}
    </th>
    @if(in_array('type',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <?php /*!empty(config('tamphat')['type'][$v->type])?config('tamphat')['type'][$v->type]:$v->type*/ ?>
        <label class="inline-flex items-center cursor-pointer w-[50px]">
            <input <?php echo ($v->type == 1) ? 'checked=""' : ''; ?> type="checkbox" value="" class="sr-only peer publish-ajax" data-module="{{$module}}" data-id="<?php echo $v->id; ?>" data-title="type" id="type-<?php echo $v->id; ?>">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
        </label>
    </td>
    @endif
    @if(in_array('title',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <a href="{{ route('deals.edit',['id'=>$v->id]) }}" class="font-semibold underline">{{$v->title}}</a>
    </td>
    @endif
    @if(in_array('catalogue_id',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->category_products)?$v->category_products->title:''}}
    </td>
    @endif
    @if(in_array('brand_id',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->brand)?$v->brand->title:''}}
    </td>
    @endif

    @if(in_array('tag_id',$permissionCheckedIndex->toArray()))
    <?php
    $tag_id = !empty($v->tag_id) ? json_decode($v->tag_id, TRUE) : [];
    ?>
    <td class="p-2">
        {{collect($tag_id)->join(', ') }}
    </td>
    @endif
    @if(in_array('source',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty(config('tamphat')['source'][$v->source])?config('tamphat')['source'][$v->source]:$v->source}}
    </td>
    @endif
    @if(in_array('status',$permissionCheckedIndex->toArray()))
    <td class="p-2 font-bold" <?php if (!empty(config('tamphat')['status'][$v->status])) { ?> style="color: <?php echo config('tamphat')['status_color'][$v->status] ?>" <?php } ?>>
        {{!empty(config('tamphat')['status'][$v->status])?config('tamphat')['status'][$v->status]:$v->status}}
    </td>
    @endif
    @if(in_array('website',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->website)?collect(json_decode($v->website,TRUE))->join(','):''}}
    </td>
    @endif
    @if(in_array('source_date_start',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <?php $source_date_start = !empty($v->source_date_start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->source_date_start)->format('d/m/Y') : '';
        echo $source_date_start ?>
    </td>
    @endif
    @if(in_array('source_date_end',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <?php $source_date_end = !empty($v->source_date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->source_date_end)->format('d/m/Y') : '';
        echo $source_date_end ?>

    </td>
    @endif
    @if(in_array('diffInMonths',$permissionCheckedIndex->toArray()))
    <td>
        <?php
        if (!empty($source_date_start) && !empty($source_date_end)) {
            $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $source_date_start);
            $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $source_date_end);
            if (!empty($start_date) && !empty($end_date)) {
                $diff_years = $start_date->diffInYears($end_date);
                if (empty($diff_years)) {
                    echo (!empty($start_date->diffInMonths($end_date)) ? $start_date->diffInMonths($end_date) : 0) . ' tháng';
                } else {
                    echo (!empty($diff_years) ? $diff_years : 0) . ' năm';
                }
            }
        }
        ?>
    </td>
    <td>
        <?php
        if (!empty(DateTime::createFromFormat('d/m/Y', $source_date_end))) {
            if (!empty($source_date_end)) {
                $start_date = \Carbon\Carbon::now();
                $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $source_date_end)->startOfDay()->addDay();
                $diffInDays = $end_date->diffInDays($start_date);
            }
        }
        ?>
        <?php
        $date1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->source_date_end)->format('d/m/Y');
        $date2 = Carbon\Carbon::now()->format('d/m/Y');
        $date1C = \Carbon\Carbon::createFromFormat('d/m/Y', $date1);
        $date2C = \Carbon\Carbon::createFromFormat('d/m/Y', $date2);
        $classText = '';
        $classText = !empty($diffInDays <= 7 && $diffInDays > 0) ? 'text-red-600' : 0;
        ?>
        <span class="{{$classText}}">
            <?php
            if ($date1C > $date2C) {
                echo "$diffInDays";
            } elseif ($date1C < $date2C) {
                echo -$diffInDays;
            } else {
                echo 0;
            }
            ?>
        </span>
    </td>
    @endif
    @if(in_array('source_description',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <div class="cursor-pointer source_description" style="width: 100px; -webkit-line-clamp: 2;display: -webkit-box;-webkit-box-orient: vertical;overflow: hidden;position: relative;">
            {!!$v->source_description!!}
        </div>
    </td>
    @endif
    @if(in_array('deal_relationships',$permissionCheckedIndex->toArray()))
    <td class="">
        <div class="cursor-pointer source_products" style="width: 100px; -webkit-line-clamp: 2;display: -webkit-box;-webkit-box-orient: vertical;overflow: hidden;position: relative;"> {!!!empty($v->deal_relationships)? $v->deal_relationships->pluck('title')->join(',<br>'):""!!}
        </div>

    </td>
    @endif
    @if(in_array('tax',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{number_format($v->price_4,'0',',','.')}}
    </td>
    @endif
    @if(in_array('price',$permissionCheckedIndex->toArray()))
    <td class="p-2 font-bold text-red-600">
        {{number_format($v->price_5,'0',',','.')}}
    </td>
    @endif
    @if(in_array('customer_id',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        <a href="{{route('deals.search',['id' => $v->customer_id])}}" class="font-medium underline">{{!empty($v->customer)?$v->customer->name:''}}</a>
    </td>
    @endif
    @if(in_array('date_end',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->date_end)->format('d/m/Y')}}
    </td>
    @endif
    @if(in_array('userid_created',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->user_created)?$v->user_created->name:''}}
    </td>
    @endif
    @if(in_array('userid_updated',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->user_updated->name)?$v->user_updated->name:''}}
    </td>
    @endif
    @if(in_array('company',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->company) ? $v->company : ''}}
    </td>
    @endif
    @if(in_array('free',$permissionCheckedIndex->toArray()))
    <td class="p-2">
        {{!empty($v->free) ? collect(json_decode($v->free, TRUE))->join(',') : ''}}
    </td>
    @endif
    <td class="p-2">
        <div class=" flex space-x-1 ">
            @if($active == 'vps')
            @can('deals_create')
            <a href="{{  route('deals.vps.copy',['id'=>$v->id]) }}" class="text-white flex items-center bg-blue-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                </svg>
            </a>
            @endcan
            @can('deals_edit')
            <a href="{{  route('deals.vps.edit',['id'=>$v->id]) }}" class="text-white flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </a>
            @endcan
            @else
            @can('deals_create')
            <a href="{{ !empty($active == 'website') ? route('deals.website.copy',['id'=>$v->id]) :  route('deals.copy',['id'=>$v->id]) }}" class="text-white flex items-center bg-blue-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                </svg>
            </a>
            @endcan
            @can('deals_edit')
            <a href="{{ !empty($active == 'website') ? route('deals.website.edit',['id'=>$v->id]) : route('deals.edit',['id'=>$v->id]) }}" class="text-white flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </a>
            @endcan

            @endif

            @can('deals_destroy')
            <a href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!" class="ajax-delete text-white flex items-center bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </a>
            @endcan
        </div>
    </td>
</tr>

@endforeach
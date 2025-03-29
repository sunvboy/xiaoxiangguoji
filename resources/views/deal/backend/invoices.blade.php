@if($invoices)
@foreach($invoices as $key=>$item)
<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
    <th class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{$item->id}}
    </th>
    <td class="p-2">
        <label class="inline-flex items-center cursor-pointer w-[50px]">
            <input <?php echo ($item->status == 1) ? 'checked=""' : ''; ?> type="checkbox" value="" class="sr-only peer publish-ajax" data-module="deal_invoices" data-id="<?php echo $item->id; ?>" data-title="status" id="status-<?php echo $item->id; ?>">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
        </label>
    </td>
    <td class="p-2">
        {{$item->title}}
    </td>
    <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{number_format($item->price,'0',',','.')}}
    </td>
    <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{!empty($item->price_tax)?number_format($item->price_tax,'0',',','.'):$item->tax}}
    </td>
    <td class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{number_format($item->total,'0',',','.')}}
    </td>
    <td class="p-2">
        <?php echo !empty($item->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->date_end)->format('d/m/Y') : ''; ?>
    </td>
    <td class="p-2">
        <?php echo !empty($item->source_date_end) ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->source_date_end)->format('d/m/Y') : ''; ?>
    </td>
    <td class="p-2">
        {{!empty($item->user)?$item->user->name:""}}
    </td>
    <td class="p-2">
        <label class="inline-flex items-center cursor-pointer w-[50px]">
            <input <?php echo ($item->status_2 == 1) ? 'checked=""' : ''; ?> type="checkbox" value="" class="sr-only peer publish-ajax" data-module="deal_invoices" data-id="<?php echo $item->id; ?>" data-title="status_2" id="status_2-<?php echo $item->id; ?>">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
        </label>
    </td>
    <td class="p-2 ">
        <div class="flex space-x-1">
            @can('deals_edit')
            <a href="javascript:void(0)" data-id="{{$item->id}}" class="handleUpdateInvoices text-white flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </a>
            @endcan
            @can('deals_destroy')
            <a href="javascript:;" data-id="<?php echo $item->id ?>" data-module="deal_invoices" data-child="0" data-title="Lưu ý: Khi bạn xóa hóa đơn, hóa đơn sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!" class="ajax-delete-invoices text-white flex items-center bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-2.5 py-1.5 text-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </a>
            @endcan
        </div>

    </td>
</tr>
@endforeach
@endif
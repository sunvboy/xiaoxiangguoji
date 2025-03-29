<div class="grid grid-cols-5 gap-1 mt-2" id="boxDealView" style="display: none;">
    @foreach($deal_views as $val)
    <label for="check{{$val->id}}" class="flex items-center space-x-1">
        <input {{!empty($permissionChecked)?($permissionChecked->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealView w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
        <span>{{$val->title}}</span>
    </label>
    @endforeach
</div>
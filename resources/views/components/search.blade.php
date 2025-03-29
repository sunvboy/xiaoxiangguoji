<div class="flex space-x-2 ">
    @if(empty($catalogue))
    <select class="flex-auto form-control ajax-delete-all mr10 w-36" style="height:42px" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
        <option>Hành động</option>
        <option value="">Xóa</option>
    </select>
    @endif
    <form action="" class="flex space-x-2 justify-between flex-1" id="search" style="margin-bottom: 0px;">
        @if(!empty($configIs) && count($configIs) > 0)
        <select class="flex-auto form-control mr10 filter w-36" name="type" style="height:42px">
            <option value="" selected>Chọn hiển thị</option>
            @foreach($configIs as $key=>$value)
            <option value="{{$value->type}}" <?php if (!empty(request()->get('type')) && request()->get('type') == $value->module) { ?>selected<?php } ?>>{{$value->title}}
            </option>
            @endforeach
        </select>
        @endif
        @if(!empty($htmlOption))
        <div class="mr10">
            <?php echo Form::select('catalogueid', $htmlOption, request()->get('catalogueid'), ['class' => ' w-36 form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
        </div>
        @endif
        <input type="search" name="keyword" class="keyword form-control filter" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
        <button class="flex-auto btn btn-primary">
            <i data-lucide="search"></i>
        </button>
    </form>

</div>
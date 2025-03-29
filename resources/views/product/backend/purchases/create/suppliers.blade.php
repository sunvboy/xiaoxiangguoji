<?php
/*
Thông tin nhà cung cấp
*/ ?>
<div class="box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            Thông tin nhà cung cấp
        </h2>
    </div>
    <div class="p-5 grid ">
        <div class="relative">
            <input autocomplete="off" class="form-control js_search_suppliers w-full" placeholder="Tìm kiếm nhà cung cấp theo SĐT, tên, mã nhà cung cấp, ..." type="text">
            <div class="absolute top-10 left-0 w-full border shadow bg-white z-10 hidden" id="loadDataSuppliers" style="display: none;">
                <div class="flex flex-col space-y-3 p-2">
                    @if(count($suppliers) > 0)
                    @foreach($suppliers as $item)
                    <a class="item flex items-center hover:text-danger js_handle_suppliers" href="javascript:void(0)" data-id="{{$item->id}}" data-info="<?php echo base64_encode(json_encode($item)); ?>">
                        <div class="w-10 h-10 rounded-full">
                            <img src="https://ui-avatars.com/api/?name={{$item->title}}" class="rounded-full w-full">
                        </div>
                        <span class="flex ml-2">
                            {{$item->title}} - {{$item->phone}}
                        </span>
                    </a>
                    @endforeach
                    @endif
                </div>
                <div class="paginationSuppliers flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center py-2 border-t ">
                    {{$suppliers->links()}}
                </div>
            </div>
        </div>
        <!-- Thông tin chi tiết nhà cung cấp -->
        <div class="mt-3" id="loadDataInfoSuppliers">
        </div>
        <!-- END-->
    </div>
</div>
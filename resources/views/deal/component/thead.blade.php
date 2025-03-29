<?php $active = !empty($active) ? 'js_sort_' . $active : 'js_sort'; ?>
<thead class="text-xs text-white uppercase bg-primary">
    <tr>
        @can('deals_destroy')
        <th class="p-2 rounded-tl-md">
            <input type="checkbox" id="checkbox-all" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
        </th>
        <th scope="col" class="p-2 ">
            <div class="flex space-x-1 items-center relative">
                <span>ID</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="id|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="id|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @else
        <th scope="col" class="p-2 rounded-tl-md">

            <div class="flex space-x-1 items-center relative w-[90px]">
                <span>ID</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="id|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="id|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endcan
        @if(in_array('type',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[90px]">
                <span>Trạng thái</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="type|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="type|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('title',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[200px]">
                <span>Deal</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="title|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="title|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif

        @if(in_array('catalogue_id',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[150px]">
                <span>Danh mục sản phẩm</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="catalogue_id|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="catalogue_id|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif

        @if(in_array('brand_id',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[150px]">
                <span>Phân loại</span>
            </div>
        </th>
        @endif
        @if($active != 'website')
        @if(in_array('tag_id',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[150px]">
                <span>Duy trì</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="tag_id|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="tag_id|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @endif
        @if(in_array('source',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[100px]">
                <span>Nguồn</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="source|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="source|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('status',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">

            <div class="flex space-x-1 items-center relative w-[150px]">
                <span>Giai đoạn</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="status|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="status|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('website',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[80px]">
                <span>Tên miền</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="website|asc"><i class=" fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="website|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('source_date_start',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Ngày Bắt đầu HĐ</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="source_date_start|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="source_date_start|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('source_date_end',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Ngày kết thúc HĐ</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="source_date_end|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="source_date_end|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('diffInMonths',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Thời gian</span>
            </div>
        </th>
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Ngày hết hạn</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="source_date_end|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="source_date_end|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('source_description',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[200px]">
                <span>Thông tin chuyển khoản</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="source_description|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="source_description|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('deal_relationships',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[200px]">
                <span>Sản phẩm</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="products|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="products|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('tax',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[60px]">
                <span>Thuế</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="tax|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="tax|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('price',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[150px]">
                <span>Tổng số tiền (VNĐ)</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="price|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="price|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('customer_id',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[200px]">
                <span>Công ty</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="customer_id|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="customer_id|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('date_end',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Ngày thanh toán</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="date_end|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="date_end|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        @if(in_array('userid_created',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="w-[100px]">
                Người tạo
            </div>
        </th>
        @endif
        @if(in_array('userid_updated',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="w-[100px]">
                Người sửa
            </div>
        </th>
        @endif

        @if(in_array('company',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            CÔNG TY TÂM PHÁT
        </th>
        @endif
        @if(in_array('free',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            FREE
        </th>
        @endif
        @if(in_array('created_at',$permissionCheckedIndex->toArray()))
        <th scope="col" class="p-2">
            <div class="flex space-x-1 items-center relative w-[140px]">
                <span>Ngày tạo</span>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -top-1 w-[10px]" data-value="created_at|asc"><i class="fa-solid fa-sort-up"></i></a>
                <a href="javascript:void(0)" class="text-white absolute <?php echo $active ?> right-0 -bottom-1 w-[10px]" data-value="created_at|desc"><i class="fa-solid fa-sort-down"></i></a>
            </div>
        </th>
        @endif
        <th scope="col" class="p-2 rounded-tr-md">
            <div class="flex justify-end">
                Thao tác
            </div>
        </th>
    </tr>
</thead>
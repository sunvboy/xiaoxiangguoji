<div id="main" class="sitemap main-category-product pt-0 md:pt-10 main-child">
    <!-- start: box 2 -->
    <section class="">
        <div class="container mx-auto px-3">
            <div class="breadcrumb  py-[10px] border-b border-brown mb-[20px]">
                <div class="flex flex-wrap justify-between">
                    <div class="w-full md:w-1/2">
                        <div class="bres mt-[10px]">
                            <ul class="flex flex-wrap">
                                <li><a href="<?php echo url('') ?>">Trang chủ</a></li>
                                <li><span class="text-gray-500 mx-2">/</span></li>
                                <li>Kết quả tìm kiếm: {{request()->get('keyword')}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="sort-1 flex flex-wrap">
                            @if(!$attribute_catalogue->isEmpty())
                            @foreach($attribute_catalogue as $key=>$val)
                            @if(count($val->listAttr) > 0)
                            <select name="attr[]" class="attr filter" data-keyword="<?php echo $val->slug ?>">
                                <option value="">TÌm theo <?php echo $val->title ?></option>
                                @foreach($val->listAttr as $k=>$v)
                                <option value="{{$v->id}}">{{$v->title}}</option>
                                @endforeach
                            </select>
                            @endif
                            @endforeach
                            <input id="choose_attr" class="hidden filter" name="attr">

                            @endif
                            <select name="sortBy" class="SortBy">
                                <option value="">Sort</option>
                                <option value="title|asc" <?php echo !empty(request()->get('sort') == 'title|asc') ? 'selected' : '' ?>>Theo bảng
                                    chữ cái từ A-Z</option>
                                <option value="title|desc" <?php echo !empty(request()->get('sort') == 'title|desc') ? 'selected' : '' ?>>Theo bảng
                                    chữ cái từ Z-A</option>
                                <option value="price|asc" <?php echo !empty(request()->get('sort') == 'price|asc') ? 'selected' : '' ?>>Giá từ thấp
                                    tới cao</option>
                                <option value="price|desc" <?php echo !empty(request()->get('sort') == 'price|desc') ? 'selected' : '' ?>>Giá từ cao
                                    tới thấp</option>
                                <option value="id|desc" <?php echo !empty(request()->get('sort') == 'id|desc') ? 'selected' : '' ?>>Mới nhất
                                </option>
                                <option value="id|asc" <?php echo !empty(request()->get('sort') == 'id|asc') ? 'selected' : '' ?>>Cũ nhất
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-title wow fadeInUp">
                <div class=""></div>
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">Kết quả tìm kiếm: {{request()->get('keyword')}}</h2>
            </div>
            <div id="data_product">
                @if($data)
                <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-5 md:mt-7 wow fadeInUp">
                    <?php foreach ($data as $k => $item) { ?>
                        <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                            <?php echo htmlItemProduct($k, $item); ?>
                        </div>

                    <?php } ?>
                </div>
                @endif
                <div class="mt-5 flex justify-center">
                    {{$data->links()}}
                </div>
            </div>

        </div>
    </section>
    <!-- end: box 2 -->
</div>
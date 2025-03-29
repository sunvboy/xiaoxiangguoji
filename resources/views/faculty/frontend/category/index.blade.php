@extends('homepage.layout.home')
@section('content')
<div id="main" class="sitemap main-course-category pb-[20px] md:pb-[70px]">
    <section class="banner-child py-[50px] md:py-[100px] relative" style="background: url('{{!empty($detail->banner) ? (!empty(File::exists(base_path($detail->banner)))?asset($detail->banner):asset($fcSystem['banner_1'])) : asset($fcSystem['banner_1'])}}')">
        <h1 class="text-f25 md:text-f35 font-bold text-white relative z-10 text-center">
            {{$detail->title}}
        </h1>
        <div class="breadcrumb py-[10px] relative z-10 mt-[5px]">
            <div class="container mx-auto px-3">
                <ul class="flex flex-wrap justify-center">
                    <li class=" text-white active"><a href="{{url('/')}}" class=" text-color_second">{{$fcSystem['title_12']}}</a></li>
                    @foreach($breadcrumb as $k=>$v)
                    <li><span class="text-gray-500 mx-2">/</span></li>
                    <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <div class="content-course-category pt-[20px] md:pt-[60px]">
        <div class="container mx-auto px-3">

            <div class="flex flex-wrap justify-start mx-[-15px]">

                <div class="w-full md:w-1/4 px-[15px] order-2 md:order-1">
                    <aside class="sidebar-course mt-[30px] md:mt-0">
                        @include('homepage.common.courseCategory',['class' => 'item-aside mb-[15px] md:mb-[25px] border border-gray-100 rounded-[10px] p-[15px]'])
                        @if(!empty($attributes) && count($attributes) > 0)
                        @foreach ($attributes as $key=>$item)
                        @if(count($item) > 0)
                        <div class="item-aside mb-[15px] md:mb-[25px] border border-gray-100 rounded-[10px] p-[15px]">
                            <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
                                {{$key}}
                            </h3>
                            <ul>
                                @foreach ($item as $val)
                                <li class="mb-[10px] transition-all cursor-pointer">
                                    <label for="attr-{{$val['id']}}" class="hover:text-color_primary transition-all js_attr cursor-pointer">
                                        <input id="attr-{{$val['id']}}" type="checkbox" value="{{$val['id']}}" type="checkbox" data-title="{{$val['title']}}" data-keyword="{{$val['keyword']}}" name="attr[]" class="float-left mr-[10px] mt-[2px] js_input_attr filter">{{$val['title']}}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endforeach
                        @endif
                        <input id="choose_attr" class="w-full hidden" type="text" name="attr">
                    </aside>
                </div>
                <div class="w-full md:w-3/4 px-[15px] order-1 md:order-2" id="scrollTop">
                    @if(!empty($data))
                    <div class="content-course">
                        <h2 class="title-primary-1 bold-1 uppercase text-green text-f20 md:text-f30 font-bold  leading-[30px] md:leading-[40px] relative pb-[20px]">
                            KHÓA HỌC
                        </h2>
                        <div class="flex flex-wrap justify-start mx-[-10px]" id="js_data_filter">
                            @foreach($data as $item)
                            <?php echo htmlItemCourse($item, ''); ?>
                            @endforeach
                        </div>
                        <div class="pagenavi wow fadeInUp mt-[20px]" id="js_pagination_filter">
                            <?php echo $data->links() ?>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script>
    $(document).on('click', '.js_attr', function() {
        if ($(this).find('input.js_input_attr:checked').length) {
            $(this).addClass('checked');
        } else {
            $(this).removeClass('checked');
        }
        loadFilterChecked();
    })

    function loadFilterChecked() {
        let attr = '';
        let brand = '';
        $('#js_selected_attr').html('');
        $('input[name="attr[]"]:checked').each(function(key, index) {
            let id = $(this).val();
            let keyword = $(this).attr('data-keyword');
            let title = $(this).attr('data-title');
            attr = attr + keyword + ';' + id + ';';
        });
        $('#choose_attr').val(attr);
    }
    $(document).on('change', '.filter', function() {
        let page = $('.pagination .active span').text();
        time = setTimeout(function() {
            get_list_object(page);
        }, 500);
        return false;
    });
    $(document).on('click', '#js_pagination_filter .pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        get_list_object(page);
    });

    function get_list_object(page = 1) {
        /*var checked_brand = [];
        $('input[name="brands[]"]:checked').each(function() {
            checked_brand.push($(this).val());
        }); */
        // var brandChecked = checked_brand.join(',');

        let attr = $('input[name="attr"]').val();
        let ajaxUrl = '<?php echo route('courses.filter') ?>';
        let catalogueid = <?php echo !empty($detail) ? $detail->id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                attr: attr,
                page: page ? page : 1,
                catalogueid: catalogueid
            },
            success: function(data) {
                $('#js_data_filter').html(data.html);
                $('#js_pagination_filter').html(data.paginate);
                $('html, body').animate({
                    scrollTop: $("#scrollTop").offset().top
                }, 300);
            }
        });
    }
</script>
@endpush
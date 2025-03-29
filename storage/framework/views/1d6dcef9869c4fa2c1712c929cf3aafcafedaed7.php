<?php $__env->startSection('content'); ?>
<div id="main" class="sitemap main-course-category pb-[20px] md:pb-[70px]">
    <section class="banner-child py-[50px] md:py-[100px] relative" style="background: url('<?php echo e(!empty($detail->banner) ? (!empty(File::exists(base_path($detail->banner)))?asset($detail->banner):asset($fcSystem['banner_1'])) : asset($fcSystem['banner_1'])); ?>')">
        <h1 class="text-f25 md:text-f35 font-bold text-white relative z-10 text-center">
            <?php echo e($detail->title); ?>

        </h1>
        <div class="breadcrumb py-[10px] relative z-10 mt-[5px]">
            <div class="container mx-auto px-3">
                <ul class="flex flex-wrap justify-center">
                    <li class=" text-white active"><a href="<?php echo e(url('/')); ?>" class=" text-color_second"><?php echo e($fcSystem['title_12']); ?></a></li>
                    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><span class="text-gray-500 mx-2">/</span></li>
                    <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-gray-600"><?php echo e($v->title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </section>
    <div class="content-course-category pt-[20px] md:pt-[60px]">
        <div class="container mx-auto px-3">

            <div class="flex flex-wrap justify-start mx-[-15px]">

                <div class="w-full md:w-1/4 px-[15px] order-2 md:order-1">
                    <aside class="sidebar-course mt-[30px] md:mt-0">
                        <?php echo $__env->make('homepage.common.courseCategory',['class' => 'item-aside mb-[15px] md:mb-[25px] border border-gray-100 rounded-[10px] p-[15px]'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if(!empty($attributes) && count($attributes) > 0): ?>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($item) > 0): ?>
                        <div class="item-aside mb-[15px] md:mb-[25px] border border-gray-100 rounded-[10px] p-[15px]">
                            <h3 class="title-aside uppercase text-f18 bold-1 relative after:content[''] after:absolute after:left-0 after:bottom-0 after:w-[40px] after:h-[2px] after:bg-color_second pb-[15px] mb-[20px]">
                                <?php echo e($key); ?>

                            </h3>
                            <ul>
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mb-[10px] transition-all cursor-pointer">
                                    <label for="attr-<?php echo e($val['id']); ?>" class="hover:text-color_primary transition-all js_attr cursor-pointer">
                                        <input id="attr-<?php echo e($val['id']); ?>" type="checkbox" value="<?php echo e($val['id']); ?>" type="checkbox" data-title="<?php echo e($val['title']); ?>" data-keyword="<?php echo e($val['keyword']); ?>" name="attr[]" class="float-left mr-[10px] mt-[2px] js_input_attr filter"><?php echo e($val['title']); ?>

                                    </label>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <input id="choose_attr" class="w-full hidden" type="text" name="attr">
                    </aside>
                </div>
                <div class="w-full md:w-3/4 px-[15px] order-1 md:order-2" id="scrollTop">
                    <?php if(!empty($data)): ?>
                    <div class="content-course">
                        <h2 class="title-primary-1 bold-1 uppercase text-green text-f20 md:text-f30 font-bold  leading-[30px] md:leading-[40px] relative pb-[20px]">
                            KHÓA HỌC
                        </h2>
                        <div class="flex flex-wrap justify-start mx-[-10px]" id="js_data_filter">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo htmlItemCourse($item, ''); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="pagenavi wow fadeInUp mt-[20px]" id="js_pagination_filter">
                            <?php echo $data->links() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/course/frontend/category/index.blade.php ENDPATH**/ ?>
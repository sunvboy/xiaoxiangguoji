
<?php $__env->startSection('content'); ?>
<?php echo htmlBreadcrumb(trans('index.AccountInformation')); ?>

<main class="pb-20">
    <div class="container px-4 mx-auto">
        <div class="mt-4 flex flex-col md:flex-row items-start md:space-x-4">
            <?php echo $__env->make('customer/frontend/auth/common/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="flex-1 w-full md:w-auto order-1 md:order-2">
                <div class="shadowC rounded-xl">
                    <div class="md:px-6 bg-white ">
                        <div class="content-right mt-[20px] md:mt-0">
                            <div class="filter-search">
                                <form method="GET" action="" class="flex flex-wrap mx-[-10px]">
                                    <div class="w-full md:w-2/5 px-[10px]">
                                        <input autocomplete="off" type="text" name="date_start" value="<?php echo e(request()->get('date_start')); ?>" placeholder="Ngày tạo" class="outline-none focus:outline-none hover:outline-none px-4 w-full border border-gray-200 h-[40px] mb-[10px] md:mb-0">
                                    </div>
                                    <div class="w-full md:w-2/5 px-[10px]">
                                        <input type="text" value="<?php echo e(request()->get('keyword')); ?>" name="keyword" class="outline-none focus:outline-none hover:outline-none w-full border border-gray-200 h-[40px] mb-[10px] md:mb-0 px-4" placeholder="Nhập từ khóa tìm kiếm">
                                    </div>
                                    <div class="w-full md:w-1/5 px-[10px]">
                                        <input type="submit" class="cursor-pointer w-full border border-color_primary h-[40px] bold-1 bg-color_primary text-white uppercase hover:bg-white hover:text-color_primary transition-all" value="TÌm kiếm">
                                    </div>
                                </form>
                            </div>
                            <div class="table-content mt-[30px]">
                                <table class="w-full">
                                    <tbody>
                                        <tr class="bg-color_primary">
                                            <td class="text-white">STT</td>
                                            <td class="text-white">Cấp bậc</td>
                                            <td class="text-white">Tên lớp</td>
                                            <td class="text-white">Tên bài kiểm tra</td>
                                            <td class="text-white">Bài luyện tập</td>
                                            <td class="text-white">Hoàn thành</td>
                                            <td class="text-white">Chấm điểm</td>
                                            <td class="text-white">Điểm</td>
                                            <td class="text-white text-center">#</td>
                                        </tr>
                                        <?php if(!empty($data)): ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $category = json_decode($item->customer_category, TRUE);
                                        $customer_levels = json_decode($item->customer_levels, TRUE);
                                        if (!empty($customer_levels)) {
                                            $customer_levels = collect($customer_levels);
                                        }
                                        if (!empty($category)) {
                                            $customer_categories = \App\Models\CustomerCategory::whereIn('id', $category)->get()->pluck('title');
                                        }
                                        ?>
                                        <tr>
                                            <td class=""><?php echo e($data->firstItem()+$loop->index); ?></td>
                                            <td>
                                                <?php if(!empty($customer_levels)): ?>
                                                <?php echo e($customer_levels->join(', ')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($customer_categories)): ?>
                                                <?php echo e($customer_categories->join(', ')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($item->title); ?>

                                            </td>
                                            <td class="">
                                                <a href="<?php echo e(route('quizzes.frontend.quiz',['slug' => $item->slug])); ?>" class="inline-block bg-color_primary text-white px-[20px] py-[5px] rounded-[5px]">Kiểm tra</a>
                                            </td>

                                            <td class="text-color_primary text-f20">
                                                <?php if (!empty($item->question_option_users)) { ?>
                                                    <i class="fa-solid fa-circle-check"></i>
                                                <?php } ?>
                                            </td>
                                            <td class="text-color_primary text-f20">
                                                <?php if (!empty($item->question_option_users) && !empty($item->question_option_users->status == 'success')) { ?>
                                                    <i class="fa-solid fa-circle-check"></i>
                                                <?php } ?>
                                            </td>
                                            <td class="text-color_primary text-f20">
                                                <?php if (!empty($item->question_option_users)) { ?>
                                                    <?php echo e(!empty($item->question_option_users->score_total)?$item->question_option_users->score_total:''); ?>

                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="flex items-center justify-center">
                                                    <?php if (!empty($item->question_option_users)) { ?>
                                                        <a href="<?php echo e(route('quizzes.frontend.quizSuccess',['slug' => $item->slug,'id'=>$item->question_option_users->id])); ?>" class="inline-block px-[20px] py-[5px] rounded-[5px]">
                                                            <i class="fa-solid fa-eye mr-[5px]"></i> Xem
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="pagenavi wow fadeInUp mt-[20px]" style="visibility: visible; animation-name: fadeInUp;">
                                    <?php echo e($data->links()); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript">
    $(function() {

        $('input[name="date_start"]').datetimepicker({

            format: 'Y-m-d',

        });


    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/frontend/quiz/index.blade.php ENDPATH**/ ?>
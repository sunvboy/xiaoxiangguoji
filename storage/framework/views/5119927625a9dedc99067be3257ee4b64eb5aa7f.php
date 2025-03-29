<?php $dropdown = getFunctions(); ?>
<div id="menu-items">

    <div id="faq-accordion-2" class="accordion accordion-boxed">
        <?php
        if (in_array('products', $dropdown)) {
            $category_products = \App\Models\CategoryProduct::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC')->get();
            $products = \App\Models\Product::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('articles', $dropdown)) {
            $category_articles = \App\Models\CategoryArticle::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC')->get();
            $articles = \App\Models\Article::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('media', $dropdown)) {
            $category_media = \App\Models\CategoryMedia::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC')->get();
            $media = \App\Models\Media::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('faqs', $dropdown)) {
            $faqs = \App\Models\FaqCategory::get();
        }
        // if (in_array('courses', $dropdown)) {
        //     $course_categories = \App\Models\CourseCategory::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC')->get();
        //     $courses = \App\Models\Course::where('alanguage', config('app.locale'))->get();
        // }

        $array = array(
            'category_products' => 'Danh mục sản phẩm',
            'products' => 'Sản phẩm',
            'category_articles' => 'Danh mục bài viết',
            'articles' => 'Bài viết',
            'category_media' => 'Danh mục media',
            'media' => 'Hình ảnh - video',
            'faqs' => 'Hỏi đáp',
            // 'course_categories' => 'Danh mục khóa học',
            // 'courses' => 'Khóa học',

        )
        ?>
        <?php $i = 0; ?>
        <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $i++; ?>
        <!-- Start: module -->
        <?php if(!empty($$key) && count($$key) > 0): ?>
        <div class="accordion-item bg-white" style="padding: 10px 10px 11px 14px;">
            <div id="faq-accordion-content-<?php echo $i ?>" class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-<?php echo $i ?>" aria-expanded="false" aria-controls="faq-accordion-collapse-<?php echo $i ?>"><?php echo e($value); ?></button>
            </div>
            <div id="faq-accordion-collapse-<?php echo $i ?>" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-<?php echo $i ?>" data-tw-parent="#faq-accordion-2">
                <div class="item-list-body" id="<?php echo $key ?>_box">
                    <?php $__currentLoopData = $$key; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p>
                        <input type="checkbox" class="<?php echo $key ?>" value="<?php echo e($v->id); ?>">
                        <?php echo e(str_repeat('|----', (($v->level > 0) ? ($v->level - 1) : 0)) . $v->title); ?>

                    </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('menus_create')): ?>
                <div class="flex mt-3">
                    <label class="btn btn-sm btn-default mr-2">
                        <input type="checkbox" name="clickAllMenu" class="hidden">&nbsp;<span>Chọn toàn bộ</span>
                    </label>
                    <button type="button" class="btn btn-sm btn-primary add-menu-item" data-module="<?php echo $key ?>">Thêm vào menu</button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- end: module -->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="accordion-item bg-white" style="padding: 10px 10px 11px 14px;">
            <div id="faq-accordion-content-5" class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="false" aria-controls="faq-accordion-collapse-5">Liên kết tự tạo
                </button>
            </div>
            <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                <div class="alert alert-danger p-2 mb-3" style="display: none;"></div>
                <div class="">
                    <div>
                        <label>Tiêu đề</label>
                        <input type="text" id="linktext" class="form-control" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label>URL</label>
                        <input type="url" id="url" class="form-control" placeholder="https://">
                    </div>
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('menus_create')): ?>
                <div class="mt-3">
                    <button type="button" class="pull-right btn btn-primary btn-sm" id="add-custom-link">Thêm vào
                        menu</button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/menu/backend/module.blade.php ENDPATH**/ ?>
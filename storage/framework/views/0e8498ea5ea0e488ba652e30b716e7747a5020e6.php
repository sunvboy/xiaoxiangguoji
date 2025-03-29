<?php
$faqs = \App\Models\Faq::limit(5)->orderBy('order', 'asc')->orderby('id', 'desc')->get();
$isasideCategoryArticle =
    \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
    ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'isaside' => 1])
    ->with(['posts' => function ($query) {
        $query->limit(5)->get();
    }])
    ->first();
?>
<aside class="aside-right">
    <?php if(!empty($faqs)): ?>
    <div class="item-sb">
        <h3 class="title-3">CÂU HỎI MỚI NHẤT</h3>
        <div class="nav-item-sb">
            <ul>
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('pageF.faqs.id',['id' => $item->id])); ?>"><span><?php echo e($key+1); ?></span><?php echo e($item->title); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($isasideCategoryArticle)): ?>
    <?php if(!empty($isasideCategoryArticle->posts)): ?>
    <div class="item-sb">
        <h3 class="title-3" style="text-transform: uppercase;"><?php echo e($isasideCategoryArticle->title); ?> MỚI</h3>
        <div class="nav-item-sb">
            <?php $__currentLoopData = $isasideCategoryArticle->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item-3">
                <div class="img hover-zoom">
                    <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>">
                        <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>">
                    </a>
                </div>
                <div class="nav-img">
                    <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                    <p class="desc"><?php echo strip_tags($item->description); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php echo $__env->make('homepage.common.subscribers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</aside><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/article/frontend/aside.blade.php ENDPATH**/ ?>
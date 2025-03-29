 <?php

    $recently_viewed = Session::get('products.recently_viewed');



    if (!empty($recently_viewed)) {

        $recentlyProduct = \App\Models\Product::select('products.id', 'products.title', 'products.image_json', 'products.image', 'products.slug', 'products.price', 'products.price_sale', 'products.price_contact')

            ->where(['products.alanguage' => config('app.locale'), 'products.publish' => 0])

            ->whereIn('products.id', $recently_viewed)

            ->orderBy('products.order', 'asc')

            ->orderBy('products.id', 'desc')

            ->with('getTags')

            ->get();

    }



    ?>

 <?php if(!empty($recentlyProduct)): ?>

 <section class="ps-section--featured viewed-products">

     <div class="section-title-2">

         <h2 class=" ps-section__title title title split-in-fade">Sản phẩm vừa xem</h2>

     </div>

     <div class="ps-section__content">

         <div class="slider-product-only owl-carousel">

             <?php $__currentLoopData = $recentlyProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

             <?php echo htmlItemProduct2($key, $item) ?>

             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

         </div>

     </div>

 </section>

 <?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/common/recently.blade.php ENDPATH**/ ?>
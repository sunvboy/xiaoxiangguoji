  <?php

    use App\Components\Polylang;

    $Polylang = new Polylang();
    $polylang = collect($Polylang->get($module, $detail->id));
    ?>
  <div class="box p-5 pt-3 <?php echo e(!empty(count(config('language')) < 2) ? 'hidden' : ''); ?>">
      <div>
          <label class="form-label text-base font-semibold">Languages</label>
      </div>
      <div>
          <p><strong>Select Language</strong></p>
          <div class="flex items-center mt-2">
              <img src="<?php echo e(asset(config('language')[$detail->alanguage]['image'])); ?>" class="w-9" alt="language icon">
              <span class="ml-2"><?php echo e(config('language')[$detail->alanguage]['title']); ?></span>
          </div>
      </div>
      <div class="mt-3">
          <input type="text" name="language[<?php echo e(config('app.locale')); ?>]" value="<?php echo e($detail->id); ?>" class="hidden">
          <p><strong>Translations</strong></p>
          <?php $__currentLoopData = config('language'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($key != config('app.locale')): ?>
          <?php if(!empty($polylang[$key])): ?>
          <?php
            $product  = $Polylang->module($module, $polylang[$key]);
            ?>
          <?php endif; ?>
          <div class="flex items-center mt-2">
              <div class="w-9">
                  <img src="<?php echo e(asset($item['image'])); ?>" alt="<?php echo e($item['title']); ?> icon">
                  <input type="text" name="language[<?php echo e($key); ?>]" class="hidden" value="<?php echo e(!empty($polylang[$key])?$polylang[$key]:''); ?>">
              </div>
              <div class="flex-1 ml-2 flex items-center relative box-<?php echo e($key); ?>">
                  <div class="hidden">
                      <a href="<?php echo e(route('products.create')); ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                          </svg>
                      </a>
                  </div>
                  <input class="form-control w-full js_languageSearch" type="text" value="<?php echo e(!empty($product->title)?$product->title:''); ?>" data-language="<?php echo e($key); ?>" data-module="<?php echo e($module); ?>">
                  <ul class="absolute w-full top-full left-0 shadow-sm p-2 bg-white space-y-1 ulDropdown ulDropdown-<?php echo e($key); ?> hidden" style="top:100%;z-index: 99999;">
                  </ul>
              </div>
          </div>
          <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  </div><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/polylang/edit.blade.php ENDPATH**/ ?>
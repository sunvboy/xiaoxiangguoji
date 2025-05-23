<?php $__env->startSection('content'); ?>
<?php
$listAlbums = json_decode($detail->image_json, true);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
if (count($detail->product_versions) > 0) {
    $type = 'variable';
} else {
    $type = 'simple';
}
$version = json_decode(base64_decode($detail->version_json), true);
$attribute_tmp = [];
$attributesID =  [];
if (!empty($version) && !empty($version[2])) {
    foreach ($version[2] as $item) {
        foreach ($item as $val) {
            $attributesID[] = $val;
        }
    }
    if (!empty($attributesID)) {
        $attribute_tmp = \App\Models\Attribute::whereIn('id', $attributesID)->select('id', 'title', 'catalogueid')->with('catalogue')->get();
    }
}
$attributes = [];
if (!empty($attribute_tmp)) {
    foreach ($attribute_tmp as $item) {
        $attributes[] = array(
            'id' => $item->id,
            'title' => $item->title,
            'titleC' => $item->catalogue->title,
        );
    }
}
$attributes = collect($attributes)->groupBy('titleC')->all();
?>
<?php if ($type == 'simple') { ?>
    <?php
    $hiddenAddToCart = 0;
    $quantityStock = '';
    $simpleStock = $detail->product_stocks->sum('value');
    if ($detail->inventory == 1) {
        if ($detail->inventoryPolicy == 0) {
            if ($simpleStock == 0) {
                $hiddenAddToCart = 1;
                $product_stock_title =  '<span class="product_stock">' . trans('index.OutOfStock') . '</span>';
            } else {
                $quantityStock = $simpleStock;
                $product_stock_title = '<span class="product_stock">' . $simpleStock . '</span> ' . trans('index.InOfStock');
            }
        } else {
            $product_stock_title = '<span class="product_stock"></span> ' . trans('index.InOfStock');
        }
    } else {
        $product_stock_title = '<span class="product_stock"></span> ' . trans('index.InOfStock');
    }
    ?>
<?php } ?>
<?php



$wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
$i_class = 'fa-regular';
if (!empty($wishlist)) {
    if (in_array($detail->id, $wishlist)) {
        $i_class = 'fa-solid';
    }
}

$descriptions = !empty($fields) ? (!empty($fields['config_colums_json_description']) ? json_decode($fields['config_colums_json_description'], TRUE) : []) : [];
$faqs = !empty($fields) ? (!empty($fields['config_colums_json_faqs']) ? json_decode($fields['config_colums_json_faqs'], TRUE) : []) : [];

?>
<input type="hidden" value="<?php echo $detail->id ?>" id="detailProductID">
<div class="ps-page--product ps-page--product1 page-detail-product bg-gray pb-120">
    <div class="container">
        <?php if(!$breadcrumb->isEmpty()): ?>
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="ps-breadcrumb__item active" aria-current="page"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>
        <div class="ps-page__content">
            <div class="ps-product--detail">
                <div class="top-product-detail bg-white">
                    <div class="row">
                        <div class="col-12 col-xl-5">

                            <?php if(!empty($listAlbums)): ?>
                            <div class="div-img ">
                                <div class="slider slider-content">
                                    <div class="item">
                                        <img src="<?php echo e(asset($detail->image)); ?>" alt="<?php echo e($detail->title); ?>" class="img-large">
                                    </div>
                                    <?php $__currentLoopData = $listAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item">
                                        <img src="<?php echo e(asset($item)); ?>" alt="<?php echo e($detail->title); ?>" class="img-large">
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="slider slider-thumb">
                                    <div class="col">
                                        <div class="item">
                                            <img src="<?php echo e(asset($detail->image)); ?>" alt="<?php echo e($detail->title); ?>" class="img-small">
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $listAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col">
                                        <div class="item">
                                            <img src="<?php echo e(asset($item)); ?>" alt="<?php echo e($detail->title); ?>" class="img-small">
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                        <div class="col-12 col-xl-7">
                            <div class="ps-product__info">
                                <?php if(!empty($brand)): ?>
                                <div class="ps-product__branch">Thương hiệu: <a href="#"><?php echo e($brand->title); ?></a></div>
                                <?php endif; ?>
                                <h2 class="ps-product__title"><?php echo e($detail->title); ?></h2>

                                <div class="ps-product__meta" style="display: flex;align-items: center;">
                                    <span class="ps-product__price sale"><?php echo e($price['price_final']); ?></span>
                                    <del><?php echo e($price['price_old']); ?></del>
                                    <?php if(!empty($detail->unit)): ?>
                                    <div style="margin-left: 5px;">/ <?php echo e($detail->unit); ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php /*@if(!empty($descriptions))
                                <div class="ps-product__desc">
                                    <ul class="ps-product__list">
                                        @foreach($descriptions['title'] as $key=>$item)
                                        @if(!empty($descriptions['content'][$key]))
                                        <li>
                                            <span class="span-1">{{$item}}</span>
                                            <span class="span-2">{{!empty($descriptions['content'])?$descriptions['content'][$key]:''}}</span>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif*/ ?>
                                <div class="ps-product__desc">
                                    <ul class="ps-product__list">
                                        <li>
                                            <span class="span-1">Mã hàng</span>
                                            <span class="span-2"><?php echo e($detail->code); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Số đăng ký</span>
                                            <span class="span-2"><?php echo e($detail->so_dang_ky); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Hoạt chất</span>
                                            <span class="span-2"><?php echo e($detail->hoat_chat); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Hàm lượng</span>
                                            <span class="span-2"><?php echo e($detail->ham_luong); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Hãng sản xuất</span>
                                            <span class="span-2"><?php echo e(!empty($detail->brand)?$detail->brand->title:''); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Nước sản xuất</span>
                                            <span class="span-2"><?php echo e($detail->nuoc_san_xuat); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Quy cách đóng gói</span>
                                            <span class="span-2"><?php echo e($detail->quy_cach_dong_goi); ?></span>
                                        </li>
                                        <li>
                                            <span class="span-1">Đường dùng</span>
                                            <span class="span-2"><?php echo e($detail->duong_dung); ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="ps-product__actions-1">
                                    <div class="ps-product__quantity">
                                        <div class="def-number-input number-input safari_only">
                                            <button class="minus card-dec"><i class="icon-minus"></i></button>
                                            <input class="quantity tp_cardQuantity" min="0" name="quantity" value="1" type="number" />
                                            <button class="plus card-inc"><i class="icon-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="ps-product__cart" style="margin-right: 15px;">
                                        <a class="ps-btn ps-btn--warning tp_addToCart" data-quantity="1" data-id="<?php echo e($detail->id); ?>" data-title="<?php echo e($detail->title); ?>" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="0" data-src="" data-type="<?php echo e($type); ?>">Thêm vào giỏ</a>
                                    </div>
                                    <div class="ps-product__cart">
                                        <a class="ps-btn ps-btn--warning tp_addToCart" data-quantity="1" data-id="<?php echo e($detail->id); ?>" data-title="<?php echo e($detail->title); ?>" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="1" data-src="" data-type="<?php echo e($type); ?>">Đặt hàng</a>
                                    </div>
                                </div>
                                <?php if($policyProduct): ?>
                                <?php if($policyProduct->slides): ?>
                                <div class=" ps-footer--top">
                                    <div class="row">
                                        <?php $__currentLoopData = $policyProduct->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-4  col-12">
                                            <div class="item">
                                                <div class="icon">
                                                    <img src="<?php echo e(asset($slide->src)); ?>" alt="<?php echo e($slide->title); ?>">
                                                </div>
                                                <div class="nav-icon">
                                                    <span class="span-1"><?php echo e($slide->title); ?></span>
                                                    <span class="span-2"><?php echo e($slide->description); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <?php endif; ?>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="ps-product__content bg-white">
                    <ul class="nav nav-tabs ps-tab-list" id="productContentTabs" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active show" id="description-tab" data-toggle="tab" href="#description-content" role="tab" aria-controls="description-content" aria-selected="false">Mô tả sản phẩm</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="information-tab" data-toggle="tab" href="#information-content" role="tab" aria-controls="information-content" aria-selected="true">Thành phần</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="specification-tab" data-toggle="tab" href="#specification-content" role="tab" aria-controls="specification-content" aria-selected="false">Công dụng</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="description-3-tab" data-toggle="tab" href="#description-3-content" role="tab" aria-controls="reviews-content" aria-selected="false">Cách dùng</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="description-4-tab" data-toggle="tab" href="#description-4-content" role="tab" aria-controls="reviews-content" aria-selected="false">Tác dụng phụ</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="description-5-tab" data-toggle="tab" href="#description-5-content" role="tab" aria-controls="reviews-content" aria-selected="false">Lưu ý</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="description-6-tab" data-toggle="tab" href="#description-6-content" role="tab" aria-controls="reviews-content" aria-selected="false">Bảo quản</a></li>

                    </ul>
                    <div class="tab-content" id="productContent">
                        <div class="tab-pane fade show active" id="description-content" role="tabpanel" aria-labelledby="description-tab">
                            <div class="ps-document">
                                <?php echo $detail->content; ?>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="information-content" role="tabpanel" aria-labelledby="information-tab">
                            <?php echo !empty($fields) ? (!empty($fields['config_colums_editor_thanhphan']) ? $fields['config_colums_editor_thanhphan'] : '') : ''; ?>

                        </div>
                        <div class="tab-pane fade" id="specification-content" role="tabpanel" aria-labelledby="specification-tab">
                            <?php echo !empty($fields) ? (!empty($fields['config_colums_editor_congdung']) ? $fields['config_colums_editor_congdung'] : '') : ''; ?>


                        </div>
                        <div class="tab-pane fade" id="description-3-content" role="tabpanel" aria-labelledby="description-3-tab">
                            <?php echo !empty($fields) ? (!empty($fields['config_colums_editor_cachdung']) ? $fields['config_colums_editor_cachdung'] : '') : ''; ?>

                        </div>
                        <div class="tab-pane fade" id="description-4-content" role="tabpanel" aria-labelledby="information-4-tab">
                            <?php echo !empty($fields) ? (!empty($fields['config_colums_editor_tacdungphu']) ? $fields['config_colums_editor_tacdungphu'] : '') : ''; ?>

                        </div>
                        <div class="tab-pane fade" id="description-5-content" role="tabpanel" aria-labelledby="information-5-tab">
                            <p class="note-detail"><?php echo !empty($fields) ? (!empty($fields['config_colums_editor_luuy']) ? strip_tags($fields['config_colums_editor_luuy']) : '') : ''; ?></p>
                        </div>
                        <div class="tab-pane fade" id="description-6-content" role="tabpanel" aria-labelledby="information-6-tab">
                            <?php echo !empty($fields) ? (!empty($fields['config_colums_editor_baoquan']) ? $fields['config_colums_editor_baoquan'] : '') : ''; ?>

                        </div>

                    </div>
                </div>
                <?php echo $__env->make('product.frontend.product.comment.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>
            <?php if(!empty($productSame)): ?>
            <section class="ps-section--featured viewed-products bg-white">

                <div class="section-title-2">
                    <h2 class=" ps-section__title title title split-in-fade">Sản phẩm liên quan</h2>
                </div>
                <div class="ps-section__content">
                    <div class="slider-product-only owl-carousel">
                        <?php $__currentLoopData = $productSame; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo htmlItemProduct2($key, $item); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <?php if(!empty($faqs)): ?>
            <div class="ps-widget__content ps-widget__category question-modul bg-white">
                <div class="section-title-2">
                    <h2 class=" ps-section__title title title split-in-fade">Câu hỏi thường gặp</h2>
                </div>

                <ul class="menu--mobile">
                    <?php $__currentLoopData = $faqs['title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="icon"><i class="fa fa-question-circle" aria-hidden="true"></i></span><?php echo e($item); ?>

                        </a>
                        <span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <div class="sub-menu">
                            <?php echo !empty($faqs['content'])?$faqs['content'][$key]:''; ?>

                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php echo $__env->make('homepage.common.recently', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>


</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('javascript'); ?>
<script src="<?php echo e(asset('frontend/library/js/common.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/library/js/products.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('frontend/css/app.css')); ?>" rel="stylesheet" async>
<link href="<?php echo e(asset('frontend/library/css/products.css')); ?>" rel="stylesheet">
<style>
    .img-large {
        height: 485px;
    }

    .img-small {
        height: 101px;
        margin: 0px auto
    }

    @media (max-width: 767px) {
        .img-large {
            height: 350px;
        }

        .img-small {
            height: 99px;
            margin: 0px auto
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/product/frontend/product/index.blade.php ENDPATH**/ ?>
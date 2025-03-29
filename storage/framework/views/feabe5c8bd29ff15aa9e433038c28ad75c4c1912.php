 <?php
    $menu_header = getMenus('menu-header');
    $categories =
        \App\Models\CategoryProduct::select('id', 'title', 'slug', 'image')->with(['children'])
        ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'isHeader' => 1])
        ->limit(6)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
    ?>
 <header class="ps-header ps-header--1">
     <div class="ps-header__top">
         <div class="container">
             <div class="ps-header__text">Tư vấn ngay: <strong><?php echo $fcSystem['contact_hotline']; ?> - <?php echo $fcSystem['homepage_brandname']; ?></strong></div>
         </div>
     </div>
     <div class="ps-header__middle">
         <div class="container">
             <?php /*<div class="ps-logo">
                 <a href="{{url('/')}}">
                     <img src="{{asset($fcSystem['homepage_logo'])}}" alt="{!!$fcSystem['homepage_brandname'] !!}">
                     <img class="sticky-logo" src="{{asset($fcSystem['homepage_logo_sticky'])}}" alt="{!!$fcSystem['homepage_brandname'] !!}">
                 </a>
             </div>*/ ?>
             <div class="main-logo">
                 <a href="<?php echo e(url('/')); ?>" class="ps-logo">
                     <img src="<?php echo e(asset($fcSystem['homepage_logo'])); ?>" alt="<?php echo $fcSystem['homepage_company']; ?>">
                 </a>
                 <h2 class="slogin"><?php echo $fcSystem['homepage_slogan']; ?></h2>
             </div>
             <a class="ps-menu--sticky" href="javascript:void()"><i class="fa fa-bars"></i></a>
             <div class="ps-header__right">
                 <ul class="ps-header__icons">
                     <li class="li-text">
                         <a href="<?php echo e(route('pageF.address')); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i>Hệ thống của hàng</a>
                     </li>
                     <li class="li-text">
                         <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"><i class="fa fa-phone" aria-hidden="true"></i>Hotline: <?php echo e($fcSystem['contact_hotline']); ?></a>
                     </li>
                     <li class="li-text li-text-suport">
                         <a  class="text-suport">Hỗ trợ</a>
                         <ul class="ul-2">
                            <li><a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>"><?php echo e($fcSystem['contact_hotline']); ?></a></li>
                            <li><a href="http://zalo.me/<?php echo e($fcSystem['social_zalo']); ?>" target="_blank">Chát Zalo</a></li>
                         </ul>
                     </li>
                     <?php if(!empty(Auth::guard('customer')->user())): ?>
                     <li>
                         <a class="ps-header__item" href="<?php echo e(route('customer.dashboard')); ?>"><i class="icon-user"></i></a>
                     </li>
                     <?php else: ?>
                     <li>

                        <a class="ps-header__item" href="#" id="login-modal"><i class="icon-user"></i></a>
                         <div class="ps-login--modal">
                             <form method="get" action="" id="form-header-login" autocomplete="off">
                                 <?php echo csrf_field(); ?>
                                 <div class="alert alert-success print-success-msg" style="display: none;">
                                 </div>
                                 <div class="alert alert-danger print-error-msg" style="display: none;">
                                 </div>
                                 <div class="form-group">
                                     <label>Số điện thoại hoặc email</label>
                                     <input class="form-control" name="phone" type="text" placeholder="Tên đăng nhập hoặc email">
                                 </div>
                                 <div class="form-group">
                                     <label>Mật khẩu</label>
                                     <input class="form-control" name="password" type="password" placeholder="Mật khẩu">
                                 </div>
                                 <div class="form-group form-check" style="margin-left: 20px;">
                                     <input class="form-check-input" type="checkbox">
                                     <label>Ghi nhớ mật khẩu</label>
                                 </div>
                                 <button class="ps-btn ps-btn--warning js_submit_login" type="submit">Đăng nhập</button>
                                 <p class="note-resgister">Bạn chưa có tài khoản</p>
                                 <a href="<?php echo e(route('customer.register')); ?>" class="ps-btn ps-btn--warning" type="submit">Đăng ký</a>
                             </form>
                         </div>

                     </li>
                     <?php endif; ?>

                     <?php
                        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
                        $quantity = $wishlist ? count($wishlist) : 0;
                        ?>
                     <li><a class="ps-header__item" href="<?php echo e(route('homepage.wishlist_index')); ?>"><i class="fa fa-heart-o"></i><span class="badge quantity-wishlist-header"><?php echo e($quantity); ?></span></a></li>
                     <li>
                         <a class="ps-header__item" href="javascript:void(0)" id="cart-mini"><i class="icon-cart-empty"></i><span class="badge cart-quantity"><?php echo e($cart['quantity']); ?></span></a>
                         <div class="ps-cart--mini">
                             <div class="box-header-cart" <?php if (empty($cart['cart'])) { ?> style="display: none;" <?php } ?>>
                                 <ul class="ps-cart__items cart-html-header" id="ps-cart__items">
                                     <?php if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0 ): ?>
                                     <?php $__currentLoopData = $cart['cart']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php echo htmlItemCartHeader($k,$item); ?>

                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     <?php else: ?>
                                     <?php endif; ?>
                                 </ul>
                                 <div class="ps-cart__total"><span>Tổng tiền </span><span class="cart-total"><?php echo !empty($cart['total']) ? number_format($cart['total'], 0, ',', '.') . '₫' : '0đ' ?></span></div>
                                 <div class="ps-cart__footer">
                                     <a class="ps-btn ps-btn--outline" href="<?php echo e(route('cart.index')); ?>">Xem giỏ hàng</a>
                                     <a class="ps-btn ps-btn--warning" href="<?php echo e(route('cart.checkout')); ?>">Thanh toán</a>
                                 </div>
                             </div>
                             <div class="flex flex-col box-empty-cart" <?php if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart'])> 0 ): ?> style="display:none" <?php endif; ?>>
                                 <div style="display: flex;justify-content: center;align-items: center;"><img src="<?php echo e(asset('images/empty-cart.png')); ?>" alt="img" style="margin: 0px auto;width: 200px;"></div>
                                 <div class="text-center">
                                     <h3 class="font-bold" style="font-size: 16px;">Chưa có sản phẩm nào trong giỏ hàng</h3>
                                 </div>
                             </div>
                         </div>
                     </li>
                 </ul>
                 <?php if(svl_ismobile() != 'is mobile'): ?>
                 <div class="ps-header__search">
                     <form action="<?php echo e(route('homepage.search')); ?>" method="GET">
                         <div class="ps-search-table">
                             <div class="input-group">
                                 <input class="form-control search-auto" value="<?php echo e(request()->get('keyword')); ?>" name="keyword" type="text" placeholder="">
                                 <div class="input-group-append"><button type="submit" style="cursor: pointer;"><i class="fa fa-search"></i></button></div>
                             </div>
                         </div>
                         <?php $keywords = explode("\r\n", $fcSystem['title_1']); ?>
                         <?php if(!empty($keywords)): ?>
                         <ul class="list-menu" style="display: none;">
                             <?php $__currentLoopData = $keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <li>
                                 <a href="<?php echo e(route('homepage.search',['keyword' => $item])); ?>"><?php echo e($item); ?></a>
                             </li>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </ul>
                         <?php endif; ?>
                     </form>
                     <div class="ps-search--result">
                         <div class="ps-result__content">
                             <div class="row m-0 results-box">
                             </div>
                             <div class="ps-result__viewall"><a href="" class="href-search">View all <span class="count-search">0</span> results</a></div>
                         </div>
                     </div>
                 </div>
                 <?php endif; ?>
             </div>
         </div>
     </div>
     <div class="ps-navigation">
         <div class="container">
             <div class="ps-navigation__left">
                 <nav class="ps-main-menu">
                     <ul class="menu">
                         <!--START: Danh mục sản phẩm -->
                         <?php if(!empty($categories)): ?>
                         <li class="has-mega-menu">
                             <a href="#"> <i class="fa fa-bars"></i>Danh mục sản phẩm<span class="sub-toggle"><i class="fa fa-chevron-down"></i></span></a>
                             <div class="mega-menu">
                                 <div class="container">
                                     <div class="mega-menu__row">
                                         <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <?php if(!empty($item->children)): ?>
                                         <div class="mega-menu__column">
                                             <h4><?php echo e($item->title); ?></h4>
                                             <ul class="sub-menu--mega">
                                                 <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <li><a href="<?php echo e(route('routerURL',['slug' => $val->slug])); ?>"><?php echo e($val->title); ?></a></li>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </ul>
                                         </div>
                                         <?php endif; ?>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </div>
                                 </div>
                             </div>
                         </li>
                         <?php endif; ?>
                         <!--END: Danh mục sản phẩm -->
                         <?php if(!empty($menu_header->menu_items) && count($menu_header->menu_items) > 0): ?>
                         <?php $__currentLoopData = $menu_header->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <li class="menu-item-has-children">
                             <a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?>

                                 <?php if(!empty($item->children) && count($item->children) > 0): ?>
                                 <span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                 <?php endif; ?>
                             </a>
                             <?php if(!empty($item->children) && count($item->children) > 0): ?>
                             <ul class="sub-menu">
                                 <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <li>
                                     <a href="<?php echo e(url($child->slug)); ?>"><?php echo e($child->title); ?></a>
                                     <?php if(!empty($child->children) && count($child->children) > 0): ?>
                                     <span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                     <ul class="sub-menu">
                                         <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <li> <a href="<?php echo e(url($child2->slug)); ?>"><?php echo e($child2->title); ?></a>
                                         </li>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </ul>
                                     <?php endif; ?>
                                 </li>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </ul>
                             <?php /* <div class="mega-menu">
                                 <div class="container">
                                     <div class="mega-menu__row">
                                         <div class="mega-menu__column col-12 col-md-3">
                                             <ul class="sub-menu--mega sub-menu--bold">
                                                 @foreach($item->children as $key=>$child)
                                                 <li class="menu-item-li menu-item-li-{{$child->id}} <?php if ($key == 0) { ?> active <?php } ?>"><a href="{{url($child->slug)}}" class="menu-item" data-id="{{$child->id}}">{{$child->title}}</a></li>
                                                 @endforeach
                                             </ul>
                                         </div>
                                         @foreach($item->children as $key=>$child)
                                         <?php
                                            $products = \App\Models\Product::join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')
                                                ->where('catalogues_relationships.module', '=', 'products')
                                                ->where('catalogues_relationships.catalogueid', $child->module_id)
                                                ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
                                                ->select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.slug', 'products.image', 'products.price', 'products.price_sale', 'products.price_contact', 'products.image_json')
                                                ->limit(4)
                                                ->orderBy('products.order', 'asc')
                                                ->orderBy('products.id', 'asc')
                                                ->get();
                                            ?>
                                         <div style="min-height: 307px;" class="mega-menu__column col-12 col-md-9 submenu-{{$child->id}} submenu <?php if ($key == 0) { ?> active <?php } ?>">
                                             <div class="product-list">
                                                 <div class="row">
                                                     @if(!empty($products))
                                                     @foreach($products as $prd)
                                                     <?php
                                                        $price = getPrice(array('price' => $prd['price'], 'price_sale' => $prd['price_sale'], 'price_contact' =>
                                                        $prd['price_contact']));
                                                        if (!empty($prd['image_json'])) {
                                                            $listAlbums = json_decode($prd['image_json'], true);
                                                            if (count($listAlbums) < 2) {
                                                                $listAlbums = [$prd['image'], $prd['image']];
                                                            }
                                                        } else {
                                                            $listAlbums = [$prd['image'], $prd['image']];
                                                        }
                                                        ?>
                                                     <div class="col-12 col-sm-6 col-lg-3">
                                                         <div class="ps-product ps-product--standard">
                                                             <div class="ps-product__thumbnail">
                                                                 <a class="ps-product__image" href="{{route('routerURL',['slug' => $prd->slug])}}">
                                                                     <figure>
                                                                         <img src="{{asset($prd['image'])}}" alt="{{$prd->title}}" />
                                                                         <img src="{{asset($listAlbums[0])}}" alt="{{$prd->title}}" />
                                                                     </figure>
                                                                 </a>
                                                                 <div class="ps-product__actions d-none">
                                                                     <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                                                     <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                                                     <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                                                     <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                                                 </div>
                                                                 <div class="ps-product__badge">
                                                                 </div>
                                                             </div>
                                                             <div class="ps-product__content">
                                                                 <h5 class="ps-product__title"><a href="{{route('routerURL',['slug' => $prd->slug])}}">{{$prd->title}}</a></h5>
                                                                 <div class="ps-product__meta"><span class="ps-product__price">{{ $price['price_final']}}</span><span class="ps-product__del">{{$price['price_old']}}</span>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     @endforeach
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                         @endforeach
                                     </div>
                                 </div>
                             </div>*/?>
                             <?php endif; ?>
                         </li>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>
                     </ul>
                 </nav>
             </div>
         </div>
     </div>
 </header>
 <header class="ps-header ps-header--1 ps-header--mobile">
     <div class="ps-header__middle">
         <div class="container">
             <div class="row">
                 <div class="col-md-6 col-sm-6 col-6">
                     <div class="ps-logo"><a href="<?php echo e(url('/')); ?>"> <img src="<?php echo e(asset($fcSystem['homepage_logo_mobile'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>"></a></div>
                 </div>
                 <div class="col-md-6 col-sm-6 col-6">
                     <div class="ps-header__right">
                         <ul class="ps-header__icons">
                             <li><a class="ps-header__item open-search" href="javascript:void(0)"><i class="fa fa-search"></i></a></li>
                             <li>
                                 <a class="ps-header__item" href="javascript: void(0)" id="open-menu-top">
                                     <i class="fa fa-bars"></i>
                                 </a>
                                 <a class="ps-header__item" href="javascript:void(0)" id="close-menu-top"><i class="icon-cross"></i></a>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </header>
 <?php if(svl_ismobile() == 'is mobile' || svl_ismobile() == 'is tablet'): ?>
 <?php if(!empty($menu_header->menu_items) && count($menu_header->menu_items) > 0): ?>
 <div class="ps-menu--slidebar">
     <div class="ps-menu__content">
         <ul class="menu--mobile" >
             <?php $__currentLoopData = $menu_header->menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <li class="menu-item-has-children">
                 <a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?></a>
                 <?php if(!empty($item->children) && count($item->children) > 0): ?>
                 <span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                 <ul class="sub-menu">
                     <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <li>
                         <a href="<?php echo e(url($child->slug)); ?>"><?php echo e($child->title); ?></a>
                         <?php if(!empty($child->children) && count($child->children) > 0): ?>
                         <span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                         <ul class="sub-menu">
                             <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <li> <a href="<?php echo e(url($child2->slug)); ?>"><?php echo e($child2->title); ?></a>
                             </li>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </ul>
                         <?php endif; ?>
                     </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </ul>
                 <?php endif; ?>
             </li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
     </div>
     <div class="ps-menu__footer">
         <div class="ps-menu__item">
             <ul class="ps-language-currency">
                 <li class="menu-item-has-children">
                     <a href="javascript:void(0)">Hỗ trợ</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                     <ul class="sub-menu">
                         <li><a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>">Hotline: <?php echo e($fcSystem['contact_hotline']); ?></a></li>
                         <li><a href="mailto:<?php echo e($fcSystem['contact_email']); ?>">Email: <?php echo e($fcSystem['contact_email']); ?></a></li>
                     </ul>
                 </li>
             </ul>
         </div>
         <div class="ps-menu__item">
             <div class="ps-menu__contact">Tư vấn ngay: <strong><?php echo e($fcSystem['contact_hotline']); ?> - <?php echo e($fcSystem['homepage_brandname']); ?></strong></div>
         </div>
     </div>
 </div>
 <?php endif; ?>
 <?php endif; ?>
<?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/homepage/common/header.blade.php ENDPATH**/ ?>
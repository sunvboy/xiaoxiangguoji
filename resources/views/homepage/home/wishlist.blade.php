@extends('homepage.layout.home')
@section('content')
<div class="ps-categogy main-category-product main-category-product-list pb-120 bg-gray main-wishlist" id="scrollTop">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active" aria-current="page"><a href="javascript:void(0)">Sản phẩm yêu thích</a></li>
        </ul>
        <div class="ps-categogy__content" style="padding-top: 20px;">
            <div class="row row-reverse">
                <div class="col-12 col-md-12">
                    @if(!empty($data))
                    <div class="ps-categogy--grid ps-categogy--detail" style="margin-top: 0px;">
                        <div class="row" id="js_data_product_filter">
                            @foreach ($data as $key=>$item)
                            <div class="col-6 col-lg-2 col-md-2 col-sm-3">
                                <?php echo htmlItemProduct2($key, $item); ?>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('homepage.layout.home')
@section('content')
<div class="ps-categogy main-category-product main-category-product-list pb-120 bg-gray" id="scrollTop">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active" aria-current="page"><a href="{{route('homepage.search',['keyword' => request()->get('keyword')])}}">Kết quả tìm kiếm</a></li>
        </ul>
        <div class="ps-categogy__content">
            <div class="row row-reverse">
                <div class="col-12 col-md-9">
                    <h2 class="title-primary-1">Danh sách sản phẩm</h2>
                    <input id="choose_attr" class="w-full d-none" type="text" name="attr">
                    <div class="ps-categogy__wrapper">
                        <div class="ps-categogy__type">
                            <a class="js_typeHTML" href="javascript:void(0)" data-type="list"><img src="{{asset('frontend/img/icon/bars.svg')}}" alt></a>
                            <a class="js_typeHTML active" href="javascript:void(0)" data-type="col"><img src="{{asset('frontend/img/icon/gird2.svg')}}" alt></a>
                        </div>
                        <div class="ps-categogy__onsale">
                            <div class="custom-control custom-checkbox">
                                <label for="onSaleProduct"> <input type="checkbox" id="onSaleProduct" value="1"> Chỉ hiển thị các sản phẩm đang sale</label>
                            </div>
                        </div>
                        <div class="ps-categogy__sort d-flex">
                            <span>Sắp xếp theo</span>
                            <select class="form-select filter" name="sort">
                                <option selected value="id|desc">Mới nhất</option>
                                <option value="cart|desc">Bán chạy</option>
                                <option value="price|asc">Giá thấp</option>
                                <option value="price|desc">Giá cao</option>
                            </select>
                        </div>
                        <div class="ps-categogy__show">
                            <span>Hiển thị</span>
                            <select class="form-select filter" name="perpage">
                                <option selected value="20">20</option>
                                <option value="40">40</option>
                                <option value="60">60</option>
                                <option value="80">80</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="ps-categogy--grid ps-categogy--detail">
                        <div class="row" id="js_data_product_filter">
                            @if($data)
                            @foreach ($data as $key=>$item)
                            <div class="col-6 col-lg-3" style="margin-bottom: 20px;">
                                <?php echo htmlItemProduct2($key, $item); ?>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        @include('homepage.common.loading')
                    </div>
                    <div class="ps-pagination js_pagination_filter">
                        @include('homepage.common.pagination', ['paginator' => $data, 'interval' => 2])
                    </div>
                </div>
                @if(svl_ismobile() != 'is mobile')
                <div class="col-12 col-md-3">
                    <div class="ps-widget ps-widget--product">
                        @if(!empty($attributes) && count($attributes) > 0)
                        <?php $i = 0; ?>
                        @foreach ($attributes as $key=>$item)
                        <?php $i++; ?>
                        @if(count($item) > 0)
                        @if($i == 1)
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title">{{$key}}</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <div class="ps-widget__content">
                                @foreach ($item as $val)
                                <div class="ps-widget__item">
                                    <div class="custom-control custom-checkbox">
                                        <label class="js_attr" for="attr-{{$val['id']}}">
                                            <input id="attr-{{$val['id']}}" type="checkbox" value="{{$val['id']}}" data-title="{{$val['title']}}" data-keyword="{{$val['keyword']}}" class="js_input_attr filter hidden" name="attr[]">
                                            <span>{{$val['title']}}</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title">Khoảng giá</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <input type="text" class="filter d-none" name="price_start" value="" id="slide-price-min-input" />
                            <input type="text" class="filter d-none" name="price_end" value="" id="slide-price-max-input" />
                            <div class="ps-widget__content">
                                <div class="ps-widget__price">
                                    <div id="slide-price"></div>
                                </div>
                                <div class="ps-widget__input">
                                    <span class="ps-price" id="slide-price-min">0</span>
                                    <span class="bridge">-</span>
                                    <span class="ps-price" id="slide-price-max"></span>
                                </div>
                                <button class="ps-widget__filter">Lọc</button>
                            </div>
                        </div>
                        @if(!empty($attributes) && count($attributes) > 0)
                        <?php $i = 0; ?>
                        @foreach ($attributes as $key=>$item)
                        <?php $i++; ?>
                        @if(count($item) > 0)
                        @if($i > 1)
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title">{{$key}}</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <div class="ps-widget__content">
                                @foreach ($item as $val)
                                <div class="ps-widget__item">
                                    <div class="custom-control custom-checkbox">
                                        <label for="attr-{{$val['id']}}" class="js_attr">
                                            <input id="attr-{{$val['id']}}" type="checkbox" value="{{$val['id']}}" data-title="{{$val['title']}}" data-keyword="{{$val['keyword']}}" class="js_input_attr filter hidden" name="attr[]">
                                            <span>{{$val['title']}}</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @include('homepage.common.recently')
    </div>
</div>
@endsection
@push('javascript')
@include('product.frontend.category.script',['module' => 'search'])
@endpush
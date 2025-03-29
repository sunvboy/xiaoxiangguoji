@extends('homepage.layout.home')
@section('content')
<div class="ps-page--product ps-page--product1 page-category-sick pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Trang chủ</a></li>
            <li class="ps-breadcrumb__item active"><a href="{{route('category.index')}}">Bệnh lý</a></li>
            <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">{{$detail->title}}</a></li>

        </ul>
        <div class="ps-page__content" style="padding-top: 0px;">
            @if(!empty($data))
            <div class="bottom-sick bg-white">
                <div class="ps-section__tab">
                    <div class="tab-content" id="bestsellerTabContent">
                        <div class="tab-pane fade show active" id="blood" role="tabpanel" aria-labelledby="blood-tab" style="display: block !important;">
                            <ul class="list-content" id="js_htmlBenhchuyenkhoa">
                                @foreach($data as $item)
                                <li>
                                    <a href="{{route('routerURL',['slug' => $item->slug])}}">{{$item->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="ps-pagination ps-pagination-benhchuyenkhoa">
                                @include('homepage.common.pagination', ['paginator' => $data, 'interval' => 2])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
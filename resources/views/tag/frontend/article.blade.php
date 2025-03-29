@extends('homepage.layout.home')
@section('content')
    <div class="ps-page--product ps-page--product1 page-category-new pb-120 bg-gray">
        <div class="container">
            <div></div>
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
                <li class="ps-breadcrumb__item active"><a href="javascript:void(0)">Tag: {{$detail->title}}</a></li>
            </ul>
            <div class="ps-page__content">
                @if(!empty($data))
                    <div class="health-corner bg-white" style="display: none">
                        <div class="section-title-2 cat">
                            <h1 class=" ps-section__title title title split-in-fade">Tag: {{$detail->title}}</h1>
                        </div>
                    </div>
                    <section class="modul-second-new">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-12">
                                <div class="modul-new-2 bg-white" style="margin: 0px;">
                                    <div class="nav-modul-new-2">
                                        <div class="row">
                                            <?php foreach ($data as $k => $item) { ?>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="item">
                                                    <div class="img">
                                                        <a href="{{route('routerURL',['slug' => $item->article->slug])}}">
                                                            <img src="{{asset($item->article->image)}}" alt="{{$item->article->title}}">
                                                        </a>
                                                    </div>
                                                    <div class="nav-img">
                                                        <h3 class="title-4"><a href="{{route('routerURL',['slug' => $item->article->slug])}}">{{$item->article->title}}</a></h3>
                                                        <p class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->article->created_at)->format('d/m/Y')}}</p>
                                                        <div class="desc">
                                                            {!!$item->article->description!!} </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="mt-10">
                                                <?php echo $data->links() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-12">
                                @include('article.frontend.aside')
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('javascript')
@endpush

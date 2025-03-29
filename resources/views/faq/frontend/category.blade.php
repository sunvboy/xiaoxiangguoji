@extends('homepage.layout.home')
@section('content')
<main class="main-new-2 main-QA">
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_6'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span class="tp-breadcrumb-link-active"><a href="{{route('pageF.faqs')}}"> \ {{$page->title}}</a></span>
                            <span> \ {{$detail->title}}</span>
                        </div>
                        <h2 class="tp-breadcrumb-title">{{$detail->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-QA">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <aside class="aside-left">
                        <?php $menu_faqs = getMenus('menu-hoi-dap'); ?>
                        @if(!empty($menu_faqs->menu_items) && count($menu_faqs->menu_items) > 0)
                        @foreach($menu_faqs->menu_items as $key=>$item)
                        @if(!empty($item->children) && count($item->children) > 0)
                        @if($key == 0)
                        <div class="item-sb">
                            <h3 class="title-3" style="text-transform: uppercase;">{{$item->title}}</h3>
                            <div class="nav-item-sb">
                                <ul>
                                    @foreach($item->children as $child)
                                    <li>
                                        <a href="{{url($child->slug)}}"><i class="fa-solid fa-angle-right"></i>{{$child->title}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="item-sb" style="margin-top: 50px;">
                            <h3 class="title-3" style="text-transform: uppercase;">{{$item->title}}</h3>
                            <div class="nav-item-sb">
                                <ul>
                                    @foreach($item->children as $child)
                                    <li>
                                        <a href="{{url($child->slug)}}"><i class="fa-solid fa-angle-right"></i>{{$child->title}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="content-qa-center">
                        <h2 class="title-2">Hỏi đáp chuyên gia</h2>
                        <div class="content-content-item">
                            @if(!empty($data))
                            @foreach($data as $item)
                            <div class="item">
                                <div class="icon">
                                    <i class="fa-solid fa-circle-question"></i>
                                </div>
                                <div class="title-top">
                                    <span class="name-title">{{$item->name}}</span>
                                    @if(!empty($item->faq_categories))
                                    <span class="category">{{$item->faq_categories->title}}</span>
                                    @endif
                                    <span class="date">Đã hỏi: Ngày {{$item->created_at}}</span>
                                </div>
                                <h4 class="title-4"><a href="{{route('pageF.faqs.id',['id'=>$item->id])}}">{{$item->title}}</a></h4>
                                <p class="desc">{!!$item->content!!}</p>
                                <div class="item-bottom">
                                    <span class="conment"><i class="fa-solid fa-comment-dots"></i>0 bình luận</span>
                                    <span class="view"> <i class="fa-solid fa-eye"></i>{{$item->viewed}} lượt xem</span>
                                    <span class="view-question"><a href="{{route('pageF.faqs.id',['id'=>$item->id])}}"><i class="fa-solid fa-check"></i>Xem câu trả lời</a></span>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        {{$data->links()}}
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-12">
                    @include('article.frontend.aside')
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
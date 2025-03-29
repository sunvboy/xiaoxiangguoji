@extends('homepage.layout.home')
@section('content')
<main class="main-new-2 main-info">

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area tp-breadcrumb-bg breadcrumb-wrap" data-background="{{asset($fcSystem['banner_5'])}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-breadcrumb text-center">
                        <div class="tp-breadcrumb-link mb-10">
                            <span class="tp-breadcrumb-link-active"><a href="url('/')">Trang chủ</a></span>
                            <span> \ {{$page->title}}</span>
                        </div>
                        <h2 class="tp-breadcrumb-title">{{$page->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <div class="content-info">


        <div class="container">

            <div class="tabbed_area">
                <ul class="tabs">
                    <li><a href="javascript:void(0)" data-href="{{url('thu-ngo')}}" title="topics" class="tab">Thư ngỏ</a></li>
                    <li><a href="javascript:void(0)" data-href="{{url('lich-su-hinh-thanh')}}" title="archives" class="tab">lịch sử hình thành</a></li>
                    <li><a href="javascript:void(0)" data-href="{{url('tam-nhin-su-menh-loi-the-canh-tranh')}}" title="pages" class="tab">Tầm nhìn - Sứ mệnh - Lợi thế cạnh tranh</a></li>
                    <li><a href="javascript:void(0)" data-href="{{url('co-cau-to-chuc')}}" title="cocau" class="tab">Cơ cấu tổ chức</a></li>
                    <li><a href="javascript:void(0)" data-href="{{url('ky-thuat-chuyen-mon')}}" title="kythuat" class="tab">Kỹ thuật chuyên môn</a></li>
                    <li><a href="javascript:void(0)" data-href="{{url('co-so-vat-chat')}}" title="coso" class="tab">Cơ sở vật chất </a></li>
                </ul>
                <div id="topics" class="content" data-href="{{url('thu-ngo')}}">
                    {!!!empty($fields['config_colums_editor_tn']) ? $fields['config_colums_editor_tn']:''!!}
                </div>
                <div id="archives" class="content" data-href="{{url('lich-su-hinh-thanh')}}">
                    <div class="timeline" style="background: url(<?php echo asset($fcSystem['banner_9'])?>)">
                        <?php
                            $lists = !empty($fields['config_colums_json_lsht']) ? json_decode($fields['config_colums_json_lsht']): [];

                        ?>
                        @if(!empty($lists->title))
                        @foreach($lists->title as $key=>$item)
                            <div class="container-1 @if($key%2==0)left @else right  @endif">
                                <div class="date">{{!empty($lists->year[$key]) ? $lists->year[$key] : '' }}</div>
                                <img class="icon" src="{{!empty($lists->icon[$key]) ? asset($lists->icon[$key]) : '' }}" alt="icon" style="object-fit: contain;">
                                <div class="content">
                                <h2>{{$item}}</h2>
                                <p>
                                    {{!empty($lists->content[$key]) ? $lists->content[$key] : '' }}
                                </p>
                                </div>
                            </div>
                        @endforeach
                        @endif


                   </div>
                </div>
                <div id="pages" class="content" data-href="{{url('tam-nhin-su-menh-loi-the-canh-tranh')}}">
                    {!!!empty($fields['config_colums_editor_tamnhin']) ? $fields['config_colums_editor_tamnhin']:''!!}
                </div>
                <div id="cocau" class="content" data-href="{{url('co-cau-to-chuc')}}">
                    {!!!empty($fields['config_colums_editor_cocau']) ? $fields['config_colums_editor_cocau']:''!!}
                </div>
                <div id="kythuat" class="content" data-href="{{url('ky-thuat-chuyen-mon')}}">
                    {!!!empty($fields['config_colums_editor_kythuat']) ? $fields['config_colums_editor_kythuat']:''!!}
                </div>
                <div id="coso" class="content" data-href="{{url('co-so-vat-chat')}}">
                    {!!!empty($fields['config_colums_editor_coso']) ? $fields['config_colums_editor_coso']:''!!}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('javascript')
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.tabs li a').filter(function() {
        return $(this).attr('data-href') === aurl;
    }).addClass('active');
    $('.content').filter(function() {
        return $(this).attr('data-href') === aurl;
    }).addClass('active');
</script>
<script>
    $(document).ready(function() {
        $("a.tab").click(function() {
            $(".active").removeClass("active");
            $(this).addClass("active");
            $(".content").hide();
            var x = $(this).attr("title");
            $("#" + x).show();
        });
    });
</script>
@endpush
@push('javascript')
<style>
    .content.active{
        display: block !important;
    }
    #topics,
    #archives,
    #pages,
    #cocau,
    #kythuat,
    #coso {
        display: none;
    }
</style>
@endpush

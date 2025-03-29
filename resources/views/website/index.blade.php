@extends('dashboard.layout.dashboard')

@section('title')
<title>Quản lý website</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Quản lý website",
        "src" => route('websites.index'),
    ],
    [
        "title" => "Danh sách",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class="flex justify-between items-center mt-10">
        <h1 class="text-lg font-medium">
            Quản lý website
        </h1>
        @can('websites_create')
        <a href="javascript:void(0)" onclick="handleCreate()" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
        @endcan
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-3 hidden">
                    <ul class="nav nav-link-tabs flex-col" role="tablist">
                        @if(!$data->isEmpty())
                        <?php $i = 0; ?>
                        @foreach($data as $key=>$item)
                        <?php $i++; ?>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                            <button class="pl-0 nav-link w-full py-2 text-left <?php if (request()->get('type') == $key) { ?>active<?php } else if (empty(request()->get('type')) &&  $i == 1) { ?>active<?php } ?>" data-type="<?php echo $key ?>" data-tw-toggle="pill" data-tw-target="#example-tab-<?php echo $i ?>" type="button" role="tab" aria-controls="example-tab<?php echo $i ?>" aria-selected="true" style="padding-left: 0px;">{{$type[$key]}}</button>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-span-12">
                    <div class="tab-content mt-5">
                        @if(!$data->isEmpty())
                        <?php $i = 0; ?>
                        @foreach($data as $key=>$item)
                        <?php $i++; ?>
                        <div id="example-tab-<?php echo $i ?>" class="tab-pane leading-relaxed <?php if (request()->get('type') == $key) { ?>active<?php } else if (empty(request()->get('type')) &&  $i == 1) { ?>active<?php } ?>" role="tabpanel" aria-labelledby="example-<?php echo $i ?>-tab">
                            @if(count($item) > 0)

                            @if($key == 'header' || $key == 'footer')
                            @foreach($item as $val)
                            <div class="box item w-full mb-5 p-2">
                                <a href="{{asset($val->image)}}" data-fancybox><img class="w-full" src="{{asset($val->image)}}" alt="{{$val->title}}"></a>
                                <div class="mt-5">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h2 class="font-bold text-base mb-2">{{$val->title}}</h2>
                                            <div class="form-check form-switch space-x-2">
                                                <input <?php echo ($val->publish == 1) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax-website" type="checkbox" data-id="<?php echo $val->id; ?>" data-keyword="<?php echo $val->keyword; ?>" id="publish-<?php echo $val->id; ?>">
                                                <span>Kích hoạt</span>
                                            </div>
                                        </div>
                                        <div>
                                            @can('websites_edit')
                                            <a class="flex items-center mr-3 text-lg font-bold" href="{{ route('websites.edit',['id'=>$val->id]) }}">
                                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            @endif
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($item as $v)
                                <div class="box item w-full mb-5 p-2">
                                    <a href="{{asset($v->image)}}" data-fancybox><img class="w-full" style="height:300px;object-fit: contain;" src="{{asset($v->image)}}" alt="{{$v->title}}"></a>
                                    <div class="mt-5">
                                        <div class="">
                                            <div>
                                                <h2 class="font-bold text-base mb-2">{{$v->title}}</h2>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="space-y-2">
                                                    <div class="form-check form-switch space-x-2">
                                                        @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                                                        $v->id])
                                                        <span>Kích hoạt</span>
                                                    </div>
                                                    <div class="form-check form-switch space-x-2">
                                                        @include('components.order',['module' => $module])
                                                        <span>Vị trí</span>
                                                    </div>
                                                </div>
                                                @can('websites_edit')
                                                <a class="flex items-center mr-3 text-lg font-bold" href="{{ route('websites.edit',['id'=>$v->id]) }}">
                                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!-- END: Data List -->
    </div>
</div>
@endsection
@push('javascript')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
    function handleCreate() {
        var type = $('.nav-link-tabs li button.active').attr('data-type');
        var url = "{{route('websites.create')}}?type=" + type;
        window.location.href = url;
    }
    /*START: ajax publish*/
    $(document).on('change', '.publish-ajax-website', function() {
        let _this = $(this);
        let param = {
            id: _this.attr("data-id"),
            keyword: _this.attr("data-keyword"),
        };
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = '<?php echo route('websites.publish') ?>';
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            param: param
                        },
                        success: function(data) {
                            if (data.code === 200) {
                                swal({
                                    title: "Cập nhập thành công!",
                                    text: "",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(jqXhr, json, errorThrown) {
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = "";
                            $.each(errors["errors"], function(index, value) {
                                errorsHtml += value + "/ ";
                            });
                        },
                    });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            }
        );
        return false;
    });
    /*END: ajax publish*/
</script>
@endpush
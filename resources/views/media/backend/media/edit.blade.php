@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập bài viết</title>
@endsection

@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách media",
        "src" => route('media.index'),
    ],
    [
        "title" => "Cập nhập media",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')


<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập media
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('media.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class="mt-3 box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề bài viết</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full title']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Đường dẫn</label>
                    <div class="input-group">
                        <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                        </div>
                        <?php echo Form::text('slug', $detail->slug, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('description', $detail->description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="grid md:grid-cols-2">
                        <div>
                            <label class="form-label text-base font-semibold">Chọn danh mục chính</label>
                            <?php echo Form::select('catalogue_id', $htmlCatalogue, $detail->catalogue_id, ['class' => 'tom-select tom-select-custom w-full layout', 'data-placeholder' => "Select your favorite actors"]); ?>

                        </div>
                        <div class="ml-3">
                            <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                            <select name="catalogue[]" class="form-control tom-select tom-select-custom w-full" multiple>
                                <option value=""></option>
                                @foreach($htmlCatalogue as $k=>$v)
                                <option value="{{$k}}" {{ (collect($getCatalogue)->contains($k)) ? 'selected':'';}}>
                                    {{$v}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- START: VIDEO -->
            <div class=" box p-5 mt-3 video hidden">
                <div class="ibox-title">
                    <div class="flex justify-between items-center">
                        <h5 class="form-label text-base font-semibold mb-0">Video <small class=" text-danger">Để giảm
                                tải dung lượng và băng thông bạn nên sử dụng mã nhúng video.</small></h5>
                    </div>
                </div>
                <div class="mt-3 ">
                    <div class="wrap-direct mb-3">
                        <span class="video-direct flex mb-3 mr-3">
                            <input class="choose_video_type" <?php echo (old('video_type') == 0) ? 'checked' : (($detail->video_type == 0) ? 'checked' : ''); ?> style="margin-top:0;margin-right:5px;" type="radio" id="video-direct" name="video_type" value="0" />
                            <label for="video-direct" style="margin:0;font-weight:normal;cursor:pointer">Upload trực
                                tiếp</label>
                        </span>
                        <?php echo Form::text('video_link', $detail->video_link, ['class' => 'form-control', 'placeholder' => 'Click để upload', "onclick" => "openKCFinderMedia(this, 'media');", "id" => "video-link", "autocomplete" => "off", '' . (($detail->video_type == 1) ? ((old('video_type') == 1) ? 'disabled'  : '') : '') . ' ']); ?>
                    </div>

                    <div class="wrap-iframe">
                        <span class="video-iframe flex  mb-3 mr-3">
                            <input <?php echo (old('video_type') == 1) ? 'checked' : (($detail->video_type == 1) ? 'checked' : ''); ?> style="margin-top:0;margin-right:5px;" type="radio" id="iframe-video" name="video_type" class="choose_video_type" value="1" />
                            <label for="iframe-video" style="margin:0;font-weight:normal;cursor:pointer">Mã
                                nhúng</label>
                        </span>
                        <?php echo Form::textarea('video_iframe', $detail->video_iframe, ['id' => 'video-iframe', 'class' => 'form-control', '' . (($detail->video_type == 0) ? ((old('video_type') == 0) ? 'disabled'  : '') : '') . '']); ?>
                    </div>
                </div>
            </div>
            <!-- END: VIDEO -->
            <!-- START: Album Ảnh -->
            <div class=" box p-5 mt-3 album hidden">
                <div class="mt-3">
                    @include('components.dropzone',['action' => 'update'])
                </div>
            </div>
            <!-- END: Album Ảnh -->
            <!-- START: Tải file upload -->

            <div class=" box p-5 mt-3 file-upload hidden">
                <div class="ibox-title">
                    <div class="flex justify-between items-center">
                        <h5 class="form-label text-base font-semibold mb-0">Chọn file</h5>
                    </div>
                </div>
                <div class="mt-3 ">
                    <?php echo Form::text('file_upload', $detail->file_upload, ['class' => 'form-control', 'placeholder' => 'Click để upload',  "onclick" => "openKCFinderMedia(this, 'files');", "id" => "video-link", "autocomplete" => "off"]); ?>
                </div>
            </div>
            <!-- END: Tải file upload -->

            <div class=" box p-5 mt-3">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <di v class=" col-span-12 lg:col-span-4">
            @include('polylang.edit')
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
            <input type="hidden" name="layoutid" value="<?php $detail->layoutid ?>">
        </di>
    </form>
</div>
<script>
    var layoutid = <?php echo !empty(old('layoutid')) ? old('layoutid') : $detail->layoutid; ?>;
    console.log(layoutid)
</script>
@include('media.backend.media.script')
@endsection
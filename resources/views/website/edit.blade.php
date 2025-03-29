@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới giao diện</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách giao diện",
        "src" => route('users.index'),
    ],
    [
        "title" => "Thêm mới",
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
            Thêm mới
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('websites.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class="col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full ']); ?>
                </div>
                <div class="mt-3 hidden">
                    <label class="form-label text-base font-semibold">Chọn loại giao diện</label>
                    <div class="mt-2">
                        <?php echo Form::select('keyword', $data, $detail->keyword, ['class' => 'form-control tom-select tom-select-custom', 'id' => 'js_keyword']); ?>
                    </div>
                </div>
                <div class="mt-3 hidden">
                    <label class="form-label text-base font-semibold">Chọn file</label>
                    <div class="mt-2">
                        <?php echo Form::select('template', $temp, $detail->template, ['class' => 'form-control', 'id' => 'js_file', 'placeholder' => '']); ?>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>

        </div>
        <div class="col-span-4">
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@endsection
@push('javascript')
<script>
    $(document).on('change', '#js_keyword', function(e, data) {
        let _this = $(this);
        let formURL = '<?php echo route('websites.folder') ?>';
        $.post(formURL, {
                'folder': _this.val(),
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                $('#js_file').html(json.html).trigger('change');
            });
    });

    /*lấy hình ảnh khi upload */
    function mainThamUrl(input, image) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#mainThmb-' + image).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    /*lấy tên file khi upload ảnh xong*/
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $(this).parent().parent().find('.file-return').html('Select file image: ' + fileName);;
    });
</script>
@endpush
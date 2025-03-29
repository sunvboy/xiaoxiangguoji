@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách Tỉnh/Thành phố</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình",
        "src" => route('generals.index'),
    ],
    [
        "title" => "Danh sách vận chuyển",
        "src" => route('ships.index'),
    ],
    [
        "title" => "Danh sách Tỉnh/Thành phố",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">

    <div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Data List -->
            <div class=" col-span-12 overflow-auto lg:overflow-visible">
                <div class="flex justify-between items-center">
                    <div class="">
                        <h2 class=" text-lg font-medium">Danh sách Tỉnh/Thành phố</h2>
                    </div>

                </div>
                <div class=" grid grid-cols-12 gap-2 justify-between  mt-5 mb-5">
                    <input type="search" name="keyword" class="form-control col-span-4 js_price" placeholder="Giá vận chuyển" autocomplete="off" value="">
                    <button type="submit" class="btn btn-primary shadow-md mr-2 col-span-2 js_update_all">Cập nhập</button>
                </div>
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th style="width:40px;">
                                <input type="checkbox" id="checkbox-all">
                            </th>
                            <th class="whitespace-nowrap text-left">Tên</th>
                            <th class="whitespace-nowrap text-left">Giá vận chuyển</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $v)
                        <tr class="odd " id="post-<?php echo $v->id; ?>">
                            <td>
                                <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                            </td>
                            <td style="text-align: left;">
                                <?php echo $v->name; ?>
                            </td>
                            <td class="text-left">
                                <input class="form-control js_update_price" data-id="<?php echo $v->id; ?>" name="price[<?php echo $v->id; ?>]" type="text" value="<?php echo $v->price ?>">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
@push('javascript')
<script type="text/javascript">
    $(document).on("change", ".js_update_price", function() {
        let _this = $(this);
        $.ajax({
            type: 'POST',
            url: BASE_URL_AJAX + "ships/update-one-province",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: _this.attr("data-id"),
                price: _this.val(),
            },
            success: function(data) {}
        });
        return false;
    });
    $(document).on('click', '.js_update_all', function() {
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        $('.checkbox-item:checked').each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error"
            }, function() {
                location.reload();
            });
            return false;
        }
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL_AJAX + "ships/update-all-province",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'price': $('.js_price').val(),
                            'list': id_checked,
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                swal({
                                    title: "Cập nhập thành công!",
                                    text: "Các bản ghi đã được cập nhập.",
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
                        }
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
            });
    });
</script>
@endpush
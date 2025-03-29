@extends('dashboard.layout.dashboard')
@section('title')
<title>Nhóm nhà cung cấp</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Nhóm nhà cung cấp",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Nhóm nhà cung cấp
    </h1>
    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module])
            @can('suppliers_categories_create')
            <a href="javascript:void(0)" class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#form_add_suppliers_categories">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Tên nhóm</th>
                        <th class="whitespace-nowrap">Mã nhóm</th>
                        <th class="whitespace-nowrap">Ghi chú </th>
                        <th class="whitespace-nowrap">Số lượng nhà cung cấp</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                        <th class="whitespace-nowrap text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$v->title}}
                        </td>
                        <td>
                            {{$v->code}}
                        </td>
                        <td>
                            {{$v->description}}
                        </td>
                        <td>
                            {{$v->counts->count()}}

                        </td>
                        <td class="w-40">
                            {{$v->created_at}}
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('suppliers_categories_edit')
                                <a class="flex items-center mr-3 js_edit_suppliers_categories" href="javascript:void(0)" data-id="{{$v->id}}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @endcan
                                @can('suppliers_categories_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thuộc tính, thuộc tính sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            {{$data->links()}}
        </div>
        <!-- END: Pagination -->
    </div>
</div>
@endsection
@push('javascript')

<div id="form_add_suppliers_categories" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Thêm mới nhóm nhà cung cấp
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 FormAddSuppliersCategories">
                <div class="col-span-12">
                    <div class="alert alert-danger-soft show flex items-center mb-2 print-error-msg" role="alert" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span class=""></span>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-1" class="form-label">Tên nhóm<span style="color: red">*</span></label>
                    <input id="modal-form-1" type="text" class="form-control" name="title" placeholder="Nhập tên nhóm nhà cung cấp">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Mã nhóm</label>
                    <input id="modal-form-2" type="text" class="form-control" name="code" placeholder="Nhập mã nhóm nhà cung cấp">
                </div>
                <div class="col-span-12">
                    <label for="modal-form-3" class="form-label">Ghi chú</label>
                    <textarea id="modal-form-3" type="text" class="form-control" name="description" placeholder=""></textarea>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                <button type="button" class="btn btn-primary js_submitFormAddSuppliersCategories">Thêm mới</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<div id="form_update_suppliers_categories" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Cập nhập thông tin thuế
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 FormUpdateSuppliersCategories">
                <div class="col-span-12">
                    <div class="alert alert-danger-soft show flex items-center mb-2 print-error-msg" role="alert" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span class=""></span>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-1" class="form-label">Tên nhóm<span style="color: red">*</span></label>
                    <input id="modal-form-1" type="text" class="form-control" name="title" placeholder="Nhập tên nhóm nhà cung cấp">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Mã nhóm</label>
                    <input id="modal-form-2" type="text" class="form-control" name="code" placeholder="Nhập mã nhóm nhà cung cấp">
                </div>
                <div class="col-span-12">
                    <label for="modal-form-3" class="form-label">Ghi chú</label>
                    <textarea id="modal-form-3" type="text" class="form-control" name="description" placeholder=""></textarea>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                <button type="button" class="btn btn-primary js_submitFormUpdateSuppliersCategories">Cập nhập</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.js_submitFormAddSuppliersCategories', function(e) {
        e.preventDefault();
        var title = $('.FormAddSuppliersCategories input[name="title"]').val();
        var code = $('.FormAddSuppliersCategories input[name="code"]').val();
        var description = $('.FormAddSuppliersCategories textarea[name="description"]').val();
        $.ajax({
            url: "<?php echo route('suppliers_categories.store') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: title,
                code: code,
                description: description,
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".FormAddSuppliersCategories .print-error-msg").css('display', 'none');
                    swal({
                        title: "Thông báo!",
                        text: data.success,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $(".FormAddSuppliersCategories .print-error-msg").css('display', 'flex');
                    $(".FormAddSuppliersCategories .print-success-msg").css('display', 'none');
                    $(".FormAddSuppliersCategories .print-error-msg span").html(data.error);
                }

            }
        });
    })
    $(document).on('click', '.js_edit_suppliers_categories', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo route('suppliers_categories.edit') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: $(this).attr('data-id'),
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('.FormUpdateSuppliersCategories input[name="title"]').val(data.data.title);
                    $('.FormUpdateSuppliersCategories input[name="code"]').val(data.data.code);
                    $('.FormUpdateSuppliersCategories textarea[name="description"]').val(data.data.description);
                    $('.js_submitFormUpdateSuppliersCategories').attr('data-id', data.data.id);
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#form_update_suppliers_categories"));
                    myModal.show();
                } else {
                    swal({
                        title: "Thông báo",
                        text: data.error,
                        type: "error"
                    });
                }

            }
        });
    })
    $(document).on('click', '.js_submitFormUpdateSuppliersCategories', function(e) {
        e.preventDefault();
        var title = $('.FormUpdateSuppliersCategories input[name="title"]').val();
        var code = $('.FormUpdateSuppliersCategories input[name="code"]').val();
        var description = $('.FormUpdateSuppliersCategories textarea[name="description"]').val();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "<?php echo route('suppliers_categories.update') ?>",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: title,
                code: code,
                description: description,
                id: id,
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".FormUpdateSuppliersCategories .print-error-msg").css('display', 'none');
                    swal({
                        title: "Thông báo!",
                        text: data.success,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $(".FormUpdateSuppliersCategories .print-error-msg").css('display', 'flex');
                    $(".FormUpdateSuppliersCategories .print-success-msg").css('display', 'none');
                    $(".FormUpdateSuppliersCategories .print-error-msg span").html(data.error);
                }

            }
        });
    })
</script>
@endpush
@extends('dashboard.layout.dashboard')

@section('title')

<title>Danh sách câu hỏi thường gặp</title>

@endsection

@section('breadcrumb')

<?php

$array = array(

    [

        "title" => "Danh sách câu hỏi thường gặp",

        "src" => 'javascript:void(0)',

    ]

);

echo breadcrumb_backend($array);

?>

@endsection

@section('content')

<div class="content">

    <h1 class=" text-lg font-medium mt-10">

        Danh sách câu hỏi thường gặp

    </h1>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">

            @include('components.search',['module'=>$module])

            @can('faqs_create')

            <a href="{{route('faqs.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>

            @endcan

        </div>

        <!-- BEGIN: Data List -->

        <div class=" col-span-12 overflow-auto lg:overflow-visible">

            <table class="table table-report -mt-2">

                <thead>

                    <tr>

                        <th style="width:40px;">

                            <input type="checkbox" id="checkbox-all">

                        </th>

                        <th class="whitespace-nowrap">STT</th>

                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>

                        <th class="whitespace-nowrap">VỊ TRÍ</th>

                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>

                        <th class="whitespace-nowrap">NGÀY TẠO</th>


                        <th class="whitespace-nowrap">#</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($data as $v)

                    <tr class="odd " id="post-<?php echo $v->id; ?>">

                        <td>

                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">

                        </td>

                        <td>

                            {{$data->firstItem()+$loop->index}}

                        </td>

                        <td>
                            <?php echo $v->title; ?>

                        </td>


                        <td>

                            {{!empty($v->user) ? $v->user->name : ''}}

                        </td>

                        @include('components.order',['module' => $module])



                        <td>

                            @if($v->created_at)

                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}

                            @endif

                        </td>


                        <td class="table-report__action w-56">

                            <div class="flex justify-center items-center">

                                @can('faqs_edit')

                                <a class="flex items-center mr-3" href="{{ route('faqs.edit',['id'=>$v->id]) }}">

                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>

                                    Edit

                                </a>

                                @endcan

                                @can('faqs_destroy')

                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa thương hiệu, thương hiệu sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">

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
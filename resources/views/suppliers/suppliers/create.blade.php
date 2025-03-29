@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới nhà cung cấp</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách nhà cung cấp",
        "src" => route('suppliers.index'),
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
            Thêm mới nhà cung cấp
        </h1>
    </div>
    @include('suppliers.suppliers.form',['action' =>'create'])
</div>
@endsection
@include('address.backend.script')
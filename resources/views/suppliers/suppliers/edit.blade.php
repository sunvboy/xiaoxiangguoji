@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập nhà cung cấp</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách nhà cung cấp",
        "src" => route('suppliers.index'),
    ],
    [
        "title" => "Cập nhập",
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
            Cập nhập nhà cung cấp
        </h1>
    </div>
    @include('suppliers.suppliers.form',['action' =>'update'])
</div>
@endsection
@include('address.backend.script')
@extends('dashboard.layout.dashboard')

@section('title')
<title>Danh sách đầu mối kinh doanh</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đầu mối kinh doanh",
        "src" => route('roles.index'),
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

<div class="p-4 space-y-5 ">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-2">

        </div>
    </div>
    <div id="data_product">
        <div class="relative overflow-x-auto">

        </div>

    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('backend/library/role.js') }}"></script>
@endsection
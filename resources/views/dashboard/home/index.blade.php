@extends('dashboard.layout.dashboard')
<!--Start: title SEO -->
@section('title')
<title>Quản trị website</title>
@endsection
<!--END: title SEO -->
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Dashboard",
        "src" => route('admin.dashboard'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
<!--Start: add javascript only index.html -->
@section('css-dashboard')
@endsection
<!--END: add javascript only index.html -->
<!-- START: main -->
@section('content')
<div class="content">

</div>

@endsection
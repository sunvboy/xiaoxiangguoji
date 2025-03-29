@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($detail->title)!!}
@include('product.frontend.category.data',['module' => 'brands','title' => $detail->title])
@endsection
@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($page->title)!!}
@include('product.frontend.category.data',['module' => 'products','title' => $page->title])
@endsection
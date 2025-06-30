@extends('layouts.frontend')
@section('content')
    @include('frontend.partials.product_card', [
        'categories' => $categories,
        'products' => $products,
    ])
@endsection

@extends('layouts.frontend')
@section('content')
    @include('frontend.partials.banner')
    {{-- @include('frontend.partials.category', ['categories' => $categories]) --}}
    {{-- @include('frontend.partials.newly') --}}
    {{-- @include('frontend.partials.trending') --}}
    @include('frontend.partials.product_card', [
        'categories' => $categories,
        'products' => $products,
    ])
    {{-- @include('frontend.partials.promo')
    @include('frontend.partials.best')
    @include('frontend.partials.discount')
    @include('frontend.partials.popular')
    @include('frontend.partials.arrived')
    @include('frontend.partials.recent_blog')
    @include('frontend.partials.info') --}}
    @include('frontend.partials.other')
@endsection

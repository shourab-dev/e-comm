@extends('layouts.frontendapp')

@section('frontend')

<div class="container mt-5">

    <div class="row">

        <div class="gallImage col-lg-4">

            <img style="width: 100%" src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}">

            @foreach ($product->images as $gallImg)
            <img src="{{ $gallImg->product_url }}" alt="" style="width: 50px">
            @endforeach

        </div>
        <div class="productContent col-lg-8">
            <h1>{{ $product->title }}</h1>
        </div>


    </div>


</div>

@endsection
@extends('layouts.frontendapp')

@section('frontend')
<div class="container">

    @foreach ($categories as $category)
    <section id="{{ $category->slug }}" style="padding: 40px 0">
        <h2>{{ str()->headline($category->title) }}</h2>

        <div class="row">
            @foreach ($category->products as $product)
            <div class="col-lg-3">
                <div class="card px-0">

                    @if (Carbon\Carbon::today() >= $product->start_date && Carbon\Carbon::today() <= $product->end_date)
                        <div class="overlay"
                            style="position: absolute; top:-10px;left:-20px;background:dodgerblue;border-radius:50%;width:40px;height:40px;color:white;text-align:center;line-height:40px;">
                            <span>{{ ($product->discount_price/$product->price) *100 }}%</span>
                        </div>

                        @endif

                        <img class="card-img-top" src="{{ $product->thumbnail_url }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}

                                <span class="float-end" style="font-size: 14px;">
                                    @if ($product->discount_price)
                                    {{ $product->discount_price }}
                                    <span style="text-decoration: line-through">
                                        {{ $product->price }}</span> $

                                    @else
                                    {{ $product->price }} $
                                    @endif

                                </span>

                            </h5>
                            <p class="card-text">
                                {{ $product->short_detail }}
                            </p>
                            <a href="{{ route('product.view', $product->slug) }}" class="btn btn-primary">View
                                Product</a>
                            <a href="{{ route('cart.add', $product->id) }}"
                                class="btn btn-primary {{ $product->status == false ? 'disabled' : '' }}">Cart+</a>
                        </div>
                </div>
            </div>
            @endforeach

        </div>

    </section>
    @endforeach


    <section style="padding: 50px 0;">
        <h1>Random Products</h1>
        <div class="row">
            @foreach ($products as $product)
            <div class="col-lg-3">
                <div class="card px-0">
                    <img class="card-img-top" src="{{ $product->thumbnail_url }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">
                            {{ $product->short_detail }}
                        </p>
                        <a href="#" class="btn btn-primary">View Product</a>
                        <a href="#" class="btn btn-primary ">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach
            <span>
                {{ $products->links() }}
            </span>
        </div>

    </section>



</div>
@endsection
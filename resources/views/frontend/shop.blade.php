@extends('layouts.frontendapp')

@section('frontend')


<div class="container-fluid mt-5">


    <div class="row">

        <aside class="col-lg-4 sidebar">

            <form action="{{ route('shop.product') }}" method="get">
                @csrf
                <div class="flex">
                    <input type="text" class="form-control" name="startPrice" placeholder="Staring Price">
                    <input type="text" class="form-control" placeholder="Ending Price" name="endPrice">
                </div>

                <div class="row my-3">
                    @foreach ($categories as $category)

                    <a href="{{ route('shop.product', $category->id) }}" class="bg-primary m-2 badge col-2">{{
                        $category->title }}</a>
                    @foreach ($category->subCategory as $subcategory)

                    <a href="{{ route('shop.product', $subcategory->id) }}" class="bg-primary m-2 badge col-2">{{
                        $subcategory->title }}</a>
                    @endforeach



                    @endforeach
                </div>

                <label for="" class="w-100">
                    <select name="sorting" class="form-control">
                        <option value="price,asc">Price Low</option>
                        <option value="price,desc">Price High</option>
                        <option value="created_at,desc">New Product </option>
                        <option value="created_at,asc">Old Product </option>
                    </select>
                </label>
                <br><br>
                <button type="submit" class="btn btn-primary">Filter Now</button>


            </form>


        </aside>

        <div class="col-lg-8">

            <div class="row">

                @foreach ($products as $product)


                <div class="col-lg-4">
                    <div class="card px-0">

                        @if (Carbon\Carbon::today() >= $product->start_date && Carbon\Carbon::today() <= $product->
                            end_date)
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
                                <a href="#" class="btn btn-primary">Buy Now</a>
                            </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>


    </div>


</div>



@endsection
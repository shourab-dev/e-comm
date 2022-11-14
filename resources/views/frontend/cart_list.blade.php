@extends('layouts.frontendapp')
@section('frontend')

<div class="container mt-5">
    <h2>All Cart Items</h2>


    <table class="table table-responsive">
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Product Quantity</th>
            <th>Product Price</th>
        </tr>
        @foreach ($carts as $key=>$cart)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $cart->products->title }}</td>
            <td>{{ $cart->quantity }}</td>
            <td>{{ $cart->products->discount_price ?? $cart->products->price }}</td>
        </tr>

        @php
        $totalPrice += ($cart->products->discount_price ?? $cart->products->price)*$cart->quantity;
        @endphp
        @endforeach

        <tr class="text-center">
            <td colspan="2">Total Price</td>
            <td colspan="2"><strong>{{ $totalPrice }} tk</strong> &nbsp;&nbsp;&nbsp;&nbsp; <a href="{{ route('auth.checkout') }}" class="btn btn-success">CheckOut</a></td>
        </tr>

    </table>


</div>


@endsection
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="text-uppercase">Invoice</h1>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Billed:</span><span
                                class="ml-1">{{ $billingName }}</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Date:</span><span
                                class="ml-1">{{ $date }}</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Order ID:</span><span
                                class="ml-1">{{ $orderId }}</span></div>
                    </div>

                </div>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedProducts as $cart)
                                <tr>
                                    <td>{{ $cart->products->title }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ $cart->products->discount_price ?? $cart->products->price }} tk</td>
                                    <td>{{ ($cart->products->discount_price ?? $cart->products->price) * $cart->quantity
                                        }} tk</td>
                                </tr>
                                @php
                               
                                $totalPrice += ($cart->products->discount_price ?? $cart->products->price)*$cart->quantity;
                                @endphp
                                @endforeach

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
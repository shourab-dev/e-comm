<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Mail\Invoice;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function checkout()
    {





        $faker = Faker::create();
        $orderNum = 'order-' . $faker->lexify('???') . $faker->numberBetween(10000, 500000);
        $totalPrice = 0;
        $order  =  Order::create([
            'invoice_id' => $orderNum,
            'user_id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'address' => $faker->address(),
            'note' => $faker->sentence(2),
        ]);

        //*CART PRODUCTS FETCH
        $selectedProducts = Cart::with('products')->where('user_id', auth()->user()->id)->get();

        foreach ($selectedProducts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->products->id,
                'price' => $cart->products->discount_price ?? $cart->products->price,
                'quantity' => $cart->quantity,
            ]);
            $totalPrice += ($cart->products->discount_price ?? $cart->products->price) * $cart->quantity;
        }

        //*UPDATE TOTAL
        $totalUpdate = Order::find($order->id);
        $totalUpdate->totals = $totalPrice;
        $totalUpdate->save();


        //*PDF VIEW
        $billingName = auth()->user()->name;
        $date = Carbon::today()->format('M d, Y');
        $orderId = $orderNum;
        $totalPrice = 0;
        $pdf = Pdf::loadView('pdf.invoice', compact('billingName', 'date', 'orderId', 'selectedProducts', 'totalPrice'));


        //*MAIL SEND
        Mail::to(auth()->user()->email)->send(new Invoice(auth()->user()->name, $pdf->output()));

        foreach ($selectedProducts as $cart) {
            $cart->delete();
        }

        return redirect()->route('cart.list');
    }
}

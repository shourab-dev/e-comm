<?php

namespace App\Http\Controllers\frontend;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart($id)
    {
        if (Auth::check()) {


            if (Cart::where('user_id', auth()->user()->id)->where('product_id', $id)->exists()) {
                Cart::where('user_id', auth()->user()->id)->where('product_id', $id)->first()->increment('quantity');
            } else {
                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->product_id = $id;
                $cart->quantity = 1;
                $cart->save();
            }
            return back();
        } else {
            return  redirect()->route('user.login');
        }
    }

    public function cartLists()
    {
        $carts = Cart::with('products')->where('user_id', auth()->user()->id)->get();
        // dd($carts);
        $totalPrice = 0;
        return view('frontend.cart_list', compact('carts', 'totalPrice'));
    }
}

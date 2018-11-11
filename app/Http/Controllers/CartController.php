<?php

namespace App\Http\Controllers;

use App\Product;
use App\Shopping\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = new Cart();
        return view('cart.index', [ 'cart' => $cart ]);
    }

    public function update(Product $product)
    {
        $cart = new Cart();
        $cart->add($product, $product->getKey());
        return redirect('/cart');
    }
}

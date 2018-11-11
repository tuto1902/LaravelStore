<?php

namespace App\Shopping;

class Cart {

    public $items;

    public function __construct()
    {
        $this->items = collect();

        if(session()->has('cart')){
            $this->items = session('cart')->items;
        }
    }

    public function add($product, $key)
    {
        $cartItem = $this->items->get($key);
        if (!$cartItem) {
            $cartItem = new CartItem($product);
        }

        $this->items->put($key, $cartItem);

        session()->put('cart', $this);

    }

    public function totalPrice()
    {
        $totalPrice = $this->items->reduce(function ($total, $cartItem) {
            return $total + $cartItem->product->price;
        });

        return number_format($totalPrice / 100, 2);
    }

    public function getTotal()
    {
        return $totalPrice = $this->items->reduce(function ($total, $cartItem) {
            return $total + $cartItem->product->price;
        });
    }

    public function hasItem($key)
    {
        return $this->items->has($key);
    }

    public function destroy()
    {
        $this->items = collect();
        session()->forget('cart');
    }
}
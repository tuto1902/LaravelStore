<?php


namespace App\Shopping;


class CartItem
{
    public function __construct($product, $quantity = 0)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price');
    }

    public function addProducts($cartItems)
    {
        foreach ($cartItems as $item) {
            $this->products()->attach($item->product->getKey(), ['price' => $item->product->price]);
        }
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function totalPrice()
    {
        return number_format($this->getTotal() / 100, 2);
    }
}

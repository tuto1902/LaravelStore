<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function getPrice()
    {
        if ($this->pivot) {
            return number_format($this->pivot->price / 100, 2);
        }
        return number_format($this->price / 100, 2);
    }
}

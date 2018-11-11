<?php

namespace Tests\Unit;

use App\Product;
use App\Shopping\CartItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartItemTest extends TestCase
{
    /**
    * @test
    */
    public function it_has_a_product ()
    {
        $product = factory(Product::class)->make();

        $cartItem = new CartItem($product);

        $this->assertEquals($product, $cartItem->product);
    }

    /**
    * @test
    */
    public function it_has_a_quantity_of_zero_by_default ()
    {
        $product = factory(Product::class)->make();

        $cartItem = new CartItem($product);

        $this->assertEquals(0, $cartItem->quantity);
    }
}

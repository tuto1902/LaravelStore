<?php

namespace Tests\Unit;

use App\Product;
use App\Shopping\Cart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_add_items_to_the_cart ()
    {
        $product = factory(Product::class)->make();
        $cart = new Cart();

        $cart->add($product, 'product-key');

        $this->assertEquals(1, $cart->items->count());
    }

    /**
    * @test
    */
    public function it_cannot_add_products_with_the_same_key_twice ()
    {
        $product = factory(Product::class)->make();
        $cart = new Cart();

        $cart->add($product, 'product-key');
        $cart->add($product, 'product-key');

        $this->assertEquals(1, $cart->items->count());
    }

    /**
    * @test
    */
    public function it_has_a_total_cart_price ()
    {
        $products = factory(Product::class,3)->make();
        $cart = new Cart();

        foreach($products as $index => $product) {
            $cart->add($product, 'product-' . $index);
        }

        $totalPrice = $products->reduce(function ($total, $product) {
            return $total + $product->price;
        });

        $formattedTotalPrice = number_format($totalPrice / 100, 2);

        $this->assertEquals($formattedTotalPrice, $cart->totalPrice());
    }

    /**
    * @test
    */
    public function it_returns_true_if_the_product_is_already_in_cart ()
    {
        $product = factory(Product::class)->make();
        $cart = new Cart();

        $cart->add($product, '1');

        $this->assertTrue($cart->hasItem('1'));
    }

    /**
    * @test
    */
    public function it_destroys_the_cart_items_and_removes_cart_from_session ()
    {
        $product = factory(Product::class)->make();
        $cart = new Cart();
        $cart->add($product, 'product-key');

        $cart->destroy();

        $this->assertTrue($cart->items->isEmpty());
        $this->assertEmpty(session('cart'));
    }
}

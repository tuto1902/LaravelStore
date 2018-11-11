<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Shopping\Cart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
    * @test
    */
    public function it_can_add_products_to_the_order ()
    {

        $product = factory(Product::class)->create();
        $cart = new Cart();
        $cart->add($product, $product->getKey());
        $order = factory(Order::class)->create();

        $order->addProducts($cart->items);

        $this->assertNotEmpty($order->products);
        $this->assertEquals(1, $order->products->count());
    }

    /**
     * @test
     */
    public function it_has_a_total_order_price()
    {
        $order = factory(Order::class)->create([
            'total' => 1099
        ]);

        $this->assertEquals(1099, $order->getTotal());
    }

    /**
     * @test
     */
    public function it_has_a_total_order_price_formatted ()
    {
        $order = factory(Order::class)->create([
            'total' => 1099
        ]);

        $this->assertEquals('10.99', $order->totalPrice());
    }

    /**
    * @test
    */
    public function it_saves_product_prices_in_the_order ()
    {
        $product = factory(Product::class)->create(['price' => 1099]);
        $cart = new Cart();
        $cart->add($product, $product->getKey());
        $order = factory(Order::class)->create();
        $order->addProducts($cart->items);
        $product->update([
            'price' => 2999
        ]);

        $orderProduct = $order->products->first();

        $this->assertEquals('10.99', $orderProduct->getPrice());
    }
}

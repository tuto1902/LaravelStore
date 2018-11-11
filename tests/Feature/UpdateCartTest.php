<?php

namespace Tests\Feature;

use App\Product;
use App\Shopping\Cart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCartTest extends TestCase
{
   use RefreshDatabase;

   /**
   * @test
   */
   public function it_can_add_a_product_to_the_cart ()
   {
       $product = factory(Product::class)->create();

       $response = $this->put('/cart/' . $product->getKey());

       $response->assertRedirect('/cart');
       $response->assertSessionHas('cart');

       $cart = session('cart');
       $this->assertEquals(1, $cart->items->count());

       $this->get('/cart')
           ->assertSee($product->name)
           ->assertSee($product->getPrice())
           ->assertSee($cart->totalPrice());
   }
}

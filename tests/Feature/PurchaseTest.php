<?php

namespace Tests\Feature;

use App\Contracts\PaymentContract;
use App\Order;
use App\Product;
use App\Services\FakePayment;
use App\Shopping\Cart;
use App\User;
use Laravel\Tinker\ClassAliasAutoloader;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function it_can_create_orders_after_purchase ()
    {
        $product = factory(Product::class)->create();
        $cart = new Cart();
        $cart->add($product, $product->getKey());

        $payment = new FakePayment();
        $this->app->instance(PaymentContract::class, $payment);

        $this->post('/orders', [
            'stripeEmail' => 'test@email.com',
            'stripeToken' => $payment->getTestToken()
        ]);

        $order = Order::where('email', 'test@email.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals($cart->items->count(), $order->products->count());
    }

    /**
    * @test
    */
    public function it_shows_order_details_after_purchase ()
    {
        $products = factory(Product::class, 3)->create();
        $cart = new Cart();
        foreach ($products as $product) {
            $cart->add($product, $product->getKey());
        }

        $payment = new FakePayment();
        $this->app->instance(PaymentContract::class, $payment);

        $response = $this->post('/orders', [
            'stripeEmail' => 'test@email.com',
            'stripeToken' => $payment->getTestToken()
        ]);

        $order = Order::where('email', 'test@email.com')->first();

        $response->assertRedirect('/orders/' . $order->getKey());

        $response = $this->get('/orders/' . $order->getKey());

        foreach ($products as $product) {
            $response
                ->assertSee($product->name)
                ->assertSee($product->getPrice());
        }

        $response->assertSee($order->totalPrice());
    }

    /**
    * @test
    */
    public function it_charges_customer_on_purchase ()
    {
        $product = factory(Product::class)->create();
        $cart = new Cart();
        $cart->add($product, $product->getKey());

        $payment = new FakePayment();
        $this->app->instance(PaymentContract::class, $payment);

        $this->post('/orders', [
            'stripeEmail' => 'test@email.com',
            'stripeToken' => $payment->getTestToken()
        ]);

        $this->assertEquals($cart->getTotal(), $payment->totalCharged());
    }
    
    /**
    * @test
    */
    public function it_does_not_create_an_order_if_the_purchase_fails ()
    {
        $product = factory(Product::class)->create();
        $cart = new Cart();
        $cart->add($product, $product->getKey());

        $payment = new FakePayment();
        $this->app->instance(PaymentContract::class, $payment);

        $response = $this->post('/orders', [
            'stripeEmail' => 'test@email.com',
            'stripeToken' => 'invalid-token'
        ]);

        $response->assertSessionHasErrors('payment_token');

        $order = Order::where('email', 'test@email.com')->first();
        $this->assertNull($order);
    }

    /**
    * @test
    */
    public function it_destroys_the_cart_after_purchase ()
    {
        $products = factory(Product::class, 3)->create();
        $cart = new Cart();
        foreach ($products as $product) {
            $cart->add($product, $product->getKey());
        }

        $payment = new FakePayment();
        $this->app->instance(PaymentContract::class, $payment);

        $this->post('/orders', [
            'stripeEmail' => 'test@email.com',
            'stripeToken' => $payment->getTestToken()
        ]);

        $cart = new Cart();
        $this->assertTrue($cart->items->isEmpty());
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentContract;
use App\Exceptions\ChargeFailedException;
use App\Order;
use App\Shopping\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class OrdersController extends Controller
{
    private $payment;

    public function __construct(PaymentContract $payment)
    {
        $this->payment = $payment;
    }

    public function store()
    {
        $cart = new Cart();
        try {
            // Charge the user with the cart total amount
            $this->payment->charge($cart->getTotal(), request('stripeToken'));
            // Create a new order for the logged in user
            $order = Order::create([
                'email' => request('stripeEmail'),
                'total' => $cart->getTotal()
            ]);
            // Add products to the order
            $order->addProducts($cart->items);
            // Destroy the cart
            $cart->destroy();
            return redirect('/orders/' . $order->getKey());
        } catch (ChargeFailedException $e) {
            $errors = new MessageBag([
                'payment_token' => 'The payment token is not valid'
            ]);
            return redirect()->back()->withErrors($errors);
        }
    }

    public function show(Order $order)
    {
        return view('orders.show', [ 'order' => $order ]);
    }
}

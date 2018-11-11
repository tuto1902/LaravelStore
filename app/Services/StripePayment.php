<?php


namespace App\Services;


use App\Contracts\PaymentContract;
use Stripe\Charge;

class StripePayment implements PaymentContract
{

    public function charge($amount, $token)
    {
        Charge::create(array(
            "amount" => $amount,
            "currency" => "usd",
            "source" => $token,
        ), ['api_key' => config('services.stripe.secret') ]);
    }
}
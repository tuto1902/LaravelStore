<?php

namespace Tests\Unit;

use App\Services\StripePayment;
use Stripe\Charge;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Stripe;
use Stripe\Token;

class StripePaymentTest extends TestCase
{
    private $lastCharge;

    public function setUp()
    {
        parent::setUp();
        $this->lastCharge = $this->lastCharge();
    }

    /**
     * @test
     */
    public function it_can_make_real_charges_with_a_valid_token()
    {
        $payment = new StripePayment();

        $token = Token::create([
            "card" => [
                "number"    => "4242424242424242",
                "exp_month" => 1,
                "exp_year"  => date('Y') + 1,
                "cvc"       => "123"
            ]
        ], [ 'api_key' => config('services.stripe.secret') ])->id;

        $payment->charge(1099, $token);

        $this->assertCount(1, $this->newCharges());
        $this->assertEquals(1099, $this->lastCharge()->amount);
    }

    public function lastCharge()
    {
        return Charge::all(["limit" => 1], [ 'api_key' => config('services.stripe.secret') ])->data[0];
    }

    public function newCharges()
    {
        return Charge::all([
            "limit" => 1,
            'ending_before' => $this->lastCharge->id
        ], [ 'api_key' => config('services.stripe.secret') ])->data;
    }
}

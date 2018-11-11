<?php

namespace Tests\Unit;

use App\Exceptions\ChargeFailedException;
use App\Services\FakePayment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FakePaymentTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_make_charges_with_a_valid_token ()
    {
        $payment = new FakePayment();

        $payment->charge(1099, $payment->getTestToken());

        $this->assertEquals(1099, $payment->totalCharged());
    }

    /**
    * @test
    */
    public function it_throws_an_exception_with_an_invalid_token ()
    {
        $payment = new FakePayment();

        try {
            $payment->charge(1099, 'invalid-token');
        } catch (ChargeFailedException $e) {
            return $this->assertTrue(true);
        }

        $this->fail();
    }
}

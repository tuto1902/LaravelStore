<?php


namespace App\Services;


use App\Contracts\PaymentContract;
use App\Exceptions\ChargeFailedException;

class FakePayment implements PaymentContract
{
    private $total;

    public function getTestToken()
    {
        return 'test_token';
    }

    public function charge($total, $token)
    {
        if ($token !== $this->getTestToken()){
            throw new ChargeFailedException();
        }
        $this->total = $total;
    }

    public function totalCharged()
    {
        return $this->total;
    }
}
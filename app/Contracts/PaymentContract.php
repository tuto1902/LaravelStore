<?php


namespace App\Contracts;


interface PaymentContract
{
    public function charge($amount, $token);
}
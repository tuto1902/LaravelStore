<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_get_the_formatted_price ()
    {
        $product = factory(Product::class)->make([
            'price' => 1099
        ]);

        $price = $product->getPrice();

        $this->assertEquals('10.99', $price);
    }
}

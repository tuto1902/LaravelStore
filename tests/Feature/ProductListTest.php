<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_can_display_the_list_of_products()
    {
        $products = factory(Product::class, 3)->create();

        $response = $this->get('/products');

        foreach ($products as $product) {
            $response
                ->assertSee($product->name)
                ->assertSee($product->getPrice());
        }
    }
}

<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_can_display_the_product_details()
    {
        $product = factory(Product::class)->create();

        $response = $this->get('/products/' . $product->getKey());
        $response
            ->assertSuccessful()
            ->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee($product->getPrice());
    }
}

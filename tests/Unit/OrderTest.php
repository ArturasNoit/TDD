<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;
use App\Order;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_order_consist_of_products()
    {
    	$order = new Order;

    	$product1 = new Product('Fallout 4', 59);
    	$product2 = new Product('Pillow', 16);

    	$order->add($product1);
    	$order->add($product2);

    	// $this->assertEquals(2, count($order->products()));
    	$this->assertCount(2, $order->products());
    }

    /** @test */
    public function an_order_can_determine_the_total_cost_of_all_its_products()
    {
    	$order = new Order;

    	$product1 = new Product('Fallout 4', 59);
    	$product2 = new Product('Pillow', 16);

    	$order->add($product1);
    	$order->add($product2);

    	$this->assertEquals(75, $order->total());
    }
}

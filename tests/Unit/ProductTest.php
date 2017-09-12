<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $product;

    public function setUp(){

    	$this->product = new Product('Fallout 4',59);
    }


    public function testAProductHasAName(){
    	// $product = new Product('Fallout 4', 59);

    	$this->assertEquals('Fallout 4', $this->product->name());
    }

    public function testAProductHasAPrice(){

    	$this->assertEquals(59, $this->product->cost());

    }
}

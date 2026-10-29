<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_reduces_product_stock_by_the_ordered_quantity(): void
    {
        $client = Client::factory()->create();
        $product = Product::factory()->create(['price' => 12.50, 'stock' => 10]);

        $this->post('/orders', ['client_id' => $client->id, 'product_id' => $product->id, 'quantity' => 3])
            ->assertRedirect('/orders');

        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 7]);
        $this->assertDatabaseHas('orders', ['client_id' => $client->id, 'product_id' => $product->id, 'quantity' => 3, 'total' => '37.50']);
    }

    public function test_order_above_available_stock_is_rejected_without_creating_an_order(): void
    {
        $client = Client::factory()->create();
        $product = Product::factory()->create(['stock' => 2]);

        $this->from('/orders/create')->post('/orders', ['client_id' => $client->id, 'product_id' => $product->id, 'quantity' => 3])
            ->assertSessionHasErrors('quantity');

        $this->assertSame(0, Order::count());
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 2]);
    }
}

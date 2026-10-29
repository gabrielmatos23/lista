<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAndClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created_updated_and_deleted(): void
    {
        $data = ['name' => 'Torta de limão', 'category' => 'Bolos', 'price' => 45.90, 'stock' => 8, 'minimum_stock' => 2];
        $this->post('/products', $data)->assertRedirect('/products');
        $product = Product::where('name', 'Torta de limão')->firstOrFail();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 8]);

        $this->put("/products/{$product->id}", [...$data, 'price' => 49.90])->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['id' => $product->id, 'price' => '49.90']);
        $this->delete("/products/{$product->id}")->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_requires_a_name_and_valid_price(): void
    {
        $this->from('/products/create')->post('/products', [
            'name' => '', 'category' => 'Bolos', 'price' => -1, 'stock' => 0, 'minimum_stock' => 0,
        ])->assertSessionHasErrors(['name', 'price']);
    }

    public function test_client_can_be_created_updated_and_deleted(): void
    {
        $this->post('/clients', ['name' => 'Ana Lima', 'email' => 'ana@example.test', 'phone' => '11999990000', 'address' => 'Rua do Açúcar, 10'])
            ->assertRedirect('/clients');
        $client = Client::where('email', 'ana@example.test')->firstOrFail();
        $this->put("/clients/{$client->id}", ['name' => 'Ana Lima Silva', 'email' => 'ana@example.test', 'phone' => '11999990000', 'address' => 'Rua do Açúcar, 20'])
            ->assertRedirect('/clients');
        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Ana Lima Silva']);
        $this->delete("/clients/{$client->id}")->assertRedirect('/clients');
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}

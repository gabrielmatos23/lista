<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->create(['name' => 'Bolo de cenoura', 'category' => 'Bolos', 'price' => 38.00, 'stock' => 12, 'minimum_stock' => 4]);
        Product::factory()->create(['name' => 'Brigadeiro artesanal', 'category' => 'Doces', 'price' => 4.50, 'stock' => 30, 'minimum_stock' => 8]);
        Product::factory()->count(13)->create();
        Client::factory()->create(['name' => 'Mariana Costa', 'email' => 'mariana@example.com', 'phone' => '(11) 99999-1234', 'address' => 'Rua das Flores, 120']);
        Client::factory()->count(5)->create();
    }
}

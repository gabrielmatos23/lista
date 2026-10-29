<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()->assertSee('Doce Gestão');
    }

    public function test_module_listings_are_available_and_unknown_route_is_not_found(): void
    {
        $this->get('/products')->assertOk()->assertSee('Produtos');
        $this->get('/clients')->assertOk()->assertSee('Clientes');
        $this->get('/orders')->assertOk()->assertSee('Pedidos');
        $this->get('/freights')->assertOk()->assertSee('Fretes');
        $this->get('/rota-que-nao-existe')->assertNotFound();
    }
}

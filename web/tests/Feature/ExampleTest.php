<?php

namespace Tests\Feature;

// Historia: H-01. Acceso público sin migraciones ni escrituras de datos.
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/ingresar');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/login',['email' => 'backend@multisyscorp.com', 'password' => 'test123']);
        $response->assertStatus(201);

        $response = $this->post('/login',['email' => 'backend@multisyscorp.com', 'password' => '123456']);
        $response->assertStatus(401);
    }
}

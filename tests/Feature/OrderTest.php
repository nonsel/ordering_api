<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //LOGIN AND GET TOKEN
        $login_response = $this->post('/login',['email' => 'backend@multisyscorp.com', 'password' => 'test123']);
        $access_token = $login_response->decodeResponseJson()['access_token'];


        //ORDER SUCCESS
        $order_response = $this->withHeaders([
            'HTTP_Authorization' => 'Bearer '.$access_token
        ])->post('/order',['product_id' => 1, 'quantity' => 1]);
        $order_response->assertStatus(201);

        //ORDER NOT ENOUGH STOCK
        $order_response = $this->withHeaders([
            'HTTP_Authorization' => 'Bearer '.$access_token
        ])->post('/order',['product_id' => 1, 'quantity' => 999]);
        $order_response->assertStatus(400);  
    }
}

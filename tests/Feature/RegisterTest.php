<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //DELETE backend@multisyscorp.com to avoid email is already taken.
        $user = User::where('email','backend@multisyscorp.com');
        $user->delete();

        $response = $this->post('/register',['email' => 'backend@multisyscorp.com', 'password' => 'test123']);
        $response->assertStatus(201);

        $response = $this->post('/register',['email' => 'backend@multisyscorp.com', 'password' => 'test123']);
        $response->assertStatus(400);

    }
}

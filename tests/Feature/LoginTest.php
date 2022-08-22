<?php

namespace Tests\Feature;

use App\Models\User\User;
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
    public function test_login()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);
        $response = $this->post('/login', ['email' => 'test@test.com', 'password' => 'password']);

        $response->assertStatus(302);
    }
}

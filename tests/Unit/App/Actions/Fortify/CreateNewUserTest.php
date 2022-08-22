<?php

namespace Tests\Unit\Actions\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $user = $this->post('/register', [
            'name' => "Test User",
            'email' => "test@test.com",
            'password' => '0000',
            'password_confirmation' => '0000'
        ]);

        $user = User::create([
            'name' => "Test User",
            'email' => 'test@test.com',
            'password' => Hash::make('0000')
        ]);

        $this->assertDatabaseCount('users', 1);

    }

    public function testCreateNotValidate()
    {
        return $this->post('/register', [
            'name' => "Test User",
            'email' => "test",
            'password' => '0000',
            'password_confirmation' => '0000'
        ])->assertStatus(302);
    }
}

<?php

namespace Actions\Fortify;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{

    public function testResetPasswordRequest()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);
        $this->post('/forgot-password', [
            'email' => 'test@test.com'
        ])->assertStatus(302);
    }

    public function testResetPassword()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);

        $this->post('/reset-password', [
            'email' => 'test@test.com',
            'password' => '0000',
            'password_confirmation' => '0000'
        ])->assertStatus(302);
    }
}

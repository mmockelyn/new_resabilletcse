<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use RefreshDatabase;


    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Test Case')
                    ->type('email', 'test@test.com')
                    ->type('password', '0000')
                    ->type('password_confirmation', '0000')
                    ->press('Valider')
                    ->assertPathIs('/');
        });
    }
}

<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    use DatabaseMigrations;
    use RefreshDatabase;
    public function testExample(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->assertSee('Sign Up Here')
            ->type('login', 'uwambadodo@gmail.com')
                    ->type('password', 'Admin@123')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }
}

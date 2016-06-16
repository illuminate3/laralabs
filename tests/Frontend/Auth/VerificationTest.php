<?php

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VerificationTest extends TestCase
{
    use DatabaseMigrations;

    

    /**
     * When configuration says that verification is enabled, do not allow unverified users to log in
     */
    public function testCreateUnverifiedUser()
    {
        factory(User::class)->create([
            'name' => 'Abigail',
            'email' => 'Abigail',
            'password' => 'Abigail',
        ]);

        $this
            ->visit('/login')
            ->type('test@example.com', 'email')
            ->type('testtest', 'password')
            ->press('Login')
            ->seePageIs('/login');
    }
        
}


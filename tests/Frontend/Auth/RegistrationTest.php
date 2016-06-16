<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     */
    public function test_RegistrationPageOk()
    {
        $this
            ->visit(route('frontend.auth.register.form'))
            ->seeStatusCode(200);
    }

    /**
     *
     */
    public function test_ShortPasswordNotAccepted()
    {
        //--------------------------------------------------------
        // 1.

        $this
            ->visit(route('frontend.auth.register.form'))
            ->type('Test', 'name')
            ->type('test@example.com', 'email')
            ->type('123', 'password')
            ->type('123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password must be at least');

        $this->assertFalse(
            $this->getUserRepository()->findByEmail('test@example.com'),
            "User has not been created");
    }

    /**
     *
     */
    public function test_UserProperlyCreated_WithVerificationEnabled()
    {
        $this->setAccountVerificationEnabled(true);

        //--------------------------------------------------------
        // We expect the UserCreatedEvent

        $this->expectsEvents(\App\Events\Auth\UserCreatedEvent::class);

        $this
            ->visit(route('frontend.auth.register.form'))
            ->type('Test', 'name')
            ->type('test@example.com', 'email')
            ->type('123123', 'password')
            ->type('123123', 'password_confirmation')
            ->press('Register');
        
        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs('/')
            ->see(trans('auth.registration.needs_verification'));

        //--------------------------------------------------------
        // Event fired

        $this->expectsEvents(UserRegistered::class);

        $user = $this->getUserRepository()->findByEmail('test@example.com');

        $this->assertNotNull(
            $user,
            "User has been created");

        $this->assertFalse(
            $user->verified,
            'User is not verified');
        $this->assertEquals(
            'Test', $user->name,
            'Name is properly set');
        $this->assertEquals(
            'test@example.com', $user->email,
            'Email is properly set');

    }

    /**
     *
     */
    public function test_UserProperlyCreated_WithVerificationDisabled()
    {
        $this->setAccountVerificationEnabled(false);
        $this->app['config']->set('auth.verification.enabled', false);

        //--------------------------------------------------------
        // We expect the UserCreatedEvent

        $this->expectsEvents(\App\Events\Auth\UserCreatedEvent::class);

        $this
            ->visit(route('frontend.auth.register.form'))
            ->type('Test', 'name')
            ->type('test@example.com', 'email')
            ->type('123123', 'password')
            ->type('123123', 'password_confirmation')
            ->press('Register');

        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs('/')
            ->see(trans('auth.registration.complete'));

        //--------------------------------------------------------
        // Proper user creation

        $user = $this->getUserRepository()->findByEmail('test@example.com');

        $this->assertNotNull(
            $user,
            "User has been created");

        $this->assertTrue(
            $user->verified,
            'User is verified');
        $this->assertEquals(
            'Test', $user->name,
            'Name is properly set');
        $this->assertEquals(
            'test@example.com', $user->email,
            'Email is properly set');
    }

}


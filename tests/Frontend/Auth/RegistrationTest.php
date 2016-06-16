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
        $this->submitRegistrationForm('Test', 'test@example.com', '123');

        $this
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

        $this->submitRegistrationForm();

        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs(route('frontend.home'))
            ->see(trans('auth.registration.needs_verification'));

        //--------------------------------------------------------
        // Event fired

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

        $this->submitRegistrationForm();

        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs(route('frontend.home'))
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

    /**
     * @param string      $name
     * @param string      $email
     * @param string      $password
     * @param string|null $passwordConfirmation
     *
     * @return $this
     */
    protected function submitRegistrationForm(
        $name = 'Test',
        $email = 'test@example.com',
        $password = 'password',
        $passwordConfirmation = null)
    {
        return $this
            ->visit(route('frontend.auth.register.form'))
            ->type($name, 'name')
            ->type($email, 'email')
            ->type($password, 'password')
            ->type($passwordConfirmation == null ? $password : $passwordConfirmation, 'password_confirmation')
            ->press('Register');
    }

}


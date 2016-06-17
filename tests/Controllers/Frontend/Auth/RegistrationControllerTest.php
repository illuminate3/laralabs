<?php

use App\Events\Auth\UserRegisteredEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Prettus\Repository\Events\RepositoryEntityCreated;

class RegistrationControllerTest extends TestCase
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
    public function test_EventsAreSent_OnRegistration()
    {
        $this->expectsEvents([RepositoryEntityCreated::class, UserRegisteredEvent::class]);
        $this->submitRegistrationForm();
    }

    /**
     *
     */
    public function test_CannotRegisterExistingAddress()
    {
        $this->submitRegistrationForm();
        $this->submitRegistrationForm('Test', 'test@example.com');

        $this
            ->seePageIs('/register')
            ->see('The email has already been taken');

        $this->assertEquals(
            1,
            $this->getUserRepository()->findByField('email', 'test@example.com')->count(),
            "There are more than 1 user with that email address");
    }

    /**
     * @dataProvider insecurePasswordProvider
     *
     * @param string $password The password to test
     */
    public function test_CannotRegisterInsecurePassword($password)
    {
        $this->submitRegistrationForm('Test', 'test@example.com', $password);

        $this
            ->seePageIs('/register')
            ->see('The password must be at least');

        $this->assertNull(
            $this->getUserRepository()->findByField('email', 'test@example.com')->first(),
            "User has not been created");
    }

    public function insecurePasswordProvider()
    {
        return [
            'too short' => ['12345']
        ];
    }

    /**
     *
     */
    public function test_UserProperlyCreated_WithVerificationEnabled()
    {
        $this->setAccountVerificationEnabled(true);

        $this->submitRegistrationForm();

        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs(route('frontend.home'))
            ->see(trans('auth.registration.needs_verification'));

        //--------------------------------------------------------
        // User properties

        $user = $this->getUserRepository()->findByField('email', 'test@example.com')->first();

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

        $this->submitRegistrationForm();

        //--------------------------------------------------------
        // Proper redirection & message

        $this
            ->seePageIs(route('frontend.home'))
            ->see(trans('auth.registration.complete'));

        //--------------------------------------------------------
        // Proper user creation

        $user = $this->getUserRepository()->findByField('email', 'test@example.com')->first();

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
            ->press(trans('general.action.register'));
    }

}


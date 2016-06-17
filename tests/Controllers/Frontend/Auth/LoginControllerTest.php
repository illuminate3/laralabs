<?php

use App\Events\Auth\UserAuthenticatedEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @var \App\Repositories\Auth\UserRepositoryContract */
    private $users;

    protected function setUp()
    {
        parent::setUp();
        $this->users = $this->getUserRepository();
    }

    /**
     *
     */
    public function test_LoginPageOk()
    {
        $this
            ->visit(route('frontend.auth.login.form'))
            ->seeStatusCode(200);
    }

    /**
     *
     */
    public function test_Logout()
    {
        $user = $this->users->create(array_merge($this->defaultUserData(), ['verified' => true]));

        $this->be($user);
        $this->assertFalse(Auth::guest(), 'We are not logged in before our logout test');

        $this
            ->visit(route('frontend.auth.logout'))
            ->seePageIs(route('frontend.home'));

        $this->assertTrue(Auth::guest(), 'User not disconnected properly');
    }

    /**
     *
     */
    public function test_InvalidLoginRejected()
    {
        $this->setAccountVerificationEnabled(false);

        $this->withoutEvents();
        $this->users->create($this->defaultUserData());

        $this->submitLoginForm('test@example.com', 'wrong-password');

        $this
            ->seePageIs(route('frontend.auth.login.form'))
            ->see(trans('auth.failed'));
    }

    /**
     * When configuration says that verification is enabled, do not allow unverified users to log in
     */
    public function test_UnverifiedLoginRejected_WhenConfigEnabled()
    {
        $this->setAccountVerificationEnabled(true);
        $this->setUnverifiedLoginEnabled(false);

        $this->withoutEvents();
        $this->users->create($this->defaultUserData());

        $this->submitLoginForm();

        $this
            ->seePageIs(route('frontend.auth.login.form'))
            ->see(trans('auth.unverified'));
    }

    /**
     * Ensure we send an event on login
     */
    public function test_UserAuthenticatedEvent_IsSentOnSuccessfulLogin()
    {
        $this->users->create(array_merge($this->defaultUserData(), ['verified' => true]));

        $this->expectsEvents([UserAuthenticatedEvent::class]);

        $this->submitLoginForm();
    }

    /**
     * When configuration says that verification is enabled BUT unverified login is allowed, allow unverified users to
     * log in
     */
    public function test_UnverifiedLoginAccepted_WhenConfigDisabled()
    {
        $this->setAccountVerificationEnabled(true);
        $this->setUnverifiedLoginEnabled(true);

        $this->withoutEvents();
        $this->users->create($this->defaultUserData());

        $this->submitLoginForm();

        $this->seePageIs(route('frontend.home'));
    }

    /**
     * Get a default user data array
     *
     * @param string $email
     * @param string $password
     * @param string $name
     * @param bool   $verified
     *
     * @return array
     */
    private function defaultUserData($email = 'test@example.com', $password = 'password', $name = 'Test',
        $verified = false)
    {
        return [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'verified' => $verified,
        ];
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return $this
     */
    protected function submitLoginForm(
        $email = 'test@example.com',
        $password = 'password')
    {
        return $this
            ->visit(route('frontend.auth.login.form'))
            ->type($email, 'email')
            ->type($password, 'password')
            ->press(trans('general.action.login'));
    }
}


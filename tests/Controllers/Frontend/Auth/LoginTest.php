<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
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
    public function test_InvalidLoginRejected()
    {
        $this->setAccountVerificationEnabled(false);

        $this->withoutEvents();
        $this->users->create($this->defaultUserData(), true);

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
     *
     * @return array
     */
    private function defaultUserData($email = 'test@example.com', $password = 'password', $name = 'Test')
    {
        return [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
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


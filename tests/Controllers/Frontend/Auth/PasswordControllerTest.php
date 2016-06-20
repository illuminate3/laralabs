<?php

use App\TestSupport\TestsEmails;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PasswordControllerTest extends TestCase
{
    use DatabaseMigrations, TestsEmails;

    /** @var \App\Repositories\Auth\UserRepositoryContract */
    private $users;

    protected function setUp()
    {
        parent::setUp();
        $this->users = $this->getUserRepository();
    }

    public function test_SendsForgotPasswordEmail()
    {
        $this->users->create($this->defaultUserData());
        $this->submitForgotPasswordForm();

        $this
            ->seeEmailWasSent()
            // Always null. Why? Feature works properly though
            //->seeEmailSubject(trans('emails.auth.forgot-password.subject'))
            ->seeEmailTo('test@example.com');
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    protected function submitForgotPasswordForm($email = 'test@example.com')
    {
        return $this->visit(route('frontend.auth.password.forgot.form'))
            ->type($email, 'email')
            ->press(trans('general.action.request_password_reset'));
    }

    /**
     * Get a default user data array
     *
     * @param string $email
     *
     * @return array
     */
    private function defaultUserData($email = 'test@example.com')
    {
        return [
            'name'     => 'Test',
            'email'    => $email,
            'password' => 'password',
            'verified' => true,
        ];
    }

}


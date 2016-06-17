<?php

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PasswordControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @var \App\Repositories\Auth\UserRepositoryContract */
    private $users;

    protected function setUp()
    {
        parent::setUp();
        $this->users = $this->getUserRepository();
    }

    public function test_SendsForgotPasswordEmail()
    {
       Mail::shouldReceive('send')
            ->once()
            ->andReturnUsing(function ($msg)
            {
                $this->assertEquals(trans('emails.auth.forgot-password.subject'), $msg->getSubject());
                $this->assertEquals('test@example.com', $msg->getTo());
            });

        $this->users->create($this->defaultUserData());
        $this->submitForgotPasswordForm();
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
            ->submitForm(trans('general.action.request_password_reset'));
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


<?php

use App\Events\Auth\UserVerifiedEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VerificationControllerTest extends TestCase
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
    public function test_EventsAreSent_OnVerification()
    {
        $user = $this->users->create($this->defaultUserData(false));

        $this->expectsEvents([UserVerifiedEvent::class]);
        $this->submitVerificationForm($user->verification_token, $user->email);
    }

    /**
     * @dataProvider wrongVerificationToken
     */
    public function test_VerificationFails_IfWrongToken($token)
    {
        $user = $this->users->create($this->defaultUserData(false));

        $this->submitVerificationForm($token, $user->email);

        $this->seePageIs(route('frontend.auth.verification.error'));

        $this->assertFalse(
            $this->getUserRepository()->findByField('email', 'test@example.com')->first()->verified,
            "The user has been verified");
    }

    public function wrongVerificationToken()
    {
        return [
            'missing' => [''],
            'invalid' => ['123456'],
        ];
    }

    /**
     * @param string $token
     * @param string $email
     *
     * @return $this
     */
    protected function submitVerificationForm($token, $email = 'test@example.com')
    {
        return $this->visit(route('frontend.auth.verification.form', [
            'token' => $token,
            'email' => $email,
        ]));
    }

    /**
     * Get a default user data array
     *
     * @param bool $verified
     *
     * @return array
     */
    private function defaultUserData($verified)
    {
        return [
            'name'     => 'Test',
            'email'    => 'test@example.com',
            'password' => 'password',
            'verified' => $verified,
        ];
    }

}


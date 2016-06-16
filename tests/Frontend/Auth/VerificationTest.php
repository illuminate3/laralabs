<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class VerificationTest extends TestCase
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
    public function test_NewUserNotVerified_WhenVerificationEnabled_FromRepository()
    {
        $this->setVerificationEnabled(true);

        //--------------------------------------------------------
        // 1.

        $user = $this->users->create($this->defaultUserData());

        $this->assertFalse(
            $user->verified,
            'New user should not be verified when verification is ON');

        $this->assertNotEmpty(
            $user->verification_token,
            'A verification token should be generated when verification is ON');

        //--------------------------------------------------------
        // 2.

        $user = $this->users->create($this->defaultUserData('test2@example.com'), true);

        $this->assertTrue(
            $user->verified,
            'New user should be verified when verification is ON and we force it');
    }

    /**
     *
     */
    public function test_NewUserVerified_WhenVerificationDisabled_FromRepository()
    {
        $this->setVerificationEnabled(false);

        //--------------------------------------------------------
        // 1.

        $user = $this->users->create($this->defaultUserData());

        $this->assertTrue(
            $user->verified,
            'New user should always be verified when verification is OFF');

        //--------------------------------------------------------
        // 2.

        $user = $this->users->create($this->defaultUserData('test2@example.com'), false);

        $this->assertTrue(
            $user->verified,
            'New user should always be verified when verification is OFF even if we force not to');
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
     * Enable verification in configuration
     *
     * @param bool $isEnabled
     */
    private function setVerificationEnabled($isEnabled)
    {
        Config::set('auth.verification.enabled', $isEnabled);
        $this->assertEquals(config('auth.verification.enabled'), $isEnabled);
    }

    /**
     * Get the UserRepository
     * @return \App\Repositories\Auth\UserRepositoryContract
     */
    private function getUserRepository()
    {
        return $this->app->make(\App\Repositories\Auth\UserRepositoryContract::class);
    }

}


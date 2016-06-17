<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function tearDown() {
        Mockery::close();
    }

    /**
     * Enable verification in configuration
     *
     * @param bool $isEnabled
     */
    protected function setAccountVerificationEnabled($isEnabled)
    {
        Config::set('auth.verification.enabled', $isEnabled);
        $this->assertEquals(config('auth.verification.enabled'), $isEnabled);
    }

    /**
     * Enable unverified user login in configuration
     *
     * @param bool $isEnabled
     */
    protected function setUnverifiedLoginEnabled($isEnabled)
    {
        Config::set('auth.verification.allow_unverified_login', $isEnabled);
        $this->assertEquals(config('auth.verification.allow_unverified_login'), $isEnabled);
    }

    /**
     * Get the UserRepository
     * @return \App\Repositories\Auth\UserRepositoryContract
     */
    protected function getUserRepository()
    {
        return $this->app->make(\App\Repositories\Auth\UserRepositoryContract::class);
    }
}

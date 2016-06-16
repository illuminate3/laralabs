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
     * Get the UserRepository
     * @return \App\Repositories\Auth\UserRepositoryContract
     */
    protected function getUserRepository()
    {
        return $this->app->make(\App\Repositories\Auth\UserRepositoryContract::class);
    }

    /**
     * @return \Mockery\MockInterface
     */
    protected function getMockMailer()
    {
        $mock = \Mockery::mock($this->app['mailer']->getSwiftMailer());
        $this->app['mailer']->setSwiftMailer($mock);

        return $mock;
    }
}

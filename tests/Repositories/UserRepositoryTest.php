<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRepositoryTest extends TestCase
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
    public function test_UserCreatedEventIsFired_OnCreateUser()
    {
        $this->expectsEvents(\App\Events\Auth\UserCreatedEvent::class);

        $this->users->create($this->defaultUserData());
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
}


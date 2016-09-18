<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Prettus\Repository\Events\RepositoryEntityCreated;

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
        Event::shouldReceive('fire')
            ->once()
            ->withArgs([
                \Mockery::type(RepositoryEntityCreated::class),
                \Mockery::any(),
                \Mockery::any(),
            ]);

        $this->users->create($this->defaultUserData());
    }

    /**
     *
     */
    public function test_UserPasswordIsEncryptedProperly()
    {
        $this->users->create($this->defaultUserData());

        $user = $this->users->findByField('email', 'test@example.com')->first();

        $this->assertTrue(Hash::check('password', $user->password));
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


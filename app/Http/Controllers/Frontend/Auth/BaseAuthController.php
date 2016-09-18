<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\UserRepositoryContract;

abstract class BaseAuthController extends Controller
{
    /** @var UserRepositoryContract */
    protected $userRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param \App\Repositories\Auth\UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get the guest middleware for the application.
     */
    public function guestMiddleware()
    {
        $guard = $this->getGuard();

        return $guard ? 'guest:' . $guard : 'guest';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return null;
    }
}
<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Auth\Traits\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Frontend\Auth\Traits\VerifiesUsers;
use App\Models\Auth\User;
use App\Repositories\Auth\UserRepositoryContract;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins, VerifiesUsers;

    /** @var UserRepositoryContract */
    protected $userRepository;

    /** @var string Where to redirect users after login / registration. */
    protected $redirectTo = '/';

    /** @var string The login form view */
    protected $loginView = 'frontend.auth.login';

    /** @var string The registration form view */
    protected $registerView = 'frontend.auth.register';

    /** @var string The verification error view */
    protected $verificationErrorView = 'frontend.auth.verification-error';

    /**
     * Create a new authentication controller instance.
     *
     * @param \App\Repositories\Auth\UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->userRepository = $userRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return $this->userRepository->create($data);
    }
}

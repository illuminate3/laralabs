<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Auth\UserAuthenticatedEvent;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth\UserRepositoryContract;
use Auth;
use Event;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Class LoginController
 * @package App\Http\Controllers\Frontend\Auth
 */
class LoginController extends BaseAuthController
{
    use ThrottlesLogins;

    const LOGIN_REDIRECT_ROUTE = 'frontend.home';
    const LOGOUT_REDIRECT_ROUTE = 'frontend.home';
    const LOGIN_VIEW = 'frontend.auth.login';

    /** @var bool Is the user trying to log in currently locked out? */
    protected $lockedOut = false;

    /** @var string The name of the property to identify the user */
    protected $usernameField = 'email';

    /**
     * Create a new authentication controller instance.
     *
     * @param \App\Repositories\Auth\UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct($userRepository);
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitLogout()
    {
        Auth::guard($this->getGuard())->logout();

        return redirect()->route(self::LOGOUT_REDIRECT_ROUTE);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view(self::LOGIN_VIEW);
    }

    /**
     * Handle a login request for the application.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitLoginForm(LoginRequest $request)
    {
        if (true !== ($response = $this->shouldTryToLogin($request))) return $response;

        // Proceed to authentication attempt
        $credentials = $this->getCredentials($request);
        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember')))
        {
            if (true !== ($response = $this->shouldProceedToLogin($request)))
            {
                Auth::guard($this->getGuard())->logout();

                return $response;
            }

            return $this->handleAuthenticationSuccess($request);
        }

        return $this->handleAuthenticationFailed($request);

    }

    /**
     * Returns true if we can try to login. Else it returns a response to send and we will not even try to authentify
     * the user
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return bool|\Illuminate\Http\Response
     */
    protected function shouldTryToLogin(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $this->lockedOut = $this->hasTooManyLoginAttempts($request);
        if ($this->lockedOut)
        {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        return true;
    }

    /**
     * Returns true if we can proceed to login. Else it returns a response to send and we will log out
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return bool|\Illuminate\Http\Response
     */
    protected function shouldProceedToLogin(LoginRequest $request)
    {
        // User credentials are valid, does he have a verified account? If not -> logout and error
        /** @var \App\Models\Auth\User $user */
        $user = Auth::guard($this->getGuard())->user();
        if ( !$user->verified)
        {
            Auth::guard($this->getGuard())->logout();

            return $this->sendUnverifiedLoginResponse($request);
        }

        return true;
    }

    /**
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleAuthenticationFailed(LoginRequest $request)
    {
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ( !$this->lockedOut)
        {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    protected function handleAuthenticationSuccess(LoginRequest $request)
    {
        $this->clearLoginAttempts($request);

        /** @noinspection PhpParamsInspection */
        Event::fire(new UserAuthenticatedEvent(Auth::guard($this->getGuard())->user()));

        return $this->sendSuccessfulLoginResponse();
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return array
     */
    protected function getCredentials(LoginRequest $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendSuccessfulLoginResponse()
    {
        return redirect()->intended(route(self::LOGIN_REDIRECT_ROUTE));
    }

    /**
     * Get the failed login response instance.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(LoginRequest $request)
    {
        return redirect()
            ->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => trans('auth.failed'),
            ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendUnverifiedLoginResponse(LoginRequest $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => trans('auth.unverified'),
            ]);
    }

    /**
     * @return string
     */
    protected function loginUsername()
    {
        return $this->usernameField;
    }
}
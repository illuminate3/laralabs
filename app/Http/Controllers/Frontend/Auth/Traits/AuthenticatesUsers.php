<?php namespace App\Http\Controllers\Frontend\Auth\Traits;

use Auth;
use Illuminate\Http\Request;
use Lang;

trait AuthenticatesUsers
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();
        /** @noinspection PhpUndefinedMethodInspection */
        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request))
        {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->fireLockoutEvent($request);

            /** @noinspection PhpUndefinedMethodInspection */
            return $this->sendLockoutResponse($request);
        }

        // Check credentials
        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->validate($credentials))
        {

        }

        // Proceed to authentication attempt

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember')))
        {
            // User credentials are valid, does he have a verified account? If not -> logout and error
            /** @var \App\Models\Auth\User $user */
            $user = Auth::guard($this->getGuard())->user();
            if ( !$user->verified)
            {
                Auth::guard($this->getGuard())->logout();

                return $this->sendUnverifiedLoginResponse($request);
            }

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && !$lockedOut)
        {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendUnverifiedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getUnverifiedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getUnverifiedLoginMessage()
    {
        return Lang::has('auth.unverified') ? Lang::get('auth.unverified') : 'You must confirm your account.';
    }
}
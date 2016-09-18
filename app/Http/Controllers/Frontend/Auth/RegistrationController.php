<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Auth\UserRegisteredEvent;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Repositories\Auth\UserRepositoryContract;
use Auth;
use Event;

/**
 * Class RegistrationController
 * @package App\Http\Controllers\Frontend\Auth
 */
class RegistrationController extends BaseAuthController
{
    const REGISTRATION_REDIRECT_ROUTE = 'frontend.home';
    const REGISTRATION_VIEW = 'frontend.auth.register';

    /**
     * Create a new authentication controller instance.
     *
     * @param \App\Repositories\Auth\UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct($userRepository);
        $this->middleware($this->guestMiddleware());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view(self::REGISTRATION_VIEW);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegistrationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitRegistrationForm(RegistrationRequest $request)
    {
        // Create the user in DB
        $user = $this->userRepository->create($request->all());

        // Login if required
        $enableVerification = config('auth.verification.enable', true);
        if (config('auth.registration.login_after_registration', false))
        {
            $allowUnverifiedLogin = config('auth.verification.allow_unverified_login', false);
            if ( !$enableVerification || $allowUnverifiedLogin)
            {
                Auth::guard($this->getGuard())->login($user);
            }
        }

        // Set status message
        $request->session()->flash('status', $enableVerification
            ? trans('auth.registration.needs_verification')
            : trans('auth.registration.complete'));

        // Send event
        Event::fire(new UserRegisteredEvent($user));

        return redirect(route(self::REGISTRATION_REDIRECT_ROUTE));
    }


}
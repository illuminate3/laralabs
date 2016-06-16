<?php namespace App\Http\Controllers\Frontend\Auth\Traits;


use Auth;
use Illuminate\Http\Request;

trait RegistersUsers
{
    use \Illuminate\Foundation\Auth\RegistersUsers;

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // Create the user in DB
        $user = $this->create($request->all());

        // Login if required
        $enableVerification = config('auth.verification.enable', true);
        $allowUnverifiedLogin = config('auth.verification.allow_unverified_login', false);
        if ( !$enableVerification || $allowUnverifiedLogin)
        {
            Auth::guard($this->getGuard())->login($user);
        }

        // Set status message
        $request->session()->flash('status', $enableVerification
            ? trans('auth.registration.complete')
            : trans('auth.registration.needs_verification'));

        return redirect($this->redirectPath());
    }

}
<?php namespace App\Http\Controllers\Frontend\Auth\Traits;


use Auth;
use Illuminate\Http\Request;
use UserVerification;

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

        $enableVerification = config('auth.verification.enable', true);
        $allowUnverifiedLogin = config('auth.verification.allow_unverified_login', false);

        if ( !$enableVerification)
        {
            Auth::guard($this->getGuard())->login($user);

            // User is verified
            $user->verified = true;
            $user->save();

            $request->session()->flash('status', trans('auth.registration.complete'));
        }
        else
        {
            if ($allowUnverifiedLogin)
            {
                Auth::guard($this->getGuard())->login($user);
            }

            // Generate a verification token and send it to the user
            UserVerification::generate($user);
            UserVerification::send($user, trans('emails.verify-account.title'));

            $request->session()->flash('status', trans('auth.registration.needs_verification'));
        }

        return redirect($this->redirectPath());
    }

}
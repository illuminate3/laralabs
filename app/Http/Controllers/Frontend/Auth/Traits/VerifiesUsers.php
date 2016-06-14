<?php namespace App\Http\Controllers\Frontend\Auth\Traits;


trait VerifiesUsers
{
    use \Jrean\UserVerification\Traits\VerifiesUsers;

    /**
     * Get the redirect path if the user is already verified.
     *
     * @return string
     */
    public function redirectIfVerified()
    {
        return route('frontend.auth.login.form');
    }

    /**
     * Get the redirect path for a successful verification token generation.
     *
     * @return string
     */
    public function redirectAfterTokenGeneration()
    {
        return route('frontend.home');
    }

    /**
     * Get the redirect path for a successful verification token verification.
     *
     * @return string
     */
    public function redirectAfterVerification()
    {
        return route('frontend.auth.login.form');
    }

    /**
     * Get the redirect path for a failing verification token verification.
     *
     * @return string
     */
    public function redirectIfVerificationFails()
    {
        return route('frontend.auth.verification.error');
    }
}
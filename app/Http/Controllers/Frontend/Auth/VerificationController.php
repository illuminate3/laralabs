<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Auth\UserVerifiedEvent;
use App\Http\Requests\Auth\VerificationRequest;
use App\Repositories\Auth\UserRepositoryContract;
use Event;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use UserVerification;

class VerificationController extends BaseAuthController
{
    const VERIFICATION_SUCCESS_REDIRECT_ROUTE = 'frontend.auth.login.form';
    const VERIFICATION_FAILED_REDIRECT_ROUTE = 'frontend.auth.verification.error';

    const ERROR_VIEW = 'frontend.auth.register';

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
     * Show the verification error view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVerificationError()
    {
        return view(self::ERROR_VIEW);
    }

    /**
     * Handle the user verification. Just landing here is enough and will allow the user to verify his account. Once
     * verified, we redirect the user.
     *
     * @param \App\Http\Requests\Auth\VerificationRequest $request
     * @param  string                                     $token
     *
     * @return \Illuminate\Http\Response
     */
    public function submitVerification(VerificationRequest $request, $token = '')
    {
        if (empty($token)) return $this->handleVerificationFailed();
        if ( !config('auth.verification.enabled')) $this->handleUserAlreadyVerified();

        try
        {
            UserVerification::process(
                $request->input('email'),
                $token,
                config('auth.tables.users'));
        }
        catch (UserNotFoundException $e)
        {
            return $this->handleVerificationFailed();
        }
        catch (TokenMismatchException $e)
        {
            return $this->handleVerificationFailed();
        }
        catch (UserIsVerifiedException $e)
        {
            return $this->handleUserAlreadyVerified();
        }

        return $this->handleVerificationSuccess($request);
    }

    /**
     * @param \App\Http\Requests\Auth\VerificationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function handleVerificationSuccess(VerificationRequest $request)
    {
        Event::fire(new UserVerifiedEvent($request->input('email')));

        return redirect()->route(self::VERIFICATION_SUCCESS_REDIRECT_ROUTE);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function handleUserAlreadyVerified()
    {
        return redirect()->route(self::VERIFICATION_SUCCESS_REDIRECT_ROUTE);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function handleVerificationFailed()
    {
        return redirect()->route(self::VERIFICATION_FAILED_REDIRECT_ROUTE);
    }

    /**
     * Get the URL we should redirect to when request validation fails
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return redirect()->route(self::VERIFICATION_FAILED_REDIRECT_ROUTE);
    }

    /**
     * Get the user table name.
     *
     * @return string
     */
    protected function userTable()
    {
        return config('auth.tables.users');
    }


}
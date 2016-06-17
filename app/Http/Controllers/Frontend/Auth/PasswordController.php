<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\Auth\User;
use App\Repositories\Auth\UserRepositoryContract;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Password;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Frontend\Auth
 */
class PasswordController extends BaseAuthController
{
    const FORGOT_PASSWORD_VIEW = 'frontend.auth.forgot-password';
    const RESET_PASSWORD_VIEW = 'frontend.auth.reset-password';

    const FORGOT_PASSWORD_SUCCESS_REDIRECT_ROUTE = 'frontend.auth.login.form';
    const RESET_PASSWORD_SUCCESS_REDIRECT_ROUTE = 'frontend.home';

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForgotPasswordForm()
    {
        return view(self::FORGOT_PASSWORD_VIEW);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \App\Http\Requests\Auth\ForgotPasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitForgotPasswordForm(ForgotPasswordRequest $request)
    {
        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request),
            $this->resetEmailBuilder()
        );

        switch ($response)
        {
            case Password::RESET_LINK_SENT:
                return $this->handleSendResetLinkEmailSuccess($response);

            case Password::INVALID_USER:
            default:
                return $this->handleSendResetLinkEmailFailure($response);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param \Illuminate\Http\Request $request
     * @param  string                  $token
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->input('email');

        return view(self::RESET_PASSWORD_VIEW)->with([
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param \App\Http\Requests\Auth\ResetPasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
        $credentials = $this->getResetCredentials($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password)
        {
            $this->resetPassword($user, $password);
        });

        switch ($response)
        {
            case Password::PASSWORD_RESET:
                return $this->handleResetPasswordSuccess($response);

            default:
                return $this->handleResetPasswordFailure($request, $response);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  User   $user
     * @param  string $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->userRepository->updatePassword($user->id, $password);

        Auth::guard($this->getGuard())->login($user);
    }

    /**
     * Get the Closure which is used to build the password reset email message.
     *
     * @return \Closure
     */
    protected function resetEmailBuilder()
    {
        return function (Message $message)
        {
            $message->subject(trans('emails.auth.forgot-password.subject'));
        };
    }

    /**
     * Get the needed credentials for sending the reset link.
     *
     * @param \App\Http\Requests\Auth\ForgotPasswordRequest $request
     *
     * @return array
     */
    protected function getSendResetLinkEmailCredentials(ForgotPasswordRequest $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleSendResetLinkEmailSuccess($response)
    {
        return redirect()->route(self::FORGOT_PASSWORD_SUCCESS_REDIRECT_ROUTE)->with('status', trans($response));
    }

    /**
     * Get the response for after the reset link could not be sent.
     *
     * @param  string $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleSendResetLinkEmailFailure($response)
    {
        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleResetPasswordSuccess($response)
    {
        return redirect()
            ->route(self::RESET_PASSWORD_SUCCESS_REDIRECT_ROUTE)
            ->with('status', trans($response));
    }

    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request $request
     * @param  string  $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleResetPasswordFailure(Request $request, $response)
    {
        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getResetCredentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     */
    public function getBroker()
    {
        return null;
    }
}

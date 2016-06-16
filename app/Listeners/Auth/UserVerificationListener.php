<?php namespace App\Listeners\Auth;

use App\Events\Auth\UserCreatedEvent;
use UserVerification;

/**
 * Class UserVerificationListener
 * @package App\Listeners\Auth
 *
 *          When a user is created within the application, this handles the verification
 */
class UserVerificationListener
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserCreatedEvent $event
     */
    public function handle(UserCreatedEvent $event)
    {
        $user = $event->user;

        // If user is already verified, we do not have to worry, take it easy
        if ($user->verified) return;

        // Do something when it is not the case: either automatically verify it or send email
        if ( !config('auth.verification.enable', true))
        {
            // User is verified
            $user->verified = true;
            $user->save();
        }
        else
        {
            // Generate a verification token and send it to the user
            UserVerification::generate($user);
            UserVerification::send($user, trans('emails.verify-account.title'));
        }
    }
}

<?php namespace App\Events\Auth;

class UserVerifiedEvent
{
    /** @var string */
    public $email;

    /**
     * UserLoggedInEvent constructor.
     *
     * @param string $email
     */
    public function __construct($email) { $this->email = $email; }
}
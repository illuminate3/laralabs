<?php namespace App\Events\Auth;

use App\Models\Auth\User;

class UserEvent
{
    /** @var User */
    public $user;

    /**
     * UserLoggedInEvent constructor.
     *
     * @param \App\Models\Auth\User $user
     */
    public function __construct(User $user) { $this->user = $user; }


}
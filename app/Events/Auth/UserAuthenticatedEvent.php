<?php namespace App\Events\Auth;

use App\Models\Auth\User;

class UserAuthenticatedEvent extends UserEvent
{
    public function __construct(User $user) { parent::__construct($user); }
}
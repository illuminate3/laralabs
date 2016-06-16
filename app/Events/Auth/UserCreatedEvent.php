<?php namespace App\Events\Auth;

use App\Events\Event;
use App\Models\Auth\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreatedEvent
 * @package App\Events\Auth
 *
 *          Fired whenever a user is created in the application
 */
class UserCreatedEvent extends Event
{
    use SerializesModels;

    public $user;

    /**
     * Constructor
     *
     * @param \App\Models\Auth\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

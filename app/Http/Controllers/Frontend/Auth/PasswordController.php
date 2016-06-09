<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    /** @var string The registration form view */
    protected $linkRequestView = 'frontend.auth.passwords.email';

    /** @var string The registration form view */
    protected $resetView = 'frontend.auth.passwords.reset';


    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}

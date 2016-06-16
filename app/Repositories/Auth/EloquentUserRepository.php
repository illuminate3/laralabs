<?php namespace App\Repositories\Auth;

use App\Models\Auth\User;
use UserVerification;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Frontend\User
 */
class EloquentUserRepository implements UserRepositoryContract
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param $email
     *
     * @return User|bool
     */
    public function findByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user instanceof User)
        {
            return $user;
        }

        return false;
    }

    /**
     * @param array $data
     * @param bool  $isVerified
     *
     * @return static
     */
    public function create(array $data, $isVerified = false)
    {
        if ( !config('auth.verification.enabled')) $isVerified = true;

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'verified' => $isVerified,
        ]);

        // If not already verified, and verification is enabled, generate a token
        if ( !$isVerified)
        {
            UserVerification::generate($user);
        }

        return $user;
    }
}
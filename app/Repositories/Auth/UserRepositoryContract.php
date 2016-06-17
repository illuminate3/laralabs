<?php namespace App\Repositories\Auth;

use App\Models\Auth\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepositoryContract
 *
 * @package App\Repositories\Auth\
 */
interface UserRepositoryContract extends RepositoryInterface
{

    /**
     * Update a user's password
     *
     * @param int    $id
     * @param string $password
     *
     * @return User
     */
    function updatePassword($id, $password);

}

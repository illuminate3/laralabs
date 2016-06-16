<?php namespace App\Repositories\Auth;

/**
 * Interface UserRepositoryContract
 *
 * @package App\Repositories\Auth\
 */
interface UserRepositoryContract
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * @param $email
     *
     * @return mixed
     */
    public function findByEmail($email);

    /**
     * @param array $data
     * @param bool  $isVerified
     *
     * @return mixed
     */
    public function create(array $data, $isVerified = false);

}

<?php namespace App\Repositories\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Frontend\User
 */
class EloquentUserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Update a user's password
     *
     * @param int    $id
     * @param string $password
     *
     * @return User
     */
    public function updatePassword($id, $password)
    {
        return $this->update([
            'password'       => $password,
            'remember_token' => Str::random(60),
        ], $id);
    }

    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        return parent::update($this->transformAttributes($attributes), $id);
    }

    /**
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return parent::updateOrCreate($this->transformAttributes($attributes), $values);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return parent::create($this->transformAttributes($attributes));
    }

    /**
     * Encrypt the password before it is saved on the model
     *
     * @param array $attributes
     *
     * @return array
     */
    private function transformAttributes($attributes)
    {
        if (isset($attributes['password']))
        {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        if (isset($attributes['verified']) && !config('auth.verification.enabled'))
        {
            $attributes['verified'] = true;
        }

        return $attributes;
    }
}
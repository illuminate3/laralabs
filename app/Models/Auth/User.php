<?php

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Auth\User
 *
 * @property integer        $id
 * @property string         $name
 * @property string         $email
 * @property string         $password
 * @property string         $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean        $verified
 * @property string         $verification_token
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereVerificationToken($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}

<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegistrationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return config('auth.registration.enabled');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordStrengthRules = config('auth.passwords.strength_validation_rules', '');
        if (!empty($passwordStrengthRules)) $passwordStrengthRules = '|' . $passwordStrengthRules;

        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed' . $passwordStrengthRules,
        ];
    }
}

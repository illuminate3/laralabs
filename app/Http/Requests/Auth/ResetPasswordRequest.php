<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordStrengthRules = config('auth.passwords.strength_validation_rules', '');
        if ( !empty($passwordStrengthRules)) $passwordStrengthRules = '|' . $passwordStrengthRules;

        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed' . $passwordStrengthRules,
        ];
    }


}

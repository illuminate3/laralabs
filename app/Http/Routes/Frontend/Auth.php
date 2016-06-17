<?php

Route::group([
    'as'        => 'auth.',
    'namespace' => 'Auth',
], function ()
{

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'login',
        'as'     => 'login.',
    ], function ()
    {
        Route::get('/', [
            'as'   => 'form',
            'uses' => 'LoginController@showLoginForm',
        ]);

        Route::post('/', [
            'as'   => 'submit',
            'uses' => 'LoginController@submitLoginForm',
        ]);
    });

    Route::get('logout', [
        'as'   => 'logout',
        'uses' => 'LoginController@submitLogout',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Registration Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'register',
        'as'     => 'register.',
    ], function ()
    {
        Route::get('/', [
            'as'   => 'form',
            'uses' => 'RegistrationController@showRegistrationForm',
        ]);

        Route::post('/', [
            'as'   => 'submit',
            'uses' => 'RegistrationController@submitRegistrationForm',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Password Reset Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'password',
        'as'     => 'reset.',
    ], function ()
    {
        Route::get('/forgot', [
            'as'   => 'form',
            'uses' => 'PasswordController@showForgotPasswordForm',
        ]);

        Route::post('/email', [
            'as'   => 'email',
            'uses' => 'PasswordController@submitForgotPasswordForm',
        ]);

        Route::get('/reset/{token}', [
            'as'   => 'form',
            'uses' => 'PasswordController@showResetPasswordForm',
        ]);

        Route::post('/reset', [
            'as'   => 'change',
            'uses' => 'PasswordController@submitResetPasswordForm',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Account verification
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'verification',
        'as'     => 'verification.',
    ], function ()
    {
        Route::get('/error', [
            'as'   => 'error',
            'uses' => 'VerificationController@showVerificationError',
        ]);

        Route::get('/{token?}', [
            'as'   => 'form',
            'uses' => 'VerificationController@submitVerification',
        ]);
    });

});
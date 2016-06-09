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
            'uses' => 'AuthController@showLoginForm',
        ]);

        Route::post('/', [
            'as'   => 'submit',
            'uses' => 'AuthController@login',
        ]);
    });

    Route::get('logout', [
        'as'   => 'logout',
        'uses' => 'AuthController@logout',
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
            'uses' => 'AuthController@showRegistrationForm',
        ]);

        Route::post('/', [
            'as'   => 'submit',
            'uses' => 'AuthController@register',
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
        Route::get('/reset/{token?}', [
            'as'   => 'form',
            'uses' => 'PasswordController@showResetForm',
        ]);

        Route::post('/email', [
            'as'   => 'email',
            'uses' => 'PasswordController@sendResetLinkEmail',
        ]);
        
        Route::post('/reset', [
            'as'   => 'change',
            'uses' => 'PasswordController@reset',
        ]);
    });

});
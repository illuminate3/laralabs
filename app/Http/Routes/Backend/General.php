<?php

Route::get('/', [
    'as'   => 'home',
    'uses' => 'DashboardController@index',
]);

Route::get('/dashboard', [
    'as'   => 'dashboard',
    'uses' => 'DashboardController@dashboard',
]);
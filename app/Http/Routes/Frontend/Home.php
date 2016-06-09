<?php

Route::get('/', [
    'as' => 'home',
    function ()
    {
        return view('frontend.home.index');
    },
]);
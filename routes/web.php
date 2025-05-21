<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-auth', function () {
    return auth()->check() ? auth()->user()->email : 'No autenticado';
});

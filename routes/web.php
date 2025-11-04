<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/firstcrudform', function () {
    return view('firstcrud');
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('log');
});
Route::get('/login', function () {
    return view('log'); // resources/views/log.blade.php
})->middleware('web');

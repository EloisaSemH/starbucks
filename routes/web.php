<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'quote' => Inspiring::quotes()->random(),
    ]);
});
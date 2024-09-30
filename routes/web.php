<?php

use App\Models\Thing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'things' => Thing::all()->sortBy('months_alive',descending: true)
    ]);
});

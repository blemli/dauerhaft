<?php

use App\Models\Thing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'things' => Thing::public()->get()->sortBy('months_alive',descending: true)
    ]);
});

Route::get('/up', function () {
    return response('OK', 200);
});

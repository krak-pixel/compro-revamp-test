<?php

use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::post('/kontak', ContactMessageController::class)
    ->middleware('throttle:5,1')
    ->name('contact.store');

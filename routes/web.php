<?php

use App\Http\Controllers\CandidateAuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::post('/kontak', ContactMessageController::class)
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::middleware('guest')->controller(CandidateAuthController::class)->group(function (): void {
    Route::get('/karir/login', 'showLogin')->name('login');
    Route::post('/karir/login', 'login')
        ->middleware('throttle:10,1')
        ->name('career.login.store');
    Route::get('/karir/register', 'showRegister')->name('register');
    Route::post('/karir/register', 'register')
        ->middleware('throttle:5,1')
        ->name('career.register.store');
});

Route::post('/karir/logout', [CandidateAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('career.logout');

Route::controller(CareerController::class)->group(function (): void {
    Route::get('/karir', 'index')->name('career.index');
    Route::get('/karir/kirim-cv', 'sendCv')
        ->middleware('auth')
        ->name('career.send-cv');
    Route::get('/karir/{slug}/apply', 'apply')
        ->middleware('auth')
        ->name('career.apply');
    Route::get('/karir/{slug}', 'show')->name('career.show');
});

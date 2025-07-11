<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// HOME PAGES
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ✅ AUTH ROUTES
Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->noContent()
        ->withCookie(cookie('XSRF-TOKEN', csrf_token(), 60, '/', '.meshcah.net'));
});

// PAGES OF DASHBOARD
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard/', 'admin.dashboard.index')->name('dashboard');
    Route::view('/dashboard/{any}', 'admin.dashboard.index')->name('dashboard');
    Route::view('/questions', 'admin.questions.index')->name('about');
    Route::view('/section', 'admin.sections.index')->name('section');
    Route::view('/settings', 'admin.questions.import')->name('settings');
    Route::view('/users', 'admin.users.index')->name('users');
    Route::view('/profile', 'profile.index')->name('profile');
    Route::view('/profile/edit', 'profile.edit')->name('profile.edit');

});

Route::prefix('/')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/sections', 'sections')->name('sections');
});
Route::get('/questions/{id}', function ($id) {
    return view('frontend.questions', ['id'=>$id ]);
});

Route::get('/questions/{id}/{any}', function ($id) {
    return view('frontend.questions', ['id'=>$id ]);
});
// DISPLAY SECTIONS BY ID
Route::get('/duc', function () {
    return view('frontend.test');
});



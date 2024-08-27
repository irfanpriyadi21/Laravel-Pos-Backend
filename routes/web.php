<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});
Route::middleware(['auth'])->group(function (){
    Route::get('home', function(){
      return view('pages.dashboard');  
    })->name('home');

    Route::get('/users', function(){
        return view('pages.users.index');
    })->name('users');
});
// Route::get('/users', function(){
//     return view('pages.users.index');
// });
// add_phone_roles_at_users
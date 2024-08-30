<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});
Route::middleware(['auth'])->group(function (){
    Route::get('home', function(){
      return view('pages.dashboard');
    })->name('home');

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);

    // Route::get('/users', function(){
    //     return view('pages.users.index');
    // })->name('users');
});
// Route::get('/users', function(){
//     return view('pages.users.index');
// });
// add_phone_roles_at_users

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as conApi;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [conApi\AuthController::class, 'login']);
Route::post('logout', [conApi\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('products', conApi\ProductController::class)->middleware('auth:sanctum');

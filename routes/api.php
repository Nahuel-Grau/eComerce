<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPruebaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::Post('/register', [UserController::class, 'register']);
Route::Post('/login', [UserController::class, 'login']);
Route::Post('/logout', [UserController::class, 'logout']);//->middleware('auth:sanctum');

Route::Post('/product', [ProductPruebaController::class, 'store'])->middleware('auth:sanctum');
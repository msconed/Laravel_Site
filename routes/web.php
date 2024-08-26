<?php

use App\Http\Controllers\htmxController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {abort(404);});
Route::get('/signup', function () {abort(404);});
Route::get('/logout', function () { abort(404);});

Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'register']);


Route::post('/login-modal', [htmxController::class, 'modal_auth']);


Route::post('/signup-modal', [htmxController::class, 'modal_signup']);


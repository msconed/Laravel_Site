<?php

use App\Http\Controllers\apiController;
use Illuminate\Support\Facades\Route;


Route::post('/', [apiController::class, 'index']);
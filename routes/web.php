<?php

use App\Http\Controllers\htmxController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\userController;
use App\Http\Controllers\forumController;
use Illuminate\Support\Facades\Route;


/* ------------STYLES + SCRIPTS---------------- */
Route::get('/css/app.css', function () {
    $base_url = 'http://127.0.0.1:8000/';
    return response()->file($base_url.'css/app.css');
})->name('css.style');

Route::get('/js/app.js', function () {
    $base_url = 'http://127.0.0.1:8000/';
    return response()->file($base_url.'js/app.js');
})->name('js.js');
/* ------------------------------------------- */

/******************CHANGE LOCALE*************************** */
Route::get('/change-locale-to-ru', function () 
{
    userController::changeLocale('ru');
    return redirect('/');
});

Route::get('/change-locale-to-en', function () 
{
    userController::changeLocale('en');
    return redirect('/');
});
/********************************************************** */


Route::group(['middleware' => 'setLocale'], function () {
    /* ------------BASE PATHS---------------------- */
    Route::get('/', function () {return view('welcome');});

    Route::get('/forum', function () 
    {return view('forum.main', ['arr' => forumController::forumMain()]);})->middleware('customAuth');

    /* ------------------------------------------- */




    /* ---------------------FORUM PATHS------------ */
    Route::get('/forum/{category_id}/{subCatrgory_id}', [forumController::class, 'showTopics'])->middleware('customAuth');
    Route::get('/forum/{category_id}/{subCatrgory_id}/{topic_id}', [forumController::class, 'details'])->middleware('customAuth');
    Route::post('/forum/new_topic_create',    [forumController::class, 'new_topic_create'])->middleware('customAuth');
    /* ------------------------------------------- */


    /* ---------------------RESTRICTED PATHS------ */
    Route::get('/login',                function () {abort(404);});
    Route::get('/signup',               function () {abort(404);});
    Route::get('/logout',               function () {abort(404);});
    /* ------------------------------------------- */

    /* ---------------------AUTH PATHS------------ */
    Route::post('/logout',              [UserController::class, 'logout'])->middleware('customAuth');
    Route::post('/login',               [UserController::class, 'login']);
    Route::post('/signup',              [UserController::class, 'register']);
    /* ------------------------------------------- */


    /* ---------------------MODALS---------------- */
    Route::post('/login-modal',         [htmxController::class, 'modal_auth']);
    Route::post('/signup-modal',        [htmxController::class, 'modal_signup']);
    Route::post('/new_topic',           [htmxController::class, 'modal_new_topic'])->middleware('customAuth');
    /* ------------------------------------------- */
});

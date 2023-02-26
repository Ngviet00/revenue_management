<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function (){

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    include "backend/role.php";

});

//Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
//
//    Route::get('/home', [HomeController::class, 'index'])->name('home');
//
//    includeRouteFiles(__DIR__ . '/backend/');
//});






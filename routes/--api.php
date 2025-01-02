<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\backend\DepartmentController;
use Illuminate\Support\Facades\Auth;
// use App\Http\Middleware\AdminMiddleware;


Route::get('app-register', [App\Http\Controllers\Auth\RegisterController::class, 'apiRegister']);


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

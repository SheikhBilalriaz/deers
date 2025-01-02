<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\DepartmentController;
use Illuminate\Support\Facades\Auth;

    Route::get('/', [AdminController::class, 'dashboard'])->name('home');
   
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::get('/locations', [AdminController::class, 'locations'])->name('locations');
    Route::get('/subscriptions', [AdminController::class, 'subcsription'])->name('subscriptions');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('invoices');
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::get('/inbox', [AdminController::class, 'inbox'])->name('inbox');


    Route::get('/add-location', [AdminController::class, 'add_location'])->name('add_location');
    Route::get('/add-appointment', [AdminController::class, 'add_appointments'])->name('add_appointments');


    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/add-members', [AdminController::class, 'add_members'])->name('add_members');
    Route::post('/add-members-submit', [AdminController::class, 'add_members_submit'])->name('add_members_submit');
    Route::get('/members/{user}/edit', [AdminController::class, 'edit_members'])->name('edit_members');
    Route::post('/members/edit/{user}', [AdminController::class, 'edit_members_submit'])->name('members.edit.submit');    
    Route::delete('/members/{user}', [AdminController::class, 'destroy'])->name('members.destroy');


    Route::get('/departments', [DepartmentController::class, 'departments'])->name('departments');
    Route::get('/add-department', [DepartmentController::class, 'add_departments'])->name('add_departments');
    Route::post('/add-department-submit', [DepartmentController::class, 'add_departments_submit'])->name('add_departments_submit');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit_departments'])->name('edit_departments');
    Route::post('departments/edit/{department}', [DepartmentController::class, 'edit_departments_submit'])->name('departments.edit.submit');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');


    Auth::routes();
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AppointmentController;
use App\Http\Controllers\backend\DepartmentController;
use App\Http\Controllers\backend\AnnouncementController;
use App\Http\Controllers\backend\EquipmentController;
use App\Http\Controllers\Auth\RegisterController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('app-register', [App\Http\Controllers\Auth\RegisterController::class, 'apiRegister']);
Route::post('app-login', [App\Http\Controllers\Auth\LoginController::class, 'appLogin']);
Route::post('upload-document', [App\Http\Controllers\backend\DocumentController::class, 'upload']);
Route::get('user-document', [App\Http\Controllers\backend\DocumentController::class, 'userDocs']);
Route::get('department-users', [App\Http\Controllers\backend\AppointmentController::class, 'departmentUers']);
Route::get('department-appointmnets', [App\Http\Controllers\backend\AppointmentController::class, 'departmentAppointmnets']);
Route::post('appointments-approve-disapprove/{id}', [App\Http\Controllers\backend\AppointmentController::class, 'approveDisapprove']);
Route::post('/announcements', [AnnouncementController::class, 'store']);
Route::get('/announcements/department/{department_id}', [AnnouncementController::class, 'getByDepartment']);
Route::get('/announcements/all-departments', [AnnouncementController::class, 'allDepartments']);
Route::apiResource('equipments', EquipmentController::class);
Route::get('app-departments', [AppointmentController::class, 'appDepartments']);
Route::apiResource('appointments', AppointmentController::class);
Route::get('user-appointments/{id}', [AppointmentController::class, 'userAppointment']);
Route::get('/departments/{id}/availability/{date}', [AppointmentController::class, 'checkAvailability']);
Route::get('/equipments/department/{department_id}', [EquipmentController::class, 'getEquipmentByDepartmentID']);

Route::prefix('otp')->group(function () {
    Route::post("/otp-verify" , [RegisterController::class,'verify_otp']);
    Route::post("/verified-Otp" , [RegisterController::class,'verifiedOtp']);
    Route::post("/resend-top" , [RegisterController::class,'resendOtp']);
});
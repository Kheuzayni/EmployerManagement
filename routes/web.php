<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login-page');
});

// Routes d'authentification
Route::get('/registration/form', [AuthController::class, 'loadRegisterForm']);
Route::post('/register/superadmin', [AuthController::class, 'registerSuperAdmin'])->name('registerSuperAdmin');
Route::get('/login/form', [AuthController::class, 'loadLoginPage']);
Route::post('/login/user', [AuthController::class, 'LoginUser'])->name('LoginUser');
Route::get('/logout', [AuthController::class, 'LogoutUser']);
Route::get('/forgot/password', [AuthController::class, 'forgotPassword']);
Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/reset/password', [AuthController::class, 'loadResetPassword']);
Route::post('/reset/user/password', [AuthController::class, 'ResetPassword'])->name('ResetPassword');

// Routes pour l'administrateur
Route::group(['middleware' => [AdminMiddleware::class]], function () {
    // Routes pour gérer les managers par les admins
    Route::get('/admin/home', [AdminController::class, 'loadAllManagers'])->name('loadAllManagers');
    // Route::get('/get/all/managers', [AdminController::class, 'loadAllManagers'])->name('loadAllManagers');
    Route::post('/register/manager', [AdminController::class, 'RegisterUser'])->name('RegisterUser');
    Route::get('/delete/manager/{id}', [AdminController::class, 'deleteManager'])->name('deleteManager');
    Route::post('/edit/manager', [AdminController::class, 'editManager'])->name('editManager');
});

// Routes pour les managers
Route::group(['middleware' => [ManagerMiddleware::class]], function () {
    Route::get('/manager/home', [EmployeeController::class, 'loadEmployeeHome']);
    // Routes pour gerer les agents par les manageres
    Route::post('/register/employee', [EmployeeController::class, 'RegisterAgent'])->name('RegisterAgent');
    Route::get('/delete/employee/{id}', [EmployeeController::class, 'deleteAgent'])->name('deleteAgent');
    Route::post('/edit/employee', [EmployeeController::class, 'editAgent'])->name('editAgent');
});

// Routes pour les employee ou agents
Route::group(['middleware' => [EmployeeMiddleware::class]], function () {
    Route::get('/employee/home', [EmployeeController::class, 'loadEmployeeHome']);
});

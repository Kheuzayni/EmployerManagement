<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController; // make sure you import the controller
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration/form',[AuthController::class,'loadRegisterForm']);
// create an Authentication Controller
Route::post('/register/user',[AuthController::class,'registerUser'])->name('registerUser');

Route::get('/login/form',[AuthController::class,'loadLoginPage']);

Route::post('/login/user',[AuthController::class,'LoginUser'])->name('LoginUser');

Route::get('/logout',[AuthController::class,'LogoutUser']);

Route::get('/forgot/password',[AuthController::class,'forgotPassword']);

Route::post('/forgot',[AuthController::class,'forgot'])->name('forgot');

Route::get('/reset/password',[AuthController::class,'loadResetPassword']);

Route::post('/reset/user/password',[AuthController::class,'ResetPassword'])->name('ResetPassword');

Route::group(['middleware' => [AdminMiddleware::class]], function () {
    Route::get('/admin/home', [AuthController::class, 'loadHomePage']);
    //Route to manage the mananger
    Route::get('/get/all/managers', [AdminController::class, 'loadAllManagers']);
    Route::get('/register/manager', [AdminController::class, 'RegisterManager'])->name('RegisterManager');
});


Route::group(['middleware' => [ManagerMiddleware::class]], function () {
    Route::get('/manager/home', [AuthController::class, 'loadHomePage']);
});
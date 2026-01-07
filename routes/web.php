<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewReleaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


/* Login */
Route::get('/', [AuthController::class, 'showSignin']);
Route::get('signin', [AuthController::class, 'showSignin'])->name('signin.get');
Route::post('signin', [AuthController::class, 'signin'])->name('signin.post');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

/* Home */
Route::get('home', [HomeController::class, 'index'])->name('home');

/* 帳號管理 */
Route::get('user', [UserController::class, 'list']);
Route::get('user/list', [UserController::class, 'list']);
Route::get('user/create', [UserController::class, 'create']);
Route::get('user/update/{id?}', [UserController::class, 'update']);
Route::get('user/delete/{id?}', [UserController::class, 'remove']);

/* 身份管理 */
Route::get('role', [RoleController::class, 'list']);
Route::get('role/list', [RoleController::class, 'list']);
Route::get('role/create', [RoleController::class, 'showCreate']);
Route::post('role/create', [RoleController::class, 'create']);
Route::get('role/update/{id?}', [RoleController::class, 'showUpdate']);
Route::post('role/update/{id?}', [RoleController::class, 'update']);
Route::post('role/delete/{id?}', [RoleController::class, 'remove']);


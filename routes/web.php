<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewReleaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


/* Login */
Route::get('/', [AuthController::class, 'showSignin'])->name('signin.index');
Route::get('signin', [AuthController::class, 'showSignin'])->name('signin.get');
Route::post('signin', [AuthController::class, 'signin'])->name('signin.post');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

/* Home */
Route::get('home', [HomeController::class, 'index'])->name('home');

/* 帳號管理 */
Route::get('user', [UserController::class, 'list'])->name('user.index');
Route::get('user/list', [UserController::class, 'list'])->name('user.list');
Route::post('users/search', [UserController::class, 'search'])->name('user.search');
Route::get('user/create', [UserController::class, 'showCreate'])->name('user.create.get');
Route::post('user/create', [UserController::class, 'create'])->name('user.create.post');
Route::get('user/update/{id?}', [UserController::class, 'showUpdate'])->name('user.update.get');
Route::post('user/update/{id?}', [UserController::class, 'update'])->name('user.update.post');
Route::post('user/delete/{id?}', [UserController::class, 'remove'])->name('user.delete.post');

/* 身份管理 */
Route::get('role', [RoleController::class, 'list'])->name('role.index');
Route::get('role/list', [RoleController::class, 'list'])->name('role.list');
Route::get('role/create', [RoleController::class, 'showCreate'])->name('role.create.get');
Route::post('role/create', [RoleController::class, 'create'])->name('role.create.post');
Route::get('role/update/{id?}', [RoleController::class, 'showUpdate'])->name('role.update.get');
Route::post('role/update/{id?}', [RoleController::class, 'update'])->name('role.update.post');
Route::post('role/delete/{id?}', [RoleController::class, 'remove'])->name('role.delete.post');


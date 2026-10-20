<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\OrderPosController;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AccessPermissionMiddleware;
use App\Enums\Functions;

/* use App\Mail\ForgetPassword; */

/* Route::get('/preview-mail', function () {
    return new ForgetPassword('http://laravel.local/forgetPassword/preview'); 
}); */

/***** Oeth fido *****/
Route::get('oeth/auth/redirect', [OethAuthController::class, 'redirect'])->name('oeth.redirect');
Route::get('oeth/auth/callback', [OethAuthController::class, 'callback']);
/***** Oeth fido End *****/

/***** Login *****/
Route::get('/', [AuthController::class, 'showSignin'])->name('signin');
Route::redirect('signin', '/'); 
Route::post('signin', [AuthController::class, 'signin'])->name('signin.post');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

/***** Forget Password *****/
Route::post('forgetPassword/send', [ForgetPasswordController::class, 'sendLink'])->name('forgetPassword.send');
Route::get('forgetPassword/setting/{token}', [ForgetPasswordController::class, 'showSetting'])->name('forgetPassword.setting');
Route::post('forgetPassword/setting', [ForgetPasswordController::class, 'setting'])->name('forgetPassword.setting.post');

Route::middleware([AuthMiddleware::class])->group(function(){
	/***** Home *****/
	Route::get('home', [HomeController::class, 'index'])->name('home');
	
	/***** User profile *****/
	Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update.post');
	
	
	/***** Order search *****/
	Route::middleware([AccessPermissionMiddleware::class . Str::start(Functions::ORDER_POS->value, ':')])->group(function(){
		Route::get('order/pos', [OrderPosController::class, 'showSearch'])->name('order.pos');
		Route::get('order/pos/search', [OrderPosController::class, 'showSearch'])->name('order.pos.search');
		Route::post('order/pos/search', [OrderPosController::class, 'search'])->name('order.pos.search.post');
		
		Route::get('order/purchase', [OrderPosController::class, 'list'])->name('order.purchase');
		Route::get('order/ezorder', [OrderPosController::class, 'list'])->name('order.ezorder');
	});
	
	/***** 權限管理 *****/
	Route::middleware([AccessPermissionMiddleware::class . Str::start(Functions::USER->value, ':')])->group(function(){
		Route::get('user', [UserController::class, 'list'])->name('users');
		Route::get('user/list', [UserController::class, 'list'])->name('user.list');
		Route::post('user/search', [UserController::class, 'search'])->name('user.search');
		Route::get('user/create', [UserController::class, 'showCreate'])->name('user.create');
		Route::post('user/create', [UserController::class, 'create'])->name('user.create.post');
		Route::get('user/update/{id}', [UserController::class, 'showUpdate'])->name('user.update');
		Route::post('user/update', [UserController::class, 'update'])->name('user.update.post');
		Route::post('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
	});
	
	/***** 身份管理 *****/
	Route::middleware([AccessPermissionMiddleware::class . Str::start(Functions::ROLE->value, ':')])->group(function(){
		Route::get('role', [RoleController::class, 'list'])->name('roles');
		Route::get('role/list', [RoleController::class, 'list'])->name('role.list');
		Route::get('role/create', [RoleController::class, 'showCreate'])->name('role.create');
		Route::post('role/create', [RoleController::class, 'create'])->name('role.create.post');
		Route::get('role/update/{id}', [RoleController::class, 'showUpdate'])->name('role.update');
		Route::post('role/update', [RoleController::class, 'update'])->name('role.update.post');
		Route::post('role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
	});

});



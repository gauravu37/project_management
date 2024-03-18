<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// userr route
Route::get('/user/login', [UserController::class, 'index'])->name('login');
Route::post('custom-login', [UserController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [UserController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [UserController::class, 'customRegistration'])->name('register.custom'); 
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard'); 
Route::get('signout', [UserController::class, 'signOut'])->name('signout');
Route::get('user/apply-leave', [UserController::class, 'applyLeave'])->name('user/apply-leave'); 
Route::post('user/leave', [UserController::class, 'leave'])->name('user/leave');

// // admin route
Route::get('admin', [AdminController::class, 'index'])->name('login');
Route::post('admin/login', [AdminController::class, 'customLogin'])->name('admin/login');
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
Route::get('users', [AdminController::class, 'users'])->name('users'); 
Route::get('request-leave', [AdminController::class, 'requestLeave'])->name('request-leave'); 
Route::get('approved-leave', [AdminController::class, 'approvedLeave'])->name('approved-leave');

// Route::get('login', [AdminController::class, 'index'])->name('login');
// Route::post('admin/login', [AdminController::class, 'customLogin'])->name('admin/login'); 
// Route::get('signout', [AdminController::class, 'signOut'])->name('signout');

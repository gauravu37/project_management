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
Route::get('/', [UserController::class, 'index'])->name('/');
Route::post('custom-login', [UserController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [UserController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [UserController::class, 'customRegistration'])->name('register.custom'); 
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard'); 
Route::get('signout', [UserController::class, 'signOut'])->name('signout');
Route::get('user/apply-leave', [UserController::class, 'applyLeave'])->name('user/apply-leave'); 
Route::post('user/leave', [UserController::class, 'leave'])->name('user/leave');
Route::get('user/attendence-time', [UserController::class, 'attendence_time'])->name('user/attendence-time');
Route::post('user/attendence', [UserController::class, 'attendence'])->name('user/attendence');


Route::post('user/time-start', [UserController::class, 'time_start'])->name('user/time-start');


Route::post('user/time-pause', [UserController::class, 'time_pause'])->name('user/time-pause');
Route::post('user/time-stop', [UserController::class, 'time_stop'])->name('user/time-stop');
Route::get('user/profile', [UserController::class, 'profile'])->name('user/profile');
Route::post('user/profile-update', [UserController::class, 'profile_update'])->name('user/profile-update');

// // admin route
Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::post('admin/login', [AdminController::class, 'customLogin'])->name('admin/login');
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
Route::get('employees', [AdminController::class, 'users'])->name('employees'); 
Route::get('request-leave', [AdminController::class, 'requestLeave'])->name('request-leave'); 
Route::get('approved-leave', [AdminController::class, 'approvedLeave'])->name('approved-leave');
Route::get('reject-leave', [AdminController::class, 'rejectleaveview'])->name('reject-leave');
Route::get('admin/accept-leave/{id}', [AdminController::class, 'accept_leave']);
Route::get('employees-time', [AdminController::class, 'employee_time'])->name('employees-time'); 
Route::get('admin-signout', [AdminController::class, 'signOut'])->name('admin-signout');
Route::post('leave/reject', [AdminController::class, 'rejectleave'])->name('leave/reject');
Route::get('project-management', [AdminController::class, 'project_management'])->name('project-management');
Route::get('add-project', [AdminController::class, 'add_project']);
Route::post('add', [AdminController::class, 'addproject']);
Route::get('edit-project/{id}', [AdminController::class, 'edit_project']);
Route::post('update-project', [AdminController::class, 'updateproject']);
Route::get('delete-project/{id}', [AdminController::class, 'delete_project']);

Route::get('add-employee', [AdminController::class, 'add_employee']);
Route::post('add-employee-detail', [AdminController::class, 'add_employee_detail']);
Route::get('delete-employee/{id}', [AdminController::class, 'delete_employee']);
Route::get('edit-employee/{id}', [AdminController::class, 'edit_employee']);
Route::post('update-employee', [AdminController::class, 'update_employee']);

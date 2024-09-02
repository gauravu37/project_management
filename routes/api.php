<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('socialLogin', [RegisterController::class, 'socialLogin']);


Route::post('register', [RegisterController::class, 'register']);
Route::post('profile_update', [RegisterController::class, 'profile_update']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('forgot-password', [RegisterController::class, 'forgetPassword']);
Route::post('add_employee', [RegisterController::class, 'add_employee_detail']);
Route::post('update_employee', [RegisterController::class, 'update_employee']);
Route::get('delete_employee/{id}', [RegisterController::class, 'delete_employee']);
	
Route::post('getProfile', [RegisterController::class, 'getProfile']);
Route::post('friendRequest', [RegisterController::class, 'friendRequest']);
Route::post('updatefriendRequest', [RegisterController::class, 'updatefriendRequest']);

Route::get('getbookings/{id}', [RegisterController::class, 'getBookings']);
Route::get('getConfirmedStatus/{id}', [RegisterController::class, 'getConfirmedStatus']);
Route::get('getOTPdata/{id}', [RegisterController::class, 'getOTPdata']);








Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api']], function () {
   
});
 Route::post('/logout',[RegisterController::class,'logout']);




Route::post('/addfollow',    [RegisterController::class, 'addFollow']);
Route::post('/unfollow',    [RegisterController::class, 'unfollow']);
Route::post('/FollowRequestsList',    [RegisterController::class, 'follow_request']);
Route::post('/FollowRequest',    [RegisterController::class, 'FollowRequestAcceept']);
Route::post('/Followers',    [RegisterController::class, 'Follower']);

Route::post('/activites',    [RegisterController::class, 'activites']);
Route::post('/workoutdone',    [RegisterController::class, 'workoutdone']);
//newone
Route::post('/my_trainers',    [RegisterController::class, 'my_trainers']);
Route::post('/my_gyms',    [RegisterController::class, 'my_gyms']);
Route::post('/following',    [RegisterController::class, 'following']);
//
Route::post('/Follower_gym_bus',    [RegisterController::class, 'Followe_gym_bus']);
Route::post('/Savedpost',    [RegisterController::class, 'Savedpost']);


//////

Route::post('/sent_message',    [RegisterController::class, 'sent_message']);
Route::post('/get_chat_users',    [RegisterController::class, 'get_chat_users']);
Route::post('/get_messages',    [RegisterController::class, 'get_messages']);
Route::post('/fromuser',    [RegisterController::class, 'fromuser']);

Route::get('diet_plan', [RegisterController::class, 'get_all_dietplan']);
Route::post('add_diet_plan',    [RegisterController::class, 'add_user_diet_plan']);
Route::post('get_all_dietplan_user',    [RegisterController::class, 'get_all_dietplan_user']);
Route::post('get_diet_plan_by_date',    [RegisterController::class, 'get_all_plan_by_date']);


Route::middleware('auth:sanctum')->group(function () {
    Route::GET('/test',    [RegisterController::class, 'test']);
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\company\auth\LoginController;
use App\Http\Controllers\company\auth\ResetController;
use App\Http\Controllers\company\auth\RegisterController;
use App\Http\Controllers\company\Home\CategoryController;
use App\Http\Controllers\company\auth\VerficationController;
use App\Http\Controllers\company\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix'=>'com'],function(){
    Route::get('register',[RegisterController::class,'show']);
    Route::post('register',[RegisterController::class,'register']);
    Route::post('send-code',[VerficationController::class,'SendCode']);
    Route::post('check-code',[VerficationController::class,'CheckCode']);
    Route::post('login',[LoginController::class,'Login']);
    Route::delete('logout',[LoginController::class,'Logout']);
    Route::delete('logout-all-devices',[LoginController::class,'AllLogout']);
    Route::get('check/{email}',[ResetController::class,'CheckMail']);
    // Route::post('send-code',[ResetController::class,'SendCode']);
    // Route::post('check-code',[ResetController::class,'CheckCode']);
    Route::post('reset-password',[ResetController::class,'ResetPassword']);
    
});

Route::group(['prefix'=>'com','middleware'=>'auth:sanctum'],function(){
    Route::get('skills',[CategoryController::class,'ShowSkills']);
    Route::get('skill/{id}',[CategoryController::class,'GetUsersBySkill']);
    Route::get('posts',[CategoryController::class,'GetAllPosts']);
    Route::get('view-profile/{id}',[ProfileController::class,'ShowUserProfile']);
    Route::get('my-skills/{id}',[ProfileController::class,'GetUserSkills']);
    Route::get('user-posts/{id}',[ProfileController::class,'GetUserPosts']);
    Route::post('add-post',[ProfileController::class,'AddNewPost']);

});
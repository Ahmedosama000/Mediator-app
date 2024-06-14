<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\SkillsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and are assigned to the "api"
| middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});



// Protected route for the Dashboard
Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'index']);


// RESTful API routes for posts, protected
Route::middleware('auth:sanctum')->apiResource('/posts', PostController::class);

// Profile and password management
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/user/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/user/change-password', [AuthController::class, 'changePassword']);
    Route::apiResource('/comments', CommentController::class);
    Route::post('/upload', [FileUploadController::class, 'upload']);
});

//Social provider
Route::get('/auth/{provider}', [SocialController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);

//dashboard for admin
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/dashboard/update-profile', [DashboardController::class, 'updateProfile']);
    Route::post('/dashboard/change-password', [DashboardController::class, 'changePassword']);
});

//skills routes
Route::post('/users/{id}/skills', [SkillsController::class, 'addSkill'])->name('skills.add');
Route::delete('/users/{id}/skills/{skillId}', [SkillsController::class, 'removeSkill'])->name('skills.remove');
Route::get('/users/{id}/skills', [SkillsController::class, 'listSkills'])->name('skills.list');

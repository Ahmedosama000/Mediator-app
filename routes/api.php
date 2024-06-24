<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SocialController;

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
Route::get('/test', function (Request $test) {
    return "test";});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile and password management
    Route::put('/user/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/user/change-password', [AuthController::class, 'changePassword']);

    // File upload
    Route::post('/upload', [FileUploadController::class, 'upload']);

    // RESTful API routes for posts
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts', [PostController::class, 'index']);
        Route::get('/posts/{post}', [PostController::class, 'show']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::put('/posts/{post}', [PostController::class, 'update']);
        Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    });

    // Social provider
    Route::get('/auth/{provider}', [SocialController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);

    // Protected route for the Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/dashboard/update-profile', [DashboardController::class, 'updateProfile']);
    Route::post('/dashboard/change-password', [DashboardController::class, 'changePassword']);
    
    // Skills routes
    Route::post('/users/{id}/skills', [SkillsController::class, 'addSkill'])->name('skills.add');
    Route::delete('/users/{id}/skills/{skillId}', [SkillsController::class, 'removeSkill'])->name('skills.remove');
    Route::get('/users/{id}/skills', [SkillsController::class, 'listSkills'])->name('skills.list');
});

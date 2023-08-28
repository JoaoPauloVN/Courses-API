<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LearningController;
use App\Http\Controllers\Api\LessonAssetController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::get('/instructors/{instructor}', [UserController::class, 'instructor'])->name('instructor.show');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::apiResource('/courses', CourseController::class)->except(['index', 'show']);
    
    Route::group(['middleware' => 'registered'], function() {
        Route::get('/courses/{course}/learn', [CourseController::class, 'currentLesson'])->name('courses.learn');
        Route::get('/courses/{course}/learn/{lesson}', [CourseController::class, 'lesson'])->name('courses.lesson');
        Route::post('/courses/{course}/review', [CourseController::class, 'review'])->name('courses.review');
    });

    Route::get('/courses/{course}/users', [CourseController::class, 'users'])->name('courses.users');

    Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::put('/courses/{course}/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/courses/{course}/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    
    Route::post('/courses/{course}/modules/{module}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::put('/courses/{course}/modules/{module}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/courses/{course}/modules/{module}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    Route::post('/courses/{course}/modules/{module}/lessons/{lesson}/assets', [LessonAssetController::class, 'store'])->name('assets.store');
    Route::delete('/courses/{course}/modules/{module}/lessons/{lesson}/assets/{asset}', [LessonAssetController::class, 'destroy'])->name('assets.destroy');
    
    Route::apiResource('/skills', SkillController::class)->except('show');

    Route::apiResource('/categories', CategoryController::class)->except('show');

    Route::apiResource('/courses/{course}/learnings', LearningController::class)->except(['index', 'show']);

    Route::post('/courses/{course}/subscribe/{user}', [CourseController::class, 'subscribe'])->name('courses.subscribe');
    Route::post('/courses/{course}/unsubscribe/{user}', [CourseController::class, 'unsubscribe'])->name('courses.unsubscribe');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// });

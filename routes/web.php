<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/instructors', [UserController::class, 'details'])->name('instructors.details');

Route::get('/courses', [CourseController::class, 'list'])->name('courses.list');
Route::get('/courses/details', [CourseController::class, 'details'])->name('courses.details');
Route::get('/courses/store', [CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/update', [CourseController::class, 'update'])->name('courses.update');
Route::get('/courses/delete', [CourseController::class, 'destroy'])->name('courses.destroy');
Route::get('/courses/subscribe', [CourseController::class, 'subscribe'])->name('courses.subscribe');
Route::get('/courses/unsubscribe', [CourseController::class, 'unsubscribe'])->name('courses.unsubscribe');

Route::get('/learnings/store', [LearningController::class, 'store'])->name('learnings.store');
Route::get('/learnings/update', [LearningController::class, 'update'])->name('learnings.update');
Route::get('/learnings/delete', [LearningController::class, 'destroy'])->name('learnings.destroy');

Route::get('/courses/students', [CourseController::class, 'students'])->name('courses.students');

Route::get('/courses/modules', [ModuleController::class, 'list'])->name('modules.list');
Route::get('/courses/modules/store', [ModuleController::class, 'store'])->name('modules.store');
Route::get('/courses/modules/update', [ModuleController::class, 'update'])->name('modules.update');
Route::get('/courses/modules/delete', [ModuleController::class, 'destroy'])->name('modules.destroy');

Route::get('/courses/lessons', [LessonController::class, 'list'])->name('lessons.list');
Route::get('/courses/lessons/store', [LessonController::class, 'store'])->name('lessons.store');
Route::get('/courses/lessons/update', [LessonController::class, 'update'])->name('lessons.update');
Route::get('/courses/lessons/delete', [LessonController::class, 'destroy'])->name('lessons.destroy');

Route::get('/courses/review', [CourseController::class, 'review'])->name('courses.review');

Route::get('/skills', [SkillController::class, 'list'])->name('skills.list');
Route::get('/skills/store', [SkillController::class, 'store'])->name('skills.store');
Route::get('/skills/update', [SkillController::class, 'update'])->name('skills.update');
Route::get('/skills/delete', [SkillController::class, 'destroy'])->name('skills.destroy');

Route::get('/categories', [CategoryController::class, 'list'])->name('categories.list');
Route::get('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/update', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;

Route::post('/', [AuthController::class, 'login']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::resource('categories', CategoryController::class);
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::resource('categories', CategoryController::class)->except(['show', 'edit']);

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');


Route::get('/dashboard', function () {
    return redirect('/questions');
})->middleware(['auth', 'verified']);


Route::resource('questions', QuestionController::class);
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');


Route::post('/answers', [AnswerController::class, 'store'])->name('answers.store');
Route::post('/answers/{question}', [AnswerController::class, 'store']);
Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy')->middleware('auth');

Route::get('/categories/{category}', [QuestionController::class, 'filterByCategory'])->name('categories.filter');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', fn() => 'Halaman Admin');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
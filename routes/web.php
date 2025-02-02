<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

Route::resource('projects', ProjectController::class);
Route::get('/api/project/{id}', [ProjectController::class, 'getProjectData']);


Route::post('/contact', [ContactController::class, 'store'])->name('mail');


Route::middleware(['single.user.auth'])->group(function () {
    Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::get('/bentoCreator', [ProjectController::class, 'create'])->name('bento.projects.create');
    Route::post('/createBento', [ProjectController::class, 'store'])->name('bento.projects.store');
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills/{skill}/update', [SkillController::class, 'update'])->name('skills.update');
    Route::put('/icons/{icon}', [SkillController::class, 'updateIcon'])->name('icons.update');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
